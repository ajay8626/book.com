<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}
require get_template_directory() . '/function/coupon-code.php';
if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyfifteen
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	/*
	 * Enable support for custom logo.
	 *
	 * @since Twenty Fifteen 1.5
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.

	/**
	 * Filter Twenty Fifteen custom-header support arguments.
	 *
	 * @since Twenty Fifteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-color     		Default color of the header.
	 *     @type string $default-attachment     Default attachment of the header.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}
	
	if ( is_checkout() ) {
		wp_enqueue_script( 'twentyfifteen-fancybox', get_template_directory_uri().'/js/jquery.fancybox.js', array( 'jquery' ), '1.4', false );
		wp_enqueue_style( 'twentyfifteen-fancyboxcss', get_template_directory_uri().'/css/jquery.fancybox.css', array( 'twentyfifteen-style' ), '2.0' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Fifteen 1.7
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function twentyfifteen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyfifteen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyfifteen_resource_hints', 10, 2 );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';


add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    
    return $tabs;

}


/*
* Hide adminbar for all users except admin	
*/
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
 */
function wc_empty_cart_redirect_url() {
    return site_url();
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );


/*
* Remove breadcrumb
*/
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

/*
* Indian currency Symbol
*/
add_filter( 'woocommerce_currencies', 'add_inr_currency' );
add_filter( 'woocommerce_currency_symbol', 'add_inr_currency_symbol' );

function add_inr_currency( $currencies ) {
    $currencies['INR'] = 'INR';
    return $currencies;
}

function add_inr_currency_symbol( $symbol ) {
	$currency = get_option( 'woocommerce_currency' );
	switch( $currency ) {
		case 'INR': $symbol = 'Rs.'; break;
	}
	return $symbol;
}


/*
* change ADD TO CART button text	
*/
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
 
function woo_custom_cart_button_text() {
    return __( 'Buy Now', 'woocommerce' );
}


add_filter( 'woocommerce_price_trim_zeros', 'wc_hide_trailing_zeros', 10, 1 );
function wc_hide_trailing_zeros( $trim ) {
	// set to false to show trailing zeros
	return false;
}



add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,2);
if(!function_exists('wdm_add_item_data'))
{
    function wdm_add_item_data($cart_item_data,$product_id)
    {
        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
        global $woocommerce;
        session_start();    
		
		/* $bookusername =  $_POST['fname'];
		$bookusergender =  $_POST['gender'];
		$_SESSION['sess_bookusername'] = $bookusername;
		$_SESSION['sess_bookusergender'] = $bookusergender; */
	  
        /* if (isset($_SESSION['sess_bookusername']) && isset($_SESSION['sess_bookusergender'])) {
            $option1 = $_SESSION['sess_bookusername'];       
            $option2 = $_SESSION['sess_bookusergender'];       
            $new_value = array('bookusername' => $option1,'bookusergender' => $option2);
        } */
		
		if (isset($_SESSION['sess_bookusername']) && isset($_SESSION['sess_bookusergender'])) {
            $option1 = $_SESSION['sess_bookusername'];       
            $option2 = $_SESSION['sess_bookusergender'];       
            $new_value = array('bookusername' => $option1,'bookusergender' => $option2);
        }else if (isset($_SESSION['sess_bagusername']) && isset($_SESSION['sess_bagusergender'])) {
    		$option1 = $_SESSION['sess_bagusername'];       
            $option2 = $_SESSION['sess_bagusergender'];       
            $new_value = array('bagusername' => $option1,'bagusergender' => $option2);
        }else{
			$bookusername =  $_POST['fname'];
			$bookusergender =  $_POST['gender'];
			$_SESSION['sess_bookusername'] = $bookusername;
			$_SESSION['sess_bookusergender'] = $bookusergender;
			
			$option1 = $_SESSION['sess_bookusername'];       
            $option2 = $_SESSION['sess_bookusergender'];       
            $new_value = array('bookusername' => $option1,'bookusergender' => $option2);
		}
		
        if(empty($option1))
            return $cart_item_data;
        else
        {    
            if(empty($cart_item_data))
                return $new_value;
            else
                return array_merge($cart_item_data,$new_value);
        }
        unset($_SESSION['sess_bookusername']); 
        unset($_SESSION['sess_bagusername']);
        unset($_SESSION['sess_bagusergender']);
        unset($_SESSION['sess_bookusergender']);
        //unset($_SESSION['sess_visitors_email']);
        unset($_SESSION['sess_visitors_dob']);
        unset($_SESSION['sess_phonenumber']);
        //Unset our custom session variable, as it is no longer needed.
    }
}


add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3 );
if(!function_exists('wdm_get_cart_items_from_session'))
{
    function wdm_get_cart_items_from_session($item,$values,$key)
    {
    	if (array_key_exists( 'bookusername', $values ) )
        {
        	$item['bookusername'] = $values['bookusername'];
        }else if (array_key_exists( 'bagusername', $values ) )
        {
        	$item['bagusername'] = $values['bagusername'];
        }
        if (array_key_exists( 'bookusergender', $values ) )
        {
        	$item['bookusergender'] = $values['bookusergender'];
        }else if (array_key_exists( 'bagusergender', $values ) )
        {
        	$item['bagusergender'] = $values['bagusergender'];
        }
		return $item;
    }
}




add_filter('woocommerce_checkout_cart_item_quantity','wdm_add_user_custom_option_from_session_into_checkout',1,3);  
if(!function_exists('wdm_add_user_custom_option_from_session_into_checkout'))
{
 function wdm_add_user_custom_option_from_session_into_checkout($product_name, $values, $cart_item_key )
    {
        /*code to add custom data on Cart & checkout Page*/
        if(count($values['bookusername']) > 0) {
            $return_string = $product_name . "<dl class='variation'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td><b>Name</b> : <span class='kids_name'>" . $values['bookusername'] . "</span></td>";
            $return_string .= "<td><b>Gender</b> : " . $values['bookusergender'] . "</td></tr>";
            $return_string .= "</table></dl>";
            return $return_string;
        } else if(count($values['bagusername']) > 0) {
            $return_string = $product_name . "<dl class='variation'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
        	$return_string .= "<tr><td><b>Name</b> : <span class='kids_name'>" . $values['bagusername'] . "</span></td>";
            $return_string .= "<td><b>Gender</b> : " . $values['bagusergender'] . "</td></tr>";
            $return_string .= "</table></dl>";
            return $return_string;
      	} else {
            return $product_name;
        }
    }
}
add_filter('woocommerce_cart_item_name','wdm_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
 function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
        //echo "<pre>"; print_r($values); exit;
        /*code to add custom data on Cart & checkout Page*/
        if(count($values['bookusername']) > 0)
        {
            $return_string = $product_name . "<dl class='variation variation-cart'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td><b>Name</b> : " . $values['bookusername'] . "</td>";
            $return_string .= "<td><b>Gender</b> : " . $values['bookusergender'] . "</td></tr>";
            $return_string .= "</table></dl>"; 
            return $return_string;
        }else if(count($values['bagusername']) > 0)
        {
            $return_string = $product_name . "<dl class='variation variation-cart'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td><b>Name</b> : " . $values['bagusername'] . "</td>";
            $return_string .= "<td><b>Gender</b> : " . $values['bagusergender'] . "</td></tr>";
            $return_string .= "</table></dl>"; 
            return $return_string;
        }
        else
        {
            return $product_name;
        }
    }
}


add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
        $bookusername = $values['bookusername'];
        $bookusergender = $values['bookusergender'];
        if(!empty($bookusername))
        {
            wc_add_order_item_meta($item_id,'Name',$bookusername);  
        }
		if(!empty($bookusergender))
        {
            wc_add_order_item_meta($item_id,'Gender',$bookusergender);  
        }
		/* wc_add_order_item_meta($item_id,'custom_pay_status','0'); */
  }
}


add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('wdm_remove_user_custom_data_options_from_cart'))
{
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
			if ( $values['bookusername'] == $cart_item_key )
				unset( $woocommerce->cart->cart_contents[ $key ] );
			if ( $values['bookusergender'] == $cart_item_key )
				unset( $woocommerce->cart->cart_contents[ $key ] );
        }
    }
}


/*
	remove company name from checkout form
*/
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	unset($fields['billing']['billing_company']);
	unset($fields['shipping']['shipping_company']);
	unset($fields['billing']['billing_last_name']);
	unset($fields['shipping']['shipping_last_name']);
    return $fields;
}

function storefront_child_remove_unwanted_form_fields($fields) {
    unset( $fields ['company'] );
    unset( $fields ['last_name']);
    return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'storefront_child_remove_unwanted_form_fields' );



//Change the Billing Details checkout label
function wc_billing_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Billing details' :
            $translated_text = __( 'Shipping Details', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 ); 

add_filter('gettext', 'translate_reply');
add_filter('ngettext', 'translate_reply');

function translate_reply($translated) {
$translated = str_ireplace('Billing', 'Shipping', $translated);
return $translated;
}

/* ------------------------------------------------------------------------- *
* WordPress Dynamic XML Sitemap Without Plugin
* Codes By Emrah Gunduz & All In One SEO
* Updated And Edited By EXEIdeas
/* ------------------------------------------------------------------------- */
add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");
function eg_create_sitemap() {
$postsForSitemap = get_posts(array(
'numberposts' => -1,
'orderby' => 'modified',
'post_type' => array('post','page','product'),
'order' => 'DESC'
));
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap .= '<?xml-stylesheet type="text/xsl" href="sitemap-style.xsl"?>';
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
foreach($postsForSitemap as $post) {
setup_postdata($post);
$postdate = explode(" ", $post->post_modified);
$sitemap .= '<url>'.
'<loc>'. get_permalink($post->ID) .'</loc>'.
'<priority>1</priority>'.
'<lastmod>'. $postdate[0] .'</lastmod>'.
'<changefreq>daily</changefreq>'.
'</url>';
}
$sitemap .= '</urlset>';
$fp = fopen(ABSPATH . "sitemap.xml", 'w');
fwrite($fp, $sitemap);
fclose($fp);
}

// We use just one function for both jobs.
add_filter( 'comment_form_defaults', 't5_move_textarea' );
add_action( 'comment_form_top', 't5_move_textarea' );

/**
 * Take the textarea code out of the default fields and print it on top.
 *
 * @param  array $input Default fields if called as filter
 * @return string|void
 */
function t5_move_textarea( $input = array () )
{
    static $textarea = '';

    if ( 'comment_form_defaults' === current_filter() )
    {
       
        $textarea = $input['fields']['author'];
        $textarea .= $input['fields']['email'];
        $textarea .= $input['comment_field'];
       
        return $input;
    }

    print apply_filters( 'comment_form_field_comment', $textarea );
}



// Function to change email address
function wpb_sender_email( $original_email_address ) {
	$admin_email = get_option('admin_email');
    return $admin_email;
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
	return "Superkid's League";
}
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );


/*remove review section*/
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}


/*--redirect to checkout page direct*/
add_filter ('add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout() {
    global $woocommerce;
    $url = $_SERVER['REQUEST_URI'];
    $pageurl = explode('/', $url);
    $pageName = $pageurl[2];
    //echo "<pre>"; print_r($pageName);exit;
    if($pageName == "full-course"){
    	return $woocommerce->cart->get_cart_url();
    }else if($pageName == "english-maths-science-part-1"){
    	return $woocommerce->cart->get_cart_url();
    }else if($pageName == "english-maths-science-part-2"){
    	return $woocommerce->cart->get_cart_url();
    }else if($pageName == "english-books"){
    	return $woocommerce->cart->get_cart_url();
    }else if($pageName == "maths-books"){
    	return $woocommerce->cart->get_cart_url();
    }else if($pageName == "science-books"){
    	return $woocommerce->cart->get_cart_url();
    }else{
    	$checkout_url = $woocommerce->cart->get_checkout_url();
	    return $checkout_url;
    }

    /*if(($pageName != "full-course")){
    	$checkout_url = $woocommerce->cart->get_checkout_url();
	    return $checkout_url;
    }else{
    	return $woocommerce->cart->get_cart_url();
    }*/
}



/*---allow only 1 item in cart at a time---*/
add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart' );
function bbloomer_only_one_in_cart( $cart_item_data ) {
global $woocommerce;
$woocommerce->cart->empty_cart();
//wc_add_notice( 'You reached the maximum amount of items in your cart.', 'notice' );
return $cart_item_data;
}


add_filter( 'woocommerce_default_address_fields' , 'override_default_address_fields' );
function override_default_address_fields( $address_fields ) {
    // @ for first_name
    $address_fields['first_name']['label'] = __('', 'woocommerce');
    $address_fields['first_name']['placeholder'] = __('Full name (Father/Mother) *', 'woocommerce');
    $address_fields['address_1']['placeholder'] = __('Apartment, suite, unit etc.', 'woocommerce');
    $address_fields['address_2']['placeholder'] = __('Street address', 'woocommerce');
    return $address_fields;
}


