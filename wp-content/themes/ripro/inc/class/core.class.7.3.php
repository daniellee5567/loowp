<?php

//www.qcma.top 破解去后门

add_action("wp_ajax_ripro_ajax_check", "ripro_ajax_check");
add_action("wp_ajax_nopriv_ripro_ajax_check", "ripro_ajax_check");
class setupDb 
{

	public function setupCoupon() 
	{
		global $wpdb;
		global $coupon_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $coupon_table_name . "'") != $coupon_table_name) 
		{
			$sql = " CREATE TABLE `" . $coupon_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `code` varchar(32) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '优惠码',\r\n                  `code_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0 无 1 直减 2折扣',\r\n                  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',\r\n                  `end_time` int(11) DEFAULT '0' COMMENT '到期时间',\r\n                  `apply_time` int(11) DEFAULT '0' COMMENT '使用时间',\r\n                  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态：0未使用 1已使用',\r\n                  `sale_money` double(10,2) DEFAULT '0.00' COMMENT '优惠金额',\r\n                  `sale_float` float(2,1) DEFAULT '0.0' COMMENT '折扣',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `code_index` (`code`) COMMENT '优惠码索引'\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='优惠券';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupRefLog() 
	{
		global $wpdb;
		global $ref_log_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $ref_log_table_name . "'") != $ref_log_table_name) 
		{
			$sql = " CREATE TABLE `" . $ref_log_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `money` double(10,2) DEFAULT NULL COMMENT '提现金额',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '申请时间',\r\n                  `up_time` int(11) DEFAULT '0' COMMENT '审核时间',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 审核中；1已打款；-1失效',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n                  PRIMARY KEY (`id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='提现记录表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}	
	
	public function setupBalanceLog() 
	{
		global $wpdb;
		global $balance_log_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $balance_log_table_name . "'") != $balance_log_table_name) 
		{
			$sql = " CREATE TABLE `" . $balance_log_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `old` double(10,2) DEFAULT NULL COMMENT '原始余额',\r\n                  `apply` double(10,2) DEFAULT NULL COMMENT '操作金额',\r\n                  `new` double(10,2) DEFAULT NULL COMMENT '新余额',\r\n                  `type` enum('charge','post','cdk','other') NOT NULL DEFAULT 'charge' COMMENT '类型：充值 资源 卡密 其他',\r\n                  `time` int(11) DEFAULT '0' COMMENT '操作时间',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n                  PRIMARY KEY (`id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='消费记录表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupPaylog() 
	{
		global $wpdb;
		global $paylog_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $paylog_table_name . "'") != $paylog_table_name) 
		{
			$sql = " CREATE TABLE `" . $paylog_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `post_id` int(11) DEFAULT NULL COMMENT '关联文章ID',\r\n                  `vip_id` int(11) DEFAULT NULL COMMENT '购买VIP类型',\r\n                  `order_trade_no` varchar(50) DEFAULT NULL COMMENT '本地订单号',\r\n                  `order_price` double(10,2) DEFAULT NULL COMMENT '文章价格',\r\n                  `order_amount` double(10,2) DEFAULT NULL COMMENT '实际扣除金额',\r\n                  `order_type` enum('post','other') NOT NULL DEFAULT 'post' COMMENT '文章资源 其他',\r\n                  `order_sale` float(2,1) DEFAULT '0.0' COMMENT 'VIP折扣',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',\r\n                  `pay_type` tinyint(3) DEFAULT '0' COMMENT '支付类型；0无；1余额；2其他',\r\n                  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 无；1已购买；-1失效',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `post_id_index` (`post_id`),\r\n                  KEY `user_id_index` (`user_id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='文章资源购买表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupDownlog()
	{
		global $wpdb;
		global $down_log_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $down_log_table_name . "'") != $down_log_table_name) 
		{
			$sql = " CREATE TABLE `" . $down_log_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `down_id` int(11) DEFAULT NULL COMMENT '下载文章ID',\r\n                  `ip` varchar(255) DEFAULT NULL COMMENT 'IP地址',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n               `create_time` int(11) DEFAULT '0' COMMENT '下载时间',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `user_id_index` (`user_id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='下载记录日志';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}		
	}
	
	public function install() 
	{
		$this->setupOrder();
		$this->setupCoupon();
		$this->setupPaylog();
		$this->setupBalanceLog();
		$this->setupRefLog();
		$this->setupDownlog();
	}
	public function setupOrder() 
	{
		global $wpdb;
		global $order_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $order_table_name . "'") != $order_table_name) 
		{
			$sql = " CREATE TABLE `" . $order_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `order_trade_no` varchar(50) DEFAULT NULL COMMENT '本地订单号',\r\n                  `order_price` double(10,2) DEFAULT NULL COMMENT '订单价格',\r\n                  `order_type` enum('charge','other') NOT NULL DEFAULT 'charge' COMMENT '充值 其他',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',\r\n                  `pay_type` tinyint(3) DEFAULT '0' COMMENT '支付类型；0无；1支付宝；2微信',\r\n                  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',\r\n                  `pay_trade_no` varchar(50) DEFAULT NULL COMMENT '商户订单号',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 未支付；1已支付；-1失效',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `order_trade_no_index` (`order_trade_no`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='在线充值订单表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}	
}

if (!wp_next_scheduled('loowp_daily_function_hook')) {
	$gt  = getTime();
    wp_schedule_event( $gt['end'], 'daily', 'loowp_daily_function_hook' );
}

add_action( 'loowp_daily_function_hook', 'loowp_daily_function');
function loowp_daily_function() {
    CleanDownNum();
}

function CleanDownNum()
{
	global $wpdb;
	global $table_prefix;
	
	$table=$table_prefix . 'usermeta';
	$sql = ' UPDATE `' . $table . '` SET `meta_value` = 0 WHERE `meta_key` = \'cao_vip_downum\'';
	
	$wpdb->query($sql);
}

if (!wp_next_scheduled('loowp_hourly_function_hook')) {	
    wp_schedule_event(time(), 'hourly', 'loowp_hourly_function_hook' );
}

add_action( 'loowp_hourly_function_hook', 'loowp_hourly_function');
function loowp_hourly_function() {
    //CleanOrders();
}
function CleanOrders()
{
	global $wpdb;
	global $paylog_table_name;
	global $order_table_name;
	
	date_default_timezone_set('Asia/Shanghai');
	$now=time();
	
	$minutes=60;
	
	$timeago=$now-$minutes * 60;
	
	$sql='DELETE FROM '.$paylog_table_name.' WHERE status = 0 and create_time < '.$timeago;
	
	$wpdb->query($sql);
	
	$sql='DELETE FROM '.$order_table_name.' WHERE status = 0 and create_time < '.$timeago;
	
	$wpdb->query($sql);
}

class ShopOrder 
{
	public function __construct() 
	{
	}
	public function get($out_trade_no) 
	{
		global $wpdb;
		global $order_table_name;
		$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $order_table_name . " WHERE order_trade_no = %s AND status = 0", $out_trade_no));
		return $data;
	}
	public function add($user_id, $trade_no, $type, $price, $payMethod) 
	{
		global $wpdb;
		global $order_table_name;
		$params = array("user_id" => $user_id, "order_trade_no" => $trade_no, "order_type" => $type, "order_price" => $price, "create_time" => time(), "pay_type" => $payMethod);
		$insert = $wpdb->insert($order_table_name, $params, array("%d", "%s", "%s", "%s", "%s", "%d"));
		return $insert ? true : false;
	}
	public function check($orderNum) 
	{
		global $wpdb;
		global $order_table_name;
		$isPay = 0;
		if (isset($orderNum)) 
		{
			$isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $order_table_name . " WHERE order_trade_no = %s AND status = 1 ", $orderNum));
			return $isPay && (0 < $isPay);
		}
		return $isPay && (0 < $isPay);
	}		
	public function update($orderNum, $payNum) 
	{
		global $wpdb;
		global $order_table_name;
		$time = time();
		$update = $wpdb->update($order_table_name, array("pay_trade_no" => $payNum, "pay_time" => $time, "status" => 1), array("order_trade_no" => $orderNum), array("%s", "%s", "%d"), array("%s"));
		return $update ? true : false;
	}
}

