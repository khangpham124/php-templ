<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/huyen/template-php/app_config.php");
include_once(APP_PATH."libs/header.php");
?>
<link type="text/css" rel="stylesheet" href="css/exvalidation.css">
<link type="text/css" rel="stylesheet" href="css/base.css">
 <script>
	history.pushState({ page: 1 }, "title 1", "#noback");
	window.onhashchange = function (event) {
		window.location.hash = "#noback";
	};
</script>
</head>

<body id="contact">
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->


<!--Container-->
<div id="container" class="clearfix">

<h2 class="blue fz30 fwB">お問い合わせフォーム</h2>
	<p align="center" class="t20b20">
    	お問い合わせありがとうございます。 
    </p>
	<p class="t20b20">送信が完了いたしました。<br />
		弊社で確認後、折り返しご連絡させていただきます。<br />
		2営業日以上経ってもご連絡がない場合は、お電話にてお問い合わせください。<br />
		</p>
	<p class=" t20b0 txtContact02"><a href="/">TOPへ戻る</a></p>
    
  	<p class="taC t30b0">上記フォームで送信できない場合は、必要項目をご記入の上、<br />
   	<a id="mailContact" href="#"></a>までメールをお送りください。</p><!-- Anti spam part2: clickable email address -->



</div>
<!--/Container-->


<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->


<!-- Anti spam part2: clickable email address start -->
<script>
	$(function(){
		var address = "info" + "@" + "sample.co.jp";
		$("#mailContact").attr("href", "mailto:" + address);
		$("#mailContact").text(address);
	});
</script>
<!-- Anti spam part2: clickable email address end -->
</body>
</html>