add_filter( 'wc_add_to_cart_message_html', 'bbloomer_custom_add_to_cart_message' );
 
function bbloomer_custom_add_to_cart_message() {
 
global $woocommerce;
$return_to  = '';
$message    = sprintf('%s', $return_to,'', __('Product successfully added.', 'woocommerce') );
return $message;
}


//redirect to home page if cart is empty
add_action("template_redirect", 'redirection_function');
function redirection_function(){
    global $woocommerce;
    if( is_cart() && WC()->cart->cart_contents_count == 0){
        wp_safe_redirect( site_url() );
    }
}


/*customer order bcc*/
function techie_custom_wooemail_headers( $headers, $object ) {
	
	/* replace the emails below to your desire email */
	$emails = array('orders@superkidsleague.com');
	
	switch($object) {
		case 'new_order':
		case 'customer_processing_order':
		case 'customer_completed_order':
		case 'customer_invoice':
			$headers .= 'Bcc: ' . implode(',', $emails) . "\r\n";
			break;
		default:
	}
 
	return $headers;
}
add_filter( 'woocommerce_email_headers', 'techie_custom_wooemail_headers', 10, 2);

function bbloomer_set_checkout_field_input_value_default($fields) {
    if(isset($_SESSION['sess_bagusername'])){
		$fields['billing']['billing_kidsname']['default'] = $_SESSION['sess_bagusername'];	
	}else{
		$fields['billing']['billing_kidsname']['default'] = $_SESSION['sess_bookusername'];
	}
    //$fields['billing']['billing_email']['default'] = $_SESSION['sess_visitors_email'];
    if(isset($_SESSION['sess_visitors_dob'])){
    	$fields['billing']['billing_dob']['default'] = $_SESSION['sess_visitors_dob'];	
    }
    if(isset($_SESSION['sess_phonenumber'])){
    	$fields['billing']['billing_phone']['default'] = $_SESSION['sess_phonenumber'];
    }
    return $fields;
}
 add_filter( 'woocommerce_checkout_fields', 'bbloomer_set_checkout_field_input_value_default' );

/* ADDING COLUMN TITLE */
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column',11);
function custom_shop_order_column($columns)
{
	$new_columns = ( is_array( $columns ) ) ? $columns : array();
  	unset( $new_columns[ 'billing_address' ] );
  	unset( $new_columns[ 'shipping_address' ] );
  	unset( $new_columns[ 'customer_message' ] );
  	unset( $new_columns[ 'order_notes' ] );
  	unset( $new_columns[ 'order_date' ] );
  	unset( $new_columns[ 'order_total' ] );
  	unset( $new_columns[ 'order_actions' ] );
	
   /* add columns */
   /* $new_columns['custom_pay_status'] = __( 'Paytm'); */
    $new_columns['kids_details'] = __( 'Kid\'s Details');
	/* $new_columns['kids_photo'] = __( 'Kid\'s Photo'); */
	$new_columns['get_product'] = __( 'Product');
	$new_columns['get_hardbound'] = __( 'Hard Bound');
	$new_columns['get_delivery'] = __( 'Urgent Delivery');
	$new_columns['get_certi'] = __( 'CERTIFICATE');
	
	$new_columns[ 'billing_address' ] = $columns[ 'billing_address' ];
	$new_columns[ 'shipping_address' ] = $columns[ 'shipping_address' ];
	/* $new_columns[ 'customer_message' ] = $columns[ 'customer_message' ]; */
	/* $new_columns[ 'order_notes' ] = $columns[ 'order_notes' ]; */
	$new_columns[ 'order_date' ] = $columns[ 'order_date' ];
	$new_columns[ 'order_total' ] = $columns[ 'order_total' ];
	$new_columns[ 'order_actions' ] = $columns[ 'order_actions' ];
   return $new_columns;
}

/* adding Kids details in order column */
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 10, 2 );
function custom_orders_list_column_content( $column ){
	global $post, $woocommerce, $the_order, $wpdb;
    $order_id = $the_order->id;
	$order = new WC_Order($order_id);
    $items = $order->get_items();
	$hardBoundCover = $wpdb->get_results("SELECT * FROM `wp_woocommerce_order_items` WHERE (`order_item_name` = 'Hard bound cover' AND `order_id` = '". $order_id ."')");
    $deliveryMethod = $wpdb->get_results("SELECT * FROM `wp_woocommerce_order_items` WHERE (`order_item_name` = 'Urgent Delivery Charge' AND `order_id` = '". $order_id ."')");
    if(!empty($hardBoundCover)){
    	$hardBound = $hardBoundCover[0]->order_item_name;
    }else{
    	$hardBound = "";
    }
    if(!empty($deliveryMethod)){
    	$urgentDelivery = $deliveryMethod[0]->order_item_name;	
    }else{
    	$urgentDelivery = '';
    }
	foreach ($items as $item_id => $item) {
		$itemData = (array)$item;
		$dataItem = $itemData["\0*\0" . 'data'];
		$productName = $dataItem['name'];
		switch ( $column )
		{
			case 'custom_pay_status' :
				$custom_pay_status = wc_get_order_item_meta( $item_id, 'custom_pay_status', true );
				$paytm = get_post_meta($order_id,'_payment_method',true);
				$paged='';
				if(isset($_REQUEST['paged'])){
					$paged="&paged=".$_REQUEST['paged'];
				}
				if($paytm == 'custom-cod'){
					if($custom_pay_status && $custom_pay_status == 1){
						echo '<strong style="background-color:green;color: #fff;">Done</strong>';
					}else{
						echo '<strong style="background-color:red;color: #fff;"><a href="admin.php?page=change_pay_status&pay_type=paytm&pay_status=0&order_id='.$order_id.$paged.'"  style="color: #fff;">Pending</a></strong>';
					}
				}else{
					echo "-";
				}
				break;
			case 'kids_details' :
				$Name = wc_get_order_item_meta( $item_id, 'Name', true );
				$Gender = wc_get_order_item_meta( $item_id, 'Gender', true );
				if(is_array($Name)){
					echo 'Name: <b>'.$Name[0].'</b> <br>Gender: <b>'.$Gender[0].'</b> <br><br>';
				}else{
					echo 'Name: <b>'.$Name.'</b> <br>Gender: <b>'.$Gender.'</b> <br><br>';
				}
				if($productName == 'Superkid’s League Book'){
					$photo = get_post_meta( $order_id, '_kidsphoto', true );
					if($photo){
						echo 'Kids Photo : <a href="'.$photo.'" target="_blank">Yes</a>';
					}else{
						echo 'Kids Photo : No<br>';
					}
				}
				
				break;

			case 'get_product' :
					echo $productName;
				break;
			case 'get_hardbound' :
                if($productName == 'Superkid’s League Book'){
                    if($hardBound == 'Hard bound cover'){
                        echo '<a href="admin.php?page=hardboundcover&order_id='.$order_id.'" target="_blank"><div style="border:1px sold green; height:20px; width:30px;background-color:green;color:#fff; text-align:center;">Yes</div></a>';
                    } else {
                        echo '<a href="admin.php?page=hardboundcover&order_id='.$order_id.'" target="_blank"><div style="border:1px sold red; height:20px; width:30px;background-color:red;color:#fff; text-align:center;">No</div></a>';
                    }
                }
                break;
			case 'get_delivery' :
            	if($urgentDelivery == 'Urgent Delivery Charge'){
                    echo '<a href="admin.php?page=shipping_delivery&order_id='.$order_id.'" target="_blank"><div style="border:1px sold green; height:20px; width:30px;background-color:green;color:#fff; text-align:center;">Yes</div></a>';
                } else {
                    echo '<a href="admin.php?page=shipping_delivery&order_id='.$order_id.'" target="_blank"><div style="border:1px sold red; height:20px; width:30px;background-color:red;color:#fff; text-align:center;">No</div></a>';
                }
				break;
			case 'get_certi' :
				$Name = wc_get_order_item_meta( $item_id, 'Name', true );
				$Gender = wc_get_order_item_meta( $item_id, 'Gender', true );
				if($productName == 'Superkid’s League Book'){
					if(is_array($Name)){
						echo '<a href="admin.php?page=front_page_pdf&bu_name='.$Name[0].'&bu_gender='.$Gender[0].'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name[0].'_front_page.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=docpdf&bu_name='.$Name[0].'&bu_gender='.$Gender[0].'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name[0].'_certi.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=enddocpdf&bu_name='.$Name[0].'&bu_gender='.$Gender[0].'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name[0].'_ending.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=prologuedocpdf&bu_name='.$Name[0].'&bu_gender='.$Gender[0].'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name[0].'_prologue.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=kidsorder_photo&bu_name='.$Name.'&bu_gender='.$Gender[0].'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name[0].'_photo.pdf</a>';
					}else{
						echo '<a href="admin.php?page=front_page_pdf&bu_name='.$Name.'&bu_gender='.$Gender.'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name.'_front_page.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=docpdf&bu_name='.$Name.'&bu_gender='.$Gender.'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name.'_certi.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=enddocpdf&bu_name='.$Name.'&bu_gender='.$Gender.'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name.'_ending.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=prologuedocpdf&bu_name='.$Name.'&bu_gender='.$Gender.'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name.'_prologue.pdf</a>';
						echo '<br />__<br /><a href="admin.php?page=kidsorder_photo&bu_name='.$Name.'&bu_gender='.$Gender.'&order_id='.$order_id.'" target="_blank">'.$order_id.'_'.$Name.'_photo.pdf</a>';
					}
				}
				break;
			/* 	case 'kids_photo' :
				$photo = get_post_meta( $order_id, '_kidsphoto', true );
				if($photo){
					echo '<a href="'.$photo.'" target="_blank">Yes</a>';
				}else{
					echo 'No<br>';
				}
				break; */
			case 'shipping_address' :
				$billing_landmark = wc_get_order_item_meta( $item_id, 'billing_landmark', true );
				$billing_house_number = wc_get_order_item_meta( $item_id, 'billing_house_number', true );				
				$billing_street_address = wc_get_order_item_meta( $item_id, 'billing_street_address', true );				
				$columns[ 'shipping_address' ] =  $billing_house_number.$billing_street_address.$billing_landmark;
				break;
			case 'billing_address' :
				$billing_landmark = wc_get_order_item_meta( $item_id, 'billing_landmark', true );
				$billing_house_number = wc_get_order_item_meta( $item_id, 'billing_house_number', true );
				$billing_street_address = wc_get_order_item_meta( $item_id, 'billing_street_address', true );
				
				$columns[ 'billing_address' ] =  $billing_house_number.$billing_street_address.$billing_landmark;
				break;
		}
	}
	
}

/*---css in admin---*/
add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
  echo '<style>
    #woocommerce_dashboard_status .inside .wc_status_list .sales-this-month, #woocommerce_dashboard_status .inside .wc_status_list .best-seller-this-month, #woocommerce_dashboard_status .inside .wc_status_list .on-hold-orders, #woocommerce_dashboard_status .inside .wc_status_list .low-in-stock, #woocommerce_dashboard_status .inside .wc_status_list .out-of-stock{ display:none;}
	#woocommerce_dashboard_status .inside .wc_status_list .processing-orders{ width:100%;}
	
	.order_data_column_container .order_data_column:nth-child(3) .address p:nth-child(2) {    background-color: green;    color: #fff !important;}
  </style>';
}


function admin_default_page() {
  return site_url().'/wp-admin/edit.php?post_type=shop_order';
}
add_filter('login_redirect', 'admin_default_page');