class CaoCdk 
{
	
	public function checkCdk($code) 
	{
		global $wpdb;
		global $coupon_table_name;
		$sale_money = 0;
		if (isset($code)) 
		{
			$coupon = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $coupon_table_name . " WHERE code = %s ", $code));
			if ($coupon && ($coupon->status == 0) && (time() < ($coupon->end_time)) && ($coupon->apply_time == 0)) 
			{
				return $coupon->sale_money;
			}
		}
		return $sale_money;
	}
public function str_code_rand($length = 12, $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") 
	{
		if (!is_int($length) || ($length < 0)) 
		{
			return false;
		}
		$string = "";
		$i = $length;
		while (0 < $i) 
		{
			$string .= ($char[mt_rand(0, strlen($char) - 1)]);
			$i--;
		}
		return $string;
	}	
	public function updataCdk($code) 
	{
		global $wpdb;
		global $coupon_table_name;
		$update = $wpdb->update($coupon_table_name, array("apply_time" => time(), "status" => 1), array("code" => $code), array("%s", "%d"), array("%s"));
		return $update ? true : false;
	}
	public function addCdk($sale_money, $day, $num) 
	{
		global $wpdb;
		global $coupon_table_name;
		$i = 0;
		$file="cdk_dump_";
		while ($i < $num) 
		{
			$create_time = time();
			$end_time = $create_time + ($day * 24 * 60 * 60);
			$params = array("code" => $this->str_code_rand($length = 12), "code_type" => 1, "create_time" => $create_time, "end_time" => $end_time, "apply_time" => 0, "status" => 0, "sale_money" => sprintf("%0.2f", $sale_money), "sale_float" => 1);
			$insCoupon = $wpdb->insert($coupon_table_name, $params, array("%s", "%d", "%s", "%s", "%s", "%s", "%s", "%s"));
			$i++;
			file_put_contents($file.$sale_money.'.log',$params['code']."\n",FILE_APPEND);
		}
		return $i ? true : false;
	}	
	
}
class CaoUser 
{
	private $uid;
	public function __construct($uid) 
	{
		$this->uid = $uid;
	}
	public function cao_vip_downum($users_id = '',$users_type = false)
	{
		global $current_user;
		if (!is_user_logged_in()) {
			return 0;
		}
		$uid = (!$users_id) ? $current_user->ID : $users_id;	

		$total_count=0;
		
		
		// 会员当前下载次数
		$this_vip_downum = (get_user_meta($uid, 'cao_vip_downum', true) > 0) ? get_user_meta($uid, 'cao_vip_downum', true) : 0;		
		
		$getTime  = getTime();

		if ($users_type) {
			if (is_boosvip_status($uid)) {
				$total_count=intval(_cao('boosvip_down_num','100'));
				$over_down_num = (_cao('is_boosvip_down_num')) ? $total_count - intval($this_vip_downum) : 999 ;
			}else{
				$total_count=intval(_cao('vip_down_num','10'));
				$over_down_num = (_cao('is_vip_down_num')) ? $total_count - intval($this_vip_downum) : 999 ;
			}
		} else{
			$total_count=intval(_cao('novip_down_num','5'));
			$over_down_num = (_cao('is_novip_down_num')) ? $total_count - intval($this_vip_downum) : 999 ;
		}
		if ($over_down_num <= 0) {
			$over_down_num = 0;
		}
		$is_down = ($over_down_num <= 0) ? false : true;
		$data = array(
			'is_down'           => $is_down, //是否可以下载
			'today_count_num'	=> $total_count,
			'today_down_num'    => $this_vip_downum, //当前已下载次数
			'over_down_num'     => $over_down_num, //剩余下载次数
			'over_down_endtime' => $getTime['end'], // 下次下载次数更新时间
		);

		return $data;
	}
	
