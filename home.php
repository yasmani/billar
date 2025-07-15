<?php
if(!isset($_COOKIE["usuario"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
}  
 if ($tipo=='administrador') {
	 # code...
	 include_once "encabezado.php"; 
 } else {
	 # code...
	 header("Location: ./vender.php");
 }
 
 
 ?>
<?php
include_once "base_de_datos.php";
 

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT SUM(ventas.total) AS total FROM ventas, productos_vendidos WHERE ventas.id=productos_vendidos.id;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
$gastos = $base_de_datos->query("SELECT SUM(total) as total FROM `egresosadm`;
");
$total_gastos = $gastos->fetchAll(PDO::FETCH_OBJ);

$inventario = $base_de_datos->query("SELECT productos.id, productos.codigo, productos.precioCompra ,productos.existencia from productos;");
$total_inventario = $inventario->fetchAll(PDO::FETCH_OBJ);
// utilidad
$utilidad = $base_de_datos->query("SELECT sum(productos_vendidos.precio-productos.precioCompra )as utilidad FROM ventas,productos_vendidos,productos WHERE ventas.id=productos_vendidos.id_venta and productos.id=productos_vendidos.id_producto;");
$total_utilidad = $utilidad->fetchAll(PDO::FETCH_OBJ);

$ventas_totales=0;
$gastos_totales=0;
$por_cobrar_totales=0;
?>
<div class="row">
	<div class="col-md-8">
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 
		<br>
		 
		 

		<table border="1">
			<H1>BALANCE GENERAL</H1>
			<tbody class="table">
				<tr>
				<th> <h1>TOTAL INVENTARIO = <?php
				$suma=0;
					  foreach($total_inventario as $inventario){ 
						  $suma +=$inventario->precioCompra*$inventario->existencia;
					  } echo $suma;?> BS</h1>
					  </th>
				</tr>
				<tr>
				<th> <h1>TOTAL VENTAS = <?php
					  foreach($ventas as $venta){ 
						  $ventas_totales=$venta->total;
						  echo $venta->total ;
					  }?> BS</h1>
					  </th>
				</tr>

				<tr>
				<th> <h1>TOTAL GASTOS = <?php
					  foreach($total_gastos as $gastos){ 
						  $gastos_totales=$gastos->total;
						  echo $gastos->total ;
					  }?> BS</h1>
					  </th>
				</tr>
				<tr>
				<th> <h1>SALDO TOTAL = <?php
					 	echo 	$ventas_totales-$gastos_totales;  
					   ?> BS</h1>
					  </th>
				</tr>
		 

				 
				 
				 
			</tbody>
			</table>
			 
		 
				
					
					
 

	</div>
	<div class="col-md-4">
	<img src="./files/imagenes/ventas.jpeg" alt="" srcset="">
	<H2> <a style="color:yellow" href="./balance_diario.php">balance diario</a></H2>


	</div>

	</div>
<?php include_once "pie.php" ?>