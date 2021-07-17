<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");

$username = $_POST['username'];
$pw = md5($_POST['password']);
	$arr_user = array();
	$wp_query = new WP_Query();
	$param = array (
	's' => $username,	
	'posts_per_page' => '-1',
	'post_type' => 'agency',
	'post_status' => 'publish',
	);
	$wp_query->query($param);
	$numb_result = count($wp_query->query($param));
	if($numb_result > 0) {
		while($wp_query->have_posts()) :$wp_query->the_post();
			$username = $post->post_title;
			$userID = $post->ID;
			$fullname = get_field('fullname');
			$pass_real = get_field('password');
			$parent = get_field('parent');
			if($pass_real==$pw) {
				$token = get_field('token');
				if($token == '') {
					update_field('token', generateRandomString() , $userID);
				}
				setcookie('login_cookies', $username, time() + (86400 * 30), "/");
				setcookie('name_cookies', $fullname, time() + (86400 * 30), "/");
				if($parent != '') {
					setcookie('paren_user', $parent, time() + (86400 * 30), "/");
				}
				setcookie('user_id', $userID, time() + (86400 * 30), "/");
				header('Location:'.APP_URL_USER);
			}
			else {
				header('Location:'.APP_URL.'login');
			}
		endwhile;
	} else {
		header('Location:'.APP_URL.'login');
		// echo 'abc';
	}
?>