	public function vip_end_time() 
	{
		$end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
		if ($end_date) 
		{
			switch ($end_date) 
			{
				case "9999-09-09": return "终身";
				break;
				default: $time = strtotime($end_date);
				return date("Y-m-d", $time);
				break;
			}
		}
		return "未开通";
	}
	public function user_status() 
	{
		$ban = get_user_meta($this->uid, "cao_banned", true);
		if ($ban) 
		{
			$reason = get_user_meta($this->uid, "cao_banned_reason", true);
			return array("banned" => true, "banned_reason" => strval($reason));
		}
		return array("banned" => false);
	}
	public function update_vip_pay($days) 
	{
		if (empty($days) && ($days < 0)) 
		{
			return false;
		}
		$days = (int) $days;
		$vip_end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
		$the_time = time();
		$end_time = strtotime($vip_end_date);
		if ($the_time < $end_time) 
		{
			$new_end_time = $end_time + ($days * 24 * 3600);
		}
		else 
		{
			$new_end_time = $the_time + ($days * 24 * 3600);
		}
		$new_user_type = "vip";
		if ($days == 9999) 
		{
			$nwe_end_data = "9999-09-09";
		}
		else 
		{
			$nwe_end_data = date("Y-m-d", $new_end_time);
		}
		update_user_meta($this->uid, "cao_vip_end_time", $nwe_end_data);
		update_user_meta($this->uid, "cao_user_type", $new_user_type);
		return true;
	}
	public function vip_status() 
	{
		$vip_type = get_user_meta($this->uid, "cao_user_type", true);
		$vip_end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
		$this_time = time();
		$end_time = strtotime($vip_end_date);
		if (($vip_type == "vip") && ($vip_end_date == ("9999-09-09"))) 
		{
			return true;
		}
		if (($vip_type == "vip") && ($this_time < $end_time)) 
		{
			return true;
		}
		return false;
	}
	
	public function vip_name() 
	{
		$site_no_vip_name = _cao("site_no_vip_name");
		$site_vip_name = _cao("site_vip_name");
		$vip_type = get_user_meta($this->uid, "cao_user_type", true);
		if ($vip_type && ($vip_type == "vip")) 
		{
			return $site_vip_name;
		}
		return $site_no_vip_name;
	}
	public function get_balance() 
	{
		return sprintf("%0.2f", get_user_meta($this->uid, "cao_balance", true));
	}
	public function get_consumed_balance() 
	{
		return sprintf("%0.2f", get_user_meta($this->uid, "cao_consumed_balance", true));
	}
	public function update_balance($amount = 0) 
	{
		$before_balances = $this->get_balance();
		if (0 < $amount) 
		{
			update_user_meta($this->uid, "cao_balance", sprintf("%0.2f", $before_balances + $amount));
		}
		else 
		{
			if ($amount < 0) 
			{
				if (($before_balances + $amount) < 0) 
				{
					return false;
				}
				$before_consumed = get_user_meta($this->uid, "cao_consumed_balance", true);
				update_user_meta($this->uid, "cao_consumed_balance", sprintf("%0.2f", $before_consumed - $amount));
				update_user_meta($this->uid, "cao_balance", sprintf("%0.2f", $before_balances + $amount));
			}
		}
		return true;
	}
}
class Caolog 
{
	public function addlog($user_id, $old, $apply, $new, $type, $note) 
	{
		global $wpdb;
		global $balance_log_table_name;
		$create_time = time();
		$params = array("user_id" => $user_id, "old" => $old, "apply" => $apply, "new" => $new, "type" => $type, "time" => $create_time, "note" => $note);
		$ins = $wpdb->insert($balance_log_table_name, $params, array("%d", "%s", "%s", "%s", "%s", "%s", "%s"));
		return $ins ? true : false;
	}
}
class Reflog 
{
	private $uid;
	public function __construct($uid) 
	{
		$this->uid = $uid;
	}
	public function updatelog($id, $status = 0) 
	{
		global $wpdb;
		global $ref_log_table_name;
		$this_log = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $ref_log_table_name . " WHERE id = %d ", $id));
		if (!$this_log) 
		{
			return false;
		}
		$update = $wpdb->update($ref_log_table_name, array("up_time" => time(), "status" => $status), array("id" => $id), array("%s", "%d"), array("%d"));
		return $update ? true : false;
	}
	public function get_total_bonus() 
	{
		return sprintf("%0.2f", get_user_meta($this->uid, "cao_total_bonus", true));
	}
	public function addlog($money, $note) 
	{
		global $wpdb;
		global $ref_log_table_name;
		$money = (int) $money;
		$create_time = time();
		$params = array("user_id" => $this->uid, "money" => $money, "create_time" => $create_time, "note" => $note);
		$ins = $wpdb->insert($ref_log_table_name, $params, array("%d", "%s", "%s", "%s"));
		return $ins ? true : false;
	}
	
	public function get_ref_num() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$ref_num = $wpdb->get_var($wpdb->prepare("SELECT COUNT(user_id) FROM " . $wpdb->usermeta . " WHERE meta_key=%s AND meta_value=%s", "cao_ref_from", $this->uid));
		return $_num = ($ref_num ? (int) $ref_num : 0);
	}
	
	public function get_ke_bonus() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$get_total_bonus = $this->get_total_bonus();
		$get_ing_bonus = $this->get_ing_bonus();
		$get_yi_bonus = $this->get_yi_bonus();
		return sprintf("%0.2f", $get_total_bonus - $get_ing_bonus - $get_yi_bonus);
	}
	public function get_yi_bonus() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$sqls = $wpdb->get_var($wpdb->prepare("SELECT SUM(money) FROM " . $ref_log_table_name . " WHERE user_id=%d AND status=1", $this->uid));
		return sprintf("%0.2f", $sqls);
	}
	public function get_ing_bonus() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$sqls = $wpdb->get_var($wpdb->prepare("SELECT SUM(money) FROM " . $ref_log_table_name . " WHERE user_id=%d AND status=0", $this->uid));
		return sprintf("%0.2f", $sqls);
	}
	
	public function add_total_bonus($amount) 
	{
		$amount = sprintf("%0.2f", $amount);
		$get_total_bonus = $this->get_total_bonus();
		if (0 < $amount) 
		{
			update_user_meta($this->uid, "cao_total_bonus", sprintf("%0.2f", $get_total_bonus + $amount));
		}
		else 
		{
			return false;
		}
		return true;
	}
	public function get_down_total()
	{
		global $wpdb;
		global $down_log_table_name;		
		
		$a8ku_shabi_jiangou = "SELECT count(id) FROM " . $down_log_table_name . " WHERE 1=1 ";
		
		return $wpdb->get_var($a8ku_shabi_jiangou);
	}
	
	public function get_down_log($params)
	{
		global $wpdb;
		global $down_log_table_name;
		
		$offset=($params['paged']-1)*$params['perpage'];
		
		$a8ku_shabi_jiangou = "SELECT * FROM " . $down_log_table_name . " WHERE 1=1 ";
		if($params['user_id'] != '0' && $params['user_id'] !=''){
			$a8ku_shabi_jiangou .= "AND user_id='" . $params['user_id'] . "' ";
		}		
		$a8ku_shabi_jiangou .= "ORDER BY create_time DESC ";
		$a8ku_shabi_jiangou .= "limit " . $offset . "," . $params['perpage'];
		
		$results = $wpdb->get_results($a8ku_shabi_jiangou, "OBJECT");
		if (!$results) 
		{
			return null;
		}
		
		return $results;		
	}
    	public function get_downlog_by_postid($params)
    {
    		global $wpdb;
    		global $down_log_table_name;
    		
    		$offset=($params['paged']-1)*$params['perpage'];
    		
    		$a8ku_shabi_jiangou = "SELECT * FROM " . $down_log_table_name . " WHERE 1=1 ";
    		
    		$a8ku_shabi_jiangou .= "AND down_id='" . $params['down_id'] . "' ";
    				
    		$a8ku_shabi_jiangou .= "ORDER BY create_time DESC ";
    		$a8ku_shabi_jiangou .= "limit " . $offset . "," . $params['perpage'];
    		
    		$results = $wpdb->get_results($a8ku_shabi_jiangou, "OBJECT");
    		if (!$results) 
    		{
    			return null;
    		}
    		
    		return $results;		
    }
}
class PostPay 
{
	public $user_id;
	public $post_id;
	public function __construct($user_id, $post_id) 
	{
		$this->user_id = $user_id;
		$this->post_id = $post_id;
	}
	public function add($price, $sale,$order_trade_no,$pay_type,$vip_id) 
	{
		global $wpdb;
		global $paylog_table_name;
		//$out_trade_no = date("ymdhis") . mt_rand(100, 999) . mt_rand(100, 999) . mt_rand(100, 999);
		if ($sale == 0) 
		{
			$amount = 0;
		}
		else if ($sale == 1) 
		{
			$amount = $price;
		}
		else 
		{
			if ((0 < $sale) && ($sale < 1)) 
			{
				$amount = sprintf("%0.2f", $price * $sale);
			}
			else 
			{
				$amount = $price;
			}
		}
		$params = array("user_id" => $this->user_id, "post_id" => $this->post_id,"vip_id" => $vip_id, "order_trade_no" => $order_trade_no, "order_price" => $price, "order_amount" => $amount, "order_type" => "post", "order_sale" => $sale, "create_time" => time(), "pay_type" => $pay_type);
		$insert = $wpdb->insert($paylog_table_name, $params, array("%d", "%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%d"));
		if ($insert) 
		{
			return $params;
		}
		else 
		{
			return false;
		}
	}
	public function a8ku_shabi_jiangou()
	{
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
	}
	public function add_down_log()
	{
		date_default_timezone_set('Asia/Shanghai');
		global $wpdb;
		global $down_log_table_name;
		try{
			$wpdb->insert($down_log_table_name, array("user_id"=>$this->user_id,"down_id"=>$this->post_id,"ip"=>$this->a8ku_shabi_jiangou(),"create_time"=>time()));
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	public function update($orderNum) 
	{
		global $wpdb;
		global $paylog_table_name;
		$time = time();
		$update = $wpdb->update($paylog_table_name, array("pay_time" => $time, "status" => 1), array("order_trade_no" => $orderNum), array("%s", "%d"), array("%s"));
		return $update ? true : false;
	}

	public function isPayPost() 
	{
		global $wpdb;
		global $paylog_table_name;
		
		$isPay = false;
		
		if($this->user_id == 0){
			/*免登录支付  0*/
			if(isset($_COOKIE['RiProPay_'.$this->post_id])){
				$this_key_id = $this->get_key($_COOKIE['RiProPay_' . $this->post_id]);
				$isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $paylog_table_name . " WHERE post_id = %d AND status = 1 AND order_trade_no = %s", $this->post_id,$this_key_id));
				$isPay = intval($isPay);
			}
		}else{
			$user = new CaoUser($this->user_id);
			if($user->vip_status()){
				//vip会员
				$isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $paylog_table_name . " WHERE user_id = %d AND post_id = %d AND status = 1 ", $this->user_id, $this->post_id));				
			}else{
				$paytime = time()-600*24*60*60;//30 day后重新购买
				$isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $paylog_table_name . " WHERE pay_time > %d AND user_id = %d AND post_id = %d AND status = 1 ",$paytime,$this->user_id, $this->post_id));
			}
			$isPay = $isPay ? true:false;
		}		
		return $isPay>0;
	}
	public function get_pay_info($order_trade_no) 
	{
		global $wpdb;
		global $paylog_table_name;
		
		$info = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $paylog_table_name . " WHERE order_trade_no = %s", $order_trade_no));
		return $info;
		
	}
	public function get_pay_ids($user_id) 
	{
		global $wpdb;
		global $paylog_table_name;
		$sql = "SELECT post_id FROM " . $paylog_table_name . " WHERE 1=1 ";
		$sql .= ("AND user_id='" . $user_id . "' AND status =1 ");
		$sql .= "ORDER BY id DESC";
		$results = $wpdb->get_results($sql, "ARRAY_A");
		$_post_id = array();
		foreach ($results as $item ) 
		{
			array_push($_post_id, $item["post_id"]);
		}
		return $_post_id;
	}
	/**
	 * [set_key 生成key]
	 * @Author   Dadong2g
	 * @DateTime 2019-05-28T13:26:54+0800
	 * @param    [type]                   $setkey [description]
	 */
	public function set_key($setkey)
	{
		return base64_encode($setkey . md5(_cao('ripro_nologin_payKey')));
	}	
	/**
	 * [get_key 获取后台设置的关键词key识别码]
	 * @Author   Dadong2g
	 * @DateTime 2019-05-28T13:26:44+0800
	 * @param    [type]                   $getkey [description]
	 * @return   [type]                           [description]
	 */
	public function get_key($getkey)
	{
		return str_replace(md5(_cao('ripro_nologin_payKey')), '', base64_decode($getkey));
	}

}
class RiProPayAuth
{
	public $uid;
	public $pid;
	
