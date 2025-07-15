<?php
 
//id del producto
$idProducto = $_POST["id"];
$cantidad = $_POST["cantidad"];
$categoria = $_GET["categoria"];
$usuario2 = $_POST["usuario"];
$idmesa = $_POST["idmesa"];
$precio = $_POST["precio"];
$opcion = $_POST["opcion"];
$precio3 = $_POST["precio3"];
//$categoria = isset($_POST["cantidad"])?$_POST["cantidad"]:'';
 //echo $usuario2;
include_once "base_de_datos.php";
 date_default_timezone_set("America/La_Paz");
$base_de_datos->beginTransaction();

$sentencia2 = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ?   ");
$sentencia2->execute([$idProducto]);
$producto1 = $sentencia2->fetch(PDO::FETCH_OBJ);
# Si no existe, salimos y lo indicamos
if (!$producto1) {
    echo 'no existe producto';
    header("Location: ./venderMesa.php?status=4");
    exit;
}
# Si no hay tienda...
if ($producto1->tienda == 0) {
    header("Location: ./venderMesa.php?categoria=".$categoria."&status=5");
 
    exit;
}

 echo 'id produ'.$idProducto.'id mesa'.$idmesa.'<br>';
  echo 'opcion : '.$opcion.' precio especial'.$precio3.'<br>';
	$sentencia = $base_de_datos->query("SELECT * FROM carrito where idproducto='$idProducto' and  idmesa='$idmesa';");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
$idCarrito=0;
$nombre='';
$fecha=date("Y-m-d H:i:s");
  foreach($productos as $producto){  
		$idCarrito=$producto->id ;
    
		//$nombre=$producto->nombre ;
		//echo $nombre, '  codigo='.$codigo.'-  '.$producto->tienda.'- '.$producto->precioVenta3.' producto ' ;	
		}
 echo 'id carrito '.$idCarrito.'<br>';
if($idCarrito!='0' && $idProducto!='23'){
    $sentencia = $base_de_datos->prepare("UPDATE carrito SET cantidad = cantidad+ ?  WHERE id = ?;");
    $resultado = $sentencia->execute([$cantidad,  $idCarrito]);
        $sentencia22 = $base_de_datos->prepare("UPDATE productos SET tienda = tienda - ?  WHERE id = ?;");
      $sentencia22->execute([1,  $idProducto]);
}else{
  $sentencia = $base_de_datos->prepare("INSERT INTO carrito(idproducto, cantidad,usuario,idmesa,precio,fechaInicio,titulo) VALUES (?, ?,?,?,?,?,?);");

  if($categoria=='BILLAR'){

	  $resultado2 = $sentencia->execute([$idProducto,$cantidad,$usuario2 ,$idmesa,0,$fecha ]);
	}else{

    if($opcion==2){
      $titulo=$producto1->titulo;
      $resultado2 = $sentencia->execute([$idProducto,$cantidad,$usuario2 ,$idmesa,$precio3,$fecha,$titulo ]);
		    $sentencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda - ?  WHERE id = ?;");
    $resultado = $sentencia->execute([1,  $idProducto]);

    }else{
      $titulo=$producto1->nombre;
      $resultado2 = $sentencia->execute([$idProducto,$cantidad,$usuario2 ,$idmesa,$precio,$fecha,$titulo ]);
		    $sentencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda - ?  WHERE id = ?;");
        $resultado = $sentencia->execute([1,  $idProducto]);
    }
		
	}
   echo 'resultado;'.$resultado2;
}
echo $idProducto.' -'.$cantidad.'- '.$usuario2 .' -'.$idmesa.' -'.$precio; 

$base_de_datos->commit();
header("Location: ./venderMesa.php?categoria=".$categoria);
