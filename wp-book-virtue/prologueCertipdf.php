<?php 
global $wpdb;
$dir = plugin_dir_path( __FILE__ );	
if(isset($_REQUEST['submit'])) {
	if(isset($_REQUEST['bu_name'])){
		$err = 0;
		$bu_name= $_REQUEST['bu_name'];
		header('Location: admin.php?page=prologuedocpdf&bu_name='.$_REQUEST['bu_name']);
		exit();
	}
}
?>
<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Check meaning of kid's name</h2>
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				<div class="option">
					<form name="bookvirtueform" action="" method="get" enctype="multipart/form-data">
						<input type="hidden" name="page" value="prologueCertiPdf" />					
						<table class="form-table virtue-table">
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="bu_name">Enter Name</label></th>
								<td><input type="text" id="bu_name" name="bu_name" value="" class="regular-text" required /></td>
							</tr>
						</table>
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Submit"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>