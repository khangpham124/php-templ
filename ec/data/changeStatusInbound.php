<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");
include(APP_PATH."libs-user/head.php");
$statusChange = $_POST['status'];
$IDInbound = $_POST['IDInbound'];
$numbOfItem = $_POST['numbOfItem'];
$dataAction = $_POST['dataAction'];
$dataInput = $_POST['dataInput'];
$postType = $_POST['postType'];


if($statusChange) {
    update_post_meta($IDInbound, 'status', $statusChange);
}

$get_current = get_field('list_products',$agencyId);
$get_my_current = get_field('my_products',$agencyId);

$timeline = get_field('timeline',$IDInbound);
$count_timeline = count($timeline);

$update_timeline = array();
$update_timeline[0]['time'] = '';
$update_timeline[0]['comment'] = '';
$update_timeline[0]['user'] = '';

array_push($timeline,$update_timeline);
update_field('timeline', $timeline, $IDInbound);

update_post_meta($IDInbound, 'timeline'.'_'.$count_timeline.'_'.'time' ,$create_time , false);
update_post_meta($IDInbound, 'timeline'.'_'.$count_timeline.'_'.'comment' , 'Status changed to ' .$statusChange , false);
update_post_meta($IDInbound, 'timeline'.'_'.$count_timeline.'_'.'user' , 'by ' .$name_user , false);


$arr = Array();
$param = array (
    'posts_per_page' => '-1',
    'post_type' => 'agency',
    'post_status' => 'publish',
    'order' => 'DESC',
    'meta_query' => array(
    array(
    'key' => 'parent',
    'value' => $agencyId,
    'compare' => '='
    ))
    );
    $posts_array = get_posts( $param );
    foreach ($posts_array as $sale ) {
        array_push($arr, $sale->ID) ;
    }

if($postType == 'inbound') {
    if($statusChange == 'Arrived') {
        for($i=0;$i<=count($arr);$i++) {
            ${'curr_noti'.$i} = get_field('inbound_noti_arrived',$arr[$i]);
            $curr_noti_parent = get_field('inbound_noti_arrived',$agencyId);
            update_post_meta($agencyId, 'inbound_noti_arrived', $curr_noti_parent . $IDInbound . ',');
            update_post_meta($arr[$i], 'inbound_noti_arrived', ${'curr_noti'.$i}  . $IDInbound . ',');
        }
        
    }
    if($statusChange == 'Received') {
        for($i=0;$i<=count($arr);$i++) {
            ${'curr_noti'.$i} = get_field('inbound_noti_complete',$arr[$i]);
            $curr_noti_parent = get_field('inbound_noti_complete',$agencyId);
            update_post_meta($agencyId, 'inbound_noti_complete', $curr_noti_parent . $IDInbound . ',');
            update_post_meta($arr[$i], 'inbound_noti_complete', ${'curr_noti'.$i}  . $IDInbound . ',');
        }
    }
    if($statusChange == 'Canceled') {
        echo 'abc';
        for($i=0;$i<=count($arr);$i++) {
            ${'curr_noti'.$i} = get_field('inbound_noti_cancel',$arr[$i]);
            $curr_noti_parent = get_field('inbound_noti_cancel',$agencyId);
            update_post_meta($agencyId, 'inbound_noti_cancel', $curr_noti_parent . $IDInbound . ',');
            update_post_meta($arr[$i], 'inbound_noti_cancel', ${'curr_noti'.$i}  . $IDInbound . ',');
        }
    }
}

if($postType == 'outbound') {
    if($statusChange == 'Arrived') {
        for($i=0;$i<=count($arr);$i++) {
            ${'curr_noti'.$i} = get_field('outbound_noti_arrived',$arr[$i]);
            $curr_noti_parent = get_field('outbound_noti_arrived',$agencyId);
            update_post_meta($agencyId, 'outbound_noti_arrived', $curr_noti_parent . $IDInbound . ',');
            update_post_meta($arr[$i], 'outbound_noti_arrived', ${'curr_noti'.$i}  . $IDInbound . ',');
        }
        
    }
    if($statusChange == 'Received') {
        for($i=0;$i<=count($arr);$i++) {
            ${'curr_noti'.$i} = get_field('outbound_noti_complete',$arr[$i]);
            $curr_noti_parent = get_field('outbound_noti_complete',$agencyId);
            update_post_meta($agencyId, 'outbound_noti_complete', $curr_noti_parent . $IDInbound . ',');
            update_post_meta($arr[$i], 'outbound_noti_complete', ${'curr_noti'.$i}  . $IDInbound . ',');
        }
    }
    if($statusChange == 'Canceled') {
        echo 'abc';
        for($i=0;$i<=count($arr);$i++) {
            ${'curr_noti'.$i} = get_field('outbound_noti_cancel',$arr[$i]);
            $curr_noti_parent = get_field('outbound_noti_cancel',$agencyId);
            update_post_meta($agencyId, 'outbound_noti_cancel', $curr_noti_parent . $IDInbound . ',');
            update_post_meta($arr[$i], 'outbound_noti_cancel', ${'curr_noti'.$i}  . $IDInbound . ',');
        }
    }
}

