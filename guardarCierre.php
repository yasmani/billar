<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";
//include_once "backup.php";
include "./fpdf181/fpdf.php";
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT * FROM apertura where estado='0';");
$cajero = $sentencia->fetchAll(PDO::FETCH_OBJ);
$nombre_cajera="";
$codigo_apertura=0;
$monto_aperturado=0;
 foreach($cajero as $caja){ 
	$nombre_cajera=$caja->cajera;
	$codigo_apertura=$caja->id;
	$monto_aperturado=$caja->monto;
 }
$sentencia = $base_de_datos->prepare("UPDATE apertura SET estado = ?  WHERE id = ?;");
$resultado = $sentencia->execute(["1", $id]);

$sentencia = $base_de_datos->query("SELECT * FROM egresos where detalle='$codigo_apertura'");
$egresos = $sentencia->fetchAll(PDO::FETCH_OBJ);
$sentencia1 = $base_de_datos->query("SELECT * FROM egresosadm where detalle='$codigo_apertura'");
$egresosadm = $sentencia1->fetchAll(PDO::FETCH_OBJ);
$sentencia2 = $base_de_datos->query("SELECT * FROM egresosdes where detalle='$codigo_apertura'");
$egresosdes = $sentencia2->fetchAll(PDO::FETCH_OBJ);

if($resultado == TRUE){
	//backupDatabaseTables('localhost','root','','dbjson',$tables='*');
}else{
    echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";
	header("Location: ./ventas.php");
	exit;
}

require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
date_default_timezone_set("America/La_Paz");
$ahora = date("Y-m-d H:i:s");





////////////////////////////////////
$sentencia = $base_de_datos->query("SELECT codigo , productos.nombre,SUM(cantidad) as cantidad,sum(productos.precioVenta) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE ventas.arqueo='0') GROUP by  productos_vendidos.id_producto");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
	



// $nombre_impresora = "LR2000";  
// $connector = new WindowsPrintConnector($nombre_impresora);
// $printer = new Printer($connector);
 
// $printer->setJustification(Printer::JUSTIFY_RIGHT);
// $granTotal=0;
// $printer->setJustification(Printer::JUSTIFY_CENTER);
// 			$printer->text("--------------------------------" . "\n");
// 			$printer->setTextSize(2,1);
// 			$printer->text("3 Hermanos\n");

// 			$printer->setTextSize(1,1);
// 			$printer->text(date("d-m-Y H:i:s") ."\n");
			
// 			$printer->text("Direccion: calle topacio y Amatista #9\n");
// 			$printer->text("CEL. 75663050"."\n");
// 			$printer->text("SANTA CRUZ - BOLIVIA "."\n");
// // impresion
// $printer->text("Cajero: ".$nombre_cajera."\n");

// $printer->text("--------------------------------------------" . "\n");
// $printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->setTextSize(1,1);
// $printer->text("DETALLE DE LAS VENTAS CIERRE DE CAJA"."\n");
// $printer->setTextSize(1,1);
// $printer->text("----------------------------------------------"."\n");
// $printer->setJustification(Printer::JUSTIFY_LEFT);
// $printer->text("CANT".' PRECIO'."       NOMBRE "."              ". 'TOTAL'."\n");
			
 $total=0;
 $totalGanancia=0;
 $numero=0;
 $cant=0;
	foreach($ventas as $venta){ 
	/*Alinear a la izquierda para la cantidad y el nombre*/
	// $printer->setJustification(Printer::JUSTIFY_LEFT);
	// $printer->setTextSize(1,1);
    // $printer->text($venta->cantidad . " x " . $venta->precio. "bs. " . $venta->nombre."\n");
 
    /*Y a la derecha para el importe*/
    // $printer->setJustification(Printer::JUSTIFY_RIGHT);
    // $printer->text(' bs ' . $venta->cantidad * $venta->precio . "\n");
 
	$total=$total+($venta->cantidad * $venta->precio); 
		$numero++;
		$cant=$cant+$venta->cantidad;
		$totalGanancia=$totalGanancia+$venta->cantidad * ($venta->precio-$venta->precioCompra);
		
} 


$VENTAS=0;
 $VENTAS=$total;

	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
	// $printer->setTextSize(1,1);
    // $printer->text("TOTAL VENTAS: " .$VENTAS."\n");


