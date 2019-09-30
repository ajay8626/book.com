
<?php
/**
* Template Name: Custom Product Page
*
*/
get_header(); 
 $des = "";
 wp_enqueue_script( 'twentyfifteen-fancybox', get_template_directory_uri().'/js/jquery.fancybox.js', array( 'jquery' ), '1.4', false );
 wp_enqueue_style( 'twentyfifteen-fancyboxcss', get_template_directory_uri().'/css/jquery.fancybox.css', array( 'twentyfifteen-style' ), '2.0' );
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $des = get_the_content(); ?>
<?php endwhile; endif; ?>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script> 
<script>
jQuery(document).ready(function($){
	$("#flipbookproduct").owlCarousel({ autoPlay : true,navigation : false,
		items: 1,
		itemsCustom: !1,
		itemsDesktop: [1199, 1],
		itemsDesktopSmall: [979, 1],
		itemsTablet: [768, 1],
		itemsTablet: [750, 1],
		itemsTabletSmall: [481,1],
		itemsMobile: [380, 1]
 	});

	
});
</script> 
<div class="innercnt">
	<div class="mtp">
		<div class="sliderwrap product-detail cusprod">
			<div class="left-slider">							
				<div class="flip_wrap">
					<div class="flipbook-bg">
						<div class="without_name">
						<?php if( have_rows('slider_image') ): ?>
						<div id="flipbookproduct" class="owl-carousel owl-theme">
						<?php  while ( have_rows('slider_image') ) : the_row(); if(empty(get_sub_field('images'))){ continue; } ?>
							<div class="slide">
								<a href="<?php the_sub_field('images'); ?>" class="fancybox1" rel="group"><img src="<?php the_sub_field('images'); ?>" alt=""></a>
							</div>	
						<?php endwhile; ?>
						</div>									
						<?php endif; ?>
						</div>
						<div class="with_name">
							<a id="imagepopup" href="<?php bloginfo('template_directory'); ?>/images/heightchartimage.jpg" class="fancybox" rel="group"><img id="heightimage" src="<?php bloginfo('template_directory'); ?>/images/heightchartimage.jpg" height="300" width="250" /></a>
						</div>
						<div id="wait" style="display:none;top:20%;left:40%;padding:2px;"><img src="<?php echo get_template_directory_uri(); ?>/images/gif/demo_wait.gif" width="64" height="64" /><br>Loading..</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<?php $productId = get_field('product_id');
		
		$product = wc_get_product( $productId );
		 
		// Now you have access to (see above)...
		 
		$product->get_type();
		$name = $product->get_name();
		/*$des = $product->get_description();*/

		$price = $product->get_price();
		$variations = $product->get_available_variations();
		$att = $product->get_attribute('pa_height-chart');
		$attributes['pa_height-chart']= explode(',', $att);
		$attribute_keys = array('pa_height-chart');
		add_filter( 'woocommerce_ajax_variation_threshold', 'wvs_ajax_variation_threshold', 8 );
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		//echo "<pre>"; print_r($attribute_keys);exit;
		

		 ?>
		
		<div class="rightcntlist heigth_chart_image">
			<h1><?php echo $name; ?></h1>
			<?php echo $des; ?>
			<div class="pricewrap">
				<!-- <div class="price">Rs- <?php echo $price; ?>/-</div> -->
				<?php

				$get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
      
		        wc_get_template( 'single-product/add-to-cart/variable.php', array(
		          'available_variations' => $get_variations ? $product->get_available_variations() : false,
		          'attributes'           => $product->get_variation_attributes(),
		          'selected_attributes'  => $product->get_default_attributes(),
		        ) );
				?>
			</div>
			<div id="upload-demo" style="width:350px"></div>
			<button class="btn btn-success upload-result">Upload Image</button>
		</div>
		<div class="commentlist">
			<ul>
				<?php
				if( have_rows('comments') ):
				$i=1;
				    while ( have_rows('comments') ) : the_row();
				?>
				    <li>
				        <p><h2><?php echo $i.". "; ?></h2><?php the_sub_field('comment'); ?></p>
				    </li>
				<?php  $i++; endwhile; endif; ?>   
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript"> 
	jQuery(document).ready(function($) { 
		$(".fancybox1").fancybox(); 
		$(".fancybox").fancybox(); 
	}); 
</script>
<?php get_footer(); ?> 
<style type="text/css">
	.quantity {
	    display: none !important;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($){

		$uploadCrop = jQuery('#upload-demo').croppie({
		    enableExif: true,
		    viewport: {
		        width: 500,
		        height: 500,
		        type: 'circle'
		    },
		    boundary: {
		        width: 550,
		        height: 550
		    }
		});
		$('input[name="upload_image"]').on('change', function () { 
			var reader = new FileReader();
		    reader.onload = function (e) {
		    	$uploadCrop.croppie('bind', {
		    		url: e.target.result
		    	}).then(function(){
		    		console.log('jQuery bind complete');
		    	});
		    	
		    }
		    reader.readAsDataURL(this.files[0]);
		    var files = this.files[0];
		    var filesname = files.name;
		    var filestype = files.type;

		});
		$('.upload-result').on('click', function (ev) {
			var kidsname = jQuery('input[name="name"]').val();
			$uploadCrop.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function (resp) {
				$.ajax({
					url: ajax_upload_image.ajax_url,
					type: "POST",
					data: {
						"action": 'upload_kids_image',
						"image":resp,
						"kidsname":kidsname},
					success: function (data) {
						html = '<img src="' + resp + '" />';
						$("#upload-demo-i").html(html);
					}
				});
			});
		});
		$('.with_name').hide();
		$('input.wccpf-field').attr('readonly', 'readonly').css('background', '#e3e3e3');
		$('input[name="upload_image"]').attr('id', 'file');
		$('input[name="upload_image"]').attr('disabled','disabled');
		$("input[name='attribute_pa_height-chart']").click(function() {
			if(this.value == 'height-chart-with-image'){
				$('.with_name').show();
				$('.without_name').hide();
				$('input.wccpf-field').removeAttr('readonly', 'readonly').css('background', '#fff');
				$('input[name="upload_image"]').removeAttr('disabled','disabled');
        		$('.wccpf-fields-container').css("display", "block");
			}else{
				$('.without_name').show();
				$('.with_name').hide();
				$('input.wccpf-field').attr('readonly', 'readonly').css('background', '#e3e3e3');
				$('input[name="upload_image"]').attr('disabled','disabled');
        		$('input.wccpf-field').val('');
			}
		});
		





	});
</script>