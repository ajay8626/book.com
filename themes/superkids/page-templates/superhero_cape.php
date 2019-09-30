<?php
/**
* Template Name: superhero cape page
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
				</div>
			</div>
		</div>
		
		<?php 
		$productId = get_field('product_id');
		$product = wc_get_product( $productId );
		//echo "<pre>"; print_r($productId->ID);exit;
		 
		// Now you have access to (see above)...
		 
		$product->get_type();
		$name = $product->get_name();
		/*$des = $product->get_description();*/

		$price = $product->get_price();
		//echo $des; exit();

		 ?>
		
		<div class="rightcntlist">
			<h1><?php echo $name; ?></h1>
			<?php echo $des; ?>
			<div class="pricewrap">
				<div class="price">Rs- <?php echo $price; ?>/-</div>
				<div class="buybtn">
					<a href="<?php echo home_url('/'); ?>gift-for-you/?add-to-cart=<?php echo $productId->ID; ?>" rel="nofollow" data-product_id="<?php echo $productId->ID; ?>" data-product_sku="" class="button add_to_cart_button product_type_simple">Buy now</a>
				</div>

			</div>
		</div>
		<div class="commentlist">
			<ul>
				<?php
				if( have_rows('comments') ):
				$i=1;
				    while ( have_rows('comments') ) : the_row();
				?>
				<li><h2><?php echo $i.". "; ?></h2></li>
				    <li>
				        <p><?php the_sub_field('comment'); ?></p>
				    </li>
				<?php  $i++; endwhile; endif; ?>   
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript"> jQuery(document).ready(function($) { $(".fancybox1").fancybox(); }); </script>
<?php get_footer(); ?> 