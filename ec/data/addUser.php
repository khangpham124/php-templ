<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");
include(APP_PATH."libs-user/head.php");

	
	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$pw = md5('123456');
	if($_POST['parent-user']!='undefined') {
		$parentuser = $_POST['parent-user'];
	} else {
		$parentuser = '';
	}
	
	if($role_user == 'super admin') {
		$role = $_POST['role'];	
	} else {
		$role = 'sub agency';
	}
	
	$customer_post = array(
		'post_title'    => $email,
		'post_status'   => 'publish',
		'post_type' => 'agency',
	);

	$pid = wp_insert_post($customer_post); 
	update_post_meta($pid, 'fullname', $fullname);
	update_post_meta($pid, 'phone', $phone);
	update_post_meta($pid, 'email', $email);
	update_post_meta($pid, 'address', $address);
	update_post_meta($pid, 'parent', $parentuser);
	update_post_meta($pid, 'role', $role);
	update_post_meta($pid, 'password', $pw);

	$listProduct = array();
	$param = array (
	'posts_per_page' => '-1',
	'post_type' => 'product',
	'post_status' => 'publish',
	'order' => 'ASC',
	);
	$posts_array = get_posts( $param );
	$i=0;
	foreach ($posts_array as $sale ) {
		$listProduct[$i]['name'] = $sale->post_title;
		$listProduct[$i]['sku'] = get_field('sku',$sale->ID);
		$listProduct[$i]['unit'] = get_field('unit',$sale->ID);
		$i++;
	}
	$listInventory = array();
	for($n=0; $n<count($listProduct); $n++) {
		$listInventory[$n]['numb'] = $n + 1;
		$listInventory[$n]['sku'] = $listProduct[$n]['sku'];
		$listInventory[$n]['unit'] = $listProduct[$n]['unit'];
		$listInventory[$n]['name'] = $listProduct[$n]['name'];
		$listInventory[$n]['quantity_real'] = 0;
		$listInventory[$n]['quantity_out'] = 0;
		$listInventory[$n]['available'] = 0;
	}
	update_field('list_products', $listInventory, $pid);
?>