<?php 
global $wpdb;
if(isset($_REQUEST['order_id'])) {  
	$order_id = $_REQUEST['order_id'];
	$kidsname = isset($_REQUEST['bu_name'])?$_REQUEST['bu_name']:'';
	$gender = isset($_REQUEST['bu_gender'])?$_REQUEST['bu_gender']:'';
	$kidsname = trim(ucfirst(strtolower($kidsname)));
	
	if($gender == "Boy"){
		$pageImage = plugin_dir_path(__FILE__).'/images/boy_final.jpg';
	}else{
		$pageImage = plugin_dir_path(__FILE__).'/images/girl_final.jpg';
	} 
	ob_clean(); 
	require('fpdf/fpdf.php');
	$pdf = new FPDF('p','mm',array(250,371.73));
	$pdf->SetAutoPageBreak(false,0);
	$pdf->Addpage('l');
	$sizeImage = getimagesize($pageImage);
	$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
	$str = strtoupper($kidsname);
	$imageSize = getimagesize($pageImage);
	$sizeX =  $imageSize[0];
	$sizeY =  $imageSize[1];
	$ratio = $sizeX/$sizeY;
	$width = 300;
	$height = 300/$ratio;
	$pdf->SetFont('P22Wedge-Bold','',19);
	$pdf->SetTextColor(0,0,0);
	//$pdf->Image($pageImage,30,25,$width,$height,'JPG');
	$pdf->Text(68.2,111,$str); 
	$pdf->Output('front_cover.pdf', 'D');

 } 
?>
