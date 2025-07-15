<?php
if(!isset($_POST["total"])) exit;


session_start();


$desde = $_POST["desde"];
$hasta = $_POST["hasta"];
echo $hasta;
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


$ahora = date("Y-m-d H:i:s");
class Producto{
 
	public function __construct($nombre, $precio, $cantidad){
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->cantidad = $cantidad;
	}
}

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
			$nombre_impresora = "EPSON TM-T20II Receipt5";  
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			 
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			date_default_timezone_set("America/La_Paz");
      $granTotal=0;
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text("-----------------------------" . "\n");
      $printer->text("PARRILLADA 'EL ARCA'.\n");
      $printer->text(date("d-m-Y H:i:s") . "\n");
      // impresion
      // $printer->text("\n".$producto->descripcion ."X". "\n");
      $printer->text("Celular: 76319897"."\n");
      $printer->text("Direccion:".'Av MUTUALISTA'."\n");
      $printer->text("--------------------------------------------" . "\n");
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text("       DETALLE.\n");
      $printer->text("--------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("CANT"."   ".'NOMBRE'."  "."                    ". 'PRECIO'."\n");
			
			$productos = array(
				// new Producto("Papas fritas", 10, 1),
				// new Producto("Pringles", 22, 2),
				// /*
				// 	El nombre del siguiente producto es largo
				// 	para comprobar que la librería
				// 	bajará el texto por nosotros en caso de
				// 	que sea muy largo
				// */
				// new Producto("Galletas saladas con un sabor muy salado y un precio excelente", 10, 1.5),
			);
			foreach ($_SESSION["carrito"] as $indice => $producto) {
				array_push($productos,new Producto($producto->descripcion, $producto->total, $producto->cantidad));

				// $granTotal += $producto->total;
			 
				// $printer->text($producto->cantidad."X");
				
				// $printer->setJustification(Printer::JUSTIFY_CENTER);
				 
				// // $printer->setJustification(Printer::JUSTIFY_CENTER);
				// $printer->text("   " .$producto->descripcion);
				// $printer->setJustification(Printer::JUSTIFY_RIGHT);
 				// $printer->text("------------".$producto->total."bs"."");
				// $printer->text(""."\n");
	}
	$total = 0;
foreach ($productos as $producto) {
	$total += $producto->precio;
 
	/*Alinear a la izquierda para la cantidad y el nombre*/
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($producto->cantidad . "x" . $producto->nombre."\n");
 
    /*Y a la derecha para el importe*/
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text(' bs' . $producto->precio . "\n");
}
	$printer->text("--------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("                        TOTAL:".$total." .Bs"."\n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->text( "COPIA 1 \n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->text("NUMERO DE PEDIDO:".$idVenta."\n");
			$printer->text("MUCHAS GRACIAS POR SU PREFERENCIA \n");
			// $printer->feed(3);
			// $printer->cut();
			// $printer->pulse();
			// $printer->close();
 
// $base_de_datos->commit();
// unset($_SESSION["carrito"]);
// $_SESSION["carrito"] = [];
// header("Location: ./vender.php?status=1");
?>