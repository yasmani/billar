<?php
if(!isset($_POST["total"])) exit;


session_start();


$total = $_POST["total"];
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

$sentencia = $base_de_datos->prepare("INSERT INTO compras(fecha, total) VALUES (?, ?);");
$sentencia->execute([$ahora, $total]);

$sentencia = $base_de_datos->prepare("SELECT id FROM compras ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idCompra = $resultado === false ? 1 : $resultado->id;

$base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("INSERT INTO productos_comprados(id_producto, id_compra, cantidad) VALUES (?, ?, ?);");
$sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET existencia = existencia + ? WHERE id = ?;");
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	echo "PRODUCTOS ",$producto->id;
	echo "d";
	echo "CANTIDAD".$producto->cantidad;

	$sentencia->execute([$producto->id, $idCompra, $producto->cantidad]);
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
			$printer->text("Celular: 76319897"."\n");
			$printer->text("Direccion:".'Av MUTUALISTA'."\n");
			$printer->text("--------------------------------------------" . "\n");
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("       DETALLE.\n");
			$printer->text("--------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("CANT"."   ".'NOMBRE'."  "."                    ". 'PRECIO'."\n");
			
		 
			foreach ($_SESSION["carrito"] as $indice => $producto) {
				array_push($productos,new Producto($producto->descripcion, $producto->total, $producto->cantidad)); 
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
			$printer->feed(3);
			$printer->cut();
			$printer->pulse();
			$printer->close();
 
$base_de_datos->commit();
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: ./vender.php?status=1");
?>