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
<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
 
$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT * FROM apertura_tienda where estado='1' order by id desc");
//$sentencia = $base_de_datos->query("SELECT ventas.orden,ventas.arqueo,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos FROM ventas  INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id INNER JOIN productos ON productos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id DESC;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>ARQUEOS</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		<br>
		<table style="color:black" name="tabla" class="table table-bordered">
			<thead style="color:black; " name="tabla" class="table table-darger">
				<tr style="background-color: #395a94;color:white">
					<th>fecha de apertura</th>
					<th>cajero</th>
					<th>Apertura</th>
					<th>imprimir</th>
					
					    <?php 


						if($tipo=='cajero'){
							?>
							<th>Detalle</th>
								<?php	
						}?>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				
				foreach($ventas as $venta){ 
					// if("0"=="0"){
						?>
				<tr> 
				
					<td><?php echo $venta->id.' '.date("d/m/Y  H:i:s", strtotime($venta->fecha)); ?></td>
					<td><?php echo $venta->cajera ?></td>
					<td><?php echo $venta->monto ?></td>
				<td><a class="btn btn-info" href="<?php echo "imprimir_arqueo_tienda.php?id=" . $venta->id."&fecha=".$venta->fecha?>"><i class="fa fa-print"></i></a></td>
				    <?php 


if($tipo=='cajero'){
	?>
	<td><a class="btn btn-success" href="<?php echo "imprimir_arqueo_mesa.php?id=" . $venta->id."&fecha=".$venta->fecha?>"><i class="fa fa-table"></i></a></td>
	<?php	
}
			 
				?>
				</tr>
				<?php 
				}
				?>
			</tbody>
		</table>
		<div>   
		  
		</div>
			<h3>TOTAL VENDIDO:

		<?php
				
				//echo $totalvendido. "  Bs."  
				?> 
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	</div>
<?php include_once "pie.php" ?>