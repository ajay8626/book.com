<?php
/**
* Template Name: Kids Books List
*
*/
get_header();
 ?>
<div class="innercnt prbag">
	<div class="mtp" style="background: #fff;">
		<h1>Kid's Worksheet</h1>
	<div class="baglist">
		<?php 
			$order = 'asc';
		$hide_empty = false ;
		$cat_args = array(
		    'order'      => $order,
		    'hide_empty' => $hide_empty,
		    'parent'	 => 27
		);
		 
		$subcategories = get_terms( 'product_cat', $cat_args );   
		if (!empty($subcategories)) {
			foreach ($subcategories as $key => $value) {
				//echo "<pre>"; print_r($value);exit;
			 	global $wp_query;
				$cat = $wp_query->get_queried_object();
				$thumbnail_id = get_woocommerce_term_meta( $value->term_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id ); 
				$name = $value->name;
				$prodcaturl = get_permalink( '26727' );
				$id = $value->term_id;
			 ?>
			 
			<div class="products-list">
			<div class="sliderwrap product-detail cusprod">
				<div class="left-slider">
					<div class="flip_wrap">
						<div class="flipbook-bg">
							<div class="slide">
								<?php if($id == 27) { ?>
								<a href="<?php echo $prodcaturl.$id; ?>" class="fancybox1" rel="group"><img src="<?php echo $image; ?>" height="300" width="300" alt=""></a>
								<?php }else{ ?>
								<a href="javascript:void(0);" class="fancybox1" style="opacity: 0.5; cursor: not-allowed;" rel="group"><img src="<?php echo $image; ?>" height="300" width="300" alt=""></a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="rightcntlist">
				
				<?php echo isset($description)?$description:""; ?>
				<div class="pricewrap">
					<!-- <div class="price">Rs- <?php //echo $price; ?>/-</div> -->
					<?php if($id == 27) { ?>
					<h1><a href="<?php echo $prodcaturl.$id; ?>" class="fancybox1" rel="group"><?php echo $name;  ?></a></h1>
						<div class="buybtn">
							<a href="<?php echo $prodcaturl.$id; ?>" class="button add_to_cart_button product_type_simple">Add To Cart</a>
						</div> 
					<?php }else{ ?>
							<h1><a href="javascript:void(0);" style="opacity: 0.5; cursor: not-allowed;" class="fancybox1" rel="group"><?php echo $name;  ?></a></h1>
						<div class="buybtn">
							<a href="javascript:void(0);" style="opacity: 0.5; cursor: not-allowed;" class="button add_to_cart_button product_type_simple">Out of Stock</a>
						</div> 
					<?php } ?>
				</div>
			</div>
			</div>
		<?php }
		wp_reset_query();
	}

 ?>
	</div>
	</div>
	<div class="clear"></div>
</div>
<?php
get_footer(); ?>