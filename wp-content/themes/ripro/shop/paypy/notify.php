<?php
header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();

if (!_cao('is_paypy')) {
    wp_safe_redirect(home_url());exit;
}

// 获取后台支付配置
$paypyConfig = _cao('paypy');
$paypy_key  = $paypyConfig['paypy_key']; //appid
$paypy_api = $paypyConfig['paypy_api']; //secret
if (empty($paypy_key) || empty($paypy_api)) {
    wp_safe_redirect(home_url());exit;
}

$secretkey = $paypy_key;

$sign = $_POST['sign'];
$total_fee = $_POST['qr_price'];
$extension= $_POST['extension'];
$out_trade_no = $wpdb->escape($_POST['order_id']);

if($sign == md5(md5($_POST['order_id']).$secretkey) && $secretkey){
    //商户本地订单号
    $out_trade_no = $_POST['order_id'];
    //交易号
    $trade_no = $out_trade_no;
    //发送支付成功回调用
    $RiProPay = new RiProPay;
    $RiProPay->send_order_trade_success($out_trade_no,$trade_no,'ripropaysucc');
    echo 'success';
}