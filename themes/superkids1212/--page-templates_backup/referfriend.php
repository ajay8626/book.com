<?php
/**
* Template Name: Refer A Friend
*
*/
get_header(); 
require("class.phpmailer.php");
$msg = $_REQUEST['succ'];
if(isset($_REQUEST['fromemail'])){
	$fromname = $_REQUEST['fromname'];
	$fromemail = $_REQUEST['fromemail'];
	$toname = $_REQUEST['toname'];
	$toemail = $_REQUEST['toemail'];
	$subject  = 'Contect Details - Superkids';
	$message  = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>Mail</title></head>
	<body style="margin:0; padding:0;">
	<table style="margin:0 auto; width:570px;" cellspacing="0" cellpadding="0" border="0"><thead>
	<tr>
	<th style="text-align:center; background:#75c202; padding:22px 0 20px;"><img src="http://superkidsleague.com/wp-content/uploads/2017/05/logo.png" alt=""></th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:left;  padding:32px 30px 0; letter-spacing:1px;">'.get_the_permalink(8).'</td>
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
		$mail->From = $fromemail;
		$mail->FromName = $fromname;
		$mail->IsHTML(true);
		$loc_email = 'contact@superkidsleague.com';
		$mail->AddAddress($loc_email);
		$mail->Subject = $subject;
		$mail->Body = $message;
		$ok=$mail->Send();
		if($ok){
			wp_redirect(get_permalink().'?succ=1');
		}
	}
} ?>

<script>
jQuery(document).ready(function($){
	$('#referform').submit(function(){
	
		if($('#fromname').val() == ''){
			$('#fromname').focus();			
			sweetAlert("Please enter from name.", "", "error");
			return false;
		}
		if($('#fromemail').val() == ''){
			$('#fromemail').focus();			
			sweetAlert("Please enter from email.", "", "error");
			return false;
		}else if (!ValidateEmail($('#fromemail').val())) {
			$('#fromemail').focus();			
			sweetAlert("Please enter valid email.", "", "error");
			return false;
		}
		
		if($('#toname').val() == ''){
			$('#toname').focus();			
			sweetAlert("Please enter to name.", "", "error");
			return false;
		}
		if($('#toemail').val() == ''){
			$('#toemail').focus();			
			sweetAlert("Please enter to email.", "", "error");
			return false;
		}else if (!ValidateEmail($('#toemail').val())) {
			$('#toemail').focus();			
			sweetAlert("Please enter valid email.", "", "error");
			return false;
		}
		
		//swal("Done", "", "success");
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
        <div class="frm_wrap">
		<?php if($msg==1){  ?>
		<div class="errmsg_cls">
		<h3>Thank you for referring a friend. A link will be sent to your friend's email.</h3>	
		</div>
		<?php }  ?>
		<form name="referform" id="referform" action="" method="POST">
         <ul class="col_2">
          <li>
           <label>From Name:</label>
			<input name="fromname" value="" id="fromname" />
          </li>
          <li>
           <label>From Email:</label>
			<input name="fromemail" value="" id="fromemail" />
          </li>
          <li>
          <label>To Name:</label>
			<input name="toname" value="" id="toname" />
          </li>
          <li>
           <label>To Email:</label>
			<input name="toemail" value="" id="toemail" />
          </li>
          <li class="btn_li"><input type="submit" class="btn_cn" name="submit" id="submit" value="Submit" /></li>
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