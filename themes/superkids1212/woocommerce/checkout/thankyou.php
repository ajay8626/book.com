<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
?>

<div class="woocommerce-order">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<style>
			header.entry-header {
			display: none;
			}
			</style>
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed" style="font-size: 22px; line-height: 30px; text-align: center;"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<?php /* <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p> */ ?>
			<?php
			global $woocommerce;
			session_start();
			$coupon = '';
			$order_id = $order->get_id();
			$order = new WC_Order($order_id);
			$items = $order->get_items();
			foreach ($items as $item_id => $item){
				$Name = wc_get_order_item_meta( $item_id, 'Name', true );
				$Gender = wc_get_order_item_meta( $item_id, 'Gender', true );
				if(is_array($Name)){
					$name = $Name[0];
					$gender = $Gender[0];
				}else{
					$name = $Name;
					$gender = $Gender;
				}
			}
			
				$first_name = get_post_meta( $order_id, '_billing_first_name', true );
				$kids_name = get_post_meta( $order_id, 'billing_kidsname', true );
				$add1 = get_post_meta( $order_id, '_billing_address_1', true );
				$add2 = get_post_meta( $order_id, '_billing_address_2', true );
				$city = get_post_meta( $order_id, '_billing_city', true );
				$state = get_post_meta( $order_id, '_billing_state', true );
				$postcode = get_post_meta( $order_id, '_billing_postcode', true );
				$email = get_post_meta( $order_id, '_billing_email', true );
				$phone = get_post_meta( $order_id, '_billing_phone', true );
				$landline = get_post_meta( $order_id, 'billing_landline', true );
				$landmark = get_post_meta( $order_id, 'billing_landmark', true );
				$special_message = get_post_meta( $order_id, '_special_message', true );
				
				$checkout_record = array('fname'=>$first_name,'kname'=>$kids_name,'add1'=>$add1,'add2'=>$add2,'city'=>$city,'state'=>$state,'postcode'=>$postcode,'email'=>$email,'phone'=>$phone,'landline'=>$landline,'landmark'=>$landmark,'special_message'=>$special_message);
				$checkout_encode = json_encode($checkout_record);
				$_SESSION['checkout_details'] = $checkout_encode;
				
			if( $order->get_used_coupons() ) {
				 $order_coupons = $order->get_used_coupons();
				$coupon = $order_coupons[0];
			}				
			if($gender == 'Boy' || $gender == 'boy'){	$link_gender = 'B';	}else{ $link_gender = 'G'; }
			$_SESSION['sess_bookusername'] = $name; 
			$_SESSION['sess_bookusergender'] = $gender;
			
			if($coupon != ''){
				$_SESSION['aplcoupan'] = 1;
			} 
				$woocommerce->cart->add_to_cart(8, 1);
				$product_url = esc_url( wc_get_checkout_url() );				
			?>
			<p class="woocommerce-notice buagain woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo $product_url; ?>" class="button pay"><?php _e( 'Buy Again', 'woocommerce' ) ?></a>
			</p>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>			
			
			<?php 
				/*
				 * Personalised detail form for first page text in book
				 */
				//$prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

				if ( isset( $_POST['personalised_detail'] ) ) {
					update_post_meta( $order->get_id(), '_personalised_detail', $_POST['personalised_detail'] );		
				}
				
				
				/*
				 * Kids photo upload for first page text in book
				 */
				 
				$uploaded_file_path = get_post_meta( $order->get_id(), '_woo_ufdc_uploaded_file_path_1', true );					
				$url = home_url('/').( str_replace( ABSPATH, '',  $uploaded_file_path) );
				if( !empty( $uploaded_file_path ) ) {
					update_post_meta( $order->get_id(), '_kidsphoto', $url );
				}
				if ( isset( $_FILES["kidsphoto"]["name"] ) && $_FILES["kidsphoto"]["name"] != '' ) {
					$check = getimagesize($_FILES["kidsphoto"]["tmp_name"]);
					if($check !== false) {
						$upload = wp_upload_dir();
						$uploadDir = $upload['basedir'] . "/kidsphotos/";
						$urlDir = $upload['baseurl'] . "/kidsphotos/";
						$permissions = 0755;
						if (!is_dir($uploadDir)) mkdir($uploadDir, $permissions);
						$newfile = $uploadDir . $order->get_id() . '-' . $_FILES["kidsphoto"]["name"];
						$newfileurl = $urlDir . $order->get_id() . '-' . $_FILES["kidsphoto"]["name"];
						if (move_uploaded_file($_FILES["kidsphoto"]["tmp_name"], $newfile)) {
							update_post_meta( $order->get_id(), '_kidsphoto', $newfileurl );		
						}
					}
				}
				
				if ( isset( $_POST["order_comments"] ) ) {

					$order_comments = $_POST["order_comments"];
					if($_POST["order_comments"] == ''){
						$order_comments = 'N/A';
					}
					
					// specify the order_id so WooCommerce knows which to update
					$order_data = array(
						'order_id' => $order->get_id(),
						'customer_note' => $order_comments
					);
					// update the customer_note on the order
					wc_update_order( $order_data );
					
				}
				
				
				if( session_id() === '' ) {
					//session has not started
					session_start();
				}
				$_SESSION['skcouponused'] = 1;
			?>
			<?php do_action( 'woocommerce_thankyou_personalised_detail', $order->get_id() ); ?>			
			
			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php _e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php _e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
				</li>

				<li class="woocommerce-order-overview__total total">
					<?php _e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>

				<li class="woocommerce-order-overview__payment-method method">
					<?php _e( 'Payment method:', 'woocommerce' ); ?>
					<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
				</li>

				<?php endif; ?>

			</ul>

		<?php endif; ?>
		<?php if ( !$order->has_status( 'failed' ) ) : ?>
		<style>
		header.entry-header {
		  display: none;
		}
		</style>
		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		
		<?php 
		$order_id = $order->id;
		$items = $order->get_items();
		$order = wc_get_order($order_id);
		foreach ( $items as $item ) {
		   $product_name = $item->get_name();
		   if($product_name == "Superkid’s League Book"){ ?>
		   		<div class="another-book">
					<p>Happy with the flow, Let's bring smile on another face- buy one more book</p>
					<a href="<?php echo get_site_url(); ?>" class="button alt">Order Another Book</a>
				</div>
		<?php   }
		} ?>
		<?php endif; ?>
	<?php else : ?>
		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '319664995112201'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=319664995112201&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
<!-- Google Code for SuperKids Conversion Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1068735470;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "zOD6CNmegHUQ7rfO_QM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1068735470/?label=zOD6CNmegHUQ7rfO_QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!-- End of Google Code for SuperKids Conversion Conversion Page -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '319664995112201');
fbq('track', 'CompleteRegistration');
</script>
<noscript>
<img height="1" width="1"
src="https://www.facebook.com/tr?id=319664995112201&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->