	public function __construct($user_id,$post_id) 
	{
		$this->uid=$user_id;
		$this->pid=$post_id;
	}

	public function cao_is_post_free()
	{
		$CaoUser = new CaoUser($this->uid);
		$cao_price = get_post_meta($this->pid, 'cao_price', true);
		$cao_vip_rate = get_post_meta($this->pid, 'cao_vip_rate', true);
		$cao_is_boosvip = get_post_meta($this->pid, 'cao_is_boosvip', true);

		//是免费资源
		if ($cao_price == '0') {
			return true;
		}

		// 是常规会员
		if ($CaoUser->vip_status() && ($cao_price*$cao_vip_rate==0) ) {
			return true;
		}
		
		//是永久会员	
		
		if ($cao_is_boosvip && is_boosvip_status($this->uid)) {
			return true;
		}

		return false;
	}	
	
	public function ThePayAuthStatus()
	{
		$status=0;
		
		$cao_is_post_free=$this->cao_is_post_free();
		$PostPay = new PostPay($this->uid, $this->pid);
		
		if(_cao('is_ripro_free_no_login')&&$cao_is_post_free){
		    $status=12;
		}else if (_cao('is_ripro_nologin_pay','1') && !is_user_logged_in()) {
			if($cao_is_post_free){
				$status=12;
			}else if($PostPay->isPayPost()){
				$status=11;
			}else{
				$status=13;
			}
		}else if(is_user_logged_in()){
			if($PostPay->isPayPost()|| $cao_is_post_free) 
			{ 
				$status=21;
			}else{
				$status=22;
			}	
		}else{
			$status=31;
		}
		
		return $status;
	}
}

/*class CaoCache
{
	public function __construct() 
	{
	}
	
	static public function is()
	{
		return false;
	}
	
	static public function get($_the_cache_key)
	{
		return false;
	}
	static public function set($_the_cache_key,$value)
	{
		return true;
	}	
}

*/
class CaoCache {
	
	/**
	 * 缓存配置
	 */
	private static $config = [
		'default_expire' => 3600,        // 默认过期时间（秒）
		'max_memory' => 67108864,        // 最大内存使用（64MB）
		'compression' => true,           // 是否启用压缩
		'log_errors' => true,            // 是否记录错误日志
		'fallback' => 'file',            // 备用缓存方式：file, database, memory
	];
	
	/**
	 * 缓存统计信息
	 */
	private static $stats = [
		'hits' => 0,                     // 缓存命中次数
		'misses' => 0,                   // 缓存未命中次数
		'sets' => 0,                     // 设置缓存次数
		'deletes' => 0,                  // 删除缓存次数
		'errors' => 0,                   // 错误次数
	];
	
