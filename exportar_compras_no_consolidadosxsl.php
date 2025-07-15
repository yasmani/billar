<?php
include_once "verificar.php";
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= reporte_De_comp.xls");
$ahora = date("Y-m-d H:i:s");
$inicio = date("Y-m-d", strtotime($_POST['inicio'])) . ' 00:00:00';
$fin = date("Y-m-d", strtotime($_POST['fin'])) . ' 23:59:59';
date_default_timezone_set("America/La_Paz");
//$sentencia = $base_de_datos->query("SELECT compras.hora,compras.proveedor ,compras.total, compras.fecha, compras.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_comprados.cantidad, '..', productos_comprados.precio SEPARATOR '__') AS productos FROM compras INNER JOIN productos_comprados ON productos_comprados.id_compra  = compras.id AND compras.fecha BETWEEN '$inicio' and '$fin' INNER JOIN productos ON productos.id =productos_comprados.id_producto GROUP BY compras.id ORDER BY compras.id DESC");
$sentencia = $base_de_datos->query("SELECT compras.fecha as FECHA, compras.HORA as HORA, proveedor.nombre as PROVEEDOR, proveedor.telefono as TELEFONO, productos.codigo as CODIGO, productos.nombre as NOMBRE, productos_comprados.cantidad as CANTIDAD, productos_comprados.precio as PRECIO, (productos_comprados.cantidad*productos_comprados.precio) as SUBTOTAL FROM compras INNER JOIN proveedor ON compras.proveedor=proveedor.id INNER JOIN productos_comprados ON compras.id=productos_comprados.id_compra INNER JOIN productos ON productos_comprados.id_producto=productos.codigo ORDER BY compras.id DESC");
//SELECT  compras.detalle,ventas.hora,ventas.cliente,ventas.orden,ventas.arqueo,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos FROM ventas  INNER JOIN productos_vendidos   ON  productos_vendidos.id_venta = ventas.id AND ventas.fecha BETWEEN '2021-11-23' and '2021-11-23' INNER JOIN productos ON productos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id DESC
$compras = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>
<div class="col-xs-12">
	<h1>REPORTE DE COMPRAS NO CONSOLIDADAS</h1>
	<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->

	<br>
	<table style="color:black" name="tabla" class="table table-bordered">
		<thead style="color:white; " name="tabla" class="table table-darger">
			<tr style="background-color :red;font-size:20px;color:white">
				<th>Fecha</th>
				<th>Hora</th>
				<th>Proveedor</th>
				<th>Telefono</th>
				<th>Producto comprado</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<th>Subtotal</th>
				<!-- <th>Eliminar</th> -->
			</tr>
		</thead>
		<tbody>
			<?php
			$totalvendido = 0;
			//$nombre_proveedor="";
			//$telefono="";
			foreach ($compras as $compra) {
				// if("0"=="0"){
				//if("0"=="0"){

			?>
				<tr style="font-size:20px;border:solid 5px">

					<td><?php echo date("d/m/Y", strtotime($compra->FECHA)) ?></td>
					<td><?php echo $compra->HORA ?></td>
					<td><?php echo $compra->PROVEEDOR ?></td>
					<td><?php echo $compra->TELEFONO ?></td>
					<td ><?php  echo $compra->NOMBRE ?></td>
					<td ><?php  echo $compra->CANTIDAD ?></td>
					<td ><?php  echo $compra->PRECIO ?></td>
					<td ><?php  echo $compra->SUBTOTAL ?></td>				

					<td style="font-size:20px;">
						<?php
						$totalvendido = $totalvendido + $compra->SUBTOTAL;
						?></td>

					<!-- <td><a class="btn btn-danger" href="<?php echo "eliminarVenta.php?id=" . $compra->id ?>"><i class="fa fa-trash"></i></a></td>-->
				</tr>
			<?php }
			//}
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