function register_neworder_order_status() {
    register_post_status( 'wc-neworder', array(
        'label'                     => 'New Order',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'New Order <span class="count">(%s)</span>', 'New Order <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_neworder_order_status' );

// Add to list of WC Order statuses
function add_neworder_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        //if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-neworder'] = 'New Order';
       // }
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_neworder_to_order_statuses' );


add_action( 'woocommerce_thankyou', 'my_change_status_function' );

function my_change_status_function( $order_id ) {

    $order = new WC_Order( $order_id );
    if ( $order->status != 'on-hold' && $order->status != 'pending' && $order->status != 'failed' && $order->status != 'neworder'){
		$order->update_status( 'neworder' );		
		
		$phone = $order->get_billing_phone();
		if($phone != ''){
			$items = $order->get_items();
			$Name = '';
			$gender = '';
			foreach ($items as $item_id => $item) {
				$Name = wc_get_order_item_meta( $item_id, 'Name', true );
				$gender = wc_get_order_item_meta( $item_id, 'Gender', true );
			}
			if($Name == ''){ $Name == "Superkid"; }
			$NewDate=Date('d-M', strtotime("+10 days"));
			$NewDate = str_replace('Sep', 'Sept', $NewDate);
			/* $msg = urlencode("Confirmed: Order No. ".$order_id." for Book on ".$Name." - Journey of SuperKid is successfully placed & will reach to you before ".$NewDate.". For any query call us on 079-48904076"); */
			
			/* $msg = urlencode("Congrats:You order No. ".$order_id." is confirmed.Your SuperKid book is on the way. Name-".$Name.",Gender-".$gender.".If there is any change,please call us on 9099903376"); */
			
			$msg = urlencode("Your order No. ".$order_id." for Super Kids book for ". strtoupper(trim($Name)) ." has been successfully placed. Call 9099903376 in case of any change. Journey of ur SUPER KID has just begun!");
						
			$newurl = 'http://sms.infisms.co.in/API/SendSMS.aspx?UserID=Abbacus&UserPassword=abbacus@123&SenderId=SUPKID&PhoneNumber='.$phone.'&AccountType=2&Text=' . $msg;
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $newurl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
			curl_close($curl);
			$resArr = json_decode($result);	
			$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				"NewDate:".$NewDate.PHP_EOL.
				"Name:".$Name.PHP_EOL.
				"resArr:".$result.PHP_EOL.
				"phone:".$phone.PHP_EOL.
				"-------------------------".PHP_EOL;
			file_put_contents('./smslog/smslog_'.time().'.txt', $log, FILE_APPEND);
		}
		
		
	}

}

add_action('admin_head', 'wc_order_status_styling');

function wc_order_status_styling() {
  echo '<style>
   .widefat .column-order_status mark.neworder::after { color:#0073aa;
	   font-family: WooCommerce;
    speak: none;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    text-indent: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
	content: "N";
	
}

.widefat .column-order_status mark.processing-two::after { color:#0073aa;
	   font-family: WooCommerce;
    speak: none;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    text-indent: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
	content: "P2";
	font-size: 14px;
}
.widefat .column-order_status mark.processing-three::after { color:#0073aa;
	   font-family: WooCommerce;
    speak: none;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    text-indent: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
	content: "P3";
	font-size: 14px;
}

.widefat .column-order_status mark.shipped::after { color:#0073aa;
	   font-family: WooCommerce;
    speak: none;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    text-indent: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
	content: "S";
	font-size: 14px;
}

  </style>';
}


add_filter( 'woocommerce_email_styles', 'patricks_woocommerce_email_styles' );
function patricks_woocommerce_email_styles( $css ) {
	$css .= "#template_header { background-color: #82AF39; }";
	return $css;
}



add_action('woocommerce_order_status_changed', 'backorder_status_custom_notification', 10, 4);
function backorder_status_custom_notification( $order_id, $from_status, $to_status, $order ) {

	//if( $order->has_status( 'neworder' )) {
	if( $from_status == 'processing' && $to_status == 'neworder') {
		// Getting all WC_emails objects
        $email_notifications = WC()->mailer()->get_emails();

        // Customizing Heading and subject In the WC_email processing Order object
        $email_notifications['WC_Email_Customer_Processing_Order']->heading = __('Thank you for placing order with SuperKids League.','woocommerce');
        $email_notifications['WC_Email_Customer_Processing_Order']->subject = 'Order Confirmed for your Super Kid.. order receipt from {order_date}';

        // Sending the customized email
        $email_notifications['WC_Email_Customer_Processing_Order']->trigger( $order_id );
    }			
}


add_action('woocommerce_order_status_changed', 'backorder_status_custom_notification9', 10, 4);
function backorder_status_custom_notification9( $order_id, $from_status, $to_status, $order ) {
//print_r($order);
//echo $order->from;
 //exit;
	//if( $order->has_status( 'processing' ) ) {
	if( $from_status != 'pending' && $order->has_status( 'processing' )) {
    // Getting all WC_emails objects
    $email_notifications = WC()->mailer()->get_emails();

    // Customizing Heading and subject In the WC_email processing Order object
    $email_notifications['WC_Email_Customer_Processing_Order']->heading = __("We are designing your kid's special book. You will soon hear from us about the next stage.",'woocommerce');
    $email_notifications['WC_Email_Customer_Processing_Order']->subject = 'Your {site_title} processing order receipt from {order_date}';

    // Sending the customized email
    $email_notifications['WC_Email_Customer_Processing_Order']->trigger( $order_id );
	}
}	



// To add Processing Level Two Status

function register_processing_level_two_order_status() {
    register_post_status( 'wc-processing-two', array(
        'label'                     => 'Processing Level Two',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Processing Level Two <span class="count">(%s)</span>', 'Processing Level Two <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_processing_level_two_order_status' );

function add_processing_level_two_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing' == $key ) {
           $new_order_statuses['wc-processing-two'] = 'Processing Level Two';
        }
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_processing_level_two_to_order_statuses' );


add_action('woocommerce_order_status_changed', 'backorder_status_custom_notification2', 10, 4);
function backorder_status_custom_notification2( $order_id, $from_status, $to_status, $order ) {

   if( $order->has_status( 'processing-two' )) {

        // Getting all WC_emails objects
        $email_notifications = WC()->mailer()->get_emails();

        // Customizing Heading and subject In the WC_email processing Order object
        $email_notifications['WC_Email_Customer_Processing_Order']->heading = __("Yepee! You kid's book has been designed successfully and now in printing hub. You will soon hear from us once the book is printed.",'woocommerce');
		$email_notifications['WC_Email_Customer_Processing_Order']->subject = 'Your {site_title} processing order receipt from {order_date}';
        // Sending the customized email
        $email_notifications['WC_Email_Customer_Processing_Order']->trigger( $order_id );
    }
}


// To add Processing Level Three Status

function register_processing_level_three_order_status() {
    register_post_status( 'wc-processing-three', array(
        'label'                     => 'Processing Level Three',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Processing Level Three <span class="count">(%s)</span>', 'Processing Level Three <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_processing_level_three_order_status' );

function add_processing_level_three_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing-two' === $key ) {
           $new_order_statuses['wc-processing-three'] = 'Processing Level Three';
        }
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_processing_level_three_to_order_statuses' );

add_action('woocommerce_order_status_changed', 'backorder_status_custom_notification3', 10, 4);
function backorder_status_custom_notification3( $order_id, $from_status, $to_status, $order ) {

   if( $order->has_status( 'processing-three' )) {

        // Getting all WC_emails objects
        $email_notifications = WC()->mailer()->get_emails();

        // Customizing Heading and subject In the WC_email processing Order object
        $email_notifications['WC_Email_Customer_Processing_Order']->heading = __("Hurrah! Your kid's special book has been printed and getting ready to be shipped to you. You will hear soon from us once shipping has been done!",'woocommerce');
        $email_notifications['WC_Email_Customer_Processing_Order']->subject = 'Your {site_title} processing order receipt from {order_date}';

        // Sending the customized email
        $email_notifications['WC_Email_Customer_Processing_Order']->trigger( $order_id );
    }
}

// To add Processing "Shipped" Status

function register_processing_level_shipped_order_status() {
    register_post_status( 'wc-shipped', array(
        'label'                     => 'Shipped',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_processing_level_shipped_order_status' );

function add_processing_level_shipped_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing-three' === $key ) {
           $new_order_statuses['wc-shipped'] = 'Shipped';
        }
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_processing_level_shipped_to_order_statuses' );

add_action('woocommerce_order_status_changed', 'backorder_status_custom_notification_shipped', 10, 4);
function backorder_status_custom_notification_shipped( $order_id, $from_status, $to_status, $order ) {

   if( $order->has_status( 'shipped' )) {

        // Getting all WC_emails objects
        $email_notifications = WC()->mailer()->get_emails();

        // Customizing Heading and subject In the WC_email processing Order object
        $email_notifications['WC_Email_Customer_Processing_Order']->heading = __("Shipped!<br> Your kid's awesome book is on the way. It will soon reach your home.  Thanks for keeping patience. You have been a wonderful customer!",'woocommerce');
        $email_notifications['WC_Email_Customer_Processing_Order']->subject = 'Your {site_title} order receipt from {order_date}';

        // Sending the customized email
        $email_notifications['WC_Email_Customer_Processing_Order']->trigger( $order_id );
		
		
		$phone = $order->get_billing_phone();
		if($phone != ''){
			$items = $order->get_items();
			$Name = '';
			foreach ($items as $item_id => $item) {
				$Name = wc_get_order_item_meta( $item_id, 'Name', true );
			}
			if($Name == ''){ $Name == "Superkid"; }
			$msg = urlencode("Dispatched: Your package of Book on ".$Name." - Journey of SuperKid, It will reached in 3 days. For Any Query Call us on 079-48904076");
			$newurl = 'http://sms.infisms.co.in/API/SendSMS.aspx?UserID=Abbacus&UserPassword=abbacus@123&SenderId=SUPKID&PhoneNumber='.$phone.'&AccountType=2&Text=' . $msg;
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $newurl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
			curl_close($curl);
			$resArr = json_decode($result);	
			$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				"Name:".$Name.PHP_EOL.
				"resArr:".$result.PHP_EOL.
				"phone:".$phone.PHP_EOL.
				"-------------------------".PHP_EOL;
			file_put_contents('./smslog/smslog_'.time().'.txt', $log, FILE_APPEND);
		}
		
    }
}


function mysite_woocommerce_order_status_completed( $order_id, $order ) {
    $phone = $order->get_billing_phone();
		if($phone != ''){
			$items = $order->get_items();
			$Name = '';
			$Gender = 'Boy';
			foreach ($items as $item_id => $item) {
				$Name = wc_get_order_item_meta( $item_id, 'Name', true );
				$Gender = wc_get_order_item_meta( $item_id, 'Gender', true );
			}
			if($Name == ''){ $Name == "Superkid"; }
			if($Gender == 'Boy' || $Gender == 'boy'){
				$msg = urlencode("Delivered: Book on ".$Name." - Journey of SuperKid is successfully delivered. Hope he will like the book which is made with love");
			}else{
				$msg = urlencode("Delivered: Book on ".$Name." - Journey of SuperKid is successfully delivered. Hope she will like the book which is made with love");
			}
			$newurl = 'http://sms.infisms.co.in/API/SendSMS.aspx?UserID=Abbacus&UserPassword=abbacus@123&SenderId=SUPKID&PhoneNumber='.$phone.'&AccountType=2&Text=' . $msg;
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $newurl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
			curl_close($curl);
			$resArr = json_decode($result);	
			$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				"Name:".$Name.PHP_EOL.
				"resArr:".$result.PHP_EOL.
				"phone:".$phone.PHP_EOL.
				"-------------------------".PHP_EOL;
			file_put_contents('./smslog/smslog_'.time().'.txt', $log, FILE_APPEND);
		}
}
add_action( 'woocommerce_order_status_completed', 'mysite_woocommerce_order_status_completed', 10, 2 );



/************* disable email new order ******************/

add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );


function unhook_those_pesky_emails( $email_class ) {
	
remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );

}
/************* disable email new order ends here ******************/



// code for cron job starts here 
 function isa_add_every_one_minutes( $schedules ) {
 
    $schedules['every_one_minutes'] = array(
			'interval'  => 60,
            'display'   => __( 'Every 1 Minutes')
    );
     
    return $schedules;
}
add_filter( 'cron_schedules', 'isa_add_every_one_minutes' ); 

if( !wp_next_scheduled( 'change_woo_order_status_hook' ) ) {
   wp_schedule_event( time(), 'daily', 'change_woo_order_status_hook' );
}

/*add_action('change_woo_order_status_hook','change_woo_order_status', 1, 1);*/
function change_woo_order_status($args) {
	$status=array('wc-processing','wc-neworder','wc-processing-two');
	/* foreach($status as $state){
		$neworder_orders = wc_get_orders( $args = array(
			'numberposts' => -1,
			'post_status' => $state,
		) );
		if(!empty($neworder_orders)){
			foreach($neworder_orders as $orders){
				$order_data = $orders->get_data(); 
				$order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
				if(date('Y-m-d', strtotime('+2 day', strtotime($order_date_created))) == date('Y-m-d') ){
					//$order_id = $order_data['id'];
					$to = 'vivek@webtechsystem.com';
					$subject = 'Superkids cron mail';
					$body = 'cron has updated status for orderid='.$order_data['id'].'new order to processing';
					$headers = array('Content-Type: text/html; charset=UTF-8');
					wp_mail( $to, $subject, $body, $headers );
				 	if($state == 'wc-neworder'){
						$orders->update_status( 'processing', sprintf( __( 'Payment is past expiration time.', 'woocommerce' )) );
					}
				}
				if(date('Y-m-d', strtotime('+4 day', strtotime($order_date_created))) == date('Y-m-d') ){
					$to = 'vivek@webtechsystem.com';
					$subject = 'Superkids cron mail';
					$body = 'cron has updated status for orderid='.$order_data['id'].'processing to processing-two';
					$headers = array('Content-Type: text/html; charset=UTF-8');
					wp_mail( $to, $subject, $body, $headers );
					if($state == 'wc-processing'){
						$orders->update_status( 'processing-two', sprintf( __( 'Payment is past expiration time.', 'woocommerce' )) );
					}
				}
				if(date('Y-m-d', strtotime('+6 day', strtotime($order_date_created))) == date('Y-m-d') ){
					$to = 'vivek@webtechsystem.com';
					$subject = 'Superkids cron mail';
					$body = 'cron has updated status for orderid='.$order_data['id'].'processing-two to processing-three' ;
					$headers = array('Content-Type: text/html; charset=UTF-8');
					wp_mail( $to, $subject, $body, $headers );
					if($state == 'wc-processing-two'){
						$orders->update_status( 'processing-three', sprintf( __( 'Payment is past expiration time.', 'woocommerce' )) );
					} 
				}	
				
			}
		}
	} */
}
//wp_clear_scheduled_hook('change_woo_order_status_hook');
//add new billing fields
add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');

function custom_woocommerce_billing_fields($fields)
{

    $fields['billing_landmark'] = array(
        'label' => __('', 'woocommerce'), // Add custom field label
        //'placeholder' => _x('Landmark', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => false, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'text', // add field type
        'placeholder' => 'Landmark',
        'class' => array('my-css')    // add class name
    );
	$fields['billing_kidsname'] = array(
        'label' => __('', 'woocommerce'),
        'required' => false,
        'clear' => false,
        'type' => 'text',
        'placeholder' => 'Kid\'s Name',
        'class' => array('my-css')
    );
	
	$fields['billing_house_number'] = array(
        'label' => __('Locality/Area', 'woocommerce'),
        'required' => false,
        'clear' => false,
        'type' => 'text',
		'placeholder'=>'',
		'class' => array('my-css')
    );
	
	$fields['billing_street_address'] = array(
        'label' => '',
        'required' => false,
        'clear' => false,
		'type' => 'text',
		'placeholder'=>'',
        'class' => array('my-css')
    );
	
	$fields['billing_landline'] = array(
        'label' => __('', 'woocommerce'),
        'required' => false,
        'clear' => false,
        'type' => 'number',
        'placeholder' => 'Secondary Mobile Number',
        'class' => array('form-row-last','setline')
    );
	
	unset($fields['billing']['billing_address_1']);
	$fields['billing_address_1'] = array(
        'label' =>  __('', 'woocommerce'),
        'required' => false,
        'clear' => false,
        'type' => 'text',
		'placeholder'=>'Flat / House No. / Floor / Building',       
        'class' => array('form-row-wide')
    );
	
	unset($fields['billing']['billing_address_2']);
	$fields['billing_address_2'] = array(
        'label' => __('', 'woocommerce'),
        'required' => false,
        'clear' => false,
        'type' => 'text',
		'placeholder'=>'Colony / Street / Locality',
        'class' => array('form-row-wide')
    );
	
	unset($fields['billing']['billing_postcode']);
	$fields['billing_postcode'] = array(
        'label' => __('', 'woocommerce'),
        'required' => true,
        'clear' => false,
        'type' => 'text',
        'placeholder' => 'Postcode *',
        'class' => array('form-row-wide')
    );
	
	unset($fields['billing']['billing_phone']);
	$fields['billing_phone'] = array(
        'label' => __('', 'woocommerce'),
        'required' => true,
        'clear' => false,
        'type' => 'number',
        'placeholder' => 'Mobile No.*',
        'class' => array('form-row-first')
    );
	
	$fields['billing_email']['class'] = array('form-row-first');
	$fields['billing_secondry_email'] = array(
        'label' => __('', 'woocommerce'),
        'required' => false,
        'clear' => false,
        'type' => 'email',
        'placeholder' => 'Secondary Email Address (optional)',
        'class' => array('form-row-last','setline')
    );
	
    return $fields;
}
add_filter("woocommerce_checkout_fields", "new_order_fields");
function new_order_fields($fields) {

$order_list = array(
    "billing_first_name", 
    "billing_kidsname", 
    "billing_address_1",
    "billing_address_2", 
    "billing_house_number", 
    "billing_street_address", 
    "billing_landmark", 
	"billing_city",	
    "billing_state", 
    "billing_postcode", 
    "billing_phone", 
    "billing_landline", 
	"billing_email",
	"billing_secondry_email",
);
foreach($order_list as $field)
{
    $ordered_fields[$field] = $fields["billing"][$field];
}

$fields["billing"] = $ordered_fields;
return $fields;

}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['billing_landmark'] ) ) {
        update_post_meta( $order_id, 'billing_landmark', sanitize_text_field( $_POST['billing_landmark'] ) );
    }
	if ( ! empty( $_POST['billing_landline'] ) ) {
        update_post_meta( $order_id, 'billing_landline', sanitize_text_field( $_POST['billing_landline'] ) );
    }
	if ( ! empty( $_POST['billing_kidsname'] ) ) {
        update_post_meta( $order_id, 'billing_kidsname', sanitize_text_field( $_POST['billing_kidsname'] ) );
    }
	if ( ! empty( $_POST['billing_house_number'] ) ) {
        update_post_meta( $order_id, 'billing_house_number', sanitize_text_field( $_POST['billing_house_number'] ) );
    }
	if ( ! empty( $_POST['billing_street_address'] ) ) {
        update_post_meta( $order_id, 'billing_street_address', sanitize_text_field( $_POST['billing_street_address'] ) );
    }
	
	/*
	 * Personalised detail form for first page text in book
	 */
	/* if ( isset( $_POST['personalised_detail'] ) ) {
		update_post_meta(  $order_id, '_personalised_detail', $_POST['personalised_detail'] );		
	} */
	/*
	 * Special Message first page text in book
	 */
	if ( isset( $_POST['special_message'] ) ) {
		update_post_meta(  $order_id, '_special_message', $_POST['special_message'] );		
	}
	
	if ( isset( $_POST['billing_secondry_email'] ) ) {
		update_post_meta(  $order_id, 'billing_secondry_email', $_POST['billing_secondry_email'] );		
	}
}


/**
 * Display field value on the order edit page
 */
 
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__('Street Address').':</strong>' . get_post_meta( $order->get_id(), 'billing_house_number', true ) . ' ' .get_post_meta( $order->get_id(), 'billing_street_address', true ) . '</p>';
	echo '<p><strong>'.__('Landmark').':</strong> <br/>' . get_post_meta( $order->get_id(), 'billing_landmark', true ) . '</p>';
    echo get_post_meta( $order->get_id(), 'billing_landline', true )?'<p><strong>'.__('Secondary Mobile Number').':</strong> <br/>' . get_post_meta( $order->get_id(), 'billing_landline', true ) . '</p>':'';
	echo get_post_meta( $order->get_id(), 'billing_secondry_email', true )?'<p><strong>'.__('Secondary Email Address').':</strong> <br/>' . get_post_meta( $order->get_id(), 'billing_secondry_email', true ) . '</p>':''; 
    echo '<p><strong>'.__('Kid\'s Name').':</strong> <br/>' . get_post_meta( $order->get_id(), 'billing_kidsname', true ) . '</p>';
}
add_filter( 'woocommerce_checkout_coupon_message', 'woocommerce_rename_coupon_message_on_checkout' );
// rename the "Have a Coupon?" message on the checkout page
function woocommerce_rename_coupon_message_on_checkout() { 
	return 'Have a coupon?' . ' <a href="#" class="showcoupon">' . __( 'Click here', 'woocommerce' ) . '</a> to enter your code';
}



add_filter( 'woocommerce_checkout_fields' , 'change_state_label_checkout_fields' );
function change_state_label_checkout_fields( $fields ) {
    /*$fields['billing']['billing_state']['label'] = '';
    $fields['billing']['billing_state']['placeholder'] = 'states';
    return $fields;*/ 
    $option_cities = array(
        '' => __( 'SELECT YOUR STATE' ),
        'ANDHRA PRADESH' => 'ANDHRA PRADESH',
        'ARUNACHAL PRADESH' => 'ARUNACHAL PRADESH',
        'ASSAM' => 'ASSAM',
        'BIHAR' => 'BIHAR',
        'CHHATTISGARH' => 'CHHATTISGARH',
        'GOA' => 'GOA',
        'GUJARAT' => 'GUJARAT',
        'HARYANA' => 'HARYANA',
        'HIMACHAL PRADESH' => 'HIMACHAL PRADESH',
        'JAMMU AND KASHMIR' => 'JAMMU AND KASHMIR',
        'JHARKHAND' => 'JHARKHAND',
        'KARNATAKA' => 'KARNATAKA',
        'KERALA' => 'KERALA',
        'MADHYA PRADESH' => 'MADHYA PRADESH',
        'MAHARASHTRA' => 'MAHARASHTRA',
        'MANIPUR' => 'MANIPUR',
        'MEGHALAYA' => 'MEGHALAYA',
        'MIZORAM' => 'MIZORAM',
        'NAGALAND' => 'NAGALAND',
        'ORISSA' => 'ORISSA',
        'PUNJAB' => 'PUNJAB',
        'RAJASTHAN' => 'RAJASTHAN',
        'SIKKIM' => 'SIKKIM',
        'TAMIL NADU' => 'TAMIL NADU',
        'TELANGANA' => 'TELANGANA',
        'TRIPURA' => 'TRIPURA',
        'UTTARAKHAND' => 'UTTARAKHAND',
        'UTTAR PRADESH' => 'UTTAR PRADESH',
        'WEST BENGAL' => 'WEST BENGAL',
        'ANDAMAN AND NICOBAR ISLANDS' => 'ANDAMAN AND NICOBAR ISLANDS',
        'CHANDIGARH' => 'CHANDIGARH',
        'DADRA AND NAGAR HAVELI' => 'DADRA AND NAGAR HAVELI',
        'DAMAN AND DIU' => 'DAMAN AND DIU',
        'DELHI' => 'DELHI',
        'LAKSHADEEP' => 'LAKSHADEEP',
        'PONDICHERRY (PUDUCHERRY)' => 'PONDICHERRY (PUDUCHERRY)',
    );
    $fields['billing']['billing_state']['type'] = 'select';
    $fields['billing']['billing_state']['label'] = '';
    $fields['billing']['billing_state']['options'] = $option_cities;
    return $fields;
}



// adding Landmark in order column
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content1', 10, 2 );
function custom_orders_list_column_content1( $column ){
	global $post, $woocommerce, $the_order;
    $order_id = $the_order->get_id();
	$order = new WC_Order($order_id);
    $items = $order->get_items();	
	foreach ($items as $item_id => $item) {
		switch ( $column )
		{
			
			case 'shipping_address' :
				$billing_house_number = get_post_meta( $order_id, 'billing_house_number' );
				$billing_street_address = get_post_meta( $order_id, 'billing_street_address' );
				$billing_landmark = get_post_meta( $order_id, 'billing_landmark' );
				if(!empty($billing_house_number)){ 
					echo "<br><b>".$billing_house_number[0]."</b>";
					echo "<br><b>".$billing_street_address[0]."</b>";
				}
				if(!empty($billing_landmark)){ 
					echo "<br><b>Landmark : ".$billing_landmark[0]."</b>";
				}	
				break;
			case 'billing_address' :
				$billing_house_number = get_post_meta( $order_id, 'billing_house_number' );
				$billing_street_address = get_post_meta( $order_id, 'billing_street_address' );
				$billing_landmark = get_post_meta( $order_id, 'billing_landmark' );
				if(!empty($billing_house_number)){ 
					echo "<br><b>".$billing_house_number[0]."</b>";
					echo "<br><b>".$billing_street_address[0]."</b>";
				}
				if(!empty($billing_landmark)){ 
					echo "<br><b>Landmark : ".$billing_landmark[0]."</b>";
				}	
				break;
		}
	}
	
}

function filter_woocommerce_states( $states ) { 
	if (array_key_exists("IN",$states)){
	$newstate = array();
	foreach($states['IN'] as $state){
		$state = strtoupper($state);
		$newstate[$state] = $state;
	}
	$states['IN'] = $newstate;
	}
    return $states; 
}; 
         
add_filter( 'woocommerce_states', 'filter_woocommerce_states', 10, 1 ); 


/*-- Kids photo---
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_order_details', 'my_custom_kidsphoto_display_admin_order_meta', 10, 1 );

function my_custom_kidsphoto_display_admin_order_meta($order){
	$kidsphoto = get_post_meta( $order->get_id(), '_kidsphoto', true );
	if(!empty($kidsphoto)){
		echo '</br><p><strong>'.__('Kid\'s photo').':</strong> </br> <a target="_blank" href="' . $kidsphoto . '"><img src="' . $kidsphoto . '" alt="" height="100" width="100"/></a></p>';
	}
}


/*-- Personalised details---
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_personalised_detail_display_admin_order_meta', 10, 1 );

function my_custom_personalised_detail_display_admin_order_meta($order){
	/* $textval = get_post_meta( $order->get_id(), '_personalised_detail', true );
    echo '<p><strong>'.__('Personalised details (First page text)').':</strong> <br></br> ' . nl2br($textval) . '</p>'; */
	
	$special_msg = get_post_meta( $order->get_id(), '_special_message', true );
    echo '<p style="border-top: 1px dashed;padding-top: 13px !important;overflow-wrap: break-word;"><strong>'.__('Personalised details (First page text)').':</strong> <br></br> ' . nl2br($special_msg) . '</p>';
}


/* add_action( 'woocommerce_thankyou_personalised_detail', 'my_custom_personalised_detail' ); */

/* function my_custom_personalised_detail( $orderid ) {
	global $woocommerce;
	
	$personalised_detail = get_post_meta( $orderid, '_personalised_detail', true );
	if(empty($personalised_detail)){
		$boyname = get_post_meta( $orderid, '_billing_kidsname', true );
		$textvalue = "Dear $boyname,

This is Your Book, Your Story.

Can you guess who created this fantastic story book about you?
The two people who know you the best, love you the most and care for you the max
 – YOUR MOMMY AND DADDY.
Do you know that you have SUPERPOWERS within you?
To help you discover your super powers, this book will take you on a journey
through a special WONDERLAND.
This wonderland will reveal your superpowers and also help you learn the true
meaning of your NAME as you take journey through it.
So without much ado, shall we embark on the exciting JOURNEY 
to discover your superpowers?

WONDERLAND Ahoy! Here we come!";   
		echo '<form name="personalised_detail_frm" method="post" action="" enctype="multipart/form-data"><div class="personalised_detail_wrap"><h3>Below You Can edit the first page text.</h3><p class="form-row personalised_detail-class form-row-wide woocommerce-validated" id="personalised_detail_field" data-priority=""><textarea name="personalised_detail" class="input-text " id="personalised_detail" rows="2" cols="5">'.$textvalue.'</textarea></p><div class="kidsimage"><h3>Upload Kid\'s photo</h3><p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto"><input name="kidsphoto" class="input-text " id="kidsphoto" type="file" accept="image/*"/></p><p>OR</p><p>You can email us your kid\'s photo with below given Order number on <a href="mailto:contact@superkidsleague.com">contact@superkidsleague.com</a>.</p></div><div class="form-row place-order" style="float: right;"><input class="button alt" name="personalised_detailsubmit" id="personalised_detailsubmit" value="Submit" type="submit"></div></div></form>';
	}
} */


add_action( 'woocommerce_thankyou_personalised_detail', 'my_custom_personalised_detail' );
function my_custom_personalised_detail( $orderid ) {
	global $woocommerce;
	global $wpdb;
	$orderItem = $wpdb->get_results("SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = '$orderid' ");
	$orderItemName = $orderItem[0]->order_item_name;
	$_kidsphoto = get_post_meta( $orderid, '_kidsphoto', true );
	$order = wc_get_order($orderid);
 	$customer_note = $order->customer_message; 
 	if($orderItemName == "Superkids Height Chart (Measure upto 5 ft)"){
 		if(empty($_kidsphoto)){
 			echo '<form name="personalised_detail_frm" method="post" action="" enctype="multipart/form-data"><div class="personalised_detail_wrap"><div class="kidsimage"><h3>Upload Kid\'s photo</h3><p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto"><input name="kidsphoto" class="input-text " id="kidsphoto" type="file" accept="image/*"/></p><p>OR</p><p>You can also email your kid\'s photos at - <a href="mailto:photo@skids.in">photo@skids.in</a>.</p></div><div class="form-row place-order" style="float: right;"><input class="button alt" name="personalised_detailsubmit" id="personalised_detailsubmit" value="Submit" type="submit"></div></div></form>';
 		}
 	}else if($orderItemName == "Superkid’s League Book"){
 		if(empty($_kidsphoto) && $customer_note == ''){
			echo '<form name="personalised_detail_frm" method="post" action="" enctype="multipart/form-data"><div class="personalised_detail_wrap"><div class="kidsimage"><h3>Upload Kid\'s photo</h3><p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto"><input name="kidsphoto" class="input-text " id="kidsphoto" type="file" accept="image/*"/></p><p>OR</p><p>You can also email your kid\'s photos at - <a href="mailto:photo@skids.in">photo@skids.in</a>.</p></div><div class="addinfo"><h3>Additional information</h3><label class="" for="order_comments">Special notes for delivery</label><textarea cols="5" rows="2" placeholder="Notes about your order." id="order_comments" class="input-text " name="order_comments" style="height: 120px;"></textarea></div><div class="form-row place-order" style="float: right;"><input class="button alt" name="personalised_detailsubmit" id="personalised_detailsubmit" value="Submit" type="submit"></div></div></form>';
		}
 	}else{
 		echo '<form name="personalised_detail_frm" method="post" action="" enctype="multipart/form-data">
				<div class="personalised_detail_wrap"><div class="addinfo"><h3>Additional information</h3>
				<label class="" for="order_comments">Special notes for delivery</label><textarea cols="5" rows="2" placeholder="Notes about your order." id="order_comments" class="input-text " name="order_comments" style="height: 120px;"></textarea>
					</div><div class="form-row place-order" style="float: right;"><input class="button alt" name="personalised_detailsubmit" id="personalised_detailsubmit" value="Submit" type="submit"></div></div></form>';
 	}
}

function custom_rewrite_rule() {
	add_rewrite_rule('([^/]*)_([^/]*)_([^/]*)_([^/]*)/?','?product=superkids-league-book&bgender=$1&bname=$2&bcode=$3&uncode=$4','top');
	add_rewrite_rule('([^/]*)_([^/]*)_([^/]*)/?','?product=superkids-league-book&bgender=$1&bname=$2&bcode=$3','top');
	add_rewrite_rule('([^/]*)_([^/]*)/?','?product=superkids-league-book&bgender=$1&bname=$2','top');
}
add_action('init', 'custom_rewrite_rule', 10, 0);

add_filter( 'query_vars', 'pmg_rewrite_add_var' );
function pmg_rewrite_add_var( $vars )
{
    $vars[] = 'product';
    $vars[] = 'bgender';
    $vars[] = 'bname';
    $vars[] = 'bcode';
	$vars[] = 'uncode';
    return $vars;
} 




/*-- kidsname_meaning_details---
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'wdm_add_values_to_order_item_meta_name_meaning', 10, 1 );

function wdm_add_values_to_order_item_meta_name_meaning($order){
	$name_meaning = get_post_meta( $order->get_id(), 'name_meaning', true );
    echo "<p><strong>Meaning :</strong> <br></br> " . $name_meaning . "</p>";
}

add_action( 'woocommerce_thankyou_personalised_detail', 'kidsname_meaning_detail' );

function kidsname_meaning_detail( $orderid ) {
	global $woocommerce;
	
	$meaning = '';
	
	if(isset($_SESSION['meaning_arr']) && !empty($_SESSION['meaning_arr']))
	{
		
		$user_custom_values = $_SESSION['meaning_arr'];
		$sess_bookusergender = $_SESSION['sess_bookusergender'];
		$meaning .= 'DIY PAGE - '.($sess_bookusergender == 'Boy' ? '( BDIY )' : '( GDIY )' ).'<br>';
		$meaning .= 'PROLOGUE - PRO <br>';
		$meaning .= 'CERTIFICATE - '. ($sess_bookusergender == 'Boy' ? '( BCERT )' : '( GCERT )' ).'<br>';
		$meaning .= 'OPENING - '.($sess_bookusergender == 'Boy' ? '( BOPEN )' : '( GOPEN )' ).'<br>';
		
		foreach($user_custom_values as $kname){
			$meaning .=  $kname[0] . ' - ' .trim(ucfirst(strtolower($kname[1]))).'  - (  '.($kname[2] == '0' ? 'B'.$kname[0].$kname[3] : 'G'.$kname[0].$kname[3] ) .'  )<br>';
		}
		$meaning .= 'ENDING - '.($sess_bookusergender == 'Boy' ? '( BEND )' : '( GEND )' ).'<br>';
		$meaning .= 'GLOSSARY - GLO1, GLO2, GLO3, GLO4 <br>';
	}
	if($meaning != '')
	{
		update_post_meta( $orderid, 'name_meaning', $meaning);	
	}
}


add_filter( 'woocommerce_checkout_fields', 'webendev_woocommerce_checkout_fields' );
/**
 * Change Order Notes Placeholder Text - WooCommerce
 * 
 */
function webendev_woocommerce_checkout_fields( $fields ) {

	$fields['order']['order_comments']['label'] = 'Special notes for delivery';
	$fields['order']['order_comments']['placeholder'] = 'Notes about your order.';
	return $fields;
}

// Hide the "Please update now" notification
function hide_update_notice() {
   remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_notices', 'hide_update_notice', 1 );


	
add_action( 'wp_enqueue_scripts', 'agentwp_dequeue_stylesandscripts', 100 );
function agentwp_dequeue_stylesandscripts() {
	if ( class_exists( 'woocommerce' ) ) {
		wp_dequeue_style( 'select2' );
		wp_deregister_style( 'select2' );
		wp_dequeue_script( 'select2');
		wp_deregister_script('select2');
	}
}


add_action('woocommerce_before_checkout_form', 'discount_when_quantity_greater_than_10');
function discount_when_quantity_greater_than_10(){
    global $woocommerce;
	if( session_id() === '' ) {
		session_start();
	}
    if( isset($_SESSION['aplcoupan']) && $_SESSION['aplcoupan'] == 1 ) {
		unset($_SESSION['aplcoupan']);
        $coupon_code = 'PN30';
		if(empty( $woocommerce->cart->applied_coupons )){
			if (!$woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ))) {
			}
		}
    }
}



