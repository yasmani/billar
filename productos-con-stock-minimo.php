<?php 
if(!isset($_COOKIE["usuario"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
}   
include_once "encabezado.php" ;?>
<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos where productos.existencia<productos.stockminimo or productos.existencia<='1' ;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>PRODUCTOS CON STOCK MINIMO DE LA TIENDA</h1>
		<br>
		<table style="background-color:#28293B ;color:white" class="table table-bordered">
			<thead>
				<tr style="background-color: blue">
					<th>CODIGO</th>
					<th>NOMBRE</th>
					<th>DESCRIPCION</th>
					<th>PRECIO DE COMPRA</th>
					<th>PRECIO DE VENTA</th>
					<th>DISPONIBLES</th>
					<th>IMAGEN</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($productos as $producto){ ?>
				<tr>
					<td><?php echo $producto->codigo ?></td>
					<td><?php echo $producto->nombre ?></td>
					<td><?php echo $producto->descripcion ?></td>
					<td><?php echo $producto->precioCompra ?></td>
					<td><?php echo $producto->precioVenta ?></td>
					<td><?php echo $producto->existencia ?></td>
					<td> <?php echo  "<img src='files/articulos/".$producto->imagen."' height='50px' width='50px' >" ?></td>
					 
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php include_once "pie.php" ?>