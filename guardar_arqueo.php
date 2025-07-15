<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
date_default_timezone_set("America/La_Paz");
$ahora = date("Y-m-d H:i:s");
include_once "base_de_datos.php";


////////////////////////////////////
$sentencia = $base_de_datos->query("SELECT codigo , productos.nombre,SUM(cantidad) as cantidad,sum(productos.precioVenta) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE ventas.arqueo='0') GROUP by  productos_vendidos.id_producto");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
	


$nombre_impresora = "SAT 22TUS";  
$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
 
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$granTotal=0;
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("-----------------------------" . "\n");
$printer->setTextSize(1,2);
$printer->text("'PIZZA HITS'.\n");
$printer->setTextSize(1,1);
$printer->text(date("d-m-Y H:i:s") . "\n");
// impresion
$printer->text("Celular: 76036417"."\n");
$printer->text("Direccion:".'AV.PIRAI entre 2do y 3er anillo'."\n");
$printer->text("--------------------------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("       DETALLE DE LAS VENTAS CIERRE DE CAJA.\n");
$printer->text("--------------------------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANT".' PRECIO'." NOMBRE "."                    ". 'TOTAL'."\n");
			
 $total=0;
 $totalGanancia=0;
 $numero=0;
 $cant=0;
	foreach($ventas as $venta){ 
	/*Alinear a la izquierda para la cantidad y el nombre*/
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($venta->cantidad . " x " . $venta->precio. "bs. " . $venta->nombre."\n");
 
    /*Y a la derecha para el importe*/
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text(' bs' . $venta->cantidad * $venta->precio . "\n");
 
	$printer->text("--------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_RIGHT);
//	$printer->text("                        TOTAL:".$total." .Bs"."\n");
	$total=$total+($venta->cantidad * $venta->precio); 

		$numero++;
		//$pdf->Cell(10,6,$numero,1,0,'C',1);
	 
		$cant=$cant+$venta->cantidad;
		 
		$totalGanancia=$totalGanancia+$venta->cantidad * ($venta->precio-$venta->precioCompra);
		//$pdf->Cell(30,6,$venta->cantidad * ($venta->precio-$venta->precioCompra),1,0,'C',1);
		//$pdf->Cell(30,6,$venta->cantidad * $venta->precio,1,1,'C',1);

} 

$printer->text("TOTAL DEL ARQUEO=".$total."BS"."\n");
// $printer->text("TOTAL DEL ARQUEO=".$total_arqueo."BS"."\n");
$printer->text("--------------------------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
			// $printer->text("                        TOTAL:".$granTotal." .Bs"."\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->text( "COPIA 1 \n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->text("NUMERO DE PEDIDO:".$idVenta."\n");
$printer->text("MUCHAS GRACIAS POR SU PREFERENCIA \n");
$printer->feed(3);
$printer->cut();
$printer->pulse();
$printer->close();
///////////////////////////////////
$sentencia = $base_de_datos->query("SELECT * FROM ventas where arqueo='0';");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
  $arqueo;
	$id;
	$cantidad=0;
	$total_arqueo=0;
  foreach($productos as $producto){ 
		$cantidad+=1;
		$total_arqueo+=$producto->total;
		$arqueo=$producto->arqueo;
		$id=$producto->id;
		$sentencia = $base_de_datos->prepare("UPDATE ventas SET arqueo = ?  WHERE id = ?;");
		$resultado = $sentencia->execute(["1",$id]);
} 
echo "totalventa";
echo $total_arqueo;
echo "cantidad";
echo $cantidad;

$sentencia = $base_de_datos->prepare("INSERT INTO arqueo(cantidad,monto,fecha) VALUES (?, ?,?);");
$fecha=date("Y-m-d ");
$resultado = $sentencia->execute(['1', '30',$fecha]);
echo $fecha;


if($resultado === TRUE){
	header("Location: ./vender.php");
	exit;
}
// else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";
// ?>