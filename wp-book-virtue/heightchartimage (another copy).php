
<?php 
global $wpdb;

if(isset($_REQUEST['submit'])) {
	
	define ("MAX_SIZE","2");
	$image_name = isset($_FILES["kidphoto"]["name"])?stripslashes($_FILES["kidphoto"]["name"]):"";
	$art_upload = isset($_FILES["kidphoto"]["tmp_name"])?($_FILES["kidphoto"]["tmp_name"]):"";
	$size = filesize($_FILES['kidphoto']['tmp_name']);
	$fileErrorMsg = $_FILES['kidphoto']['error'];
	$sourceProperties = getimagesize($art_upload);
	$image_etn = explode(".",$image_name);
	$image_cont = end($image_etn);
	$png_name = $image_etn[0];
	list($width, $height) = getimagesize($art_upload);
	$ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $imageType = $sourceProperties[2];
    if (!$art_upload) { 
	    echo "ERROR: Please browse for a file before clicking the upload button.";
	    exit();
	} else if($size > (9048 * 3024)) {
	    echo "ERROR: Your file was larger than 2MB in size.";
	    unlink($art_upload); 
	    exit();
	} else if ($fileErrorMsg == 1) { 
	    echo "ERROR: An error occured while processing the file. Try again.";
	    exit();
	}
	/*$or_h = ($height/$width)* $or_w;
	$src = imagecreatefromjpeg($art_upload);
	$tmp = imagecreatetruecolor($or_w, $or_h);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $or_w, $or_h, $width, $height);
	imagejpeg($tmp, $folder.$filename);

	imagedestroy($tmp);
	imagedestroy($src);*/
	/*if ($size > MAX_SIZE*1024) {
		echo "You have to upload upto 2MB image size";
		
	}*/
	/*switch ($imageType) {
		case IMAGETYPE_PNG:
			$image = imagecreatefrompng($_FILES["kidphoto"]["tmp_name"]);
			$tmp = imageResize($image,$sourceProperties[0],$sourceProperties[1]);
			imagepng($tmp, plugin_dir_path(__FILE__)."pdf-image/".$png_name.".jpg",100);
			break;
		case IMAGETYPE_JPEG:
			$image = imagecreatefromjpeg($_FILES["kidphoto"]["tmp_name"]);
			$tmp = imageResize($image,$sourceProperties[0],$sourceProperties[1]);
			imagejpeg($tmp, plugin_dir_path(__FILE__)."pdf-image/".$png_name.".jpg",100);
			break;
		default:
			echo "Invalid Image type.";
            exit;
            break;
	}*/
	list($width,$height) = getimagesize($art_upload);
	$newwidth=400;
	$newheight=($height/$width)*$newwidth;
	if($newheight > 400) { 
		$newheightX = 400;
		$newwidthX = ($newwidth/$newheight)*$newheightX;
	}else{
		$newheightX = $newheight;
		$newwidthX = $newwidth;
	}
	$tmpimage = imagecreatetruecolor($newwidthX,$newheightX);
	imagecopyresampled($tmpimage,$image,0,0,0,0,$newwidthX,$newheightX,$width,$height);
	
	$path = plugin_dir_path(__FILE__)."pdf-image/".$image_name;
	imagejpeg($tmpimage,$path,100);
	imagedestroy($image);
	imagedestroy($tmpimage);
	if(move_uploaded_file($art_upload,$path)){
		$path = $path;
	}else{
		$path = '';
	}
	
	/*if($image_cont == "png") {
	    $image = imagecreatefrompng($_FILES["kidphoto"]["tmp_name"]);
	    $path = imagejpeg($image, plugin_dir_path(__FILE__)."pdf-image/".$png_name.".jpg",100);
	    imagedestroy($image);
	    if($path == 1) {
		    $path = plugin_dir_path(__FILE__)."pdf-image/".$png_name.".jpg";
	    } else {
		   $path = '';
	 	} 
	} else {
		$path = plugin_dir_path(__FILE__)."pdf-image/".$image_name;
		if(move_uploaded_file($art_upload,$path))
		{
			$path = $path;
		} else {
			$path = '';
		}
	}*/
	$kid_photo = plugin_dir_url( __FILE__ )."pdf-image/".$png_name.".".$ext;


	$filename = urlencode($filename);
	$kid_msg =  $_REQUEST['heigth_name'];
	
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
							<tr><td>
								
							</td></tr>
						</table>
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Submit"></p>
					</form>
					<div class="clear"></div>
					<?php if($kid_photo !="") { ?>
						<form action="admin.php?page=crop_image" method="POST" name="thumbnail" onsubmit="return checkCoords();">
				  			<input type="hidden" name="x" value="" id="x" />
				  			<input type="hidden" name="x2" value="" id="x2" />
							<input type="hidden" name="y" value="" id="y" />
							<input type="hidden" name="y2" value="" id="y2" />
							<input type="hidden" name="w" value="" id="w" />
							<input type="hidden" name="h" value="" id="h" />
							<input type="hidden" name="tmp_name" value="<?php echo $art_upload;?>"  />
							<input type="hidden" name="img_name" value="<?php echo $image_name;?>" />
							<input type="hidden" name="filepath" value="<?php echo $kid_photo; ?>" />
							<input type="hidden" name="kid_msg" value="<?php echo $kid_msg; ?>"  />
				  			<img src="<?php echo $kid_photo; ?>" alt="kids_image" width="500" height="auto" id="cropbox">
				        <br>
			  			<input type="submit" name="save" value="Save Image" class="btn btn-primary btn-large btn-inverse">
			        	<br><br>
			  		</form>
			  		<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(function(){
      $('#cropbox').Jcrop({
      	aspectRatio: 1,
        onSelect: updateCoords
      });
    });

    function updateCoords(c){
    	//console.log(c);
      $('#x').val(c.x);
      $('#x2').val(c.x2);
      $('#y').val(c.y);
      $('#y2').val(c.y2);
      $('#w').val(c.w);
      $('#h').val(c.h);
      /*$('#tmp_name').val(c.tmp_name);
      $('#img_name').val(c.img_name);
      $('#filename').val(c.filename);*/
    };

    function checkCoords(){
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };

  </script>