   <?php 
session_start();
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


?>

<div class="col-xs-6">
	<h1>FRACIONAMIENTO </h1>
	<form method="post" enctype="multipart/form-data" action="guardarFraccionamiento.php" >
		<label for="codigo">NOMBRE :</label>
		<input class="form-control" name="nombre" autofocus required type="text" id="nombre" placeholder="Escribe nombre">
		<!--<label for="cantidad">DESCRIPCION :</label>-->
		<input class="form-control" name="cantidad"    type="hidden" id="cantidad" placeholder="Escribe la descripcion">
			<input class="form-control" name="detalle" value ="<?php  echo $idCajera?>" required type="hidden" id="detalle" placeholder="Escribe nombre">

		<!-- <label for="descripcion">detalle:</label> -->

		<label for="precioCompra">MONTO:</label>
		
	
	
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="total" id="total" required>
 
		<br><br><input class="btn btn-info" type="submit" value="GUARDAR">
	</form>
	 
 
</div>
<div class="col-xs-6">
    		<label for="precioCompra">REGISTRADOS:</label>
    		
    		
    		
    		<?php
    		$sentencia = $base_de_datos->query("SELECT * FROM fraccionamiento  where detalle='$idCajera'  ;");
 
//$sentencia = $base_de_datos->query("SELECT * FROM productos ;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>


 
		 
 
		<table style="" name="tabla" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<!-- <th>ID</th> -->
					<th>id</th>
					<th>nombre</th>
					<th>monto</th>
				 
					<th>ELIMINAR</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$total=0;
				foreach($productos as $producto){ ?>
				<tr>
					
					<td><?php echo $producto->egresoid ?></td>
 					<td><?php echo $producto->nombre ?></td>
					<td><?php echo $producto->total ;
					
					$total+=$producto->total;?></td>
					 
					<td><a class="btn btn-danger" href="<?php echo "eliminar.php?id=" . $producto->id?>"><i class="fa fa-trash"></i></a></td>
				</tr>
				
				<?php } ?>
					<tr> 
					<td> </td>
					<td> </td>
				 
					<td> <?php echo $total?> bs</td></tr>
			</tbody>
		
		</table>
		
		
		
    </div>
 
