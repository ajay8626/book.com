<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<div class="innercnt">
	<div class="mtp">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyfifteen' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location.', 'twentyfifteen' ); ?></p>

				<?php //get_search_form(); ?>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</div>
</div>

<?php get_footer(); ?>
