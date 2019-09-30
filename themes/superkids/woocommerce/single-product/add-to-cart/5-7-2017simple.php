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
global $product;
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
		
		
		<?php if(isset($_REQUEST['bu_name']) && isset($_REQUEST['bu_gender'])){ ?>
			<div class="pricewrap">
			<div class="btn_dff">
			<div class="buybtn"><button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button><span>(Cash on Delivery Available)</span></div></div>
			</div>
			<input name="fname" type="hidden" value="<?php if(isset($_REQUEST['bu_name'])){ echo $_REQUEST['bu_name']; } ?>" />
			<input name="gender" type="hidden" value="<?php if(isset($_REQUEST['bu_gender'])){ echo $_REQUEST['bu_gender']; } ?>" />
		<?php } else { ?>
		<div class="formwrap">
			<ul>
				<li><div class="inputbox"><input placeholder="Enter name" class="fname" name="fname" type="text" value="<?php if(isset($_REQUEST['bu_name'])){ echo $_REQUEST['bu_name']; } ?>" disable="true" maxlength="13" /></div></li>
				<li>
					<div class="inner_rad">
						<?php if(isset($_REQUEST['bu_gender'])){ ?>
							<?php if($_REQUEST['bu_gender'] == 'Boy'){ ?>
								<label class="active"><input name="gender" value="Boy" class="rd_btn" checked="checked" type="radio">Boy</label>
								<label class="grl"><input name="gender" value="Girl" class="rd_btn" type="radio">Girl</label>
							<?php } ?>
							<?php if($_REQUEST['bu_gender'] == 'Girl'){ ?>
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
		<?php
			/**
			 * @since 2.1.0.
			 */
			do_action( 'woocommerce_after_add_to_cart_button' );
		?>
	</form>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<?php endif; ?>