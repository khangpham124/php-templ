<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");
include(APP_PATH."libs-user/head.php");

    $name =  $_POST['name_product'];
    $sku =  $_POST['sku'];
    $unit =  $_POST['unit'];
    $available =  $_POST['available'];
    $quantity_real = 0;
    $quantity_out = 0;
    $key_item = $_POST['key_item'];
    $curr_list = get_field('my_products',$agencyId);

    $update_product = array();
    $update_product[0]['numb'] = $key_item;
    $update_product[0]['name'] = $name;
    $update_product[0]['sku'] = $sku;
    $update_product[0]['unit'] = $unit;
    $update_product[0]['available'] = $available;
    $update_product[0]['quantity_real'] = $quantity_real;
    $update_product[0]['quantity_out'] = $quantity_out;

    if((count($curr_list)>0)&&($curr_list[0][numb]!='')) {
        array_push($curr_list,$update_product);
        update_field('my_products', $curr_list, $agencyId);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'numb' , $key_item + 1 , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'name' , $name , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'sku' , $sku , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'unit' , $unit , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'available' , $available , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'quantity_real' , $quantity_real , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item.'_'.'quantity_out' , $quantity_out , false);
    } else {
        update_field('my_products', $update_product, $agencyId);
    }

?>