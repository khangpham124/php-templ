<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(LOAD_PATH."/wp-load.php");
		// // $email_rep = get_field('mail_company',COMPANY_ID);
		$address = $_POST['address'];
		$idUser = $_POST['idUser'];
		$orderDate = $_POST['orderDate'];
		$noted = $_POST['noted'];
		$orderDate = $_POST['orderDate'];
		$codePromo = $_POST['codePromo'];
		$totalPriceAll = 0;

		$fullname = $_POST['fullname'];
		$phone = $_POST['phone'];
		$emailAgency = $_POST['email'];
		$payment = $_POST['payment'];


		$IDBooking = 'LOT_' . date("Y") .date("m") . date("d") .rand(100,999);
        $customer_post = array(
            'post_title'    => $IDBooking,
            'post_content'    => $noted,
            'post_status'   => 'publish',
            'post_type' => 'orders',
        );
        $pid = wp_insert_post($customer_post); 
        
        add_post_meta($pid, 'address', $address);
        add_post_meta($pid, 'order_date', $orderDate);
		update_post_meta($pid, 'status', 'Processed');
		update_post_meta($pid, 'note', $noted);

		update_post_meta($pid, 'fullname', $fullname);
		update_post_meta($pid, 'phone', $phone);
		update_post_meta($pid, 'email', $emailAgency);
		update_post_meta($pid, 'payment', $payment);
		update_post_meta($pid, 'has_promo', $codePromo);
		
		$listBooking = array();
		$numberOder = $_POST['numberOder'];
		
		for($n=0; $n<$numberOder; $n++) {
			$listBooking[$n]['name_pro'] = $_POST['prod_name_'.$n];
			$listBooking[$n]['quantity'] = $_POST['prod_quan_'.$n];
			$listBooking[$n]['price'] = $_POST['prod_price_'.$n];
			$listBooking[$n]['color'] = $_POST['prod_color_'.$n];
			$listBooking[$n]['size'] = $_POST['prod_size_'.$n];
			$listBooking[$n]['thumb'] = $_POST['prod_thumb_'.$n];
			$listBooking[$n]['sku'] = $_POST['prod_sku_'.$n];
			$totalPriceAll += $_POST['prod_quan_'.$n] * get_field('price',$_POST['prod_id_'.$n]);
		}

		$original = $totalPriceAll;
		if($codePromo == 'KHAITRUONG') {
			$discount = $totalPriceAll * 20 / 100;
			$totalPriceAll = $totalPriceAll - $discount;	
		}
		
		update_post_meta($pid, 'total', $totalPriceAll);
		
		
		update_field('order_detail', $listBooking, $pid);
		setcookie('order_numb', $IDBooking , time() + (86400), "/"); // 86400 = 1 day

//SEND MAIL 


// 設定
include(LOAD_PATH."/mail/class.phpmailer.php");
include(LOAD_PATH."/mail/class.smtp.php"); 

$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Host = "host07.emailserver.vn"; // specify main and backup server
$mail->Port = 587; // set the port to use
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = 'tsl';
$mail->Username = "order-system@lotus-club.vn"; // your SMTP username or your gmail username
$mail->Password = "P@55word!!!123"; // your SMTP password or your gmail password
$from = "order-system@lotus-club.vn"; // Reply to this email


$to="teddycoder421@gmail.com";
$to2="cskh.lotus.club@gmail.com";


$name="Lotus Club Booking System System "; // Recipient's name
$mail->From = $from;
$mail->CharSet = 'UTF-8';
$mail->FromName = "Lotus Club Booking System"; // Name to indicate where the email came from when the recepient received
$mail->AddAddress($to,$name);
$mail->AddAddress($to2,$name);
$mail->AddAddress($emailAgency,$name);
$mail->addReplyTo('cskh.lotus.club@gmail.com', 'Sales Lotus Club');
$mail->WordWrap = 50; // set word wrap
$mail->IsHTML(true); // send as HTML
$mail->Subject = '=?utf-8?B?'.base64_encode('Lotus Club xác nhận đơn hàng - Your Lotus Club order has been received').'?=';

$fm_original = number_format($original);
$fm_discount = number_format($discount);
$fm_totalPriceAll = number_format($totalPriceAll);



