<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */   
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/images/favicon(34).ico">
	<!--<title><?php wp_title( '|', true, 'right' ); ?></title> -->
	
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<?php
		global $wpdb;
		if((isset($_REQUEST)) && (!empty($_REQUEST['sk']))){
			$ucode = $_REQUEST['sk'];
			$query = "SELECT `kidsname`,`gender` FROM `wp_general_contacts` WHERE `ucode` = '".$ucode."' ";
	    	$result = $wpdb->get_results($query);
	    	$kidsname = $result[0]->kidsname;
	    	if($result[0]->gender == "Boy"){
	    		$gender = "B";
	    	}else{
	    		$gender = "G";
	    	}
			wp_redirect('http://skids.in/'.$gender."_".$kidsname."_".$ucode);
		}
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	
	<?php /* <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/main.css?ver=1.6.7" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css?ver=1.5.3" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/fonts/fonts.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.fancybox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/magiczoomplus.css" > */ ?>
	<style>
	.newtesti{
		   clear: both;
    margin: 0 auto;
    max-width: 1000px;
    position: relative;
    z-index: 9;
	}
	#billing_street_address_field, #billing_street_address{
		display:none;
	}
	#billing_house_number_field, #billing_house_number{
		display:none;
	}
	</style>
	
	<?php /* <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.fancybox.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.pictureflip.js?ver=1.0"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/at-jquery.js?ver=1.2.2" ></script>
	
	<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script>
	<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/chosen.jquery.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/magiczoomplus.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/sweetalert.css"> */ ?>
	
	

	<script>
	function MM_jumpMenu(targ,selObj,restore){ 
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	</script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105672461-1', 'auto');
  ga('send', 'pageview');

</script>

<script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', '5043c8ae744910d6ccb62b3ff3b9b4cc02eeb12b');
</script>
<script>
	
	jQuery(document).ready(function($) {	

		/* $(".tab_content").hide(); 
		$("ul.tabs li:first").addClass("active").show(); 
		$(".tab_content:first").show(); 

		$("ul.tabs li").click(function() {

			$("ul.tabs li").removeClass("active"); 
			$(this).addClass("active"); 
			$(".tab_content").hide(); 

			var activeTab = $(this).find("a").attr("href"); 
			$(activeTab).fadeIn(); 
			return false;
		}); */

	});
	function MM_jumpMenu(targ,selObj,restore){ 
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	</script>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5WZ88MN');</script>
	<!-- End Google Tag Manager -->
</head>
<body <?php body_class(); ?>>
	
	<?php if(is_front_page()){ ?>
	<div class="hm_blk1">
		<div class="main">
			<div class="signin">
				<ul>
					<?php /*
					<li><a href="<?php echo site_url(); ?>/my-account/"><?php if ( is_user_logged_in() ) { ?>My Account<?php }else{ ?>Products<?php } ?></a></li>
					 <li class="buynow"><a href="<?php echo site_url(); ?>/checkout/"><?php if(WC()->cart->get_cart_contents_count() > 0){ ?><span><?php echo WC()->cart->get_cart_contents_count(); ?></span><?php } ?>Buy Now</a></li> */ ?>
					 <li><a href="<?php echo site_url(); ?>/products/">Products</a></li>
				</ul>
			</div>
			<div class="hdtop home_video">
				<div class="logo"><a href="<?php echo get_site_url();?>"><img src="<?php if(get_option('image_location') != ""){ echo get_option('image_location'); }else{ echo get_template_directory_uri()."/images/logo.png"; } ?>" alt=""/></a>
                <div class="hm-mobile-title">A Unique Personalized Storybook For Kids!</div>
                </div>
				<div class="videowrap">
					<?php /*<video id="video1" autoplay >
					  <source src="<?php echo get_template_directory_uri(); ?>/images/vid2.mp4" type="video/mp4">
					</video> */ ?>
					<div class="iframe_wrp">
						<iframe src="https://www.youtube.com/embed/EaPJTz_FiFc?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>
					</div>
					<?php /*<button class="btn" onclick="playPause()"></button> 
					 echo get_field('header_text'); ?>
					<?php if(get_field('video_link')){ ?>
						<div class="playbtn"><a class="a_vd" href="<?php echo get_field('learn_how_page'); ?>"></a></div>
						<div style="display:none;">
							<div class="vd-iframe" id="vd-1">
								<?php echo get_field('video_link'); ?>
							</div>
						</div>
					<?php } */ ?>
				</div>
				<div class="boyimg"><img src="<?php echo get_template_directory_uri(); ?>/images/boy.png" alt=""/> </div>
				<div class="girlimg"><img src="<?php echo get_template_directory_uri(); ?>/images/girl.png" alt=""/> </div>
			</div>
		</div> 
		<div class="bg"><img src="<?php echo get_template_directory_uri(); ?>/images/btm.png" alt=""/></div>
	</div>
	<?php }else{ ?>
		<div class="hm_blk1 inner">
			<div class="topblk">
				<div class="main">
					<div class="signin">
						<ul>
							 <li><a href="<?php echo site_url(); ?>/products/">Products</a></li>
							<?php /*<li class="buynow"><a href="<?php echo site_url(); ?>/checkout/"><?php if(WC()->cart->get_cart_contents_count() > 0){ ?><span><?php echo WC()->cart->get_cart_contents_count(); ?></span><?php } ?>Buy Now</a></li> */ ?>
						</ul>
					</div>
					<div class="hdtop">
						<div class="logo"><a href="<?php echo get_site_url();?>"><img src="<?php if(get_option('image_location') != ""){ echo get_option('image_location'); }else{ echo get_template_directory_uri()."/images/logo.png"; } ?>" alt=""/></a></div>
						<div class="boyimg"><img src="<?php echo get_template_directory_uri(); ?>/images/boy.png" alt=""/> </div>
						<div class="girlimg"><img src="<?php echo get_template_directory_uri(); ?>/images/girl.png" alt=""/> </div>
						<!--<div id="changededication" class='hide'>You can modify the dedication page text after checkout</div>-->
					</div>
				</div> 
			</div>
		</div>
	<?php } ?>