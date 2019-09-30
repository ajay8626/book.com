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
} else { ?>
	<!-- <div class="quantity">
		<input type="number" class="input-text qty text" step="<?php //echo esc_attr( $step ); ?>" min="<?php //echo esc_attr( $min_value ); ?>" max="<?php //echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>" name="<?php //echo esc_attr( $input_name ); ?>" value="<?php //echo esc_attr( $input_value ); ?>" title="<?php //echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" size="4" pattern="<?php //echo esc_attr( $pattern ); ?>" inputmode="<?php //echo esc_attr( $inputmode ); ?>" />
	</div> -->
	<div class="quantity">
		<input class="minus" type="button" value="-">
		<input type="number" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" size="4" />
		<input class="plus" type="button" value="+">
	</div>
<?php } ?>
<?php
	$url = $_SERVER['REQUEST_URI'];
    $pageurl = explode('/', $url);
    $pageId = $pageurl[2];
    $product = new WC_Product_Variable($pageId);
	$product_variations = $product->get_available_variations();
	$regular_price = $product_variations[1]['regular_price'];
	$sale_price = $product_variations[1]['sale_price'];

	$withNamePrice = $product_variations[1]['regular_price'];
	$withoutNamePrice = $product_variations[0]['regular_price'];
    //echo "<pre>"; print_r($withoutNamePrice); exit;
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	var regular_price = '<?php echo $regular_price; ?>';
	var sale_price = '<?php echo $sale_price; ?>';
	var withNamePrice = '<?php echo $withNamePrice; ?>';
	var withoutNamePrice = '<?php echo $withoutNamePrice; ?>';
	var difference = regular_price - sale_price;
	$('.quantity').on('click', '.plus', function(e) {
		$input = $(this).prev('input.qty');
		var val = parseInt($input.val());
		var radio = $("input[name='attribute_pa_bags']:checked").val();
		//var bagprice = $('.woocommerce-variation-price .price .amount').text();
		var price = $('span.amount').text();
		var url = window.location.href;
		var result = url.split('/');
		if(result[3] == 'worksheets'){
			var deltotal = regular_price * (val+1);
			var total = sale_price * (val+1);
			var discount = difference * (val+1);
			var percent = Math.ceil((total/deltotal)*100);
			if(discount != ""){
				$('.save_price').html('(<i>You Save: Rs.'+addCommas(discount)+' ('+percent+'%))</i>');	
			}else{
				$('.save_price').html('(<i>You Save: Rs.0 (0%))</i>');
			}
			$(".woocommerce-variation-price .price > del > span.amount").html('Rs. '+ addCommas(deltotal));
			$(".woocommerce-variation-price .price > ins > span.amount").html('Rs. '+ addCommas(total));
			$input.val( val+1 ).change();
		}
		if(result[3] == 'bags-product'){
			if(radio == 'without-name'){
				var bagtotal = withoutNamePrice * (val+1);	
			}else {
				var bagtotal = withNamePrice * (val+1);	
			}
			$(".woocommerce-variation-price .price .amount").html('Rs. '+ addCommas(bagtotal));
			$input.val( val+1 ).change();
		}
		//$('span.amount').text('Rs. '+ total);
	});
	$('.quantity').on('click', '.minus',  function(e) {
		$input = $(this).next('input.qty');
		var val = parseInt($input.val());
		
		var bag_price = $('.woocommerce-variation-price .amount').text();
		var bag_qty_price = bag_price.replace('Rs.', '');
		bag_qty_price = bag_qty_price.replace(/\,/g,'');

		var price = $('.woocommerce-variation-price .price > ins > span.amount').text();
		var qty_price = price.replace('Rs.', '');
		qty_price = qty_price.replace(/\,/g,'');
		
		var delprice = jQuery('.woocommerce-variation-price .price > del > span.amount').text();
		var del_qty_price = delprice.replace('Rs.', '');
		del_qty_price = del_qty_price.replace(/\,/g,'');
		
		var url = window.location.href;
		var result = url.split('/');
		var radio = $("input[name='attribute_pa_bags']:checked").val();
		console.log(result[3]);
		if(result[3] == 'worksheets'){
			var total = (qty_price - (sale_price));
			var deltotal = (del_qty_price - (regular_price));
			if(val == 1){
				var discount = difference * (val);
			}else{
				var discount = difference * (val-1);
			}
			var percent = Math.ceil((total/deltotal)*100);
			$('.save_price').html('(<i>You Save: Rs.'+addCommas(discount)+' ('+percent+'%))</i>');
		}
		if(result[3] == 'bags-product'){
			if((radio == 'without-name')){
				var bagtotal = (bag_qty_price - (withoutNamePrice ));
			}else {
				var bagtotal = (bag_qty_price - (withNamePrice ));
			}
			if(bagtotal > 0){
				$(".woocommerce-variation-price .price .amount").html('Rs. '+ addCommas(bagtotal));
			}
		}
		if(deltotal > 0){
			$(".woocommerce-variation-price .price > del > span.amount").html('Rs. '+ addCommas(deltotal));
		}
		if(total > 0){
			$(".woocommerce-variation-price .price > ins > span.amount").html('Rs. '+ addCommas(total));
		}
		if(val >= 1){
			if(val == 1){
				$input.val( val ).change();
				alert('Minimum Quantity Should be 1');
			}else{
				$input.val( val-1 ).change();
			}
		}
	});
});

function addCommas(num) {
    var str = num.toString().split('.');
    if (str[0].length >= 4) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    return str.join('.');
}
</script>