$orderDetail = "";
for($n=0; $n<$numberOder; $n++) {
	$namepro = $listBooking[$n]['name_pro'];
	$quanpro = $listBooking[$n]['quantity'];
	$pricepro = $listBooking[$n]['price'];
	$thumbpro = $listBooking[$n]['thumb'];
	$sizepro = $listBooking[$n]['size'];
	$colorpro = $listBooking[$n]['color'];
	$rate = number_format($quanpro * $pricepro);
	$orderDetail .= "
		<tr>
			<td style='border:1px solid #ccc;padding:5px'><img src='$thumbpro' width='80'/></td>
			<td style='border:1px solid #ccc;padding:5px'>$namepro x $quanpro ($sizepro $colorpro)</td>
			<td style='border:1px solid #ccc;padding:5px;text-align:right'>$rate Đ</td>
		</tr>
	";
	$orderDetail_en .= "
		<tr>
			<td style='border:1px solid #ccc;padding:5px'><img src='$thumbpro' width='80'/></td>
			<td style='border:1px solid #ccc;padding:5px'>$namepro x $quanpro ($sizepro $colorpro)</td>
			<td style='border:1px solid #ccc;padding:5px;text-align:right'>$rate Đ</td>
		</tr>
	";
}

$orderDetail .= "
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Tổng giá trị sản phẩm</td>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;text-align:right;'>$fm_original Đ</td>
	</tr>";

if($codePromo == 'KHAITRUONG') {
	$orderDetail .= "
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Giảm giá</td>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;text-align:right;'>$fm_discount  Đ</td>
	</tr>";
}

$orderDetail .= "
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Chi phí vận chuyển</td>
		<td style='border:1px solid #ccc;padding:5px;text-align:right;font-weight:bold;'>0 Đ</td>
	</tr>
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Tổng giá trị đơn hàng</td>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;text-align:right;'>$fm_totalPriceAll Đ</td>
	</tr>
";

//ENG

$orderDetail_en .= "
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Sub-Total</td>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;text-align:right;'>$fm_original Đ</td>
	</tr>";

if($codePromo == 'KHAITRUONG') {
	$orderDetail_en .= "
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Discount</td>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;text-align:right;'>$fm_discount  Đ</td>
	</tr>";
}

$orderDetail_en .= "
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Shipping fee</td>
		<td style='border:1px solid #ccc;padding:5px;text-align:right;font-weight:bold;'>0 Đ</td>
	</tr>
	<tr>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;' colspan='2'>Total</td>
		<td style='border:1px solid #ccc;padding:5px;font-weight:bold;text-align:right;'>$fm_totalPriceAll Đ</td>
	</tr>
";

$body = "
<style type='text/css'> .bold{font-size:16px;font-weight:bold;} </style>
<table style='width:800px;border-collapse: collapse;'>
	<tr style='border-bottom:1px solid #ccc;'>
	<td style='text-align:center;'><img src='https://lotus-club.vn/logo_email.png' width='125'></td>
	</tr>
</table>
	
<p style='font-size:16px;font-weight:bold;'>Cám ơn bạn đã đặt hàng tại Lotus Club!<br><em>(Scroll down for English version)</em></p>

<table style='width:800px;border-collapse: collapse;'>
<tr>
	<td><strong class='bold'>Xin chào $fullname ,</strong></td>
</tr>
<tr>
	<td>Đơn hàng của bạn đã được Lotus Club tiếp nhận và đang trong quá trình xử lý. Bạn sẽ nhận được thông báo tiếp theo khi đơn hàng đã sẵn sàng được giao.</td>
</tr>
</table>

<br>
<br>

<table style='width:800px;border-collapse: collapse;'>
	<tr><td style='border:1px solid #ccc;padding:5px;color:#95569b;font-weight:bold;' colspan='3'>THÔNG TIN ĐƠN HÀNG $IDBooking</td></tr>
	<tr>
		<td style='border:1px solid #ccc;padding:5px;vertical-align:top;' colspan='2'>
			<p style='font-size:16px;font-weight:bold;'>Thông tin thanh toán</p>
			<p>
			$fullname<br>
			$email<br>
			$phone<br>
			</p>
			<p style='font-size:16px;font-weight:bold;'>Thông tin đặt hàng</p>
			<p>
			Ngày đặt hàng: $orderDate
			</p>
		</td>
		<td style='border:1px solid #ccc;padding:5px;vertical-align:top;' colspan='2'>
			<p style='font-size:16px;font-weight:bold;'>Địa chỉ giao hàng</p>
			<p>$address</p>
		</td>
	</tr>
	<tr>
		<td style='border:1px solid #ccc;padding:5px;' colspan='2'><p style='font-size:16px;font-weight:bold;'>Phương thức thanh toán</p></td>
		<td style='border:1px solid #ccc;padding:5px;text-transform:uppercase;'>$payment</td>
	</tr>
	<tr><td style='border:1px solid #ccc;padding:5px;color:#95569b;font-weight:bold;' colspan='3'>CHI TIẾT ĐƠN HÀNG $IDBooking</td></tr>
	$orderDetail
