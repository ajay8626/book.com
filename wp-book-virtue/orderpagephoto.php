<?php 
global $wpdb;
$order_id = '';
$kidsname= '';

function remove_emoji($text){
      return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
}

if(isset($_REQUEST['order_id']))
{  
	$order_id = $_REQUEST['order_id'];
	$kidsname = isset($_REQUEST['bu_name'])?$_REQUEST['bu_name']:'';
	$kidsname = trim(ucfirst(strtolower($kidsname)));
	$kid_photo = get_post_meta( $order_id, '_kidsphoto', true );
	if($kid_photo == "")
	{
		$kid_photo = plugin_dir_url( __FILE__ )."images/Spacial-Msg.jpg";
	}
?>
<style>
.north {
transform:rotate(0deg);
-ms-transform:rotate(0deg); /* IE 9 */
-webkit-transform:rotate(0deg); /* Safari and Chrome */
}
.west {
transform:rotate(90deg);
-ms-transform:rotate(90deg); /* IE 9 */
-webkit-transform:rotate(90deg); /* Safari and Chrome */
}
.south {
transform:rotate(180deg);
-ms-transform:rotate(180deg); /* IE 9 */
-webkit-transform:rotate(180deg); /* Safari and Chrome */
    
}
.east {
transform:rotate(270deg);
-ms-transform:rotate(270deg); /* IE 9 */
-webkit-transform:rotate(270deg); /* Safari and Chrome */
}

</style>

<form name="" id="" method="post" action="">
	<div style="margin-top:50px;width:300px;float:left;">
	  <img style="width:100%;" class="north" width="500px" height="auto" src="<?php echo $kid_photo; ?>" id="img" name="img"/>
	</div>
	<div style="margin-top:75px;width:100%;float:left;">
		<input type="button" id="plus" value="Rotate Right" />
		<input type="button" id="minus" value="Rotate Left" />
		<input type="hidden" name="degree" id="degree" value="0" />
		<input type="submit" name="submit" id="submit" value="Save" />
	</div>
</form>
<?php 
 
	if(isset($_POST['submit'])){ 
	
		$filename = $kid_photo;
		
		if(preg_match("~\bhttp://skids.in/\b~",$filename)){
			$path_replace = str_replace('http://skids.in/','/home/superkidsleague/public_html/',$filename);
			
		} else if(preg_match("~\bhttp://www.skids.in/\b~",$filename)){
			
			$path_replace = str_replace('http://www.skids.in','/home/superkidsleague/public_html/',$filename);
		} else if(preg_match("~\bhttp://superkidsleague.com/\b~",$filename)){
			
			$path_replace = str_replace('http://superkidsleague.com/','/home/superkidsleague/public_html/',$filename);
		} else if(preg_match("~\bhttp://www.superkidsleague.com/\b~",$filename)){
			
			$path_replace = str_replace('http://www.superkidsleague.com/','/home/superkidsleague/public_html/',$filename);
		}
		
		$temp_filename = rand(0,9999).'_'.time();
		$degrees = "-".$_POST['degree'];
		
		$image_etn = explode(".",$path_replace);
		$image_cont = end($image_etn);
		
		
		if($image_cont == "png")
		{
			$source = imagecreatefrompng($path_replace);
		}
		else
		{
			$source = imagecreatefromjpeg($path_replace);
		}
		$rotate = imagerotate($source, $degrees, 0);
		imagejpeg($rotate,plugin_dir_path(__FILE__)."tempkids-photo/".$temp_filename.".jpg");
		imagedestroy($source);
		imagedestroy($rotate);
		$path = plugin_dir_path(__FILE__)."tempkids-photo/".$temp_filename.".jpg";
		
		$special_msg = get_post_meta( $order_id, '_special_message', true );
		$special_msg = trim($special_msg);
		if($special_msg == '"To Our World!"' || $special_msg == '"To Our World"' || $special_msg == '"To Our World."')
		{
			$message =  '"To Our World!" '. $kidsname;
		} else {
			$message = htmlentities($special_msg);
		}
		
		$message = remove_emoji($message);
		$str_message = iconv('UTF-8','ASCII//TRANSLIT', html_entity_decode($message));
		
		ob_clean();
		require('fpdf/fpdf.php');
		$pdf = new FPDF('p','cm',array(37.5,25));
		$pdf->SetAutoPageBreak(false,0);
		$pdf->Addpage('l');
		$margin = 2;
		//$file = $image_name;
		$file = $path;
		$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
		$str = $str_message;
		$size=getimagesize($file);
		$size_x = $size[0] * 2.54 / 96;
		$size_y = $size[1] * 2.54 / 96;
		$ratio = $size_x / $size_y;
		if($ratio > 1)
		{
		$width = 17;
		$height = 17/$ratio;
		}
		else
		{
		$width = 17*$ratio;
		$height = 17;	
		}
		$vh = (25 - $height) / 2;
		$pdf->Image($file,5,$vh,$width,$height,'jpg');
		$set_x = 11;

		$font_size=28;
		if(strlen($str) > 20)
		{
		$set_x = 9;
		if(strlen($str) > 40)
		{
			$set_x = 8;
			if(strlen($str) > 60)
			{
				$set_x = 7;
				if(strlen($str) >= 80)
				{
					$set_x = 6;
					$font_size = 25;
					if (strlen($str) >= 90) {
						$set_x = 5;
						if (strlen($str) > 100) {
							$set_x = 7;
							$margin = 1.5;
							$font_size = 30;
							if (strlen($str) >= 120) {
								$set_x = 5;
								if (strlen($str) >= 180){
									$font_size = 25;
									if (strlen($str) >= 200){
										$set_x = 5;
										$font_size = 20;
										if (strlen($str) >= 300){
											$set_x = 4;
											$font_size = 18;
											if (strlen($str) >= 400){
												$set_x = 3.5;
												$margin = 1.2;
												$font_size = 18;
												if (strlen($str) >= 500){
													$set_x = 3;
													$margin = 1.1;
													$font_size = 16;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		}
		$pdf->SetXY(24,$set_x);
		$pdf->SetFont('P22Wedge-Bold','',$font_size);
		$pdf->Multicell(10,$margin,$str,0,"C");
		$pdf->Output($order_id.'_'.$kidsname.'_photo.pdf','D');
	}
 } 

?>
<script>
jQuery(document).ready(function($){
	$('#plus').click(function(){
		setDegree('add');
		var img = $('img');
			if(img.hasClass('north')){
				img.attr('class','west');
			}else if(img.hasClass('west')){
				img.attr('class','south');
			}else if(img.hasClass('south')){
				img.attr('class','east');
			}else if(img.hasClass('east')){
				img.attr('class','north');
			}
	});
	$('#minus').click(function(){
		setDegree('subtract');
		var img = $('img');
			if(img.hasClass('north')){
				img.attr('class','east');
			}else if(img.hasClass('east')){
				img.attr('class','south');
			}else if(img.hasClass('south')){
				img.attr('class','west');
			}else if(img.hasClass('west')){
				img.attr('class','north');
			}
	}); 
});

function setDegree(type) {
	var degree = jQuery('#degree');
	var new_degree = 0;
	if(type == "add") {
		new_degree = parseInt(degree.val())+90;
	} else {
		new_degree = parseInt(degree.val())-90;
	}
	if(new_degree < 0) {
		new_degree = 360 + new_degree;
	} else if(new_degree >= 360) {
		new_degree = new_degree - 360;
	}
	degree.val(new_degree);
}
</script>