<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<div class="footer">
	<div class="main">
		<div class="footermenu">
			<ul>
				<?php
					$defaults = array(
					'theme_location'  => '',
					'menu'            => 'Footer menu',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '%3$s',
					'depth'           => 0,
					'walker'          => ''
					);
					
					wp_nav_menu( $defaults );
				?>
			</ul>
		</div>
		<div class="social">
			<?php if(get_option('ad_facebook_link') != ''){ ?><a href="<?php echo get_option('ad_facebook_link');?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/fb.png" alt="" /></a><?php } ?>
			<?php if(get_option('ad_twitter_link') != ''){ ?><a href="<?php echo get_option('ad_twitter_link');?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/twi.png" alt="" /></a><?php } ?>
			<?php if(get_option('ad_instagram_link') != ''){ ?><a href="<?php echo get_option('ad_instagram_link');?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/insta.png" alt="" /></a><?php } ?>
			<?php if(get_option('ad_youtube_link') != ''){ ?><a href="<?php echo get_option('ad_youtube_link');?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" alt="" /></a><?php } ?>
		</div>
		<div class="copyright"><?php echo stripslashes(get_option('ad_footer_desc'));?></div>
	</div>
<?php wp_footer(); ?>
<?php if(is_checkout()){ ?>
<script>
(function($) {
	
	jQuery('#kidsphoto').change(function () {
    var ext = $(this).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
		alert('Sorry, only jpg, jpeg, png files are allowed.');
		$(this).val('');
		return false;
	}else{
		if(this.files[0].size > 3145728){
			alert('invalid image size!');
			$(this).val('');
			return false;			
		} 
	}
});
})(jQuery);


    jQuery(document).ready(function($) {
		jQuery('#billing_postcode').keyup(function() {
			$( 'body' ).trigger( 'update_checkout' );
		});
            $("#payment_method_razorpay").trigger("click");
            /* $("#payment_method_razorpay").addClass("checked"); */
       
	
	$("#order_comments").css('height','120px');
	$("#wufdc_div h3").css('margin-top','40px');
	$("#wufdc_div h3").css('margin-bottom','10px');
	$("#wufdc_div small").text('(only jpg, jpeg, png files are allow)');
	$("wufdc_div small").css('float','left');
	$("wufdc_div small").css('width','100%');
	$('#personalised_detail').keypress(function(e) {
		var tval = $('#personalised_detail').val(),
			tlength = tval.length,
			set = 725,
			remain = parseInt(set - tlength);
		if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
			$('#personalised_detail').val((tval).substring(0, tlength - 1));
			return false;
		}
	})
});
</script>
<?php } ?>
</div>
 
<!--            
<script type="text/javascript">
    (function () {
        var head = document.getElementsByTagName("head").item(0);
        var script = document.createElement("script");
        
        var src = (document.location.protocol == 'https:' 
            ? 'https://www.formilla.com/scripts/feedback.js' 
            : 'http://www.formilla.com/scripts/feedback.js');
        
        script.setAttribute("type", "text/javascript"); 
        script.setAttribute("src", src); script.setAttribute("async", true);        

        var complete = false;
        
        script.onload = script.onreadystatechange = function () {
            if (!complete && (!this.readyState 
                    || this.readyState == 'loaded' 
                    || this.readyState == 'complete')) {
                complete = true;
                Formilla.guid = 'cs44ef07-a50a-4c8a-8da8-e0c236959248';
                Formilla.loadWidgets();                
            }
        };

        head.appendChild(script);
    })();
</script> -->
                                    
	<script type="text/javascript"><!--
    //<![CDATA[
    twatchData = 'page=' + encodeURIComponent(window.location);
    if (typeof document.referrer != 'undefined' && document.referrer != '') {
        twatchData += '&ref=' + encodeURIComponent(document.referrer);
    }
    
    twatchData += '&website_id=' + encodeURIComponent('superkidsleague');
    if (typeof screen.width != 'undefined') {
        twatchData += '&resolution=' + screen.width + 'x' + screen.height;
    }
    document.write('<scr' + 'ipt type="text/javascript" ' +
	'src="http://www.websitedesigner.ws/tracewatch/remote/js_logger.php?' + twatchData + '">' +
	'</scr' + 'ipt>');
    //]]>
//--></script>

<!-- Google Code for Remarketing Tag -->

<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1068735470;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1068735470/?guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>