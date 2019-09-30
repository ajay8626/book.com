jQuery(document).ready(function($){
	/* $(".a_vd").fancybox(); 
	$('#flipbook').pageFlip();
	jQuery('.fullSizeImage').click(function(){
		jQuery('.MagicZoomPlus img').click();
		jQuery('body').addClass('dblock');
	});
	
	jQuery('.MagicZoomPlus').click(function(){
		jQuery('body').addClass('dblock');
	});
	
	
	 
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
	}); */ 
	
	var owl = jQuery("#flipbookproduct");
        owl.owlCarousel({
                items: 1,
                itemsDesktop: [1279, 1],
                itemsDesktopSmall: [1023, 1],
                itemsTablet: [979, 1],
                loop: true,
                itemsMobile: [639, 1]
        });
});

jQuery(window).load(function(){
		
	setTimeout(function(){	
		
		jQuery('.MagicThumb-expanded').click(function(){
			jQuery('body').removeClass('dblock');
		});
		
	},1500);

	jQuery(document).ready(function($){
		$('.owl-item a').click(function() {
			if ($(this).hasClass('act')) {
				$('.owl-item a').removeClass('act');          
			} else {
				$('.owl-item a').removeClass('act');
				$(this).addClass('act');
			}
		}); 
		$(".owl-example_4").owlCarousel({
			items: 5,
			itemsCustom: !5,
			itemsDesktop: [1199, 5],
			itemsDesktopSmall: [979, 5],
			itemsTablet: [768, 5],
			itemsTablet: [750, 5],
			itemsTabletSmall: [481,4],
			itemsMobile: [380, 4]
		});
		
		
	});
});