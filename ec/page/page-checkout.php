<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
if(!$_COOKIE['order_des']) {    
    header('Location:'.APP_URL);
    die();
}
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>checkform/exvalidation.css" media="all">
</head>

<body id="men" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(TEMPLATEPATH."/libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent">
		<h3 class="h3_page">Checkout</h3>
		<div class="boxTotal">
			<h3 class="h3_checkout"><?php echo ${'summary_'.$lang_web} ?><em> <?php echo ${'cartSum_'.$lang_web} ?> (<span class="numbCart"></span>)</em></h3>
			<table class="tblCheckout">
			<table class="tblCheckout">
						<?php
							$f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$_COOKIE['order_des'].'.json';
							$curr_cart  = json_decode(file_get_contents($f_isset));
							$arr_price = array();
							$total_stockCus = array();
							foreach($curr_cart as $mydata)
							{
								if($mydata->name!='Customize Design') {
								if(get_field('special-offer',$mydata->id)!=0) {
									$price_real = get_field('price',$mydata->id);
									$promo = get_field('special-offer',$mydata->id);
									$price_dis = ($price_real * $promo) / 100;
									$price_no = $price_real - $price_dis;
								}else{
									$price_no = get_field('price',$mydata->id);
								}
								$count_price = ($mydata->quantity * $price_no);
								$arr_price[] = $count_price;
						?>
						<tr>
							<th><?php echo $mydata->name; ?></th>
							<td><?php echo number_format($price_no); ?> VND x <?php echo $mydata->quantity; ?></td>
							<td><?php echo number_format($price_no * $mydata->quantity); ?> VND</td>
						</tr>
							<?php } else { ?>
							<?php
								$getItem = explode('_',$mydata->color);
								$priceStock = array();
								foreach($getItem as $pSs) {
									$priceStock[] = get_field('price',$pSs);
								}
								$cusItemPrice = array_sum($priceStock);	
								$total_stockCus [] = $cusItemPrice;
							?>
								<tr>
									<th><?php echo $mydata->name; ?></th>
									<td><?php echo number_format($cusItemPrice); ?> VND x 1</td>
									<td><?php echo number_format($cusItemPrice); ?> VND</td>
								</tr>
							<?php } } ?>
						<tr class="totalCost">
							<th  colspan="2"><?php echo ${'price_'.$lang_web} ?></th>
							<td><?php
							$finalCart = (int)array_sum($total_stockCus) + (int)array_sum($arr_price);
							echo number_format($finalCart);
							$_SESSION["total"] = $finalCart;
							?> VND</td>
						</tr>
					</table>
			</table>
		</div>	
		<form action="<?php echo APP_URL; ?>payment/visa/do.php" class="formChk" method="post" id="formCheckout">		
			<div class="flexBox flexBox--between checkOutcontent">
				
				<div class="leftCheck">
					<h3 class="h3_checkout"><?php echo ${'shipping_'.$lang_web} ?></h3>
					
						<p class="inputForm">
							<label><?php echo ${'fullname_'.$lang_web} ?><span>(*)</span></label>
							<input type="text" name="fullname_chk" value="<?php echo $_SESSION['fullname']; ?>" id="fullname_chk" class="inputText">
						</p>
						<p class="inputForm">
							<label><?php echo ${'address_'.$lang_web} ?><span>(*)</span></label>
							<input type="text" name="address_chk" value="<?php echo $_SESSION['address']; ?>" id="address_chk" class="inputText">
						</p>
						<p class="inputForm">
							<label><?php echo ${'phone_'.$lang_web} ?><span>(*)</span></label>
							<input type="text" name="mobile_chk" value="<?php echo $_SESSION['mobile']; ?>" id="mobile_chk"  class="inputText">
						</p>
						<p class="inputForm">
							<label>E-mail<span>(*)</span></label>
							<input type="text" name="mail_chk" value="<?php echo $_SESSION['login']; ?>" id="mail_chk" class="inputText">
						</p>
					<h3 class="h3_checkout"><?php echo ${'note_'.$lang_web} ?></h3>
					<textarea id="note_order" name="comt_order"></textarea>	
				</div>
				<div class="leftCheck">
					<h3 class="h3_checkout"><?php echo ${'paymethod_'.$lang_web} ?></h3>
					<div class="chkradio" id="radPay">
						<p class="inputRadio">
						<input type="radio" <?php if($_SESSION['payment']=='atm') { ?>checked<?php } ?> id="pay_atm" name="payment" value="atm"><label for="pay_atm"><?php echo ${'atm_'.$lang_web} ?></label>
						</p>
						<div class="atmCard boxLogoBank">
							<div class="flexBox logoBank  flexBox--wrap logoBank--4">
								<?php for($i=1;$i<28;$i++) { ?>
									<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/logo<?php echo $i; ?>.jpg" alt=""></p>
								<?php } ?>
							</div>	
						</div>
						<p class="inputRadio"><input type="radio" <?php if(($_SESSION['payment']=='creditcard')||($_SESSION['payment']=='')) { ?>checked<?php } ?>  id="pay_visa" name="payment" value="creditcard"><label for="pay_visa"><?php echo ${'visa_'.$lang_web} ?></label></p>
						<div class="visaCard boxLogoBank">
							<div class="flexBox logoBank flexBox--start">
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/visa.png" alt=""></p>
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/master.png" alt=""></p>
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/jcb.png" alt=""></p>
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/amex.png" alt=""></p>
							</div>
						</div>
					</div>
					
					<?php
						$login_session_duration = 10;
						if(((time() - $_SESSION['err_time']) < $login_session_duration)){ 
							if($_SESSION['err_fail']!="") { ?>
							<?php if($lang_web=='en') { ?>
								<label class="messErr">Failured</label>
							<?php } else { ?>
								<label class="messErr">Giao dịch thất bại</label>
							<?php } ?>
							<p class="messErr_text"><?php echo $_SESSION['err_fail']; ?></p>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<div class="boxBtn">
				<a href="<?php echo APP_URL; ?>shop/" class="btnPage"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;<?php echo ${'cont_'.$lang_web} ?></a>
				<input type="hidden" value="<?php echo $_COOKIE['order_des']; ?>" name="order_des" >
				<input type="hidden" value="<?php echo virtualPaymentClientURL_visa; ?>" id="virtualPaymentClientURL" name="virtualPaymentClientURL" >
				<input type="hidden" name="Title" value="VPC 3-Party"/>
				<input type="submit" class="btnPage" value="<?php echo ${'pay_'.$lang_web} ?>">
			</div>
		</form>
			
		</div>  
</div>
<!-- container -->


<!--Footer-->
<?php include(TEMPLATEPATH."/libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->

<script type="text/javascript">
$(function(){
	$('.lstProdMen li').biggerlink();
});
</script>

<script type="text/javascript" src="<?php echo APP_URL; ?>checkform/exvalidation.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>checkform/exchecker-ja.js"></script>
<script type="text/javascript">
$(function(){
	  $("#formCheckout").exValidation({
	    rules: {
			fullname_chk: "chkrequired",
			address_chk: "chkrequired",
			mail_chk: "chkrequired chkemail",
			mobile_chk: "chkrequired chktel",
	    },
	    stepValidation: true,
	    scrollToErr: true,
	    errHoverHide: true
	  });
	$('.visaCard').show();


	if($("#pay_atm").prop("checked")) {
		$('.visaCard').slideUp(200);
		$('.atmCard').slideDown(200);
		$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL; ?>');
		$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/local/do.php');
		$('.infoVisa').slideUp(200);
	}

	if($("#pay_visa").prop("checked")) {
		$('.visaCard').slideDown(200);
		$('.atmCard').slideUp(200);
		$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL_visa; ?>');
		$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/visa/do.php');
		$('.infoVisa').slideDown(200);
	}

	$('input[name="payment"]').on('change', function() {
	   var pay = $(this).val();
	   if(pay=='atm') {
			$('.visaCard').slideUp(200);
			$('.atmCard').slideDown(200);
		   $('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL; ?>');
		   $('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/local/do.php');
		   $('.infoVisa').slideUp(200);
	   } else {
			$('.visaCard').slideDown(200);
			$('.atmCard').slideUp(200);
			$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL_visa; ?>');
			$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/visa/do.php');
			$('.infoVisa').slideDown(200);
	   }
    });
});
</script>

</body>
</html>	