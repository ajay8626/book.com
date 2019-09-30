<?php
/**
* Template Name: Custom Test Page
*
*/

get_header(); 
error_reporting(0);
?>
<?php
if((isset($_REQUEST)) && (!empty($_REQUEST))){
  $ucode = $_REQUEST['uc'];
  if($ucode != ""){
    $message = "Visitors Code = ". $ucode;
    $subject = 'From Superkids Worksheet';
    $loc_email = 'keval@skids.in';
    $headers = "From: Skids <contact@superkidsleague.com> \r\n" . 
        "Content-type: text/html; charset=UTF-8 \r\n"; 
    $ok = wp_mail($loc_email, $subject, $message, $headers);
  }
}
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
  .topimg img{max-width:100% !important;height:960px !important;width:auto !important;display:block;margin:0 auto;margin-left:15% } 
  
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
.jssora106.arrowrgt {margin-top: 101px;}
.jssora106.arrowlft {margin-top: 101px;}
.pricewrap .inputbox input{padding-top:5px}
.rightcntlist{padding-top:7px;padding-left:30px}
.rightcntlist .pricewrap .price{border:1px solid #787878}
.innercnt .mtp{padding-bottom:30px;}
.rightcntlist .pricewrap .buybtn{margin-top:20px}
    
</style>

<?php
$category_link = get_category_link( $category_id );
$pageId =$_SERVER['REQUEST_URI'];
$pageId= explode('/', $pageId);

$id = $pageId[2];
/*$args = array( 'post_type' => 'bags');
$variationloop = new WP_Query( $args );
//echo "<pre>"; print_r($variationloop); exit;*/

$product = wc_get_product( $id );
$title = $product->get_title();
$price = $product->get_price_html();
$long_desc = $product->get_description();
$variations = $product->get_available_variations();
$att = $product->get_attribute('pa_worksheet');
$attributes['pa_worksheet']= explode(',', $att);
$attribute_keys = array('pa_worksheet');
add_filter( 'woocommerce_ajax_variation_threshold', 'wvs_ajax_variation_threshold', 8 );
wp_enqueue_script( 'wc-add-to-cart-variation' );

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
//echo "<pre>"; print_r($att);exit;
/*$bagkidsname = $_REQUEST['skids_name'];
$bagkidsgender = $_REQUEST['skids_gender'];*/
$uploads = wp_upload_dir();
$upload_url = $uploads['baseurl'];
$upload_path = $uploads['basedir'];

//echo '<input type="checkbox" name="product_id" value="' . $product->ID . '" />';

?>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script> 

<div class="innercnt bag_single_product worksheet_page">
  <div class="mtp">
    <h1>Superkids Worksheets for UKG / Sr. KG (4-6 years)<br> Set of 6 Workbooks</h1>
    <div class="sliderwrap product-detail cusprod">
    <div id="jssor_1" style="position:relative;margin:0 auto;top:10px;left:0px;width:980px;height:1200px;overflow:hidden;visibility:hidden;">
      <!-- <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
              <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
          </div> -->
        <?php
         if( have_rows('slider_image', $id) ): ?>
          <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:950px;overflow:hidden;" class="topimg">
            <?php   while ( have_rows('slider_image', $id) ) : the_row(); if(empty(get_sub_field('images'))){ continue; } ?>
              <div>
                <a href="<?php  the_sub_field('images'); ?>" class="fancybox" rel="group"><img data-u="image" src="<?php the_sub_field('images'); ?>" /></a>
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
    <div method="POST" name="bagsproduct" id="bagsproduct">
      <div class="rightcntlist">
      <!-- <h1><?php //echo $title; ?></h1> -->
      
      <span><?php 
      $sort_desc = get_field('worksheet_description', $id);
      echo $sort_desc; ?>
        <br>

        <p><strong>Super Kids League</strong> brings to your home a series of fun, challenging, high-quality practice-based workbooks for your preschooler or kindergartener. The content of the worksheets are designed to be complementary to the curriculum and thus they don’t add to the workload. </p><br>

        <p><strong>Why Super kids worksheets is a superior choice</strong></p>
        <ul>
        <li>480 pages of worksheet that work in tandem with the overall development of the child</li>
        <li>Colourful, bright and engaging visuals makes learning fun.</li>
        <li>Scientifically worded instructions make it easy and natural for a kid to understand and follow.</li>
        <li>No two back-to-back worksheets have the same cognitive challenge.</li>
        <li>The worksheets become more challenging as the child progresses, providing a stimulating learning experience.</li>
        <li>All topics are curriculum based and researched by alumnus of IIM A & IIT R.</li>
        <li>Clear learning outcomes help give parents an understanding of the progress made.</li>
        </ul>
        <p>Superkids worksheets make learning and practicing easy and so much fun!</p>

      </span>
      
      
      <div class="pricewrap">
        <div class="clear"></div>
        <div class="kids_name">
        <div class="clear"></div>
        
        <?php
          $get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
          wc_get_template( 'single-product/add-to-cart/variable.php', array(
            'available_variations' => $get_variations ? $product->get_available_variations() : false,
            'attributes'           => $product->get_variation_attributes(),
            'selected_attributes'  => $product->get_default_attributes(),
          ) );
          ?>
          <div class="save_price"><i>(You Save: Rs.1,500 (49.98%))</i></div>
    </div>

    <div class="long_desc">

      <?php //echo $long_desc; ?>
    </div>
    <div class="cod_avail">(COD Available)</div>
    <div class="clear"></div>
    <div class="money_back"><span class="blink_remaining"><i>100% money back Guarantee </i></span><br><i> "If you don't like our worksheets, we will refund the full amount. No Question  Asked!"</i></div>
    <span class="work_pdf">
    <p><b>Download sample PDF</b>
    <?php
      $pdfUrl = $upload_url.'/worksheet_pdf/ukg-combined.pdf';
      $pdfimage = $upload_url.'/worksheet_pdf/pdf.png';
    ?>
    <a href="<?php echo $pdfUrl; ?>" target="_blank" download><img class="pdf" alt="" border="0" src="<?php echo $pdfimage;?>"></a></p>
  </span>
    
  <?php /*<div class="free_chart"><strong>"Order Now and get a free <a href="http://superkidsleague.com/superkids-height-chart/" target="_blank" style="color:red">heigth chart</a> worth Rs. 299/-"</strong></div> */ ?>
</div>
</div>
<div class="clear"></div>

<span class="bag_desc">
  <strong>Description</strong>
</span>
<div class="diswarp">
<?php
if( get_field('worksheet_product', $id) ){
  $i = 1;
  while ( have_rows('worksheet_product', $id) ) {
    the_row();  ?>
      <div class="dislist">
      <div class="dis_slider">
      <div class="owl-carousel owl-theme flipbookproduct">
        <?php if( have_rows('worksheet_images') ){
            while ( have_rows('worksheet_images') ) { 
                the_row(); ?>
                <div class="slide">
                  <a href="<?php the_sub_field('cource_images'); ?>" class="fancybox<?php echo $i;?>" rel="group">
                    <img src="<?php the_sub_field('cource_images'); ?>" alt=""></a>
                </div>  
          <?php } }?>
          </div>
          <?php the_sub_field('title_desc');?>
      </div>
      <div class="discription">
       <?php echo get_sub_field("description"); ?>
        <a href="<?php the_sub_field('pdf_file'); ?>" target="_blank" download><img class="pdf" alt="" border="0" src="<?php echo $upload_url.'/worksheet_pdf/pdf.png';;?>"></a>
      </div>
      </div>
      <?php $i++; } }?>
    </div>

<div class="dislist">
  <div class="discription">
    <p><b>Words from the desk of the curator of the worksheets- Mr.Ameet Siingh (IIM Ahmedabad, IIT Roorkee) who shares how practising worksheet has helped him get admission into institutes like IITs and IIMs.</b></p>
    <p><i>"It has been an incredible journey so far. When I look back to find the reason for my academic success, I find one unique but obvious habit which came naturally to me and it was – <b>“PRACTICE MAKES ONE PERFECT”</b>. I without understanding the science behind it, use to practice all types of questions multiple times. This habit stuck to me for a lifetime and helped me crack IIMs and IITs and school exams. So I decided to universalize this habit for every kid on this planet. Hence the idea of these super worksheets comes into realization. Remember it is the habit of practising questions, which made the difference. Inculcate the same habit in your kid from the very early age by adopting these worksheets in your kid’s schedule and help him/her become successful in life. <b>All The Best.”</b></b></p>
  </div>
</div>
</div>
<div class="hm_blk3 wk_testimonial">
<div class="testimonialwrap">
<h2 class="testimain-title">Super Moments of Super Parents</h2>
<?php 
  query_posts( array( 'post_type' => 'testimonials', 'showposts' => -1,'meta_query' => array(
          array('key' => 'show_on','value' => 'worksheet','compare' => '==')), 'orderby' => 'date', 'order' => 'DESC' ) ); 
  if ( have_posts() ) :  
?>

  <ul class="testi-list wk_testi_list">
  <?php while ( have_posts() ) : the_post(); ?>
    <li>
      <div class="testi-cnt">
        <p><?php echo wp_trim_words(get_the_content(),30,'...'); ?></p>
        <span class="testi-title wk_testi_title"><?php the_title(); ?><?php if(get_field('location') != "") { ?>, <?php echo get_field('location'); ?><?php } ?></span>
      </div>
    </li>
  <?php endwhile; ?>
  </ul>
<?php endif; wp_reset_query(); ?>
</div>

</div>

  <div class="clear"></div>
  </div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">jssor_1_slider_init();</script>
<script type="text/javascript"> 
jQuery(document).ready(function($) { 
  $(".fancybox").fancybox();
  $(".fancybox1").fancybox();
  $(".fancybox2").fancybox();
  $(".fancybox3").fancybox();
  $(".fancybox4").fancybox();
  $(".fancybox5").fancybox();
  $(".fancybox6").fancybox();
}); 
</script>

