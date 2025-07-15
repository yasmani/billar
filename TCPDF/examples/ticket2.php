<?php
 require_once('tcpdf_include.php');
 //require_once('../../modelos/Cobros.php'); 
 date_default_timezone_set("America/La_Paz");
 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 $interno='';
$id='';
$cantidad='';
$idsocio='';
$idtipoCobro='';
$monto='';
$nombre='';
$fecha='';
$descripcion='';
$numero_aportes='';
$numeroT='';
$ahorroS=0;
$pdf->SetFont('dejavusans', 'B', 10);
if (isset($_GET['mensaje'])) {
    /* Deshacemos el trabajo hecho por base64_encode */
    $error = base64_decode($_GET['mensaje']);
    /* Deshacemos el trabajo hecho por 'serialize' */
    $error = unserialize($error);
    $id= $error['id'];
    $cantidad= $error['cantidad'];
    $nombre= $error['nombre'];
    $idsocio= $error['idsocio'];
    $idtipoCobro= $error['idtipoCobro'];
    $monto= $error['monto'];
    $fecha= date("d/m/Y", strtotime($error['fecha']));
    $descripcion= $error['descripcion'];
    $numero_aportes= $error['numero_aportes'];
    // El contenido del error está en el índice 'error'
}
$pdf->SetFont('dejavusans', '', 10);
 
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

$pdf->AddPage('P', 'A7');
$pdf->SetY(3);

// test Cell stretching
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->Cell(0, 0, 'Cooperativa de Transporte', 1, 1, 'C', 0, '', 0);
 
$pdf->Cell(0, 0, 'LINEA 82', 0, 1, 'C', 0, '', 0);
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->SetX(2);

$pdf->SetFont('dejavusans ', 'B', 10);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'NRO:0000'.htmlspecialchars($id), 0, 1, 'L', 0, '', 0);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'FECHA:'.$fecha, 0, 1, 'L', 0, '', 0);
$pdf->SetX(8);
 
$pdf->Cell(0, 0, 'HORA:'.date('h:i:s A'), 0, 1, 'L', 0, '', 0);
$pdf->SetFont('dejavusans ', 'B', 10);
$pdf->SetX(8);
$pdf->Cell(0, 0,'ACUMULADO: '.$numero_aportes, 0, 1, 'L', 0, '', 0);

//$pdf->Cell(15, 2,'NOMBRE: '.$nombre, 0, 1, 'C', 0, '', 0);
 
$pdf->SetFont('dejavusans', 'B', 25);
$pdf->SetY(13);
$pdf->SetX(48);
$pdf->Cell(24, 1,$idsocio, 1, 1, 'C', 0, '', 0);
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->SetX(53);
$pdf->Cell(15, 2,'interno', 0, 1, 'R', 0, '', 0);
//$pdf->Cell(0, 0, 'cantidad mensual '.htmlspecialchars($_GET["numero_aportes"]), 0, 1, 'C', 0, '', 0);
//$pdf->Ln(1);
$pdf->SetX(8);
$pdf->Cell(0, 0, '--------------------------------------------------', 0, 1, 'L', 0, '', 0);
$pdf->SetX(8);
$pdf->Cell(0, 0,htmlspecialchars($nombre), 0, 1, 'L', 0, '', 0);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'CONCEPTO:'.htmlspecialchars($idtipoCobro), 0, 1, 'L', 0, '', 0);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'CANTIDAD:'.htmlspecialchars($cantidad), 0, 1, 'L', 0, '', 0);
$pdf->SetX(1);
//$pdf->Cell(0, 0, 'MONTO:'.htmlspecialchars($_GET["monto"]).'.bs', 0, 1, 'L', 0, '', 0);
$pdf->SetX(1);
$pdf->Cell(0, 0, '--------------------------------------------------------------', 0, 1, 'L', 0, '', 0);



$pdf->SetX(3);
$pdf->SetFont('dejavusans', 'B', 15);
$pdf->Cell(0, 0, 'TOTAL '.htmlspecialchars($monto).' .Bs', 0, 1, 'R', 0, '', 0);
$pdf->SetFont('dejavusans', 'B', 10);
$pdf->SetX(8);
$pdf->Cell(0, 0, 'Observaciones', 0, 1, 'L', 0, '', 0);
$pdf->SetX(3);
$pdf->MultiCell(70, 14, ''.htmlspecialchars($descripcion), 1, 'L', 0, 0, '', '', true);
$pdf->Cell(0, 0, '                          ', 0, 1, 'L', 0, '', 0);
//$pdf->ln(15);
$pdf->SetY(78.7);
$pdf->Cell(0, 0, '------------------', 0, 1, 'C', 0, '', 0);
$pdf->SetY(80.5);
$pdf->Cell(0, 0, 'firma', 0, 1, 'C', 0, '', 0);


 
// create some HTML content
 




 
$pdf->Output('linea82.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
