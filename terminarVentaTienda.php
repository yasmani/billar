 <?php
if(!isset($_POST["total"])) exit;


session_start();


$total = $_POST["total"];
//$descuento = 0;
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

function addSpaces($string = '', $valid_string_length = 0) {
    if (strlen($string) < $valid_string_length) {
        $spaces = $valid_string_length - strlen($string);
        for ($index1 = 1; $index1 <= $spaces; $index1++) {
            $string = $string . ' ';
        }
    }

    return $string;
} 


class Producto{
 
	public function __construct( $descuento,$nombre, $descripcion, $precio, $cantidad,$total){
		$this->descuento=$descuento;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
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
$sentencia = $base_de_datos->prepare("INSERT INTO ventastienda(descuento,fecha,hora, total,Thing,devolver,cliente,detalle,orden,apertura,tipoDeVenta,idUsuario,nombre_de_usuario,saldo,tarjeta,transferencia,entrega) VALUES (?,?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?,?);");
echo $descuento." -".$ahora." -".$hora." -".$total." -".$Thing." -". $devolver." -".$cliente." -".$detalle." -".$numero." -".$codigo_apertura." - TIPO".$tipoDeVenta." -".$idUsuario." -".$nombre_de_usuario;
$sentencia->execute([$descuento,$ahora,$hora,$total,$Thing, $devolver,$cliente,$detalle,$numero,$codigo_apertura,$tipoDeVenta,$idUsuario,$nombre_de_usuario,0,$tarjeta,$transferencia,$entrega]);
$last_insert=$base_de_datos->lastInsertId();
$sentencia = $base_de_datos->prepare("SELECT id FROM ventastienda ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idVenta = $resultado === false ? 1 : $resultado->id;


$sentencia = $base_de_datos->prepare("INSERT INTO productos_vendidos_tienda(id_producto,precio, id_venta, cantidad,descuento,detalle) VALUES (?,?,?, ?, ?,?);");
$sentenciaExistencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda - ? WHERE id = ?;");
 
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	$sentencia->execute([$producto->id,$producto->precioVenta, $idVenta, $producto->cantidad,$producto->descuento,$producto->descripcion]);
	$sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
	//$sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
}
			 
			
			$productos = array();
			foreach ($_SESSION["carrito"] as $indice => $producto) {
				array_push($productos,new Producto($producto->descuento,$producto->nombre,$producto->descripcion, $producto->precioVenta, $producto->cantidad,$producto->total));
	}
	$total = 0;
foreach ($productos as $producto) {
	$total += $producto->total;
 
	 
}
	 
//$nombre_impresora = "caja";  
//$connector = new WindowsPrintConnector($nombre_impresora);
//$printer = new Printer($connector);

//$printer->setJustification(Printer::JUSTIFY_RIGHT);
//$granTotal=0;
//$printer->setJustification(Printer::JUSTIFY_CENTER);
//$printer->text("--------------------------------" . "\n");
//$printer->setTextSize(3,1);
//$printer->text( (" TRADICION\n"));
//$printer->text("\n");
//$printer->text( ("VALLEGRANDINA\n"));
//$printer->setTextSize(2,1);
//$printer->text("\n");
//$printer->text("\n");
//$printer->setTextSize(1,1);

//$printer->setTextSize(3,1);
//			 $printer->text("ORDEN ".$numero."\n");
//			 $printer->setTextSize(2,1);
//			 $printer->text($tipoDeVenta=="1"?"PARA MESA"."\n":"PARA LEVAR"."\n");
//			 $printer->setTextSize(1,1);
//			 $printer->setJustification(Printer::JUSTIFY_LEFT);
//			 $printer->text("_______________________________ "."\n");
//			 $printer->setJustification(Printer::JUSTIFY_LEFT);
//			 $printer->text("     CAJERO:".$nombre_cajera."\n");
//			 $printer->text("     FECHA:".date("d-m-Y H:i:s")   ."\n");
//			 $printer->setJustification(Printer::JUSTIFY_LEFT);
//			 $printer->setJustification(Printer::JUSTIFY_CENTER);
//			 
//			 $printer->setTextSize(1,1);
//			 $printer->setJustification(Printer::JUSTIFY_LEFT);
//			 $printer->text("_______________________________ "."\n");
//			 $printer->setTextSize(1,1);
//			 $printer->setJustification(Printer::JUSTIFY_LEFT);
			 //$printer->text("     CANT".' PRECIO'."     DETALLE "."         ". 'SUBTOTAL'."\n");
//			 $printer->text("\n");
			 
//			 $printer->setTextSize(1,1);
			 //	$printer->text("-------------------------------------------"."\n");
//			 $printer->setPrintLeftMargin(0);
//		$printer->setJustification(Printer::JUSTIFY_LEFT);
//		$printer->setEmphasis(true);
		//$printer->text(addSpaces('CANT', 12) . addSpaces('ITEM', 18) .addSpaces('P', 8) . addSpaces('TO', 8) . "\n\n");
//		$printer->text(addSpaces('CANT', 5) . addSpaces('ITEM', 30) .addSpaces(' ', 5) . addSpaces('TOTAL', 5) . "\n\n");
//		$printer->setEmphasis(false);
		$items = [];
		
		$total=0;
		foreach ($productos as $producto) {
			
			$total += $producto->total;
			$items[] = [
				'name' => "  ". $producto->cantidad."  ".$producto->nombre ."       *(".strtolower($producto->descripcion).")" ,
				'qtyx_price' => $descripcion,
				'total_price' => $producto->cantidad* $producto->precio,
		'igst' => '',
		'cgst' => 'B ',
		'mrp' => ' C',
		'upr' => ' V',
	];
	 
}
 
//$printer->setTextSize(1,1);
foreach ($items as $item) {

    //Current item ROW 1
    $name_lines = str_split($item['name'], 40);
    foreach ($name_lines as $k => $l) {
		$l = trim($l);
        $name_lines[$k] = addSpaces($l, 40);
    }
	
    $qtyx_price = str_split($item['qtyx_price'], 1);
    foreach ($qtyx_price as $k => $l) {
		$l = trim($l);
        $qtyx_price[$k] = addSpaces($l, 1);
    }
	
    $total_price = str_split($item['total_price'], 10);
    foreach ($total_price as $k => $l) {
		$l = trim($l);
        $total_price[$k] = addSpaces($l, 10);
    }

    $counter = 0;
    $temp = [];
    $temp[] = count($name_lines);
    $temp[] = count($qtyx_price);
    $temp[] = count($total_price);
    $counter = max($temp);

    for ($i = 0; $i < $counter; $i++) {
		$line = '';
        if (isset($name_lines[$i])) {
			$line .= ($name_lines[$i]);
        }
        if (isset($qtyx_price[$i])) {
			$line .= ($qtyx_price[$i]);
        }
        if (isset($total_price[$i])) {
            $line .= ($total_price[$i]);
        }
       // $printer->text($line . "\n");
    }
	
    
}









		//$printer->setJustification(Printer::JUSTIFY_LEFT);
	//	$printer->text("_______________________________ "."\n");
	//	$printer->setJustification(Printer::JUSTIFY_RIGHT);
		//	$printer->setTextSize(2,1);
		//	$printer->text("TOTAL:".$total."Bs"."\n");
		//	$printer->text("TARJETA:".$tarjeta."Bs"."\n");
		//	$printer->text("QR:".$transferencia."Bs"."\n");
		//	$printer->text("EFECTIVO:".$Thing."Bs"."\n");
		//	$printer->text("CAMBIO:".$devolver."\n");
		//	$printer->setTextSize(1,2);
			
		//	$printer->setJustification(Printer::JUSTIFY_LEFT);
			
		//	$printer->setTextSize(1,1);
			
			
			
		//	$printer->text("NOTA:".$detalle." \n");
		//	$printer->setJustification(Printer::JUSTIFY_LEFT);
		//	$printer->text("_______________________________ "."\n");
			 
		//	$printer->setJustification(Printer::JUSTIFY_CENTER);
		//	$printer->text("HORARIO ATENCIÓN \n");
		//	$printer->text("DE JUEVES  A DOMINGO  \n");
		//	//$printer->text("5:00 AM - 3:00 AN \n");
		//	$printer->text("MUCHAS GRACIAS POR SU PREFENRENCIA  \n");
		//	$printer->setTextSize(1,1);
			//$printer->text("Pedidos al 69207626  \n");
		//	$printer->feed(3);
		//	$printer->feed(3);
		//	$printer->cut();
		//	$printer->pulse();
		//	$printer->close();
		






			$total=0;




		//	$nombre_impresora = "cocina";  
		//	$connector = new WindowsPrintConnector($nombre_impresora);
		//	$printer = new Printer($connector);
			
		//	$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$granTotal=0;
		//	$printer->setJustification(Printer::JUSTIFY_CENTER);
			//$printer->text("--------------------------------" . "\n");
		//	$printer->setTextSize(3,1);
		//	$printer->text( (" TRADICION\n"));
		//	$printer->text("\n");
		//	$printer->text( ("VALLEGRANDINA\n"));
		//	$printer->setTextSize(2,1);
		//	$printer->text("\n");
		//	$printer->text("\n");
		//	$printer->setTextSize(1,1);
			
		//	$printer->setTextSize(3,1);
						// $printer->text("ORDEN ".$numero."\n");
						// $printer->setTextSize(2,1);
						// $printer->text($tipoDeVenta=="1"?"PARA MESA"."\n":"PARA LEVAR"."\n");
					//	 $printer->setTextSize(1,1);
					//	 $printer->setJustification(Printer::JUSTIFY_LEFT);
						// $printer->text("_______________________________ "."\n");
						// $printer->setJustification(Printer::JUSTIFY_LEFT);
						// $printer->text("     CAJERO:".$nombre_cajera."\n");
						// $printer->text("     FECHA:".date("d-m-Y H:i:s")   ."\n");
						// $printer->setJustification(Printer::JUSTIFY_LEFT);
						// $printer->setJustification(Printer::JUSTIFY_CENTER);
						 
						// $printer->setTextSize(1,1);
						// $printer->setJustification(Printer::JUSTIFY_LEFT);
						// $printer->text("_______________________________ "."\n");
					//	 $printer->setTextSize(1,1);
						 //$printer->setJustification(Printer::JUSTIFY_LEFT);
						 //$printer->text("     CANT".' PRECIO'."     DETALLE "."         ". 'SUBTOTAL'."\n");
						 //$printer->text("\n");
						 
						 //$printer->setTextSize(1,1);
						 //	$printer->text("-------------------------------------------"."\n");
						 //$printer->setPrintLeftMargin(0);
				//	$printer->setJustification(Printer::JUSTIFY_LEFT);
				//	$printer->setEmphasis(true);
					//$printer->text(addSpaces('CANT', 12) . addSpaces('ITEM', 18) .addSpaces('P', 8) . addSpaces('TO', 8) . "\n\n");
				//	$printer->text(addSpaces('CANT', 5) . addSpaces('ITEM', 30) .addSpaces(' ', 5) . addSpaces('TOTAL', 5) . "\n\n");
				//	$printer->setEmphasis(false);
					$items = [];
					
			
					foreach ($productos as $producto) {
						
						$total += $producto->total;
						$items[] = [
							'name' => "  ". $producto->cantidad."  ".$producto->nombre ."      *(".strtolower($producto->descripcion).")" ,
							'qtyx_price' => " ",
							'total_price' => $producto->cantidad* $producto->precio,
					'igst' => '',
					'cgst' => 'B ',
					'mrp' => ' C',
					'upr' => ' V',
				];
				 
			}
			 
//$printer->setTextSize(1,1);
			foreach ($items as $item) {
			
				//Current item ROW 1
				$name_lines = str_split($item['name'], 40);
				foreach ($name_lines as $k => $l) {
					$l = trim($l);
					$name_lines[$k] = addSpaces($l, 40);
				}
				
				$qtyx_price = str_split($item['qtyx_price'], 1);
				foreach ($qtyx_price as $k => $l) {
					$l = trim($l);
					$qtyx_price[$k] = addSpaces($l, 1);
				}
				
				$total_price = str_split($item['total_price'], 10);
				foreach ($total_price as $k => $l) {
					$l = trim($l);
					$total_price[$k] = addSpaces($l, 10);
				}
			
				$counter = 0;
				$temp = [];
				$temp[] = count($name_lines);
				$temp[] = count($qtyx_price);
				$temp[] = count($total_price);
				$counter = max($temp);
			
				for ($i = 0; $i < $counter; $i++) {
					$line = '';
					if (isset($name_lines[$i])) {
						$line .= ($name_lines[$i]);
					}
					if (isset($qtyx_price[$i])) {
						$line .= ($qtyx_price[$i]);
					}
					if (isset($total_price[$i])) {
						$line .= ($total_price[$i]);
					}
				//	$printer->text($line . "\n");
				}
				
				
			}
			
			
			
			
			
			
			
			
			
				//	$printer->setJustification(Printer::JUSTIFY_LEFT);
				//	$printer->text("_______________________________ "."\n");
				//	$printer->setJustification(Printer::JUSTIFY_RIGHT);
					//	$printer->setTextSize(2,1);
					//	$printer->text("TOTAL:".$total."Bs"."\n");
					//	$printer->text("TARJETA:".$tarjeta."Bs"."\n");
					//	$printer->text("QR:".$transferencia."Bs"."\n");
					//	$printer->text("EFECTIVO:".$Thing."Bs"."\n");
					//	$printer->text("CAMBIO:".$devolver."\n");
					//	$printer->setTextSize(1,2);
						
					//	$printer->setJustification(Printer::JUSTIFY_LEFT);
						
					//	$printer->setTextSize(1,1);
						
						
					//	
					//	$printer->text("NOTA:".$detalle." \n");
					//	$printer->setJustification(Printer::JUSTIFY_LEFT);
					//	$printer->text("_______________________________ "."\n");
						 
					//	$printer->setJustification(Printer::JUSTIFY_CENTER);
					//	$printer->text("HORARIO ATENCIÓN \n");
					//	$printer->text("DE JUEVES  A DOMINGO  \n");
					//	//$printer->text("5:00 AM - 3:00 AN \n");
					//	$printer->text("MUCHAS GRACIAS POR SU PREFENRENCIA  \n");
					//	$printer->setTextSize(1,1);
						//$printer->text("Pedidos al 69207626  \n");
					//	$printer->feed(3);
					//	$printer->feed(3);
					//	$printer->cut();
					//	$printer->pulse();
					//	$printer->close();
					
			































 
$base_de_datos->commit();
//unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
$error = [ 'id' => $last_insert ];
$error = serialize($error);
$error = urlencode($error);
/* OJO: agregamos 'mensaje=' para que en el otro lado llegue como $_GET['mensaje'] */
//sheader("Location: subidaarchivos.php?mensaje=" . $error);
// header("Location: ./venderTienda.php?status=1");
header("Location: ./imprimir_tienda.php?ticket=".$error);
?>