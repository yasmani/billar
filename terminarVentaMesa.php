<?php
 

session_start();


$total = $_POST["total"];
//$descuento = 0;
$idmesa = $_POST["idmesa"];
$cliente = $_POST["cliente"];
$entrega = $_POST["entrega"];
$detalle = $_POST["detalle"];
$tipoDeVenta = $_POST["tipoDeVenta"];
$nombre_de_usuario =$_POST["nombre_de_usuario"] ;
$idUsuario =$_POST["idUsuario"] ;
$transferencia = $_POST["transferencia"];
$tarjeta = $_POST["tarjeta"];
$descuento = $_POST["descuento"];
$orden = 1;
//$orden = $_POST["orden"];
$Thing = $_POST["Thing"];
$devolver = $_POST["devolver"];


include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

date_default_timezone_set("America/La_Paz");

$ahora = date("Y-m-d H:i:s");
$hora = date("H:i:s");
class Producto{
 
	public function __construct( $descuento,$nombre, $precio, $cantidad,$total){
		$this->descuento=$descuento;
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->cantidad = $cantidad;
		$this->total = $total;
	}
}
/* obteniendo datos del cajero*/
$sentencia = $base_de_datos->query("SELECT * FROM apertura_tienda where estado='0';");
$cajero = $sentencia->fetchAll(PDO::FETCH_OBJ);
$nombre_cajera="";
$codigo_apertura=0;
 foreach($cajero as $caja){ 
	$nombre_cajera=$caja->cajera;
	$codigo_apertura=$caja->id;
 }

 /*fin de la caputara  de datos del cliente*/
 /*obteniendo el numero de orden*/
  $ap = $base_de_datos->prepare("SELECT count(*) as cantidad FROM ventastienda where apertura='$codigo_apertura'");
  $ap->execute();
  $platos_ordenados = $ap->fetch(PDO::FETCH_OBJ);
  $numero=$platos_ordenados->cantidad+1;
  
 /*fin*/
 $base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("INSERT INTO ventastienda(descuento,fecha,hora, total,Thing,devolver,cliente,detalle,orden,apertura,tipoDeVenta,idUsuario,nombre_de_usuario,saldo,tarjeta,transferencia,entrega,entregado) VALUES (?,?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?,?,?);");
// echo $descuento." -".$ahora." -".$hora." -".$total." -".$Thing." -". $devolver." -".$cliente." -".$detalle." -".$numero." -".$codigo_apertura." -".$tipoDeVenta." -".$idUsuario." -".$nombre_de_usuario;
$sentencia->execute([$descuento,$ahora,$hora,$total,$Thing, $devolver,$cliente,$detalle,$numero,$codigo_apertura,$tipoDeVenta,$idUsuario,$nombre_de_usuario,0,$tarjeta,$transferencia,$entrega,$idmesa]);
$last_insert=$base_de_datos->lastInsertId();
$sentencia = $base_de_datos->prepare("SELECT id FROM ventastienda ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idVenta = $resultado === false ? 1 : $resultado->id;


$sentencia = $base_de_datos->prepare("INSERT INTO productos_vendidos_tienda(id_producto,precio, id_venta, cantidad,descuento,apertura) VALUES (?,?, ?, ?,?,?);");
$sentenciabillar = $base_de_datos->prepare("INSERT INTO productos_vendidos_tienda(inicio,fin,id_producto,precio, id_venta, cantidad,descuento,apertura) VALUES (?,?,?,?, ?, ?,?,?);");
// $sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda - ? WHERE id = ?;");



$idUsuario=$_COOKIE["id"];
$sql = $base_de_datos->query("SELECT productos.lote,productos.precioVenta, carrito.fechaInicio,carrito.fechaFin,productos.id as idproducto,carrito.precio, carrito.id,productos.nombre,carrito.cantidad,carrito.usuario,carrito.idmesa,productos.imagen ,carrito.cantidad*carrito.precio as total FROM `carrito`,productos WHERE productos.id=carrito.idproducto and carrito.idmesa='$idmesa' ;");
$aperturados = $sql->fetchAll(PDO::FETCH_OBJ);

foreach($aperturados as $producto){ 

	
	$total += $producto->total; 
	if($producto->lote=='BILLAR'){
	    $c=$producto->precio/$producto->precioVenta;
	    echo "hola".$producto->fechaInicio." ".$producto->fechaFin;
	  //  $sentenciabillar->execute([$producto->fechaInicio,$producto->fechaFin,$producto->idproducto,$producto->precioVenta, $idVenta, $c,0]);

	  $sentenciabillar->execute([$producto->fechaInicio,$producto->fechaFin,$producto->idproducto,$producto->precio, $idVenta, $c,0,$codigo_apertura]);
	}else{
	   // $sentencia->execute([$producto->idproducto,$producto->precio, $idVenta, $producto->cantidad,0]);
	   $sentencia->execute([$producto->idproducto,$producto->precio, $idVenta, $producto->cantidad,0,$codigo_apertura]);
	}
	
// 	$sentenciaExistencia->execute([$producto->cantidad, $producto->idproducto]);
}
// $delete = $base_de_datos->prepare("DELETE FROM atencion WHERE usuario = ? and idmesa=?;");
// $resultado = $delete->execute([$idUsuario,$idmesa]);			 
$carrito = $base_de_datos->prepare("DELETE carrito FROM carrito WHERE  idmesa=?;");
$resultado = $carrito->execute([ $idmesa]);			 
$update = $base_de_datos->prepare("UPDATE `mesa` SET `condicion` = '0'     WHERE id = ?;");
$resultado = $update->execute([ $idmesa]);			 
 



$sentencia3 = $base_de_datos->prepare("DELETE FROM pausas_billar WHERE id_mesa = ?;");
$resultado2 = $sentencia3->execute([$idmesa]);

$total = 0;



$base_de_datos->commit();
unset($_SESSION["carrito"]);
//$p=$_SESSION["carrito"];
$_SESSION["carrito"] = [];
/* En la captura de tu pregunta aparenta estar definido así 'error' */
$error = [ 'id' => $last_insert ];
$error = serialize($error);
$error = urlencode($error);
/* OJO: agregamos 'mensaje=' para que en el otro lado llegue como $_GET['mensaje'] */
//sheader("Location: subidaarchivos.php?mensaje=" . $error);
// header("Location: ./venderMesa.php?status=1");
header("Location: ./imprimir_tienda.php?ticket=".$error);


?>