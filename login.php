<?php
 

?>
<?php include_once "encabezado.php" ?>
	<div class="col-xs-12">
	<h1>SOLO PERSONAL AUTORIZADO</h1>
		<div class="container">
		<form method="post" action="listarR.php" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $producto->id; ?>">
	
			<label for="usuario">USUARIO:</label>
			<input class="form-control" name="usuario" required type="text" id="usuario" placeholder=" ">

			 

			<label for="password">CONTRASEÑA:</label>
			<input   class="form-control" name="password" type="password" id="password"  >

 
	</div>
	<br><br>
			<input class="btn btn-info" type="submit" value="ACCEDER">
			<a class="btn btn-warning" href="./vender.php">CANCELAR</a>
			
		</form>
		</div>
	</div>
<?php include_once "pie.php" ?>
