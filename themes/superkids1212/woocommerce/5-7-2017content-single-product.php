<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		if(isset($_REQUEST['bu_name']) && isset($_REQUEST['bu_gender'])){
			remove_action( 'woocommerce_single_product_summary','woocommerce_show_product_sale_flash',10);
			remove_action( 'woocommerce_single_product_summary','woocommerce_show_product_images',20);
		}
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			if(isset($_REQUEST['bu_name']) && isset($_REQUEST['bu_gender'])){
				remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_title',5);
				remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
			}
			do_action( 'woocommerce_single_product_summary' );
		?>

	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

</div><!-- #product-<?php the_ID(); ?> -->

	<script>
	jQuery(document).ready(function($) {	
		$('.inner_rad label input:radio').click(function() {
			$('.inner_rad label input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
			$(this).parent().addClass('active');
		});
	});
	jQuery(document).ready(function($) {	

		$(".tab_content").hide(); 
		$("ul.tabs li:first").addClass("active").show(); 
		$(".tab_content:first").show(); 

		$("ul.tabs li").click(function() {

			$("ul.tabs li").removeClass("active"); 
			$(this).addClass("active"); 
			$(".tab_content").hide(); 

			var activeTab = $(this).find("a").attr("href"); 
			$(activeTab).fadeIn(); 
			return false;
		});

	});
	function MM_jumpMenu(targ,selObj,restore){ 
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	</script>
		
    <?php $tab_titles = get_field('tab_details'); ?>
    <?php $tab_contents = get_field('tab_details'); ?>
	<div class="tab_wrap">
		<ul class="tabs">
			<li><a href="#tab1"><?php if(get_field('tab_1_title')){ the_field('tab_1_title'); }else{ echo 'Description'; } ?></a></li>
			<?php if($tab_titles){ $i = 2; ?>
				<?php foreach($tab_titles as $title){ ?>
					<li><a href="#tab<?php echo $i++; ?>"><?php echo $title['tab_title']; ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<?php the_content(); ?>
			</div>
			<?php if($tab_contents){ $i = 2; ?>
				<?php foreach($tab_contents as $value){ ?>
					<div id="tab<?php echo $i++; ?>" class="tab_content">
					<?php echo $value['tab_content']; ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
