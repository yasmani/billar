<?php
 require_once('tcpdf_include.php');
 //require_once('../../modelos/Cobros.php'); 
 date_default_timezone_set("America/La_Paz");
 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
$pdf->SetFont('dejavusans', '', 10);
 
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

$pdf->AddPage('P', 'A7');
$pdf->SetY(3);
$ingreso=$_GET["ingreso"];
$egreso=$_GET["egreso"];
// test Cell stretching
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->Cell(0, 0, 'Cooperativa de Transporte', 1, 1, 'C', 0, '', 0);
$pdf->Cell(0, 0, 'LINEA 82', 0, 1, 'C', 0, '', 0);
 
$pdf->Cell(0, 0, ''.htmlspecialchars(( date("d/m/Y",strtotime($_GET["fecha"])))), 0, 1, 'C', 0, '', 0);
$pdf->Cell(0, 0, 'HORA:'.date('h:i:s A'), 0, 1, 'C', 0, '', 0);
$pdf->SetFont('dejavusans ', 'B', 10);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'NRO:0000'.htmlspecialchars($_GET["id"]), 0, 1, 'L', 0, '', 0);
 
if($ingreso>0){
    $pdf->Cell(0, 0, 'INGRESO', 0, 1, 'C', 0, '', 0);
} 
if($egreso>0){
    $pdf->Cell(0, 0, 'EGRESO', 0, 1, 'C', 0, '', 0);
     
} 
$pdf->SetX(8);
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->Cell(0, 0, 'Conductor:', 0, 1, 'L', 0, '', 0);
$pdf->SetX(8);
 
//$pdf->MultiCell(8, 40, ''.htmlspecialchars($_GET["idconductor"]), 1, 'L', 0, 0, '', '', true);
$pdf->Cell(0, 0, htmlspecialchars($_GET["idconductor"]), 0, 1, 'L', 0, '', 0);
 
$pdf->Cell(0, 0, '--------------------------------------------------------------', 0, 1, 'C', 0, '', 0);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'CODIGO:'.htmlspecialchars($_GET["cod"]), 0, 1, 'L', 0, '', 0);

$monto=0;
if($ingreso>0){
    $monto=$ingreso;
    $pdf->SetX(8);
    $pdf->Cell(0, 0, 'INGRESO:'.htmlspecialchars($_GET["ingreso"]).'.bs', 0, 1, 'L', 0, '', 0);
} 
if($egreso>0){
    $monto=$egreso;
    $pdf->SetX(8);
    $pdf->Cell(0, 0, 'EGRESO:'.htmlspecialchars($_GET["egreso"]).'.bs', 0, 1, 'L', 0, '', 0);
} 
//$pdf->Cell(0, 0, 'MONTO:'.htmlspecialchars($_GET["monto"]).'.bs', 0, 1, 'L', 0, '', 0);
$pdf->Cell(0, 0, '--------------------------------------------------------------', 0, 1, 'C', 0, '', 0);
//$pdf->Cell(0, 0, '--------------------------------------------------', 0, 1, 'R', 0, '', 0);



$pdf->SetX(3);
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->Cell(0, 0, '                           TOTAL '.htmlspecialchars($monto).' .Bs', 0, 1, 'L', 0, '', 0);
$pdf->SetX(3);
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->Cell(0, 0, '        SALDO ACTUAL:  '.htmlspecialchars($_GET["saldo"]).' .Bs', 0, 1, 'L', 0, '', 0);
$pdf->SetFont('dejavusans', '', 7);
$pdf->SetX(3);
$pdf->Cell(0, 0, 'Observaciones:', 0, 1, 'L', 0, '', 0);
$pdf->SetX(3);
$pdf->MultiCell(70, 14, ''.htmlspecialchars($_GET["observacion"]), 0, 'L', 0, 0, '', '', true);
$pdf->Cell(0, 0, '                          ', 0, 1, 'L', 0, '', 0);
 $pdf->ln(10);
$pdf->Cell(0, 0, 'firma', 0, 1, 'C', 0, '', 0);
// create some HTML content
 




 
$pdf->Output('linea82.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
