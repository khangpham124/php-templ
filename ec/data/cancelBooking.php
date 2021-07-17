<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/rapha-tea/app_config.php");
include(LOAD_PATH."/wp-load.php");
		$pid = $_POST['idBooking'];
		$last_update = $_POST['last_update'];
		
		// this gets the repeater and all rows in an array
		update_field('status', 'Canceled', $pid);
		update_field('last_update', $last_update, $pid);
?>