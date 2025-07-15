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
 
 
 ?>
<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
 

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT traspaso.descuento,traspaso.tipoDeVenta, traspaso.hora,traspaso.nombre_de_usuario,traspaso.orden,traspaso.arqueo,traspaso.total, traspaso.fecha, traspaso.id , GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_traspasados.cantidad , '..', productos_traspasados.precio SEPARATOR '__') AS productos FROM traspaso INNER JOIN productos_traspasados ON productos_traspasados.id_traspaso = traspaso.id INNER JOIN productos ON productos.id = productos_traspasados.id_producto GROUP BY traspaso.id ORDER BY traspaso.id DESC;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>IMPRIMIR BAJAS</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 
		<br>
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<th>NUMERO</th>
					<th>FECHA</th>
					<th>HORA</th>
					<th>VENDEDOR</th>
					<!-- <th>venta al</th> -->
					<th>PRODUCTOS VENDIDOS</th>
					<th>SubTotal</th>
					<th>Descuento del total</th>
					<th>TOTAL</th>
					<?php 
					     if ($tipo=='administrador') {
					         echo '<th>eliminar</th>';
					     }
					     ?>
					
					<th>Imprimir</th>
					<th>Eliminar</th> 
				</tr>
			</thead>
			<tbody style='color:black'>
				<?php
				$totalvendido=0;
				
				foreach($ventas as $venta){ 
					// if("0"=="0"){
					if($venta->arqueo=="0"){

						?>
				<tr> 
				
					<td><?php echo $venta->orden ?></td>
					<td><?php echo date("d/m/Y", strtotime($venta->fecha)) ?></td>
					<td><?php echo  $venta->hora ?></td>
					<td><?php echo $venta->nombre_de_usuario ?></td>
					<!-- <td  ><?php echo $venta->tipoDeVenta==2? "<p style='color:black;background-color:yellow'>CREDITO</p>":"<p style='color:white;background-color:green '>CONTADO</p>" ?></td> -->
					<td>
						<table style="background-color:#28293B ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>nombre</th>
									<th>Cantidad</th>
									<th>precio</th>
									<th>subtotal</th>
								</tr>
							</thead>
							<tbody style="background-color:#28293B ;color:white">
								<?php foreach(explode("__", $venta->productos) as $productosConcatenados){ 
									$producto = explode("..", $productosConcatenados)
									?>
								<tr>
									<td><?php echo $producto[0] ?></td>
									<td><?php echo $producto[1] ?></td>
									<td><?php echo $producto[2] ?></td>
									<td><?php echo $producto[3] ?></td>
									<td><?php echo $producto[2]*$producto[3] ?></td>
								</tr>
								<?php } 
								?>
							</tbody>
						</table>
					</td>
					<td>
					<?php
				 
					echo $venta->descuento+$venta->total;
				 
					
					?></td>
					<td>
					<?php
				 
					echo $venta->descuento;
				 
					
					?></td>
					<td>
					<?php
					$totalvendido=$totalvendido+$venta->total;
					echo $venta->total;
					$error = [ 'id' => $venta->id ];
					$error = serialize($error);
				$error = urlencode($error);
					
					?></td>
					
					 
					     <?php 
					     if (1==11) {
					     ?>
					     <td>
					     <a class="btn btn-danger" href="<?php echo "eliminarTraspaso.php?id=" . $venta->id?>"><i class="fa fa-trash"></i></a>
					     </td>
					     <?php }?>
					     
					 
					 
					 <td><a class="btn btn-info" href="<?php echo "imprimir_ticket_traspaso.php?ticket=".$error ?> "><i class="fa fa-print"></i></a></td>
				</tr>
				<?php } 
				}
				?>
			</tbody>
		</table>
		<div>   
		  
		</div>
			<h3>TOTAL VENDIDO:

		<?php
				
				echo $totalvendido. "  Bs."  ?> 
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	</div>
<?php include_once "pie.php" ?>