/*
* Restrict COD for some postcode
*/
function payment_gateway_disable_country( $available_gateways ) {
global $woocommerce;

$postalcode = get_option('restricted_postal_code');
$expl_postalcode = explode(",",$postalcode);
$expl_postalcode = array_map('trim',$expl_postalcode);
$chekcode = in_array($woocommerce->customer->postcode,$expl_postalcode);
if ( isset( $available_gateways['cod'] ) && $woocommerce->customer->postcode != $chekcode) {
    unset(  $available_gateways['cod'] );
}
if(!empty( $woocommerce->cart->applied_coupons )){
	if ( isset( $available_gateways['cod'] )){
		$available_gateways['cod']->title = str_replace("45","45",$available_gateways['cod']->title);
	}
}
return $available_gateways;
}
add_filter( 'woocommerce_available_payment_gateways', 'payment_gateway_disable_country' );

function Theme_css_js() {
	if(is_page('wall-of-happiness')){
		wp_enqueue_style( 'jquery.fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', '', '2.7');
		wp_enqueue_script( 'jquery.fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.js',array(),array(),false);
	}	
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css', '', '3.3');
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', '', '3.8');
	wp_enqueue_style( 'font2', get_template_directory_uri() . '/fonts/fonts.css', '', '2.7');
	/* wp_enqueue_style( 'jquery.fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', '', '2.7'); */
	wp_enqueue_style( 'magiczoomplus-css', get_template_directory_uri() . '/css/magiczoomplus.css', '', '2.7');
	wp_enqueue_style( 'sweetalert', get_template_directory_uri() . '/css/sweetalert.css', '', '2.7');
	wp_enqueue_style( 'swiper-min', get_template_directory_uri() . '/css/swiper.min.css', '', '3.7');
	
	/* js */
	/* wp_enqueue_script( 'min', get_template_directory_uri() . '/js/min.js',array(),array(),false); */
	/* wp_enqueue_script( 'jquery.fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.js',array(),array(),false); */
	if ( is_product() ) { 
	wp_enqueue_script( 'modernizr-js', get_template_directory_uri() . '/js/modernizr.js',array(),array(),false);
	/* wp_enqueue_script( 'jquery.pictureflip', get_template_directory_uri() . '/js/jquery.pictureflip.js',array(),array(),false); */
	}
	wp_enqueue_script( 'at-jquery', get_template_directory_uri() . '/js/at-jquery.js',array(),array(),false);
	wp_enqueue_script( 'jssor', get_template_directory_uri() . '/js/jssor.slider.min.js',array(),array(),false);
	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js',array(),array(),false);
	wp_enqueue_style( 'jquery.fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', '', '2.7');
	wp_enqueue_script( 'jquery.fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.js',array(),array(),false);
	if ( is_product() ) { 
	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js',array(),array(),false);
	wp_enqueue_script( 'magiczoomplus', get_template_directory_uri() . '/js/magiczoomplus.js',array(),array(),false);
	}
	wp_enqueue_script( 'chosen.jquery', get_template_directory_uri() . '/js/chosen.jquery.js',array(),array(),false);
	wp_enqueue_script( 'sweetalert.min', get_template_directory_uri() . '/js/sweetalert.min.js',array(),array(),false);
	wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/js/swiper.min.js',array(),array('3.7'),false);
	if(is_product()){
		wp_enqueue_script( 'product_detail', get_template_directory_uri() . '/js/product_detail.js',array(),array(),false);
	}
	if(is_checkout() || is_account_page()){
		wp_enqueue_script( 'woo_forms', get_template_directory_uri() . '/js/woo_forms.js',array(),array(),false);
	}
	if(is_page('wall-of-happiness')){
		wp_enqueue_script( 'masonry-js', '//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.2/masonry.pkgd.js' );
	}
	
	
}
add_action( 'wp_enqueue_scripts', 'Theme_css_js' );


