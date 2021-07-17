<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/rapha-tea/app_config.php");
include(LOAD_PATH."/wp-load.php");
        $pid = $_POST['idBooking'];
        $last_update = $_POST['last_update'];
        $numberOder = $_POST['numberOder'];
                
        for($n=0; $n < $numberOder; $n++) {
            update_post_meta($pid, 'order_detail'.'_'.$n.'_'.'name_pro' ,$_POST['prod_name_'.$n], true);
            update_post_meta($pid, 'order_detail'.'_'.$n.'_'.'quantity' ,$_POST['prod_quan_'.$n], false);
            update_post_meta($pid, 'order_detail'.'_'.$n.'_'.'price' ,$_POST['prod_price_'.$n], false);
        }
        update_field('last_update', $last_update, $pid);
?>