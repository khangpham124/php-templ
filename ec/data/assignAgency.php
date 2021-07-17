<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");
include(APP_PATH."libs-user/head.php");


$idToAssigned = $_POST['idToAssigned'];
$assigned = $_POST['assigned'];

update_post_meta($idToAssigned, 'assigned', $assigned);
?>