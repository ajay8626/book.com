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
require("class.phpmailer.php");
error_reporting(0);
?>
<?php 
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
	
	$img1 = $targetPath.'PROLOGUE1500.jpg';

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
	
	$P22Wedge = $targetPath.'P22Wedge.ttf';
	$KelmscottRegular = $targetPath.'KelmscottRegular.ttf';
	
	imagettftext($outputImage, 22, 0, 730, 207, $blk, $P22Wedge, $text);
	imagettftext($outputImage, 22, 0, 730, 209, $blk, $P22Wedge, $text);
	imagettftext($outputImage, 22, 0, 731, 208, $blk, $P22Wedge, $text);
	

	$filename = $name.'_prologue.jpg';
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
	
	if($gender == 0){
		$filename = $name.'_enging_boy.jpg';
		$img1 = $targetPath.'ENDING_boy.jpg';
	}else{
		$filename = $name.'_enging_girl.jpg';
		$img1 = $targetPath.'ENDING_girl.jpg';
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
	$KelmscottRegular = $targetPath.'KelmscottRegular.ttf';
	$TrajanBold = $targetPath.'TrajanBold.ttf';
	
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
	$smallArr = array('I','J');
	$medArr = array('A','S','E','F','L');
	$largeArr = array('M','W','H');	
	
	foreach($name_arr as $res){
		imagettftext($outputImage, 26, 0, $charspace, 440, $wht, $TrajanBold, $res[0]);
		
		if(in_array($res[0],$smallArr)){
			$charspace += 15;
		}else if(in_array($res[0],$medArr)){
			$charspace += 25;
		}else if(in_array($res[0],$largeArr)){
			$charspace += 35;
		}else{
			$charspace += 30;
		}
	}
	
	
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
	
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	
	if($gender == 0){
		$filename = $name.'_boy_certificate.jpg';
		$img1 = $targetPath.'boycerti1500.jpg';
	}else{
		$filename = $name.'_girl_certificate.jpg';
		$img1 = $targetPath.'girlcerti1500.jpg';
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
	
	$KELMSCOT = $targetPath.'KELMSCOT.TTF';
	
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
	foreach($smallname_arr as $res){
		if($i == 1){
			imagettftext($outputImage, 32, 0, $charspace, 240, $titleColor, $KELMSCOT, strtoupper($res[0]));
			
		}else{
			imagettftext($outputImage, 32, 0, $charspace, 240, $titleColor, $KELMSCOT, strtolower($res[0]));
		}
		if($i == 1){
			if(in_array(strtoupper($res[0]),$smallArr)){
				$charspace += 30;
			}else if(in_array(strtoupper($res[0]),$medArr)){
				$charspace += 32;
			}else if(in_array(strtoupper($res[0]),$largeArr)){
				$charspace += 40;
			}else{
				$charspace += 30;
			}
		}else{
			if(in_array($res[0],$smallArr)){
				$charspace += 30;
			}else if(in_array($res[0],$smallsmArr)){
				$charspace += 15;
			}else if(in_array($res[0],$medsmArr)){
				$charspace += 24;
			}else if(in_array($res[0],$medArr)){
				$charspace += 32;
			}else if(in_array($res[0],$largeArr)){
				$charspace += 40;
			}else{
				$charspace += 30;
			}
		}
		$i = 0;
	}
	
	
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
});
 $(window).load(function(){
		$('.sk-spinner_wrap').fadeOut();
		
	});
