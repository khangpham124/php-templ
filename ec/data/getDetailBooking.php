<?php
include($_SERVER["DOCUMENT_ROOT"] . "/projects/rapha-tea/app_config.php");
include(LOAD_PATH."/wp-load.php");

$postID = $_POST['postID'];
$args = array(
'p' => $postID, // p -> id of post
'post_type' => 'booking',
'post_status' => 'publish',
'posts_per_page' => 1,
'caller_get_posts' => 1
);
$wp_query = null;
$wp_query = new WP_Query($args);

if($wp_query->have_posts()): $wp_query->the_post();
?>
<table class="table-page mt--30" id="tableUpdate" data-action-update="<?php echo APP_URL; ?>data/editBooking.php">
    <?php 
    $i=0;
    $numberOder =  count(get_field(order_detail));
    while(has_sub_field('order_detail')):
    ?>
    <tr>
        
        <td><input class="input-page" type="text" disabled id="prod_name_<?php echo $i; ?>" name="name_pro_<?php echo $i; ?>" value="<?php echo get_sub_field('name_pro') ?>" ></td>
        <td>
            <input class="input-page js-input-update" type="number" id="prod_quan_<?php echo $i; ?>" name="quantity_<?php echo $i; ?>" value="<?php echo get_sub_field('quantity') ?>" >
            <input type="hidden" id="prod_price_<?php echo $i; ?>" name="prod_price_<?php echo $i; ?>" value="<?php echo get_sub_field('price') ?>">
        </td>
    </tr>
    <?php $i++; endwhile; ?>
    <tr>
        <td colspan="2">
            <a href="javascript:void(0)" class="btn-page--outline js-close-popup">Cancel</a>
            <a href="javascript:void(0)" data-update="<?php echo $post->ID; ?>" class="btn-page js-update-booking disable">Update</a>
        </td>
    </tr>
    <input type="hidden" value="<?php echo $numberOder ?>" id="numberOder">
    <input type="hidden" value="<?php echo $numberOder ?>" id="numberOder">
</table>
<?php endif; ?>

<script>
    $( ".js-input-update" ).keyup(function() {
        let valChange = $(this).val();
        if((valChange > 0)&&(valChange!='')) {
            $('.js-update-booking').removeClass('disable');
        } else {
            $('.js-update-booking').addClass('disable');
        }
    });

    $('.js-update-booking').click(function() {
        var isThis = $(this);
        isThis.html('<i class="fa fa-spinner fa-spin"></i> Updating...');
        
        var urlUpdateBooking = $('#tableUpdate').attr('data-action-update'); 
        var idBooking = isThis.attr('data-update'); 
        var last_update = $('#last_update').val(); 
        var numberOder = $('#numberOder').val(); 

        var bodyFormData = new FormData();
        bodyFormData.append("idBooking", idBooking );
        bodyFormData.append("last_update", last_update );
        bodyFormData.append("numberOder", numberOder );

        for(var i = 0;i<numberOder;i++) {
            let name_pro = $(`#prod_name_${i}`).val(); 
            let quantity = $(`#prod_quan_${i}`).val(); 
            let price = $(`#prod_price_${i}`).val(); 
            bodyFormData.append('prod_name_' + i , name_pro );
            bodyFormData.append('prod_quan_' + i , quantity );
            bodyFormData.append('prod_price_' +i , price );
        }

        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            data: bodyFormData,
            url: urlUpdateBooking
        };
        axios(options).then(function (response) {
            setTimeout(function(){
                location.reload();
        }, 500);
        });
    });



$('.js-close-popup').click(function() {
    $('.popup').fadeOut(20);
    $('.overlay').fadeOut(20);
});

$('.overlay').click(function() {
    $('.popup').fadeOut(20);
    $(this).fadeOut(20);
});
</script>