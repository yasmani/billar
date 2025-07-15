 <?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";

$base_de_datos->beginTransaction();

$sqlcompras = $base_de_datos->query("SELECT productos_comprados_tienda.id,productos_comprados_tienda.id_producto,productos_comprados_tienda.cantidad FROM `comprastienda`,productos_comprados_tienda WHERE comprastienda.id=productos_comprados_tienda.id_compra and comprastienda.id='$id'");
//SELECT productos_comprados_tienda.id,productos_comprados_tienda.id_producto,productos_comprados_tienda.cantidad FROM `comprastienda`,productos_comprados_tienda WHERE comprastienda.id=productos_comprados_tienda.id_compra and comprastienda.id='9';

$compras = $sqlcompras->fetchAll(PDO::FETCH_OBJ); 

foreach($compras as $productos){ 
	$id_producto=$productos->id_producto;
	$cantidad=$productos->cantidad; 

	$sentencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda-?  WHERE id = ?;");
	$resultado = $sentencia->execute([$cantidad, $id_producto]);

	if($resultado === TRUE){
		//header("Location: ./listar.php");
		//exit;
	}
	else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";

 }
 $sentencia = $base_de_datos->prepare("DELETE FROM comprastienda WHERE id = ?;");
 $resultado = $sentencia->execute([$id]);
 
 $base_de_datos->commit();
 if($resultado === TRUE){
	 header("Location: ./imprimir_compras_tienda.php");
	 exit;
	}
else echo "Algo salió mal";
?>