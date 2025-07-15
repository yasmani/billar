<?php
if(!isset($_POST["total"])) exit;
session_start();
$total = $_POST["total"];
$proveedor = $_POST["proveedor"];
include_once "base_de_datos.php";
date_default_timezone_set("America/La_Paz");
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$ahora = date("Y-m-d H:i:s");
$hora = date("H:i:s");
class Producto{
	public function __construct($nombre, $precio, $cantidad,$total){
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->cantidad = $cantidad;
		$this->total = $total;
	}
} 
//echo $proveedor;
$usuario=$_COOKIE["usuario"];
//INSERT INTO `compras` (`id`, `fecha`, `total`, `usuario`, `condicion`) VALUES (NULL, '2021-11-21 15:37:45.000000', '100', NULL, '1');
$sentencia = $base_de_datos->prepare("INSERT INTO comprastienda(id,fecha, total,usuario,proveedor,hora,condicion) VALUES (?,?,?, ?,?,?,?);");
$sentencia->execute([null,$ahora, $total,$usuario,$proveedor,$hora,'1']);

$sentencia = $base_de_datos->prepare("SELECT id FROM comprastienda ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idCompra = $resultado === false ? 1 : $resultado->id;

$base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("INSERT INTO productos_comprados_tienda(id_producto,precio, id_compra, cantidad) VALUES (?,?, ?, ?);");
$sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET precioCompra = ?, precioVenta = ?, precioVenta2 = ?, precioVenta3 = ?,tienda = tienda + ? WHERE id = ?;");
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	echo "PRODUCTOS ",$producto->id;
	echo "d";
	echo "CANTIDAD".$producto->cantidad;

	$sentencia->execute([$producto->id,$producto->precioCompra, $idCompra, $producto->cantidad]); 
	$sentenciaExistencia->execute([$producto->precioCompra,$producto->precioVenta,$producto->precioVenta2,$producto->precioVenta3,$producto->cantidad, $producto->id]);
}
			// $nombre_impresora = "EPSON TM-T20II Receipt";  
			// $connector = new WindowsPrintConnector($nombre_impresora);
			// $printer = new Printer($connector);
			// $printer->setJustification(Printer::JUSTIFY_RIGHT);
			date_default_timezone_set("America/La_Paz");
			$granTotal=0;
			// $printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->text("--------------------------------" . "\n");
			// $printer->setTextSize(2,1);
			// $printer->text("GLOBALSOFTSOLUTION\n");

			// $printer->setTextSize(1,1);
			// $printer->text(date("d-m-Y H:i:s") ."\n");
			
			// $printer->text("AV/RADIAL 13 #4110 4to ANILLO\n");
			// $printer->text("CEL. 77097848"."\n");
			// $printer->text("SANTA CRUZ - BOLIVIA "."\n");
			
			// $printer->text("--------------------------------------------" . "\n");
			// $printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->text("       DETALLE DE COMPRA.\n");
			// $printer->text("--------------------------------------------"."\n");
			// $printer->setJustification(Printer::JUSTIFY_LEFT);
			// $printer->text("CANT"." PRECIO ".'NOMBRE'."  "."                    ". 'PRECIO'."\n");
			
			$productos = array(
			);
			foreach ($_SESSION["carrito"] as $indice => $producto) {
				array_push($productos,new Producto($producto->nombre, $producto->precioCompra, $producto->cantidad,$producto->total)); 
			}
	$total = 0;
foreach ($productos as $producto) {
	$total += $producto->total;
	/*Alinear a la izquierda para la cantidad y el nombre*/
	// $printer->setJustification(Printer::JUSTIFY_LEFT);
    // $printer->text($producto->cantidad . " X ".  $producto->precio ."bs. " . $producto->nombre."\n");
    /*Y a la derecha para el importe*/
    // $printer->setJustification(Printer::JUSTIFY_RIGHT);
    // $printer->text(' bs' . $producto->total . "\n");
}
	// $printer->text("--------------------------------------------"."\n");
			// $printer->setJustification(Printer::JUSTIFY_RIGHT);
            // $printer->text("                        TOTAL:".$total." .Bs"."\n");
			// $printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->setJustification(Printer::JUSTIFY_CENTER);
			// $printer->text("***MUCHAS GRACIAS POR SU PREFERENCIA*** \n");
			// $printer->feed(3);
			// $printer->cut();
			// $printer->pulse();
			// $printer->close();
 
$base_de_datos->commit();
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: ./comprasTienda.php?status=1");
?>