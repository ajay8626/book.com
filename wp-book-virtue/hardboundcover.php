<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<?php
global $wpdb;
$order_id = $_REQUEST['order_id'];
$hardBoundYesNo = $_REQUEST['hardbound'];
$hardBound = 'Hard bound cover';
$orderItems = $wpdb->prefix.'woocommerce_order_items';
$hardboundAmount = get_option('ad_hardbound_amount');
$hardBoundCover = $wpdb->get_results("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE (order_item_name = 'Hard bound cover' AND order_id = '". $order_id ."')");
$hardboundVal = $hardBoundCover[0]->order_item_name;
//$wpdb->update( 'table', array( 'column1' => 'value1','column2' => 'value2'), array( 'ID' => 1 ));
$old_order_total = get_post_meta($order_id,'_order_total',true);
$new_order_total = $old_order_total;
$checked_status = 0;
if($hardboundVal == 'Hard bound cover'){
	$checked_status = 1;
}else{
	$checked_status = 0;
}

if(isset($_POST['hardboundSubmit']) == 'Submit'){
	if(($hardboundVal == "") && ($_POST['hardboundValue'] == 'yes')){
		$data = array('order_item_name' => $hardBound, 'order_item_type' => 'fee','order_id' => $order_id);
	    $wpdb->insert( $orderItems, $data);
	    $new_order_total = $old_order_total + $hardboundAmount;
	    update_post_meta( $order_id, '_order_total', $new_order_total); 
	    //wp_redirect( site_url().'/wp-admin/edit.php?post_type=shop_order' );
		echo  "<div class='alert alert-success'>
			  <strong>Success!</strong> Hard bound add successfully.
			</div>";
		$checked_status = 1;
		
	}else if(($hardboundVal != "") && ($_POST['hardboundValue'] == 'no')){
		
		$wpdb->delete( $orderItems, [ 'order_id' => $order_id, 'order_item_name' =>$hardBound,'order_item_type' => 'fee'] );
		$new_order_total = $old_order_total - $hardboundAmount;
	    update_post_meta( $order_id, '_order_total', $new_order_total); 
	    //wp_redirect( site_url().'/wp-admin/edit.php?post_type=shop_order' );
		echo  "<div class='alert alert-success'>
			  <strong>Success!</strong> Hard bound remove successfully.
			</div>";
		$checked_status = 0;
	}else{
		echo  "<div class='alert alert-success'>
			  <strong>Success!</strong> Hard bound update successfully.
			</div>";
		
	}
}

?>


<div class="container">
  	<form method="post" name="hardboundForm" id="" action="">
	  	<fieldset class="block">
			<legend>Hard Bound</legend>
		    <div class="form-group col-sm-6">
		        <label for="inputEmail" class="control-label col-xs-2">Order Id: </label>
		        <input type="text" class="form-control" value="<?php echo $order_id;?>" name="order_id" readonly="readonly">
		    </div>
		    <div class="form-group col-sm-6">
		        <label for="inputEmail" class="control-label col-xs-2">Order Price: </label>
		        <input type="text" class="form-control" value="<?php echo $new_order_total;?>" name="order_price" readonly="readonly">
		    </div>
		    <label class="control-label">Hard Bound Order : </label>
			<div class="form-check form-check-inline">
			    <input class="form-check-input" type="radio" name="hardboundValue" value="yes"<?php if($checked_status == 1){?> checked <?php } ?> /> Yes
			</div>
			<div class="form-check form-check-inline">
			    <input class="form-check-input" type="radio" name="hardboundValue" value="no"<?php if($checked_status == 0){?> checked <?php } ?> /> No
			</div>
			
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="hardboundSubmit" id="hardboundSubmit" value="Submit" />
			</div>
		</fieldset>
  	</form>
</div>
<style>
fieldset.block {
    border: 5px solid #1F497D!important;
    background: #eee!important;
    border-radius: 5px!important;
    padding: 15px!important;
}
</style>
