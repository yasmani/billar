<?php
if(!isset($_POST["total"])) exit;


session_start();


$total = $_POST["total"];
$cliente = $_POST["cliente"];
$detalle = $_POST["detalle"];
//$descuento = $_POST["descuento"];
$orden = $_POST["orden"];
$Thing = $_POST["Thing"];
$devolver = $_POST["devolver"];

include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

date_default_timezone_set("America/La_Paz");

$ahora = date("Y-m-d H:i:s");
class Producto{
 
	public function __construct( $nombre, $precio, $cantidad,$total){

		//$this->descuento=$descuento;
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->cantidad = $cantidad;
		$this->total = $total;
	}
}
/* obteniendo datos del cajero*/
$sentencia = $base_de_datos->query("SELECT * FROM apertura where estado='0';");
$cajero = $sentencia->fetchAll(PDO::FETCH_OBJ);
$nombre_cajera="";
$codigo_apertura=0;
 foreach($cajero as $caja){ 
	$nombre_cajera=$caja->cajera;
	$codigo_apertura=$caja->id;
 }

 /*fin de la caputara  de datos del cliente*/
 /*obteniendo el numero de orden*/
  $ap = $base_de_datos->prepare("SELECT count(*) as cantidad FROM ventas where apertura='$codigo_apertura'");
  $ap->execute();
  $platos_ordenados = $ap->fetch(PDO::FETCH_OBJ);
  $numero=$platos_ordenados->cantidad+1;
  
 /*fin*/
$sentencia = $base_de_datos->prepare("INSERT INTO ventas(fecha, total,Thing,devolver,cliente,detalle,orden,apertura) VALUES (?, ?,?,?,?,?,?,?);");
$sentencia->execute([$ahora,$total,$Thing, $devolver,$cliente,$detalle,$numero,$codigo_apertura]);

$sentencia = $base_de_datos->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idVenta = $resultado === false ? 1 : $resultado->id;

$base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("INSERT INTO productos_vendidos(id_producto, id_venta, cantidad) VALUES (?, ?, ?);");
$sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET existencia = existencia - ? WHERE id = ?;");
 
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	$sentencia->execute([$producto->id, $idVenta, $producto->cantidad]);
	$sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
	$sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
}
			$nombre_impresora = "EPSON TM-T20II Receipt";  
			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
			
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$granTotal=0;
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("--------------------------------" . "\n");
			$printer->setTextSize(2,1);
			$printer->text("GLOBALSOFTSOLUTION\n");

			$printer->setTextSize(1,1);
			$printer->text(date("d-m-Y H:i:s") ."- COD-".$idVenta ."\n");
			
			$printer->text("AV/RADIAL 13 #4110 4to ANILLO\n");
			$printer->text("CEL. 77097848"."\n");
			$printer->text("SANTA CRUZ - BOLIVIA "."\n");
			 $printer->setTextSize(3,1);
			 $printer->text("NOTA VENTA"."\n");
			 $printer->setTextSize(1,1);
			 $printer->text("CLIENTE:".$cliente."\n");
			 $printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->setTextSize(2,2);
			$printer->setTextSize(1,1);
			$printer->text("----------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("CANT".' PRECIO'."     DETALLE "."              ". 'SUBTOTAL'."\n");
			$printer->text("----------------------------------------------"."\n");
			
			$productos = array(
			);
			foreach ($_SESSION["carrito"] as $indice => $producto) {
				array_push($productos,new Producto($producto->nombre, $producto->precioVenta, $producto->cantidad,$producto->total));
	}
	$total = 0;
foreach ($productos as $producto) {
	$total += $producto->total;
 
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($producto->cantidad . " x " . $producto->precio. "bs.  " . $producto->nombre. "\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
   $printer->text(' bs' . $producto->total . "\n");
}
	$printer->text("------------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_RIGHT);
	$printer->setTextSize(2,1);
	$printer->text("TOTAL:".$total."Bs"."\n");
	$printer->text("EFECTIVO:".$Thing."Bs"."\n");
	$printer->text("CAMBIO:".$devolver."\n");
	$printer->setTextSize(1,2);
	  
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	  
	$printer->setTextSize(1,1);
	
	 
	
	$printer->text("NOTA:".$detalle." \n");
	
	$printer->text("--------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_CENTER);
	$printer->text("HORARIO ATENCIÓN \n");
	$printer->text("LUNES - DOMINGOS  \n");
	$printer->text("6:00 AM - 23:00 PM \n");
	$printer->text("***MUCHAS GRACIAS POR SU PREFENRENCIA*** \n");
	$printer->feed(3);
	$printer->cut();
$printer->pulse();
$printer->close();
 
$base_de_datos->commit();
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: ./vender.php?status=1");
?>