</script>
<div class="innercnt">
	<div class="mtp">
		<?php if(isset($_REQUEST['bu_name']) && isset($_REQUEST['bu_gender'])){ ?>
				<div class="flip_wrap">
					<div class="flipbook-bg">
						<div class="sk-spinner_wrap">
							<?php if($_REQUEST['bu_gender'] == 'Girl'){ ?>
								<img src="<?php echo get_template_directory_uri(); ?>/images/girl_front.jpg"/>
							<?php }else if($_REQUEST['bu_gender'] == 'Boy'){ ?>
								<img src="<?php echo get_template_directory_uri(); ?>/images/boy_frnt.jpg"/>
							<?php } ?>
						</div>
						<?php
							$result = array();
							$characterset = array();
							if(isset($_REQUEST['bu_name'])){
								$err = 0;
								if(strlen($_REQUEST['bu_name']) <= 12){
								
									$bu_gender = isset($_REQUEST['bu_gender'])?$_REQUEST['bu_gender']:'Boy';
									$gender = 0;
									if($bu_gender == 'Girl'){
										$gender = 1;
									}
									global $wpdb;
									$bu_name_str = $_REQUEST['bu_name'];
									$bu_name_arr = str_split(strtoupper($bu_name_str));
									$bu_name= implode("','",$bu_name_arr);
									
									
									$sql = "SELECT * FROM `wp_book_virtue` WHERE alphabet IN ('$bu_name') AND gender = '$gender' ORDER BY priority, FIELD(alphabet, '$bu_name')";
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
							$prname = isset($_REQUEST['bu_name'])?trim(strtolower($_REQUEST['bu_name'])):'';
						?>
						<div id="flipbook">
							<?php 
							
							if($gender == 0){
								$frontimage	= get_option('frontimage')?get_option('frontimage'):"";
								$endingimage1	= get_option('boys_back1')?get_option('boys_back1'):"";
								$endingimage2	= get_option('boys_back2')?get_option('boys_back2'):"";
							}else if($gender == 1){
								$frontimage	= get_option('girl_frontimage')?get_option('girl_frontimage'):"";
								$endingimage1	= get_option('girls_back1')?get_option('girls_back1'):"";
								$endingimage2	= get_option('girls_back2')?get_option('girls_back2'):"";
							}
							?>
							<?php if($frontimage != ''){ ?>
								<div class="slide">
									<img src="<?php echo $frontimage; ?>" alt="" /> 		 
								</div>
							<?php } ?>
							<?php if(!empty($result) && $err == 0){ 
								$prname = isset($_REQUEST['bu_name'])?trim(strtolower($_REQUEST['bu_name'])):'';
								if (getimagesize(site_url().'/createimage/frontimage/'.$prname.'_prologue.jpg') !== false){
									$prologue = site_url().'/createimage/frontimage/'.$prname.'_prologue.jpg';
								}else{
									$prologue = createPrologueImage($prname);
								}
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
										<img src="<?php echo get_template_directory_uri(); ?>/images/girl-opening-scene-02"/>
									</div>
								<?php } ?>
								
									<?php 
									$certi_arr = array();
										foreach($result as $res){	?>
										<?php 
											$sql = "SELECT image,alphabet,virtue,page_order FROM `wp_book_virtue` WHERE id = $res";
											$resVirtue = $wpdb->get_results($sql);
											foreach($resVirtue as $virtue){
												if($virtue->page_order == 'L'){
													$certi_arr[] = array($virtue->alphabet,$virtue->virtue);
												}
												?>
												<div class="slide">
													<img src="<?php echo $virtue->image; ?>" alt="<?php echo $virtue->virtue; ?>" title="<?php echo $virtue->virtue; ?>" /> 
												</div>
											<?php } ?>
									<?php } ?>
								
								<?php if($endingimage1 != ''){ ?>
									<div class="slide">
										<img src="<?php echo $endingimage1; ?>" alt="" /> 		 
									</div>
								<?php } ?>
								<?php 
								if($gender == 0){
									if (getimagesize(site_url().'/createimage/certimage/'.$prname.'_enging_boy.jpg') !== false){
										$endingimage2 = site_url().'/createimage/certimage/'.$prname.'_enging_boy.jpg';
									}else{
										$endingimage2 = createCertiImage($prname,0,$certi_arr);
									}
									
									if (getimagesize(site_url().'/createimage/certimage/'.$prname.'_boy_certificate.jpg') !== false){
										$certificate = site_url().'/createimage/certimage/'.$prname.'_boy_certificate.jpg';
									}else{
										$certificate = createCertificate($prname,0,$certi_arr);
									}
									
								}else{
									if (getimagesize(site_url().'/createimage/certimage/'.$prname.'_enging_girl.jpg') !== false){
										$endingimage2 = site_url().'/createimage/certimage/'.$prname.'_enging_girl.jpg';
									}else{
										$endingimage2 = createCertiImage($prname,1,$certi_arr);
									}
									
									if (getimagesize(site_url().'/createimage/certimage/'.$prname.'_girl_certificate.jpg') !== false){
										$certificate = site_url().'/createimage/certimage/'.$prname.'_girl_certificate.jpg';
									}else{
										$certificate = createCertificate($prname,1,$certi_arr);
									}
								}
								if($endingimage2){ ?>
									<div class="slide">
										<img src="<?php echo $endingimage2; ?>" alt="" />
									</div>
								<?php } ?>
								<?php if($certificate){ ?>
									<div class="slide">
										<img src="<?php echo $certificate; ?>" alt="" />									   
									</div>
								<?php } ?>
							<?php } ?>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0000_g1.jpg"/>
								</div>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0001_g2.jpg"/>
								</div>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0002_g3.jpg"/>
								</div>
								<div class="slide">
									<img src="<?php echo get_template_directory_uri(); ?>/images/_0003_g4.jpg"/>
								</div>
							<?php /* if($backimage != ''){ ?>
								<div class="slide">
									<img src="<?php echo $backimage; ?>" alt="" /> 		 
								</div>
							<?php }  */ ?>
						</div>
					</div>
				   
				    <div class="btn_dff dff_wrap_a">
					<a href="javascript:void(0);" id="trydiff_open" class="a_dff">Try different name</a>
				   </div>
				 
						<?php if(isset($_REQUEST['succ']) && $_REQUEST['succ'] == 1){ ?>
							<div class="popupparent"><span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a><div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;"><p>Thank you for enquiry. We will get back to you as soon as possible.</p></div></div></div>
						<?php }else{ ?>
						<?php if($err != 0 && $err != 4){ ?>
						<div class="popupparent">
							<span class="hgt"></span><div class="flip_form flip_form_popup"><a class="a_cls" href="javascript:void(0)">close</a>
								<div style="text-align: center; line-height: 20px; margin-bottom: 10px; color: #E40C0C;"><p>We are sorry! We do not have book which is matching with your name.</p>
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
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					
					<div class="flip_form open_diffname" style="display:none;">
						<form id="productbookform" name="productbookform" action="" method="get">
							<ul class="frst_frm">
								<li>
									<b>Name</b><input type="text" class="txt_flip" id="bu_name" name="bu_name" value="<?php if(isset($_REQUEST['bu_name'])){ echo $_REQUEST['bu_name']; } ?>"  maxlength="13"/>
								</li>
								<li>
									<b>Gender</b>
									<?php if(isset($_REQUEST['bu_gender'])){ ?>
										<?php if($_REQUEST['bu_gender'] == 'Boy'){ ?>
											<label class="active"><input type="radio" class="rd_flip"  name="bu_gender" value="Boy" checked="checked" /> Boy</label>
											<label class="girl_lb"><input type="radio" class="rd_flip"  name="bu_gender" value="Girl" /> Girl</label>
										<?php } ?>
										<?php if($_REQUEST['bu_gender'] == 'Girl'){ ?>
											<label><input type="radio" class="rd_flip"  name="bu_gender" value="Boy" /> Boy</label>
											<label class="girl_lb active"><input type="radio" class="rd_flip"  name="bu_gender" value="Girl" checked="checked" /> Girl</label>
										<?php } ?>
									<?php }else{ ?>
										<label class="active"><input type="radio" class="rd_flip"  name="bu_gender" value="Boy" checked="checked" /> Boy</label>
										<label class="girl_lb"><input type="radio" class="rd_flip"  name="bu_gender" value="Girl" /> Girl</label>
									<?php } ?>
									
								</li>
								<li>
									<a href="javascript:void(0)" class="a_cnt" id="Continue"><?php if(isset($_REQUEST['bu_name'])){ ?>Update<?php }else{ ?>Continue<?php } ?></a>
								</li>
							</ul>
						</form>
					</div>
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
</script>
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
