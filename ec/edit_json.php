<?php
$f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$_COOKIE['order_des'].'.json';
$curr_cart  = json_decode(file_get_contents($f_isset),true);
$curr_cart = array_values($curr_cart);
$c = count($curr_cart);
for($i=0;$i<=$c;$i++)
{    
    echo $curr_cart[$i]['id'];
    if($_GET['proid'] == $curr_cart[$i]['id']) {
        unset($curr_cart[$i]);
    }
}

$recurr_cart = array_values($curr_cart);
$formattedData = json_encode($recurr_cart);

$handle = fopen($f_isset,'w+');
fwrite($handle,$formattedData);
fclose($handle);
$curr_cookie = $_COOKIE['incart'];
$update_cookie = $curr_cookie - $_GET['qual'];
setcookie('incart', $update_cookie, time() + 86400, "/");
if(sizeof($curr_cart)== 0) {
    unlink($f_isset);
    setcookie('order_cookies','', time() + 86400, "/");
    setcookie('order_des','', time() + 86400, "/");
    setcookie('incart', 0, time() + 86400, "/");
}
unset($_COOKIE['incart']);
?>