	/**
	 * 缓存前缀
	 */
	private static $prefix = 'cao_cache_';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		// 初始化缓存配置
		$this->initConfig();
	}
	
	/**
	 * 初始化配置
	 */
	private function initConfig() {
		// 从主题配置中读取缓存设置
		$cache_config = _cao('cache_config', []);
		if (!empty($cache_config)) {
			self::$config = array_merge(self::$config, $cache_config);
		}
		
		// 设置缓存前缀
		$site_prefix = _cao('cache_prefix', '');
		if ($site_prefix) {
			self::$prefix = $site_prefix . '_';
		}
	}
	
	/**
	 * 检查是否启用缓存
	 * @return bool
	 */
	public static function is() {
		try {
			// 检查WordPress缓存是否可用
			if (!function_exists('wp_cache_get')) {
				return false;
			}
			
			// 检查主题配置
			$enabled = _cao('all_slte_ob_cache', true);
			if (!$enabled) {
				return false;
			}
			
			// 检查内存使用情况
			if (self::isMemoryLimitReached()) {
				return false;
			}
			
			return true;
		} catch (Exception $e) {
			self::logError('Cache check failed: ' . $e->getMessage());
			return false;
		}
	}
	
	/**
	 * 从缓存中获取数据
	 * @param string $key 缓存键名
	 * @param mixed $default 默认值
	 * @return mixed 缓存数据
	 */
	public static function get($key, $default = false) {
		if (!self::is()) {
			self::$stats['misses']++;
			return $default;
		}
		
		try {
			$full_key = self::getFullKey($key);
			$data = wp_cache_get($full_key);
			
			if ($data !== false) {
				self::$stats['hits']++;
				
				// 解压缩数据
				if (self::$config['compression'] && is_string($data)) {
					$data = self::decompress($data);
				}
				
				return $data;
			} else {
				self::$stats['misses']++;
				return $default;
			}
		} catch (Exception $e) {
			self::logError('Cache get failed for key: ' . $key . ' - ' . $e->getMessage());
			self::$stats['errors']++;
			return $default;
		}
	}
	
	/**
	 * 设置缓存数据
	 * @param string $key 缓存键名
	 * @param mixed $data 要缓存的数据
	 * @param int $expire 缓存过期时间（秒）
	 * @return bool 是否设置成功
	 */
	public static function set($key, $data, $expire = null) {
		if (!self::is()) {
			return false;
		}
		
		try {
			$full_key = self::getFullKey($key);
			
			// 使用默认过期时间
			if ($expire === null) {
				$expire = self::$config['default_expire'];
			}
			
			// 压缩数据
			if (self::$config['compression'] && is_string($data)) {
				$data = self::compress($data);
			}
			
			$result = wp_cache_set($full_key, $data, '', $expire);
			
			if ($result) {
				self::$stats['sets']++;
				
				// 记录缓存键到索引中
				self::addToIndex($key, $expire);
			}
			
			return $result;
		} catch (Exception $e) {
			self::logError('Cache set failed for key: ' . $key . ' - ' . $e->getMessage());
			self::$stats['errors']++;
			return false;
		}
	}
	
	/**
	 * 删除指定的缓存项
	 * @param string $key 缓存键名
	 * @return bool 是否删除成功
	 */
	public static function delete($key) {
		if (!self::is()) {
			return false;
		}
		
		try {
			$full_key = self::getFullKey($key);
			$result = wp_cache_delete($full_key);
			
			if ($result) {
				self::$stats['deletes']++;
				
				// 从索引中移除
				self::removeFromIndex($key);
			}
			
			return $result;
		} catch (Exception $e) {
			self::logError('Cache delete failed for key: ' . $key . ' - ' . $e->getMessage());
			self::$stats['errors']++;
			return false;
		}
	}
	
	/**
	 * 清空所有缓存
	 * @return bool 是否清空成功
	 */
	public static function flush() {
		if (!self::is()) {
			return false;
		}
		
		try {
			$result = wp_cache_flush();
			
			if ($result) {
				// 清空索引
				self::clearIndex();
				
				// 重置统计信息
				self::resetStats();
			}
			
			return $result;
		} catch (Exception $e) {
			self::logError('Cache flush failed: ' . $e->getMessage());
			self::$stats['errors']++;
			return false;
		}
	}
	
	/**
	 * 检查缓存是否存在
	 * @param string $key 缓存键名
	 * @return bool
	 */
	public static function exists($key) {
		if (!self::is()) {
			return false;
		}
		
		try {
			$full_key = self::getFullKey($key);
			return wp_cache_get($full_key) !== false;
		} catch (Exception $e) {
			self::logError('Cache exists check failed for key: ' . $key . ' - ' . $e->getMessage());
			return false;
		}
	}
	
	/**
	 * 获取缓存剩余时间
	 * @param string $key 缓存键名
	 * @return int 剩余秒数，-1表示永久，-2表示不存在
	 */
	public static function ttl($key) {
		if (!self::is()) {
			return -2;
		}
		
		try {
			$full_key = self::getFullKey($key);
			$data = wp_cache_get($full_key);
			
			if ($data === false) {
				return -2; // 不存在
			}
			
			// WordPress对象缓存不直接支持TTL查询，这里返回-1表示永久
			// 实际项目中可以通过记录时间戳来计算
			return -1;
		} catch (Exception $e) {
			self::logError('Cache TTL check failed for key: ' . $key . ' - ' . $e->getMessage());
			return -2;
		}
	}
	
	/**
	 * 递增缓存值
	 * @param string $key 缓存键名
	 * @param int $value 递增值
	 * @return int|false 新值或失败
	 */
	public static function increment($key, $value = 1) {
		if (!self::is()) {
			return false;
		}
		
		try {
			$full_key = self::getFullKey($key);
			return wp_cache_incr($full_key, $value);
		} catch (Exception $e) {
			self::logError('Cache increment failed for key: ' . $key . ' - ' . $e->getMessage());
			return false;
		}
	}
	
	/**
	 * 递减缓存值
	 * @param string $key 缓存键名
	 * @param int $value 递减值
	 * @return int|false 新值或失败
	 */
	public static function decrement($key, $value = 1) {
		if (!self::is()) {
			return false;
		}
		
		try {
			$full_key = self::getFullKey($key);
			return wp_cache_decr($full_key, $value);
		} catch (Exception $e) {
			self::logError('Cache decrement failed for key: ' . $key . ' - ' . $e->getMessage());
			return false;
		}
	}
	
	/**
	 * 批量获取缓存
	 * @param array $keys 缓存键名数组
	 * @return array 缓存数据数组
	 */
	public static function getMultiple($keys) {
		$result = [];
		
		foreach ($keys as $key) {
			$result[$key] = self::get($key);
		}
		
		return $result;
	}
	
	/**
	 * 批量设置缓存
	 * @param array $items 缓存项数组 [key => [data, expire]]
	 * @return bool 是否全部设置成功
	 */
	public static function setMultiple($items) {
		$success = true;
		
		foreach ($items as $key => $item) {
			$data = $item[0] ?? null;
			$expire = $item[1] ?? null;
			
			if (!self::set($key, $data, $expire)) {
				$success = false;
			}
		}
		
		return $success;
	}
	
	/**
	 * 批量删除缓存
	 * @param array $keys 缓存键名数组
	 * @return bool 是否全部删除成功
	 */
	public static function deleteMultiple($keys) {
		$success = true;
		
		foreach ($keys as $key) {
			if (!self::delete($key)) {
				$success = false;
			}
		}
		
		return $success;
	}
	
	/**
	 * 获取缓存统计信息
	 * @return array 统计信息
	 */
	public static function getStats() {
		return [
			'stats' => self::$stats,
			'config' => self::$config,
			'memory_usage' => memory_get_usage(true),
			'memory_limit' => ini_get('memory_limit'),
			'cache_enabled' => self::is(),
		];
	}
	
	/**
	 * 重置统计信息
	 */
	public static function resetStats() {
		self::$stats = [
			'hits' => 0,
			'misses' => 0,
			'sets' => 0,
			'deletes' => 0,
			'errors' => 0,
		];
	}
	
	/**
	 * 清理过期缓存
	 * @return int 清理的缓存项数量
	 */
	public static function gc() {
		if (!self::is()) {
			return 0;
		}
		
		try {
			$cleaned = 0;
			$index = self::getIndex();
			
			foreach ($index as $key => $expire_time) {
				if (time() > $expire_time) {
					if (self::delete($key)) {
						$cleaned++;
					}
				}
			}
			
			return $cleaned;
		} catch (Exception $e) {
			self::logError('Cache garbage collection failed: ' . $e->getMessage());
			return 0;
		}
	}
	
	/**
	 * 获取完整的缓存键名
	 * @param string $key 原始键名
	 * @return string 完整键名
	 */
	private static function getFullKey($key) {
		return self::$prefix . md5($key);
	}
	
	/**
	 * 检查内存限制
	 * @return bool
	 */
	private static function isMemoryLimitReached() {
		$memory_limit = ini_get('memory_limit');
		$memory_usage = memory_get_usage(true);
		
		if ($memory_limit == -1) {
			return false; // 无限制
		}
		
		$limit_bytes = self::parseSize($memory_limit);
		return $memory_usage > ($limit_bytes * 0.8); // 使用80%以上时禁用缓存
	}
	
	/**
	 * 解析内存大小字符串
	 * @param string $size 大小字符串（如：64M, 1G）
	 * @return int 字节数
	 */
	private static function parseSize($size) {
		$unit = strtolower(substr($size, -1));
		$value = (int)substr($size, 0, -1);
		
		switch ($unit) {
			case 'k': return $value * 1024;
			case 'm': return $value * 1024 * 1024;
			case 'g': return $value * 1024 * 1024 * 1024;
			default: return $value;
		}
	}
	
	/**
	 * 压缩数据
	 * @param string $data 原始数据
	 * @return string 压缩后的数据
	 */
	private static function compress($data) {
		if (function_exists('gzcompress')) {
			return gzcompress($data, 6);
		}
		return $data;
	}
	
	/**
	 * 解压缩数据
	 * @param string $data 压缩后的数据
	 * @return string 原始数据
	 */
	private static function decompress($data) {
		if (function_exists('gzuncompress')) {
			$decompressed = gzuncompress($data);
			return $decompressed !== false ? $decompressed : $data;
		}
		return $data;
	}
	
	/**
	 * 记录错误日志
	 * @param string $message 错误消息
	 */
	private static function logError($message) {
		if (self::$config['log_errors']) {
			error_log('[CaoCache] ' . $message);
		}
	}
	
	/**
	 * 获取缓存索引
	 * @return array 索引数组
	 */
	private static function getIndex() {
		$index_key = self::$prefix . 'index';
		$index = wp_cache_get($index_key);
		return is_array($index) ? $index : [];
	}
	
	/**
	 * 添加到索引
	 * @param string $key 缓存键名
	 * @param int $expire 过期时间
	 */
	private static function addToIndex($key, $expire) {
		$index_key = self::$prefix . 'index';
		$index = self::getIndex();
		$index[$key] = time() + $expire;
		wp_cache_set($index_key, $index, '', 0); // 永久存储索引
	}
	
	/**
	 * 从索引中移除
	 * @param string $key 缓存键名
	 */
	private static function removeFromIndex($key) {
		$index_key = self::$prefix . 'index';
		$index = self::getIndex();
		unset($index[$key]);
		wp_cache_set($index_key, $index, '', 0);
	}
	
	/**
	 * 清空索引
	 */
	private static function clearIndex() {
		$index_key = self::$prefix . 'index';
		wp_cache_delete($index_key);
	}
}

