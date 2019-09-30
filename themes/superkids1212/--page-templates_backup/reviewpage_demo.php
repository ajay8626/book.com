<?php
/**
* Template Name: Review Page Demo
*
*/
get_header(); 

require("class.phpmailer.php");
global $wpdb;
$msg = $_REQUEST['succ'];

if(isset($_POST['submit_reviews'])){

	$cname=isset($_POST['cname']) && $_POST['cname'] != "" ? $_POST['cname'] : "Anonymous";
	$kname=isset($_POST['kname'])?$_POST['kname']:"";
	$city=isset($_POST['city'])?$_POST['city']:"";
	$email=isset($_POST['email'])?$_POST['email']:"";
	$phone=isset($_POST['phone'])?$_POST['phone']:"";
	$message=isset($_POST['message'])?$_POST['message']:"";

	$rate=$_POST['rate'];
	$data= array('customer_name'=>$cname,'kid_name'=>$kname,'email'=>$email,'city'=>$city,'phone'=>$phone,'message'=>$message,'rating'=>$rate);

	$wpdb->insert('wp_review',$data);

	$subject  = 'Review Details - Superkids';
	$message  = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>Review</title></head>
		<body style="margin:0; padding:0;">
		<table style="margin:0 auto; width:570px;" cellspacing="0" cellpadding="0" border="0"><thead>
		<tr>
		<th style="text-align:center; background:#75c202; padding:22px 0 20px;"><img src="http://superkidsleague.com/wp-content/uploads/2017/05/logo.png" alt=""></th></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Review Details</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Name : '.$cname.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Kid Name : '.$kname.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Email : '.$email.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">City : '.$city.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Message : '.$message.'</td>
		</tr>
		</tbody></table>
		</body></html>';
			$Host = get_option('smtp_hostname');
			$Username = get_option('smtp_username');
			$Password = get_option('smtp_password');
			if($Host != '' && $Username != '' && $Password != ''){
				$mail = new PHPMailer();	
				$mail->IsSMTP(); 			
				$mail->Host = $Host;	
				$mail->Username = $Username;	
				$mail->Password = $Password;	
				$mail->SMTPAuth = true;		
				$mail->Debug = true;	
				$mail->From = 'littleeinstein@superkidssingapore.com'; 	
				$mail->FromName = "Superkid's League";		
				$mail->IsHTML(true);							
				$loc_email = get_option('admin_email');					
				$mail->AddAddress($loc_email);	
				$mail->Subject = $subject;		
				$mail->Body = $message;		
				$ok=$mail->Send();
				if($ok){
					wp_redirect(get_permalink().'?succ=1');
				}
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
	
		/* if($('#cname').val() == ''){
			$('#cname').focus();			
			sweetAlert("Please enter name.", "", "error");
			return false;
		}
		if($('#kname').val() == ''){
			$('#kname').focus();			
			sweetAlert("Please enter kid name.", "", "error");
			return false;
		}
		if($('#email').val() == ''){
			$('#email').focus();			
			sweetAlert("Please enter email.", "", "error");
			return false;
		}else if (!ValidateEmail($('#email').val())) {
			$('#email').focus();			
			sweetAlert("Please enter valid email.", "", "error");
			return false;
		}
		if($('#city').val() == ''){
			$('#city').focus();			
			sweetAlert("Please enter city.", "", "error");
			return false;
		}
		if($('#message').val() == ''){
			$('#message').focus();			
			sweetAlert("Please enter message.", "", "error");
			return false;
		} */
		
		if($('#rate').val() != ''){
			return true;
		}else {
			sweetAlert("Please select rating.", "", "error");
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
		<?php if($msg==1){  ?>
		<div class="errmsg_cls">
		<h3>Thanks for writing to us. We will get back to you as soon as possible.</h3>	
		</div>
		<?php }  ?>
		<form name="reviewform" id="reviewform" action="" method="POST">
         <ul>
			<li class="full_li"><label>Rate:</label>
			<input type="hidden" name="rate" id="rate" />
			<div class="rating">
				<div>
				<span class="ratingSelector">
				<input type="radio" name="ratings[1]" id="Degelijkheid-1-5" value="1" class="radio">
				<label class="full" for="Degelijkheid-1-5"></label>
				<input type="radio" name="ratings[1]" id="Degelijkheid-2-5" value="2" class="radio">
				<label class="full" for="Degelijkheid-2-5"></label>
				<input type="radio" name="ratings[1]" id="Degelijkheid-3-5" value="3" class="radio">
				<label class="full" for="Degelijkheid-3-5"></label>
				<input type="radio" name="ratings[1]" id="Degelijkheid-4-5" value="4" class="radio">
				<label class="full" for="Degelijkheid-4-5"></label>
				<input type="radio" name="ratings[1]" id="Degelijkheid-5-5" value="5" class="radio">
				<label class="full" for="Degelijkheid-5-5"></label>
				</span>
				</div>
			</div>
			</li>
		 
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
           <label>City:</label>
			<input name="city" value="" id="city" />
          </li>
          <li class="full_li">
           <label>Message:</label>
			<textarea name="message" id="message"></textarea>
          </li>
          <li class="btn_li"><input type="submit" class="btn_cn" name="submit_reviews" id="submit_reviews" value="Submit" /></li>
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