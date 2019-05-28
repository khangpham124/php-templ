<?php
session_start();
$method = $_GET['method'];
$amount = $_SESSION['grand_total'] * 100;
$order_code = str_replace('_','',$_SESSION['order_code']);
$key = 'C8B00334FEA031F11505C3A98D30626C';
$vpc_AccessCode = 'HEA5RTOFD7AR8KN9ESS';
$vpc_Amount = $amount;
$vpc_BackURL = 'http://heartofdarknessbrewery.com/checkout/?step=3';
if($_COOKIE['methodPay']=='creditcard') {
$vpc_CardType = 'Visa';
} else if($_COOKIE['methodPay']=='atm') {
$vpc_CardType = '';
}
$vpc_Command = 'pay';
$vpc_CurrencyCode = 'VND';
$vpc_Locale = 'vn';
$vpc_MerchTxnRef = time();
$vpc_Merchant = 'HEARTOFDARKNESS';
$vpc_OrderInfo = $order_code;
if($_COOKIE['methodPay']=='creditcard') {
$vpc_PaymentGateway = 'INT';
} else if($_COOKIE['methodPay']=='atm') {
$vpc_PaymentGateway = 'ATM';
}
$vpc_ReturnURL = 'http://heartofdarknessbrewery.com/confirm/checkpay.php';
$vpc_TicketNo = '2.0';
$vpc_Version = '2.0';

$slip = $key.$vpc_AccessCode.$vpc_Amount.$vpc_BackURL.$vpc_CardType.$vpc_Command.$vpc_CurrencyCode.$vpc_Locale.$vpc_MerchTxnRef.$vpc_Merchant.$vpc_OrderInfo.$vpc_PaymentGateway.$vpc_ReturnURL.$vpc_TicketNo.$vpc_Version;
// echo $slip;
$md5 = md5($slip);
$vpc_SecureHash = strtoupper($md5);
echo $url_napas = 'https://payment.napas.com.vn/gateway/vpcpay.do?vpc_Version='.$vpc_Version.'&vpc_Command='.$vpc_Command.'&vpc_AccessCode='.$vpc_AccessCode.'&vpc_MerchTxnRef='.$vpc_MerchTxnRef.'&vpc_Merchant='.$vpc_Merchant.'&vpc_OrderInfo='.$vpc_OrderInfo.'&vpc_Amount='.$vpc_Amount.'&vpc_ReturnURL='.$vpc_ReturnURL.'&vpc_BackURL='.$vpc_BackURL.'&vpc_Locale='.$vpc_Locale.'&vpc_CurrencyCode='.$vpc_CurrencyCode.'&vpc_TicketNo='.$vpc_TicketNo.'&vpc_PaymentGateway='.$vpc_PaymentGateway.'&vpc_CardType='.$vpc_CardType.'&vpc_SecureHash='.$vpc_SecureHash;
?>
