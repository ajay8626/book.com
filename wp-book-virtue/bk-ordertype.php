<?php

if( isset($_POST['ordertypesubmit'])){
	
	if(isset($_POST['ordertype_id']) && $_POST['ordertype_id'] !=''){	
		global $wpdb;
		$ordertype_id = $_POST['ordertype_id'];
		$selected_method = $_POST['payment_st'];
		$message = '';
		
		if($selected_method == '0')
		{
			update_post_meta( $ordertype_id, '_payment_method', 'cod');
			update_post_meta( $ordertype_id, '_payment_method_title', 'Cash on delivery (Extra charge : Rs. 45)');
			
			$message = "Your Order ID ". $ordertype_id ." payment method has been changed to COD";
		}
		else if($selected_method == '1')
		{
			update_post_meta( $ordertype_id, '_payment_method', 'razorpay');
			update_post_meta( $ordertype_id, '_payment_method_title', 'Credit Card/Debit Card/NetBanking');
			
			$message = "Your Order ID ". $ordertype_id ." payment method has been changed to Razorpay";
		}else{
			$message = "Please select payment method.";
		}
		
	}
}

?>
<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Change Payment Method</h2>
	<?php if($message != "") { ?>
		<p style="padding-left:31px;clear: both;float: left; width:100%;color:green;font-size:15px;"><?php echo $message; ?></p>
	<?php } ?>
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				<div class="option">
					<form name="chngordertype" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="page" value="chngorderstatus" />					
						<table class="form-table virtue-table">
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="ordertype_id">Enter Order ID:</label></th>
								<td><input type="text" id="ordertype_id" name="ordertype_id" value="" class="regular-text" required /></td>
							</tr>
							<tr class="user-rich-editing-wrap">
								<th scope="row"><label for="payment-method">Payment Method</label></th>
								<td>
									<fieldset>
										<legend class="screen-reader-text"><span>Select Payment Method</span></legend>
										<label for="cod"><input name="payment_st" type="radio" id="cod" value="0">COD</label>
									</fieldset>
									<fieldset>
										<label for="razorpay"><input name="payment_st" type="radio" id="razorpay" value="1">Razorpay</label>
									</fieldset>
								</td>
							</tr>
						</table>
						<p class="submit"><input type="submit" name="ordertypesubmit" id="ordertypesubmit" class="button button-primary" value="Submit"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>