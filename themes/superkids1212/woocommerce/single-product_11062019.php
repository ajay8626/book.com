<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' );

if(isset($_REQUEST['bu_name'])){
	$bu_name = $_REQUEST['bu_name'];
}elseif(get_query_var('bname') != ''){
	$bu_name = get_query_var('bname');
}else{
	$bu_name = '';
}
if(isset($_REQUEST['bu_gender'])){
	$bu_gender = $_REQUEST['bu_gender'];	
}elseif(get_query_var('bgender') != ''){
	$bgender = get_query_var('bgender');
	$bu_gender = 'Boy';
	if($bgender == 'G' || $bgender == 'g'){
		$bu_gender = 'Girl';
	}else if($bgender == 'B' || $bgender == 'b'){
		$bu_gender = 'Boy';
	}else{
		$bu_gender = '';
	}
}else{
	$bu_gender = '';
}
if(isset($_REQUEST['code'])){
	$bcode = $_REQUEST['code'];
}elseif(get_query_var('bcode') != ''){
	$bcode = get_query_var('bcode');
}else{
	$bcode = '';
}

if((!isset($bcode) || $bcode == '') && isset($_SESSION['sess_bcode'])){
    $bcode = $_SESSION['sess_bcode'];    
}
if(isset($_SESSION['sess_campaign'])){
	$campaign = $_SESSION['sess_campaign'];
}else{
	$campaign = '';
}

if($bu_gender == '' || $bu_name == ''){
  global $wp_query;
  $wp_query->set_404();
  status_header( 404 );
  get_template_part( 404 ); exit();
}

require("class.phpmailer.php");
error_reporting(0);
if( session_id() === '' ) {
	//session has not started
	session_start();
}
if(isset($_SESSION['sess_bookusername']) && $_SESSION['sess_bookusername'] != $bu_name){
	$_SESSION['sess_bookusername'] = $bu_name;
}

if(isset($_SESSION['sess_bookusergender']) && $_SESSION['sess_bookusergender'] != $bu_gender){
	$_SESSION['sess_bookusergender'] = $bu_gender;
}
$_SESSION['email_count'] = 1;
/* if (isset($_COOKIE['skcouponcode']) && isset($_SESSION['skcouponused']) && $_SESSION['skcouponused'] == 1) {
    // get data from cookie for local use
	$bcode = $_COOKIE['skcouponcode'];
}
else {
    // set cookie, local $uname already set
	ob_start();
    setcookie('skcouponcode', $bcode, time() + (86400 * 30));
	ob_end_flush();
}       */

/* if(isset($bcode) && $bcode != '' && (strpos($bcode, 'SK') !== false || strpos($bcode, 'NW') !== false || strpos($bcode, 'AP') !== false || strpos($bcode, 'MY') !== false)){ */
    
if(isset($bcode) && $bcode != '' && $bcode != 'PN30' && $bcode != 'pn30' ){
	global $wpdb;
    $_SESSION['sess_bcode'] = $bcode;
    $gender = $_REQUEST['bgender'];
    $kidsName = $_REQUEST['bname'];
	$dailySmsCron = $wpdb->prefix.'daily_sms_cron';
	$cronSchedule = $wpdb->get_results("SELECT * FROM `$dailySmsCron` WHERE `ucode` = '$bcode'");
	$visitpage = isset($cronSchedule[0]->total_visit)?$cronSchedule[0]->total_visit:"";
	$totalVisit = $visitpage + 1;
	$id = isset($cronSchedule[0]->id)?$cronSchedule[0]->id:"";
	if(count($cronSchedule) == 0){
		$checkPage = $cronSchedule[0]->visiting_page;
		if(($checkPage != 'checkout') && ($checkPage != 'product')){
			$cronSms = array('kids_name' => $kidsName, 'ucode' => $bcode, 'gender' => $gender,'visiting_page' => 'product');
    		$wpdb->insert( $dailySmsCron, $cronSms);
		}
	}else{
		$wpdb->update( $dailySmsCron, array( 'total_visit' => $totalVisit),array('id'=>$id));
	}





	/*$message = "Name : " . $bu_name. "<br> Unique Code : " . $bcode;
	$subject = $bu_name.' with code - '.$bcode.' has visited site';
	$Host = get_option('smtp_hostname');
	$Username = get_option('smtp_username');
	$Password = get_option('smtp_password');
	$siteVisitedPage = $wpdb->prefix.'site_visited_page';
	if($Host != '' && $Username != '' && $Password != ''){
		/* $emails = array('krishna@skids.in','keval@skids.in','jayendra@skids.in','nisha@skids.in'); */
		/* $emails = array('krishna@skids.in','jayendra@skids.in','keval@skids.in','nisha@skids.in'); */
		/* $emails = array('anjali@skids.in','keval@skids.in','nisha@skids.in','sachin@skids.in'); */
	/*	$emails = array('anjali@skids.in','keval@skids.in','nisha@skids.in','harsh@skids.in','sachin@skids.in','devanshu@skids.in','nilesh@skids.in','khushbu@skids.in');
		
		$last_email_sent = get_option('last_email_sent');
		
		if($last_email_sent == 0){
			$last_email_sent = 1;
		}else if($last_email_sent == 1){
			$last_email_sent = 2;
		}else if($last_email_sent == 2){
			$last_email_sent = 3;
		}else if($last_email_sent == 3){
			$last_email_sent = 4;
		}else if($last_email_sent == 4){
			$last_email_sent = 5;
		}else if($last_email_sent == 5){
			$last_email_sent = 6;
		}else if($last_email_sent == 6){
			$last_email_sent = 7;
		}else if($last_email_sent == 7){
			$last_email_sent = 0;
		}
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $Host;
		$mail->Username = $Username;
		$mail->Password = $Password;
		$mail->SMTPAuth = true;
		$mail->Debug = true;
		$mail->From = 'asingh@skids.in';
		$mail->FromName = "Skids";
		$mail->IsHTML(true);
		$loc_email = $emails[$last_email_sent];
		$mail->AddAddress($loc_email);
        /* $mail->AddCC('asingh@skids.in'); */
	/*	$mail->Subject = $subject;
		$mail->Body = $message;
		$ok=$mail->Send();
		if(get_option('last_email_sent', 'default') == 'default'){
			add_option('last_email_sent');
		}				
		$data = array('unique_code' => $bcode, 'visited_page' => 'product','employee_email' => $emails[$last_email_sent]);
	    $wpdb->insert( $siteVisitedPage, $data); 
		update_option('last_email_sent', $last_email_sent);
	}*/
}