/*
 Order searching
*/
function filter_woocommerce_shop_order_search_fields( $array ) { 
	$array = array(
	"_billing_kidsname",
	"_billing_first_name", 
    "_billing_kidsname", 
    "_billing_address_1",
    "_billing_address_2", 
    "_billing_landmark", 
	"_billing_city",	
    "_billing_state", 
    "_billing_postcode", 
    "_billing_phone", 
	"_billing_email",
    "_billing_landline" );
    return $array; 
}; 
add_filter( 'woocommerce_shop_order_search_fields', 'filter_woocommerce_shop_order_search_fields', 10, 1 );




/*
pop up when only name found in url
*/
function redirect_404_send_mail() {
    if (is_404()) {    
		

		$REQUEST_URI = trim(parse_url($_SERVER[REQUEST_URI], PHP_URL_PATH), '/');
		$REQUEST_URI = explode('/',$REQUEST_URI);
		$array_under_test = array();
		if(count($REQUEST_URI) == 1 && (!in_array('about-us', $array_under_test) && !in_array('cart', $array_under_test) && !in_array('checkout', $array_under_test) && !in_array('contact-us', $array_under_test) && !in_array('learn-how', $array_under_test) && !in_array('my-account', $array_under_test) && !in_array('privacy-policy', $array_under_test) && !in_array('refer-a-friend', $array_under_test) && !in_array('returns-policy',$array_under_test) && !in_array('home', $array_under_test) && !in_array('terms-and-conditions', $array_under_test))){
			wp_redirect( home_url().'?kidname='.$REQUEST_URI[0] );
		}
		
    }
}
add_action( 'template_redirect', 'redirect_404_send_mail' );



