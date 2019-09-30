<?php 
$order_status = array('wc-pending'=>'pending', 'wc-completed'=>'completed', 'wc-neworder'=>'new order', 'wc-processing-three'=>'processing', 'wc-processing-two'=>'processing', 'wc-shipped'=>'shipped', 'wc-cancelled'=>'cancelled', 'wc-processing'=>'processing', 'wc-failed'=>'failed');
if( isset($_POST['exprsexportorder'])){
	if(isset($_POST['order_ids']) && $_POST['order_ids'] !=''){
		
		$order_ids = $_POST['order_ids'];
		$order_ids = str_replace(array("\n", "\r\n"), ",", $order_ids);		
		global $wpdb;	
		ob_end_clean();
		$startdate = isset($_POST['startdate'])?$_POST['startdate']:'';
		$enddate = isset($_POST['enddate'])?$_POST['enddate']:'';
		$filename = "orders.csv";
		$fp = fopen('php://output', 'w');

		$header = array('OrderType','OrderStatus','NetPayment','POID','ShippingID','ShippingReferenceNo','ShipName','ShipAddress','ShipCity','ShipMobileNo','MobileNo2','ShipPinCode','ShipState','ServiceType','PhysicalWeight','Instructions','OctroiMRP','ProductInfo','RTOAddress','RTOPinCode','RTOName','RTOCity','InvoiceNumber','SellerName','SellerAddress','IsSellerRegUnderGST','SellerGSTRegNumber','SupplyStatePlace','EWayBillSrNumber','BuyerGSTRegNumber','HSNCode','TaxableValue','CGSTAmount','IGSTAmount');

			fputcsv($fp, $header);
			$order_id_in = '';
			if($order_ids != ''){
				$order_id_in = "i.ID IN (".$order_ids.")";
			}
			
			$sql = "select
				i.ID as order_id,
				i.post_status as post_status, i.post_excerpt as post_excerpt,
				max( CASE WHEN im.meta_key = '_paid_date' and i.ID = im.post_id THEN im.meta_value END ) as _paid_date,
				max( CASE WHEN pm.meta_key = 'Name' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Name,
				max( CASE WHEN pm.meta_key = 'Gender' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Gender,
				max( CASE WHEN im.meta_key = '_billing_first_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_first_name,
				max( CASE WHEN im.meta_key = '_billing_last_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_last_name,
				max( CASE WHEN im.meta_key = '_billing_address_1' and i.ID = im.post_id THEN im.meta_value END ) as _billing_address_1,
				max( CASE WHEN im.meta_key = '_billing_address_2' and i.ID = im.post_id THEN im.meta_value END ) as _billing_address_2,
				max( CASE WHEN im.meta_key = '_billing_city' and i.ID = im.post_id THEN im.meta_value END ) as _billing_city,
				max( CASE WHEN im.meta_key = '_billing_state' and i.ID = im.post_id THEN im.meta_value END ) as _billing_state,
				max( CASE WHEN im.meta_key = '_billing_postcode' and i.ID = im.post_id THEN im.meta_value END ) as _billing_postcode,
				max( CASE WHEN im.meta_key = '_billing_street_address' and i.ID = im.post_id THEN im.meta_value END ) as _billing_street_address,
				max( CASE WHEN im.meta_key = '_billing_house_number' and i.ID = im.post_id THEN im.meta_value END ) as _billing_house_number,
				max( CASE WHEN im.meta_key = '_billing_landmark' and i.ID = im.post_id THEN im.meta_value END ) as _billing_landmark,
				max( CASE WHEN im.meta_key = '_billing_phone' and i.ID = im.post_id THEN im.meta_value END ) as _billing_phone,
				max( CASE WHEN im.meta_key = '_billing_landline' and i.ID = im.post_id THEN im.meta_value END ) as _billing_landline,
				max( CASE WHEN im.meta_key = '_payment_method' and i.ID = im.post_id THEN im.meta_value END ) as _payment_method,
				max( CASE WHEN im.meta_key = '_order_total' and i.ID = im.post_id THEN im.meta_value END ) as subtotal
				from
				wp_posts as i,
				wp_woocommerce_order_items as p,
				wp_postmeta as im,
				wp_woocommerce_order_itemmeta as pm
				 where order_item_type = 'line_item' and
				 p.order_item_id = pm.order_item_id and
				 i.ID = im.post_id and 
				 i.ID = p.order_id and
				 ".$order_id_in."
				 group by
				p.order_item_id";	
				
				$result = $wpdb->get_results($sql) or die(mysql_error());
				foreach($result as $row){
				$hardBoundCover = $wpdb->get_results("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE (order_item_name = 'Hard bound cover' AND order_id = '". $row->order_id ."')");
				$hardBoundWeight = $hardBoundCover[0]->order_item_name;
				if($hardBoundWeight == 'Hard bound cover'){
					$weight = '0.75';
				}else{
					$weight = '0.40';
				}
				$alllogs = array();	
				
				$payment_method = 'COD';
				if($row->_payment_method == 'razorpay')
				{
					$payment_method = 'Prepaid';

				}
				if($row->_payment_method == 'razorpay' || $row->_payment_method == 'custom-cod' || $row->_payment_method == 'paytm')
				{
					$row->subtotal = '0';
				}
				
				if($row->_payment_method == 'paytm')
				{
					$payment_method = 'Prepaid';

				}	
				if($row->_payment_method == 'custom-cod')
				{
					$payment_method = 'Prepaid';

				}				
					
				$post_status = isset($order_status[$row->post_status]) ? $order_status[$row->post_status] : '';
				$address = '';
				$address .= ($row->_billing_address_1 != '') ? $row->_billing_address_1.', ' : '';
				$address .= ($row->_billing_address_2 != '') ? $row->_billing_address_2.', ' : '';
				$address .= ($row->_billing_street_address != '') ? $row->_billing_street_address.', ' : '';
				$address .= ($row->_billing_house_number != '') ? $row->_billing_house_number.', ' : '';
				$address .= ($row->_billing_landmark != '') ? $row->_billing_landmark.', ' : '';
				$address .= ($row->_billing_city != '') ? $row->_billing_city.', ' : '';
				$address .= ($row->_billing_state != '') ? $row->_billing_state.', ' : '';
				$address .= ($row->_billing_postcode != '') ? $row->_billing_postcode : '';
				
				$parent_fname = trim($row->_billing_first_name);
				$parent_lname = trim($row->_billing_last_name);
				$parent_lname = ($parent_lname != '') ? ' '.$parent_lname : '';
				$pname = $parent_fname.$parent_lname;
						
				array_push($alllogs,$payment_method,$post_status,$row->subtotal,$row->order_id,'',$row->order_id,$pname,$address,$row->_billing_city,$row->_billing_phone,$row->_billing_landline,$row->_billing_postcode,$row->_billing_state,'AIR',$weight,$row->post_excerpt,$row->subtotal,'Children Book '. $row->Name,'Team Super Kids League,203, Kashiparekh Complex, Opp City Center,Swastik Cross Road, Navrangpura, Ahmedabad, Gujarat -380009','380009','BRIGHTFOX LEARNING SOLUTIONS LLP','Ahmedabad',$row->order_id,'BRIGHTFOX LEARNING SOLUTIONS LLP','Team Super Kids League,203, Kashiparekh Complex, Opp City Center,Swastik Cross Road, Navrangpura, Ahmedabad, Gujarat -380009','1','24AASFB4078P1ZQ ','Gujarat','0','0','4903','0','0','0');		
					fputcsv($fp, $alllogs);
				}
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$filename);	

		exit;
	}else{
		global $wpdb;	
		ob_end_clean();
		$startdate = isset($_POST['startdate'])?$_POST['startdate']:'';
		$enddate = isset($_POST['enddate'])?$_POST['enddate']:'';
		$filename = $startdate."-".$enddate.".csv";
		$fp = fopen('php://output', 'w');

		$header = array('OrderType','NetPayment','POID','ShippingID','ShippingReferenceNo','ShipName','ShipAddress','ShipCity','ShipMobileNo','MobileNo2','ShipPinCode','ShipState','ServiceType','PhysicalWeight','Instructions','OctroiMRP','ProductInfo','RTOAddress','RTOPinCode','RTOName','RTOCity','InvoiceNumber','SellerName','SellerAddress','IsSellerRegUnderGST','SellerGSTRegNumber','SupplyStatePlace','EWayBillSrNumber','BuyerGSTRegNumber','HSNCode','TaxableValue','CGSTAmount','IGSTAmount');

			fputcsv($fp, $header);
			$daterange = '';
			if($startdate != '' && $enddate != ''){
				$daterange = "i.post_date BETWEEN '".$startdate."' AND '".$enddate."'";
			}else if($startdate != ''){
				$daterange = "i.post_date LIKE '".$startdate."%'";
			}
			
			    $sql = "select
				i.ID as order_id,
                i.post_status as post_status, i.post_excerpt as post_excerpt,
				max( CASE WHEN im.meta_key = '_paid_date' and i.ID = im.post_id THEN im.meta_value END ) as _paid_date,
				max( CASE WHEN pm.meta_key = 'Name' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Name,
				max( CASE WHEN pm.meta_key = 'Gender' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Gender,
				max( CASE WHEN im.meta_key = '_billing_first_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_first_name,
				max( CASE WHEN im.meta_key = '_billing_last_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_last_name,
				max( CASE WHEN im.meta_key = '_billing_address_1' and i.ID = im.post_id THEN im.meta_value END ) as _billing_address_1,
				max( CASE WHEN im.meta_key = '_billing_address_2' and i.ID = im.post_id THEN im.meta_value END ) as _billing_address_2,
				max( CASE WHEN im.meta_key = '_billing_city' and i.ID = im.post_id THEN im.meta_value END ) as _billing_city,
				max( CASE WHEN im.meta_key = '_billing_state' and i.ID = im.post_id THEN im.meta_value END ) as _billing_state,
				max( CASE WHEN im.meta_key = '_billing_postcode' and i.ID = im.post_id THEN im.meta_value END ) as _billing_postcode,
				max( CASE WHEN im.meta_key = '_billing_street_address' and i.ID = im.post_id THEN im.meta_value END ) as _billing_street_address,
				max( CASE WHEN im.meta_key = '_billing_house_number' and i.ID = im.post_id THEN im.meta_value END ) as _billing_house_number,
				max( CASE WHEN im.meta_key = '_billing_landmark' and i.ID = im.post_id THEN im.meta_value END ) as _billing_landmark,
				max( CASE WHEN im.meta_key = '_billing_phone' and i.ID = im.post_id THEN im.meta_value END ) as _billing_phone,
				max( CASE WHEN im.meta_key = '_billing_landline' and i.ID = im.post_id THEN im.meta_value END ) as _billing_landline,
				max( CASE WHEN im.meta_key = '_payment_method' and i.ID = im.post_id THEN im.meta_value END ) as _payment_method,
				max( CASE WHEN im.meta_key = '_order_total' and i.ID = im.post_id THEN im.meta_value END ) as subtotal
				from
				wp_posts as i,
				wp_woocommerce_order_items as p,
				wp_postmeta as im,
				wp_woocommerce_order_itemmeta as pm
				 where order_item_type = 'line_item' and
				 p.order_item_id = pm.order_item_id and
				 i.ID = im.post_id and 
				 i.ID = p.order_id and
				 ".$daterange."
				 group by
				p.order_item_id";	
				
				$result = $wpdb->get_results($sql) or die(mysql_error());
				foreach($result as $row){
				$hardBoundCover = $wpdb->get_results("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE (order_item_name = 'Hard bound cover' AND order_id = '". $row->order_id ."')");
				$hardBoundWeight = $hardBoundCover[0]->order_item_name;
				if($hardBoundWeight == 'Hard bound cover'){
					$weight = '0.75';
				}else{
					$weight = '0.40';
				}
				$alllogs = array();	
				
				$payment_method = 'COD';
				if($row->_payment_method == 'razorpay')
				{
					$payment_method = 'Prepaid';

				}
				if($row->_payment_method == 'razorpay' || $row->_payment_method == 'custom-cod' || $row->_payment_method == 'paytm')
				{
					$row->subtotal = '0';
				}
				
				if($row->_payment_method == 'custom-cod')
				{
					$payment_method = 'Paytm';

				}
				
				if($row->_payment_method == 'paytm')
				{
					$payment_method = 'Prepaid';

				}
				$post_status = isset($order_status[$row->post_status]) ? $order_status[$row->post_status] : '';
				$address = '';
				$address .= ($row->_billing_address_1 != '') ? $row->_billing_address_1.', ' : '';
				$address .= ($row->_billing_address_2 != '') ? $row->_billing_address_2.', ' : '';
				$address .= ($row->_billing_street_address != '') ? $row->_billing_street_address.', ' : '';
				$address .= ($row->_billing_house_number != '') ? $row->_billing_house_number.', ' : '';
				$address .= ($row->_billing_landmark != '') ? $row->_billing_landmark.', ' : '';
				$address .= ($row->_billing_city != '') ? $row->_billing_city.', ' : '';
				$address .= ($row->_billing_state != '') ? $row->_billing_state.', ' : '';
				$address .= ($row->_billing_postcode != '') ? $row->_billing_postcode : '';
				
				$parent_fname = trim($row->_billing_first_name);
				$parent_lname = trim($row->_billing_last_name);
				$parent_lname = ($parent_lname != '') ? ' '.$parent_lname : '';
				$pname = $parent_fname.$parent_lname;
				
				array_push($alllogs,$payment_method,$post_status,$row->subtotal,$row->order_id,'',$row->order_id,$pname,$address,$row->_billing_city,$row->_billing_phone,$row->_billing_landline,$row->_billing_postcode,$row->_billing_state,'AIR',$weight,$row->post_excerpt,$row->subtotal,'Children Book '. $row->Name,'Team Super Kids League,203, Kashiparekh Complex, Opp City Center,Swastik Cross Road, Navrangpura, Ahmedabad, Gujarat -380009','380009','BRIGHTFOX LEARNING SOLUTIONS LLP','Ahmedabad',$row->order_id,'BRIGHTFOX LEARNING SOLUTIONS LLP','Team Super Kids League,203, Kashiparekh Complex, Opp City Center,Swastik Cross Road, Navrangpura, Ahmedabad, Gujarat -380009','1','24AASFB4078P1ZQ ','Gujarat','0','0','4903','0','0','0');		
					fputcsv($fp, $alllogs);
				}
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$filename);	

		exit;
	}
}
if( isset($_POST['exprsexportdoc'])){
	ob_get_clean();
	if(isset($_POST['order_ids']) && $_POST['order_ids'] !=''){
		
		global $wpdb;	
		$order_ids = $_POST['order_ids'];
		$order_ids = str_replace(array("\n", "\r\n"), ",", $order_ids);		
		$filename = "orders.doc";
		
		header('Content-Type: application/vnd.msword; charset=utf-8');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Content-Disposition: attachment; filename='.$filename);	
			$order_id_in = '';
			if($order_ids != ''){
				$order_id_in = "i.ID IN (".$order_ids.")";
			}
			
			 $sql = "select
				i.ID as order_id,
				max( CASE WHEN pm.meta_key = 'Name' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Name
				from
				wp_posts as i,
				wp_woocommerce_order_items as p,
				wp_postmeta as im,
				wp_woocommerce_order_itemmeta as pm
				 where order_item_type = 'line_item' and
				 p.order_item_id = pm.order_item_id and
				 i.ID = im.post_id and 
				 i.ID = p.order_id and
				 ".$order_id_in."
				 group by
				p.order_item_id";
				
				
				$result = $wpdb->get_results($sql) or die(mysql_error());
				echo "<html><meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
				echo "<body>";
				foreach($result as $row){
				
				
					echo "<p style='font-size:66.5px;font-family:calibri;text-align:center;font-weight:bold;margin-top:85px;'>GIFT FOR ". strtoupper($row->Name) ."</p><br />";
					
				}
				echo"</body>";
				echo"</html>";
		

		exit;
	} else {
		global $wpdb;	
		
		$startdate = isset($_POST['startdate'])?$_POST['startdate']:'';
		$enddate = isset($_POST['enddate'])?$_POST['enddate']:'';
		$filename = $startdate."-".$enddate.".doc";
		header('Content-Type: application/vnd.msword; charset=utf-8');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Content-Disposition: attachment; filename='.$filename);	

			$daterange = '';
			if($startdate != '' && $enddate != ''){
				$daterange = "i.post_date BETWEEN '".$startdate."' AND '".$enddate."'";
			}else if($startdate != ''){
				$daterange = "i.post_date LIKE '".$startdate."%'";
			}
			
			$sql = "select
				i.ID as order_id,
				max( CASE WHEN pm.meta_key = 'Name' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Name
				from
				wp_posts as i,
				wp_woocommerce_order_items as p,
				wp_postmeta as im,
				wp_woocommerce_order_itemmeta as pm
				 where order_item_type = 'line_item' and
				 p.order_item_id = pm.order_item_id and
				 i.ID = im.post_id and 
				 i.ID = p.order_id and
				 ".$daterange."
				 group by
				p.order_item_id";	
				
				$result = $wpdb->get_results($sql) or die(mysql_error());
				echo "<html><meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
				echo "<body>";
				foreach($result as $row){
				
					echo "<p style='font-size:66.5px;font-family:calibri;text-align:center;font-weight:bold;margin-top:85px;'>GIFT FOR ". strtoupper($row->Name) ."</p><br />";
				
				}
				echo"</body>";
				echo"</html>";
		exit;
	}
}
?>