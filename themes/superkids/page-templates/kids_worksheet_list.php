<?php
/**
* Template Name: Kids Worksheet List
*
*/
get_header();
 ?>
<div class="innercnt prbag">
	<div class="mtp" style="background: #fff;">
		<h1>Kid's Worksheet</h1>
	<div class="baglist">
		<?php 
		$defaulImage = get_template_directory_uri().'/images/NoBookCover.jpg';
		$url = $_SERVER['REQUEST_URI'];
		$pageurl = explode('/', $url);
		$pageId = $pageurl[3];
		//echo "<pre>";print_r($pageurl);exit;
		$args = array(
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'id',
					'terms'     => $pageId
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
				$prodcaturl = get_permalink( '25578' );
				//echo "<pre>";print_r($prodcaturl);exit;
				
				$sort_desc = get_field('short_description', $id);
				
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
				<?php echo isset($description)?$description:""; ?>
				<div class="pricewrap">
					<div class="sort_desc"><?php echo $sort_desc; ?></div>
					<div class="price">Rs- <?php echo $price; ?>/-</div>
					<div class="buybtn">
						<a href="<?php echo $prodcaturl.$id; ?>" data-product_sku="" class="button add_to_cart_button product_type_simple">Add to Cart</a>
					</div> 
				</div>
			</div>
			</div>
		<?php
		endwhile;
		wp_reset_query();
	}else{ ?>
		<!-- <div class="products-list defaulImage">
			<div class="sliderwrap product-detail cusprod">
				<div class="left-slider">
					<div class="flip_wrap">
						<div class="flipbook-bg">
							<div class="slide">
								<img src="<?php echo $defaulImage; ?>" height="300" width="300" alt="">
								<p class="title">Out of Stock</p>
								<div class="overlay"></div>
  								<div class="button"><a href="#"> BUTTON </a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<div class="container">
			<img src="<?php echo $defaulImage; ?>" height="300" width="300" alt="">
			<p>Out of Stock</p>
			<div class="middle">
		    	<button class="text notify_me" data-popup-open="popup-1">Notify Me</button>

		  	</div>
		</div>
<?php	}

 ?>
	</div>
	</div>
	<div class="clear"></div>
</div>
<?php

/*
if(isset($_REQUEST['c']) && $_REQUEST['c'] != "" ){
	global $wpdb;
	
	$bcode = $_REQUEST['c'];
	$_SESSION['bags_visitor'] = $bcode;
	$message = "Hi, <br><br> Unique Code : $bcode <br>";

	include_once("class.phpmailer.php");

	$Host = get_option('smtp_hostname');
	$Username = get_option('smtp_username');
	$Password = get_option('smtp_password');
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = $Host;
	$mail->Username = $Username;
	$mail->Password = $Password;
	$mail->SMTPAuth = true;
	$mail->Debug = true;
	$mail->From = 'asingh@skids.in';
	$mail->FromName = "Skids";
	$mail->IsHTML(true);
	$loc_email = 'harsh@skids.in';
	$mail->AddAddress($loc_email);
	$mail->Subject = "Bags Visitor - $bcode";
	$mail->Body = $message;
	$ok=$mail->Send();

}*/



get_footer(); ?>

<style type="text/css">
	.container {
  position: relative;
  width: 50%;
}

.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  /*transition: .5s ease;
  backface-visibility: hidden;*/
}

.middle {
  /*transition: .5s ease;*/
  opacity: 0;
  position: absolute;
  top: 35%;
  left: 20%;
  /*transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);*/
  text-align: center;
}

.container:hover .image {
  opacity: 0.3;
}

.container:hover .middle {
  opacity: 1;
}

.text {
  background-color: #4CAF50;
  color: white;
  font-size: 16px;
  padding: 16px 32px;
}
</style>