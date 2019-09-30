<?php
global $wpdb;
$log_changed_order_pm = $wpdb->prefix . "log_changed_order_pm";
$log_order_details = $wpdb->get_results("SELECT * FROM $log_changed_order_pm");
?>
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">View Order Payment Method Log</h2>
					
					<table class="virtue-table" border="1" cellpadding="1" cellspacing="1">
							<tr class="user-rich-editing-wrap">
								<th><label for="ordertype_id">Order ID</label></th>
								<th><label for="ordertype_id">Change from payment method</label></th>
								<th><label for="ordertype_id">Change to payment method</label></th>
								<th><label for="ordertype_id">Date - Time</label></th>
							</tr>
					<?php 
						if(sizeof($log_order_details)) {
						foreach($log_order_details as $log_order_detail) {	
					?>
							<tr>
								<td><?php echo $log_order_detail->order_id; ?></td>
								<td><?php echo $log_order_detail->change_from; ?></td>
								<td><?php echo $log_order_detail->change_to; ?></td>
								<td><?php echo $log_order_detail->changed_date; ?></td>
							</tr>
						<?php } } ?>
							
						</table>
	