</table>

<p>
Đây là email tự động, quý khách vui lòng không trả lời lại email này. Mọi thắc mắc và hỗ trợ vui lòng gửi mail đến <a href='mailto:cskh.lotus.club@gmail.com'>cskh.lotus.club@gmail.com</a>.
</p>


<p style='font-size:16px;font-weight:bold;'>Thanks for your order!</p>

<table style='width:800px;border-collapse: collapse;'>
<tr>
	<td><strong class='bold'>Hello $fullname ,</strong></td>
</tr>
<tr>
	<td>Your order has been received and is being processed. We will notify you when the parcel is ready.</td>
</tr>
</table>

<br>
<br>

<table style='width:800px;border-collapse: collapse;'>
	<tr><td style='border:1px solid #ccc;padding:5px;color:#95569b;font-weight:bold;' colspan='3'>DELIVERY DETAILS ORDER NO.$IDBooking</td></tr>
	<tr>
		<td style='border:1px solid #ccc;padding:5px;vertical-align:top;' colspan='2'>
			<p style='font-size:16px;font-weight:bold;'>Billing information</p>
			<p>
			$fullname<br>
			$email<br>
			$phone<br>
			</p>
			<p style='font-size:16px;font-weight:bold;'>Order information</p>
			<p>
			Order date: $orderDate
			</p>
		</td>
		<td style='border:1px solid #ccc;padding:5px;vertical-align:top;' colspan='2'>
			<p style='font-size:16px;font-weight:bold;'>Delivery Address</p>
			<p>$address</p>
		</td>
	</tr>
	<tr>
		<td style='border:1px solid #ccc;padding:5px;' colspan='2'><p style='font-size:16px;font-weight:bold;'>Payment</p></td>
		<td style='border:1px solid #ccc;padding:5px;text-transform:uppercase;'>$payment</td>
	</tr>
	<tr><td style='border:1px solid #ccc;padding:5px;color:#95569b;font-weight:bold;' colspan='3'>DELIVERED ITEMS ORDER NO.$IDBooking</td></tr>
	$orderDetail_en
</table>

<p>
This is an automated message. Please do not reply. If you need any assistance, please send us an email to <a href='mailto:cskh.lotus.club@gmail.com'>cskh.lotus.club@gmail.com</a>.
</p>




<table style='width:800px;border-collapse: collapse;margin-top:40px'>
	<tr style='border-top:1px solid #ccc;'>
	<td style='text-align:center;padding-top:25px;'><img src='https://lotus-club.vn/logo_email.png' width='125'></td>
	</tr>
	<tr>
	<td style='text-align:center;'>
		<a href='https://www.instagram.com/lotusclub.vn/' target='_blank'><img src='https://lotus-club.vn/icon_ins.jpg' width='40'></a>
		<a href='https://www.facebook.com/lotusclub.vn' target='_blank'><img src='https://lotus-club.vn/icon_fb.jpg' width='40'></a>
		<a href='https://www.youtube.com/channel/UCf7FCasJQx3-hEDSRjqGtxA' target='_blank'><img src='https://lotus-club.vn/icon_youtube.jpg' width='40'></a>
	</td>
	</tr>
</table>

";
$mail->Body = $body; //HTML Body

$mail->AltBody = "Mail nay duoc goi bang phpmailer class."; //Text Body
//$mail->SMTPDebug = 2;
if(!$mail->Send())
{
	echo "<h1>Loi khi goi mail: " . $mail->ErrorInfo . '</h1>';
}
else
{
	echo "<h1>Send mail thanh cong</h1>";
}

?>