class RiProPay
{
	public function __construct() 
	{
	}
	public function _cao_get_xunhupay_js_url($pay_url){
		return $pay_url;		
	}
	public function _cao_get_xunhupay_qrcode($pay_js_url){
		return getQrcode($pay_js_url);
	}
	public function get_order_info($out_trade_no){
		//返回post_id，user_id，order_trade_no
		$postPay = new PostPay('0','0');
		$order   = $postPay->get_pay_info($out_trade_no);
		if(!$order){//找不到订单记录
			echo "no order found!out_trade_no=$out_trade_no";
			exit();
		}
		return array("user_id"=>$order->user_id,"post_id"=>$order->post_id,"order_trade_no"=>$out_trade_no);
	}
	public function send_order_trade_success($out_trade_no,$trade_no,$info){
				// 验证通过 获取基本信息
		$ShopOrder = new ShopOrder();
		$order     = $ShopOrder->get($out_trade_no);
		$obj_user = get_user_by('ID', $order->user_id);
		$CaoUser = new CaoUser($order->user_id);
		// 是否有效订单 && 订单类型为充值
		if ($order && $order->order_type == 'charge') {
			// 实例化用户信息
			
			// 计算充值数量
			$charge_rate  = (int) _cao('site_change_rate'); //充值比例
			$old_money    = $CaoUser->get_balance(); //用户原来余额
			$charge_money = sprintf('%0.2f', $order->order_price * $charge_rate); // 实际充值数量

			//更新用户余额信息
			if ($CaoUser->update_balance($charge_money)) {
				// 写入记录
				$Caolog    = new Caolog();
				$new_money = $old_money + $charge_money; //充值后金额
				$note      = '支付宝-在线充值 [￥' . $order->order_price . '] +' . $charge_money;
				$Caolog->addlog($order->user_id, $old_money, $charge_money, $new_money, 'charge', $note);
				//更新订单状态
				$ShopOrder->update($out_trade_no, $trade_no);
				//发放佣金 查找推荐人
				add_to_user_bonus($order->user_id,$charge_money);
				//发送邮件				
				_sendMail($obj_user->user_email, '充值支付成功', $note);
			}
		}
		if($order && $order->order_type == 'other'){
			//更新订单状态
			$ShopOrder->update($out_trade_no, $trade_no);
			//更新文章购买记录
			$postPay = new PostPay($order->user_id,'0');
			$paylog = $postPay->get_pay_info($out_trade_no);
			$postPay->post_id = $paylog->post_id;
			if($postPay->update($out_trade_no)){
				$this->AddPayPostCookie($uid,$paylog->post_id,$out_trade_no);
			}
			$before_paynum = get_post_meta($paylog->post_id, 'cao_paynum', true);
			update_post_meta($paylog->post_id, 'cao_paynum', (int) $before_paynum + 1);
			
			$down_url=get_post_meta($paylog->post_id, 'cao_downurl', true);
			
			if($paylog->post_id==cao_get_page_by_slug('user')){
				$this->PayVIP($CaoUser,$paylog->post_id,$paylog->vip_id,$paylog->price);
				_sendMail($obj_user->user_email, '，会员购买支付成功', $note);
			}else{
				// 发放作者佣金
				$author_id = (int)get_post($post_id)->post_author;
				if ($author_id != $order->user_id) {
					//自己购买自己不发放
					add_post_author_bonus($author_id,$order->price);
				}
				$pwd=get_post_meta($paylog->post_id, 'cao_pwd', true);
				$note = '购买文章资源 [￥' . $order->order_price . '] +' . $charge_money . ',下载地址：' . $down_url. ',提取码：' .$pwd;
				_sendMail($obj_user->user_email, '文章支付购买成功', $note);
			}
		}
	}
	private function PayVIP($CaoUser,$postid,$vid,$price)
	{
		global $current_user;
		
		$uid=$current_user->ID;
		
		// 获取后台价格设置
		$vip_pay_setting = _cao('vip-pay-setting');
		$payInfo = [];
		foreach ($vip_pay_setting as $key => $item) {
			if ($key == $vid) {
				$payInfo = $item;
				break; // 当 $value为c时，终止循环
			}     
		}
		// 计算价格 验证会员折扣权限
		$pay_price = $payInfo['price'] * -1;
		$pay_daynum = $payInfo['daynum'];
		
		$Caolog    = new Caolog();
		$note      = '购买'._cao('site_vip_name') .' '. $amount;
		$Caolog->addlog($uid, 0, $amount, 0, 'other', $note);
		$CaoUser->update_vip_pay($pay_daynum);//更新vip时间
		if ($pay_daynum == 9999) {
			$success_msg = '成功开通：终身特权！ 花费：' . $price . '元';
		}else{
			$success_msg = '成功开通：'.$pay_daynum.'天特权！ 花费：' . $price . '元';
		}
		
		//if (_cao('is_mail_nitfy_vip')) {
			_sendMail($current_user->user_email, '特权开通成功', $success_msg);
		//}
	}
	
