<?php
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
date_default_timezone_set("America/La_Paz");
$nombre_impresora = "EPSON TM-T20II Receipt5";  
$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

if(!isset($_POST["total"])) exit;


session_start();


$total = $_POST["total"];
 


$ahora = date("Y-m-d H:i:s");


$sentencia = $base_de_datos->prepare("INSERT INTO ventas(fecha, total) VALUES (?, ?);");
$sentencia->execute([$ahora, $total]);

$sentencia = $base_de_datos->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idVenta = $resultado === false ? 1 : $resultado->id;

$base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("INSERT INTO productos_vendidos(id_producto, id_venta, cantidad) VALUES (?, ?, ?);");
$sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET existencia = existencia - ? WHERE id = ?;");
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	echo "PRODUCTOS ",$producto->id;
	echo "d";
	echo "CANTIDAD".$producto->cantidad;

	$sentencia->execute([$producto->id, $idVenta, $producto->cantidad]);
	$sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
}
			#Mando un numero de respuesta para saber que se conecto correctamente.
			// echo 1;
			# Vamos a alinear al centro lo próximo que imprimamos
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
      $granTotal=0;
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text("-----------------------------" . "\n");
      $printer->text("TIENDA MEGO MARKET.\n");
      $printer->text(date("d-m-Y H:i:s") . "\n");
      // impresion
      // $printer->text("\n".$producto->descripcion ."X". "\n");
      $printer->text("Celular: 61599811"."\n");
      $printer->text("Direccion:".'Av Radial 13 4to anillo'."\n");
      $printer->text("--------------------------------------------" . "\n");
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text("       DETALLE.\n");
      $printer->text("--------------------------------------------"."\n");
      $printer->setJustification(Printer::JUSTIFY_LEFT);
      $printer->text("NOMBRE"."--------- ".'$CANt.'."  "."            ". 'precio'. ""."bs"."\n");

  foreach ($_SESSION["carrito"] as $indice => $producto) {
      $granTotal += $producto->total;
			echo"id".$producto->id;
      echo "codigo". $producto->codigo  ;
      echo "desc". $producto->descripcion;
      echo "precioV".$producto->precioVenta  ;
      echo "cantidad".$producto->cantidad; 
      setPrintLeftMargin('2');
      setPrintWidth("20");
			$printer->text($producto->descripcion."              ".$producto->cantidad. "".$producto->precioVenta."bs"."\n");
    }
			$printer->text("--------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("                        TOTAL:".$granTotal." .Bs"."\n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->text( "COPIA 1 \n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("GRACIAS POR SU PREFERENCIA \n");
			$printer->feed(3);
			$printer->cut();
			$printer->pulse();
			$printer->close();
 
$base_de_datos->commit();
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
// header("Location: ./vender.php?status=1");
?>