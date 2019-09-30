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

if(isset($_REQUEST['bu_name'])){
	$bu_name = $_REQUEST['bu_name'];
}elseif(get_query_var('bname') != ''){
	$bu_name = get_query_var('bname');
}else{
	$bu_name = '';
}
if(isset($_REQUEST['bu_gender'])){
	$bu_gender = $_REQUEST['bu_gender'];
}elseif(get_query_var('bgender') != ''){
	$bgender = get_query_var('bgender');
	$bu_gender = 'Boy';
	if($bgender == 'G' || $bgender == 'g'){
		$bu_gender = 'Girl';
	}
}else{
	$bu_gender = '';
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
		if($bu_name != '' && $bu_gender != ''){ 
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
			if($bu_name != '' && $bu_gender != ''){ 
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
	
<?php if(get_field('book_description') != "" && $bu_name == '' ) { ?>
<div class="book_desp">
<?php echo get_field('book_description'); ?>
</div>
<?php } ?> 
<div class="book_testimonial">
		<div class="testimnal_img">
			<?php if(get_field('image') != "") { ?>
				<img src="<?php echo get_field('image'); ?>" />
			<?php } if(get_field('name') != "") { ?>
				<h4><?php echo get_field('name'); ?></h4>
			<?php } if(get_field('designation') != "") { ?>
				<p><?php echo get_field('designation'); ?></p>
			<?php } ?>
		</div>
		<?php if(get_field('description') != "") { ?>
			<div class="testimnal_des">
				<p><?php echo get_field('description'); ?></p>
			</div>
		<?php } ?>
</div>
			
	<script> /* 
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
	} */
	</script>
		
    <?php /* $tab_titles = get_field('tab_details'); ?>
		<?php $tab_contents = get_field('tab_details'); ?>
            
            <div class="tab_wrap">
             <ul class="tabs">
            <?php if($tab_titles){ $i = 1; ?>
				<?php foreach($tab_titles as $title){ ?>
					<li><span></span><a href="#tab<?php echo $i++; ?>"><?php echo $title['tab_title']; ?></a></li>
				<?php } ?>
			<?php } ?>
             </ul>
             <div class="tab_container">
              <?php if($tab_contents){ $i = 1; ?>
				<?php foreach($tab_contents as $value){ ?>
				<?php $bg_image = $value['tab_background_image']; ?>
			  <div id="tab<?php echo $i++; ?>" class="tab_content <?php if($bg_image != "") { echo 'tab_bg'; } else { echo 'only_cont'; } ?>">
			  <?php if($bg_image != "") { ?>
				<img src="<?php echo $bg_image; ?>" alt="" />
			  <?php } ?>
				<div class="tab_overlay">
					<?php echo $value['tab_content']; ?>
				</div>
              </div>
			 <?php } ?>
			<?php } ?>
              
              
			  
             </div>
            </div> */ ?>
			
<?php do_action( 'woocommerce_after_single_product' ); ?>
