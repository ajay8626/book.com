<?php
global $wpdb;
/*
 * Kids photo upload for first page text in book
 */
$chk = '';
if ( isset( $_REQUEST["ordernumber"] ) && $_REQUEST["ordernumber"] != '' && isset( $_FILES["kidsphoto"]["name"] ) && $_FILES["kidsphoto"]["name"] != '' ) {
	$order = $_REQUEST["ordernumber"];
	$check = getimagesize($_FILES["kidsphoto"]["tmp_name"]);
	if($check !== false) {
		$upload = wp_upload_dir();
		$uploadDir = $upload['basedir'] . "/kidsphotos/";
		$urlDir = $upload['baseurl'] . "/kidsphotos/";
		$permissions = 0755;
		if (!is_dir($uploadDir)) mkdir($uploadDir, $permissions);
		$newfile = $uploadDir . $order . '-' . $_FILES["kidsphoto"]["name"];
		$newfileurl = $urlDir . $order . '-' . $_FILES["kidsphoto"]["name"];
		if (move_uploaded_file($_FILES["kidsphoto"]["tmp_name"], $newfile)) {							
			update_post_meta( $order, '_kidsphoto', $newfileurl );
			$chk = 'Photo uploaded successfully.';
		}
	}
}
?>
<div role="main" id="wpbody">
	<div id="wpbody-content" aria-label="Main content" tabindex="0">		
		<div class="wrap">
			<form name="personalised_detail_frm" method="post" action="" enctype="multipart/form-data">
				<div class="personalised_detail_wrap">					
					<div class="kidsimage">
						<?php if($chk != ''){ ?>
						<h2 style="color:#698037"><?php echo $chk; ?></h2>
						<p><a href="post.php?post=<?php echo $order; ?>&action=edit" target="_blank">Click <?php echo "#".$order; ?></a>
					<?php } ?>
					<h3>Kid's photo</h3>
						<p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto">
							<label for="ordernumber">Order Number:</label>
							<input name="ordernumber" class="input-text " id="ordernumber" type="text" value="" />
							<small>Please enter order number without #,space or any special characters<small>
						</p>
						<p class="form-row personalised_detail-class form-row-wide woocommerce-validated uphoto">
							<label for="kidsphoto">Upload Photo:</label>
							<input name="kidsphoto" class="input-text " id="kidsphoto" type="file" accept="image/*"/>
						</p>
						<input class="button alt" name="kidssubmit" id="kidssubmit" value="Submit" type="submit">
					</div>
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>