<?phpFirst CPU 
/**
* Template Name: Custom Product Page
*
*/
/*if(($_SESSION['sess_bookusername'] !='') && ($_SESSION['sess_bookusergender'] !='')){
  session_unset($_SESSION['sess_bookusername']);
  session_unset($_SESSION['sess_bookusergender']);
  session_unset($_SESSION['sess_kids_dob']);
}*/
get_header(); 
 $des = "";
 /*wp_enqueue_script( 'twentyfifteen-fancybox', get_template_directory_uri().'/js/jquery.fancybox.js', array( 'jquery' ), '1.4', false );
 wp_enqueue_style( 'twentyfifteen-fancyboxcss', get_template_directory_uri().'/css/jquery.fancybox.css', array( 'twentyfifteen-style' ), '2.0' );*/
?>
<?php
if(isset($_REQUEST['hcname'])){
	$kidsname = isset($_REQUEST['hcname'])?stripslashes($_REQUEST['hcname']):"";
}
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $des = get_the_content(); ?>
<?php endwhile; endif; ?>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script> 
<script>
jQuery(document).ready(function($){
	$("#flipbookproduct").owlCarousel({ autoPlay : true,navigation : true,
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
  
  <!-- Modal -->
   
<div class="innercnt height_chart">
	<div class="mtp">
		<div class="sliderwrap product-detail cusprod">
			<div class="left-slider">							
				<div class="flip_wrap">
					<div class="flipbook-bg">
						<div class="without_name">
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
						<!-- <div class="with_name">
							<a id="imagepopup" href="<?php //bloginfo('template_directory'); ?>/images/heightchartimagenew.jpg" class="fancybox1" rel="group"><img id="heightimage" src="<?php //bloginfo('template_directory'); ?>/images/heightchartimagenew.jpg" height="300" width="250" /></a>
						</div> -->
						<div id="wait" style="display:none;top:20%;left:40%;padding:2px;"><img src="<?php echo get_template_directory_uri(); ?>/images/gif/demo_wait.gif" width="64" height="64" /><br>Loading..</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<?php $productId = get_field('product_id');
		
		$product = wc_get_product( $productId );
		 
		// Now you have access to (see above)...
		 
		$product->get_type();
		$name = $product->get_name();
		/*$des = $product->get_description();*/

		$price = $product->get_price();
		$variations = $product->get_available_variations();
		$att = $product->get_attribute('pa_height-chart');
		$attributes['pa_height-chart']= explode(',', $att);
		$attribute_keys = array('pa_height-chart');
		add_filter( 'woocommerce_ajax_variation_threshold', 'wvs_ajax_variation_threshold', 8 );
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		//echo "<pre>"; print_r($attribute_keys);exit;
		

		 ?>
		
		<div class="rightcntlist">
			<div class="height_chart_image">
			<h1><?php echo $name; ?></h1>
			
			<div class="pricewrap height_chart_image">
				<!-- <div class="price">Rs- <?php echo $price; ?>/-</div> -->
				<?php

				$get_variations = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
      
		        wc_get_template( 'single-product/add-to-cart/variable.php', array(
		          'available_variations' => $get_variations ? $product->get_available_variations() : false,
		          'attributes'           => $product->get_variation_attributes(),
		          'selected_attributes'  => $product->get_default_attributes(),
		        ) );
				?>
				
				<div class="preview">
					
					<div id="wait" style="display:none;top:20%;left:40%;padding:2px;"><img src="<?php echo get_template_directory_uri(); ?>/images/gif/demo_wait.gif" width="64" height="64" /><br>Loading..</div>
					<a id="imagepopup" href="#" class="fancybox preview_button" >Preview</a>
					<!-- <input type="button" class="preview_button" value="preview"> -->
				</div>
			</div>

			<!-- <div class="display_image">
				<img src="<?php echo bloginfo('template_directory'); ?>/images/kids-photo/10_1538206048.jpg">
			</div> -->
		</div>
		</div>
		<div class="description">
			<h2>Description</h2>
			<?php echo $des; ?>
		</div>
		<div class="commentlist">
			<ul>
				<?php
				if( have_rows('comments') ):
				$i=1;
				    while ( have_rows('comments') ) : the_row();
				?>
				    <li>
				        <p><h2><?php echo $i.". "; ?></h2><i><?php the_sub_field('comment'); ?></i></p>
				    </li>
				<?php  $i++; endwhile; endif; ?>   
			</ul>
		</div>
	</div>
	<a id="height_url" href="<?php echo site_url();?>/checkout/?add-to-cart=25536&amp;quantity=1" class="single_add_to_cart_button custom_btn button alt custom-checkout-btn">Buy Now</a>
	
	<div class="clear"></div>
</div>
<script type="text/javascript"> 
	jQuery(document).ready(function($) { 
		$(".fancybox1").fancybox({
			'showNavArrows': true,
		}); 
		$(".fancybox").fancybox({
			'autoScale' : false,
             'href' : '#',
             'type':'iframe',
             'padding' : 0,
             'closeClick'  : false,
		}); 
	}); 
</script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var hcname = '<?php echo $kidsname; ?>';
		var siteurl = '<?php echo site_url(); ?>';
		$('.with_name').hide();
		$('input.wccpf-field').attr('readonly', 'readonly').css('background', '#e3e3e3');
		//$('#imagepopup').attr('readonly', 'readonly').css('opacity', '0.6');
		$('input[name="upload_image"]').attr('id', 'file');
		$('input[name="upload_image"]').attr('readonly','readonly');
		$("input[name='attribute_pa_height-chart']").click(function() {
			if(this.value == 'personalized-height-chart'){
				var variationId = 25535;
				url = siteurl+'/checkout/?add-to-cart='+variationId+'&quantity=1';
				$("#height_url").attr("href", url);
				$('input.wccpf-field').removeAttr('readonly', 'readonly').css('background', '#fff');
				$('input[name="upload_image"]').removeAttr('readonly','readonly');
				$('#imagepopup').removeAttr('readonly', 'readonly').css('opacity', '1');
        		$('.wccpf-fields-container').css("display", "block");
			}else{
				var variationId = $("input[name='attribute_pa_height-chart']").attr("variation_id");
				url = siteurl+'/checkout/?add-to-cart='+variationId+'&quantity=1';
				$("#height_url").attr("href", url);
				$('input.wccpf-field').attr('readonly', 'readonly').css('background', '#e3e3e3');
				$('#imagepopup').attr('readonly', 'readonly').css('opacity', '0.6');
				$('input[name="upload_image"]').attr('readonly','readonly');
        		$('input.wccpf-field').val('');
			}
		});
		$("button.single_add_to_cart_button, #height_url").on("click", function(){
		    var display = $('.wccpf-field ').css("display");
		    //var kidsname = $('input[name="name"]').val();
		    var readonly = $("input.wccpf-field").attr("readonly");
		    if(readonly != 'readonly'){
		      if($('input.wccpf-field').val() == ""){
		        $('input.wccpf-field').focus();
		        alert('Name is required!');
		        return false;
		      }else{
		      	var kidsname = $('input[name="name"]').val();
		      	var variationId = 25535;
				url = siteurl+'/checkout/?add-to-cart='+variationId+'&name='+kidsname+'&Height-Chart=&quantity=1';
				$("#height_url").attr("href", url);
		      }
		    }else{
		      $('input.wccpf-field').val('');
		    }
		});
		jQuery(document).on('click','.preview_button',function($){
			var kidsname = jQuery('input[name="name"]').val();
			var hcname = '<?php echo $kidsname; ?>';
			if(kidsname == ""){
		        jQuery(kidsname).focus();
		        alert('Name must be required!');
		        return false;
		    }
			jQuery("#wait").css("display", "block");
			//console.log(temp);
			jQuery.ajax({
				method: "POST",
				url: ajax_load_image.ajax_url,
				data: {
		            action: 'upload_kids_image',
		            name: kidsname,
		            hcname: hcname,
		        },
				success:function(data){
					//console.log(data);
					jQuery("#imagepopup").attr("href", data);
					jQuery.fancybox(data, {
		                'href': data,
		            });
					jQuery('#wait').css("display", "none");
				},
				complete: function(){
			        //$('#wait').css("display", "none");
			    },
			});
		});
		if(hcname){
			$("#imagepopup").trigger("click");
		}
	});
</script>
<?php get_footer(); ?> 

