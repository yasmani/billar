<?php
if(!isset($_COOKIE["usuario"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
} 
 if($tipo=='administrador'){
include_once "encabezado.php";
}
if($tipo=='cajero'){
include_once "encabezado3.php";
}
if($tipo=='ambulante'){
	include_once "encabezado4.php";
}


if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ?;");
$sentencia->execute([$id]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
if($producto === FALSE){
	echo "¡No existe algún producto con ese ID!";
	exit();
}

?>
<?php 


?>
	<div class="col-xs-12">
		
		<h1>EDITAR PRODUCTO CON EL CODIGO: <?php echo $producto->codigo; ?></h1>
		<form method="post" action="guardarDatosEditados.php" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $producto->id; ?>">
	
			<label for="codigo">CODIGO:</label>
			<input value="<?php echo $producto->codigo ?>" class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
			<label for="nombre">NOMBRE:</label>
			<textarea required id="nombre" name="nombre" cols="30" rows="1" class="form-control"><?php echo $producto->nombre ?></textarea>

			<label for="descripcion">descripcion:  </label>
			<input value="<?php echo $producto->descripcion ?>" class="form-control" name="descripcion"   type="text" id="descripcion" placeholder="descripcion" >
			<label for="lote">categoria:  </label>
			<input value="<?php echo $producto->lote ?>" class="form-control" name="lote"   type="text" id="lote" placeholder="lote" >

			<label for="precioCompra">COSTO UNITARIO:</label>
			<input value="<?php echo $producto->precioCompra ?>" class="form-control" name="precioCompra"   type="number" id="precioCompra" placeholder="Precio de compra" step="0.01">

			<label for="precioVenta">PRECIO :</label>
			<input value="<?php echo $producto->precioVenta ?>" class="form-control" name="precioVenta" required type="number" id="precioVenta" placeholder="Precio de venta" step="0.01">
			<!--<label for="precioVenta">PRECIO 2:</label>-->
			<input value="<?php echo $producto->precioVenta2 ?>" class="form-control" name="precioVenta2" required type="hidden" id="precioVenta2" placeholder="Precio de venta" step="0.01">
			<!--<label for="precioVenta">PRECIO 3:</label>-->
			<input value="<?php echo $producto->precioVenta3 ?>" class="form-control" name="precioVenta3" required type="hidden" id="precioVenta3" placeholder="Precio de venta" step="0.01">


			
			<label for="existencia">CANTIDAD:</label>
			<input value="<?php echo $producto->tienda ?>" class="form-control" name="tienda" type="text" id="tienda"  >
			<!--<label for="existencia">ALMACEN:</label>-->
			<input value="<?php echo $producto->existencia ?>" class="form-control" name="existencia" type="hidden" id="existencia"  >
			<!--<label for="existencia">STOCK MINIMO:</label>-->
			<input value="<?php echo $producto->stockminimo ?>" class="form-control" name="stockminimo" type="hidden" id="existencia"  >

  
			
			<label style="display: none;" for="">NUEVA FOTO</label>
			<div   class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
 		<label>IMAGEN:</label>
		 <input type="file" class="form-control" name="imagen" id="imagen">

		<input type="hidden" value="<?php echo $producto->imagen ?>" name="imagenactual" id="imagenactual">

		<img src='files/articulos/<?php echo $producto->imagen?>'  width="150px" height="120px" id="imagenmuestra">
	</div>
	<br><br>
			<input class="btn btn-info" type="submit" value="GUARDAR PRODUCTO">
			<a class="btn btn-warning" href="./listar.php">CANCELAR</a>
			
		</form>
	</div>
<?php// include_once "pie.php" ?>