/*----ajax call for zipcode-----*/
/*add_action('wp_enqueue_scripts', 'ajax_get_state_with_zipcode');
function ajax_get_state_with_zipcode(){
    wp_localize_script( 'swiper-js', 'ajax_state_object', array(
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
                //'nonce' => wp_create_nonce( "process_reservation_nonce" ),
            )
    );
}

function st_state_with_zipcode_action(){
	global $wpdb;
	$zipcode = $wpdb->prefix.'zipcode';
	$postCode = $_POST['postCode'];
	$getzipCode = $wpdb->get_results("SELECT * FROM `$zipcode` WHERE `zipcode` = '".$postCode."'");
	$stateName = [];
	if(!empty($getzipCode)){
		foreach ($getzipCode as $getzipCodeKey => $getzipCodeValue) {
			$stateName[] = $getzipCodeValue->state_name;
		}
	}
	wp_send_json($stateName);
	die;
}
add_action( 'wp_ajax_state_with_zipcode', 'st_state_with_zipcode_action' );
add_action( 'wp_ajax_nopriv_state_with_zipcode', 'st_state_with_zipcode_action');
*/



/* load more gallery */
add_action('wp_enqueue_scripts', 'ajax_auth_init');
function ajax_auth_init(){
    wp_localize_script( 'twentyfifteen-script', 'ajax_auth_object', array(
                'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( "process_reservation_nonce" ),
            )
    );
}
function st_nextgen_pagination_action(){
	global $nggdb;
	$json = '';
	$limit = sanitize_text_field( $_POST['limit'] );
	$offset = sanitize_text_field( $_POST['offset'] );
	/* echo $offset; die; */
	$picturelist = nggdb::get_gallery(1, 'sortorder', 'ASC', true, $limit, $offset);
	$images = array();
	if(!empty($picturelist)){
	foreach($picturelist as $image){
		$image = array(
			'imageurl' => $image->imageURL,
			'imagename' => $image->alttext,
			'image_slug' => $image->image_slug,
			'pid' => $image->pid,
			'imagethumb' => $image->thumbURL
		);
		$images[] = $image;
	}
	}
	$json = array('records' => $images);
	echo wp_send_json($json);
	die;
}
add_action( 'wp_ajax_nextgen_pagination', 'st_nextgen_pagination_action' );
add_action( 'wp_ajax_nopriv_nextgen_pagination', 'st_nextgen_pagination_action' );


add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
function default_values_checkout_fields( $fields ) {
    if(isset($_SESSION['checkout_details']))
	{
		$decoded_details = json_decode($_SESSION['checkout_details']);
		
		$fields['billing']['billing_first_name']['default'] = $decoded_details->fname;
		$fields['billing']['billing_kidsname']['default'] = $decoded_details->kname;
		$fields['billing']['billing_address_1']['default'] = $decoded_details->add1;
		$fields['billing']['billing_address_2']['default'] = $decoded_details->add2;
		$fields['billing']['billing_city']['default'] = $decoded_details->city;
		$fields['billing']['billing_state']['default'] = $decoded_details->state;
		$fields['billing']['billing_postcode']['default'] = $decoded_details->postcode;
		$fields['billing']['billing_email']['default'] = $decoded_details->email;
		$fields['billing']['billing_phone']['default'] = $decoded_details->phone; 
		$fields['billing']['billing_landline']['default'] = $decoded_details->landline;
		$fields['billing']['billing_landmark']['default'] = $decoded_details->landmark;
		
		//unset($_SESSION['checkout_details']);
	}
    return $fields;
  } 
  
function keep_me_logged_in_for_1_year( $expirein ) {
   return 31556926; // 1 year in seconds
}
add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );





/*--*/


/*
 * Step 1. Add Link to My Account menu
 */
add_filter ( 'woocommerce_account_menu_items', 'misha_log_history_link', 40 );
function misha_log_history_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'upload-photo-and-message' => 'Photo & Message' )
	+ array_slice( $menu_links, 5, NULL, true );
 
	return $menu_links;
 
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {
 
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'upload-photo-and-message', EP_PAGES );
 
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_upload-photo-and-message_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
    ?>
    <?php
    global $wpdb;
    /*
     * Kids photo upload for first page text in book
     */
    $chk = '';
    if ( isset( $_REQUEST["ordernumber"] ) && $_REQUEST["ordernumber"] != '' ) {
        $order = $_REQUEST["ordernumber"];
        if ( isset( $_FILES["kidsphoto"]["name"] ) && $_FILES["kidsphoto"]["name"] != '' ) {
            $check = getimagesize($_FILES["kidsphoto"]["tmp_name"]);
            if($check !== false) {
                $upload = wp_upload_dir();
                $uploadDir = $upload['basedir'] . "/kidsphotos/";
                $urlDir = $upload['baseurl'] . "/kidsphotos/";
                $permissions = 0755;
                if (!is_dir($uploadDir)) mkdir($uploadDir, $permissions);
                $newfile = $uploadDir . $order . '-' . $_FILES["kidsphoto"]["name"];
                $newfileurl = $urlDir . $order . '-' . $_FILES["kidsphoto"]["name"];
                if (move_uploaded_file($_FILES["kidsphoto"]["tmp_name"], $newfile)) {							
                    update_post_meta( $order, '_kidsphoto', $newfileurl );
                    $chk .= 'Photo uploaded successfully.<br>';
                }
            }
        }
        
        $ordernumber = $_REQUEST['ordernumber'];
        if ( isset( $_REQUEST['special_message'] ) && $_REQUEST['special_message'] != '' ) {
            update_post_meta(  $ordernumber, '_special_message', $_REQUEST['special_message'] );
            $chk .= "Special Message updated successfully.<br>";
        }
        if ( isset( $_REQUEST['order_comments'] ) && $_REQUEST['order_comments'] != '' ) {
			$order_data = array(
				'order_id' => $order,
				'customer_note' => $_REQUEST['order_comments']
			);
			wc_update_order( $order_data );
            $chk .= "Additional Message updated successfully.<br>";
        }
        if ( isset( $_REQUEST['payment_st1'] ) && $_REQUEST['payment_st1'] != '' ) {
            $selected_method = $_POST['payment_st1'];
            if($selected_method == 0){
                update_post_meta( $ordernumber, '_payment_method', 'cod');
                update_post_meta( $ordernumber, '_payment_method_title', 'Cash on delivery (Extra charge : Rs. 45)');
                $chk .= 'Payment uploaded successfully.<br>';
            }else if($selected_method == 1){
                update_post_meta( $ordernumber, '_payment_method', 'razorpay');
                update_post_meta( $ordernumber, '_payment_method_title', 'Credit Card/Debit Card/NetBanking');
                $chk .= 'Payment uploaded successfully.<br>';
            }else if($selected_method == 2){
                update_post_meta( $ordernumber, '_payment_method', 'custom-cod');
                update_post_meta( $ordernumber, '_payment_method_title', 'Paytm');
                $chk .= 'Payment uploaded successfully.<br>';
            }else if($selected_method == 3){
                update_post_meta( $ordernumber, '_payment_method', 'custom-cod');
                update_post_meta( $ordernumber, '_payment_method_title', 'OTHER PAYMENT OPTIONS (NEFT/IMPS/RTGS)');
                $chk .= 'Payment uploaded successfully.<br>';
            }
            
            $order_obj = new WC_Order( $ordernumber );
            $order_obj->update_status( 'neworder' );		
        }
        
    }
    ?>
    <div role="main" id="wpbody">
        <div id="wpbody-content" aria-label="Main content" tabindex="0">		
            <div class="wrap">
                <form name="personalised_detail_frm" method="post" action="" enctype="multipart/form-data">
                    <div class="personalised_detail_wrap">					
                        <div class="kidsimage">
                            <?php if($chk != ''){ ?>
                            <p style="color:#698037"><?php echo $chk; ?></p>
                        <?php } ?>
                        <h3>Kid's Other Details</h3>
                           
                            <fieldset>
                                <legend class="screen-reader-text"><span>Order Number</span></legend>
                                <p class="form-row personalised_detail-class form-row-wide woocommerce-validated">
                                    <input name="ordernumber" class="input-text " id="ordernumber" type="text" value="" />
                                </p>
                                <small>Please enter order number without #,space or any special characters</small>
                            </fieldset>
                            
                            <fieldset>
                                <legend class="screen-reader-text"><span>Message</span></legend>
                                <p class="form-row personalised_detail-class form-row-wide woocommerce-validated">
                                    <textarea name="special_message" style="width:100%; height:200px" maxlength="500"></textarea>
                                </p>
                            </fieldset>
                            
                            <fieldset>
                                <legend class="screen-reader-text"><span>Customer Note</span></legend>
                                <p class="form-row personalised_detail-class form-row-wide woocommerce-validated">
                                    <textarea name="order_comments" id="order_comments" style="width:100%; height:200px"></textarea>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend class="screen-reader-text"><span>Upload Photo</span></legend>
                                <p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto">
                                    <input name="kidsphoto" class="input-text " id="kidsphoto" type="file" accept="image/*"/>
                                </p>
                            </fieldset>
                            
                            <fieldset>
                                <legend class="screen-reader-text"><span>Select Payment Method</span></legend>
                                <label for="cod"><input name="payment_st1" type="radio" id="cod" value="0">  COD</label>
                                <br>
                                <br>
                                <label for="razorpay"><input name="payment_st1" type="radio" id="razorpay" value="1">  Razorpay</label>
                                <br>
                                <br>
                                <label for="paytm"><input name="payment_st1" type="radio" id="paytm" value="2">  Paytm</label>
                                <br>
                                <br>
                                <label for="Other"><input name="payment_st1" type="radio" id="Other" value="3">  Other</label>
                            </fieldset>
                            <input class="button alt" name="kidssubmit" id="kidssubmit" value="Submit" type="submit">
                        </div>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div>    
    <?php
}

/**
 * Add html
 *
 * @version 1.0.0
 * @since   1.0.0
 */
