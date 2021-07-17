<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/storage/app_config.php");
include(LOAD_PATH."/wp-load.php");
		$password = md5('123456');
		$pid = $_POST['idUserChange'];
		update_field('password', $password, $pid);
?>