if($bcode == 'PN30' || $bcode == 'pn30'){
	global $woocommerce;
	if(empty( $woocommerce->cart->applied_coupons )){
		$woocommerce->cart->add_discount('PN30');
		$_SESSION['aplcoupan'] = 1;
	}
}else{
	global $woocommerce;
	if(in_array('pn30',$woocommerce->cart->applied_coupons )){
		$woocommerce->cart->remove_coupon( 'pn30' );
		if( isset($_SESSION['aplcoupan']) && $_SESSION['aplcoupan'] == 1 ) {
			unset($_SESSION['aplcoupan']);
		}
	}
}


// shortcode for similiar meaning starts here

function similiar_words($Whole_word,$gender){
global $wpdb,$err;

$static_word1=str_split(strtoupper($Whole_word));
$data_library=array();
$meaning=array();
$used=array();
$checked=array();

$page_orderleftpriority=array();
$page_ids=array();
$page_orderrightpriority=array();
$static_word=array_unique($static_word1);

// word library
foreach($static_word as $static){
	$query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$static."%' and gender='".$gender."' order by priority";
	$words = $wpdb->get_results( $query );
	
	foreach($words as $word){
		if($word->page_order == 'L'){
			$data_library[$static][]=$word->virtue;

		}
	} 
}

// smiliar words library
$ignore_query = "SELECT * FROM `wp_words_ignore` ";
$ignore_words = $wpdb->get_results( $ignore_query );
	foreach($ignore_words  as $ignore_word){
		$str =$ignore_word->similiar_words;
		$str_splode = explode(',',$str);
		$combos[] = showCombo(array(), $str_splode);

	}	
if(!empty($combos)){
	foreach($combos as $key=>$array){
		$all_list=displayArrayByKey($key, $array);
		foreach($all_list as $k=>$a){
			$similiar[$k]=$a;
		}
	} 
}
//logic for the combination 
foreach($static_word1 as $static){
	if($data_library[$static][0] !=''){
	$wr=$data_library[$static][0];
	if(count($used) ==0){
		$meaning[]=$static.'-'.$wr;
		$used[]=$wr;
	}
	else{
		foreach($used as $use){
			if(isset($similiar[$use])){
				if(in_array($wr,$similiar[$use]) && !in_array($wr,$checked)){
					$name = $data_library[$static][0];
					array_push($checked,$name);
					array_push($data_library[$static],$name);
					array_shift($data_library[$static]);
				}
			}
		}
		$meaning[]=$static.'-'.$data_library[$static][0];
		$used[]=$data_library[$static][0];
	}
	
	$name = $data_library[$static][0];
	array_push($data_library[$static],$name);
	array_shift($data_library[$static]);
	}
	
}
	foreach($meaning as $mean){
		$single_word=explode('-',$mean);
		$single_query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$single_word[1]."' and gender='".$gender."' order by priority";
		$singlewords = $wpdb->get_results( $single_query );
		foreach($singlewords as $singleword){
			$other_data[]=$singleword->id;
		}
		
	}
 $all_data_array=array('initial'=>$meaning,'other_data'=>$other_data);

	return $all_data_array;
}
// for combination
function showCombo($str_arr, $arr){
    $ret = array();
    foreach($arr as $val){
       if(!in_array($val, $str_arr)){
           $temp = $str_arr;
           $temp[] = $val;
           $ret[$val] = showCombo($temp, $arr);
       }
    }
    return $ret;
}
function displayArrayByKey($str, $arr){
    foreach($arr as $key=>$array){
		if(!empty($array)){
			$list[$key]=array_keys($array);
		}
        if(count($array)> 0){
            displayArrayByKey($string, $array);
        }
    }
	return $list;

}
// similiar all function ends here
function createPrologueImage($name='',$img1=''){
	$x=1500;
	$y=1000;
	$name = trim(strtolower($name));
	$babyname = ucfirst($name);
	//header('Content-Type: image/jpg');
	//header("Content-type: text/html");
	$targetFolder = '/createimage/frontimage/';
	$targetFolder1 = '/createimage/frontimage/';
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$masterimagesPath = $_SERVER['DOCUMENT_ROOT'] . '/createimage/masterimages/';
	$img1 = $masterimagesPath.'PROLOGUE1500.jpg';

	$outputImage = imagecreatetruecolor(1500, 1000);

	// set background to white
	$blk = imagecolorallocate($outputImage, 0, 0, 0);
	
	imagefill($outputImage, 0, 0, $blk);

	$first = imagecreatefromjpeg($img1);

	//imagecopyresized ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresized($outputImage,$first,0,0,0,0, $x, $y,$x,$y);

	// Add the text
	//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
	$text = $babyname.',';
	
	$P22Wedge = $masterimagesPath.'P22Wedge.ttf';
	$KelmscottRegular = $masterimagesPath.'KelmscottRegular.ttf';
	
	imagettftext($outputImage, 22, 0, 731, 208, $blk, $P22Wedge, $text);
	imagettftext($outputImage, 22, 0, 731, 210, $blk, $P22Wedge, $text);
	imagettftext($outputImage, 22, 0, 732, 209, $blk, $P22Wedge, $text);
	
	$random = mt_rand(100000,999999);
	$filename = $name.$random.'_prologue.jpg';
	$fullfilepath = $targetPath.$filename;
	$fullfileurl = site_url().$targetFolder1.$filename;
	$ok = imagejpeg($outputImage, $fullfilepath);
	imagedestroy($outputImage);
	/* $tn = imagecreatetruecolor(950, 633) ;
	$image = imagecreatefromjpeg($fullfilepath) ;
	imagecopyresampled($tn, $image, 0, 0, 0, 0, 950, 633, 1500, 1000) ;

	imagejpeg($tn, $fullfilepath) ;
	
	imagedestroy($tn); */
	
	if($ok)
		return $fullfileurl;
	else
		return false;
}


