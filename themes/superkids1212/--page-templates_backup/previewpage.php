<?php
/**
* Template Name: Preview Page Demo
*
*/
get_header(); 
global $wpdb;
if(isset($_POST['submit_previews'])){
	$cname=isset($_POST['cname']) && $_POST['cname'] != "" ? $_POST['cname'] : "Anonymous";
	$kname=isset($_POST['kname'])?$_POST['kname']:"";
	$phone=isset($_POST['phone'])?$_POST['phone']:"";
	$email=isset($_POST['email'])?$_POST['email']:"";
	$nameAttribute=isset($_POST['message'])?$_POST['message']:"";
	$data= array('customer_name'=>$cname,'kids_name'=>$kname,'email'=>$email,'phone_number'=>$phone,'name_attribute'=>$nameAttribute, 'created_on' => date('Y-m-d H:i:s'));
	if($wpdb->insert('wp_preview_pages',$data)){
		$query = "SELECT id FROM `wp_preview_pages` ORDER BY `id` DESC LIMIT 0,1";
	    $result = $wpdb->get_results($query);
	    $id = $result[0]->id;
	    get_permalink().'demo'.'?succ='.$id;
	}

}


?>
<style>
	.rating input { display: none; } 
	.rating label:before { 
	margin: 5px;
	font-size: 1.25em;
	font-family: FontAwesome;
	display: inline-block;
	content: "\2605";
	}


	.rating label {color: grey;}
	label:hover { color: green;  }
	.ratingSelector:hover .full {color: green; }
	.full:hover ~ .full { color: grey !important;  } 
	.frm_wrap .rating div label {
	color: #000;
	float: left;
	width: auto;
	}
	.cl_red{color:green !important;}
	</style>
<script>
jQuery(document).ready(function($){
	
	$(".full").on("click", function(){
		//$('.full').css('color','grey');
		$('.full').removeClass('cl_red');
		$('#rate').val($(this).prev().val());
		//$(this).css('color','red');
		//$(this).prevAll('.full').css('color','red');
		$(this).addClass('cl_red');
		$(this).prevAll('.full').addClass('cl_red');
	}); 
	
	
	$('#reviewform').submit(function(){
	
		if($('#cname').val() == ''){
			$('#cname').focus();			
			sweetAlert("Please enter parent's name.", "", "error");
			return false;
		}
		if($('#kname').val() == ''){
			$('#kname').focus();			
			sweetAlert("Please enter kid's name.", "", "error");
			return false;
		}
		if($('#email').val() == ''){
			$('#email').focus();			
			sweetAlert("Please enter your email.", "", "error");
			return false;
		}else if (!ValidateEmail($('#email').val())) {
			$('#email').focus();			
			sweetAlert("Please enter valid email.", "", "error");
			return false;
		}
		if($('#phone').val() == ''){
			$('#phone').focus();			
			sweetAlert("Please enter Mobile Number.", "", "error");
			return false;
		}
		if($('#name_attribute').val() == ''){
			$('#name_attribute').focus();			
			sweetAlert("Please enter Name Attribute.", "", "error");
			return false;
		}
		return true;
	});
});
</script>
<div class="innercnt">
	<div class="mtp">
		<?php 
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		
		?>
        <div class="frm_wrap rev">
		<form name="reviewform" id="reviewform" action="" method="POST">
         <ul>
			
          <li>
           <label>Name:</label>
			<input name="cname" value="" id="cname" />
          </li>
		  <li>
           <label>Kid Name:</label>
			<input name="kname" value="" id="kname" />
          </li>
          <li>
           <label>Email:</label>
			<input name="email" value="" id="email" />
          </li>
          <li>
           <label>Mobile:</label>
			<input name="phone" value="" id="phone" />
          </li>
          <li class="full_li">
           <label>Name Abbreviation:</label>
			<textarea name="name_attribute" id="name_attribute"></textarea>
          </li>
          
          <li class="btn_li"><input type="submit" class="btn_cn" name="submit_previews" id="submit_previews" value="Submit" /></li>
         </ul>
		</form>
        </div>
	</div>
<div class="clear"></div>
</div>
	<script>
function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
</script>
<?php get_footer(); ?>