<?php /* Template Name: Search */ ?>
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if(!$_COOKIE['login_cookies']) {    
	header('Location:'.APP_URL.'login');
}
include(APP_PATH."libs/head.php"); 
?>
</head>

<body id="users">
<div class="flexBox flexBox--between flexBox--wrap">
<?php include(APP_PATH."libs/sidebar.php"); ?>
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header.php"); ?>
<!--/Header-->


<div class="blockPage blockPage--full maxW">
    <div class="buttonBar">
        <a href="<?php echo APP_URL ?>add-supplies/"><i class="fa fa-user-plus" aria-hidden="true"></i>Thêm vật tư</a>
    </div>
    <h2 class="h2_page">Danh sách vật tư</h2>
        <table class="tblPage">
            <thead>
                <tr>
                    <td>Tên vật tư</td>
                    <td>Đơn vị tính</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $wp_query = new WP_Query();
                    $param = array (
                        'posts_per_page' => '-1',
                        'post_type' => 'supplies',
                        'post_status' => 'publish',
                        'order' => 'DESC',
                    );
                    $wp_query->query($param);
                    if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
                ?>
                <tr>
                    <td><?php the_title(); ?></td>
                    <td><?php the_field('unit') ?></td>
                </tr>
                <?php endwhile;endif;?>
            </tbody>
        </table>
    </div>


<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
</div>
<script>
    $(function(){
      // bind change event to select
      $('#selectBox').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
</body>
</html>	