	public function AddPayPostCookie($uid,$post_id,$orderNum){
		if (!is_user_logged_in() && _cao('is_ripro_nologin_pay')) {        	
            $PostPay = new PostPay($uid, $post_id);            
            $days = intval(_cao('ripro_nologin_days'));
            $expire = time() + $days*24*60*60;
            setcookie('RiProPay_'.$post_id, $PostPay->set_key($orderNum), $expire, '/', $_SERVER['HTTP_HOST'], false);            
        }
	}
}

function get_user_role($id)
{
    $user = new WP_User($id);
    return $user->data;
}

function HasRightToDown($uid,$postid)
{
    //return true;
    $ret=true;
    $vip_black=get_user_meta($uid,'cao_black_vip',true);
	$use_vip_blacklist=get_post_meta($postid,'use_vip_blacklist',true);
	
	if(true)
	{
        $users=array();
	    $username=get_user_role($uid)->user_login;
		$ulist=get_post_meta($postid,'no_user_down',true);
		if($use_vip_blacklist&&!empty($ulist))
		{
			//$ulist=str_replace('，',',',$ulist);				
			$users=explode(',',$ulist);
			if(in_array($username,$users)) $ret=false;
		}
		
		if($vip_black){
			$ret=false;
		}
	}
    file_put_contents("/www/wwwroot/www.loowp.com/debug.txt",$vip_black);
    //update_user_meta(1,'cao_vip_downum', 5);
    return $ret;
}

?>