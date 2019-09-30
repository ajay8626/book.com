<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
global $wpdb;
global $woocommerce;

$attribute_keys = array_keys( $attributes );
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $name => $options ) : 
				?>

					<?php $sanitized_name = sanitize_title( $name ); ?>
					<tr class="attribute-<?php echo esc_attr( $sanitized_name ); ?>">
						<?php /* <td class="label"><label for="<?php echo esc_attr( $sanitized_name ); ?>"><?php echo wc_attribute_label( $name ); ?></label></td> */ ?>
						<?php
				
						if ( isset( $_REQUEST[ 'attribute_' . $sanitized_name ] ) ) {
							$checked_value = $_REQUEST[ 'attribute_' . $sanitized_name ];
						} elseif ( isset( $selected_attributes[ $sanitized_name ] ) ) {
							$checked_value = $selected_attributes[ $sanitized_name ];
						} else {
							$checked_value = '';
						}
						if(wc_attribute_label( $name ) == 'Bags'){
							$variation = 'variations_bag_name';
						}else if(wc_attribute_label( $name ) == 'Height Chart'){
							$variation = 'variations_height_chart';
						}else if(wc_attribute_label( $name ) == 'Worksheet'){
							$variation = 'variations_Worksheet';
						}else{
							$variation = 'variations_gender';
						}
						?>
						<td class="value">
							<div class="<?php echo $variation; ?>">
							<?php
							//echo "<pre>"; print_r($options);exit;
							if ( ! empty( $options ) ) {
								if ( taxonomy_exists( $name ) ) {
									// Get terms if this is a taxonomy - ordered. We need the names too.
									$terms = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'all' ) );

									foreach ( $terms as $term ) {
										if($name == 'pa_height-chart'){
											$post_id = $wpdb->get_results("SELECT `ID` FROM `wp_posts` WHERE `post_title` = 'Superkids Height Chart' AND `post_parent` = '".$product->get_id()."' AND `post_status` = 'publish' ");
										}else if($name == 'pa_bags'){
											$post_id = $wpdb->get_results("SELECT `ID` FROM `wp_posts` WHERE `post_title` = 'Superkids School Bags - ".$term->name."' AND `post_parent` = '".$product->get_id()."'");
										}else{
											$post_id = "";
										}
										//echo "<pre>"; print_r($post_id); exit;
										if(!empty($post_id)){
											$variation_id = $post_id[0]->ID;	
										}else{
											$variation_id = "";
										}
										
										if ( ! in_array( $term->slug, $options ) ) {
											continue;
										}
										print_attribute_radio( $checked_value, $term->slug, $term->name, $sanitized_name, $variation_id );
									}
								} else {
									foreach ( $options as $option ) {
										print_attribute_radio( $checked_value, $option, $option, $sanitized_name );
									}
								}
							}else{
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
								echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) : '';
							}

							echo end( $attribute_keys ) === $name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php
			if ( version_compare($woocommerce->version, '3.4.0') < 0 ) {
				do_action( 'woocommerce_before_add_to_cart_button' );
			}
		?>

		<div class="single_variation_wrap">
			<?php
				do_action( 'woocommerce_before_single_variation' );
				do_action( 'woocommerce_single_variation' );
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php
			if ( version_compare($woocommerce->version, '3.4.0') < 0 ) {
				do_action( 'woocommerce_after_add_to_cart_button' );
			}
		?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
