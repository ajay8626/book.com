<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';

?><table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top;" border="0">
	<tr>
		<td class="td" style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" valign="top" width="50%">
			<h3><?php _e( 'Billing address', 'woocommerce' ); ?></h3>

			<p class="text"><?php echo $order->get_formatted_billing_address(); ?>
			<?php 
				$billing_house_number = get_post_meta( $order->get_id(), 'billing_house_number' );
				$billing_street_address = get_post_meta( $order->get_id(), 'billing_street_address' );
				if(!empty($billing_house_number)){ 
					echo "<br><b>";
					echo $billing_house_number[0];
					echo "</b>";
				} 
				if(!empty($billing_street_address)){ 
					echo "<br><b>";
					echo $billing_street_address[0]; 
					echo "</b>";
				} ?>	
				<?php 
				$billing_landmark = get_post_meta( $order->get_id(), 'billing_landmark' );
				if(!empty($billing_landmark)){ 
					echo "<br><b>Landmark : ";
					echo $billing_landmark[0]; 
					echo "</b>";
				} ?>	
			</p>
			<br><br>
			<p><strong>IP address:</strong> <?php echo get_post_meta( $order->get_id(), '_customer_ip_address', true ); ?></p>
		</td>
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>
			<td class="td" style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" valign="top" width="50%">
				<h3><?php _e( 'Shipping address', 'woocommerce' ); ?></h3>

				<p class="text"><?php echo $shipping; ?></p>
			</td>
			<?php endif; ?>
	</tr>
</table>
