<?php 
global $wpdb;
$personalised_detail = "";
$ordertype_id = "";
$message = "";
$flag = 0;
if(isset($_REQUEST['submitorderid']) && isset($_REQUEST['ordertype_id']) && $_REQUEST['page'] !='' && $_REQUEST['ordertype_id'] !='' && $_REQUEST['page'] =='change_message' && !isset( $_REQUEST['special_message'] )){
	$ordertype_id = $_REQUEST['ordertype_id'];
	$personalised_detail = get_post_meta($ordertype_id,'_special_message',true);
    $flag = 1;
}
if(isset($_REQUEST['updatemessage']) && isset($_REQUEST['ordertype_id']) && $_REQUEST['page'] !='' && $_REQUEST['ordertype_id'] !='' && $_REQUEST['page'] =='change_message' && $_REQUEST['updatemessage'] =='Submit'){
	if ( isset( $_REQUEST['special_message'] ) ) {
		$ordertype_id = $_REQUEST['ordertype_id'];
		update_post_meta(  $ordertype_id, '_special_message', $_REQUEST['special_message'] );
		$message = "Special Message updated successfully";
	}
}
?>
<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Change Special Message</h2>
	<?php if($message != "") { ?>
		<p style="padding-left:31px;clear: both;float: left; width:100%;color:green;font-size:15px;"><?php echo $message; ?></p>
	<?php } ?>
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				<div class="option">
					<?php if($flag == 1){ ?>
						<form name="chngmessage" action="/wp-admin/admin.php?page=change_message&ordertype_id=<?php echo $ordertype_id; ?>" method="post">
							<input type="hidden" name="page" value="change_message" />					
							<table class="form-table virtue-table">
								<tr class="user-rich-editing-wrap">
									<th scope="row"><label for="ordertype_id">Enter Order ID:</label></th>
									<td><input type="text" id="ordertype_id" name="ordertype_id" value="<?php echo $ordertype_id; ?>" class="regular-text" required /></td>
								</tr>
								<tr class="user-rich-editing-wrap">
									<th scope="row"><label for="ordertype_id">Message</label></th>
									<td><textarea name="special_message" style="width:100%; height:200px"><?php echo $personalised_detail; ?></textarea></td>
								</tr>								
							</table>
							<p class="submit"><input type="submit" name="updatemessage"  class="button button-primary" value="Submit"></p>
						</form>
					<?php }else{ ?>
						<form name="chngmessage" action="/wp-admin/admin.php?page=change_message" method="post">
							<table class="form-table virtue-table">
								<tr class="user-rich-editing-wrap">
									<th scope="row"><label for="ordertype_id">Enter Order ID:</label></th>
									<td><input type="text" id="ordertype_id" name="ordertype_id" value="" class="regular-text" required /></td>
								</tr>
							</table>
							<p class="submit"><input type="submit"  name="submitorderid"  class="button button-primary" value="Submit"></p>
						</form>
					<?php } ?>
				</div>				
			</div>
		</div>
	</div>
</div>