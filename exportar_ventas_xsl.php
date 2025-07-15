<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= reporte_De_ventas.xls");
include_once "./base_de_datos.php";
$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
$sentencia = $base_de_datos->query("SELECT codigo , productos.nombre,SUM(cantidad) as cantidad, sum(productos.precioVenta) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE fecha BETWEEN '$inicio' AND '$fin') GROUP by  productos_vendidos.id_producto");

$compras = $sentencia->fetchAll(PDO::FETCH_OBJ);


?>
<h1>reporte de ventas  <?php echo 'desde : '.date("d/m/Y", strtotime($inicio)). " hasta: ".date("d/m/Y", strtotime($fin))?></h1>
<table style="color:black" name="tabla" class="table table-bordered">
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
                foreach($compras as $compra){ 
		$cant=$cant+$compra->cantidad;
		$totalGanancia=$totalGanancia+$compra->cantidad * ($compra->precio-$compra->precioCompra);
		$total=$total+($compra->cantidad * $compra->precioCompra); 
		$total_capital=$total_capital+($compra->cantidad * $compra->precioCompra); 
                     echo '<td style="font-size:20px;"> ' . $compra->codigo .'</td>';
                     echo '<td style="font-size:20px;">'. $compra->nombre .'</td>';
                     echo '<td style="font-size:20px;">'. $compra->precioCompra .'</td>';
                     echo '<td style="font-size:20px;">'. $compra->precio .'</td>';
                     echo '<td style="font-size:20px;">'. $compra->cantidad .'</td>';
                     echo '<td style="font-size:20px;">'. $compra->cantidad*($compra->precio-$compra->precioCompra) .'</td>';
                     echo '<td style="font-size:20px;">'. ($compra->cantidad*$compra->precio) .'</td>';
                     echo '</tr>';
                }  
                echo '<td style="font-size:20px;"></td>';
                echo '<td style="font-size:20px;"> </td>';
                echo '<td style="font-size:20px;"> </td>';
                echo '<td style="font-size:20px;"></td>';
                echo '<td style="font-size:20px;">'. $cant .'</td>';
                echo '<td style="font-size:20px;">'. $totalGanancia .'</td>';
                echo '<td style="font-size:20px;">Total  :'. ($total) .' BS</td>';
                echo '</tr>';
					?>

		  
			</tbody>
		</table>