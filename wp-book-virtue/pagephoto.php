<?php 
global $wpdb;
$message = '';
if(isset($_REQUEST['submit'])) {
	$image_name= isset($_FILES["kidphoto"]["name"])?stripslashes($_FILES["kidphoto"]["name"]):"";
	$art_upload= isset($_FILES["kidphoto"]["tmp_name"])?($_FILES["kidphoto"]["tmp_name"]):"";
	$image_etn = explode(".",$image_name);
	$image_cont = end($image_etn);
	$png_name = $image_etn[0];
	if($image_cont == "png") {
		$image = imagecreatefrompng($_FILES["kidphoto"]["tmp_name"]);
		$path = imagejpeg($image, plugin_dir_path(__FILE__)."/kids-photo/".$png_name.".jpg",100);
		imagedestroy($image);
		if($path == 1) {
			$path = plugin_dir_path(__FILE__)."/kids-photo/".$png_name.".jpg";
		} else {				 
			$path = '';
		} 
	} else {
		$path = plugin_dir_path(__FILE__)."/kids-photo/".$image_name;
		if(move_uploaded_file($art_upload,$path)) {
			$path = $path;
		} else {
			$path = '';
		}
	}
	$kid_msg =  $_REQUEST['kids_msg'];
	$kids_name =  $_REQUEST['kids_name'];
	/*if($kid_msg == ''){
		$kid_msg ="To,
		The Cutest Super Kid!";
	}*/
	if($kid_msg != ""){
		$kid_msg = stripcslashes($kid_msg);
		$kidsName = stripcslashes($kids_name);
		$kid_msg = iconv('UTF-8','ASCII//TRANSLIT', html_entity_decode($kid_msg));
		$kidsName = iconv('UTF-8','ASCII//TRANSLIT', html_entity_decode($kidsName));
		if($path != "") {
			ob_clean();
			require('fpdf/fpdf.php');
			$pdf = new FPDF('p','cm',array(37.5,25));
			$pdf->SetAutoPageBreak(false,0);
			$pdf->Addpage('l');
			$margin = 2;
			$file = $path;
			$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
			$str = $kid_msg;
			$size = getimagesize($file);
			$size_x = $size[0] * 2.54 / 96;
			$size_y = $size[1] * 2.54 / 96;
			$ratio = $size_x / $size_y;
			if($ratio > 1) {
				$width = 17;
				$height = 17/$ratio;
			} else {
				$width = 17*$ratio;
				$height = 17;	
			}
			$vh = (25 - $height) / 2;
			$pdf->Image($file,4,$vh,$width,$height,'jpg');
			$set_x = 11;
			$font_size=29;
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
			/*$pdf->SetXY(24,$set_x);*/
			$pdf->SetFont('P22Wedge-Bold','',$font_size);
			$pdf->Multicell(0,0,$kidsName,0,"D");
			$pdf->SetXY(24,$set_x);
			$pdf->Multicell(10,$margin,$str,0,"C");
			$pdf->SetXY(0,0);
			$pdf->Output($png_name.'.pdf','I');
		} else {
			$message =  "Image is not upload. please try again.";
		}
	}else{
		if($path != ""){
			ob_clean();
			$kids_name =  $_REQUEST['kids_name'];
			require('fpdf/fpdf.php');
			$pdf = new FPDF('p','cm',array(37.5,25));
			$pdf->SetAutoPageBreak(false,0);
			$pdf->Addpage('l');
			$margin = 2;
			//$file = $image_name;
			$file = $path;
			$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
			$str = $kid_msg;
			$size=getimagesize($file);
			$size_x = $size[0];
			$size_y = $size[1];
			/*echo $size_x; echo "<br>";
			echo $size_y; exit;*/
			$ratio = $size_x / $size_y;
			if($size_y < 1200){
				$height_y = 29;
			}else if($size_y < 1300){
				$height_y = 26;
			}else if($size_y < 1400){
				$height_y = 24;
			}else if($size_y < 1500){
				$height_y = 22;
			}else{
				$height_y = 20;
			}
			if($ratio > 1) {
				$width = 30;
				$height = $height_y/$ratio;
			} else {
				$height = 20;	
				$width = 20*$ratio;
			}
			$hw = (37 - $width) / 2;
			$vh = (25 - $height) / 2;
			/*$pdf->SetXY(24,20);*/
			$pdf->SetXY(0,0.2);
			$pdf->SetFont('P22Wedge-Bold','',15);
			$pdf->Multicell(0,0,$kids_name,0,"A");
			$pdf->Image($file,$hw,$vh,$width,$height,'jpg');
			$pdf->Output($png_name.'.pdf','D');
		} else {
			$message =  "Image is not upload. please try again.";
		}
	}
}
?>

<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Check kid's photo and message</h2>
	<?php if($message != "") { ?>
		<p style="color:red;font-size:15px;float: left;padding-left: 31px;width: 50%;"><?php echo $message ?></p>
	<?php } ?>
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				<div class="option">
					<form name="kidsphotofrm" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="page" value="kidsphotofrm" />					
						<table class="form-table virtue-table">
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="image">Kids Name</label></th>
								<td><input class="kids_name" type="text" placeholder="Kids Name" id="kids_name" name="kids_name" /></td>
							</tr>
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="image">Upload Image</label></th>
								<td><input class="button staff_button" type="file"  id="kidphoto" name="kidphoto" required /></td>
							</tr>
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="kids_msg">Enter message</label></th>
								<td><textarea name="kids_msg" class="input-text " id="kids_msg" style="width:400px;height:200px;" ></textarea></td>
							</tr>
						</table>
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Submit"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>