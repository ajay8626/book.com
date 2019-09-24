
<?php 
global $wpdb;
wp_enqueue_script( 'jquery_min', plugins_url('js/jquery.min.js', __FILE__), array('jquery') );
wp_enqueue_script( 'jquery-Jcrop', plugins_url('js/jquery.Jcrop.min.js', __FILE__), array('jquery') );
wp_enqueue_style('Jcrop_min', plugins_url().'/wp-book-virtue/css/jquery.Jcrop.min.css');

if(isset($_REQUEST['submit'])) {
	$image_name= isset($_FILES["kidphoto"]["name"])?stripslashes($_FILES["kidphoto"]["name"]):"";
	$art_upload= isset($_FILES["kidphoto"]["tmp_name"])?($_FILES["kidphoto"]["tmp_name"]):"";
	$image_etn = explode(".",$image_name);
	$image_cont = end($image_etn);
	$png_name = $image_etn[0];
	$jpeg_quality = 90;
	$or_w = 500;
	list($width, $height) = getimagesize($art_upload);
	$or_h = ($height/$width)* $or_w;
	$src = imagecreatefromjpeg($art_upload);
	$tmp = imagecreatetruecolor($or_w, $or_h);
	$folder = plugin_dir_path(__FILE__)."/kids-photo/";
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $or_w, $or_h, $width, $height);
	echo $folder.$image_name; exit;
	imagejpeg($tmp, $folder.$image_name);

	imagedestroy($tmp);
	imagedestroy($src);
	imagejpeg($src, null, $jpeg_quality);
	imagecopyresampled($tmp, $src, 0, 0, $_GET['x'], $_GET['y'], $width, $height, $_GET['w'],$_GET['h']);
	
	if($image_cont == "png") {
	    $image = imagecreatefrompng($_FILES["kidphoto"]["tmp_name"]);
	    $path = imagejpeg($image, plugin_dir_path(__FILE__)."/kids-photo/".$png_name.".jpg",100);
	    imagedestroy($image);
	    if($path == 1) {
		    $path = plugin_dir_path(__FILE__)."kids-photo/".$png_name.".jpg";
	    } else {
		   $path = '';
	 	} 
	} else {
		$path = plugin_dir_path(__FILE__)."kids-photo/".$image_name;
		if(move_uploaded_file($art_upload,$path))
		{
			$path = $path;
		} else {
			$path = '';
		}
	}
	$kid_photo = plugin_dir_url( __FILE__ )."kids-photo/".$png_name.".jpg";


	$filename = urlencode($filename);
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
			
			//$pdf->Cell( 40, 40, $pdf->Image($file, $size_x, $size_y, 50), 0, 0, 'L', false )
			$pdf->ClippingCircle(105,150,38,true);
			$pdf->Image($file,65,100,100,150,'jpg');
			$pdf->UnsetClipping();
			
    		//$pdf->RoundedRect($size_x, $size_y, $width, $height, 50, '13');
			//$pdf->RoundedBorderCell(50,50,0);
			$font_size=40;
			if(strlen($str) > 4){
				$set_x = 25;
			}
			$pdf->SetXY(45,70);
			$pdf->SetFont('P22Wedge-Bold','',$font_size);
			$pdf->Multicell(110,$margin,$str,0,"C");
			/*$pdf->Output();
			echo "<pre>"; print_r($size); exit;*/
			$pdf->Output('kids.pdf','D');
		} else {
				$message =  "Image is not upload. please try again.";
		}
	}

  } 

?>

<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Height Chart With Name & Photo</h2>
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
								<th scope="row"><label for="kids_msg">Enter Name</label></th>
								<td><input type="text" name="heigth_name"></td>
							</tr>
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="image">Upload Image</label></th>
								<td>
									<input type="file" class="button staff_button" style="" id="kidphoto" name="kidphoto" required />
								</td>
							</tr>
						</table>
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Upload"></p>
					</form>
					
				<form action="save.php?file=<?php echo $filename; ?>" method="post" onsubmit="return checkCoords();">
		  			<input type="hidden" id="x" name="x" />
		  			<input type="hidden" id="y" name="y" />
		  			<input type="hidden" id="w" name="w" />
		  			<input type="hidden" id="h" name="h" />
		        	<br><br>
		  		</form>
		  		<?php if($kid_photo != "") { ?>
		  			<img src="<?php echo $kid_photo; ?>" alt="kids_image" width="400" height="auto" id="cropbox">
		        	<br>
		  			<input type="submit" value="Save Image" class="btn btn-primary btn-large btn-inverse">
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(function(){
      $('#cropbox').Jcrop({
      	alert('sdfkljlkj');
        aspectRatio: 1,
        onSelect: updateCoords
      });
     /* $("#crop").click(function(){
	        var img = $("#cropbox").attr('src');
	        $("#cropped_img").show();
	        $("#cropped_img").attr('src','image-crop.php?x='+size.x+'&y='+size.y+'&w='+size.w+'&h='+size.h+'&img='+img);
	    });*/
    });

    function updateCoords(c){
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };

    function checkCoords(){
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };

  </script>