jQuery(document).ready(function() {
	jQuery("#billing_postcode").attr('maxlength','6');
	jQuery("#billing_phone").attr('maxlength','10');
	jQuery(".inputbox select").chosen({no_results_text: "Oops, nothing found!"});
});