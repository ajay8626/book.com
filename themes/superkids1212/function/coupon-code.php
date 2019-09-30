<?php 
function wc_register_guests( $order_id ) {
  
  $order = new WC_Order($order_id);
  $order_email = $order->billing_email;
  $email = email_exists( $order_email );  
  $user = username_exists( $order_email );
  
  if( $user == false && $email == false ){
    
		$random_password = wp_generate_password();
 
		$user_id = wp_create_user( $order_email, $random_password, $order_email );
		if ( ! is_wp_error( $user_id ) ) {
			/* $referralcode = 'SKID'.$user_id; */
			$referralcode = $user_id;
			update_user_meta( $user_id, 'referralcode', $referralcode );
			update_user_meta( $user_id, 'credit', '0' );
			
			$amount = get_option('ad_referral_code'); // Amount
			$discount_type = 'percent'; 

			$coupon = array(
				'post_title' => $referralcode,
				'post_content' => '',
				'post_status' => 'publish',
				'post_author' => 1,
				'post_type'     => 'shop_coupon'
			);    

			$new_coupon_id = wp_insert_post( $coupon );

			// Add meta
			update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
			update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
			update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
			update_post_meta( $new_coupon_id, 'product_ids', '' );
			update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
			update_post_meta( $new_coupon_id, 'usage_limit', '' );
			/* update_post_meta( $new_coupon_id, 'usage_limit_per_user', '1' ); */
			update_post_meta( $new_coupon_id, 'expiry_date', '' );
			update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
			update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
			//user's billing data
			update_user_meta( $user_id, 'billing_address_1', $order->billing_address_1 );
			update_user_meta( $user_id, 'billing_address_2', $order->billing_address_2 );
			update_user_meta( $user_id, 'billing_city', $order->billing_city );
			update_user_meta( $user_id, 'billing_company', $order->billing_company );
			update_user_meta( $user_id, 'billing_country', $order->billing_country );
			update_user_meta( $user_id, 'billing_email', $order->billing_email );
			update_user_meta( $user_id, 'billing_first_name', $order->billing_first_name );
			update_user_meta( $user_id, 'billing_last_name', $order->billing_last_name );
			update_user_meta( $user_id, 'billing_phone', $order->billing_phone );
			update_user_meta( $user_id, 'billing_postcode', $order->billing_postcode );
			update_user_meta( $user_id, 'billing_state', $order->billing_state );
			
			/* $mailer = WC()->mailer();
			$subject = "Your Superkid's League Referral code";
			$message = '<p>Hello '.trim(ucfirst(strtolower($order->billing_first_name))).',</p>';
			$message .= '<p>Thank you for your order with us. Hope your family must have enjoyed to see and read the book.<br/></p>';
			$message .= '<p>Here there is something more that you will enjoy. We are sharing a referral code with you that can help your friends and family to get the book on a 10% discount and you too get a surprise gift from us on every confirmed purchase.<br/></p><p>To learn more about the scheme, click here.</p><br/><p>Your Referral code is : <strong>101291</strong></p>';
			$send = $mailer->send( $order->billing_email, $subject, $mailer->wrap_message( 'Your Referral Code Information', $message ), '', '' ); */		
		}
	}
	
	if( $order->get_used_coupons() ) {
		$order_coupons = $order->get_used_coupons();
		$code = $order_coupons[0];
		if($code){
			
			$chk_used_coupon = get_post_meta(  $order_id, 'used_coupon_code');
			if(!$chk_used_coupon){
				update_post_meta(  $order_id, 'used_coupon_code',  $code);
				/* $code_user = explode("skid",$code); */
				/* $user_id = $code_user[1]; */
				$user_id = $code;
				if($user_id != ""){
					$user_data = get_user_meta($user_id);
					$previous_credit = $user_data[credit][0];
					$newcredit = 10 + $previous_credit;
					update_user_meta( $user_id, 'credit', $newcredit );				
				}
			}
		}
	}
  
}
 
//call our wc_register_guests() function on the thank you page
add_action( 'woocommerce_thankyou', 'wc_register_guests', 10, 1 );

add_action('show_user_profile', 'main_user_profile_edit_action');
add_action('edit_user_profile', 'main_user_profile_edit_action');
function main_user_profile_edit_action($user) { 
if($user->referralcode != "") {
?>
	<table>
  <tr>
  <th><label for="referralcode">Referral code</label></th>
    <td><input name="referralcode" type="text" id="referralcode" disabled value="<?php echo $user->referralcode; ?>" /><span class="description">Referral code cannot be changed.</span></td>
  </tr>
   </table>
<?php } ?>
<table>
  <tr>
  <th><label for="credit">User credit</label></th>
    <td><input name="credit" type="text" id="credit" value="<?php echo $user->credit; ?>" /></td>
  </tr>
</table>
<?php }

function save_extra_user_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) ) {
    return false; 
}

update_user_meta( $user_id, 'credit', $_POST['credit'] );   
}
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );