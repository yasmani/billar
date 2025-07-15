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
$sentencia = $base_de_datos->prepare("SELECT * FROM usuario WHERE id = ?;");
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
		
		<h1>EDITAR  USUARIO : <?php echo $producto->id; ?></h1>
		<form method="post" action="guardarDatosEditadosUsuario.php" enctype="multipart/form-data">
	
			<input value="<?php echo $producto->id ?>" class="form-control" name="id" required type="hidden" id="codigo" placeholder="Escribe el código">

			<label for="descripcion">USUARIO:  </label>
			<input value="<?php echo $producto->usuario ?>" class="form-control" name="usuario"   type="text" id="descripcion" placeholder="descripcion" >
			<label for="lote">contraseña:  </label>
			<input value="<?php echo $producto->clave ?>" class="form-control" name="clave"   type="text" id="lote" placeholder="lote" >

			<label for="precioCompra">TIPO: administrador/cajero</label>
			<input value="<?php echo $producto->tipo=='cajero'?'administrador':'cajero' ?>" class="form-control" name="tipo"   type="text" id="precioCompra" placeholder="Precio de compra" step="0.01">
 
			<br>
	</div>
	<br><br>
			<input class="btn btn-info" type="submit" value="GUARDAR  ">
			<a class="btn btn-warning" href="./usuarios.php">CANCELAR</a>
			
		</form>
	</div>
<?php include_once "pie.php" ?>
