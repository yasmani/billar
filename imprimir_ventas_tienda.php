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
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");

	$usuario=$_COOKIE["id"];

if($tipo=='cajero'){
$sentencia = $base_de_datos->query("SELECT ventastienda.entregado,ventastienda.tarjeta,ventastienda.entrega,cliente.nombre as cliente, ventastienda.transferencia,ventastienda.detalle,ventastienda.descuento,ventastienda.tipoDeVenta, ventastienda.hora,ventastienda.nombre_de_usuario,ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_vendidos_tienda.cantidad , '..', productos_vendidos_tienda.precio SEPARATOR '__') AS productos FROM ventastienda INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto INNER JOIN cliente on cliente.id=ventastienda.cliente and ventastienda.arqueo=0  GROUP BY ventastienda.id ORDER BY ventastienda.id ASC ;
;");

}
if($tipo=='ambulante'){
	$sentencia = $base_de_datos->query("SELECT ventastienda.entrega,ventastienda.entregado,ventastienda.tarjeta,cliente.nombre as cliente, ventastienda.transferencia,ventastienda.detalle,ventastienda.descuento,ventastienda.tipoDeVenta, ventastienda.hora,ventastienda.nombre_de_usuario,ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_vendidos_tienda.cantidad , '..', productos_vendidos_tienda.precio SEPARATOR '__') AS productos FROM ventastienda INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto INNER JOIN cliente on cliente.id=ventastienda.cliente and ventastienda.arqueo=0   GROUP BY ventastienda.id ORDER BY ventastienda.id ASC  ;
;");

}

$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>
	</div>
	</div>
	<div class="container mt-4" style="margin-left:150px;width:98% !important;">
  <div class="row" style="width:98% !important;">
    <!-- Columna izquierda: tabla de ventas -->
    <div class="col-lg-6">
		<h1>VENTAS DIARIAS EN TIENDA</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 
		<br>
		<table style="color:black" name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color: #395a94">
					<th>NUMERO</th>
					<th>FECHA</th>
					<th>MESA</th>
					<th>QR</th>
					<th>TARJETA</th>
					<th>EFECTIVO</th>
					<th>HORA</th>
					<th>VENDEDOR</th>
					<th>CLIENTE</th>
				 
					<th>PRODUCTOS VENDIDOS</th>
					<!--<th>QR</th>-->
					<!-- <th>ENTREGA</th> -->
					<th>NOTA</th>
					<th>SubTotal</th>
					<th>Descuento del total</th>
					<th>TOTAL</th>
					<?php 
					     if ($tipo=='administrador') {
					         echo '<th>eliminar</th>';
					     }
					     ?>
					
					<th>Imprimir</th>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				$transferencia=0;
				$tarjeta=0;
				$descuentototal=0;
				$ventasalcredito=0;
				$ventasalcontado=0;
				$ii=0;
				
				$notas='';
				foreach($ventas as $venta){ 
				    
				    $ii++;
					// if("0"=="0"){
					if($venta->arqueo=="0"){
					    $transferencia+=$venta->transferencia;
					    $tarjeta+=$venta->tarjeta;
					    $descuentototal+=$venta->descuento;

						?>
				<tr> 
				
					<td><?php echo $venta->orden ?></td>
					<td><?php echo date("d/m/Y", strtotime($venta->fecha)) ?></td>
					<td><?php
					if($venta->entregado==26){
						echo  'CONSUMO PERSONAL'; 
					}else{
						echo  $venta->entregado;
					}
					
					?></td>
					<td><?php echo  $venta->transferencia?></td>
					<td><?php echo  $venta->tarjeta ?></td>
					<td><?php echo  $venta->total-($venta->tarjeta+$venta->transferencia) ?></td>
					<td><?php echo  $venta->hora ?></td>
					<td><?php echo $venta->nombre_de_usuario ?></td>
					<td><?php echo $venta->cliente ?></td>
					
					<td>
						<table style="background-color:#28293B ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<!--<th>Código</th>-->
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
									<!--<td><?php echo $producto[0] ?></td>-->
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
					 
							<td  style='display:none'  ><?php
							if ($venta->tipoDeVenta>1) {
								$ventasalcontado+=$venta->total-$venta->descuento;
							} else {
								$ventasalcredito+=$venta->total-$venta->descuento;
							}
							
							// $venta->tipoDeVenta>1?$ventasalcontado+=$venta->total:$ventasalcredito+=$venta->total;
							echo $venta->transferencia>0? "<p style='color:black;background-color:yellow'>QR ".$venta->transferencia." </p>":''?></td>
							<!-- <td   ><?php echo $venta->tipoDeVenta==1? "<p style='color:white;background-color:green'>para mesa   </p>":"<p style='color:white;background-color:red'>para llevar  </p>"?></td> -->
					<td>
					<?php
				 
					echo $venta->detalle;
				 $notas= $notas.'<br>'.$venta->detalle;
					
					?></td>
				
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
					//if($tipo=='ambulante'){
            	       		echo '<h2 style="color:green" >'.($venta->total -$venta->descuento)."</h2>" ;
            	       		 
                   // }
					
			
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
					     
					 
					 
					 <td><a class="btn btn-info" href="<?php echo "imprimir_tienda.php?ticket=".$error ?> "><i class="fa fa-print"></i></a></td>
				</tr>
				<?php } 
				}
				?>
			</tbody>
		</table>
			</div>   
		  
		  <!-- Columna derecha: resumen de cierre -->
    <div class="col-lg-3" style="margin-left:458px;">
			</br>
			<table style="background-color:#28c8e6c2293B ;color:black" class="table table-bordered">
				<center><h3>CIERRE DE CAJA</h3></center>
				<tr>
					<td style="width:50%;"><h4 style='color:black'>   VENTAS POR QR </h4></td>
					<td><h3 style='color:black'>  <?php echo $transferencia; ?> </h3></td>
			</tr>
			<tr>
					<td style="width:50%;"><h4 style='color:black'>   DEBE </h4></td>
					<td><h3 style='color:black'>  <?php echo $tarjeta; ?> </h3></td>
			</tr>
			<tr>
					<td style="width:50%;"><h4 style='color:black'>   VENTAS EFECTIVO </h4></td>
					<td><h3 style='color:black'>  <?php echo ($totalvendido-($tarjeta+$transferencia)); ?> </h3></td>
			</tr>
			<tr>
					<td style="width:50%;"><h4 style='color:black'>   TOTAL  VENTA </h4></td>
					<td><h3 style='color:black'>  <?php echo $totalvendido; ?> </h3></td>
			</tr>
			<tr>
					<td style="width:30%;"><h4 style='color:black'>   NOTAS </h4></td>
					<td><h3 style='color:black'>  <?php echo $notas; ?> </h3></td>
				</tr>
				

			</table>
			<?php
				/*echo "   ____________CIERRE DE CAJA_________________" ;
				
				// echo ($totalvendido-$descuentototal). "      |\n" ;
					if($tipo=='cajero'){
            	       	//	echo "  <H3 style='background-color:green'>  TOTAL  -> ".($totalvendido-$descuentototal). "  </h3>" ;
                    }
				
				
				// echo "  <h3 style='background-color:yellow;color:black'>   VENTAS EN EFECTIVO ->  ".(($totalvendido-$descuentototal)-$transferencia). "  </h3>" ;
				echo "  <h3 style='color:black'>   VENTAS POR QR ->  ".$transferencia. "  </h3>" ;
				echo "  <h3 style='background-color:yellow;color:black'>   DEBE ->  ".$tarjeta. "  </h3>" ;
				echo "  <h3 style='background-color:yellow;color:black'>   VENTAS EFECTIVO  ->  ".($totalvendido-($tarjeta+$transferencia)). "  </h3>" ;
				echo "  <h3 style='background-color:yellow;color:black'>   TOTAL  VENTAS  ->  ".$totalvendido. "  </h3>" ;
				echo "  <h3 style='background-color:red;color:white'>   NOTAS;  ->  ".$notas. "  </h3>" ;
				// echo $notas;
				// echo "  <h3 style='background-color:red;color:white'>   VENTAS AL CREDITO  -> ".$ventasalcredito. "  </h3>" ;
				// echo "  <h3 style='background-color:white;color:black'>   VENTAS AL CONTADO  -> ".$ventasalcontado. "  </h3>" ;
				// echo "     VENTAS AL CREDITO ".$ventasalcredito. "  | " ;
				echo "   ________________________________________" ;
			
				*/
				?> 

				</div>
		</div>
				
	</div>
	
			<!-- <h3>TOTAL : -->

	
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	
