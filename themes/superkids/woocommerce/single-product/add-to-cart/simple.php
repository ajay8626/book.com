<?php
/**
* Simple product add to cart
*
* This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
* @version     3.0.0
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$coupon_code='';
global $product;
global $woocommerce;
global $err;
$original_price = $product->get_price();
$price = $product->get_price();


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



//$gender_new = $bu_name;
$err1 = 0;
if (ctype_alpha(str_replace('', '', $bu_name)) === false)
{
$err1 = 5;
}
							
	if ( ! empty( $woocommerce->cart->applied_coupons ) ) {
             $my_coupon = $woocommerce->cart->get_coupons() ;
             foreach($my_coupon as $coupon){

                if ( $post = get_post( $coupon->id ) ) {
                        if (  $post->coupon_amount  ) {
							$coupon_ammount=$coupon->coupon_amount;
							if($coupon->discount_type == 'percent'){
								$price = $product->get_price();
								$price = $price - ($price*$coupon_ammount/100);
								$price = round($price);
								$coupon_code = "<p class='Coupon-applied'><span>(Coupon '".$coupon->code."' applied.)</span></p>";
							}
							
                           // echo $post->post_excerpt;
						}
				}
			}
	}
if ( ! $product->is_purchasable() ) {
	return;
}
echo wc_get_stock_html( $product );
if ( $product->is_in_stock() ) : ?>
	<?php 
	if(isset($_POST['continue'])){
	$name = $_POST['fname'];	
	$gender = $_POST['gender'];
	wp_redirect(get_permalink()."?bu_name=$name&bu_gender=$gender");
	exit;
	}	
	?>
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	<form class="cart" method="post" enctype='multipart/form-data'>
		<?php
		/**
		 * @since 2.1.0.
		 */
		//do_action( 'woocommerce_before_add_to_cart_button' );

		/**
		 * @since 3.0.0.
		 */
		//do_action( 'woocommerce_before_add_to_cart_quantity' );

		/* woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
		) ); */

		/**
		 * @since 3.0.0.
		 */
		//do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>	
		
		<script>
		jQuery(document).ready(function($) {	
			$('.inner_rad label input:radio').click(function() {
				$('.inner_rad label input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
				$(this).parent().addClass('active');
			});
		});
		</script>
		
		
		<?php if($bu_name != '' && $bu_gender != ''){ ?>
			<div class="pricewrap">
				<?php if($err == 0 ){ ?>
					<div class="btn_dff">
						<div class="book_name">
							<p class="lets_start">Let's start <span class="caps_name"><?php if($bu_name != '' ){ echo $bu_name; } ?>'s</span> journey to become Superkid</p>
							<span class="book_price">price: Rs. <?php $_product = wc_get_product(); if($price != $original_price){ echo $price.'  ( <span class="strike">Rs. '.$original_price.' </span> )'; }else{ echo $price; } ?><?php echo $coupon_code; ?><br><span class="">(Cash on Delivery Available)</span></span>							
								
						</div>					
						<div class="buybtn"><button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button></div>
					</div>
				<?php } ?> 
				<?php if($err != 5 && $err != 4){ ?>
				<div class="btn_dff dff_wrap_a">
					<a href="javascript:void(0);" id="trydiff_open" class="a_dff">Try different name</a>					
				</div>
				<?php } ?>
				<!--<div class="btn_video dff_wrap_a">
					<a href="javascript:void(0);" id="watch_video" class="a_dff">Click to Watch the Video, to understand more about the book.</a>
				</div>
				<div class="mob_dedication hide"><div class="dedication_text">You can modify the dedication page text after checkout</div></div>-->
			</div>
			<input name="fname" type="hidden" value="<?php if($bu_name != ''){ echo $bu_name; } ?>" />
			<input name="gender" type="hidden" value="<?php if($bu_gender != ''){ echo $bu_gender; } ?>" />
		<?php } else { ?>
		<div class="formwrap">
			<ul>
				<li><div class="inputbox"><input placeholder="Enter name" class="fname" name="fname" type="text" value="<?php if($bu_name != ''){ echo $bu_name; } ?>" disable="true" maxlength="13" /></div></li>
				<li>
					<div class="inner_rad">
						<?php if($bu_gender != ''){ ?>
							<?php if($bu_gender == 'Boy'){ ?>
								<label class="active"><input name="gender" value="Boy" class="rd_btn" checked="checked" type="radio">Boy</label>
								<label class="grl"><input name="gender" value="Girl" class="rd_btn" type="radio">Girl</label>
							<?php } ?>
							<?php if($bu_gender == 'Girl'){ ?>
								<label><input name="gender" value="Boy" class="rd_btn" type="radio">Boy</label>
								<label class="grl active"><input name="gender" value="Girl" class="rd_btn" checked="checked" type="radio">Girl</label>
							<?php } ?>
						<?php }else{ ?>
							<label class="active"><input name="gender" value="Boy" class="rd_btn" checked="checked" type="radio">Boy</label>
							<label class="grl"><input name="gender" value="Girl" class="rd_btn" type="radio">Girl</label>
						<?php } ?>
					</div>
				</li>
			</ul>
		</div>
		<div class="pricewrap">
			<div class="price"><?php echo $product->get_price_html(); ?>/-</div>
			<div class="buybtn"><button type="submit" name="continue" value="Continue" class="button single_continue alt">Continue</button></div>
		</div>
		<?php } ?>
		<!--<p style="margin: 10px 0px; width: 100%; float: left; text-align: center; font-size: 20px; font-weight: bold;">Upload your kid's photo and add a personalize message on BUY NOW page.</p>-->
		
		<?php 
		if(isset($_SESSION['kidsArr']) && !empty($_SESSION['kidsArr'])){ 
			if($bu_name !='' && $bu_gender != ''){
				$bu_name = $bu_name != '' ? $bu_name : '';
				$bu_gender = $bu_gender != '' ? $bu_gender : '';
				$bu_name = trim(strtolower($bu_name));
				$bu_name = ucfirst($bu_name);
				$his_her = (($bu_gender == 'Boy' || $bu_gender == 'boy')?'his':'her');
				$him_her = (($bu_gender == 'Boy' || $bu_gender == 'boy')?'him':'her');
				$he_she =  (($bu_gender == 'Boy' || $bu_gender == 'boy')?'he':'she');
				$himself_herself =  (($bu_gender == 'Boy' || $bu_gender == 'boy') ? 'himself' : 'herself');
				?>
				<p style="margin: 10px 0px; width: 100%; float: left; text-align: center; font-size: 20px; font-weight: bold;">
				This is a personalized book (<i>design and printed</i>) uniquely created for <?php echo $bu_name; ?> based on <?php echo $his_her; ?> name.
				</p>
				<?php 
				
				echo "<div class='book_desp kidsmeaning'><p>The book is formed in such a manner that each alphabet gets associated with a positive value/traits or good habits. So in a story, <b>$bu_name</b> Finds that $he_she has following good qualities in $him_her : ";				
				
				$res = $_SESSION['kidsArr'];
				echo "<div class='kidsname'>";
				foreach($res as $kname){
					echo $kname[0] . ' - ' .trim(ucfirst(strtolower($kname[1]))).'<br>';
				}
				
				echo "</div>";
				echo "<div class='book_desp kidsmeaning'><p>The story starts with <b>$bu_name</b> finding $himself_herself lost in a wonderland and somehow could not remember $his_her name. To come out of the wonderland and go back to $his_her home, $he_she needs to find $his_her name. Hence the adventure starts to find the missing alphabets of $his_her name. At each page of the storybook, $he_she meets a new character who gives a missing alphabet as per the good traits/habits/values. <br/>
				So at the end of the book, $he_she realizes that $his_her name contains these superpowers, which is the true meaning of $his_her name. These powers make $him_her a SUPER KID!</p>";
				/*echo "<p>So in the end, $he_she realizes that $his_her name contains these super powers which is the true meaning of $his_her name. These powers make $him_her a SUPER KID!</p><div>";*/
			}
		}
	?>
	<p style="margin: 10px 0px; width: 100%; float: left;  font-weight: bold;">*Upload your kid's photo and add a personalize message on BUY NOW page.</p>
	<div class="skidsvid">
			<iframe src="https://www.youtube.com/embed/hmmPkM_FHYM?rel=0" frameborder="0" allowfullscreen></iframe>
		</div> 
		<?php if(get_field('book_description') != "" && $bu_name != '') { ?>
			<div class="book_desp">
				<?php echo get_field('book_description'); ?>
			</div>
			<?php if($err == 0 ){ ?>
			<div class="single_buybtn"><button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button></div>
		<?php } ?> 
		<?php } ?> 
		
		<?php
			/**
			 * @since 2.1.0.
			 */
			do_action( 'woocommerce_after_add_to_cart_button' );
		?>
	</form>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<?php endif; ?>
<script>
/* $("#watch_video").click(function() {
    $.fancybox({
            'padding'       : 0,
            'autoScale'     : false,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'title'         : this.title,
            'width'     : 680,
            'height'        : 495,
            'href'          : 'https://www.youtube.com/embed/hmmPkM_FHYM?rel=0&autoplay=1',
			'type'          : 'iframe'
            
        });

    return false;
}); */
</script>