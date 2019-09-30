<?php

if( isset($_POST['ordertypesubmit'])){
	
	if(isset($_POST['ordertype_id']) && $_POST['ordertype_id'] !=''){	
		global $wpdb;
		$log_changed_order_pm = $wpdb->prefix . "log_changed_order_pm";
		$ordertype_id = $_POST['ordertype_id'];
		$selected_method = $_POST['payment_st'];
		$message = '';
		
		$woocommerce_cod_extra_charges = get_option('woocommerce_cod_extra_charges')?get_option('woocommerce_cod_extra_charges'):0;
		
		$old_order_total = get_post_meta($ordertype_id,'_order_total',true);
		$old_payment_method = get_post_meta($ordertype_id,'_payment_method',true);
		
		/*start*/
		if($old_payment_method != 'cod' && $old_order_total == 699){
			$woocommerce_cod_extra_charges = 85;
		}else if($old_payment_method == 'cod' && $old_order_total == 784){
			$woocommerce_cod_extra_charges = 85;
		}
		
		if($old_payment_method == 'custom-cod' && $selected_method == 1){
			$woocommerce_cod_extra_charges = 0;
		}
		
		if($old_payment_method == 'razorpay' && $selected_method == 2){
			$woocommerce_cod_extra_charges = 0;
		}
		/*end*/
		if($selected_method == '0' && $old_payment_method)
		{
			if($old_payment_method == 'cod'){
				$message = "Order ID ". $ordertype_id ." has already COD.";
			}else{
				update_post_meta( $ordertype_id, '_payment_method', 'cod');
				update_post_meta( $ordertype_id, '_payment_method_title', 'Cash on delivery (Extra charge : Rs. 45)');
				$old_order_total = get_post_meta($ordertype_id,'_order_total',true);
				$old_order_total = $old_order_total + $woocommerce_cod_extra_charges;
				update_post_meta( $ordertype_id, '_order_total', $old_order_total);
				//insert log
				$wpdb->insert($log_changed_order_pm, array(
							'order_id' =>$ordertype_id,
							'change_from' => $old_payment_method,
							'change_to' => 'cod', 
						));
				$message = "Order ID ". $ordertype_id ." payment method has been successfully changed to COD";
			}
				
		}else if($selected_method == '1' && $old_payment_method){
			if($old_payment_method == 'razorpay'){
				$message = "Order ID ". $ordertype_id ." has already Razorpay.";
			}else{
				update_post_meta( $ordertype_id, '_payment_method', 'razorpay');
				update_post_meta( $ordertype_id, '_payment_method_title', 'Credit Card/Debit Card/NetBanking');
				$old_order_total = get_post_meta($ordertype_id,'_order_total',true);
				$old_order_total = $old_order_total - $woocommerce_cod_extra_charges;
				update_post_meta( $ordertype_id, '_order_total', $old_order_total);
				//insert log
				$wpdb->insert($log_changed_order_pm, array(
							'order_id' =>$ordertype_id,
							'change_from' => $old_payment_method,
							'change_to' => 'razorpay',
					    ));
				$message = "Order ID ". $ordertype_id ." payment method has been successfully changed to Razorpay";
			}
		}else if($selected_method == '2' && $old_payment_method){
			if($old_payment_method == 'custom-cod'){
				$message = "Order ID ". $ordertype_id ." has already Paytm.";
			}else{
				update_post_meta( $ordertype_id, '_payment_method', 'custom-cod');
				update_post_meta( $ordertype_id, '_payment_method_title', 'Paytm');
				$old_order_total = get_post_meta($ordertype_id,'_order_total',true);
				$old_order_total = $old_order_total - $woocommerce_cod_extra_charges;
				update_post_meta( $ordertype_id, '_order_total', $old_order_total);
				//insert log
				$wpdb->insert($log_changed_order_pm, array(
							'order_id' =>$ordertype_id,
							'change_from' => $old_payment_method,
							'change_to' => 'Paytm',
					    ));
				$message = "Order ID ". $ordertype_id ." payment method has been successfully changed to Paytm";
			}
		}else{
			$message = "Order ID ". $ordertype_id ." does not exist!";
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
								<th scope="row"><label for="payment-method">Change to:</label></th>
								<td>
									<fieldset>
										<legend class="screen-reader-text"><span>Select Payment Method</span></legend>
										<label for="cod"><input name="payment_st" type="radio" id="cod" value="0">COD</label>
									</fieldset>
									<fieldset>
										<label for="razorpay"><input name="payment_st" type="radio" id="razorpay" value="1">Razorpay</label>
									</fieldset>
									<fieldset>
										<label for="paytm"><input name="payment_st" type="radio" id="paytm" value="2">Paytm</label>
									</fieldset>
								</td>
							</tr>
						</table>
						<p class="submit"><input type="submit" name="ordertypesubmit" id="ordertypesubmit" onclick="return validate();" class="button button-primary" value="Submit"></p>
					</form>
				</div>
				<div>
					<table class="form-table virtue-table">
						<tr class="user-rich-editing-wrap">
							<th scope="row"><label for="check_log">Check Order Log :</label></th>
							<td><a href="<?php echo get_admin_url(). 'admin.php?page=check_opm_log' ?>" target="_blank">Previous Log</a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function validate()
{
	var obj=document.chngordertype;
	
	if(obj.ordertype_id.value=='')
     {
	    alert("Please enter order ID.");
	    obj.ordertype_id.focus();
	    return false;
	 }
	 var coexp = /^[0-9]+$/;
     if(!obj.ordertype_id.value.match(coexp))
    {
        alert('Please enter only number');
        ordertype_id.focus();
        return false;
    }
	if(obj.payment_st.value=='')
     {
	    alert("Please choose payment method.");
	    return false;
	 }
}
</script>