<?php
if (!defined('ABSPATH')) {die;} // Cannot access directly.
/**
 * RiPro是一个优秀的主题，首页拖拽布局，高级筛选，自带会员生态系统，超全支付接口，你喜欢的样子我都有！
 * 正版唯一购买地址，全自动授权下载使用：https://vip.ylit.cc/
 * 作者唯一QQ：200933220 （油条）
 * 承蒙您对本主题的喜爱，我们愿向小三一样，做大哥的女人，做大哥网站中最想日的一个。
 * 能理解使用盗版的人，但是不能接受传播盗版，本身主题没几个钱，主题自有支付体系和会员体系，盗版风险太高，鬼知道那些人乱动什么代码，无利不起早。
 * 开发者不易，感谢支持，更好的更用心的等你来调教
 */

/**
 * 下载地址加密flush shangche
 *
 */
header("Content-type:text/html;character=utf-8");
global $current_user;

$post_id = !empty($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
$ref = !empty($_GET['ref']) ? (int)$_GET['ref'] : 0;

if (!$post_id && !$ref) {
    cao_wp_die('URL参数错误','地址错误或者URL参数错误');
}

// 开始下载处理
if (isset($post_id) && empty($ref)):
    $uid = $current_user->ID;
    $RiProPayAuth = new RiProPayAuth($uid,$post_id);

    
    // 判断是否有权限下载
    $CaoUser = new CaoUser($uid);
    $PostPay = new PostPay($uid, $post_id);
    $_downurl     = get_post_meta($post_id, 'cao_downurl', true);
    $home_url=esc_url(home_url());
    // 本地文件做处理
    if(strpos($_downurl,$home_url) !== false){ 
    	$parse_url = parse_url($_downurl);
    	$_downurl  =$parse_url['path'];
	}

    $cao_is_post_free = $RiProPayAuth->cao_is_post_free();
    if (!is_user_logged_in() && !_cao('is_ripro_nologin_pay','1')) {
        cao_wp_die('请登录下载','请登录后下载资源包');
    }
    if ($cao_is_post_free && !is_user_logged_in()) {
        if(!_cao('is_ripro_free_no_login')){
            cao_wp_die('请登录下载','免费资源请登录后进行下载');
        }else{
            $old_down = get_post_meta($post_id, 'cao_paynum', true);
            update_post_meta($post_id, 'cao_paynum', (int) $old_down + 1);
			$flush = _download_file($_downurl);
            exit();            
        }
    }
    $has_bought=$PostPay->isPayPost();
    if($has_bought){
            $before_paynum = get_post_meta($post_id, 'cao_paynum', true);
            update_post_meta($post_id, 'cao_paynum', (int) $before_paynum + 1);
            $PostPay->add_down_log();
			$flush = _download_file($_downurl);
            exit();
		}
    if ($cao_is_post_free) {
		
		date_default_timezone_set('Asia/Shanghai');
		$now=time();
		$tmp=get_user_meta($uid,'last_down_time',true);
		if(empty($tmp))  
		    $tmp=$now;
		$last=intval(get_user_meta($uid,'last_down_time',true));
		$diff=$now-$last;

		$inteval=intval(get_user_meta($uid,'cao_download_interval',true));
			
		if($diff<$inteval*60&& $diff != 0){
				cao_wp_die('连续两次下载间隔限制：'.$inteval.'分钟','上次下载时间：'.date("Y-m-d H:i",$last).',距离下一次下载剩余时间：'.(($last+$inteval*60-$now)/60).'分钟。');exit();
		}else{
				//cao_wp_die('连续两次下载间隔限制：'.$inteval.'分钟','上次下载时间：'.date("Y-m-d",$last).',距离下一次下载剩余时间：'.(($last+$inteval*60-$now)/60).'分钟。');exit();
		}
        
        if(!HasRightToDown($uid,$post_id))
        {
            //cao_wp_die('非法下载','您没有购买此资源或下载权限错误');
            $flush = _download_file("https://pan.baidu.com/s/14m3DwHn2D6LlmTjZaTyAPA?pwd=w2hz");
            exit();
        }		
		
        // 判断会员类型 判断下载次数
        $vip_status = $CaoUser->vip_status();
        $this_vip_downum = $CaoUser->cao_vip_downum($uid,$vip_status);
        // var_dump($this_vip_downum);die;
        if ($this_vip_downum['is_down'] || $PostPay->isPayPost() ) {
            if (_cao('is_all_down_num','0') && !$this_vip_downum['is_down']) {
                cao_wp_die('下载次数超出限制','今日下载次数已用：'.$this_vip_downum['today_down_num'].'次,剩余下载次数：'.$this_vip_downum['over_down_num']);exit();
            }
            
            $is_black_user=get_user_meta($uid,'cao_black_vip',true);
            if(empty($is_black_user)) $is_black_user='0';
            
            $wait_days=intval(get_post_meta($post_id,'cao_vip_day',true));

            $current_time=time();
            $post_time=strtotime(get_the_time('c',$post_id));
            $dead_time=$wait_days * 86400+$post_time;
            if($is_black_user != '0')//黑名单用户
            {
               if($current_time < $dead_time){
            	    cao_wp_die('该新上资源VIP免费下载需要等待 '.$wait_days.' 天后才能下载，还剩：'.($dead_time-$current_time)/3600 . '小时');exit();
            	    //cao_wp_die('新上资源免费下载需要等待：'.$current_time.'天后才能下载，还剩：'.$post_time. '小时'.$dead_time.'ss');exit();
                }
            }
            
            $is_add_down_log = false;
            //没有真实购买 但是使用免费权限下载 将计算下载次数
            
            $wait_days=get_post_meta($post_id,'cao_vip_day',true);
            if (!$has_bought && $cao_is_post_free) {
                update_user_meta($uid,'cao_vip_downum', $this_vip_downum['today_down_num'] + 1); //更新+1
                $is_add_down_log = $PostPay->add_down_log();
                // 更新完成 更新资源销售数量 输出成功信息
                $before_paynum = get_post_meta($post_id, 'cao_paynum', true);
                update_post_meta($post_id, 'cao_paynum', (int) $before_paynum + 1);
                update_user_meta($uid,'last_down_time',$now);
            }
            if (_cao('is_all_down_num','0') && !$is_add_down_log) {
                $PostPay->add_down_log();
            }
            # // 开始下载缓冲...
            //file_put_contents("12334.log",$is_black_user);
            if($is_black_user != "0")//黑名单用户
            {
               $black_vip_use_backup=get_post_meta($post_id,'black_vip_use_backup',true);
               if($black_vip_use_backup){
                   $_downurl=get_post_meta($post_id,'cao_downurl_bak',true);
               }
            }
            $flush = _download_file($_downurl);
            exit();
        } else {
            cao_wp_die('下载次数超出限制','今日下载次数已用：'.$this_vip_downum['today_down_num'].'次,剩余下载次数：'.$this_vip_downum['over_down_num']);
            exit;
        }
    	
    }else{
    	cao_wp_die('非法下载','您没有购买此资源或下载权限错误');
    }
endif;

// 开始推广地址处理
if (isset($ref) && empty($post_id)):
    if (!session_id()) session_start();
    $from_user_id = $ref;
    // empty($_SESSION['WPAY_code_captcha']);
    $_SESSION['cao_from_user_id'] = $from_user_id;
    header("Location:" . home_url());
    exit();
endif;
// 结束推广地址处理


cao_wp_die('地址错误或者URL参数错误','地址错误或者URL参数错误');
