<?php
include_once "verificar.php";
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';

// header("Content-Type: application/xls");
// header("Content-Disposition: attachment; filename= reporte_De_comp.xls");
$ahora = date("Y-m-d H:i:s");
$inicio = date("Y-m-d", strtotime($_POST['inicio'])) ;
$fin = date("Y-m-d", strtotime($_POST['fin'])) ;
date_default_timezone_set("America/La_Paz");
//$sentencia = $base_de_datos->query("SELECT  ventas.detalle,ventas.hora,ventas.cliente,ventas.orden,ventas.arqueo,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos.cantidad, '..', productos_vendidos.precio SEPARATOR '__') AS productos FROM ventas  INNER JOIN productos_vendidos   ON  productos_vendidos.id_venta = ventas.id AND ventas.fecha BETWEEN '$inicio' and '$fin' INNER JOIN productos ON productos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id DESC;");
$sentencia = $base_de_datos->query("SELECT ventas.fecha as FECHA, ventas.hora as HORA, cliente.nombre as CLIENTE, cliente.telefono as TELEFONO, productos_vendidos.id_producto as CODIGO, productos.nombre as NOMBRE, productos_vendidos.cantidad as CANTIDAD, productos_vendidos.precio as PRECIO, ventas.detalle as DETALLE,(productos_vendidos.cantidad*productos_vendidos.precio) as SUBTOTAL FROM ventas INNER JOIN productos_vendidos ON productos_vendidos.id_venta=ventas.id INNER JOIN productos ON productos_vendidos.id_producto=productos.codigo INNER JOIN cliente ON cliente.id = ventas.cliente ORDER BY productos_vendidos.id_producto DESC");
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
				<th>Fecha</th>
				<th>Hora</th>
				<th>Cliente</th>
				<th>Telefono</th>
				<th>Producto vendido</th>
				<th>Detalle</th>
				<th>SubTotal</th>
				<!-- <th>Eliminar</th> -->
			</tr>
		</thead>
		<tbody>
			<?php
			$totalvendido = 0;
			foreach ($ventas as $venta) {
				// if("0"=="0"){



			?>
				<tr style="font-size:20px;border:solid 5px">

					<td><?php echo date("d/m/Y", strtotime($venta->FECHA)) ?></td>
					<td><?php echo $venta->HORA ?></td>
					<td><?php echo strtoupper($venta->CLIENTE) ?></td>
					<td><?php echo $venta->TELEFONO ?></td>
					<td><?php echo ($venta->NOMBRE) ?></td>
			
					<td style="font-size:20px;">
						<?php
						echo $venta->DETALLE ?></td>
					<td style="font-size:20px;">
						<?php
						$totalvendido = $totalvendido + $venta->SUBTOTAL;
						echo round($venta->SUBTOTAL,2) ?></td>

					<!-- <td><a class="btn btn-danger" href="<?php echo "eliminarVenta.php?id=" . $venta->id ?>"><i class="fa fa-trash"></i></a></td>-->
				</tr>
			<?php }

			?>
		</tbody>
	</table>
	<div>

	</div style="font-size:20px;">
	<h3>TOTAL VENDIDO:

		<?php

		echo $totalvendido . "  Bs."  ?>
		<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id ?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->


</div>
<?php include_once "pie.php" ?>