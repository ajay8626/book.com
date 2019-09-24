<?php 
global $wpdb;
$bu_name_str = '';
$order_id = '';
if(isset($_REQUEST['bu_name'])){
	$bu_name_str = $_REQUEST['bu_name'];
	$order_id = isset($_REQUEST['order_id'])?$_REQUEST['order_id']:'';
	$bu_name_str = trim(ucwords(strtolower($bu_name_str)));
}

$dir = plugin_dir_path( __FILE__ );	
if($bu_name_str != ''){
	ob_clean(); 
	require($dir.'fpdf/fpdf.php');
	$kidsname = $bu_name_str;
	
	$pdf = new FPDF('p','cm',array(37.5,24.7));
	$pdf->Addpage('l');
	$pdf->AddFont('P22Wedge','','P22Wedge.php');
	$pdf->AddFont('P22Wedge-Bold','','P22Wedge-Bold.php');
	$pdf->SetFont('P22Wedge-Bold','',20.5);
	/* $pdf->SetXY(16.584,3.2); */
	/*$pdf->Write(5,'Dear '.$kidsname.',');*/
	$pdf->Cell(0,10,'Dear '.$kidsname.',',0,0,'C');
	$pdf->SetFont('P22Wedge-Bold','',17.5);
	$pdf->SetXY(14.55,4.98);
	$pdf->Write(5,'This is Your Book,Your Story.');
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->SetXY(10,6.91);
	$pdf->Write(5,'This is not just a book but a ');
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->Write(5,'MEMORY ');
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5,'for a lifetime created by people');
	$pdf->SetXY(14.40,7.82);
	$pdf->Write(5,'who love you most in this world.');
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->SetXY(13.63,8.7);
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->SetXY(11,8.7);
	$pdf->Write(5,"Do you know that you have ");
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->Write(5,"SUPERPOWERS");
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5," within you?");
	$pdf->SetXY(9.03,9.67);
	$pdf->Write(5," To help you discover your super powers,this book will take you on a journey");
	$pdf->SetXY(13.63,10.65);
	$pdf->Write(5,"through a special ");
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->Write(5,"WONDERLAND.");
	$pdf->SetXY(7.99,11.60);
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5,"This wonderland will reveal your ");
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->Write(5,"SUPERPOWERS ");
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5,"and also help you learn the true");
	$pdf->SetXY(15.25,12.45);
	$pdf->Write(5,"meaning of your ");
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->Write(5,"NAME ");
	$pdf->SetXY(10.08,13.33);
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5,"So without much ado, shall we embark on the exciting");
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5," JOURNEY");
	$pdf->SetXY(9.45,14.33);
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5,"to discover your superpowers and to create memories for a ");
	$pdf->SetFont('P22Wedge-Bold','',21);
	$pdf->Write(5,"LIFETIME?");
	$pdf->SetXY(13.26,16.12);
	$pdf->Write(5,"WONDERLAND ");
	$pdf->SetFont('P22Wedge','',17.5);
	$pdf->Write(5,"Ahoy! Here we come!");
	$pdf->Output($order_id.'_'.$kidsname.'_prologue.pdf',D);
}
?>