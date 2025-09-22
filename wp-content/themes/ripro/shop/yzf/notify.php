<?php
/**
 * RiPro是一个优秀的主题，首页拖拽布局，高级筛选，自带会员生态系统，超全支付接口，你喜欢的样子我都有！
 * 正版唯一购买地址，全自动授权下载使用：https://ritheme.com/
 * 作者唯一QQ：200933220 （油条）
 * 承蒙您对本主题的喜爱，我们愿向小三一样，做大哥的女人，做大哥网站中最想日的一个。
 * 能理解使用盗版的人，但是不能接受传播盗版，本身主题没几个钱，主题自有支付体系和会员体系，盗版风险太高，鬼知道那些人乱动什么代码，无利不起早。
 * 开发者不易，感谢支持，更好的更用心的等你来调教
 */


/**
 * 源分享是一个优质程序聚集地,不定期更新原创资源分享给大家,用心制作建站教程和源码评测,为更多的个人站长推荐有价值的好东西!
 * 正版唯一购买地址，下载使用：https://www.yfxw.cn/
 * 作者唯一QQ：26341012 （开心）
 */


/**
 * 易支付异步通知
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();


if (empty($_GET)) {exit;}

// 获取后台易支付配置
$yzf = _cao('yzf');
$data=$_GET;
if ($data['type'] == 'alipay') {
    $yzfConfig=$yzf['yzf_alipay'];
} else {
    $yzfConfig=$yzf['yzf_wxpay'];
}
if (empty($yzfConfig['yzf_id'])||empty($yzfConfig['yzf_key'])) {
    exit('error');
}
// 处理本地业务逻辑
if ($_GET['trade_status']=='TRADE_SUCCESS') {
    //商户本地订单号
    $out_trade_no = sanitize_text_field(wp_unslash($_GET[ 'out_trade_no' ]));
    //易支付交易号
    $trade_no = sanitize_text_field(wp_unslash($_GET[ 'trade_no' ]));
    //发送支付成功回调用
    $RiProPay = new RiProPay;
    $RiProPay->send_order_trade_success($out_trade_no, $trade_no, 'ripropaysucc');
    echo 'success';
    exit();
} else {
    // 输出错误日志 可以在生产环境关闭 注释即可
    echo "error";
    exit();
}
exit();
