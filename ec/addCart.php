<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/app_config.php');
include(APP_PATH . '/hod/wp-load.php');
echo $id_pro = $_GET['addtocart']
?>
<h3 class="h3_popup f_lapresse">CART</h3>

<table class="tblCart">
    <thead>
        <td class="detailPro">PRODUCTS</td>
        <td>PRICE</td>
        <td>QTY</td>
        <td>SUBTOTAL</td>
    </thead>    
    <tbody>
        <?php    
        $wp_query = new WP_Query();
        $param=array(
        'post_type' => array( 'shop', 'food','bottles'),
        'posts_per_page' => '-1',
        'p'=> $id_pro
        );
        $wp_query->query($param);
        if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
            $thumb = get_post_thumbnail_id($post->ID);
            $img_label = wp_get_attachment_image_src($thumb,'full');
            $img_cup = wp_get_attachment_image_src(get_field('image_beer'),'full');
            $post_t = get_post_type();
        ?>
        <tr>
        <td class="detailPro">
            <div class="clearfix">
                <p class="thumbPro_tab"><img src="<?php echo thumbCrop($img_label[0],70,70) ?>" alt=""></p>
                <div class="descPro_tab">
                    <p class="title"><?php the_title(); ?></p>
                    <p class="sku"><?php the_field('cf_sku'); ?></p>
                    <span class="removeItem" data-id="cart_<?php echo $post_t; ?>_<?php echo $post->ID; ?>">Remove</span>
                </div>
            </div>
            
        </td>
        <td><p class="pricePro"><input type="text" readonly class="priceNumb" value="<?php echo $cost = get_field('cf_price'); ?>"></p></td>
        <td>
            <div class="qtyPro">
            <div class="numbers-row clearfix">
                <div class='inc button cal' rel='+' ><i class="fa fa-caret-up" aria-hidden="true"></i></div>
                <div class='dec button cal' id='dec'><i class="fa fa-caret-down" aria-hidden="true"></i></div>
                <input type="text" id="<?php echo 'cart_'.$post_t.'_'.$post->ID; ?>"  class="input_cal qtyNumb" readonly  value="<?php echo  $curr_wty = $_COOKIE['cart_'.$post_t.'_'.$post->ID]; ?>"> 
            </div>
            </div>
        </td>
        <td><p class="subTotal"><input type="number" readonly class="totalNumb" value="<?php echo $total_curr = $cost * $curr_wty; ?>" alt=""></p></td>
        </tr>    
        <?php endwhile;endif; ?>
    </tbody>    
    </table>

<p class="taR_popup">
    <a href="javascript:void(0)" class="contBtn">continue shopping</a>
    <a href="javascript:void(0)" class="updateBtn">Update Cart</a>
    <a href="<?php echo APP_URL; ?>checkout" class="checkOut" >Checkout</a>
</p>

<span class="closeBtn"><i class="fa fa-times" aria-hidden="true"></i></span>