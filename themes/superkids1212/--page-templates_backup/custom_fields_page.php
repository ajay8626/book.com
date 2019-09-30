<?php
/**
* Template Name: Custom Fields Page
*
*/
session_start();
//echo "<pre>"; print_r($_SESSION); exit;
if(($_SESSION['sess_bookusername'] !='') && ($_SESSION['sess_bookusergender'] !='')){
	session_unset($_SESSION['sess_bookusername']);
	session_unset($_SESSION['sess_bookusergender']);
	session_unset($_SESSION['sess_kids_dob']);
}
get_header(); ?>

<?php

error_reporting(0);

if(isset($_SESSION['sess_bagusername']) && $_SESSION['sess_bagusername'] != $skids_name){
	$_SESSION['sess_bagusername'] = $skids_name;
}

if(isset($_SESSION['sess_bagusergender']) && $_SESSION['sess_bagusergender'] != $skids_gender){
	$_SESSION['sess_bagusergender'] = $skids_gender;
}


if(isset($_REQUEST['skids_name']) && $_REQUEST['skids_name'] != '' && isset($_REQUEST['skids_gender']) && $_REQUEST['skids_gender'] != '')
{
	$kids_name=$_REQUEST['skids_name'];
	$gender=$_REQUEST['skids_gender'];

	/*$kidsurl = site_url().'/checkout/'.'?skids_name='.$kids_name.'&skids_gender='.$gender;
	wp_redirect($kidsurl);die();*/

}
?>

<?php
$category_link = get_category_link( $category_id );
$pageId =$_SERVER['REQUEST_URI'];
$pageId= explode('/', $pageId);
$id = $pageId[3];
$product = wc_get_product( $id );
$title = $product->get_title();
$price = $product->get_price_html();
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
$bagkidsname = $_REQUEST['skids_name'];
$bagkidsgender = $_REQUEST['skids_gender'];


?>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script> 

<div class="innercnt">
	<div class="mtp">
		<div class="sliderwrap product-detail cusprod">
			<div class="left-slider">							
				<div class="flip_wrap">
					<div class="flipbook-bg">
						<?php
						//var_dump(have_rows('slider_image', $id));
						if( have_rows('slider_image', $id) ): ?>
						<div id="flipbookproduct" class="owl-carousel owl-theme">
							<?php  while ( have_rows('slider_image', $id) ) : the_row(); if(empty(get_sub_field('images'))){ continue; } ?>
							<div class="slide">
								<a href="<?php  the_sub_field('images');; ?>" class="fancybox1" rel="group"><img src="<?php   the_sub_field('images');; ?>" alt=""></a>
							</div>
							<?php endwhile; ?>
						</div>									
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<form method="POST" name="bagsproduct" id="bagsproduct">
			<div class="rightcntlist">
			<h1><?php echo $title; ?></h1>
			<?php echo $des; ?>
			<div class="pricewrap">
				<div class="price"><?php echo $price; ?>/-</div>
				<div class="clear"></div>
				<div class="inputbox">
					<input type="text" value="" placeholder="Enter kid’s name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter kid’s name'" class="fname" name="skids_name" id="fnameid" maxlength="14">
				</div>
				<div class="kids_gender">
					<label class="active"><input type="radio" name="skids_gender" value="Boy" class="rd_btn" checked="checked">Boy</label>
					<label class="grl"><input type="radio" name="skids_gender" value="Girl" class="rd_btn">Girl</label>
					<input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>">
				</div>
			<div class="buybtn">
				<a href="javascript:void(0);"  rel="nofollow" data-product_id="<?php echo $id; ?>" data-product_sku="" class="button add_to_cart_button bag_list product_type_simple">Buy Now</a>
			</div>
		</div>
	</div>
</form>
</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>
<script>
jQuery(document).ready(function($){

	jQuery(".bag_list").on("click", function(e){
		e.preventDefault();
		var name = $("#fnameid").val();
		var gender = $("input[name='skids_gender']:checked").val();
		var pid = $("#pid").val();
		jQuery.ajax({
            type: 'post',
            url: ajax_kids_name.ajax_url,
            data: {
                action: 'load_kidsbags',
                name: name,
                gender:gender,
                pid:pid
            },
            dataType:'json',
            success:function(response){

            	$('#bagsproduct').trigger("reset");            	

            	if(response!=0){

            		window.location = "<?php echo $kidsurl = site_url().'/checkout'; ?>";
            	}
              
            }
        });

	});

});

</script>