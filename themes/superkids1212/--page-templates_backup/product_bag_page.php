<?php
/**
* Template Name: bag Product Page
*
*/
get_header(); 

?>
<div class="innercnt">
	<div class="mtp" style="background: #fff;">
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
		if ($kidsCates->have_posts()) {
			while ($kidsCates->have_posts()) :
				$kidsCates->the_post();
				$kidsproduct = get_product( $kidsCates->post->ID );
				$id = $kidsproduct->get_id(); 
				$kidsproduct->get_type();
				$name = $kidsproduct->get_name();
				$nameurl = strtolower(str_replace(' ', '-', $name));
				$des = $kidsproduct->get_description();
				$price = $kidsproduct->get_price();
				$prodcateimgurl = get_the_post_thumbnail_url( $kidsproduct->get_id(), 'medium' );
				//echo $prodcaturl = get_permalink( woocommerce_get_page_id( 'shop' ) );
				$prodcaturl = get_permalink( '22630' );
				?>  
			<div class="products-list">
			<div class="sliderwrap product-detail cusprod">
				<div class="left-slider">
					<div class="flip_wrap">
						<div class="flipbook-bg">
							<div class="slide">
								<a href="<?php echo $prodcateimgurl; ?>" class="fancybox1" rel="group"><img src="<?php echo $prodcateimgurl; ?>" height="300" width="300" alt=""></a>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="rightcntlist">
				<h1><?php echo $name;  ?></h1>
				<?php echo $description; ?>
				<div class="pricewrap">
					<div class="price">Rs- <?php echo $price; ?>/-</div>
					<div class="buybtn">
						<a href="<?php echo $prodcaturl.$id; ?>" data-product_sku="" class="button add_to_cart_button product_type_simple">Buy now</a>
					</div> 
					
					
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