function createCertiImage($name='',$gender='',$name_arr=array()){
	$x=1500;
	$y=1000;
	$name = trim(strtolower($name));
	$babyname = strtoupper($name);
	
	$targetFolder = '/createimage/certimage/';
	$targetFolder1 = '/createimage/certimage/';
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$masterimagesPath = $_SERVER['DOCUMENT_ROOT'] . '/createimage/masterimages/';
	
	$random = mt_rand(100000,999999);
	if($gender == 0){
		$filename = $name.$random.'_enging_boy.jpg';
		$img1 = $masterimagesPath.'ENDING_boy.jpg';
	}else{
		$filename = $name.$random.'_enging_girl.jpg';
		$img1 = $masterimagesPath.'ENDING_girl.jpg';
	}

	$outputImage = imagecreatetruecolor(1500, 1000);

	// set background to white
	$blk = imagecolorallocate($outputImage, 0, 0, 0);
	$wht = imagecolorallocate($outputImage, 255, 255, 255);
	
	imagefill($outputImage, 0, 0, $blk);

	$first = imagecreatefromjpeg($img1);

	//imagecopyresized ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresized($outputImage,$first,0,0,0,0, $x, $y,$x,$y);

	// Add the text
	//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
	
	$topname = $babyname;
	$KelmscottRegular = $masterimagesPath.'KelmscottRegular.ttf';
	$TrajanBold = $masterimagesPath.'TrajanBold.ttf';
	
	$start = 900;
	$end = 1395;
	$gap = 495;
	$charspace = 1128;
	
	
	$countChar = strlen($name);
	if($countChar <=1 ){
		$charspace = 1128;
	}else{
		$charspace = (910 + ($gap/2)) - (15 * $countChar);
	}
	$smallArr = array('I','J','t');
	$medArr = array('A','S','E','F','L','i');
	$largeArr = array('M','W','H');	
	$textCoords=imagettfbbox(26 , 0 , $TrajanBold , strtoupper($name));
	$titlenamex=  1145-(($textCoords[4]-$textCoords[0]))/2 ;
	imagettftext($outputImage, 26, 0, $titlenamex, 440, $wht, $TrajanBold, strtoupper($name));
	$startingpoint = 1040;
	$lineheight = 0;
	$spacing = 40;
	$fontsize = 20;
	if($countChar == 12 || $countChar == 11){
		$lineheight = 475;
		$spacing = 38;
	}else if($countChar <= 10 && $countChar >= 8){
		$lineheight = 475;
		$spacing = 46;
		$startingpoint = 1020;
	}else if($countChar <= 7){
		$lineheight = 520;
		$spacing = 50;
		$startingpoint = 1000;
		$fontsize = 22;
	}
	foreach($name_arr as $res){
		$lineheight += $spacing;
		$name = $res[0].' - '.ucfirst(strtolower($res[1]));
		imagettftext($outputImage, $fontsize, 0, $startingpoint, $lineheight, $blk, $KelmscottRegular, $name);	
	}
	$fullfilepath = $targetPath.$filename;
	$fullfileurl = site_url().$targetFolder1.$filename;
	
	$ok = imagejpeg($outputImage, $fullfilepath);
	imagedestroy($outputImage);	
	
	if($ok)
		return $fullfileurl;
	else
		return false;
}



function createCertificate($name='',$gender=0,$name_arr=array()){
	$x=1500;
	$y=1000;
	$name = trim(strtolower($name));
	$babyname = strtoupper($name);
	
	$targetFolder = '/createimage/certimage/';
	$targetFolder1 = '/createimage/certimage/';
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$masterimagesPath = $_SERVER['DOCUMENT_ROOT'] . '/createimage/masterimages/';
	
	$random = mt_rand(100000,999999);
	if($gender == 0){
		$filename = $name.$random.'_boy_certificate.jpg';
		$img1 = $masterimagesPath.'boycerti1500.jpg';
	}else{
		$filename = $name.$random.'_girl_certificate.jpg';
		$img1 = $masterimagesPath.'girlcerti1500.jpg';
	}
	
	$outputImage = imagecreatetruecolor(1500, 1000);


	$blk = imagecolorallocate($outputImage, 0, 0, 0);
	$wht = imagecolorallocate($outputImage, 255, 255, 255);
	$titleColor = imagecolorallocate($outputImage, 86,42,17);
	$meaningColor = imagecolorallocate($outputImage, 148,97,6);
	
	imagefill($outputImage, 0, 0, $blk);

	$first = imagecreatefromjpeg($img1);	
	imagecopyresized($outputImage,$first,0,0,0,0, $x, $y,$x,$y);
	
	$topname = $babyname;
	
	$KELMSCOT = $masterimagesPath.'KELMSCOT.TTF';
	
	$start = 500;
	$end = 1000;
	$gap = 500;
	$charspace = 750;
	
	
	$countChar = strlen($name);
	if($countChar <=1 ){
		$charspace = 750;
	}else{
		$charspace = (510 + ($gap/2)) - (15 * $countChar);
	}
	$smallsmArr = array('i','j','l');
	$smallArr = array('I','J');
	$medArr = array('A','S','E','F','L');
	$medsmArr = array('a','s','e','f','h','o','y');
	$largeArr = array('G','M','W','H','m');	
	$i = 1;
	$smallname_arr = str_split($name, 1);
	$textCoords=imagettfbbox(32 , 0 , $KELMSCOT ,  ucwords($name) );
	$titlenamex=  750-(($textCoords[4]-$textCoords[0]))/2 ;

	imagettftext($outputImage, 32, 0,$titlenamex, 240, $titleColor, $KELMSCOT, ucwords($name));
	
	$startingpoint = 600;
	$lineheight = 0;
	$spacing = 40;
	$fontsize = 20;
	if($countChar == 12 || $countChar == 11){
		$lineheight = 360;
		$spacing = 28;
		$fontsize = 16;
	}else if($countChar <= 10 && $countChar >= 8){
		$lineheight = 360;
		$fontsize = 18;
		$spacing = 34;
		$startingpoint = 600;
	}else if($countChar <= 7 && $countChar >= 5){
		$lineheight = 370;
		$spacing = 46;
		$startingpoint = 600;
		$fontsize = 20;
	}else if($countChar <= 4){
		$lineheight = 390;
		$spacing = 50;
		$startingpoint = 600;
		$fontsize = 22;
	}
	$lineheight1 = $lineheight;
	foreach($name_arr as $res){
		$lineheight += $spacing;
		$lineheight1 += $spacing-1;
		$char = ucfirst(strtolower($res[0]));
		$name = ucfirst(strtolower($res[1]));
		imagettftext($outputImage, $fontsize, 0, $startingpoint, $lineheight, $titleColor, $KELMSCOT, $char);
		imagettftext($outputImage, 16, 0, 635, $lineheight1, $titleColor, $KELMSCOT, '-');	
		imagettftext($outputImage, $fontsize, 0, 665, $lineheight, $meaningColor, $KELMSCOT, $name);	
	}
	
	$fullfilepath = $targetPath.$filename;
	$fullfileurl = site_url().$targetFolder1.$filename;
	$ok = imagejpeg($outputImage, $fullfilepath);
	imagedestroy($outputImage);	
	
	if($ok)
		return $fullfileurl;
	else
		return false;
}

