<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php");
$design = $_POST['ssValue'];
$price = $_POST['ssPrice'];
while(has_sub_field('design',$_SESSION['idcustomer'])){
    $addList[] = array(
        'id' => get_sub_field('id'),
        'price' => get_sub_field('price'),
    );
}
$currWL = count($addList);

if($currWL==0) {
    $addList[] = array(
        'id' => $design,
        'price'=> $price
    );
    update_field('design', $addList, $_SESSION['idcustomer']);
} else {
    $add_new = array();
    for($i=0;$i<$currWL;$i++) {
        $add_new[] = array(
            'id' => $addList[$i]['id'],
            'price' => $addList[$i]['price'],
        );
    }
    $add_new[] = array(
        'id' => $design,
        'price'=> $price
    ); 
    update_field('design', $add_new, $_SESSION['idcustomer']);
}
?>