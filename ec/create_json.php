<?php
$data = array();
$insert_data = array();
//format the data

$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789'); // and any other characters
shuffle($seed); // probably optional since array_is randomized; this may be redundant
$rand = '';
foreach (array_rand($seed, 8) as $k) 
$rand .= $seed[$k];


//set the filename
$filename = './tmp/DES_'.$rand.'.json';
//open or create the file

if(!isset($_COOKIE['order_des'])) {
    $data =array (
        array(
        "id"=>$_GET['proid'],
        "sku"=>$_GET['sku'],
        "name"=>$_GET['name_pro'],
        "quantity"=>$_GET['qual'],
        "color"=>$_GET['color'],
        )
    );
    $formattedData = json_encode($data,JSON_FORCE_OBJECT);
    $handle = fopen($filename,'w+');
    $cookie_name = 'order_cookies';
    $cookie_value = 'DES_'.$rand;
    setcookie($cookie_name, $cookie_value, time() + 86400, "/");
    setcookie('order_des', $cookie_value, time() + 86400, "/");
    //write the data into the file
    fwrite($handle,$formattedData);
    fclose($handle);
    setcookie('incart', $_GET['qual'], time() + 86400, "/");
} else {
    $f_isset = './tmp/'.$_COOKIE['order_des'].'.json';
    $formattedData_curr = file_get_contents($f_isset);
    $formattedData_get = json_decode($formattedData_curr,true);

    $check_id = array();
    for($u=0;$u<=count($formattedData_get);$u++) {
        $check_id[]= $formattedData_get[$u]['id'];
    }
    $se = array_search($_GET['proid'],$check_id);

    if($se > -1) {
        $cr = $formattedData_get[$se]['quantity'];
        $new = $cr + $_GET['qual'];
        $formattedData_get[$se]['quantity'] = $new;
    } else {
        $data =
        array(
            "id"=>$_GET['proid'],
            "sku"=>$_GET['sku'],
            "name"=>$_GET['name_pro'],
            "quantity"=>$_GET['qual'],
            "color"=>$_GET['color'],
        );
        array_push($formattedData_get,$data);
    }
    $formattedData = json_encode($formattedData_get,JSON_FORCE_OBJECT);
    $handle = fopen($f_isset,'w+');
    fwrite($handle,$formattedData);
    fclose($handle);
    $curr_cookie = $_COOKIE['incart'];
    $update_cookie = $curr_cookie + $_GET['qual'];
    setcookie('incart', $update_cookie, time() + 86400, "/");
}
?> 