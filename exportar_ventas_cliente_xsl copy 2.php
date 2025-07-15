<?php
include_once "verificar.php";  
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
 
//header("Content-Type: application/xls");
//header("Content-Disposition: attachment; filename= reporte_De_comp.xls");
$ahora = date("Y-m-d H:i:s");
$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT  ventas.detalle,ventas.hora,ventas.cliente,ventas.orden,ventas.arqueo,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos.cantidad, '..', productos_vendidos.precio SEPARATOR '__') AS productos FROM ventas  INNER JOIN productos_vendidos   ON  productos_vendidos.id_venta = ventas.id AND ventas.fecha BETWEEN '$inicio' and '$fin' INNER JOIN productos ON productos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id DESC;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>
	<div class="col-xs-12">
		<h1>REPORTE DE VENTAS</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 
		<br>
		<table style="color:black" name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color :red;font-size:20px;color:white">
					<th>FECHA</th>
					<th>hora</th>
					<th>CLIENTE</th>
					<th>telefono</th>
					<th>PRODUCTOS VENDIDOS</th>
					<th>DETALLE</th>
					<th>TOTAL</th>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				$nombre_cliente="";
				$telefono="";
				foreach($ventas as $venta){ 
					// if("0"=="0"){

                        $cliente = $base_de_datos->query("SELECT  * FROM cliente where  id='$venta->cliente'");
                        $datos = $cliente->fetchAll(PDO::FETCH_OBJ);
                        foreach($datos as $dato){ 
                            $nombre_cliente=$dato->nombre;
                            $telefono=$dato->telefono;

                        }
					if($venta->arqueo=="0"){

						?>
				<tr style="font-size:20px;border:solid 5px"> 
				
                    <td ><?php  echo date("d/m/Y", strtotime($venta->fecha)) ?></td>
					<td ><?php  echo ' hora:'.$venta->hora ?></td>
					<td><?php echo $nombre_cliente ?></td>
					<td><?php echo $telefono ?></td>
					<td>
						<table   class="table table-bordered">
							<thead>
								<tr style="color:white;margin:-10; background-color :blue;font-size:15px;">
									<th>Codigo</th>
									<th>nombre</th>
									<th>Cantidad</th>
									<th>precio</th>
									<th>sub total</th>
								</tr>
							</thead>
							<tbody  >
								<?php foreach(explode("__", $venta->productos) as $productosConcatenados){ 
									$producto = explode("..", $productosConcatenados)
									?>
								<tr style="font-size:20px;">
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
					<td style="font-size:20px;">
					<?php
					echo $venta->detalle ?></td>
					<td style="font-size:20px;">
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
		  
		</div style="font-size:20px;">
			<h3>TOTAL VENDIDO:

		<?php
				
				echo $totalvendido. "  Bs."  ?> 
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	</div>
<?php include_once "pie.php" ?>