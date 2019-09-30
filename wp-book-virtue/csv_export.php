	<?php 
$order_status = array('wc-pending'=>'pending', 'wc-completed'=>'completed', 'wc-neworder'=>'new order', 'wc-processing-three'=>'processing', 'wc-processing-two'=>'processing', 'wc-shipped'=>'shipped', 'wc-cancelled'=>'cancelled', 'wc-processing'=>'processing', 'wc-failed'=>'failed');
if( isset($_POST['exportorder'])){
global $wpdb;	
ob_end_clean();

$order_ids = $_POST['order_ids'];
$order_ids = str_replace(array("\n", "\r\n"), ",", $order_ids);		
		
$startdate = isset($_POST['startdate'])?$_POST['startdate']:'';
$enddate = isset($_POST['enddate'])?$_POST['enddate']:'';
$filename = $startdate."-".$enddate.".csv";
$fp = fopen('php://output', 'w');
/* $header = array('Order#','Order Status','Order Date','Kids Photo','Kids Name','Kids Name (capital)','Gender','Payment Method','Cost','Address','Phone Number','Secondary Mobile Number','Email','Personalised details','Special Notes'); */


$header = array('Order#','Order Date','Order Status','Hard Bound','Urgent Delivery','Kids Photo','Kids Name','Kids Name (capital)','Gender','Address','Email','Secondary Email Number','Phone Number','Secondary Mobile Number','Payment Method','Cost','Personalised details','Special Notes');
//$header = 'subpagevisited';


fputcsv($fp, $header);
	$daterange = '';
	if($startdate != '' && $enddate != '' && $startdate != $enddate){
		$daterange = "date(i.post_date) BETWEEN '".$startdate."' AND '".$enddate."'";
	}else if($startdate != ''){
		$daterange = "date(i.post_date) LIKE '".$startdate."%'";
	}else if($startdate != '' && $startdate == $enddate){
		$daterange = "date(i.post_date) LIKE '".$startdate."%'";
	}
	
	$order_id_in = '';
	if($order_ids != ''){
		$order_id_in = "i.ID IN (".$order_ids.")";
	}
	
	if($order_id_in != ''){
		$sql = "select
		i.ID as order_id,
        i.post_status as post_status,
		i.post_excerpt as special_notes,
		max( CASE WHEN im.meta_key = '_paid_date' and i.ID = im.post_id THEN im.meta_value END ) as _paid_date,
		max( CASE WHEN im.meta_key = '_kidsphoto' and i.ID = im.post_id THEN im.meta_value END ) as _kidsphoto,
		max( CASE WHEN pm.meta_key = 'Name' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Name,
		max( CASE WHEN pm.meta_key = 'Gender' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Gender,
		max( CASE WHEN im.meta_key = '_billing_first_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_first_name,
		max( CASE WHEN im.meta_key = '_billing_last_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_last_name,
		max( CASE WHEN im.meta_key = '_billing_email' and i.ID = im.post_id THEN im.meta_value END ) as _billing_email,
		max( CASE WHEN im.meta_key = '_billing_secondry_email' and i.ID = im.post_id THEN im.meta_value END ) as _billing_secondry_email,
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
		max( CASE WHEN im.meta_key = '_special_message' and i.ID = im.post_id THEN im.meta_value END ) as _special_message,
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
		
		
		$filename = "orders.csv";
		
	}else{
		$sql = "select
		i.ID as order_id,
          i.post_status as post_status,
		i.post_excerpt as special_notes,
		max( CASE WHEN im.meta_key = '_paid_date' and i.ID = im.post_id THEN im.meta_value END ) as _paid_date,
		max( CASE WHEN im.meta_key = '_kidsphoto' and i.ID = im.post_id THEN im.meta_value END ) as _kidsphoto,
		max( CASE WHEN pm.meta_key = 'Name' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Name,
		max( CASE WHEN pm.meta_key = 'Gender' and p.order_item_id = pm.order_item_id THEN pm.meta_value END ) as Gender,
		max( CASE WHEN im.meta_key = '_billing_first_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_first_name,
		max( CASE WHEN im.meta_key = '_billing_last_name' and i.ID = im.post_id THEN im.meta_value END ) as _billing_last_name,
		max( CASE WHEN im.meta_key = '_billing_email' and i.ID = im.post_id THEN im.meta_value END ) as _billing_email,
		max( CASE WHEN im.meta_key = '_billing_secondry_email' and i.ID = im.post_id THEN im.meta_value END ) as _billing_secondry_email,
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
		max( CASE WHEN im.meta_key = '_special_message' and i.ID = im.post_id THEN im.meta_value END ) as _special_message,
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
	}
		
		
		$result = $wpdb->get_results($sql) or die(mysql_error());
		foreach($result as $row){
		$hardBoundCover = $wpdb->get_results("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE (order_item_name = 'Hard bound cover' AND order_id = '". $row->order_id ."')");

		$urgentDeliveryCharge = $wpdb->get_results("SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE (order_item_name = 'Urgent Delivery Charge' AND order_id = '". $row->order_id ."')");
		$urgentDelivery = $urgentDeliveryCharge[0]->order_item_name;
		if($urgentDelivery == 'Urgent Delivery Charge'){
			$deliveryMode = "Yes";
		}else{
			$deliveryMode = "No";
		}
		$hardBoundRecord = $hardBoundCover[0]->order_item_name;
		if($hardBoundRecord == 'Hard bound cover'){
			$hardBound = "Yes";
		}else{
			$hardBound = "No";
		}
		$alllogs = array();
		if($row->_kidsphoto != ""){
			$photo = $row->_kidsphoto;
		}else{
			$photo = "NO";
		}
		if($row->_special_message != ""){
			$personal = $row->_special_message;
		}else{
			$personal = '"To Our World!"';
		}
		
		$parentname = trim(strtolower($row->_billing_first_name.' '.$row->_billing_last_name));
		$parentname = strtoupper($parentname);
		
		$Name = trim(strtolower($row->Name));
		$Name = strtoupper($Name);
		
		$payment_method = $row->_payment_method;
		if($payment_method == 'custom-cod'){
			$payment_method = 'paytm';
		}
		$post_status = isset($order_status[$row->post_status]) ? $order_status[$row->post_status] : '';
        
        array_push(
        $alllogs,
        $row->order_id,
        $row->_paid_date,
        $post_status,
		$hardBound,
		$deliveryMode,
        $photo,
        $row->Name,
        $Name,
        $row->Gender,
        trim($parentname."\r\n".$row->_billing_address_1."\r\n".$row->_billing_address_2."\r\n".$row->_billing_city."\r\n".$row->_billing_state."\r\n".$row->_billing_postcode."\r\nLandmark: ".$row->_billing_landmark),
        $row->_billing_email,
        $row->_billing_secondry_email,
        $row->_billing_phone,
        $row->_billing_landline,
        $payment_method,
        $row->subtotal,
        $personal,
        $row->special_notes);	
			fputcsv($fp, $alllogs);
		}
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$filename);	

exit;
}
?>