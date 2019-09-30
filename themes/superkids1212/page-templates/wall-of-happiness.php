<?php
/**
* Template Name: Wall of Happiness
*
*/
get_header(); 
$images = intval( $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->nggpictures WHERE galleryid = 1") );?>
<div class="innercnt">
	<div class="mtp">
		<div class="gellerywrap">
			<div class="container">
				<div class="ngg-galleryoverview ngg-ajax-pagination-none" id="a778aa7347e25fd4a79b357aeda77e92">
				<?php 
				$picturelist = nggdb::get_gallery(1, 'sortorder', 'ASC', true, 9, 0);
					$images = array();
					if(!empty($picturelist)){
						$i = 1;
					foreach($picturelist as $image){
						echo '<div id="ngg-image-'.$image->pid.'" class="ngg-gallery-thumbnail-box"><div class="ngg-gallery-thumbnail"><a href="'.$image->imageURL.'" title="" data-src="'.$image->imageURL.'" data-thumbnail="'.$image->imageURL.'" data-image-id="'.i.'" data-title="'.$image->alttext.'" data-description="" data-image-slug="'.$image->image_slug.'" class="ngg-fancybox" rel="'.imgrel.'" style="cursor: auto;"><img title="'.$image->image_slug.'" alt="'.$image->alttext.'" src="'.$image->imageURL.'" style="max-width:100%;" width="240" height="160"></a></div></div>';
						/* if($i % 3 == 0) { echo '<br style="clear: both">';} $i++; */
					}
					} 
				?>
				</div>
				<div class="proploadwrap run" style="display:none;" id="load-more" data-atr=""><img src="<?php echo get_template_directory_uri() . '/images/loder.svg'; ?>"/></div>
			</div>
		</div>
	</div>
</div>
<?php 
/* $picturelist = nggdb::get_gallery(1, 'sortorder', 'ASC', true, $limit, $offset);
	$images = array();
	if(!empty($picturelist)){
	foreach($picturelist as $image){
		echo '<pre>';
		print_r($image->image_slug);
		echo '</pre>';
	}
	} */
?>
<script type="text/javascript">
  var limit = 6
  var offset = 0;

	function displayRecords(lim, off) {	
		jQuery('#load-more').show();
	jQuery('#load-more').removeClass('run');			
		action = 'nextgen_pagination';
		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_auth_object.url,
			data: {
				'action': action,
				'limit': lim,
				'offset': off
			},
			error: function (xhr, status) {
				jQuery('#load-more').hide();
			  jQuery('#load-more').addClass('run');
			},
			success: function (response) {
				imgrel = jQuery('.ngg-fancybox').attr("rel");
				if (jQuery.isEmptyObject(response.records)) {
				  jQuery('#load-more').attr("data-atr","nodata");
				  jQuery('#load-more').addClass('run');
				  jQuery('#load-more').hide();
				} else {					
					var html = ''; 
					var i = 1;
					jQuery.each(response.records, function(idx, record){
						html +='<div id="ngg-image-'+record.pid+'" class="ngg-gallery-thumbnail-box"><div class="ngg-gallery-thumbnail"><a href="'+record.imageurl+'" title="" data-src="'+record.imageurl+'" data-thumbnail="'+record.imageurl+'" data-image-id="'+i+'" data-title="'+record.imagename+'" data-description="" data-image-slug="'+record.image_slug+'" class="ngg-fancybox" rel="'+imgrel+'" style="cursor: auto;"><img title="'+record.image_slug+'" alt="'+record.imagename+'" src="'+record.imageurl+'" style="max-width:100%;" width="240" height="160"></a></div></div>';
						/* if(i % 3 == 0) {html +='<br style="clear: both">';} */
						i++;
					});
					jQuery('.ngg-galleryoverview').append(html);
					var container = document.querySelector('.ngg-galleryoverview');
					  var msnry = new Masonry( container, {
						itemSelector: '.ngg-gallery-thumbnail-box',
						columnWidth: '.ngg-gallery-thumbnail-box',                
					  });
						setTimeout(function(){  msnry.layout(); }, 2000);
					jQuery('#load-more').addClass('run');
				}
			}
		});
	}

  jQuery(document).ready(function() {
	  jQuery(".ngg-fancybox").fancybox();
		offset = 3;
		jQuery('#load-more').hide();
		jQuery(window).scroll(function(){
			footerheight = jQuery(document).height();
			if (jQuery(window).scrollTop() >= footerheight - jQuery(window).height() - 128){
				var d = jQuery('#load-more').attr("data-atr");
			  if (d != "nodata") {
				  if(jQuery('#load-more').hasClass('run')){	  
				offset = limit + offset;
				displayRecords(limit, offset);
				
				  }
			  }
			}
		});
  });
</script>	
 <script type="text/javascript">
        
        jQuery(window).load(function() {
      var container = document.querySelector('.ngg-galleryoverview');
      var msnry = new Masonry( container, {
        itemSelector: '.ngg-gallery-thumbnail-box',
        columnWidth: '.ngg-gallery-thumbnail-box',                
      });  
      
        });
	
      
    </script>
<?php get_footer(); ?>