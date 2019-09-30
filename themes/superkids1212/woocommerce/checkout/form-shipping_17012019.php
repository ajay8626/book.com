<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
require("class.phpmailer.php");
error_reporting(0);

if(isset($_SESSION['sess_bookusername']) && $_SESSION['sess_bookusername'] != '' && isset($_SESSION['sess_bcode']) && $_SESSION['sess_bcode'] != '' && $_SESSION['sess_bcode'] != 'PN30' && $_SESSION['sess_bcode'] != 'pn30'){
	global $wpdb;
	$bcode = $_SESSION['sess_bcode'];
	$dailySmsCron = $wpdb->prefix.'daily_sms_cron';
	$checkUcode = $wpdb->get_results("SELECT * FROM `$dailySmsCron` WHERE `ucode` = '$bcode'");
	if(!empty($checkUcode)){
		$checkPage = $checkUcode[0]->visiting_page;
		$id = $checkUcode[0]->id;
		if($checkPage == 'product'){
			$updateVisitPage = $wpdb->update( $dailySmsCron, array( 'visiting_page' => 'checkout'),array('id'=>$id));
		}else if($checkPage == 'checkout'){

		}else{
			$cronSms = array('ucode' => $bcode, 'visiting_page' => 'checkout');
			$wpdb->insert( $dailySmsCron, $cronSms);	
		}		
	}
	
	/* $message = "Name : " . $_SESSION['sess_bookusername']. "<br> Unique Code : " . $_SESSION['sess_bcode'];
	$subject = 'Checkout : '.$bu_name.' with code - '.$_SESSION['sess_bcode'].' has visited checkout page in site';
	$Host = get_option('smtp_hostname');
	$Username = get_option('smtp_username');
	$Password = get_option('smtp_password');
	$siteVisitedPage = $wpdb->prefix.'site_visited_page';
	if($Host != '' && $Username != '' && $Password != ''){
		$emails = array('harsh@skids.in','keval@skids.in','nisha@skids.in','sachin@skids.in');
		
		$ch_last_email_sent = get_option('ch_last_email_sent');
		
		if($ch_last_email_sent == 0){
			$ch_last_email_sent = 1;
		}else if($ch_last_email_sent == 1){
			$ch_last_email_sent = 2;
		}else if($ch_last_email_sent == 2){
			$ch_last_email_sent = 3;
		}else if($ch_last_email_sent == 3){
			$ch_last_email_sent = 0;
		}
		
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
		$loc_email = $emails[$ch_last_email_sent];
		$mail->AddAddress($loc_email);
		$mail->AddCC('ameet@parentingnation.in');
		$mail->Subject = $subject;
		$mail->Body = $message;
		$ok=$mail->Send();
        
		if(get_option('ch_last_email_sent', 'default') == 'default'){
			add_option('ch_last_email_sent');
		}
		$data = array('unique_code' => $_SESSION['sess_bcode'], 'visited_page' => 'checkout','employee_email' => $emails[$ch_last_email_sent]);
	    $wpdb->insert( $siteVisitedPage, $data);
		
		update_option('ch_last_email_sent', $ch_last_email_sent);
	}	 */
}
?>
<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php foreach ( $checkout->get_checkout_fields( 'shipping' )  as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
<div class="personalised_detail_wrap">
	<!--<h3>Below You Can edit the first page text.</h3>-->
	<h3>Personalised Message</h3>
	<?php $special_message = 'To,
'.ucfirst(strtolower(trim($_SESSION['sess_bookusername']))).', 
The Cutest Super Kid!'; ?>
	 <p class="form-row special_message-class form-row-wide woocommerce-validated" id="special_message_field" data-priority="">
		<textarea name="special_message" class="input-text" id="special_message" rows="2" cols="5"><?php echo $special_message; ?></textarea>
	</p><small>(Max 200 characters)</small>
</div>
	<?php /* if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3 style="margin: 20px 0px 0px;"><?php _e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' )  as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; */ ?>
	
	
	<div class="ckbox">
	<div class="imgwraplft"><img src="<?php echo get_template_directory_uri(); ?>/images/Spacial-Msg1.jpg"/></div>
	<!--<p>You can email us kids photo on email - <a href="mailto:photo@skids.in">photo@skids.in</a>. Please do mention your Order Number with the photo.</p>-->
	</div>
	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
<?php 
function wpufe_limit_text() {
	?>
	<script type="text/javascript">
		(function($) {

			function limitText(field, maxChar){
			    var ref = $(field),
			        val = ref.val();

			    if ( val.length >= maxChar ) {
			        ref.val(val.substr(0, maxChar));
			    }
			}

            // Insert Limitations here
            $('#special_message').on('keyup', function() {
                limitText(this, 200)
			});
			$('#billing_phone_field').append('<p style="font-size:12px;">(No need to enter 0 or +91.)</p><span id="errormsg"></span>');
			$("#billing_phone").keypress(function (e) {
			    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			        $("#errormsg").html("Digits Only").delay(1000).show().fadeOut("slow").css({"color": "#ff0000", "font-size": "11px"});
			        	return false;
			    }
		   });
      })(jQuery);
	</script>
	<?php
}

add_action( 'wp_footer', 'wpufe_limit_text' );