<?php
//email list
$aMailto = array("hien@alive-web.co.jp", "hien@alive-web.co.jp");
$from = "hien@alive-web.co.jp";

// 設定
require("./jphpmailer.php");
$script = "index.php";
$gtime = time();

// グローバル変数とサニタイジング
$action = htmlspecialchars($_POST['action']);

//お問い合わせフォーム内容
$reg_name = htmlspecialchars($_POST['name']);
$reg_email = htmlspecialchars($_POST['email']);
$reg_remail = htmlspecialchars($_POST['remail']);
$reg_tel = htmlspecialchars($_POST['tel']);
$reg_fax = htmlspecialchars($_POST['fax']);
$reg_corp = htmlspecialchars($_POST['corp']);
$reg_content = htmlspecialchars($_POST['content']);
$reg_url = htmlspecialchars($_POST['url']);
$reg_gender = htmlspecialchars($_POST['gender']);
$reg_check01 = $_POST['check01'];
$reg_checkAll01 = htmlspecialchars($_POST['checkAll01']);
$reg_sl01 = htmlspecialchars($_POST['sl01']);
$reg_code = htmlspecialchars($_POST['code']);
$reg_address = htmlspecialchars($_POST['address']);
$reg_check02 = $_POST['check02'];
$reg_checkAll02 = htmlspecialchars($_POST['checkAll02']);
$reg_orther = htmlspecialchars($_POST['orther']);
// 処理分岐
if($action == "confim"){
//======================================================================================== お問い合わせ確認画面



	html_header();

	$br_reg_content = nl2br($reg_content);
?>


<h2 class="blue fz30 fwB">お問い合わせフォーム</h2>
	<div class="txtContact01">
		<p>(<em>【必須】</em>は入力必須項目です)</p>
		<p class="t20b20">入力内容をご確認ください。<br>問題がなければ【この内容で送信する】ボタンをクリックして下さい。</p>
	</div>
	<p class="taC t20b0"><img src="img/img_step02.png" alt="" width="630" height="39"></p>
    
<form method="post" class="form-1" action="<?php echo $script ?>?<?php echo $gtime ?>">
<div class="t20b0">
	<p class="hid_url">Leave this empty: <input type="text" name="url" value="<?php echo $reg_url ?>"></p><!-- Anti spam part1: the contact form -->
	<table class="tableContact" cellspacing="0">
    	<tr class="thSP">
            <th>お名前</th>
        </tr>
        <tr>
            <th class="thPC">お名前</th>
            <td><?php echo $reg_name ?></td>
        </tr>
        
        <tr class="thSP">
            <th>性別</th>
        </tr>
        <tr>
            <th class="thPC">性別</th>
            <td><?php echo $reg_gender ?></td>
        </tr>
        
        <tr class="thSP">
            <th>Checkbox1</th>
        </tr>
        <tr>
            <th class="thPC">Checkbox1</th>
            <td>
            <?php 
            $strCheckbox = "";
            for($i=0; $i < count($reg_check01); $i++)
            {
                $strCheckbox .= $reg_check01[$i].", ";
            }
            if($strCheckbox != "") $strCheckbox = substr($strCheckbox,0,strlen($string)-2);
            echo $strCheckbox;
            ?>
             </td>
        </tr>
        
        <tr class="thSP">
            <th>Checkbox2</th>
        </tr>
        <tr>
            <th class="thPC">Checkbox2</th>
            <td>
            <?php 
            $strCheckbox02 = "";
            for($i=0; $i < count($reg_check02); $i++)
            {
                $strCheckbox02 .= $reg_check02[$i].", ";
            }
            if($strCheckbox02 != "") $strCheckbox02 = substr($strCheckbox02,0,strlen($string)-2);
            echo $strCheckbox02;
            ?><br>
            <?
            echo $reg_orther;
            ?>
             </td>
        </tr>
        
        <tr class="thSP">
            <th>Select</th>
        </tr>
        <tr>
            <th class="thPC">Select</th>
            <td><?php echo $reg_sl01 ?></td>
        </tr>
        
        <tr class="thSP">
            <th>メールアドレス</th>
        </tr>
        <tr>
            <th class="thPC">メールアドレス</th>
            <td><?php echo $reg_email ?></td>
        </tr>
        
        <tr class="thSP">
            <th>電話番号</th>
        </tr>
        <tr>
            <th class="thPC">電話番号</th>
            <td>
            <?php echo $reg_tel ?>
            </td>
        </tr>
        
        <?
        if(isset($reg_fax) && $reg_fax != '')
        {
        ?>
        <tr class="thSP">
            <th>FAX</th>
        </tr>
        <tr>
            <th class="thPC">FAX</th>
            <td><?php echo $reg_fax ?></td>
        </tr>
        <?
        }
        ?>
        
      	<?
        if(isset($reg_corp) && $reg_corp != '')
        {
        ?>
        <tr class="thSP">
            <th>企業名</th>
        </tr>
        <tr>
            <th class="thPC">企業名</th>
            <td><?php echo $reg_corp ?></td>
        </tr>
        <?
        }
        ?>
        
        <?
        if(isset($reg_code) && $reg_code != '' && isset($reg_address) && $reg_address != '')
        {
        ?>
        <tr class="thSP">
            <th>ご住所</th>
        </tr>
        <tr>
          <th class="thPC">ご住所</th>
          <td>
          <p><?php echo $reg_code ?></p>
          <p><?php echo $reg_address ?></p>
          </td>
        </tr>
        <?
        }
        ?>
        
        <?
        if(isset($reg_content) && $reg_content != '')
        {
        ?>
        <tr class="thSP">
            <th>お問い合わせの内容</th>
        </tr>
        <tr>
            <th class="thPC">お問い合わせの内容</th>
            <td><?php echo $br_reg_content ?></td>
        </tr>
        <?
        }
        ?>
    </table>
</div>


<input type="hidden" name="name" value="<?php echo $reg_name ?>">
<input type="hidden" name="email" value="<?php echo $reg_email ?>">
<input type="hidden" name="tel" value="<?php echo $reg_tel ?>">
<input type="hidden" name="fax" value="<?php echo $reg_fax ?>">
<input type="hidden" name="corp" value="<?php echo $reg_corp ?>">
<input type="hidden" name="content" value="<?php echo $reg_content ?>">
<input type="hidden" name="url" value="<?php echo $reg_url ?>">
<input type="hidden" name="gender" value="<?php echo $reg_gender ?>">
<input type="hidden" name="checkAll01" value="<?php echo $strCheckbox ?>">
<input type="hidden" name="checkAll02" value="<?php echo $strCheckbox02 ?>">
<input type="hidden" name="orther" value="<?php echo $reg_orther ?>">
<input type="hidden" name="sl01" value="<?php echo $reg_sl01 ?>">
<input type="hidden" name="code" value="<?php echo $reg_code ?>">
<input type="hidden" name="address" value="<?php echo $reg_address ?>">

<p style="text-align:right;">
	<a href="javascript:history.back()">
		入力内容を修正する
	</a>
</p>

<p align="center">
	<input type="image" src="img/btn_send.png" onMouseOver="this.src='img/btn_send.png'" onMouseOut="this.src='img/btn_send.png'" class="t20b20">
	<input type="hidden" name="action" value="send">
</p>

<p class="taC t30b0">上記フォームで送信できない場合は、必要項目をご記入の上、<br>
<a id="mailContact" href="#"></a>までメールをお送りください。</p><!-- Anti spam part2: clickable email address -->


</form>


<?php

	html_footer();

}elseif($action == "send"){
//========================================================================================== お問い合わせ確認画面



	$entry_time = gmdate("Y/m/d H:i:s",time()+9*3600);
	$entry_host = gethostbyaddr(getenv("REMOTE_ADDR"));
	$entry_ua = getenv("HTTP_USER_AGENT");



$msgBody = "

■お名前
$reg_name

■性別
$reg_gender
";

if(isset($reg_checkAll01) && $reg_checkAll01 != '')
{
	$msgBody .= "
■Checkbox1
$reg_checkAll01
";
}

if(isset($reg_checkAll02) && $reg_checkAll02 != '')
{
	$msgBody .= "
■Checkbox2
$reg_checkAll02
$reg_orther
";
}

$msgBody .= "
■Select
$reg_sl01

■メールアドレス
$reg_email

■電話番号
$reg_tel
";

if(isset($reg_fax) && $reg_fax != '')
{
	$msgBody .= "
■FAX
$reg_fax
";
}

if(isset($reg_corp) && $reg_corp != '')
{
	$msgBody .= "
■【任意】企業名
$reg_corp
";
}

if(isset($reg_code) && $reg_code != '' && isset($reg_address) && $reg_address != '')
{
	$msgBody .= "
■ご住所
$reg_code-$reg_address
";
}

if(isset($reg_content) && $reg_content != '')
{
$msgBody .= "
■お問い合わせの内容
$reg_content
";
}


//お問い合わせメッセージ送信
	$subject = "ホームページからお問い合わせがありました";
	$body = "

登録日時：$entry_time
ホスト名：$entry_host
ブラウザ：$entry_ua


ホームページからお問い合わせがありました。


$msgBody


";

//お客様用メッセージ
	$subject1 = "お問い合わせありがとうございました";
	$body1 = "

$reg_name 様

この度はお問い合わせいただきまして誠にありがとうございます。
こちらは自動返信メールとなっております。
弊社にて確認した後、改めてご連絡させていただきます。

以下、お問い合わせ内容となっております。
ご確認くださいませ。
---------------------------------------------------------------
---------------------------------------------------------------

$msgBody


---------------------------------------------------------------
About company
---------------------------------------------------------------

";



	// メール送信
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	
	$fromname = "Alive株式会社テストメール";


	//お客様受け取りメール送信
	$email1 = new JPHPmailer();
	$email1->addTo($reg_email);
	$email1->setFrom($from,$fromname);
	$email1->setSubject($subject1);
	$email1->setBody($body1);

	//if($email1->send()) {};
	
	//Anti spam advanced version 2 start: Don't send blank emails
	if( $reg_name <> "" && $reg_email <> "" ) {
		
		//Anti spam advanced version 1 start: The preg_match() is there to make sure spammers can’t abuse your server by injecting extra fields (such as CC and BCC) into the header.
		if( $reg_email && !preg_match( "/[\r\n]/", $reg_email) ) {
			
			//Anti spam part1: the contact form start
			if($reg_url == ""){
				
		     	// then send the form to your email
				if($email1->Send()) {};
			} // otherwise, let the spammer think that they got their message through
			//Anti spam part1: the contact form end
		}//Anti spam advanced version 1 end
	}//Anti spam advanced version 2 end: Don't send blank emails
	


	//メール送信
	$email = new JPHPmailer();
	for($i = 0; $i < count($aMailto); $i++)
	{
		$email->addTo($aMailto[$i]);
	}
	$email->setFrom($reg_email, $reg_name."様");
	$email->setSubject($subject);
	$email->setBody($body);

	//if($email->Send()) {};
	
	//Anti spam advanced version 2 start: Don't send blank emails
	if( $reg_name <> "" && $reg_email <> "" ) {
		
		//Anti spam part1: the contact form start
		if($reg_url == ""){
			
	     	// then send the form to your email
			if($email->Send()) {};
		} // otherwise, let the spammer think that they got their message through
		//Anti spam part1: the contact form end
	}//Anti spam advanced version 2 end: Don't send blank emails
	

	header("Location: indexThx.php");
	exit;

}else{
//================================================================================================== 初期画面
	html_init("");
}

