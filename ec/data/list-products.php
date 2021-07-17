<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(LOAD_PATH . "/wp-load.php");
$parent_cate = $_GET['parent'];
$offset = $_GET['offset'];
$category = $_GET['category'];
$sort = $_GET['sort'];
$lang_web = $_GET['lang'];
?>
<?php
    $wp_query = new WP_Query();
    if($category) {
        if($sort != '') {
            $param=array(
                'post_type'=>'product',
                'post_status' => 'publish',
                'meta_key'  => 'price',
                'orderby'	=> 'meta_value',
                'order' => $sort,
                'posts_per_page' => '16',
                'offset' => $offset,
                'tax_query' => array(
                    array(
                    'taxonomy' => 'productcat',
                    'field' => 'slug',
                    'terms' => $category
                    )
                )
            );
        } else {
            $param=array(
                'post_type'=>'product',
                'post_status' => 'publish',
                'posts_per_page' => '16',
                'offset' => $offset,
                'tax_query' => array(
                    array(
                    'taxonomy' => 'productcat',
                    'field' => 'slug',
                    'terms' => $category
                    )
                )
            );
        }
        
    } else {
        if($sort != '') {
            $param = array (
                'posts_per_page' => '-16',
                'post_type' => 'product',
                'post_status' => 'publish',
                'meta_key'  => 'price',
                'orderby'	=> 'meta_value',
                'order' => $sort,
                'offset' => $offset
            );
        } else {
            $param = array (
                'posts_per_page' => '16',
                'post_type' => 'product',
                'post_status' => 'publish',
                'order' => 'ASC',
                'offset' => $offset
            );
        }
    }
    
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
