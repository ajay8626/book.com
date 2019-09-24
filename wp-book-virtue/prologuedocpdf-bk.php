<?php 
global $wpdb;
$bu_name_str = '';
if(isset($_REQUEST['bu_name'])){
	$bu_name_str = $_REQUEST['bu_name'];
	$bu_name_str = trim(ucfirst(strtolower($bu_name_str)));
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
	$pdf->SetFont('P22Wedge-Bold','',19.5);
	$pdf->SetXY(16.584,3.2);
	$pdf->Write(5,'Dear '.$kidsname.',');
	$pdf->SetFont('P22Wedge-Bold','',16.5);
	$pdf->SetXY(14.55,4.98);
	$pdf->Write(5,'This is Your Book,Your Story.');
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->SetXY(10.62,6.91);
	$pdf->Write(5,'Can you guess who created this fantastic story book about you?');
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->SetXY(8.14,7.82);
	$pdf->Write(5,'The two people who know you the best,love you the most and care for you the max');
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->SetXY(13.63,8.7);
	$pdf->Write(5,"-YOUR MOMMY AND DADDY.");
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->SetXY(11,9.67);
	$pdf->Write(5,"Do you know that you have ");
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5,"SUPERPOWERS");
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->Write(5," within you?");
	$pdf->SetXY(9.03,10.65);
	$pdf->Write(5," To help you discover your super powers,this book will take you on a journey");
	$pdf->SetXY(13.63,11.60);
	$pdf->Write(5,"through a special ");
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5,"WONDERLAND.");
	$pdf->SetXY(7.99,12.45);
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->Write(5,"This wonderland will reveal your ");
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5,"SUPERPOWERS ");
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->Write(5,"and also help you learn the true");
	$pdf->SetXY(11.50,13.28);
	$pdf->Write(5,"meaning of your ");
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5,"NAME ");
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->Write(5,"as you take journey through it.");
	$pdf->SetXY(10.08,14.33);
	$pdf->Write(5,"So without much ado, shall we embark on the excitin");
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5," JOURNEY");
	$pdf->SetXY(14.55,15.12);
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->Write(5," to discover your superpowers?");
	$pdf->SetXY(13.26,16.87);
	$pdf->SetFont('P22Wedge-Bold','',20);
	$pdf->Write(5,"WONDERLAND ");
	$pdf->SetFont('P22Wedge','',16.5);
	$pdf->Write(5,"Ahoy! Here we come!");
	$pdf->Output($kidsname.'_prologue.pdf',D);
}
?>