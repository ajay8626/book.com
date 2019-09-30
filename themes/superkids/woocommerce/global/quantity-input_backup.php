<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	?>
	<?php /* <div class="quantity">
		<input type="number" class="input-text qty text" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" size="4" pattern="<?php echo esc_attr( $pattern ); ?>" inputmode="<?php echo esc_attr( $inputmode ); ?>" />
	</div> */ ?>
	<div class="quantity">
		<input class="minus" type="button" value="-">
		<input type="number" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" size="4" />
		<input class="plus" type="button" value="+">
	</div>
	<?php
}
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var count = 0;
		$('.quantity').on('click', '.plus', function(e) {
			count += 1;
			$input = $(this).prev('input.qty');
			var val = parseInt($input.val());
			var radio = $("input[name='attribute_pa_bags']:checked").val();
			if(radio == 'without-name'){
				var total = 849 * (val+1);	
			}else{
				var total = 999 * (val+1);
			}
			$('span.amount').text('Rs. '+ total);
			$input.val( val+1 ).change();
		});
		var counter = 0;
		$('.quantity').on('click', '.minus',  function(e) {
			counter += 1;
			$input = $(this).next('input.qty');
			var val = parseInt($input.val());
			var price = $('span.amount').text();
			var qty_price = price.replace('Rs.', '');
			var radio = $("input[name='attribute_pa_bags']:checked").val();
			if (val > 0) {
				if((radio == 'without-name')){
					var total = (qty_price - (849 ));
				}else{
					var total = (qty_price - (999 ));
				}
				if(total > 0){
					$('span.amount').text('Rs. '+ total);
				}
			$input.val( val-1 ).change();
		}
	});
});
</script>