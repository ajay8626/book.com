<?php
/**
* Template Name: Kids Class List
*
*/
get_header();
 ?>
<div class="innercnt prbag">
	<div class="mtp" style="background: #fff;">
		<h1>Kid's Worksheet</h1>
	<div class="baglist">
		<?php 
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'id',
						'terms'     => 27
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
				$prodcaturl = get_permalink( '25578' );
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
				<?php echo isset($des)?$des:""; ?>
				<div class="pricewrap">
					<!-- <div class="price">Rs- <?php //echo $price; ?>/-</div> -->
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
/*if(isset($_REQUEST['c']) && $_REQUEST['c'] != "" ){
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