?>
<?php 
	//session_start();
//$_SESSION['msg'] = '';
if(isset($_POST['nt_name']) && isset($_POST['nt_email'])){
	$name = isset($_POST['nt_name'])?$_POST['nt_name']:'';
	$email = isset($_POST['nt_email'])?$_POST['nt_email']:'';
	if($name != '' && $email != ''){
		
		$message .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>Mail</title></head>
		<body style="margin:0; padding:0;">
		<table style="margin:0 auto; width:570px;" cellspacing="0" cellpadding="0" border="0"><thead>
		<tr>
		<th style="text-align:center; background:#75c202; padding:22px 0 20px;"><img src="'.get_template_directory_uri().'/images/logo.png" alt=""></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Hello Admin, Please check below enquiry for name which not found in system.</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Name : '.$name.'</td>
		</tr>
		<tr>
			<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Email : '.$email.'</td>
		</tr>
		</tbody></table>
		</body></html>';
		
		$subject = 'Notify for book!';
		$loc_email = 'orders@superkidsleague.com';
		$headers = "From: SUPER KIDS LEAGUE.COM <".$email."> \r\n" . 
				"Content-type: text/html; charset=UTF-8 \r\n"; 
		$ok = wp_mail($loc_email, $subject, $message, $headers);
		if($ok){
          wp_redirect(get_permalink().'?succ=1');  
        }
	}
}	
?>
<script>
jQuery(document).ready(function($){
	
	$('.a_cls').click(function() {
			$(".popupparent").fadeOut();
	});
	
	
	
	$('.flip_form li label input:radio').click(function() {
			$('.flip_form li label input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
			$(this).parent().addClass('active');
	});

	$(".a_edit").click(function(){
		$(".flip_form .frst_frm").slideDown();
		$(".flip_form .dedication-input").slideUp();
	});
	
	
	$('.single_add_to_cart_button, .single_continue').click(function(){
	
		if($('.fname').val() == ''){
			$('.fname').focus();			
			sweetAlert("Please enter name.", "", "error");
			return false;
		}
		//$("#productbookform").submit();
		return true;
	});	
	
	$('#Continue').click(function(){
		if($('#bu_name').val() == ''){
			$('#bu_name').focus();			
			sweetAlert("Please enter name.", "", "error");
			return false;
		}
		$("#productbookform").submit();
		return true;
	});	
	
	$('#tryfiffcontinue').click(function(){
		if($('#bu_name').val() == ''){
			$('#bu_name').focus();			
			sweetAlert("Please enter name.", "", "error");
			return false;
		}
		$("#trydiffname").submit();
		return true;
	});	
	
	$('#notifyproductsubmit').click(function(){
		if($('#nt_name').val() == ''){
			$('#nt_name').focus();			
			sweetAlert("Please enter name.", "", "error");
			return false;
		}
		if($('#nt_email').val() == ''){
			$('#nt_email').focus();			
			sweetAlert("Please enter email.", "", "error");
			return false;
		}else if (!ValidateEmail($('#nt_email').val())) {
			$('#nt_email').focus();			
			sweetAlert("Please enter valid email.", "", "error");
			return false;
		}
		$("#notifyproduct").submit();
		return true;
	});	
	
	
	
	$("#bu_name, .fname, #author").on("keypress", function(e) {
		if (e.which === 32 && !this.value.length)
			e.preventDefault();
	});
	
	$('.fname').keydown(function (e) {
		var key = e.keyCode;
		if (!((key == 8) || (key == 32) || (key == 13) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		  e.preventDefault();
		}
		  
		var key = e.keyCode;
		var len = $('.fname').val().length;
		if(len == 12){
			if (key >= 65 && key <= 90){
				sweetAlert("Sorry! The name should be less than or equals to 12 characters.","","");
				e.preventDefault();
			}
		}
      });
	  
	  
	  $('#bu_name').keydown(function (e) {
		var key = e.keyCode;
		if (!((key == 8) || (key == 32) || (key == 13) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		  e.preventDefault();
		}
		  
		var key = e.keyCode;
		var len = $('#bu_name').val().length;
		if(len == 12){
			if (key >= 65 && key <= 90){
				sweetAlert("Sorry! The name should be less than or equals to 12 characters.","","");
				e.preventDefault();
			}
		}
      });
	  
		$('#trydiff_open').click(function(){
			$('.open_diffname').slideToggle();
		});
		$('.mob_preview_div a').click(function(){
		   $('.mob_preview_div').remove();
		  });
});
 /* $(window).load(function(){
		$('.sk-spinner_wrap').fadeOut();
		
	}); */
</script>
<div class="innercnt">
	<div class="mtp">
		<?php if($bu_name != '' && $bu_gender != ''){  ?>
				<div class="flip_wrap">
					
					<div class="sk-spinner_wrap">
						<div class="sk-spinner sk-spinner-wave">
							<div class="sk-rect1"></div>
							  <div class="sk-rect2"></div>
							  <div class="sk-rect3"></div>
							  <div class="sk-rect4"></div>
							  <div class="sk-rect5"></div>
							<h1>Please wait, we are creating wonderful book for <?php echo $bu_name != '' ?$bu_name:'you' ?>.</h1>
						</div>
					</div>
					<div class="flipbook-bg">
					    <div class="mob_preview_div">
				    	<span class="hgt"></span><div><a href="javascript:void(0)">Click here<br/>for preview<br/><b><?php echo ucfirst(strtolower(trim($bu_name))); ?>'s</b><br/>book</a></div>
				    </div>
							<?php /*
							<div class="sk-spinner_wrap">
							<?php if($_REQUEST['bu_gender'] == 'Girl'){ ?>
								<img src="<?php echo get_template_directory_uri(); ?>/images/girl_front.jpg"/>
							<?php }else if($_REQUEST['bu_gender'] == 'Boy'){ ?>
								<img src="<?php echo get_template_directory_uri(); ?>/images/boy_frnt.jpg"/>
							<?php } ?>							
							</div>*/ ?>
						<?php
							$result = array();
							$characterset = array();
							if($bu_name != ''){
								$err = 0;
								if(strlen($bu_name) <= 12){
								
									$bu_gender = $bu_gender != ''?$bu_gender:'Boy';
									$gender = 0;
									if($bu_gender == 'Girl' || $bu_gender == 'girl'){
										$gender = 1;
									}
									global $wpdb;
									$bu_name_str = $bu_name;
									$bu_name_arr = str_split(strtoupper($bu_name_str));
									$bu_name1 = implode("','",$bu_name_arr);
									
									
									$sql = "SELECT * FROM `wp_book_virtue` WHERE alphabet IN ('$bu_name1') AND gender = '$gender' ORDER BY priority, FIELD(alphabet, '$bu_name1')";
									$result = $wpdb->get_results($sql);
									
									if(!empty($result)){
										foreach($result as $res){
											$characterset[$res->alphabet][$res->priority.$res->page_order] = $res->id;
										}
									}
									$resultval = array();
									$resultvalR = array();
									$result = array();
									$priority = array();
									foreach($bu_name_arr as $bun){
										if(isset($characterset[$bun])){
											if(!isset($priority[$bun])){
												$occ = 1;
												
											}else{
												$occ = $priority[$bun] + 1;
												$total = count($characterset[$bun])/2;
												if($occ > $total){
													$occ = 1;
													$err = 1;
												}
												
											}
											$priority[$bun] = $occ;
											
											$resultval = $characterset[$bun][$occ.'L'];
											$resultvalR = $characterset[$bun][$occ.'R'];
											$result[] = $resultval;
											$result[] = $resultvalR;
										}else{
											$err = 2;
										}
									}
									
									if(empty($resultval)){
										$err = 3;
									}
								}else{
									$err = 4;
								}
							}
							
							//$gender_new = $_REQUEST['bu_name'];
							if (ctype_alpha(str_replace('', '', $bu_name)) === false)
							{
							$err = 5;
							}
							
							$data_result=similiar_words($bu_name_str,$gender);
							$result=$data_result['other_data']; 
							$prname = $bu_name != ''?trim(strtolower($bu_name)):'';
							
							if($bu_name == 'DARSHITA' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'secondname'){
								$result = array(0 => 79, 1 => 80, 2 => 173, 3 => 174, 4 => 118, 5 => 119, 6 => 122, 7 => 123, 8 => 93, 9 => 94, 10 => 97, 11 => 98, 12 => 128, 13 => 129, 14 => 161, 15 => 162);
							}
						?>
						<div id="flipbookproduct">
							<?php 
							$certi_arr = array();
							if(!empty($result) && $err == 0){
								foreach($result as $res1){
									$sql = "SELECT image,alphabet,virtue,page_order,gender,priority FROM `wp_book_virtue` WHERE id = $res1";
									$resVirtue = $wpdb->get_results($sql);
									foreach($resVirtue as $virtue){
										if($virtue->page_order == 'L'){
											$certi_arr[] = array($virtue->alphabet,$virtue->virtue);
											$meaning_arr[] = array($virtue->alphabet,$virtue->virtue,$virtue->gender,$virtue->priority);
										}
									}
								}
							}
							$_SESSION['kidsArr'] = $certi_arr;
							$_SESSION['meaning_arr'] = $meaning_arr;
							if($gender == 0){
								$frontimage	= get_option('frontimage')?get_option('frontimage'):"";
								$endingimage1	= get_option('boys_back1')?get_option('boys_back1'):"";
								if(!empty($certi_arr)){
									$endingimage2 = createCertiImage($prname,0,$certi_arr);
									$certificate = createCertificate($prname,0,$certi_arr);
								}
							}else if($gender == 1){
								$frontimage	= get_option('girl_frontimage')?get_option('girl_frontimage'):"";
								$endingimage1	= get_option('girls_back1')?get_option('girls_back1'):"";
								if(!empty($certi_arr)){
									$endingimage2 = createCertiImage($prname,1,$certi_arr);
									$certificate = createCertificate($prname,1,$certi_arr);
								}
							}
							
							?>
							<?php if($frontimage != ''){ ?>
								<div class="slide">
									<img src="<?php echo $frontimage; ?>" alt="" /> 		 
								</div>
							<?php } ?>
							<?php if($certificate){ ?>
								<div class="slide">
									<img src="<?php echo $certificate; ?>" alt="" />									   
								</div>								
							<?php } ?>
							<div class="slide">
								<img src="<?php echo site_url(); ?>/createimage/masterimages/Spacial-Msg1.jpg" alt="" />
							</div>
							<?php if(!empty($result) && $err == 0){ 
								$prname = $bu_name != ''?trim(strtolower($bu_name)):'';
									$prologue = createPrologueImage($prname);
								if($prologue){ ?>
									<div class="slide">
										<img src="<?php echo $prologue; ?>" alt="" />
									</div>
								<?php } ?>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/welcome.jpg"/>
								</div>
								<?php if($gender == 0){ ?>
									<div class="slide">
										<img src="<?php echo get_template_directory_uri(); ?>/images/boy-openingscene.jpg"/>
									</div>
									<div class="slide">
										<img src="<?php echo get_template_directory_uri(); ?>/images/boy-opening-scene-02.jpg"/>
									</div>
								<?php }else if($gender == 1){ ?>
									<div class="slide">
										<img src="<?php echo get_template_directory_uri(); ?>/images/girl-openingscene.jpg"/>
									</div>
									<div class="slide">
										<img src="<?php echo get_template_directory_uri(); ?>/images/girl-opening-scene-02.jpg"/>
									</div>
								<?php } ?>
								
									<?php if(strlen($bu_name) == 3){ ?>
											<?php if($gender == 0){ ?>
												<?php foreach($result as $key=>$res){ ?>
													<?php if($key == 2){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfary01.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfary02.jpg" /> 
														</div>
													<?php }else if($key == 4){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfrog01.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfrog02.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerpuppet01.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerpuppet02.jpg" /> 
														</div>
													<?php } ?>
													<?php 
													$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
													$resVirtue = $wpdb->get_results($sql);
													foreach($resVirtue as $virtue){ ?>
														<div class="slide">
															<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
														</div>
													<?php } ?>
												<?php } ?>
											<?php }else if($gender == 1){ ?>
												<?php foreach($result as $key=>$res){ ?>
													<?php if($key == 2){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfary01.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfary02.jpg" /> 
														</div>
													<?php }else if($key == 4){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfrog01.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfrog02.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerpuppet01.jpg" /> 
														</div>													
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerpuppet02.jpg" /> 
														</div>
													<?php } ?>
													<?php 
													$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
													$resVirtue = $wpdb->get_results($sql);
													foreach($resVirtue as $virtue){ ?>
														<div class="slide">
															<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
														</div>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										
									<?php }else if(strlen($bu_name) == 4){ ?>
										<?php if($gender == 0){ ?>
												<?php foreach($result as $key=>$res){ ?>
													<?php if($key == 2){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfary01.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfary02.jpg" /> 
														</div>
													<?php }else if($key == 4){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfrog01.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfrog02.jpg" /> 
														</div>													
													<?php } ?>
													<?php 
													$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
													$resVirtue = $wpdb->get_results($sql);
													foreach($resVirtue as $virtue){ ?>
														<div class="slide">
															<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
														</div>
													<?php } ?>
												<?php } ?>
											<?php }else if($gender == 1){ ?>
												<?php foreach($result as $key=>$res){ ?>
													<?php if($key == 2){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfary01.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfary02.jpg" /> 
														</div>
													<?php }else if($key == 4){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfrog01.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfrog02.jpg" /> 
														</div>													
													<?php } ?>
													<?php 
													$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
													$resVirtue = $wpdb->get_results($sql);
													foreach($resVirtue as $virtue){ ?>
														<div class="slide">
															<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
														</div>
													<?php } ?>
												<?php } ?>
											<?php } ?>

									<?php }else if(strlen($bu_name) == 5){ ?>
										<?php if($gender == 0){ ?>
												<?php foreach($result as $key=>$res){ ?>
													<?php if($key == 4){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfary01.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/boyfillerfary02.jpg" /> 
														</div>													
													<?php } ?>
													<?php 
													$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
													$resVirtue = $wpdb->get_results($sql);
													foreach($resVirtue as $virtue){ ?>
														<div class="slide">
															<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
														</div>
													<?php } ?>
												<?php } ?>
											<?php }else if($gender == 1){ ?>
												<?php foreach($result as $key=>$res){ ?>
													<?php if($key == 4){ ?>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfary01.jpg" /> 
														</div>
														<div class="slide">
															<img src="<?php echo get_template_directory_uri(); ?>/images/filler/girlfillerfary02.jpg" /> 
														</div>													
													<?php } ?>
													<?php 
													$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
													$resVirtue = $wpdb->get_results($sql);
													foreach($resVirtue as $virtue){ ?>
														<div class="slide">
															<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
														</div>
													<?php } ?>
												<?php } ?>
											<?php } ?>
									<?php }else{ ?>
										<?php foreach($result as $res){ ?>
											<?php 
												$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
												$resVirtue = $wpdb->get_results($sql);
												foreach($resVirtue as $virtue){ ?>
													<div class="slide">
														<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
													</div>
												<?php } ?>
										<?php } ?>
									<?php } ?>	
								
								<?php if($endingimage1 != ''){ ?>
									<div class="slide">
										<img src="<?php echo $endingimage1; ?>" alt="" /> 		 
									</div>
								<?php } ?>
								<?php 								
								if($endingimage2){ ?>
									<div class="slide">
										<img src="<?php echo $endingimage2; ?>" alt="" />
									</div>
								<?php } ?>
							<?php } ?>
							<?php
								if($gender == 0){ ?>
									<div class="slide">
										<img src="<?php echo get_template_directory_uri(); ?>/images/newfinal_boy.jpg"/>
									</div>
								<?php	}else{ ?>
									<div class="slide">
										<img src="<?php echo get_template_directory_uri(); ?>/images/newFinal_girl.jpg"/>
									</div>
							<?php	} ?>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0000_g1.jpg"/>
								</div>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0001_g2.jpg"/>
								</div>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0002_g3.jpg"/>
								</div>
								<?php /* <div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0003_g4.jpg"/>
								</div> */ ?>
								<div class="slide">
									<?php if($bu_gender == 'Girl' || $bu_gender == 'girl'){ ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/girl-COVER-BACK.jpg"/>
									<?php }else if($bu_gender == 'Boy' || $bu_gender == 'boy'){ ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/boy-COVER-BACK.jpg"/>
									<?php } ?>
								</div>
							<?php /* if($backimage != ''){ ?>
								<div class="slide">
									<img src="<?php echo $backimage; ?>" alt="" /> 		 
								</div>
							<?php }  */ ?>
						</div>
					</div>
				   
				   
				 
						<?php if(isset($_REQUEST['succ']) && $_REQUEST['succ'] == 1){ ?>
							<div class="popupparent"><span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a><div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;"><p>Thank you for enquiry. We will get back to you as soon as possible.</p></div></div></div>
						<?php }else{ ?>
							<?php if($err != 0 && $err != 4 && $err != 5){ ?>
								<?php
								
								/*** Code for Mismatch Name's Email to admin and entry to database start here  ***/
							
									$kids_name=trim($bu_name);
									$gender=trim($bu_gender);
																
									if($kids_name !='' && ($gender =='Boy' || $gender =='Girl'))
									{
										$selectt = "SELECT * FROM wp_mismatch_names WHERE kids_name = '" .$kids_name."' && gender = '" .$gender."'";
										$wpdb->get_results($selectt);
										$total = $wpdb->num_rows;
										if($total <= 0)
										{
											$sql1 = "INSERT INTO `wp_mismatch_names` (`id`, `kids_name`, `gender`) VALUES ('', '$kids_name', '$gender');";
											$wpdb->get_results($sql1);
											if($wpdb)
											{								
												$message .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>Mail</title></head>
												<body style="margin:0; padding:0;">
												<table style="margin:0 auto; width:570px;" cellspacing="0" cellpadding="0" border="0"><thead>
												<tr>
												<th style="text-align:center; background:#75c202; padding:22px 0 20px;"><img src="'.get_template_directory_uri().'/images/logo.png" alt=""></th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Hello Admin, Please check below enquiry for name which not found in system.</td>
												</tr>
												<tr>
													<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Name : '.$kids_name.'</td>
												</tr>
												<tr>
													<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0; letter-spacing:1px;">Gender : '.$gender.'</td>
												</tr>
												</tbody></table>
												</body></html>';
											
												$subject = 'No book available for this name';
												$from = get_option('admin_email');											
													$loc_email = "orders@superkidsleague.com";
												$headers = "From: SUPER KIDS LEAGUE.COM <".$from."> \r\n" . 
														"Content-type: text/html; charset=UTF-8 \r\n"; 
												$ok = wp_mail($loc_email, $subject, $message, $headers);
											}
										}
									}
									/*** Code for Mismatch Name's Email to admin and entry to database ends here  ***/
								
								?>
								<div class="popupparent">
									<span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a>
										<div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;"><p>We are sorry! We do not have book which is matching with your name.</p>
										<p>Please try different name without surname.</p>
										</div>
										<form style="width:100%" id="trydiffname" name="trydiffname" action="<?php echo get_permalink(); ?>" method="get">
											<ul class="frst_frm">
												<li>
													<b>Name</b><input class="txt_flip" id="bu_name" name="bu_name" value="" maxlength="13" type="text">
												</li>
												<li>
													<b>Gender</b>
													<label class="active"><input class="rd_flip" name="bu_gender" value="Boy" checked="checked" type="radio"> Boy</label>
													<label class="girl_lb"><input class="rd_flip" name="bu_gender" value="Girl" type="radio"> Girl</label>
												</li>
												<li>
													<a href="javascript:void(0)" class="a_cnt" id="tryfiffcontinue">Try Again</a>
												</li>
											</ul>
										</form>
										<span style="width:100%;border:2px dashed #015bbc"></span>
										<div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;">
										<p>Please submit your enquiry below, we will get back to you as soon as possible.</p>
										</div>
										<form id="notifyproduct" name="notifyproduct" action="" method="post">
											<ul class="frst_frm">
												<li>
													<b>Name</b><input type="text" class="txt_flip" id="nt_name" name="nt_name" value=""  maxlength="12"/>
												</li>
												<li>
													<b>Email</b><input type="email" class="txt_flip" id="nt_email" name="nt_email" value=""  maxlength="100"/>
												</li>
												<li>
													<a href="javascript:void(0)" class="a_cnt" id="notifyproductsubmit">Notify Me</a>
												</li>
											</ul>
										</form>
									</div>
								</div>
							<?php } ?>
							
							<?php if($err == 4){ ?>
								<div class="popupparent">
									<span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a>
										<div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;"><p>Sorry! The name should be less than or equals to 12 characters.</p>
										<p>Please try different name without surname.</p>
										</div>
										<form style="width:100%" id="trydiffname" name="trydiffname" action="<?php echo get_permalink(); ?>" method="get">
											<ul class="frst_frm">
												<li>
													<b>Name</b><input class="txt_flip" id="bu_name" name="bu_name" value="" maxlength="13" type="text">
												</li>
												<li>
													<b>Gender</b>
													<label class="active"><input class="rd_flip" name="bu_gender" value="Boy" checked="checked" type="radio"> Boy</label>
													<label class="girl_lb"><input class="rd_flip" name="bu_gender" value="Girl" type="radio"> Girl</label>
												</li>
												<li>
													<a href="javascript:void(0)" class="a_cnt" id="tryfiffcontinue">Try Again</a>
												</li>
											</ul>
										</form>
									</div>
								</div>
							<?php } else if($err == 5){ ?>
								<div class="popupparent">
									<span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a>
										<div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;"><p>Sorry! Name should not contain special characters and space.</p>
										<p>Please try different name without surname.</p>
										</div>
										<form style="width:100%" id="trydiffname" name="trydiffname" action="<?php echo get_permalink(); ?>" method="get">
											<ul class="frst_frm">
												<li>
													<b>Name</b><input class="txt_flip" id="bu_name" name="bu_name" value="" maxlength="13" type="text">
												</li>
												<li>
													<b>Gender</b>
													<label class="active"><input class="rd_flip" name="bu_gender" value="Boy" checked="checked" type="radio"> Boy</label>
													<label class="girl_lb"><input class="rd_flip" name="bu_gender" value="Girl" type="radio"> Girl</label>
												</li>
												<li>
													<a href="javascript:void(0)" class="a_cnt" id="tryfiffcontinue">Try Again</a>
												</li>
											</ul>
										</form>
									</div>
								</div>
							<?php } ?>
							
						<?php } ?>
					<?php if($err != 5 && $err != 4){ ?>
					<div class="flip_form open_diffname" style="display:none;">
						<form id="productbookform" name="productbookform" action="" method="get">
							<ul class="frst_frm">
								<li>
									<b>Name</b><input type="text" class="txt_flip" id="bu_name" name="bu_name" value="<?php if($bu_name != ''){ echo $bu_name; } ?>"  maxlength="13"/>
								</li>
								<li>
									<b>Gender</b>
									<?php if($bu_gender != ''){ ?>
										<?php if($bu_gender == 'Boy' || $bu_gender == 'boy'){ ?>
											<label class="active"><input type="radio" class="rd_flip"  name="bu_gender" value="Boy" checked="checked" /> Boy</label>
											<label class="girl_lb"><input type="radio" class="rd_flip"  name="bu_gender" value="Girl" /> Girl</label>
										<?php } ?>
										<?php if($bu_gender == 'Girl' || $bu_gender == 'girl'){ ?>
											<label><input type="radio" class="rd_flip"  name="bu_gender" value="Boy" /> Boy</label>
											<label class="girl_lb active"><input type="radio" class="rd_flip"  name="bu_gender" value="Girl" checked="checked" /> Girl</label>
										<?php } ?>
									<?php }else{ ?>
										<label class="active"><input type="radio" class="rd_flip"  name="bu_gender" value="Boy" checked="checked" /> Boy</label>
										<label class="girl_lb"><input type="radio" class="rd_flip"  name="bu_gender" value="Girl" /> Girl</label>
									<?php } ?>
									
								</li>
								<li>
									<a href="javascript:void(0)" class="a_cnt" id="Continue"><?php if($bu_name != ''){ ?>Update<?php }else{ ?>Continue<?php } ?></a>
								</li>
							</ul>
						</form>
					</div>
					<?php } ?>
				</div>
		  <?php } ?>
			  
		<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
	
		<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>
		<?php
			/**
			 * woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			//do_action( 'woocommerce_sidebar' );
		?>
	</div>
	<div class="clear"></div>
</div>
<script>
function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	
	
	
	// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

jQuery('document').ready(function($){	
	var gender = '<?php echo $bu_gender; ?>';
	var kids_name = '<?php echo $bu_name; ?>';
	var campaign = '<?php echo $campaign; ?>';
	var myKeyVals = { kids_name : kids_name, gender : gender, campaign : campaign }
	$.ajax({ url: "<?php echo site_url(); ?>/sendmailtovisitor.php",
		type: 'POST',
		data: myKeyVals,
		success: function(data){
			console.log(data);
		   return true;
		}
	});
	
			/* $('#changededication').addClass('hide');
			$('.mob_dedication').addClass('hide');
			$('.flip_wrap #flipbook .next.next_b, .flip_wrap #flipbook .prev.prev_b').click(function(){
				if($('.slide.current').hasClass('s-1') || $('.slide.current').hasClass('s-2') || $('.slide.current').hasClass('s-3')){
					$('#changededication').removeClass('hide');
					$('.mob_dedication').removeClass('hide');
					var left = $('#changededication').offset().right;
					$("#changededication").css({
						left: left
					}).animate({
						"right": "0"
					}, "slow");
				}else{
					$('#changededication').addClass('hide');
					$('.mob_dedication').addClass('hide');
				}
				
			}); */
			
			$('.sk-spinner_wrap').fadeOut();
	
});

</script>

<?php /* if(isset($_REQUEST['bu_name'])){ ?>
	<script>
	jQuery('document').ready(function($){
		var code = getUrlVars();
		if (typeof code['code'] !== "undefined"){
			$('.sk-spinner_wrap').css({position: "fixed"});	
			$('.innercnt').css({'z-index':99});	
			$('.sk-spinner_wrap').fadeIn();
			var request = $.ajax({
				type: 'GET',
				data: "",
				url: "<?php echo site_url(); ?>/coupon/?code="+code['code'],
				beforeSend: function(data) {
					$('.sk-spinner_wrap').show();
				},
				success: function(data) {
					console.log('done');
					//alert(1);
					$('.sk-spinner_wrap').show();
					var url = window.location.href;
					var a = url.indexOf("&code");
					var b =  url.substring(a);
					var c = url.replace(b,"");
					url = c;				
					window.location.href = url;
				}
			});			
		}else{
			$('.sk-spinner_wrap').fadeOut();
		}
	});
	</script>
<?php }elseif(get_query_var('bname') != ''){ ?>
	<script>
	jQuery('document').ready(function($){
		var code = '<?php echo $bcode; ?>';
		if (typeof code !== "undefined" && code != ''){
			$('.sk-spinner_wrap').css({position: "fixed"});	
			$('.innercnt').css({'z-index':99});	
			$('.sk-spinner_wrap').fadeIn();
			var request = $.ajax({
				type: 'GET',
				data: "",
				url: "<?php echo site_url(); ?>/coupon/"+code,
				beforeSend: function(data) {
					$('.sk-spinner_wrap').show();
				},
				success: function(data) {
					$('.sk-spinner_wrap').show();
					url = "<?php echo site_url().'/'.$bgender.'_'.$bu_name; ?>";
					window.location.href = url;
				}			
			});		
		}else{
			$('.sk-spinner_wrap').fadeOut();
		}		
	});
	</script>
<?php }  */ ?>
</div>
	<?php
		$args = array(
			'post_type' => 'testimonials',
			'showposts' => -1,
			'no_found_rows' => true,
			'meta_query' => array(
					array('key' => 'show_on','value' => 'inner','compare' => '==')),
		);
		$query = new WP_Query( $args  );
if($query->have_posts()){
?>	
<div class="sk_testimonial vdowrap">	
	<h2>Super Moments of Super Kids</h2>
		<div class="owl-carousel-video">
			<div><div class="imagewrap"><span></span><iframe width="280" height="180" src="https://www.youtube.com/embed/yklYSxQ0Qvo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>
			<div><div class="imagewrap"><span></span><iframe width="280" height="180" src="https://www.youtube.com/embed/rnN97EuhTRo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>
			<div><div class="imagewrap"><span></span><iframe width="280" height="180" src="https://www.youtube.com/embed/N4CzfoFGPkQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>
        </div>
   
</div>
<div class="sk_testimonial">
	<div class="swiper-container">
        <div class="swiper-wrapper">
		<?php
	    while ( $query->have_posts() ) : $query->the_post();
        $post_id = $post->ID;
	?>
	<div class="swiper-slide"><div class="imagewrap"><span></span><?php echo get_the_post_thumbnail( $post_id); ?></div></div>
	<?php
		endwhile;
        wp_reset_postdata();
	
	?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
<?php } ?>
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
