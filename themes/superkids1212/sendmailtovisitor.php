<?php
include($_SERVER['DOCUMENT_ROOT']."/wp-config.php");
session_start();
$email = isset($_SESSION['sess_visitors_email']) ? $_SESSION['sess_visitors_email'] : '';
if(isset($_SESSION['is_sent']) && $_SESSION['is_sent'] == 1){
	$_SESSION['is_sent'] = 0;
}else{
	$_SESSION['is_sent'] = 1;
}
$kids_name = $_REQUEST['kids_name'];
$gender = $_REQUEST['gender'];
if(isset($_SESSION['is_sent']) && $_SESSION['is_sent'] == 1 && $kids_name !='')
{
	$selectt = 'SELECT id FROM wp_site_visitors WHERE kids_name LIKE "'.$kids_name.'" AND email LIKE "'.$email.'"';
	$wpdb->get_results($selectt);
	$total = $wpdb->num_rows;
	if($total == 0){
	
		$sql = 'INSERT INTO wp_site_visitors (id, kids_name, gender, email) VALUES ("", "'.$kids_name.'", "'.$gender.'", "'.$email.'");';	
		$wpdb->get_results($sql);
		$lastid = $wpdb->insert_id;	
		/*--send email to visitors---*/
		$Host = get_option('smtp_hostname');
		$Username = get_option('smtp_username');
		$Password = get_option('smtp_password');
		$Host = 'mail.superkidsleague.com';
		$Username = 'auth@superkidsleague.com';
		$Password = 'Au#54!64iSDe9';
		if($Host != '' && $Username != '' && $Password != ''){
			require_once($_SERVER['DOCUMENT_ROOT']."/class.phpmailer.php");
			/* include($_SERVER['DOCUMENT_ROOT']."/sendgrid-php.php"); */
			/* $from = new SendGrid\Email("Little Einstein", "contact@superkidsleague.com"); */
			/* $apiKey = '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'; */
			/* $apiKey = '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'; */
			
			$subject  = "Let's Make #kidname# A Superkid";
			$message  = '<!DOCTYPE html>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
			<title>NewsLetter</title>
			</head>
			<style>
			@media screen and (max-width:599px){
			.logo{ max-width:100px !important;}
			.social img{ height:15px;}
			.blk{ text-align:center !important; display:block; width:100% !important;}
			.blk img{ float:right; position:static !important; display:inline-block; margin:20px -27px 0 0; max-width:100%; width:auto !important;}
			.a_btn{ font-size:20px !important; padding:12px 40px !important; }
			.blk h3{ font-size:18px !important;}
			.we{ font-size:20px !important;}
			.want{ font-size:20px !important; padding-bottom:20px !important;}
			.algn_cntr{ text-align:center !important;}
			}
			</style>
			<body>

			<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:Arial, Helvetica, sans-serif; background:#fff; max-width:600px;">
			 <tr>
			  <td>
			   <table style="background:#00b244; border-bottom:1px solid #33c169; vertical-align:middle; width:100%; padding:22px 27px;" border="0" cellpadding="0" cellspacing="0">
				<tr>
				 <td><a href="#"><img class="logo" style="max-width:100%;" src="http://superkidsleague.com/visitorstemplate/images/logo.png" alt=""/></a></td>					 
				</tr>
			   </table>
			  </td>
			 </tr>
			 <tr>
			  <td>
			   <table class="algn_cntr" style="background:#00b244;  vertical-align:middle; width:100%; padding:22px 27px;" border="0" cellpadding="0" cellspacing="0">
				<tr>
				 <td colspan="2">
				  <p style="font-size:16px; line-height:24px; color:#fff; margin:0 0 17px;">Dear Parent,</p>
				  <p style="font-size:16px; line-height:24px; color:#fff; margin:0 0 10px;">We have created a personalised book specially for your #kid_relation# #kidname#, which will give him meaning of his name and help you know the hidden talents of your kid, that will help him to become a Superkid.</p>
				 </td>
				</tr>
				<tr>
				 <td class="blk" style="position:relative;">
				  <h3 style="color:#fff; font-size:22px; margin:0 0 22px; line-height:normal;">Let\'s start the journey of <span style="color:#b9ff29;">#kidname#</span><br/>becoming <span style="color:#b9ff29;">a Superkid.</span></h3>
				  <a class="a_btn" style="border:1px solid #fff; margin:0 0 18px; border-radius:3px;padding:16px 57px; font-weight:bold; font-size:25px; text-align:center; color:#fff; text-decoration:none; display:inline-block;" href="#bookurl#">See Preview</a>				  
				 </td>
				 <td class="blk" style="text-align:right; position:relative; width:45%;"><img style="position: absolute;right: -27px;top: 34px; width:114%;" src="http://superkidsleague.com/visitorstemplate/images/bk.png" alt=""/></td>
				</tr>
			   </table>
			  </td>
			 </tr>
			 <tr>
			  <td>
			   <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
				<tr>
				 <td><img style="width:100%;" src="http://superkidsleague.com/visitorstemplate/images/bg.jpg" alt=""/></td>
				</tr>
			   </table>
			  </td>
			 </tr>
			 <tr>
			  <td>
			   <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
				<tr>
				 <td class="we" style="font-weight:bold; padding:2px 0 26px; color:#000; font-size:30px; text-align:center;">We are on a mission<br/>to deliver happiness in the world</td>
				</tr>
				<tr>
				 <td>
				  <img style="width:100%; float:left;" src="http://superkidsleague.com/visitorstemplate/images/bg2.jpg" alt=""/>
				 </td>
				</tr>
				<tr>
				 <td>
				  <table style="background:#00b244;width:100%; text-align:center;" border="0" cellpadding="0" cellspacing="0">
				   <tr>
					<td class="want" style="font-weight:bold; padding:0 0 32px; font-size:30px; color:#fff; line-height:normal;">Want to increase your child\'s<br/>intelligence by Einstein\'s method?</td>
				   </tr>
				   <tr>
					<td><a class="a_btn" style="border:1px solid #fff; margin:0 0 18px; border-radius:3px;padding:16px 95px; font-weight:bold; font-size:25px; text-align:center; color:#fff; text-decoration:none; display:inline-block;" href="#bookurl#">Buy now</a></td>
				   </tr>
				  </table>
				 </td>
				</tr>
				<tr>
					<td>
					 <img style="width:100%; float:left;" src="http://superkidsleague.com/visitorstemplate/images/br.png" alt=""/>
					</td>
				   </tr>
			   </table>
			  </td>
			 </tr>
			</table>
			</body>
			</html>';
			
			$kidname = stripslashes($kids_name);
			$gender = stripslashes($gender);
			
			$name = trim(strtolower($kidname));
			$babyname = ucfirst($name);
			$bookurl = site_url()."/product/superkids-league-book/?bu_name=$kidname&bu_gender=$gender";
			$email_body = $message;
			$email_subject = $subject;
			$email_body = str_replace("#kidname#", $kidname, $email_body);
			$email_body = str_replace("#bookurl#", $bookurl, $email_body);
			
			$email_body = str_replace("\'s", "'s", $email_body);
			$email_subject = str_replace("\'s", "'s", $email_subject);
			
			$email_subject = str_replace("#kidname#", $kidname, $email_subject);		
			$kid_relation = 'son';
			$his_him_her = 'son';
			if($gender == 'Boy' || $gender == 'boy'){
				$email_body = str_replace("#kid_relation#", $kid_relation, $email_body);
				$email_subject = str_replace("#kid_relation#", $kid_relation, $email_subject);					
			}else{
				$kid_relation = 'daughter';
				$email_body = str_replace("#kid_relation#", $kid_relation, $email_body);
				$email_subject = str_replace("#kid_relation#", $kid_relation, $email_subject);
				
				$email_body = str_replace("his","her", $email_body);
				$email_body = str_replace("him","her", $email_body);
				$email_subject = str_replace("his", "her", $email_subject);					
				$email_subject = str_replace("him", "her", $email_subject);					
			}
		
				$mail = new PHPMailer();	
				$mail->IsHTML(true);							
				$mail->IsSMTP(); 			
				$mail->Host = $Host;	
				$mail->Port     = 25;
				$mail->Username = $Username;	
				$mail->Password = $Password;
				$mail->SMTPAuth = true;		
				$mail->Debug = true;	
				$mail->From = 'contact@superkidsleague.com'; 	
				$mail->FromName = 'Little Einstein';		
				$mail->AddAddress($email);	
				$mail->Subject = $email_subject;		
				$mail->Body = $email_body;		
				$ok=$mail->Send();
				
				/* $to = new SendGrid\Email("", $email);
				$content = new SendGrid\Content("text/html", $email_body);
				$mail = new SendGrid\Mail($from, $email_subject, $to, $content);
				$sg = new \SendGrid($apiKey);
				$response = $sg->client->mail()->send()->post($mail);
				$statusCode = $response->statusCode();
				$response->headers();
				$response->body(); */
				/* if($statusCode == '202'){
					$wpdb->insert(
						'wp_sk_email_status',
						array(
							'id'			=> NULL,
							'visitor_id'	=> $lastid,
							'temp_id'	=> 1,
							'is_sent'	=> '1'
						)
					);
				} */
				
		}
	}
	/* unset($_SESSION['sess_visitors_email']); */
}