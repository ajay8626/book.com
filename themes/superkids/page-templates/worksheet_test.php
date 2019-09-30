<?php
/**
* Template Name: worksheet test page
*
*/

get_header(); 
error_reporting(0);
?>
<script type="text/javascript">
    jssor_1_slider_init = function() {

        var jssor_1_SlideshowTransitions = [
          {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
        ];

        var jssor_1_options = {
          //$AutoPlay: 1,
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: jssor_1_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
          },
          $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $SpacingX: 5,
            $SpacingY: 5
          }
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        /*#region responsive code begin*/

        var MAX_WIDTH = 980;

        function ScaleSlider() {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_1_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };
</script>
<style>
    /* jssor slider loading skin spin css */
    .jssorl-009-spin img {
        animation-name: jssorl-009-spin;
        animation-duration: 1.6s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }
    @keyframes jssorl-009-spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    .jssora106 {display:block;position:absolute;cursor:pointer;}
    .jssora106 .c {fill:#fff;opacity:.3;}
    .jssora106 .a {fill:none;stroke:#000;stroke-width:350;stroke-miterlimit:10;}
    .jssora106:hover .c {opacity:.5;}
    .jssora106:hover .a {opacity:.8;}
    .jssora106.jssora106dn .c {opacity:.2;}
    .jssora106.jssora106dn .a {opacity:1;}
    .jssora106.jssora106ds {opacity:.3;pointer-events:none;}

    .jssort101 .p {position: absolute;top:0;left:0;box-sizing:border-box}
    .jssort101 .p .cv {display:none} 
    .jssort101 .a {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;visibility:hidden;}
    .jssort101 .p:hover .cv, .jssort101 .p.pdn .cv {border-color:#4F6A8F;}
    .jssort101 .p:hover{padding:2px;} 
    .jssort101 .p:hover.pdn{padding:0;}
    .jssort101 .p:hover.pdn .cv {border:2px solid transparent;background:none;opacity:.35;}
    .jssort101 .pav .cv {border-color:#4F6A8F; }
    .jssort101 .pav .a, .jssort101 .p:hover .a {visibility:visible;}
    .jssort101 .t {position:absolute;top:0;left:0;width:100%;height:100%;border:none;opacity:.6;}
    .jssort101 .pav .t, .jssort101 .p:hover .t{opacity:1;}
    .topimg img{max-width:100% !important;height:670px !important;width:auto !important;display:block;margin:0 auto;margin-left:23% } 
    
    .jssort101 .t {
      padding:10px;
      position: absolute;
      top: 0;
      left: 50%;
      width: auto;
      height: 100%;
      border: none;
      opacity: .6;
      transform: translate3d(-50%, 0, 0px);
    }
  .jssora106.arrowrgt {margin-top: 51px;}
  .jssora106.arrowlft {margin-top: 51px;}
  .pricewrap .inputbox input{padding-top:5px}
  .rightcntlist{padding-top:7px;padding-left:30px}
  .rightcntlist .pricewrap .price{border:1px solid #787878}
  .innercnt .mtp{padding-bottom:30px;}
  .rightcntlist .pricewrap .buybtn{margin-top:20px}
    
</style>
<script>
jQuery(document).ready(function($){
  $(".flipbookproduct").owlCarousel({ autoPlay : false,navigation : true,
    items: 1,
    itemsCustom: !1,
    itemsDesktop: [1199, 1],
    itemsDesktopSmall: [979, 1],
    itemsTablet: [768, 1],
    itemsTablet: [750, 1],
    itemsTabletSmall: [481,1],
    itemsMobile: [380, 1]
  });

  
});
</script> 
<?php /* if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $des = get_the_content(); ?>
<?php endwhile; endif; */ ?>
<!-- <script type='text/javascript' src="<?php //echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script>  -->
<?php 

	$url = $_SERVER['REQUEST_URI'];
	$page = explode('/', $url);
	$productId = $page[3];
	$product = wc_get_product( $productId );
  //echo "<pre>"; print_r($product); exit;
  $des = $product->get_description();
	$product->get_type();
	$name = $product->get_name();
	//echo "<pre>";print_r($name); exit;
	/*$des = $product->get_description();*/
	$price = $product->get_price();
	//echo $des; exit();

 ?>

<div class="innercnt worksheet_single_product bag_single_product">
	<div class="mtp">
		<h1>Kid's Worksheet</h1>
		<div class="sliderwrap product-detail cusprod">
			<div id="jssor_1" style="position:relative;margin:0 auto;top:10px;left:0px;width:980px;height:1000px;overflow:hidden;visibility:hidden;">
				<?php /* <div class="left-slider">							
					<div class="flip_wrap">
						<div class="flipbook-bg">
							<?php if( have_rows('slider_image') ): ?>
							<div id="flipbookproduct" class="owl-carousel owl-theme">
							<?php  while ( have_rows('slider_image') ) : the_row(); if(empty(get_sub_field('images'))){ continue; } ?>
								<div class="slide">
									<a href="<?php the_sub_field('images'); ?>" class="fancybox1" rel="group"><img src="<?php the_sub_field('images'); ?>" alt=""></a>
								</div>	
							<?php endwhile; ?>
							</div>									
							<?php endif; ?>
						</div>
					</div>
				</div> */ ?>
				  <?php
		         if( have_rows('slider_image', $productId) ): ?>
		          <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:750px;overflow:hidden;" class="topimg">
		            <?php 
                  while ( have_rows('slider_image', $productId) ) : 
                    the_row(); 
                    if(empty(get_sub_field('images'))){ 
                      continue; 
                    } ?>
		              <div>
		              <a href="<?php  the_sub_field('images'); ?>" class="fancybox1" rel="group"><img data-u="image" src="<?php the_sub_field('images'); ?>" /></a>
		                <img data-u="thumb" src="<?php the_sub_field('images'); ?>" />
		              </div>
		            <?php endwhile; ?>
		          </div>
		            <?php endif; ?>
		          <!-- Thumbnail Navigator -->
		          <div data-u="thumbnavigator" class="jssort101" style="position:absolute;left:0px;bottom:0px;width:980px;height:240px;" data-autocenter="1" data-scale-bottom="0.75">
		              <div data-u="slides">
		                  <div data-u="prototype" class="p" style="width:200px;height:190px;">
		                      <div data-u="thumbnailtemplate" class="t"></div>
		                      <svg viewBox="0 0 16000 16000" class="cv">
		                          <circle class="a" cx="8000" cy="8000" r="3238.1"></circle>
		                          <line class="a" x1="6190.5" y1="8000" x2="9809.5" y2="8000"></line>
		                          <line class="a" x1="8000" y1="9809.5" x2="8000" y2="6190.5"></line>
		                      </svg>
		                  </div>
		              </div>
		          </div>
		          <!-- Arrow Navigator -->
		          <div data-u="arrowleft" class="jssora106 arrowlft" style="width:100px;height:100px;top:162px;left:30px;" data-scale="0.75">
		              <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
		                  <circle class="c" cx="8000" cy="8000" r="6260.9"></circle>
		                  <polyline class="a" points="7930.4,5495.7 5426.1,8000 7930.4,10504.3 "></polyline>
		                  <line class="a" x1="10573.9" y1="8000" x2="5426.1" y2="8000"></line>
		              </svg>
		          </div>
		          <div data-u="arrowright" class="jssora106 arrowrgt" style="width:100px;height:100px;top:162px;right:30px;" data-scale="0.75">
		              <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
		                  <circle class="c" cx="8000" cy="8000" r="6260.9"></circle>
		                  <polyline class="a" points="8069.6,5495.7 10573.9,8000 8069.6,10504.3 "></polyline>
		                  <line class="a" x1="5426.1" y1="8000" x2="10573.9" y2="8000"></line>
		              </svg>
		          </div>
			</div>
		</div>
		
		
		
		<div class="pricewrap">
        <div class="clear"></div>
        <div class="kids_name">
          <div class="clear"></div>
            <?php
            //echo "<pre>"; print_r($product); exit;
              $get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
              wc_get_template( 'single-product/add-to-cart/variable.php', array(
                'available_variations' => $get_variations ? $product->get_available_variations() : false,
                'attributes'           => $product->get_variation_attributes(),
                'selected_attributes'  => $product->get_default_attributes(),
              ) );
              ?>
        </div>
        <div class="long_desc">
          <?php //echo $long_desc; ?>
        </div>
        <div class="clear"></div>
    </div>
		<div class="commentlist">
			<ul>
				<?php
				if( have_rows('comments') ):
				$i=1;
				    while ( have_rows('comments') ) : the_row();
				?>
				<li><h2><?php echo $i.". "; ?></h2></li>
				    <li>
				        <p><?php the_sub_field('comment'); ?></p>
				    </li>
				<?php  $i++; endwhile; endif; ?>   
			</ul>
		</div>
    
<div class="diswarp">
<?php
if( get_field('worksheet_product', $productId) ){
  while ( have_rows('worksheet_product', $productId) ) {
    the_row();  ?>
      <div class="dislist">
      <div class="dis_slider">
      <div class="owl-carousel owl-theme flipbookproduct">
        <?php if( have_rows('worksheet_images') ){
            while ( have_rows('worksheet_images') ) { 
                the_row(); ?>
                <div class="slide">
                  <a href="<?php the_sub_field('cource_images'); ?>" class="fancybox1" rel="group">
                    <img src="<?php the_sub_field('cource_images'); ?>" alt=""></a>
                </div>  
          <?php  } }?>
          </div>
      </div>
      <div class="discription">
        <?php echo get_sub_field("description"); ?>
      </div>
      </div>
      <?php } }?>
    </div>
  </div>
<div class="hm_blk3">
  <div class="testimonialwrap">
    <h2 class="testimain-title">Super Moments of Super Parents</h2>
    <?php 
      query_posts( array( 'post_type' => 'testimonials', 'showposts' => -1,'meta_query' => array(
              array('key' => 'show_on','value' => 'worksheet','compare' => '==')), 'orderby' => 'date', 'order' => 'DESC' ) );

        /*$args = array(
        'post_type' => 'testimonials',
        'showposts' => -1,
        'no_found_rows' => true,
        'meta_query' => array(
            array('key' => 'show_on','value' => 'worksheet','compare' => '==')),
      );
      $query = new WP_Query( $args  );*/
      if ( have_posts() ) :  
    ?>
      <ul class="testi-list">
      <?php while ( have_posts() ) : the_post(); ?>
        <li>
          <div class="testi-cnt">
            <p><?php echo wp_trim_words(get_the_content(),40,'...'); ?></p>
            <span class="testi-title"><?php the_title(); ?><?php if(get_field('location') != "") { ?>, <?php echo get_field('location'); ?><?php } ?></span>
          </div>
        </li>
      <?php endwhile; ?>
      </ul>
    <?php endif; wp_reset_query(); ?>
  </div>

</div>
  <div class="clear"></div>
</div>
<script type="text/javascript"> jQuery(document).ready(function($) { $(".fancybox1").fancybox(); }); </script>
<script type="text/javascript">jssor_1_slider_init();</script>
<?php get_footer(); ?> 