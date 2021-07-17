<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");
include(APP_PATH."libs-user/head.php");

echo $userID;

$fullnameUpdate = $_POST['fullnameUpdate'];
$phoneUpdate = $_POST['phoneUpdate'];
$emailUpdate = $_POST['emailUpdate'];
$passwordUpdate = md5($_POST['passwordUpdate']);

update_post_meta($userID, 'fullname', $fullnameUpdate);
update_post_meta($userID, 'phone', $phoneUpdate);
update_post_meta($userID, 'email', $emailUpdate);
if($passwordUpdate!='') {
    update_post_meta($userID, 'password', $passwordUpdate);
}

$my_post = array(
    'ID'           => $userID,
    'post_title'   => $emailUpdate, // new title
);

wp_update_post( $my_post );

?>