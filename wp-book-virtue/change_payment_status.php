<?php 
global $wpdb;
$message = '';
if(isset($_REQUEST['pay_type']) && isset($_REQUEST['pay_status']) && isset($_REQUEST['order_id'])) {
	$pay_type = ($_REQUEST['pay_type'] != '') ? $_REQUEST['pay_type'] : '' ;
	$pay_status = ($_REQUEST['pay_status'] != '') ? $_REQUEST['pay_status'] : '' ;
	$order_id = ($_REQUEST['order_id'] != '') ? $_REQUEST['order_id'] : '' ;
	if($pay_type != '' && $pay_status != '' && $order_id != '' ){
		$order = new WC_Order($order_id);
		$items = $order->get_items();
		foreach ($items as $item_id => $item) {
			$custom_pay_status = wc_get_order_item_meta( $item_id, 'custom_pay_status', true );
			$paytm = get_post_meta($order_id,'_payment_method',true);
			if($paytm == 'custom-cod' && ($custom_pay_status == '0' || !$custom_pay_status)){
				wc_update_order_item_meta( $item_id, 'custom_pay_status', '1');
				
				
				$html = '<!DOCTYPE html><html lang="en-US">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
					<title>Superkid\'s League</title>
				</head>
				<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
					<div id="wrapper" dir="ltr" style="background-color: #f7f7f7; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%;">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
							<tr>
								<td align="center" valign="top">
									<div id="template_header_image">
									</div>
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #ffffff; border: 1px solid #dedede; border-radius: 3px !important;">
										<tr>
											<td align="center" valign="top">
												<!-- Header -->
												<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #82AF39; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">
													<tr>
														<td id="header_wrapper" style="padding: 36px 48px; display: block;">
															<h1 style="color: #ffffff; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #ab79a1; -webkit-font-smoothing: antialiased;">Thank you for payment</h1>
														</td>
													</tr>
												</table>
												<!-- End Header -->
											</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<!-- Body -->
												<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
													<tr>
														<td valign="top" id="body_content" style="background-color: #ffffff;">
															<!-- Content -->
															<table border="0" cellpadding="20" cellspacing="0" width="100%">
																<tr>
																	<td valign="top" style="padding: 48px;">
																		<div id="body_content_inner" style="color: #636363; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">

																		<h2 style="color: #96588a; display: block; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: left;">Order #'.$order_id.'</h2>

																		<p>Your Paytm payment has been received. We thanks your placing order with us. Your kid\'s book will reach you soon</p>
																		</div>
																	</td>
																</tr>
															</table>
															<!-- End Content -->
														</td>
													</tr>
												</table>
												<!-- End Body -->
											</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<!-- Footer -->
												<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
													<tr>
														<td valign="top" style="padding: 0; -webkit-border-radius: 6px;">
															<table border="0" cellpadding="10" cellspacing="0" width="100%">
																<tr>
																	<td colspan="2" valign="middle" id="credit" style="padding: 0 48px 48px 48px; -webkit-border-radius: 6px; border: 0; color: #c09bb9; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;">
																		<p>Little Einstein</p>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
												<!-- End Footer -->
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</body>
				</html>';

				$to = $toemail;
				$subject = "Order #$order_id : Payment Confirmation";
				$headers = 'From: Little Einstein <contact@superkidsleague.com>' . "\r\n";
			    $headers .= "MIME-Version: 1.0\r\n";
			    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$message = $html;

				$ok = wp_mail( $to, $subject, $message, $headers );
				$phone = $order->get_billing_phone();
				if($phone != ''){
					$msg = urlencode("Your Paytm payment has been received. We thanks your placing order with us. Your kid's book will reach you soon");							
					$newurl = 'http://sms.infisms.co.in/API/SendSMS.aspx?UserID=Abbacus&UserPassword=abbacus@123&SenderId=SUPKID&PhoneNumber='.$phone.'&AccountType=2&Text=' . $msg;
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $newurl);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec($curl);
					curl_close($curl);
				}
				
			}
		}
	}
}
$paged='';
if(isset($_REQUEST['paged'])){
	$paged="&paged=".$_REQUEST['paged'];
}

?>
<div style="float: left; width: 100%;">
	<h2 style="padding: 10px; margin: 20px; float: left; width: 50%;">Change Payment Status</h2>	
	<div role="main" id="wpbody" style="border: 1px solid rgb(196, 196, 196); padding: 10px; margin: 20px; float: left; width: 50%;">
		<div tabindex="0" aria-label="Main content" id="wpbody-content">
			<div class="wrap">
				<div class="option">
					<strong>Are you sure to change payment status for #<?php echo isset($order_id) ? $order_id : ''; ?>? </strong>
					<a href="<?php echo 'edit.php?post_type=shop_order'.$paged; ?>">YES</a>
				</div>
			</div>
		</div>
	</div>
</div>