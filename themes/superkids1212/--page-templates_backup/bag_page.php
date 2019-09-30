<?php
/**
* Template Name: Bag Page
*
*/
get_header(); ?>

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
		<!-- <div class="sliderwrap product-detail cusprod">
			<div class="left-slider">							
				<div class="flip_wrap">
					<div class="flipbook-bg">
						<div id="flipbookproduct" class="owl-carousel owl-theme">
							<div class="slide">
								<a href="<?php the_sub_field('images'); ?>" class="fancybox1" rel="group"><img src="<?php the_sub_field('images'); ?>" alt=""></a>
							</div>	
						</div>					
					</div>
				</div>
			</div>
		</div> -->
		
<?php 
$args = array(
		'post_type' => 'product',
		'orderby'   => 'title',
		'tax_query' => array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'id',
				'terms'     => 20
			),
		),
		'posts_per_page' => -1
	);
$kidsCates = new WP_Query( $args );
//echo "<pre>";
//print_r($kidsCates->posts);

if ($kidsCates->have_posts()) {


	while ($kidsCates->have_posts()) :
		
		$kidsCates->the_post();
					
		$kidsproduct = get_product( $kidsCates->post->ID );
		$kidsproduct->get_type();
		$name = $kidsproduct->get_name();
		$des = $kidsproduct->get_description();
		$price = $kidsproduct->get_price();
		$prodcateimgurl = get_the_post_thumbnail_url( $kidsproduct->get_id(), 'medium' );
		//echo $prodcaturl = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$prodcaturl = get_permalink(22630 );
		?>
		<div class="slide">
			<a href="<?php echo $prodcateimgurl; ?>" class="fancybox1" rel="group"><img src="<?php echo $prodcateimgurl; ?>" height="300" width="300" alt=""></a>
		</div>
		<div class="rightcntlist">
			<h1><?php echo $name; ?></h1>
			<?php echo $des; ?>
			<div class="pricewrap">
				<div class="price">Rs- <?php echo $price; ?>/-</div>
					<div class="buybtn">
					<a href="<?php echo $prodcaturl; ?>" rel="nofollow" data-product_id="<?php echo $productId->ID; ?>" data-product_sku="" class="button add_to_cart_button product_type_simple">Buy now</a> 
					</div>
				</div>	
			</div>
		<?php
	
	endwhile;
	wp_reset_query();				    

}

 ?>

</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>