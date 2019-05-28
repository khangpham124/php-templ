<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php");
if(!$_COOKIE['order_des']) {    
    header('Location:'.APP_URL);
    die();
}
setcookie('incart','', time() + 86400, "/");
setcookie('order_cookies','', time() + 86400, "/");
setcookie('order_des','', time() + 86400, "/");
include(TEMPLATEPATH."/mailer/class.phpmailer.php");
include(TEMPLATEPATH."/mailer/class.smtp.php");
?>
<!-- <meta http-equiv="REFRESH" content="5; url=<?php echo APP_URL; ?>"> -->
</head>
<body id="store" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent" class="clearfix">
        <h2 class="h3_page"><?php echo ${'thank_'.$lang_web} ?><?php echo $_SESSION['fullname']; ?>!</h2>
        <?php
            if($_SESSION['transactionNo']!="") {
            $reg_fullname = $_SESSION['fullname'];
            $reg_address = $_SESSION['address'];
            $reg_phone = $_SESSION['mobile'];
            $reg_mail = $_SESSION['mail'];
            $reg_order = $_SESSION['order_des'];
            $cf_total = $_SESSION["total"];
            $cf_note = $_SESSION['note'];
            $idcustomer = $_SESSION['idcustomer'];
            if($_SESSION['payment']=='atm') {
                $method = 'Domestic ATM Card';
            } else {
                $method = 'International Card';
            }
            
            $dateOrder = date("d/m/Y");

            $transactionNo = $_SESSION['transactionNo'];

            $f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$reg_order.'.json';
            $order_post = array(
            'post_title'    => $reg_order,
            'post_status'   => 'publish',
            'post_type' => 'getorder'
            );
            $pid = wp_insert_post($order_post);
            add_post_meta($pid, 'cf_fullname', $reg_fullname);
            add_post_meta($pid, 'cf_address', $reg_address);
            add_post_meta($pid, 'cf_phone', $reg_phone);
            add_post_meta($pid, 'cf_mail', $reg_mail);

            add_post_meta($pid, 'cf_total', $cf_total);
            add_post_meta($pid, 'cf_note', $cf_note);
            add_post_meta($pid, 'idcustomer', $idcustomer);
            add_post_meta($pid, 'transaction_number', $transactionNo);
            add_post_meta($pid, 'method', $method);
            add_post_meta($pid, 'cf_order_status', 'in progress');

            
            $order_detail  = json_decode(file_get_contents($f_isset),true);
            $count_product = count($order_detail);
        
            $listOrder = array();
            for($i=0; $i<$count_product;$i++)
            {
                if($order_detail[$i]['name']!='Customize Design') {
                    $listOrder[] = array(
                        'cf_name' => $order_detail[$i]['name'],
                        'cf_quantity' => $order_detail[$i]['quantity'],
                        'cf_color' => '#'.$order_detail[$i]['color'],
                        'cf_id' => $order_detail[$i]['id'],
                    );
                } else {
                    $inDesign = get_field('design',$_SESSION['idcustomer']);
                    $key = (int)$order_detail[$i]['sku'] - 1;
                    $thumb_design = $inDesign[$key]['id'];							
                    $listOrder[] = array(
                        'cf_name' => $order_detail[$i]['name'],
                        'cf_quantity' => $order_detail[$i]['quantity'],
                        'cf_color' => '#'.$order_detail[$i]['color'],
                        'cf_id' => $thumb_design,
                        'cf_include' => $order_detail[$i]['color']
                    );
                }
            }
            update_field('order_list', $listOrder, $pid);
        //}
        

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = "order.desino@gmail.com";
            $mail->Password = "P@@55w0rd123456";
            $from = "order.desino@gmail.com";

            $to_admin = "khangpham421@gmail.com";
            $to_customer = $reg_mail;

            $name="Desino";

            $mail->From = $from;
            $mail->FromName = "DESINO Premium Leather Handbags and Accessories";
            $mail->AddAddress($to_admin,$name);
            $mail->AddAddress($to_customer,$name);

            //$mail->AddReplyTo($from,"khang test");
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = "Mail from Premium Leather Handbags and Accessories";
            $mail->CharSet = 'UTF-8';
            $msgBody = "
            <p><strong>Full Name</strong> : $reg_fullname</p>
            <p><strong>Email</strong> : $reg_mail</p>
            <p><strong>Phone </strong>: $reg_phone</p>
            <p><strong>Address</strong> : $reg_address </p>
            <p><strong>Order Code</strong> : $reg_order</p>
            <p><strong>Order Date</strong> : $dateOrder</p>
            <br>
            <table style='border:1px solid #000;border-collapse: collapse;border-spacing: 0;'>
                <tr style='font-weight:bold; padding:5px'>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>PRODUCTS</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>PRICE</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>DETAIL</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>QTY</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>TOTAL</td>
                </tr>
            ";
            for($i=0;$i<=($count_product-1);$i++) {
                if($order_detail[$i]['name']!='Customize Design') {
                    $productname = get_the_title($order_detail[$i]['id']);
                    $promo = get_field('special-offer',$order_detail[$i]['id']);
                    if($promo!=0) {
                        $price_real = get_field('price',$order_detail[$i]['id']);
                        $price_dis = ($price_real * $promo) / 100;
                        $price = $price_real - $price_dis;
                    } else {
                        $price = get_field('price',$order_detail[$i]['id']);
                    }
                    $tt = $price * $order_detail[$i]['quantity'];
                } else {
                    $productname = $order_detail[$i]['name'];
                    $getItem = explode('_',$order_detail[$i]['color']);
                    $priceStock = array();
                    foreach($getItem as $pSs) {
                        $priceStock[] = get_field('price',$pSs);
                    }
                    $price = array_sum($priceStock);
                    $tt = array_sum($priceStock);	
                }
            
            $msgBody .= "   
                <tr>
                    <td style='border:1px solid #000;padding:5px'>".$productname."</td>
                    <td style='border:1px solid #000;padding:5px'>".number_format($price)."</td>
                    <td style='border:1px solid #000;padding:5px'>"
                    ;	
                    if($order_detail[$i]['color']!='') {
                        $msgBody .= "
                        <p style='border:1px solid #000;width:20px;height:20px;background:#".$order_detail[$i]['color']."'></p>
                    ";
                    }
                    $msgBody .= "
                    </td>
                        <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['quantity']."</td>    
                        <td style='border:1px solid #000;padding:5px'><strong>".number_format($tt)." VND</strong></td>
                    </tr>
                    ";
            }
            $msgBody .= " 
                <tr>
                    <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>Paid by: <strong>".$method."</strong></td>
                </tr>";
            if($cf_note!='') { 
                $msgBody .= " 
                <tr>
                    <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>Note: <strong>".$cf_note."</strong></td>
                </tr>";
            }
            $msgBody .= "
                <tr>
                    <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>GRAND TOTAL: <strong>".number_format($cf_total)." VND</strong></td>
                </tr>
            </table>
            ";

            $mail->Body = $msgBody;
            $mail->AltBody = "Desino successful order";
            //$mail->SMTPDebug = 2;
            // include(APP_PATH."libs/head.php");

            if(!$mail->Send())
            {
                echo "<h1>" . $mail->ErrorInfo . '</h1>';
            }
            else
            {
                echo '<p>
                You will receive an order confirmation with the details of your order in your email.<br>
                </p>';
            }
            // AFTER SUBMIT
            unlink($f_isset);
            $_SESSION['payment'] = '';
        ?>
        
        <h3 class="h3_page mt30"><?php echo ${'detail_'.$lang_web} ?></h3>
            <table class="tblAccount">
                <tr>
                    <th><?php echo ${'orderID_'.$lang_web} ?></th>
                    <td><?php echo get_the_title($pid); ?></td>
                </tr>
                <tr>
                    <th><?php echo ${'date_'.$lang_web} ?></th>
                    <td><?php echo get_the_time('d/m/Y',$pid); ?></td>
                </tr>
                <tr>
                    <th><?php echo ${'shipping_'.$lang_web} ?></th>
                    <td>
                        <?php echo get_field('cf_fullname',$pid); ?><br>
                        <?php echo get_field('cf_address',$pid); ?><br>
                        <?php echo get_field('cf_phone',$pid); ?><br>
                        <?php echo get_field('cf_mail',$pid); ?><br>
                    </td>
                </tr>

                <tr>
                    <th><?php echo ${'product_'.$lang_web} ?></th>
                    <td>
                    <?php 
                        $l_Order = get_field('order_list',$pid);
                        $arr_ids = array();
                        $arr_qty = array();
                        
                        $numb_order = count($l_Order);
                        
                        for($i=0;$i<=$numb_order;$i++) {
                            $arr_ids[] = $l_Order[$i]['cf_id'];
                            $arr_qty[] = $l_Order[$i]['cf_quantity'];
                        }
                        
                        ?>
                        
                        <ul class="lstCart">
                            <?php
                                $i=0;
                                $param = array (
                                'post_type' => 'product',
                                'orderby' => 'post__in', 
                                'post__in'=> $arr_ids
                                );
                                $posts_array = get_posts( $param );
                                foreach ($posts_array as $pro ) {
                                    $thumb = get_post_thumbnail_id($pro->ID);
                                    $img_label = wp_get_attachment_image_src($thumb,'full');
                                    $promo = get_field('special-offer',$pro->ID);
                                    if($promo!=0) {
                                        $price_real = get_field('price',$pro->ID);
                                        $price_dis = ($price_real * $promo) / 100;
                                        $price = $price_real - $price_dis;
                                    } else {
                                        $price = get_field('price',$pro->ID);
                                    }
                            ?>
                            <li class="flexBox flexBox--nosp">
                                <p class="thumb"><img src="<?php echo thumbCrop($img_label[0],140,140); ?>" class="" alt="<?php echo $pro->post_title; ?>"></p>	
                                <div class="info">
                                    <p class="name"><a href="<?php echo get_permalink($pro->ID); ?>"><?php echo $pro->post_title; ?></a></p>
                                    <table>
                                        <tr>
                                            <th><?php echo ${'qty_'.$lang_web} ?></th>
                                            <td class="qtyNumb"><?php echo $arr_qty[$i]; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo ${'cost_'.$lang_web} ?></th>
                                            <td><?php if($promo!=0) { ?><em><?php echo $price_real; ?></em><?php } ?><?php echo number_format($price); ?> VND</td>
                                        </tr>
                                        <tr>
                                            <th class="totalCost"><?php echo ${'tt_'.$lang_web} ?></th>
                                            <td class="totalCost"><?php echo number_format($price * $arr_qty[$i]); ?> VND</td>
                                        </tr>
                                    </table>
                                </div>
                            </li>
                            <?php $i++; } ?>
                        </ul>

                        <ul class="lstCart">
                            <?php
                                for($i=0;$i<=$numb_order;$i++) {
                                    if($l_Order[$i]['cf_include']!='') {
                                    $getItem = explode('_',$l_Order[$i]['cf_include']);
                                    $priceStock = array();
                                    foreach($getItem as $pSs) {
                                        $priceStock[] = get_field('price',$pSs);
                                    }
                                    $cusItemPrice = array_sum($priceStock);	
                            ?>
                            <li class="flexBox flexBox--nosp">
                                <p class="thumb"><img src="<?php echo $l_Order[$i]['cf_id']; ?>" class="" alt=""></p>	
                                <div class="info">
                                    <p class="name"><?php echo $l_Order[$i]['cf_name']; ?></p>
                                    <table>
                                        <tr>
                                            <th><?php echo ${'qty_'.$lang_web} ?></th>
                                            <td class="qtyNumb"><?php echo $l_Order[$i]['cf_quantity']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo ${'cost_'.$lang_web} ?></th>
                                            <td><?php echo number_format($cusItemPrice); ?> VND</td>
                                        </tr>
                                        <tr>
                                            <th class="totalCost"><?php echo ${'tt_'.$lang_web} ?></th>
                                            <td class="totalCost"><?php echo number_format($cusItemPrice); ?> VND</td>
                                        </tr>
                                    </table>
                                </div>
                            </li>
                            <?php } } ?>
                        </ul>                        
                    </td>
                </tr>

                <tr>
                    <th><?php echo ${'price_'.$lang_web} ?></th>
                    <td><?php echo number_format(get_field('cf_total',$pid)); ?> VND</td>
                </tr>
                <tr>
                    <th><?php echo ${'paymethod_'.$lang_web} ?></th>
                    <td>
                        <?php echo get_field('method',$pid); ?>
                        
                    </td>
                </tr>
                <?php if(get_field('note',$pid)!="") { ?>
                    <tr>
                        <th><?php echo ${'note_'.$lang_web} ?></th>
                        <td>
                            <?php echo get_field('note',$pid); ?><br>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <th><?php echo ${'status_'.$lang_web} ?></th>
                    <td><?php echo get_field('cf_order_status',$pid); ?></td>
                </tr>
            </table>
        <?php  } ?>
	</div>
      
<!-- container -->

<!--Footer-->
<?php include(TEMPLATEPATH."/libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->
	

</body>
</html>	