<?php
/**
* Template Name: Worksheet Subject List
*
*/
get_header();
 ?>
<div class="innercnt prbag worksheet_subject">
	<div class="mtp" style="background: #fff;">
		<h1>Worksheet Subject</h1>
	<div class="baglist">
		<?php
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'term_id',
						'terms'     => 27,
						//'include_children' => false	
					),
				),
				'posts_per_page' => -1
			);
		$kidsCates = new WP_Query( $args );
//echo "<pre>"; print_r($kidsCates);exit;
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
				$prodcaturl = get_permalink( '26774' );
			 ?>
			<div class="products-list">
			<div class="sliderwrap product-detail cusprod">
				<div class="left-slider">
					<div class="flip_wrap">
						<div class="flipbook-bg">
							<div class="slide">
								<?php //if($id == 27991) { ?>
								<a href="<?php echo $prodcaturl.$id; ?>" class="fancybox1" rel="group"><img src="<?php echo $prodcateimgurl; ?>" height="300" width="300" alt=""></a>
								<?php /* }else{ ?>
								<a href="javascript:void(0);" class="fancybox1" style="opacity: 0.5; cursor: not-allowed;" rel="group"><img src="<?php echo $prodcateimgurl; ?>" height="300" width="300" alt=""></a>
								<?php } */ ?>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="rightcntlist">
				<?php echo isset($description)?$description:""; ?>
				<div class="pricewrap">
					<!-- <div class="price">Rs- <?php //echo $price; ?>/-</div> -->
					<?php //if($id == 27991) { ?>
					<h1><a href="<?php echo $prodcaturl.$id; ?>" class="fancybox1" rel="group"><?php echo $name;  ?></a><br></h1>
						<div class="price">Rs- <?php echo $price; ?>/-</div>
						<div class="buybtn">
							<a href="<?php echo $prodcaturl.$id; ?>" class="button add_to_cart_button product_type_simple">Add To Cart</a>
						</div> 
					<?php /* }else{ ?>
							<h1><a href="javascript:void(0);" style="opacity: 0.5; cursor: not-allowed;" class="fancybox1" rel="group"><?php echo $name;  ?></a></h1>
						<div class="buybtn">
							<a href="javascript:void(0);" style="opacity: 0.5; cursor: not-allowed;" class="button add_to_cart_button product_type_simple">Out of Stock</a>
						</div> 
					<?php } */ ?>
				</div>
			</div>
			</div>
		<?php 
		endwhile;
		wp_reset_query();
	}

 ?>
	</div>
	</div>
	<div class="clear"></div>
</div>
<?php

get_footer(); ?>