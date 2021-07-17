<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");

$IDUser = $_POST['IDUser'];
$action = $_POST['action'];

if($action == 'disable') {
    $stt = 'draft';
    wp_update_post(
        array(
        'ID'    =>  $IDUser,
        'post_status'   =>  $stt
        )
    );
} else if($action == 'enable') {
    $stt = 'publish';
    wp_update_post(
        array(
        'ID'    =>  $IDUser,
        'post_status'   =>  $stt
        )
    );
} else if($action == 'remove') {
    wp_trash_post($IDUser);
}

?>