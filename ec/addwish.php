<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php");
$idAdd = $_GET['proid'];
$color = $_GET['color'];
$action = $_GET['action'];
while(has_sub_field('wishlist',$_SESSION['idcustomer'])){
    $addList[] = array(
        'id' => get_sub_field('id'),
        'color' => get_sub_field('color'),
    );
}
$currWL = count($addList);

if($action=='add') {
    if($currWL==0) {
        $addList[] = array(
            'id' => $idAdd,
            'color' => $color,
        );
        update_field('wishlist', $addList, $_SESSION['idcustomer']);
    } else {
        $add_new = array();
        for($i=0;$i<$currWL;$i++) {
            $add_new[] = array(
                'id' => $addList[$i]['id'],
                'color' => $addList[$i]['color'],
            );
        }
        $add_new[] = array(
            'id' => $idAdd,
            'color' => $color,
        ); 
        update_field('wishlist', $add_new, $_SESSION['idcustomer']);
    }
} else {
    $search_id = array();
    $search_color = array();

    $wish = get_field('wishlist',$_SESSION['idcustomer']);
    $c_wish = count($wish);
    for($i=0;$i<$c_wish;$i++) {
        $search_id[]= $wish[$i]['id'];
        $search_color[]= $wish[$i]['color'];
    }
    
    $r = array_search($idAdd,$search_id);

    
    unset($search_id[$r]);
    unset($search_color[$r]);
    $after_id = array_values($search_id);
    $after_color = array_values($search_color);

    
    $run = count($search_id);
    $add_new = array();
    for($i=0;$i<$run;$i++) {
        $add_new[] = array(
            'id' => $after_id[$i],
            'color' => $after_color[$i],
        );
    }
    update_field('wishlist', $add_new, $_SESSION['idcustomer']);
}
?>