////////////////////////////////////////////////////////////////////////////// HTML初期画面
function html_init($err_msg){

	global $gtime, $script;
	global
		$reg_company,
		$reg_name,
		$reg_tel,
		$reg_fax,
		$reg_email,
		$reg_content,
		$reg_url;

	html_header();

	if($err_msg){
?>

<?php
	}
?>




<h2 class="blue fz30 fwB">お問い合わせフォーム</h2>
	<p class="t20b0">Company Name のお問い合わせは、<br>
		<strong>お電話・またはお問い合わせフォーム</strong>よりお願いいたします。<br>
		また、お客様の個人情報についてはプライバシーポリシーに基づき管理いたします。</p>
	
	<div class="txtContact01">
		<p class="t0b20">下記の情報に御記入の上、【入力内容を確認する】ボタンをクリックしてください。<br>
			折り返し弊社より御連絡させていただきます。</p>
		<p>(半角カナは使用しないでください)<br>
			(<em>【必須】</em>は入力必須項目です)</p>
	</div>
	<p class="taC t20b0"><img src="img/img_step01.png" alt="" width="630" height="39"></p>

<form method="post" class="form-1" action="<?php echo $script ?>?<?php echo $gtime ?>" name="form1" onSubmit="return check()">
	<p class="hid_url">Leave this empty: <input type="text" name="url"></p><!-- Anti spam part1: the contact form -->
	<table class="tableContact" cellspacing="0">
    	<tr class="thSP">
            <th><em>【必須】</em>お名前</th>
        </tr>
        <tr>
            <th class="thPC"><em>【必須】</em>お名前</th>
            <td>
            <p class="test">
                <label for="name">例) 山田 太郎</label><br>
                <input type="text" size="20" name="name" id="name" class="writingBox size1" value="<?php echo $reg_name ?>">
            </p>
            </td>
        </tr>
        
        <tr class="thSP">
            <th><em>【必須】</em>性別</th>
        </tr>
        <tr>
            <th class="thPC"><em>【必須】</em>性別</th>
            <td>
            <span class="chkradio" id="radioarray01">
                <input type="radio" id="male" name="gender" value="男性" class="mr10">
                <label for="male" class="mr50">男性</label>
                <input type="radio" id="female" name="gender" value="女性" class="mr10">
                <label for="female">女性</label>
            </span>
            </td>
        </tr>
        
        <tr class="thSP">
            <th><em>【必須】</em>Checkbox1</th>
        </tr>			
        <tr>
            <th class="thPC"><em>【必須】</em>Checkbox1</th>
            <td>
            <span class="chkcheckbox" id="checkbox01">
                <input type="checkbox" name="check01[]" id="check01" value="01"> <label for="check01" class="mr20">01</label>
                <input type="checkbox" name="check01[]" id="check02" value="02"> <label for="check02" class="mr20">02</label>
                <input type="checkbox" name="check01[]" id="check03" value="03"> <label for="check03" class="mr20">03</label>
                <input type="checkbox" name="check01[]" id="check04" value="04"> <label for="check04" class="mr20">04</label>
                <input type="checkbox" name="check01[]" id="check05" value="05"> <label for="check05" class="mr20">05</label>
            </span>
            </td>
        </tr>
        
        <tr class="thSP">
            <th><em>【必須】</em>Checkbox2</th>
        </tr>
        <tr>
            <th class="thPC"><em>【必須】</em>Checkbox2</th>
            <td>
            <span class="chkcheckbox" id="checkbox02">
                <input type="checkbox" name="check02[]" id="check0201" value="01"> <label for="check0201" class="mr20">01</label><br>
                <input type="checkbox" name="check02[]" id="check0202" value="02"> <label for="check0202" class="mr20">02</label><br>
                <input type="checkbox" name="check02[]" id="check0203" value="03"> <label for="check0203" class="mr20">03</label> <input type="text" size="20" name="orther" id="orther" class="writingBox size1" value="<?php echo $reg_orther ?>">
            </span>
            </td>
        </tr>
        
        <tr class="thSP">
            <th><em>【必須】</em>Select</th>
        </tr>
        <tr>
            <th class="thPC"><em>【必須】</em>Select</th>
            <td>
                <select name="sl01" id="sl01" class="chkselect">
                    <option value="">選択してください</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>							
                </select>
            </td>
        </tr>
        
        <tr class="thSP">
            <th><em>【必須】</em>メールアドレス</th>
        </tr>
        <tr>
            <th class="thPC"><em>【必須】</em>メールアドレス</th>
            <td>
                <p class="test">
                    <label for="email">例）sample@sample.co.jp</label><br>
                    <input type="text" size="20" name="email" id="email" class="writingBox size1" value="<?php echo $reg_email ?>">
                </p>
            </td>
        </tr>
        
        <tr class="thSP">
            <th><em>【必須】</em>電話番号</th>
        </tr>
        <tr>
            <th class="thPC"><em>【必須】</em>電話番号</th>
            <td>
            <p class="test">
                <label for="tel">例）090-0000-1111</label><br>
                <input type="text" size="20" name="tel" id="tel" class="writingBox size1" value="<?php echo $reg_tel ?>">
            </p>
            </td>
        </tr>
        
        <tr class="thSP">
            <th>【任意】FAX</th>
        </tr>
        <tr>
            <th class="thPC">【任意】FAX</th>
            <td>
            <p class="test">
                <label for="fax">例）03-0000-1112</label><br>
                <input type="text" size="20" name="fax" id="fax" class="writingBox size1" value="<?php echo $reg_fax ?>">
            </p>
            </td>
        </tr>
        
        <tr class="thSP">
            <th>【任意】企業名</th>
        </tr>
        <tr>
            <th class="thPC">【任意】企業名</th>
            <td>
            <p class="test">
                <label for="corp">例) sample</label><br>
                <input type="text" size="20" name="corp" id="corp" class="writingBox size1" value="<?php echo $reg_corp ?>">
            </p>
            </td>
        </tr>
        
        <tr class="thSP">
            <th>【任意】ご住所</th>
        </tr>
        <tr>
          <th class="thPC">【任意】ご住所</th>
          <td>
              <p class="test test01"><span class="codeLabel">〒</span>
                <label for="code">例) 000-0000</label>
                <br>
                <input type="text" size="20" name="code" id="code" class="size2" value="<?php echo $reg_code ?>" onKeyUp="AjaxZip3.zip2addr(this,'','address','address')">
              </p>
            <p class="test t10b0">
              <label for="address">例) 愛知県名古屋市○○区0-00</label>
              <br>
              <input type="text" size="20" name="address" id="address" class="writingBox size1" value="<?php echo $reg_address ?>">
            </p></td>
        </tr>
        
        <tr class="thSP">
            <th>【任意】お問い合わせの内容</th>
        </tr>
        <tr>
            <th class="thPC">【任意】<br>お問い合わせの内容</th>
            <td><textarea name="content" class="content" id="content" rows="3" cols="5"></textarea></td>
        </tr>
    </table>
    
    <p class="t0b10">【個人情報の取扱いについて】</p>
    <ul class="t0b20">
        <li>・本フォームからお客様が記入・登録された個人情報は、資料送付・電子メール送信・電話連絡<br>
        などの目的で利用・保管します。</li>
        <li>・プライバシーポリシーについてはこちらをご覧ください。</li>
    </ul>
    
    <div class="taC">
    <label class="agree"><input type="checkbox" name="check1" value="ok"><span><b> 個人情報の取扱いに同意する</b></span></label>
    <br><br>
    <input type="image" src="img/btn_confirm.png" onMouseOver="this.src='img/btn_confirm_on.png'" onMouseOut="this.src='img/btn_confirm.png'" class="t20b20">
    <input type="hidden" name="action" value="confim"><br>
    </div>
