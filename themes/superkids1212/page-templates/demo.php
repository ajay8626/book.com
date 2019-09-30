<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/min.js"></script>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/sweetalert.css">
<?php
/**
 * Template Name: Preview Demo
 *
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
/*
wp_enqueue_script( 'my-script', get_template_directory_uri() . '/js/at-jquery.js', array(), true );
wp_enqueue_script( 'my-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array(), true );*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' );

if(isset($_REQUEST['code'])){
	$bcode = $_REQUEST['code'];
}elseif(get_query_var('bcode') != ''){
	$bcode = get_query_var('bcode');
}else{
	$bcode = '';
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
// shortcode for similiar meaning starts here

function similiar_words($Whole_word,$gender,$id){
global $wpdb,$err;

$static_word1=str_split(strtoupper($Whole_word));
$data_library=array();
$meaning=array();
$used=array();
$checked=array();

$page_orderleftpriority = array();
$page_ids = array();
$page_orderrightpriority = array();
$static_word = array_unique($static_word1);
// word library
foreach($static_word as $static){
	$query = "SELECT * FROM `wp_book_virtue` WHERE `virtue` LIKE '".$static."%' and gender='".$gender."'";
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
	$preview_query = "SELECT * FROM `wp_preview_pages` WHERE id = $id ";
	$previewData = $wpdb->get_results( $preview_query );

	$nameAttr = $previewData[0]->name_attribute;
	$nameAttrute =explode(',',$nameAttr);
	foreach($nameAttrute as $mean){
		$single_word=explode('-',$mean);
		$singleWord = trim($single_word[1]);
		$single_query = "SELECT * FROM `wp_book_virtue` WHERE `gender` = '".$gender."' AND `virtue` LIKE '".$singleWord."'";
		$singlewords = $wpdb->get_results( $single_query );
		if(!empty($previewData)){
			foreach($singlewords as $singleword){
				$other_data[]=$singleword->id;
			}	
		}else{

		}
				
	}
 	$all_data_array = array('initial'=>$nameAttrute,'other_data'=>$other_data);
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

	imagecopyresized($outputImage,$first,0,0,0,0, $x, $y,$x,$y);
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
	
	if($ok){
		return $fullfileurl;
	}else{
		return false;
	}
}

?>
<script>
jQuery(document).ready(function($){
	
	
	$('.flip_form li label input:radio').click(function() {
			$('.flip_form li label input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
			$(this).parent().addClass('active');
	});

	$(".a_edit").click(function(){
		$(".flip_form .frst_frm").slideDown();
		$(".flip_form .dedication-input").slideUp();
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
<?php
	$sql = "SELECT * FROM `wp_preview_pages` WHERE `id` = '".$_REQUEST['succ']."'";
	$previewData = $wpdb->get_results($sql);
	$bu_name = $previewData[0]->kids_name;
	$bu_gender = $previewData[0]->gender;
	$comments = $previewData[0]->comments;
	$id = $previewData[0]->id;
?>
<div class="innercnt">
	<div class="mtp single-product">
		
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
						//$sql = "SELECT * FROM `wp_book_virtue` WHERE alphabet IN ('$bu_name1') AND gender = '$gender' ORDER BY priority , FIELD(alphabet, '$bu_name1')";
						$sql = "SELECT * FROM `wp_book_virtue` WHERE alphabet IN ('$bu_name1') AND gender = '$gender'";
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
				$data_result = similiar_words($bu_name_str,$gender,$id);
				$result = $data_result['other_data']; 
				$prname = $bu_name != ''?trim(strtolower($bu_name)):'';
				
				if($bu_name == 'DARSHITA' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'secondname'){
					$result = array(0 => 79, 1 => 80, 2 => 173, 3 => 174, 4 => 118, 5 => 119, 6 => 122, 7 => 123, 8 => 93, 9 => 94, 10 => 97, 11 => 98, 12 => 128, 13 => 129, 14 => 161, 15 => 162);
				}
			?>
			<div id="flipbookproduct" class="Carousel">
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
					//$image = createimageinstantly($comments);
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
					<?php	}
					?>
					
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
			</div>
		</div>
		  
			  
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

				<?php wc_get_template_part( 'content', 'demo' ); ?>

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
	//var campaign = '<?php //echo $campaign; ?>';
	
	
	var myKeyVals = { kids_name : kids_name, gender : gender}
	console.log(myKeyVals);
	/*$.ajax({ url: "<?php echo site_url(); ?>/sendmailtovisitor.php",
		type: 'POST',
		data: myKeyVals,
		success: function(data){
			//console.log(data);
		   return true;
		}
	});*/
	$('.sk-spinner_wrap').fadeOut();
	
});
 
$(function() {
  var owl = $("#flipbookproduct.Carousel");     
    owl.owlCarousel({   animateOut: 'fadeOut',items :1, itemsDesktop : [1000,1], itemsDesktopSmall : [1030,1],  itemsTablet: [650,1],   itemsMobile :  [360,1]});
  });
</script>
</div>
	
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>
<style>
h2.entry-title.post-tittle-desc {
    display: none;
}
</style>