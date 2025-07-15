<?php 
if(!isset($_COOKIE["usuario"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
}

if ($tipo=='administrador') {
	include_once "encabezado.php";
	# code...
} else {
	header("Location: ./vender.php");
	# code...
}

?>
<?php
include_once "base_de_datos.php";
  
$sentencia = $base_de_datos->query("SELECT * FROM productos;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>LISTAS DE PRODUCTOS</h1>
		<div>
		  <a class="btn btn-success" href="./formularioR.php">NUEVO ITEM <i class="fa fa-plus"></i></a> 
		  <a class="btn btn-warning" target="_blank" href="./reportes/imprimirinv.php">IMPRIMIR INVENTARIO <i class="fa fa-print"></i></a> 
		 <!-- <a class="btn btn-warning" href="./compras.php">AUMENTAR STOCK <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-info" href="./listar-inventario.php">INVENTARIO <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-danger" href="./listar.php">VOLVER A LISTA <i class=""></i></a>  -->






		</div>
		<br>
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<!-- <th>ID</th> -->
					<th>CODIGO</th>
					<th>NOMBRE</th>
					<th>DESCRIPCION</th>
					<th>CATEGORIA</th>
					<th>PRECIO 1</th>
					<th>PRECIO 2</th>
					<th>PRECIO 3</th>
					<th>ALMACEN</th>
					<th>TIENDA</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($productos as $producto){ ?>
				<tr>
					
					<td><?php echo $producto->codigo ?></td>
					<td><?php echo $producto->nombre ?></td>
					<td><?php echo $producto->descripcion ?></td>
					<td><?php echo $producto->lote ?></td>
					<td><?php echo $producto->precioVenta ?></td>
					<td><?php echo $producto->precioVenta2 ?></td>
					<td><?php echo $producto->precioVenta3 ?></td>
					<td><?php echo $producto->existencia ?></td>
					<td><?php echo $producto->tienda ?></td>
					
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php //include_once "pie.php" ?>