if($dataAction != '') {
    for($i=0; $i<$numbOfItem;$i++) {
        ${'item_check_default_'.$i} = explode('_',$_POST['item_check_default_'.$i]);
        ${'item_check_my_'.$i} = explode('_',$_POST['item_check_my_'.$i]);

        ${'item_origin_'.$i} = explode('_',$_POST['item_origin_'.$i]);
        

        $item_available = $get_current[${'item_check_default_'.$i}[1] - 1]['available'];
        $item_real = $get_current[${'item_origin_'.$i}[0] - 1]['quantity_real'];
        $item_real_out = $get_current[${'item_origin_'.$i}[0] - 1]['quantity_out'];

        $my_item_available = $get_my_current[${'item_check_my_'.$i}[1] - 1]['available'];
        $my_item_real = $get_my_current[${'item_origin_'.$i}[0] - 1]['quantity_real'];
        $my_item_real_out = $get_my_current[${'item_origin_'.$i}[0] - 1]['quantity_out'];
    
        $key_item_default = ${'item_check_default_'.$i}[1] - 1;
        $key_item_my = ${'item_check_my_'.$i}[1] - 1;

        if($statusChange != 'Canceled') {
            if($postType=='inbound') {
                $update_available = ${'item_check_default_'.$i}[2] + $item_available;
                $my_update_available = ${'item_check_my_'.$i}[2] + $my_item_available;
            } else {
                $update_available =   $item_available - ${'item_check_default_'.$i}[2];
                $my_update_available = $my_item_available - ${'item_check_my_'.$i}[2];
            }
            
        } else if($statusChange == 'Canceled') {
            if($postType=='outbound') {
                $update_available = $item_available;
                $update_real = $item_real_out - ${'item_origin_'.$i}[1];

                $my_update_available = $my_item_available;
                $my_update_real = $my_item_real_out - ${'item_origin_'.$i}[1];
            } else {
                $update_available = $item_available;
                $update_real = $item_real - ${'item_origin_'.$i}[1];

                $my_update_available = $my_item_available;
                $my_update_real = $my_item_real - ${'item_origin_'.$i}[1];
            }
        }

        // $update_real = $item_real - ${'item_origin_'.$i}[1];
        // $my_update_real = $my_item_real - ${'item_origin_'.$i}[1];

        update_post_meta($agencyId, 'list_products'.'_'.$key_item_default.'_'.'available' , $update_available , false);
        update_post_meta($agencyId, 'my_products'.'_'.$key_item_my.'_'.'available' , $my_update_available , false);

        if($postType=='inbound') {
            update_post_meta($agencyId, 'list_products'.'_'.$key_item_default.'_'.'quantity_real' , $update_real , false);
            update_post_meta($agencyId, 'my_products'.'_'.$key_item_my.'_'.'quantity_real' , $my_update_real , false);
        } else {
            $update_outbount_real = $item_real_out - ${'item_origin_'.$i}[1];
            $my_update_outbount_real = $my_item_real_out - ${'item_origin_'.$i}[1];
            update_post_meta($agencyId, 'list_products'.'_'.$key_item_default.'_'.'quantity_out' , $update_outbount_real , false);
            update_post_meta($agencyId, 'my_products'.'_'.$key_item_my.'_'.'quantity_out' , $my_update_outbount_real , false);
        }

        update_post_meta($IDInbound, 'list_package'.'_'.${'item_check_my_'.$i}[0].'_'.'quantity_real' , ${'item_check_my_'.$i}[2] , false);
        update_post_meta($IDInbound, 'list_package'.'_'.${'item_check_default_'.$i}[0].'_'.'quantity_real' , ${'item_check_default_'.$i}[2] , false);
    }

    if($statusChange != 'Canceled') {
        $format_date = date('d/m/Y', time());
        $create_time_input = DateTime::createFromFormat('d/m/Y',$format_date);
        $create_time_stamp = $create_time_input->getTimestamp();
        update_post_meta($IDInbound, 'status', 'Received');
        update_post_meta($IDInbound, 'date_reality', $create_time_stamp);
    } else {
        update_post_meta($IDInbound, 'status', 'Canceled');
    }
}



