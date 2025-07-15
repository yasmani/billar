<?php
 
 require __DIR__ . '../../ticket/autoload.php';
 use Mike42\Escpos\Printer;
 use Mike42\Escpos\EscposImage;
 use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
 
 date_default_timezone_set("America/La_Paz");


// require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
// $pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
// $pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
// $y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
// $pdf->SetFont('Arial','B',12);

// $pdf->Cell(40,6,'',0,0,'C');
// $pdf->Cell(100,6,'REPORTE DE EGRESOS',1,1,'C'); 
// $inicio=$_POST['inicio'];
// $fin=$_POST['fin']; 
  
// $pdf->Cell(170,6,' DESDE '.date("d/m/Y", strtotime($inicio)).' HASTA '.date("d/m/Y", strtotime($fin)),0,0,'C'); 
// $pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
// $pdf->SetFillColor(232,232,232); 
// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(140,6,'DETALLE',1,0,'C',1); 
// $pdf->Cell(20,6,utf8_decode('MONTO'),1,0,'C',1);
// $pdf->Cell(20,6,utf8_decode('SUBTOTAL'),1,0,'C',1);
// $pdf->Cell(12,6,'Stock',1,0,'C',1);
// $pdf->Cell(35,6,'descripcion',1,0,'C',1);

// $pdf->Ln(6);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Egresos.php";
date_default_timezone_set("America/La_Paz");
// $hoy=date('Y-m-d');
// $hoy=date('Y-m-d');
  $inicio=$_POST['inicio'];
  $fin=$_POST['fin'];
  $ahora = date("Y-m-d H:i:s");


$egresos = new Egresos();

// $rspta = $egresos->listar();

////////////////////////////////////////////////
$nombre_impresora = "EPSON TM-T20II Receipt";  
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			 
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$granTotal=0;
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("-----------------------------" . "\n");
			$printer->setTextSize(1,2);
			$printer->text("'LA CANASTA'.\n");
			$printer->setTextSize(1,1);
			$printer->text(date("d-m-Y H:i:s") ."" ."\n");
			// impresion
			// $printer->text("\n".$producto->descripcion ."X". "\n");
			$printer->text("FECHA INICIO: ".date("d/m/Y", strtotime($inicio))."\n");
			$printer->text("FECHA FIN: ".date("d/m/Y", strtotime($fin))."\n");
			// $printer->text("#ORDEN: ".$idVenta."\n");
			$printer->text("Celular:".' '."\n");
			$printer->text("Direccion:".' '."\n");
			$printer->text("--------------------------------------------" . "\n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("       DETALLE DE LOS GASTOS.\n");
			$printer->text("--------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("FECHA          DETALLE".'   '."  "."             ". 'TOTAL'."\n");
			
			// $productos = array(
				// new Producto("Papas fritas", 10, 1),
				// new Producto("Pringles", 22, 2),
				// /*
				// 	El nombre del siguiente producto es largo
				// 	para comprobar que la librería
				// 	bajará el texto por nosotros en caso de
				// 	que sea muy largo
				// */
				// new Producto("Galletas saladas con un sabor muy salado y un precio excelente", 10, 1.5),
			// );
			// foreach ($_SESSION["carrito"] as $indice => $producto) {
				// array_push($productos,new Producto($producto->nombre, $producto->precioVenta, $producto->cantidad,$producto->total));

			 
	// }
  $total = 0;
  $rspta = $egresos->listar_fecha($inicio,$fin);
 $monto_total=0;
while($reg= $rspta->fetch_object())
{  
  $nombre = $reg->nombre;
  $detalle = $reg->detalle;
  $total = $reg->total;
  $monto_total=$monto_total+$total;
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->text(date("d/m/Y", strtotime($reg->fecha))." ".$nombre. "  " . $detalle."\n");

  /*Y a la derecha para el importe*/
  $printer->setJustification(Printer::JUSTIFY_RIGHT);
  $printer->text( $total.' Bs.'."\n");

  // $pdf->Row(array(utf8_decode($nombre."(".$detalle.")"),utf8_decode($total),utf8_decode($total)));
}
 
// $pdf->Cell(20,6,$monto_total,1,0,'C',1);


// foreach ($productos as $producto) {
	// $total += $producto->total;
 
	/*Alinear a la izquierda para la cantidad y el nombre*/
	// $printer->setJustification(Printer::JUSTIFY_LEFT);
  //   $printer->text($producto->cantidad . " x " . $producto->precio. "bs.  " . $producto->nombre."\n");
 
  //   /*Y a la derecha para el importe*/
  //   $printer->setJustification(Printer::JUSTIFY_RIGHT);
  //   $printer->text(' bs' . $producto->total . "\n");
// }
	$printer->text("--------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_RIGHT);
	$printer->text("                        TOTAL.".$monto_total." Bs."."\n");
	// $printer->text( "COPIA 1 \n");
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	// $printer->text("NUMERO DE PEDIDO:".$idVenta."\n");
	$printer->setTextSize(1,1);
	
	//$printer->ln(10);
	// $printer->text("NOTA: \n");
	// $printer->text($detalle."\n");
	$printer->text("--------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_CENTER);
	$printer->text("REPORTE DE GASTOS \n");
	// $printer->text("original \n");
	$printer->feed(3);
	$printer->cut();
$printer->pulse();
$printer->close();
////////////////////////////////////////////////
// $rspta = $egresos->listar_fecha($inicio,$fin);
//  $monto_total=0;
// while($reg= $rspta->fetch_object())
// {  
//   $nombre = $reg->nombre;
//   $detalle = $reg->detalle;
//   $total = $reg->total;
//   $monto_total=$monto_total+$total;
   
//   $pdf->Row(array(utf8_decode($nombre."(".$detalle.")"),utf8_decode($total),utf8_decode($total)));
// }
 
// $pdf->Cell(20,6,$monto_total,1,0,'C',1);

header("Location: ../vender.php");
?>
 