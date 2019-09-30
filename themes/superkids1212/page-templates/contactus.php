<?php
/**
* Template Name: Contact Us
*
*/
get_header(); 

require("class.phpmailer.php");
$uploads = wp_upload_dir();
$siteUrl = $upload_path = $uploads['baseurl'].'/'.'contact-us';
$msg = $_REQUEST['succ'];

if($_POST['email']){

$cname=$_POST['cname'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$message=$_POST['message'];

			$subject  = 'Contact Details - Superkids';
			$message  = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>Mail</title></head>
		<body style="margin:0; padding:0;">
		<table style="margin:0 auto; width:570px;" cellspacing="0" cellpadding="0" border="0"><thead>
		<tr>
		<th style="text-align:center; background:#75c202; padding:22px 0 20px;"><img src="http://superkidsleague.com/wp-content/uploads/2017/05/logo.png" alt=""></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Contact Enquiry</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Name : '.$cname.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Email : '.$email.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Phone : '.$phone.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">Message : '.$message.'</td>
		</tr>
		</tbody></table>
		</body></html>';
			/*$Host = get_option('smtp_hostname');
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
				$mail->From = 'littleeinstein@superkidsleague.com'; 	
				$mail->FromName = "Superkid's League";		
				$mail->IsHTML(true);							
				//$loc_email = get_option('admin_email');					
				$loc_email = 'contact@superkidsleague.com';					
				$mail->AddAddress($loc_email);	
				$mail->Subject = $subject;		
				$mail->Body = $message;		
				$ok=$mail->Send();
				if($ok){
					wp_redirect(get_permalink().'?succ=1');
				}
			}*/
			$loc_email = 'contact@superkidsleague.com';
			$headers = "From: Superkid's League <littleeinstein@superkidsleague.com> \r\n" . 
					"Content-type: text/html; charset=UTF-8 \r\n"; 
			$ok = wp_mail($loc_email, $subject, $message, $headers);
			

}

?>
<style type="text/css">
.frm_wrap ul li input.captcha {
	background-image:url("<?php echo $siteUrl; ?>/cat.png"); 
	font-size:20px; 
	border: 1px solid;
	width:100px;
}
.frm_wrap ul li input.ref-btn {
    float: left;
    font-size: 0;
    background: url("<?php echo $siteUrl; ?>/refresh.png") no-repeat;
    border: none;
    width: 25px;
    background-size: 22px;
    margin-left: 10px;
    margin-top: 6px;
    cursor: pointer;
}
.color {
	color:#FF0000;
}
</style>
<script>
jQuery(document).ready(function($){
	$('#contactform').submit(function(){
	
		if($('#cname').val() == ''){
			$('#cname').focus();			
			sweetAlert("Please enter name.", "", "error");
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
		if($('#message').val() == ''){
			$('#message').focus();			
			sweetAlert("Please enter message.", "", "error");
			return false;
		}
		//swal("Done", "", "success");
		return true;
	});
});

function ValidateEmail(email) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return expr.test(email);
};
//Javascript Referesh Random String
function refresh() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz@!#$%&*()<>{}[]";
	var string_length = 5;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	document.contactform.captch_ref.value = randomstring;
}
//Javascript Captcha validation
function validateCaptcha() {
	if(document.contactform.chk.value == "") {
	    document.contactform.chk.focus();
		sweetAlert("Please enter captcha.", "", "error");
		return false;
	}
	if(document.contactform.ran.value != document.contactform.chk.value) {
	    document.contactform.chk.focus();
		sweetAlert("Please enter valid captcha.", "", "error");	
		return false;
	}
	return true;
}
</script>
<div class="innercnt">
	<div class="mtp">
		<?php 
		$captcha_num = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz@!#$%&*()<>{}[]";
		$rand = substr(str_shuffle($captcha_num), 0, 5); 
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
        <div class="frm_wrap">
		<?php if($msg==1){  ?>
		<div class="errmsg_cls">
		<h3>Thanks for writing to us. We will get back to you as soon as possible.</h3>	
		</div>
		<?php }  ?>
		<form name="contactform" id="contactform" action="" method="POST">
         <ul>
          <li>
           <label>Name:</label>
			<input name="cname" value="" id="cname" />
          </li>
          <li>
           <label>Email:</label>
			<input name="email" value="" id="email" />
          </li>
          <li>
           <label>Phone:</label>
			<input name="phone" value="" id="phone" />
          </li>
          <li class="full_li">
           <label>Message:</label>
			<textarea name="message" id="message"></textarea>
          </li>          
		  <li><input type="text" name="chk" id="chk">
			<span id="error" class="color"></span>
		  </li>
          <li>
          	<input type="text" value="<?=$rand?>" name="captch_ref" id="ran" readonly="readonly" class="captcha">
			<input type="button" class="ref-btn" value="Referesh" onclick="refresh()" />
          </li>
          <li class="btn_li"><input type="submit" class="btn_cn" name="submit" id="submit" value="Submit" onclick="return validateCaptcha();"/></li>
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