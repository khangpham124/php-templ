<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(LOAD_PATH . "/wp-load.php");
if(!isset($_COOKIE['lang_web'])) {
	$lang_web = 'en';
} else {
	$lang_web = $_COOKIE['lang_web'];
}
$size = explode(',',$_GET['size']);
$color = explode(',',$_GET['color']);
$gender = explode(',',$_GET['gender']);
$effect = explode(',',$_GET['effect']);
$type = explode(',',$_GET['type']);
$base = explode(',',$_GET['base']);
$category = explode(',',$_GET['category']);

$query =  Array();
for($i=0;$i < count($size);$i++) {
    array_push($query,
    array(
        'key'	 	=> 'size_item',
        'value'	  	=> $size[$i],
        'compare' 	=> 'LIKE',
    )
    );
}

$meta_query = array (
    'relation'		=> 'OR',
    array(
        'key'	 	=> 'color',
        'value'	  	=> $color,
        'compare' 	=> 'IN',
    ),
    array(
        'key'	 	=> 'for_whom',
        'value'	  	=> $gender,
        'compare' 	=> 'IN',
    ),
    array(
        'key'	 	=> 'effect',
        'value'	  	=> $effect,
        'compare' 	=> 'IN',
    ),
    array(
        'key'	 	=> 'type',
        'value'	  	=> $type,
        'compare' 	=> 'IN',
    ),
    array(
        'key'	 	=> 'base',
        'value'	  	=> $base,
        'compare' 	=> 'IN',
    ),
);

if($_GET['size']!='') {
    array_push($meta_query,$query);
}


    $wp_query = new WP_Query();
    if($category=='') {
        $param=array(
            'post_type'=>'product',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby'=>'post_date',
            'posts_per_page' => '-1',
            'meta_query'	=> $meta_query,    
        );
    } else {
        $param=array(
            'post_type'=>'product',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby'=>'post_date',
            'posts_per_page' => '-1',
            'meta_query'	=> $meta_query,
            'tax_query' => array(
                array(
                'taxonomy' => 'productcat',
                'field' => 'slug',
                'terms' => $category
                )
            )
        );
    }
    ?>
<?php
    $wp_query->query($param);
    if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
    $thumbImg = get_post_thumbnail_id($post->ID);
    $thumb_img = get_post_thumbnail_id($post->ID);
    $thumb_url = wp_get_attachment_image_src($thumb_img,'full');    
    $title_en =  $post->post_title;
    $title_vn = get_field('name_product_vn');       
?> 

<li class="grid--25 <?php the_ID(); ?> grid__mb--50 padding--5">
     <div class="list-products-thumb">
     <p><a href="<?php the_permalink(); ?>"><img src="<?php echo thumbCrop($thumb_url[0],600,900); ?>"></a></p>
     </div>
     <p class="list-products-name"><a href="<?php the_permalink(); ?>"><?php echo ${'title_'.$lang_web}; ?></a></p>
     <p class="list-products-price"><?php echo number_format(get_field('price')); ?> Đ</p>
 </li>
 <?php endwhile;endif; ?>
