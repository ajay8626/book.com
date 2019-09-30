<?php
/**
* Template Name: bag listing Page
*
*/
get_header();
 ?>
<div class="innercnt prbag">
	<div class="mtp" style="background: #fff;">
		<h1>Bags</h1>
	<div class="baglist">
		<?php 
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'id',
						'terms'     => 18
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
				$prodcaturl = get_permalink( '23659' );
				?>  
			<div class="products-list">
			<div class="sliderwrap product-detail cusprod">
				<div class="left-slider">
					<div class="flip_wrap">
						<div class="flipbook-bg">
							<div class="slide">
								<a href="<?php echo $prodcaturl.$id; ?>" class="fancybox1" rel="group"><img src="<?php echo $prodcateimgurl; ?>" height="300" width="300" alt=""></a>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="rightcntlist">
				<h1><a href="<?php echo $prodcaturl.$id; ?>" class="fancybox1" rel="group"><?php echo $name;  ?></a></h1>
				<?php //echo $description; ?>
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
	</div>
	<div class="clear"></div>
</div>
<?php


if(isset($_REQUEST['c']) && $_REQUEST['c'] != "" ){
	global $wpdb;
	
	$bcode = $_REQUEST['c'];
	$_SESSION['bags_visitor'] = $bcode;
	$message = "Hi, <br><br> Unique Code : $bcode <br>";


	$subject = "Bags Visitor - $bcode";
	$loc_email = "orders@superkidsleague.com";
	$headers = "From: Skids <asingh@skids.in> \r\n" . 
			"Content-type: text/html; charset=UTF-8 \r\n"; 
	$ok = wp_mail($loc_email, $subject, $message, $headers);
}



get_footer(); ?>