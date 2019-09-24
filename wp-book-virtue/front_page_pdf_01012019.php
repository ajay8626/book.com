<?php 
global $wpdb;
$order_id = '';
$kidsname= '';
if(isset($_REQUEST['order_id'])) {  
	$order_id = $_REQUEST['order_id'];
	$kidsname = isset($_REQUEST['bu_name'])?$_REQUEST['bu_name']:'';
	$gender = isset($_REQUEST['bu_gender'])?$_REQUEST['bu_gender']:'';
	$kidsname = trim(ucfirst(strtolower($kidsname)));
	$kid_photo = get_post_meta( $order_id, '_kidsphoto', true );
	if($kid_photo == "") {
		$kid_photo = plugin_dir_url( __FILE__ )."images/Spacial-Msg3.png";
	}
?>

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
		if($image_cont == "png") {
			$source = imagecreatefrompng($path_replace);
		}else {
			$source = imagecreatefromjpeg($path_replace);
		}
		$rotate = imagerotate($source, $degrees, 0);
		imagejpeg($rotate,plugin_dir_path(__FILE__)."tempkids-photo/".$temp_filename.".jpg");
		imagedestroy($source);
		imagedestroy($rotate);
		$path = plugin_dir_path(__FILE__)."tempkids-photo/".$temp_filename.".jpg";
		if($gender == "Boy"){
			$pageImage = plugin_dir_path(__FILE__).'/images/boy.png';
		}else{
			$pageImage = plugin_dir_path(__FILE__).'/images/girl.png';
		}
		
		
		ob_clean(); 
		require('fpdf/fpdf.php');
		$pdf = new FPDF('p','mm',array(250,371.73));
		$pdf->SetAutoPageBreak(false,0);
		$pdf->Addpage('l');
		$file = $path;
		$kidsname = $_REQUEST['bu_name'];
		$size = getimagesize($file);
		$sizeImage = getimagesize($pageImage);
		$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
		$str = strtoupper($kidsname);
		$size_x = $size[0] * 2.54 / 96;
		$size_y = $size[1] * 2.54 / 96;
		$ratio = $size_x / $size_y;
		if($ratio > 1) {
			$width = 170;
			$height = 170/$ratio;
		} else {
			$width = 170*$ratio;
			$height = 170;	
		}
		$vh = (260 - $height) / 2;		
		if($height > $width){
			$pdf->Image($file,50,$vh,$width,$height,'jpg');	
		}else{
			$pdf->Image($file,9,$vh,$width,$height,'jpg');
		}
		//$pdf->Image($file,20,45,165,140,'jpg');
		$set_x = 45;
		$pdf->SetXY(55,$set_x);
		//$style = 'color:#FFF; letter-spacing:2px';
		$pdf->SetFont('P22Wedge-Bold','',17);
		$pdf->SetTextColor(0,0,0);

		$pdf->Image($pageImage,175,18,170,'auto','PNG');
		$pdf->Text(200,38.5,$str);
		$pdf->Output('front_cover.pdf', 'D');
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