<?php 
global $wpdb;

if(isset($_REQUEST['upload'])) {
	$image_name= isset($_FILES["kidphoto"]["name"])?stripslashes($_FILES["kidphoto"]["name"]):"";
	$art_upload= isset($_FILES["kidphoto"]["tmp_name"])?($_FILES["kidphoto"]["tmp_name"]):"";
	$image_etn = explode(".",$image_name);
	$image_cont = end($image_etn);
	$png_name = $image_etn[0];
	if($image_cont == "png") {
		$image = imagecreatefrompng($_FILES["kidphoto"]["tmp_name"]);
		$path = imagejpeg($image, plugin_dir_path(__FILE__)."kids-photo/".$png_name.".jpg",100);
		imagedestroy($image);
		if($path == 1) {
			$path = plugin_dir_path(__FILE__)."kids-photo/".$png_name.".jpg";
		} else {
			$path = '';
		} 
	} else {
		$path = plugin_dir_path(__FILE__)."kids-photo/".$image_name;
		if(move_uploaded_file($art_upload,$path)) {
			$path = $path;
		} else {
			$path = '';
		}
	}
	$kid_msg =  $_REQUEST['heigth_name'];
	
	/*if($kid_msg == ''){
		$kid_msg ="To,
		The Cutest Super Kid!";
	}*/
	if($kid_msg != ""){
		$kid_msg = stripcslashes($kid_msg);
		$kid_msg = iconv('UTF-8','ASCII//TRANSLIT', html_entity_decode($kid_msg));
		if($path != "") {
			ob_clean();
			require('fpdf/customfpdf.php');
			$pdf = new FPDF('p','cm',array(37.5,25));
			$pdf = new PDF_Clipping();
			$pdf->SetAutoPageBreak(false,0);
			$pdf->Addpage('p');
			$pageImage = plugin_dir_path(__FILE__).'images/heightchartimage.jpg';
			list($width, $height) = getimagesize($pageImage);
			$pdf->Image($pageImage, 0, 0, 210, 300);
			$margin = 2;
			$file = $path;
			//$file = $image_name;
			$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
			$str = $kid_msg;
			
			$size=getimagesize($file);
			$size_x = $size[0] * 2.54 / 56;
			$size_y = $size[1] * 2.54 / 56;
			$ratio = $size_x / $size_y;
			if($ratio > 1) {
				$width = 17;
				$height = 17/$ratio;
			} else {
				$width = 17*$ratio;
				$height = 17;	
			}
			$vh = (45 - $height) / 2;
			$set_x = 25;
			$pdf->ClippingCircle(105,150,38,true);
			$pdf->Image($file,50,100,100,150,'jpg');
			$pdf->UnsetClipping();
			$font_size=40;
			if(strlen($str) > 4){
				$set_x = 25;
			}
			$pdf->SetXY(45,70);
			$pdf->SetFont('P22Wedge-Bold','',$font_size);
			$pdf->Multicell(110,$margin,$str,0,"C");
			$pdf->Output('kids.pdf','I');
		} else {
				$message =  "Image is not upload. please try again.";
		}
	}

  } 

?>

<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Height Chart With Name & Photo</h2>
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				<div class="option">
					<form name="kidsphotofrm" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="page" value="kidsphotofrm" />					
						<table class="form-table virtue-table">
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="kids_msg">Enter Name</label></th>
								<td><input type="text" name="heigth_name"></td>
							</tr>
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="image">Upload Image</label></th>
								<td><input type="file" class="button staff_button" style="" id="kidphoto" name="kidphoto" required /></td>
							</tr>
							
						</table>
						<p class="submit">
						<input type="submit" name="upload" id="upload" class="button button-primary" value="Upload">
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>