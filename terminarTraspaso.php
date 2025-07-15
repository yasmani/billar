 <?php
if(!isset($_POST["total"])) exit;


session_start();


$total = $_POST["total"];
//$descuento = 0;
$cliente = $_POST["cliente"];
//$habitacion = $_POST["habitacion"];
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
  $ap = $base_de_datos->prepare("SELECT count(*) as cantidad FROM traspaso where apertura='$codigo_apertura'");
  $ap->execute();
  $platos_ordenados = $ap->fetch(PDO::FETCH_OBJ);
  $numero=$platos_ordenados->cantidad+1;
  
 /*fin*/
 $base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("INSERT INTO traspaso(descuento,fecha,hora, total,Thing,devolver,cliente,detalle,orden,apertura,tipoDeVenta,idUsuario,nombre_de_usuario,saldo,tarjeta,transferencia) VALUES (?,?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?);");
echo $descuento." -".$ahora." -".$hora." -".$total." -".$Thing." -". $devolver." -".$cliente." -".$detalle." -".$numero." -".$codigo_apertura." -".$tipoDeVenta." -".$idUsuario." -".$nombre_de_usuario;
$sentencia->execute([$descuento,$ahora,$hora,$total,$Thing, $devolver,$cliente,$detalle,$numero,$codigo_apertura,$tipoDeVenta,$idUsuario,$nombre_de_usuario,0,$tarjeta,$transferencia]);
$last_insert=$base_de_datos->lastInsertId();
$sentencia = $base_de_datos->prepare("SELECT id FROM traspaso ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idTraspaso = $resultado === false ? 1 : $resultado->id;


$sentencia = $base_de_datos->prepare("INSERT INTO productos_traspasados(id_producto,precio, id_traspaso, cantidad,descuento) VALUES (?,?, ?, ?,?);");
$sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda - ?,existencia = existencia + ? WHERE id = ?;");
 
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	$sentencia->execute([$producto->id,$producto->precioVenta, $last_insert, $producto->cantidad,$producto->descuento]);
	$sentenciaExistencia->execute([$producto->cantidad,$producto->cantidad, $producto->id]);
	//$sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
}
			 
			
			$productos = array();
			foreach ($_SESSION["carrito"] as $indice => $producto) {
				array_push($productos,new Producto($producto->descuento,$producto->nombre, $producto->precioVenta, $producto->cantidad,$producto->total));
	}
	$total = 0;
foreach ($productos as $producto) {
	$total += $producto->total;
 
	//$printer->setJustification(Printer::JUSTIFY_LEFT);
    //$printer->text($producto->cantidad . " x " . $producto->precio. "bs.  " . $producto->nombre. "\n");
    //$printer->setJustification(Printer::JUSTIFY_RIGHT);
   //$printer->text(' bs' . $producto->total . "\n");
}
	//$printer->text("------------------------------------------------"."\n");
	//$printer->setJustification(Printer::JUSTIFY_RIGHT);
	//$printer->setTextSize(2,1);
	//$printer->text("TOTAL:".$total."Bs"."\n");
	//$printer->text("EFECTIVO:".$Thing."Bs"."\n");
	//$printer->text("CAMBIO:".$devolver."\n");
	//$printer->setTextSize(1,2);
	  
	//$printer->setJustification(Printer::JUSTIFY_LEFT);
	  
	//$printer->setTextSize(1,1);
	
	 
	
	//$printer->text("NOTA:".$detalle." \n");
	
	//$printer->text("--------------------------------------------"."\n");
	//$printer->setJustification(Printer::JUSTIFY_CENTER);
	//$printer->text("HORARIO ATENCIÓN \n");
	//$printer->text("LUNES - DOMINGOS  \n");
	//$printer->text("6:00 AM - 23:00 PM \n");
	//$printer->text("***MUCHAS GRACIAS POR SU PREFENRENCIA*** \n");
	//$printer->feed(3);
	//$printer->cut();
//$printer->pulse();
//$printer->close();
 
$base_de_datos->commit();
unset($_SESSION["carrito"]);
$p=$_SESSION["carrito"];
$_SESSION["carrito"] = [];
/* En la captura de tu pregunta aparenta estar definido así 'error' */
$error = [ 'id' => $last_insert ];
$error = serialize($error);
$error = urlencode($error);
/* OJO: agregamos 'mensaje=' para que en el otro lado llegue como $_GET['mensaje'] */
//sheader("Location: subidaarchivos.php?mensaje=" . $error);
header("Location: ./traspaso.php?status=1");
//header("Location: ./imprimir.php?ticket=".$error);
?>