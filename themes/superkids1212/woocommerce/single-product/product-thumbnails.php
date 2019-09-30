<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

if(isset($_REQUEST['bu_name'])){
	$bu_name = $_REQUEST['bu_name'];
}elseif(get_query_var('bname') != ''){
	$bu_name = get_query_var('bname');
}else{
	$bu_name = '';
}
if(isset($_REQUEST['bu_gender'])){
	$bu_gender = $_REQUEST['bu_gender'];
}elseif(get_query_var('bgender') != ''){
	$bgender = get_query_var('bgender');
	$bu_gender = 'Boy';
	if($bgender == 'G' || $bgender == 'g'){
		$bu_gender = 'Girl';
	}
}else{
	$bu_gender = '';
}

$attachment_ids = $product->get_gallery_image_ids();
if($bu_name == '' && $bu_gender == ''){

/*if ( $attachment_ids && has_post_thumbnail() ) {
	foreach ( $attachment_ids as $attachment_id ) {
		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$image_title     = get_post_field( 'post_excerpt', $attachment_id );

		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
		$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
 		$html .= '</a></div>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}
}*/  ?>
<?php 
					$err = 0;
					$result = array();
					$characterset = array();
					if($bu_name != ''){
						global $wpdb;
						$bu_gender = $bu_gender != '' ?$bu_gender:'Boy';
						$gender = 0;
						if($bu_gender == 'Girl' || $bu_gender == 'girl'){
							$gender = 1;
						}
						$bu_name_str = $bu_name;
						$bu_name_arr = str_split(strtoupper($bu_name_str));
						$bu_name= implode("','",$bu_name_arr);
						$sql = "SELECT * FROM `wp_book_virtue` WHERE alphabet IN ('$bu_name') AND gender = '$gender' ORDER BY priority, FIELD(alphabet, '$bu_name')";
						$result = $wpdb->get_results($sql);
						if(!empty($result)){
							foreach($result as $res){
								$characterset[$res->alphabet][$res->priority] = $res->id;
							}
						}						
						$result = array();
						$priority = array();
						foreach($bu_name_arr as $bun){
							if(!isset($priority[$bun])){
								$occ = 1;
							}else{
								$occ = $priority[$bun] + 1;
								$total = count($characterset[$bun]);
								if($occ > $total)
									$occ = 1;
									$err = 1;
							}
							$priority[$bun] = $occ;
							$resultval = $characterset[$bun][$occ];
							$result[] = $resultval;
						}
						if(empty($resultval)){
							$err = 1;
						}
					}
				?>	
<div class="sliderwrap product-detail">
	<div class="left-slider">
		<div id="demo">
			<div class="container">
				<div class="row">
					<div class="span12">
						<?php 
						if(!empty($result) && $err == 0){ ?>
							<?php 
								$sql = "SELECT image,virtue FROM `wp_book_virtue` WHERE id = $result[0]";
								$resVirtue = $wpdb->get_results($sql);
								foreach($resVirtue as $virtue){ ?>
									<span class="zoombig">
										<a id="Zoomer" href="<?php echo $virtue->image; ?>" class="MagicZoomPlus Selector" rel="show-title: bottom; selectors-class: Active;" title="<?php echo $virtue->virtue; ?>" rev="<?php echo $virtue->image; ?>">
										<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" /> </a> 
									</span>
								<?php } ?>
						<?php }else{ 
								if ( has_post_thumbnail() ) { ?>									
									<span class="zoombig">
										<a id="Zoomer" href="<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>" class="MagicZoomPlus Selector" rel="show-title: bottom; selectors-class: Active;" title="" rev="<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>">
										<img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>" alt="" /> </a> 
									</span>
								<?php } else { ?>
								<span class="zoombig">
										<a id="Zoomer" href="<?php echo wc_placeholder_img_src(); ?>" class="MagicZoomPlus Selector" rel="show-title: bottom; selectors-class: Active;" title="" rev="<?php echo wc_placeholder_img_src(); ?>">
										<img src="<?php echo wc_placeholder_img_src(); ?>" alt="" /> </a> 
									</span>
								<?php } ?>
							<?php } ?>
						<?php if(!empty($result) && $err == 0){ ?>
							<div id="sync2" class="owl-example_4 owl-carousel"> 								 
								<?php foreach($result as $res){	?>
									<?php 
										$sql = "SELECT image,virtue FROM `wp_book_virtue` WHERE id = $res";
										$resVirtue = $wpdb->get_results($sql);
										foreach($resVirtue as $virtue){?>
											<div class="item"><a href="<?php echo $virtue->image; ?>" class="Selector MagicThumb-swap"  rel="zoom-id:Zoomer" rev="<?php echo $virtue->image; ?>"><img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" /></a></div>
										<?php } ?>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>