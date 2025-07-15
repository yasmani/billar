<?php
// header("Content-Type: application/xls");
// header("Content-Disposition: attachment; filename= reporte_De_compras.xls");
include_once "./base_de_datos.php";
date_default_timezone_set("America/La_Paz");
$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';

$ahora = date("Y-m-d H:i:s");
$sentencia = $base_de_datos->query("SELECT ventas.orden,ventas.arqueo,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos FROM ventas  INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id INNER JOIN productos ON productos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id DESC;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
//$sentencia = $base_de_datos->query("SELECT codigo , productos.nombre,SUM(cantidad) as cantidad, sum(productos.precioVenta) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE fecha BETWEEN '$inicio' AND '$fin') GROUP by  productos_vendidos.id_producto");

$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);


?>
<div class="col-xs-12">
		<h1>VENTAS DIARIAS</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 
		<br>
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<th>NUMERO</th>
					<th>FECHA</th>
					<th>PRODUCTOS VENDIDOS</th>
					<th>TOTAL</th>
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
				<tr> 
				
					<td><?php echo $venta->orden ?></td>
					<td><?php echo $venta->fecha ?></td>
					<td>
						<table style="background-color:#28293B ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>nombre</th>
									<th>Cantidad</th>
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
								</tr>
								<?php } 
								?>
							</tbody>
						</table>
					</td>
					<td>
					<?php
					$totalvendido=$totalvendido+$venta->total;
					echo $venta->total ?></td>
					<!-- <td><a class="btn btn-danger" href="<?php echo "eliminarVenta.php?id=" . $venta->id?>"><i class="fa fa-trash"></i></a></td>--> 
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
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color:red;color :white;font-size:20px;">
					 
					<th>codigo</th>
					<th>nombre</th>
					<th>p/compra</th>
					<th>p/venta</th>
					<th>cantidad</th>
					<th>utilidad</th>
					<th>monto</th>
					 
				</tr>
			</thead>
			<tbody>
                <tr style="font-size:20px;">
                    
				<?php 
                $total=0;
                $totalGanancia=0;
                $numero=0;
                $cant=0;
                $total_capital=0;
                foreach($ventas as $venta){ 
           $detalle_idventas = $base_de_datos->query(" SELECT * FROM `ventas` WHERE cliente='$venta->cliente' and fecha   BETWEEN '$inicio' AND '$fin' ORDER BY fechA");
           foreach($detalle_idventas as $ventas_id){

           }
		//$totalGanancia=$totalGanancia+$venta->cantidad * ($venta->precio-$venta->precioCompra);
		//$total=$total+($venta->cantidad * $venta->precioCompra); 
		//$total_capital=$total_capital+($venta->cantidad * $venta->precioCompra); 
                     echo '<td style="font-size:20px;">'.$venta->nombre.'-'.$venta->telefono .'  </td>';
                     echo '<td style="font-size:20px;"> </td>';
                     echo '<td style="font-size:20px;"> </td>';
                     echo '<td style="font-size:20px;"> </td>';
                     echo '<td style="font-size:20px;"> </td>';
                     echo '<td style="font-size:20px;"> </td>';
                     echo '<td style="font-size:20px;"> </td>';
                     echo '</tr>';
                }  
                echo '<td style="font-size:20px;"></td>';
                echo '<td style="font-size:20px;"> </td>';
                echo '<td style="font-size:20px;"> </td>';
                echo '<td style="font-size:20px;"></td>';
                echo '<td style="font-size:20px;">'. $cant .'</td>';
                echo '<td style="font-size:20px;">'. $totalGanancia .'</td>';
                echo '<td style="font-size:20px;">MONTAL  :'. ($total) .' BS</td>';
                echo '</tr>';
					?>

		  
			</tbody>
		</table>