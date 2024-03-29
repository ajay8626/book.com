<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
	exit; // Exit if accessed directly.
}

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>
	
	<p class="meta"><em class="woocommerce-review__awaiting-approval"><?php esc_attr_e( 'Your review is awaiting approval', 'woocommerce' ); ?></em></p>

<?php } else { ?>
	<div class="commentlist">
<ul>
<li>
	<p class="meta">
		<strong class="woocommerce-review__author" itemprop="author"><h2><?php comment_author(); ?></h2></strong> <?php

		/*if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
			echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')</em> ';
		}*/

		?><span class="woocommerce-review__dash"></span> <time class="woocommerce-review__published-date" itemprop="datePublished" datetime="<?php //echo get_comment_date( 'c' ); ?>"><?php //echo get_comment_date( wc_date_format() ); ?></time>
	</p>

<?php }


global $comment;
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) { ?>
		<div class="star-rating rating">
		<span style="width:<?php echo ( esc_attr( $rating ) / 5 ) * 100; ?>%"><?php
			/* translators: %s: rating */
			printf( esc_html__( '%s out of 5', 'woocommerce' ), '<strong>' . $rating . '</strong>' );
		?></span>
	</div>
<?php } ?>