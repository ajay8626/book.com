document.documentElement.addEventListener('touchstart', function (event) {
  alert(current_user);
  if (event.touches.length > 1) {
    event.preventDefault();
  }
}, false);
jQuery(document).ready(function($){ 
$(".hm_blk1 .signin").hover(
  function () {
    $('body').addClass("result_hover");
  },
  function () {
    $('body').removeClass("result_hover");
  }  );

$(".flip_wrap #flipbook .slide:nth-last-child(2)").addClass("certy");
$(".flip_wrap #flipbook .slide:nth-child(2)").addClass("baby_nm");
/* if($( "body" ).hasClass( "woocommerce-checkout" )){
    jQuery('#billing_first_name').val(jQuery('#billing_first_name').val().toUpperCase());   
    jQuery('#billing_address_1').val(jQuery('#billing_address_1').val().toUpperCase());
    jQuery('#billing_address_2').val(jQuery('#billing_address_2').val().toUpperCase()); 
    jQuery('#billing_house_number').val(jQuery('#billing_house_number').val().toUpperCase());   
    jQuery('#billing_street_address').val(jQuery('#billing_street_address').val().toUpperCase());
    jQuery('#billing_landmark').val(jQuery('#billing_landmark').val().toUpperCase());
    jQuery('#billing_city').val(jQuery('#billing_city').val().toUpperCase());
} */
/* billing_kidsname */
jQuery('#billing_kidsname').prop('readonly', true);
  var swiper = new Swiper('.swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        pagination: '.swiper-pagination',
        slidesPerView: 2,
        centeredSlides: true,
        paginationClickable: true,
        spaceBetween: 0
    });
});

jQuery(function() {
    
    heightChart = jQuery("dl.variation dd.variation-Name p").text();
    if(heightChart != ""){
        jQuery("#billing_kidsname_field").css("display", "block");
        jQuery('.woocommerce-billing-fields__field-wrapper').find('#billing_kidsname').val(heightChart);
    }
    console.log(heightChart);
    checkoutName = jQuery( "table.wdm_options_table span.checkout_name" ).val();
    checkoutName = jQuery('.wdm_options_table').find('span.kids_name').text();
    kidsName = checkoutName.charAt(0).toUpperCase() + checkoutName.slice(1);
    var bagKidsName = jQuery("p#billing_kidsname_field").text();
    if(bagKidsName != ""){
    	bagkidsName = bagKidsName.charAt(0).toUpperCase() + bagKidsName.slice(1);	
    }else{
    	bagkidsName = "";
    }
    if(checkoutName != ""){
        jQuery('.woocommerce-billing-fields__field-wrapper').find('#billing_kidsname').val(kidsName);    
    }else if(bagkidsName != ""){
        jQuery('.woocommerce-billing-fields__field-wrapper').find('#billing_kidsname').val(bagKidsName);
    }else if(heightChart != ""){
        jQuery('.woocommerce-billing-fields__field-wrapper').find('#billing_kidsname').val(heightChart);
    }else{
        jQuery('.woocommerce-billing-fields__field-wrapper').find('#billing_kidsname').hide();
    }

   /* jQuery('#billing_first_name').attr('value', '');
    jQuery('#billing_address_1').attr('value', '');
    jQuery('#billing_address_2').attr('value', '');
    jQuery('#billing_landmark').attr('value', ''); 
    jQuery('#billing_city').attr('value', ''); 
    jQuery('#billing_state').attr('value', ''); 
    jQuery('#billing_postcode').attr('value', ''); 
    jQuery('#billing_phone').attr('value', '');
    jQuery('#billing_email').attr('value', ''); 
    jQuery('#billing_landline').attr('value', ''); 
    jQuery('#billing_secondry_email').attr('value', ''); */
    jQuery('#billing_first_name,#billing_address_1,#billing_address_2,#billing_landmark,#billing_city,#billing_house_number,#billing_street_address').keyup(function() {
        //this.value = this.value.toUpperCase();
    });
});
jQuery(document).ready(function($){   
    var owl = $(".owl-carousel-video");     
    owl.owlCarousel({ items :3, itemsDesktop : [1000,3], itemsDesktopSmall : [1030,3],  itemsTablet: [767,1],   itemsMobile :  [360,1]});
  
});