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
include_once "encabezado33.php";
}
if($tipo=='ambulante'){
	include_once "encabezado4.php";
}
 
 
 ?>
<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT ventastienda.entregado, cliente.nombre as cliente, ventastienda.detalle,ventastienda.descuento,ventastienda.tipoDeVenta, ventastienda.hora,ventastienda.nombre_de_usuario,ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_vendidos_tienda.cantidad , '..', productos_vendidos_tienda.precio SEPARATOR '__') AS productos FROM ventastienda INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto INNER JOIN cliente on cliente.id=ventastienda.cliente GROUP BY ventastienda.id ORDER BY ventastienda.id DESC;
;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>lista de entregados</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 
		<br>
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<th>NUMERO</th>
					<th>ENGREGADO</th>
					
					<th>FECHA</th>
					<th>HORA</th>
					<th>VENDEDOR</th>
					<th>CLIENTE</th>
				 
					<th>PRODUCTOS VENDIDOS</th>
					<th>ENTREGA?</th>
					<th>NOTA</th>
					<th style="display:none">SubTotal</th>
					<th style="display:none">Descuento del total</th>
					<th>TOTAL</th>
					<?php 
					     if ($tipo=='administrador') {
					         echo '<th>eliminar</th>';
					     }
					     ?>
					
					<th>REGISTRAR ENTREGADO</th>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				
				foreach($ventas as $venta){ 
					// if("0"=="0"){
					if($venta->arqueo=="0"){

						?>
				<tr style="background-color:<?php echo $venta->entregado=='0'? "blue":"green" ?>" > 
				
					<td><?php echo $venta->orden ?></td>
				<td  ><?php 
				
				  if($venta->entregado==0){
				      echo "2 ".$venta->entregado;
				    echo "<p style='color:black;background-color:yellow'>PENDIENTE </p>";  
				  } else{
				      echo "<p style='color:white;background-color:green '>ENTREGADO</p>" ;
				  }
			 
				
				?></td>
					<td><?php echo date("d/m/Y", strtotime($venta->fecha)) ?></td>
					 	
					<td><?php echo  $venta->hora ?></td>
					<td><?php echo $venta->nombre_de_usuario ?></td>
					<td><?php echo $venta->cliente ?></td>
					
					<td >
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
						<td  ><?php
						echo $venta->tipoDeVenta==2? "<p style='color:black;background-color:yellow'>PARA LLEVAR</p>":"<p style='color:white;background-color:green '>PARA MESA</p>" ?></td>
					<td>
					<?php
				 
					echo $venta->detalle;
				 
					
					?></td>
				
					<td style="display:none" >
					<?php
				 
					echo $venta->descuento+$venta->total;
				 
					
					?></td>
					<td style="display:none">
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
					     if ($tipo=='administrador') {
					     ?>
					     <td>
					     <a class="btn btn-danger" href="<?php echo "eliminarVentaTienda.php?id=" . $venta->id?>"><i class="fa fa-trash"></i></a>
					     </td>
					     <?php }?>
					     
					 
					 
					 <td>
					     
					       <?php 
					       if($venta->entregado=='0'){
					          ?>
					          <a style="background-color:yellow"  class="btn btn" href="<?php echo "entregado.php?id=" . $venta->id?>"><i class="fa fa-check"></i></a>
					          <?php
					       }else{   ?>
					           
					          <a class="btn btn-success" href="<?php echo "entregado.php?id=" . $venta->id?>"><i class="fa fa-check"></i></a>
					          <?php 
					       }
					       
					       ?>
					    
					    </td>
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