</center>

<p class="taC t30b0">上記フォームで送信できない場合は、必要項目をご記入の上、<br>
<a id="mailContact" href="#"></a>までメールをお送りください。</p><!-- Anti spam part2: clickable email address -->

</form>



<?php

	html_footer();

}

////////////////////////////////////////////////////////////////////////////// HTMLヘッダー
function html_header(){

?>



<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/huyen/template-php/app_config.php");
include_once(APP_PATH."libs/header.php");
?>
<link type="text/css" rel="stylesheet" href="css/exvalidation.css" media="all">
<link type="text/css" rel="stylesheet" href="css/base.css" media="all">

<!-- Anti spam part1: the contact form start -->
<style type="text/css">
	.hid_url { display:none; }
</style>
<!-- Anti spam part1: the contact form end -->
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

	<?php
	}

	////////////////////////////////////////////////////////////////////////////// HTMLフッター
	function html_footer(){
	?>

</div>
<!--/Container-->


<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->



<script src="./js/ajaxzip3.js" charset="UTF-8"></script>
<script src="./js/jquery.cookie.js"></script>
<script src="./js/jquery.infieldlabel.js"></script>
<script charset="utf-8">
	$(function(){ $("label").inFieldLabels(); });
</script>
<script src="./js/exvalidation.js"></script>
<script src="./js/exchecker-ja.js"></script>
<script>
	$(function(){
	  $("form").exValidation({
	    rules: {
			name: "chkrequired",
			email: "chkrequired chkemail",
			tel: "chkrequired chktel",
			fax: "chkfax",
			orther: "chkrequired"
	    },
	    stepValidation: true,
	    scrollToErr: true,
	    errHoverHide: true
	  });
	});
</script>
<script>
	<!--
	function check(){
		var flag = 0;
		if(!document.form1.check1.checked){
			flag = 1;
		}
		if(flag){
			window.alert('「個人情報の取扱いに同意する」にチェックを入れて下さい');
			return false;
		}
		else{
			return true;
		}
	}
	// -->
</script>
<script src="./js/jquery.gafunc.js"></script>


<!-- Anti spam part2: clickable email address start -->
<script>
	$(function(){
		var address = "info" + "@" + "sample.co.jp";
		$("#mailContact").attr("href", "mailto:" + address);
		$("#mailContact").text(address);
	});
</script>
<!-- Anti spam part2: clickable email address end -->

	
<script>
	$(document).ready(function(){
		$("input:checkbox[name='check02[]']").click(function() {	
			if($("#check0203").is(":checked")) {
				$('#orther').addClass('chkrequired errPosRight');
			}
			else {
				$('#orther').removeClass('chkrequired errPosRight');
			}
		});	
		
		if($("#check0203").is(":checked")) {
				$('#orther').addClass('chkrequired errPosRight');
			}
			else {
				$('#orther').removeClass('chkrequired errPosRight');
			}

	})(jQuery);
</script>


<script>
	$(function(){
		function tablePC() {
			$(".thSP").hide();
			$(".thPC").show();
		}//end function tablePC()
		
		function tableSP() {
			$(".thPC").hide();
			$(".thSP").show();
		}//end function tableSP()
	
	
		if($(window).width() > 640){
			tablePC();
		}else{
			tableSP();
		}
		
		$(window).resize(function () {
			if($(window).width() > 640){
				tablePC();
			}else{
				tableSP();
			}
		});//load, resize
		
	});	
</script>

</body>
</html>
<?php
	exit;
}
?>