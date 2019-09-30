<?php
/**
* Template Name: Product Page
*
*/
get_header(); 
?>
<div class="innercnt">
				<div class="mtp" style="background: #fff;">
		<?php if( have_rows('products') ): ?>
			<?php while ( have_rows('products') ) : the_row(); ?>
					<?php 
					
					$productId = get_sub_field('product_object');
					$product = wc_get_product( $productId );
					$name = $product->get_title();
					$id = $product->get_id();
					$description = $product->get_description();
					$price = $product->get_price();
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $productId ), 'single-post-thumbnail' );
					?>    
					<div class="products-list">
					<div class="sliderwrap product-detail cusprod">
						<div class="left-slider">
							<div class="flip_wrap">
								<div class="flipbook-bg">
									<div class="slide">
										<a href="<?php echo get_sub_field('product_link'); ?>"><img src="<?php  echo $image[0]; ?>" data-id="<?php echo $loop->post->ID; ?>"></a>
									</div>
								</div>
							</div>
						</div>
					</div>			
					<div class="rightcntlist">
						<h1><a href="<?php echo get_sub_field('product_link'); ?>"><?php echo $name;  ?></a></h1>
						<?php echo $description; ?>
						<div class="pricewrap">
							<div class="price">Rs- <?php echo $price; ?>/-</div>
							<!-- <div class="buybtn">
								<a href="<?php //echo get_sub_field('product_link'); ?>" data-product_sku="" class="button add_to_cart_button product_type_simple">Buy now</a>
							</div> -->
							<?php if($id == 24597) { ?>
								<div class="buybtn">
								<a href="<?php echo get_sub_field('product_link'); ?>" data-product_sku="" class="button add_to_cart_button select_bags product_type_simple">Select Bags</a>
							</div>
							<?php }else { ?>
								<div class="buybtn">
								<a href="<?php echo get_sub_field('product_link'); ?>" data-product_sku="" class="button add_to_cart_button product_type_simple">Buy now</a>
							</div>
							<?php } ?>
							
						</div>
					</div>
					</div>
			<?php endwhile; ?>
		<?php endif; ?>
				</div>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>