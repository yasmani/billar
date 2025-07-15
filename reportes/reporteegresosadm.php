<?php
 

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'REPORTE DE GASTOS ADMINISTRATIVOS',1,1,'C'); 
$inicio=$_POST['inicio'];
$fin=$_POST['fin']; 
  
$pdf->Cell(170,6,' DESDE '.date("d/m/Y", strtotime($inicio)).' HASTA '.date("d/m/Y", strtotime($fin)),0,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,6,'NOMBRE',1,0,'C',1);
$pdf->Cell(80,6,'DESCRIPCION',1,0,'C',1); 
//$pdf->Cell(20,6,utf8_decode('MONTO'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('SUBTOTAL'),1,0,'C',1);
// $pdf->Cell(12,6,'Stock',1,0,'C',1);
// $pdf->Cell(35,6,'descripcion',1,0,'C',1);

$pdf->Ln(6);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Egresosadm.php";
date_default_timezone_set("America/La_Paz");
// $hoy=date('Y-m-d');
// $hoy=date('Y-m-d');
  $inicio=$_POST['inicio'];
  $fin=$_POST['fin'];
    // $inicio='2020-12-07';
    // $fin='2020-12-07';
//  $query = "SELECT multaid,interno,tipo,fecha,precio FROM multa WHERE     condicion=1 and fecha between '$inicio' AND '$fin' ORDER BY fecha asc";

// echo $inicio;
// echo $fin;
$egresos = new Egresos();

// $rspta = $egresos->listar();
$rspta = $egresos->listar_fecha($inicio,$fin);

//Table with 20 rows and 4 columns
$pdf->SetWidths(array(80,80,20));
$monto_total=0;
while($reg= $rspta->fetch_object())
{  
  $nombre = $reg->nombre;
  $cantidad = $reg->cantidad;
  $detalle = $reg->detalle;
  $total = $reg->total;
  $monto_total=$monto_total+$total;
  // echo "cc".$nombre;
  // $codigo = $reg->codigo;
  // $stock = $reg->stock;
  // $descripcion =$reg->descripcion;
  
  $pdf->SetFont('Arial','',10);
  $pdf->Row(array(utf8_decode($nombre),utf8_decode($cantidad),utf8_decode($total)." bs."));
}
$pdf->SetX(150);
$pdf->Cell(20,6,utf8_decode('TOTAL BS'),1,0,'C',1);
// $pdf->SetWidths(array(13));
$pdf->SetFont('Arial','',14);
$pdf->Cell(20,6,$monto_total." bs.",1,0,'C',1);
// $pdf->Row(array());

//Mostramos el documento pdf
$pdf->Output();

?>
 