// $printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->setTextSize(2,1);
// $printer->text("COMPRAS DE INSUMOS.\n");
// $printer->setTextSize(1,1);
// $printer->setJustification(Printer::JUSTIFY_LEFT);
// $printer->text("NOMBRE".'     DESCRIPCION '."   "."              ". 'TOTAL'."\n");
$totalGasto=0;
foreach($egresos as $gasto){ 
	$totalGasto=$totalGasto+$gasto->total;
	// $printer->setJustification(Printer::JUSTIFY_LEFT);
	// $printer->text($gasto->nombre."   ".$gasto->cantidad."\n");
	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
    // $printer->text($gasto->total . "bs\n");
} 
	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
	// $printer->setTextSize(1,1);
    // $printer->text("TOTAL INSUMO: " .$totalGasto."\n");
// $printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->setTextSize(2,1);
// $printer->text("LISTA DE GASTOS ADMIN.\n");
// $printer->setTextSize(1,1);
// $printer->setJustification(Printer::JUSTIFY_LEFT);
// $printer->text("NOMBRE".'     DESCRIPCION '."   "."              ". 'TOTAL'."\n");
$totalGasto1=0;
foreach($egresosadm as $gasto1){ 
	$totalGasto1=$totalGasto1+$gasto1->total;
	// $printer->setJustification(Printer::JUSTIFY_LEFT);
	// $printer->text($gasto1->nombre."   ".$gasto1->cantidad."\n");
	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
    // $printer->text($gasto1->total . "bs\n");
} 
	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
	// $printer->setTextSize(1,1);
    // $printer->text("TOTAL GASTOS ADMIN: " .$totalGasto1."\n");

// $printer->setJustification(Printer::JUSTIFY_CENTER);
// $printer->setTextSize(2,1);
// $printer->text("PRODUCTOS DE BAJAS.\n");
// $printer->setTextSize(1,1);
// $printer->setJustification(Printer::JUSTIFY_LEFT);
// $printer->text("NOMBRE".'     DESCRIPCION '."   "."              ". 'TOTAL'."\n");
$totalGasto2=0;
foreach($egresosdes as $gasto2){ 
	$totalGasto2=$totalGasto2+$gasto2->total;
	// $printer->setJustification(Printer::JUSTIFY_LEFT);
	// $printer->text($gasto2->nombre."   ".$gasto2->cantidad."\n");
	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
    // $printer->text($gasto2->total . "bs\n");
} 
	// $printer->setJustification(Printer::JUSTIFY_RIGHT);
	// $printer->setTextSize(1,1);
    // $printer->text("TOTAL BAJAS: " .$totalGasto2."\n");
// $printer->setTextSize(1,1);
// $printer->text("----------------------------------------------"."\n");
// $printer->setTextSize(2,1);
// $printer->text("MONTO DE APERTURA:".$monto_aperturado."Bs"."\n");
// $printer->text("TOTAL VENTAS:".$VENTAS."Bs"."\n");
$saldo=$VENTAS+$monto_aperturado;
// $printer->text("APERTURA+VENTAS:".$saldo."Bs"."\n");
// $printer->setTextSize(1,1);
// $printer->text(""."\n");
// $printer->text(""."\n");
// $printer->setTextSize(2,1);
// $printer->text("COMPRA INSUMOS:".$totalGasto."Bs"."\n");
// $printer->text("GASTOS ADMIN:".$totalGasto1."Bs"."\n");
// $printer->text("PRODUCTO DE BAJAS:".$totalGasto2."Bs"."\n");
$saldo=$VENTAS+$monto_aperturado;
// $printer->setTextSize(1,1);
//  //$printer->text("TOTAL DEL ARQUEO=".$total_arqueo."BS"."\n");
// $printer->text("--------------------------------------------"."\n");
// $printer->setJustification(Printer::JUSTIFY_CENTER);
//  //$printer->text( "COPIA 1 \n");
// $printer->setJustification(Printer::JUSTIFY_CENTER);
//  //$printer->text("NUMERO DE PEDIDO:".$idVenta."\n");
// $printer->feed(3);
// $printer->cut();
// $printer->pulse();
// $printer->close();
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
	//backupDatabaseTables('localhost','root','','dbjson',$tables='*');
	exit;
}
// else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";
// ?>