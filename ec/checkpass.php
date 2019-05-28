<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php");

$reg_pass = md5($_POST['password']);
$reg_url = $_POST['url'];

$arr_user = array();
$wp_query = new WP_Query();
$param = array (
'p' => $_SESSION['idcustomer'],	
'posts_per_page' => '-1',
'post_type' => 'customer',
'post_status' => 'publish',
);
$wp_query->query($param);
while($wp_query->have_posts()) :$wp_query->the_post();
    $pass_real = get_field('password');
    if($pass_real==$reg_pass) {
        header('Location:'.$reg_url);
    }
    else {
        $_SESSION['err_signup'] = "Email or Passord is not correct";
        header('Location:'.APP_URL.'error');
    }
endwhile;
?>