add_action( 'woocommerce_after_checkout_billing_form', 'add_box_option_to_checkout' );
function add_box_option_to_checkout( $checkout ) {
	$prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	$bagpag = explode('/', $prev_url);

	if(($prev_url != site_url().'/superhero-cape/') && ($prev_url != site_url().'/height-chart/') && ($bagpag[3] != 'bags-product') && ($bagpag[3] != 'worksheets') && ($bagpag[3] != 'cart')){
		if(get_option('ad_hardbound_amount') && get_option('ad_hardbound_amount') > 0){
			echo '<div id="message_fields">';
			woocommerce_form_field( 'hardboundcover150', array(
				'type'          => 'checkbox',
				'class'         => array('hardboundcover150 form-row-wide'),
				'label'         => __( 'Add Hard bound cover in Rs. '.get_option('ad_hardbound_amount').' extra.', 'hardboundcover' ),
				'placeholder'   => '',
			), $checkout->get_value( 'hardboundcover150' ));
			echo '</div> <br><p><a href="'.get_template_directory_uri().'/images/hardbound/1.jpg" class="fancybox1" rel="group" id="openhardboundpopup" >Click Here</a> to check Hard Bound book preview.</p>';
			echo '<a style="display:none;" href="'.get_template_directory_uri().'/images/hardbound/2.jpg" class="fancybox1" rel="group" >2</a>';
			echo '<a style="display:none;" href="'.get_template_directory_uri().'/images/hardbound/3.jpg" class="fancybox1" rel="group" >3</a>';
			echo '<a style="display:none;" href="'.get_template_directory_uri().'/images/hardbound/4.jpg" class="fancybox1" rel="group" >4</a>';
			echo '<a style="display:none;" href="'.get_template_directory_uri().'/images/hardbound/5.jpg" class="fancybox1" rel="group" >5</a>';
			
			echo '<script type="text/javascript"> jQuery(document).ready(function($) { $(".fancybox1").fancybox(); }); </script>';

			
			
		}
	}
	echo '<h3 id="order_review_heading">Shipping</h3>';
	if(($bagpag[3] == 'height-chart')){
	echo '<p><input type="radio" name="height_chart_method" id="height_option" value="free_shipping" class="standard_delivery" checked="checked">
		<label for="height_option">Standard Delivery - 5 to 7 working days - <span style="font-weight:bold">Free</span></label>
		<br>
		<input type="radio" name="height_chart_method" id="urgent_height_shipping" value="height_urgent_shipping" class="urgent_delivery">
		<label for="urgent_height_shipping">Urgent Delivery - 3 to 5 working days: <span style="font-weight:bold"> Rs.50</span>
		</label></p>';
	}else if(($bagpag[3] == 'cart')){
	echo '<p><input type="radio" name="worksheet_method" id="worksheet_option" value="free_shipping" class="standard_delivery" checked="checked">
		<label for="worksheet_option">Standard Delivery - 5 to 7 working days - <span style="font-weight:bold">Free</span></label>
		<br>
		<input type="radio" name="worksheet_method" id="worksheet_shipping" value="worksheet_shipping" class="urgent_delivery">
		<label for="worksheet_shipping">Urgent Delivery - 3 to 5 working days: <span style="font-weight:bold"> Rs.100</span>
		</label></p>';
	}else{
		echo '<p><input type="radio" name="shipping_method" id="delivery_option" value="free_shipping" class="standard_delivery" checked="checked">
		<label for="delivery_option">Standard Delivery - 10 to 15 working days - <span style="font-weight:bold">Free</span></label>
		<br>
		<input type="radio" name="shipping_method" id="urgent_shipping" value="urgent_shipping" class="urgent_delivery">
		<label for="urgent_shipping">Urgent Delivery - 4 to 7 working days: <span style="font-weight:bold"> Rs.100</span>
		</label></p>'; 
	}
}
/**
 * Add Javascript
 *
 * @version 1.0.0
 * @since   1.0.0
 */
add_action( 'wp_footer', 'woocommerce_add_gift_box' );
function woocommerce_add_gift_box() {
	$prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	if (is_checkout()) {
		?>
		<script type="text/javascript">
			var prev_url = "<?php echo $prev_url ?>";
			var superheroCape = "<?php echo site_url().'/superhero-cape/'; ?>";
			var heightChart = "<?php echo site_url().'/height-chart/'; ?>";
			jQuery( document ).ready(function( $ ) {
				$("#billing_kidsname_field").css("display", "block");
				if((prev_url == superheroCape) || (prev_url == heightChart)){
					$("#billing_kidsname_field").css("display", "none");
				}else {
					$("#billing_kidsname_field").css("display", "block");
				}
				
				$('#hardboundcover150').click(function(){
					jQuery('body').trigger('update_checkout');
				});
				jQuery('input[name=shipping_method]').change(function(){
					var value = jQuery("input[name='shipping_method']:checked").val()
					if((value == 'urgent_shipping') || ((value == 'free_shipping'))){
						jQuery('body').trigger('update_checkout');
					}
				});
				jQuery('input[name=height_chart_method]').change(function(){
					var value = jQuery("input[name='height_chart_method']:checked").val()
					if((value == 'height_urgent_shipping') || ((value == 'free_shipping'))){
						jQuery('body').trigger('update_checkout');
					}
				});
				jQuery('input[name=worksheet_method]').change(function(){
					var value = jQuery("input[name='worksheet_method']:checked").val()
					if((value == 'worksheet_shipping') || ((value == 'free_shipping'))){
						jQuery('body').trigger('update_checkout');
					}
				});
			});
		</script>
		<?php
	}
}
/**
 * Add fee to cart
 *
 * @link    https://docs.woocommerce.com/document/add-a-surcharge-to-cart-and-checkout-uses-fees-api/
 * @version 1.0.0
 * @since   1.0.0
 */
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
	if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
		return;
	}
	if ( isset( $_POST['post_data'] ) ) {
		parse_str( $_POST['post_data'], $post_data );
	} else {
		$post_data = $_POST;
	}

	if (isset($post_data['hardboundcover150'])) {
		$extracost = get_option('ad_hardbound_amount');
		WC()->cart->add_fee( esc_html__( 'Hard bound cover', 'hardboundcover' ), $extracost );
	}
	if ($post_data['shipping_method'] == 'urgent_shipping') {
		$deliveryCost = get_option('delivery_option');
		WC()->cart->add_fee( esc_html__( 'Urgent Delivery Charge', 'delivery_option' ), $deliveryCost );
	}
	if ($post_data['height_chart_method'] == 'height_urgent_shipping') {
		$deliveryCosts = get_option('height_option');
		WC()->cart->add_fee( esc_html__( 'Urgent Delivery Charge', 'height_option' ), $deliveryCosts );
	}
	if ($post_data['worksheet_method'] == 'worksheet_shipping') {
		$worksheetCosts = get_option('ad_worksheet_amount');
		WC()->cart->add_fee( esc_html__( 'Urgent Delivery Charge', 'worksheet_option' ), $worksheetCosts );
	}
}

add_filter('woocommerce_checkout_get_value','__return_empty_string',10, 2);




// code for cron job starts here 
function isa_add_every_ten_minutes( $schedules ) {
 
    $schedules['every_ten_minutes'] = array(
			'interval'  => 60 * 10,
            'display'   => __( 'Every 10 Minutes')
    );
     
    return $schedules;
}
add_filter( 'cron_schedules', 'isa_add_every_ten_minutes' ); 

add_action('wp', 'remove_dynamic_images');
register_activation_hook(__FILE__, 'remove_dynamic_images');
function remove_dynamic_images() {
    if (! wp_next_scheduled ( 'remove_images_event' )) {
		wp_schedule_event(time(), 'every_ten_minutes', 'remove_images_event');

    }
}


add_action( 'remove_images_event', 'fnRemoveDynamicImages' );
function fnRemoveDynamicImages(){
	$frontimages = glob($_SERVER['DOCUMENT_ROOT'].'/createimage/frontimage/*');
	$certimages = glob($_SERVER['DOCUMENT_ROOT'].'/createimage/certimage/*');
	foreach($frontimages as $frontimage){
	  $lastModifiedTime = filemtime($frontimage);
	    $currentTime = time();
	    $timeDiff = abs($currentTime - $lastModifiedTime)/(60);
	    if(is_file($frontimage) && $timeDiff > 5)
	        unlink($frontimage);
	}

	foreach($certimages as $certimage){
	    $lastModifiedTime = filemtime($certimage);
	    $currentTime = time();
	    $timeDiff = abs($currentTime - $lastModifiedTime)/(60);
	    if(is_file($certimage) && $timeDiff > 5)
	        unlink($certimage);
	}
}


// code for cron job starts here 
function isa_add_every_five_minutes( $schedules ) {
 
    $schedules['every_five_minutes'] = array(
			'interval'  => 60 * 5,
            'display'   => __( 'Every 5 Minutes')
    );
     
    return $schedules;
}
add_filter( 'cron_schedules', 'isa_add_every_five_minutes' ); 



// set cron 
//require("./class.phpmailer.php");
add_action('wp', 'my_sms_cron_email');
register_activation_hook(__FILE__, 'my_sms_cron_email');
function my_sms_cron_email() {
    if (! wp_next_scheduled ( 'checkout_hourly_event' )) {
		wp_schedule_event(time(), 'every_five_minutes', 'checkout_hourly_event');

    }
}

function send_hourly_checkout_sms() {
	global $wpdb;
  	$bcode = $_SESSION['sess_bcode'];
	$callingTeamEmail = $wpdb->prefix.'calling_team_emails';
	$dailySmsCron = $wpdb->prefix.'daily_sms_cron';
	$cronSchedule = $wpdb->get_results("SELECT * FROM `$dailySmsCron` WHERE `visiting_page` = 'checkout' AND `sms_status` = '0'");
	$callingResult = $wpdb->get_results("SELECT * FROM `$callingTeamEmail` WHERE `visiting_page` = 'checkout' AND `status` = 'active'");
	$getEmail = [];
	if(!empty($callingResult)){
		foreach ($callingResult as $key => $value) {
			$getEmail[] = $value->email;
		}
	}
	end($getEmail);
	$getEmailId = key($getEmail);
	$i = get_option('ch_last_email_sent');
	if(!empty($cronSchedule)){
		foreach($cronSchedule as $cronScheduleKey => $cronScheduleVal){
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'] . "/cron";
			$fileName = $upload_dir ."/cronfile.txt";
			$txt = 'Checkout Page Cron Run With Unique Code in every five min :  '.$cronScheduleVal->ucode.'----'.date('d/m/Y H:i').'---'.$getEmail[$i];
			$filedir = (file_exists($fileName)) ? fopen($fileName, "a") : fopen($fileName, "w");
			fwrite($filedir, $txt . "\n");
			if($cronScheduleVal->gender == 'B'){
				$gender = 'Boy';
			}else{
				$gender = 'Girl';
			}
			$message = "Name : " . $cronScheduleVal->kids_name. "<br> Gender : " . $gender. "<br> Unique Code : " . $cronScheduleVal->ucode . '<br> Total Clicks - ' . $cronScheduleVals->total_visit;;
			$subject = 'Checkout : '.$cronScheduleVal->kids_name.' with code - '.$cronScheduleVal->ucode.' has visited checkout page in site';
			

			$loc_email = $getEmail[$i];
			$headers = "From: Skids <asingh@skids.in> \r\n" . 
					"Content-type: text/html; charset=UTF-8 \r\n"; 
			$ok = wp_mail($loc_email, $subject, $message, $headers);
			if($ok)
                {
                    $txt = "send successfully";        
                }
                else
                {
                    $txt = "sending fail";
                }
			fwrite($filedir, $txt . "\n\n");
			fclose($filedir);
			if(get_option('ch_last_email_sent', 'default') == 'default'){
				add_option('ch_last_email_sent');
			}
			$wpdb->query("DELETE FROM $dailySmsCron WHERE `id` = $cronScheduleVal->id AND `ucode` = '$cronScheduleVal->ucode' AND `visiting_page` = 'checkout'"); 
			$updateVisitPage = $wpdb->update( $dailySmsCron, array( 'sms_status' => 1),array('id'=>$cronScheduleVal->id));
			$i++;
			if($i > $getEmailId){
				$i = 0;
				update_option('ch_last_email_sent', $i);
			}else{
				update_option('ch_last_email_sent', $i);
			}
		}
	}
}



add_action('wp', 'my_product_sms_cron_email');
register_activation_hook(__FILE__, 'my_product_sms_cron_email');
function my_product_sms_cron_email($bcode) {

    if (! wp_next_scheduled ( 'product_hourly_event' )) {
		wp_schedule_event(time(), 'every_five_minutes', 'product_hourly_event');
    }
}



