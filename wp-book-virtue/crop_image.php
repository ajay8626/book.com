<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//echo "<pre>"; print_r($_POST); 
	$targ_w  = 500;
	$targ_h = 1000;
	$img_name = $_POST['img_name'];
	$image_etn = explode(".",$img_name);
	$image_cont = end($image_etn);
	$png_name = $image_etn[0];
	$png_name = str_replace(" ", "_", $png_name);
	$tmp_name = $_POST['tmp_name']; 
	$kid_msg = $_POST['kid_msg']; 
	$filepath = $_POST['filepath']; 
	$ext = pathinfo($img_name, PATHINFO_EXTENSION);
	$w = $_POST['w'];
	$h = $_POST['h'];
	$x = $_POST['x'];
	$x2 = $_POST['x2'];
	$y = $_POST['y'];
	$y2 = $_POST['y2'];
	$oldPath = plugin_dir_path(__FILE__)."pdf-image/".$img_name;
	$newPath = plugin_dir_path(__FILE__)."height-chart-image/"."thumb_".$png_name."."$ext;
	//echo "convert -crop ".$x."x".$x2."+".$y."x".$y2." $oldPath $newPath";
	$percent = 0.5;
	list($width, $height) = getimagesize($filepath);
	$newwidth = $width * $percent;
	$newheight = $height * $percent;
	$dst_r = ImageCreateTrueColor( $newwidth, $newheight );
	$img_r = imagecreatefromjpeg($filepath); 
	imagecopyresized($dst_r, $img_r, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	$path = shell_exec("convert -crop ".$w."x".$h."+".$x."+".$y." $oldPath $newPath"); 

	//imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$w,$h);

	//header('Content-type: image/png');
	/*$path = imagejpeg($dst_r, plugin_dir_path(__FILE__)."/height-chart-image/"."thum_".$png_name.".jpg",100);
	imagedestroy($dest);
	imagedestroy($src);*/
	if($kid_msg != ""){
		$kid_msg = stripcslashes($kid_msg);
		$kid_msg = iconv('UTF-8','ASCII//TRANSLIT', html_entity_decode($kid_msg));
		if($newPath != "") {
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
			$file = $newPath;
			$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
			$str = $kid_msg;
			$size=getimagesize($file);
			$size_x = $size[0] * 2.54 / 56;
			$size_y = $size[1] * 2.54 / 56;
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
			$vh = (45 - $height) / 2;
			$set_x = 25;
			$pdf->ClippingCircle(105,150,38,true);
			$pdf->Image($file,50,50,100,150,'jpg');
			$pdf->UnsetClipping();
			$font_size=40;
			if(strlen($str) > 4){
				$set_x = 25;
			}
			$pdf->SetXY(45,70);
			$pdf->SetFont('P22Wedge-Bold','',$font_size);
			$pdf->Multicell(110,$margin,$str,0,"C");
			$pdf->Output('kids.pdf','I');
			
		}else {
			$message =  "Image is not upload. please try again.";
		}
	}



	//wp_redirect('admin.php?page=heightchartimage');
}


?>