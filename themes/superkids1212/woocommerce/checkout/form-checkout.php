<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>
<!-- <div id="wait" style="display:none;top:50%;left:40%;padding:2px;"><img src='<?php echo get_template_directory_uri(); ?>/images/gif/demo_wait.gif' width="64" height="64" /><br>Loading..</div> -->
			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
<script>
/*jQuery( document ).ready(function( $ ) {
	$('#billing_postcode').append().after('<span id="zipcode_msg"></span>');
	$("#billing_postcode").change(function(){
    	//((396 == postCodespl) || (605 == postCodespl) || (682 == postCodespl) || (737 == postCodespl) || (744 == postCodespl) || (793 == postCodespl) || (795 == postCodespl) || (796 == postCodespl) || (797 == postCodespl) || (798 == postCodespl) || (799 == postCodespl));
	  var checkZipCode = ['00','01','02','03','04','05','06','07','08','09','10', '29', '35', '54', '55'];
	  checkCode = $('#billing_postcode').val().substr(0, 2);
	  if(jQuery.inArray(checkCode, checkZipCode) != -1){
	  	$("#zipcode_msg").html("Incorrect Zip Code").delay(5000).fadeOut().css({"color": "#ff0000", "font-size": "11px",'display': 'block'});
	  	$('#billing_state').find('option').remove().end();
     	$("#billing_state").append("<option value=''>SELECT YOUR STATE</option>");
      	return false;
	  }
	  
	  postCodeId = '';
	  postCode = $('#billing_postcode').val();
	  postCodespl = $('#billing_postcode').val().substr(0, 3);
	  if((396210 == postCode)){
	  	postCodeId = postCode;
	  }else if((396 == postCodespl) || (605 == postCodespl) || (682 == postCodespl) || (737 == postCodespl) || (744 == postCodespl) || (793 == postCodespl) || (795 == postCodespl) || (796 == postCodespl) || (797 == postCodespl) || (798 == postCodespl) || (799 == postCodespl)){
	  	postCodeId = postCodespl;
	  }else{
	  	postCodeId = $('#billing_postcode').val().substr(0, 2);
	  }
	  if((postCode.length) != 6){
	  	$('#billing_state').find('option').remove().end();
     	$("#billing_state").append("<option value=''>SELECT YOUR STATE</option>");
	  	$("#zipcode_msg").html("Please type correct zipcode").delay(5000).fadeOut().css({"color": "#ff0000", "font-size": "11px", 'display': 'block'});
	  	return false;
	  }else{
	  	$("#zipcode_msg").html('');
	  }
	  $("#wait").css("display", "block");
	  action = 'state_with_zipcode';
	  $.ajax({
	        url: ajax_state_object.ajax_url,
	        dataType: 'text',
	        type: 'post',
	        contentType: 'application/x-www-form-urlencoded',
	        data: {'action': action, postCode : postCodeId },
	        success: function( data, textStatus, jQxhr ){
	        	$("#wait").css("display", "none");
	        	data = jQuery.parseJSON(data);
	        	if(jQuery.isEmptyObject(data) == false){
	        		$('#billing_state').find('option').remove().end();
		             if(postCodeId != ""){
		             	$.each(data, function(key,statename) {
		        		$('#billing_state')
						    .append($("<option></option>")
		                    .attr("value",statename)
		                    .text(statename.toUpperCase()));
						});	
		             }else{
		             	$("#zipcode_msg").html("Please type correct zipcode").delay(5000).fadeOut().css({"color": "#ff0000", "font-size": "11px"});
		             	$("#billing_state").append("<option value=''>SELECT YOUR STATE</option>");
		             }
		         }else{
		         	$('#billing_state').find('option').remove().end();
		         	$("#billing_state").append("<option value=''>SELECT YOUR STATE</option>");
		         }
	        },
	        error: function( jqXhr, textStatus, errorThrown ){
	             
	        }
        });
	});
});*/
</script>