function send_hourly_product_sms() {
	global $wpdb;
	$callingTeamEmail = $wpdb->prefix.'calling_team_emails';
	$bcode = $_SESSION['sess_bcode'];
	$dailySmsCron = $wpdb->prefix.'daily_sms_cron';
	$cronSchedules = $wpdb->get_results("SELECT * FROM `$dailySmsCron` WHERE `visiting_page` = 'product' AND `sms_status` = '0'");	
	$callingResult = $wpdb->get_results("SELECT * FROM `$callingTeamEmail` WHERE `visiting_page` = 'product' AND `status` = 'active'");
	$getEmail = [];
	if(!empty($callingResult)){
		foreach ($callingResult as $key => $value) {
			$getEmail[] = $value->email;		
		}
	}
	end($getEmail);
	$getEmailId = key($getEmail);
	$i = get_option('last_email_sent');
	if(!empty($cronSchedules)){
		foreach($cronSchedules as $cronScheduleKeys => $cronScheduleVals){
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'] . "/cron";
			$fileName = $upload_dir ."/cronfile.txt";
			$txt = 'Product Page Cron Run With Unique Code in every five min. :  '.$cronScheduleVals->ucode.'----'.date('d/m/Y H:i').'---'.$getEmail[$i];
			$filedir = (file_exists($fileName)) ? fopen($fileName, "a") : fopen($fileName, "w");
			fwrite($filedir, $txt . "\n");
			if($cronScheduleVals->gender == 'B'){
				$gender = 'Boy';
			}else{
				$gender = 'Girl';
			}
			$message = "Name : " . $cronScheduleVals->kids_name. "<br> Gender : " . $gender."<br> Unique Code : " . $cronScheduleVals->ucode . '<br> Total Clicks - ' . $cronScheduleVals->total_visit;
			$subject = 'Product : '.$cronScheduleVals->kids_name.' with code - '.$cronScheduleVals->ucode.' has visited product page in site';
			
			$loc_email = $getEmail[$i];

			$headers = "From: Skids <asingh@skids.in> \r\n" . 
					"Content-type: text/html; charset=UTF-8 \r\n"; 
			$ok = wp_mail($loc_email, $subject, $message, $headers);
			if($ok)
                {
                	$txt = "send successfully";        
                }
                else
                {
                    $txt = "sending fail";
                }
			fwrite($filedir, $txt . "\n\n");
			if(get_option('last_email_sent', 'default') == 'default'){
				add_option('last_email_sent');
			} 
			$wpdb->query("DELETE FROM $dailySmsCron WHERE `id` = $cronScheduleVals->id AND `ucode` = '$cronScheduleVals->ucode' AND `visiting_page` = 'product'");
			$updateVisitPage = $wpdb->update( $dailySmsCron, array( 'sms_status' => 1),array('id'=>$cronScheduleVals->id));
			fclose($filedir);
			$i++;
			if($i > $getEmailId){
				$i = 0;
				update_option('last_email_sent', $i);
			}else{
				update_option('last_email_sent', $i);
			}
		}
	}
}

add_action( 'checkout_hourly_event', 'send_hourly_checkout_sms' );
add_action( 'product_hourly_event', 'send_hourly_product_sms' );

/*
* Bags Kids Name
*/
/*----ajax call for zipcode-----*/
add_action('wp_enqueue_scripts', 'ajax_get_session');
function ajax_get_session(){
    wp_localize_script( 'swiper-js', 'ajax_kids_name', array(
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
            )
    );
}

function load_kidsbags(){
	session_start();
	global $woocommerce;
	$replace_order = new WC_Cart();
	$replace_order->empty_cart( true );
	if(isset($_REQUEST['name'])){
	$skids_name = $_REQUEST['name'];
		$_SESSION['sess_bagusername'] = $skids_name;
	}
	if(isset($_REQUEST['gender'])){
		$skids_gender = $_REQUEST['gender'];
		$_SESSION['sess_bagusergender'] = $skids_gender;
	}
	//$woocommerce->cart->add_to_cart($_REQUEST['pid']);
	$replace_order->add_to_cart( $_REQUEST['pid'], "1");

	$data=$_REQUEST['pid'];
	echo  $data; die();

}
add_action( 'wp_ajax_load_kidsbags', 'load_kidsbags' );
add_action( 'wp_ajax_nopriv_load_kidsbags', 'load_kidsbags');

add_action('wp_default_scripts', function ($scripts) {
	if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});


add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host = "smtp.gmail.com";
	$phpmailer->SMTPAuth = true;
	$PHPMailer->SMTPSecure = 'tls';
	$phpmailer->Port = 587;
	$phpmailer->Username = "infosuperkidsleague@gmail.com";
	$phpmailer->Password = "Abbacus@007";
}


add_action('wp_enqueue_scripts', 'ajax_height_image');
function ajax_height_image(){
    wp_localize_script( 'at-jquery', 'ajax_load_image', array(
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
            )
    );
}

function load_kids_image(){
	$hckidsname = isset($_POST["hcname"])?stripslashes($_POST["hcname"]):"";
	$kidsname = isset($_POST["name"])?stripslashes($_POST["name"]):"";
	$kidsfile = str_replace(" ", "_", $kidsname);
	$hckidsfile = str_replace(" ", "_", $hckidsname);
	$uploads = wp_upload_dir();
	$upload_url = $uploads['baseurl'];
	$upload_path = $uploads['basedir'];
	
	if($hckidsname != ""){
		$upload_dir = $upload_path . "/height_chart_log";
		$currentUrl = site_url().'/height-chart/?hc='.$hckidsname;
		$fileName = $upload_dir ."/height_chart.txt";
		$txt = 'kidsname =' .$hckidsname.'==='. 'url='.$currentUrl.'---'.'date='.date('d/m/Y H:i');
		$filedir = (file_exists($fileName)) ? fopen($fileName, "a") : fopen($fileName, "w");
		fwrite($filedir, $txt . "\n");
		fclose($filedir);
	}

 	$pageImage = get_template_directory()."/images/heightchartimagenew.jpg";
	$font_path = get_template_directory().'/fonts/P22Wedge-Bold.ttf';
	if($kidsname != ""){
		$text = ucfirst($kidsname);	
	}else{
		$text = ucfirst($hckidsname);
	}
	if($kidsfile != ""){
		$filename = $kidsfile;
	}else{
		$filename = $hckidsfile;
	}
	$white = imagecolorallocate($pageImage, 0, 0, 0);
	$image1 = imagecreatefromstring(file_get_contents($pageImage));
	$textlen = strlen($text);

	if($textlen < 4){
		$left = 1080;
	}else if($textlen < 6){
		$left = 1040;
	}else if($textlen < 8){
		$left = 1000;
	}else if($textlen < 10){
		$left = 960;
	}else if($textlen < 12){
		$left = 900;
	}else{
		$left = 860;
	}
	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$rand_number = substr(str_shuffle($str_result), 0, 6);
	//$rand_number = 1;
	imagettftext($image1, 120, 0, $left, 930, $white, $font_path, $text);
	header("Content-Type: image/jpg");
	imagejpeg($image1, $upload_path."/kids-photo/".$filename."_".$rand_number.".jpg");
	$newpath = $upload_url.'/kids-photo/'.$filename."_".$rand_number.".jpg";
	echo $newpath;
	die();

}

add_action( 'wp_ajax_load_kids_image', 'load_kids_image' );
add_action( 'wp_ajax_nopriv_load_kids_image', 'load_kids_image');


add_action('wp_enqueue_scripts', 'ajax_upload_bag_image');
function ajax_upload_bag_image(){
    wp_localize_script( 'at-jquery', 'ajax_bag_image', array(
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
            )
    );
}
function upload_kidsbag_image(){
	
	$hckidsname = isset($_POST["hcname"])?stripslashes($_POST["hcname"]):"";
	$kidsname = isset($_POST["name"])?stripslashes($_POST["name"]):"";
	/*$kidsname = str_replace(" ", "_", $kidsname);
	$hckidsname = str_replace(" ", "_", $hckidsname);*/
	$uploads = wp_upload_dir();
	$upload_url = $uploads['baseurl'];
	$upload_path = $uploads['basedir'];
 	/*$blueBag = get_template_directory()."/images/bags/blue.jpg";
 	$yellowBag = get_template_directory()."/images/bags/yellow_1.jpg";
 	$pinkBag = get_template_directory()."/images/bags/pink.jpg";
 	$redBag = get_template_directory()."/images/bags/red_1.jpg";*/
	$font_path = get_template_directory().'/fonts/P22Wedge-Bold.ttf';
	if($kidsname != ""){
		$text = strtoupper($kidsname);	
	}else{
		$text = strtoupper($hckidsname);
	}
	$themePath = get_template_directory()."/images/bags";
	$white = imagecolorallocate($blueBag, 288, 288, 288);
	/*$image1 = imagecreatefromstring(file_get_contents($blueBag));
	$image2 = imagecreatefromstring(file_get_contents($yellowBag));
	$image3 = imagecreatefromstring(file_get_contents($pinkBag));
	$image4 = imagecreatefromstring(file_get_contents($redBag));*/

	if (is_dir($themePath)){
		if ($dh = opendir($themePath)){
			while (($file = readdir($dh)) !== false){
				$bagname = chop($file, '.jpg');
				$filename = $themePath.'/'.$file;
				$image[$bagname] = imagecreatefromstring(file_get_contents($filename));
			}
			closedir($dh);
			$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			$rand_number = 1;
			if($text != ""){
				$dir = $upload_path.'/kids-bag/'.$text;
				if (!is_dir($dir)) {
				    mkdir($dir, 0777, true);
				}
			}
			$imageUrl = $upload_url.'/kids-bag/'.$text;
			
			//echo "<pre>"; print_r($image); exit;
			$textlen = strlen($text);
			foreach ($image as $key => $value) {
				if($value !== ""){
					if($key == 'blue'){
						if($textlen < 4){
							$left = 200;
							$right = 190;
							$font = 35;
						}else if($textlen < 6){
							$left = 190;
							$right = 180;
							$font = 30;
						}else if($textlen < 8){
							$left = 190;
							$right = 170;
							$font = 25;
						}else if($textlen < 10){
							$left = 190;
							$right =150;
							$font = 22;
						}else if($textlen < 12){
							$left = 190;
							$right =150;
							$font = 20;
						}else{
							$left = 190;
							$right =145;
							$font = 19;
						}
						imagettftext($value, $font, 0, $right, $left, $white, $font_path, $text);
						imagejpeg($value, $dir.'/'.$text."_".$key.'_'.$rand_number.".jpg");
						$newpath[$key] = $imageUrl.'/'.$text."_".$key."_".$rand_number.".jpg";
					}else if($key == 'pink'){
						if($textlen < 4){
							$left = 200;
							$right = 190;
							$font = 35;
						}else if($textlen < 6){
							$left = 200;
							$right = 190;
							$font = 30;
						}else if($textlen < 8){
							$left = 200;
							$right = 180;
							$font = 25;
						}else if($textlen < 10){
							$left = 200;
							$right =170;
							$font = 22;
						}else if($textlen < 12){
							$left = 200;
							$right =160;
							$font = 20;
						}else{
							$left = 200;
							$right =160;
							$font = 19;
						}
						imagettftext($value, $font, 0, $right, $left, $white, $font_path, $text);
						imagejpeg($value,$dir.'/'.$text."_".$key.'_'.$rand_number.".jpg");
						$newpath[$key] = $imageUrl.'/'.$text."_".$key."_".$rand_number.".jpg";
					}else if($key == 'yellow_1'){
						if($textlen < 4){
							$left = 180;
							$right = 180;
							$font = 35;
						}else if($textlen < 6){
							$left = 180;
							$right = 180;
							$font = 30;
						}else if($textlen < 8){
							$left = 180;
							$right = 150;
							$font = 25;
						}else if($textlen < 10){
							$left = 180;
							$right =140;
							$font = 22;
						}else if($textlen < 12){
							$left = 180;
							$right =140;
							$font = 20;
						}else{
							$left = 180;
							$right =130;
							$font = 19;
						}
						imagettftext($value, $font, 0, $right, $left, $white, $font_path, $text);
						imagejpeg($value, $dir."/".$text."_".$key.'_'.$rand_number.".jpg");
						$newpath[$key] = $imageUrl.'/'.$text."_".$key."_".$rand_number.".jpg";
					}else if($key == 'red_1'){
						if($textlen < 4){
							$left = 180;
							$right = 180;
							$font = 35;
						}else if($textlen < 6){
							$left = 180;
							$right = 180;
							$font = 30;
						}else if($textlen < 8){
							$left = 180;
							$right = 150;
							$font = 25;
						}else if($textlen < 10){
							$left = 180;
							$right =140;
							$font = 22;
						}else if($textlen < 12){
							$left = 180;
							$right =140;
							$font = 20;
						}else{
							$left = 180;
							$right =140;
							$font = 20;
						}
						imagettftext($value, $font, 0, $right, $left, $white, $font_path, $text);
						imagejpeg($value, $dir."/".$text."_".$key.'_'.$rand_number.".jpg");
						$newpath[$key] = $imageUrl.'/'.$text."_".$key."_".$rand_number.".jpg";
					}					
				}
			}
		}
	}
	//print_r($newpath);
	print_r(json_encode($newpath));
	die();
}
add_action( 'wp_ajax_upload_kidsbag_image', 'upload_kidsbag_image' );
add_action( 'wp_ajax_nopriv_upload_kidsbag_image', 'upload_kidsbag_image');


// Add back to store button on WooCommerce cart page
add_action('woocommerce_cart_actions', function() {
  ?>
  <a class="button wc-backward continue_shopping" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', site_url(  ) ).'/products' ); ?>"> <?php _e( 'Return to shop', 'woocommerce' ) ?> </a>
  <?php
});





 
?>