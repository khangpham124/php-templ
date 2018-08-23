<?php echo('<?xml version="1.0" encoding="UTF-8"?>'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<!--responsive or smartphone-->
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php
	// set viewport by user agent.
	require_once 'ua.class.php';
	$ua = new UserAgent();
	if($ua->set() === 'tablet') :
		// set width when you use the tablet
		$width = '1024px';
?>
<meta content="width=<?php echo $width; ?>" name="viewport">
<?php else: ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<?php endif; ?>
<!--responsive or smartphone-->

<?php include(APP_PATH."libs/argument.php"); ?>
<title><?php echo $titlepage; ?></title>
<meta name="description" content="<?php echo $desPage; ?>">
<meta name="keywords" content="<?php echo $keyPage; ?>">

<!--facebook-->
<meta property="og:title" content="<?php echo $titlepage; ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo 'http://';echo $_SERVER["SERVER_NAME"];echo $_SERVER["SCRIPT_NAME"];echo $_SERVER["QUERY_STRING"]; ?>">
<meta property="og:image" content="<?php echo APP_URL; ?>common/img/other/fb_image.jpg">
<meta property="og:site_name" content="">
<meta property="og:description" content="<?php echo $desPage; ?>">
<meta property="fb:app_id" content="">
<!--/facebook-->

<!--css-->
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/base.css" media="all">
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/style.css" media="all">
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/media.css" media="all">
<!--/css-->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700,900" rel="stylesheet">

<!--favicons-->
<link rel="icon" href="<?php echo APP_URL; ?>common/img/icon/favicon.ico" type="image/vnd.microsoft.icon">

<?php
	//wp_head();
?>
