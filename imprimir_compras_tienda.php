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
$sentencia = $base_de_datos->query("SELECT * FROM `comprastienda` ORDER by id desc");
$compras = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

<div class="col-xs-12">
	<h1>COMPRAS</h1>
	
	<br>
	<table id="tabla_compras_tienda" style="color:black" name="tabla" class="table table-bordered">
		<thead style="color:white; " name="tabla" class="table table-darger">
			<tr style="background-color: #46818a;">
				<th>NUMERO</th>
				<th>FECHA</th>
				<th>HORA</th>
				<th>PRODUCTOS</th>
				<!-- <th>USUARIO</th> -->
				<!-- <th>PRODUCTOS COMPRADOS</th> -->
				<th>TOTAL</th>
				<?php 
					     if ($tipo=='cajero') {
							 echo '<th>ELIMINAR</th>';
							}
							?>
					
					<th>IMPRIMIR</th>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				// $sentencia = $base_de_datos->query("SELECT productos_comprados_tienda.id, productos.id,productos.codigo,productos.nombre,productos_comprados_tienda.precio,productos_comprados_tienda.cantidad,productos_comprados_tienda.precio *productos_comprados_tienda.cantidad as total FROM `productos_comprados_tienda`, productos WHERE productos_comprados_tienda.id_compra='$id_compra',   productos_comprados_tienda.id_producto=productos.id;");
				// $compras = $sentencia->fetchAll(PDO::FETCH_OBJ);
				
				foreach($compras as $comp){ 
					// if("0"=="0"){
						if($comp->condicion=="1"){
							
							?>
				<tr> 
					
					<td><?php echo $comp->id ?></td>
					<td><?php echo date("d/m/Y", strtotime($comp->fecha)) ?></td>
					<td><?php echo $comp->HORA ?></td>
					<td>
						<table style="background-color:#43ab9b ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>nombre</th>
									<th>Cantidad</th>
									<th>precio compra</th>
									<th>subtotal</th>
								</tr>
							</thead>
							<tbody style="background-color:#28293B ;color:white">
								<?php 
								$detallesql = $base_de_datos->query("SELECT productos_comprados_tienda.id, productos.id,productos.codigo,productos.nombre,productos_comprados_tienda.precio,productos_comprados_tienda.cantidad,productos_comprados_tienda.precio *productos_comprados_tienda.cantidad as total 
								FROM `productos_comprados_tienda`, productos 
								WHERE productos_comprados_tienda.id_compra='$comp->id' and  productos_comprados_tienda.id_producto=productos.id;");
								$detalle = $detallesql->fetchAll(PDO::FETCH_OBJ);
								foreach($detalle as $de){ 
									?>
								<tr>
								 
									<td><?php echo $de->codigo ?></td>
									<td><?php echo  $de->nombre?></td>
									<td><?php echo  $de->cantidad?></td>
									<td><?php echo  $de->precio?></td>
									<td><?php echo  $de->total?></td>
								 
								</tr>
								<?php } 
								?>
							</tbody>
						</table>
					</td>
					<td>
					<?php
				 
					echo $comp->total;
				 
					
					?></td>
				 
					<?php
					$totalvendido=$totalvendido+$comp->total;
					// echo $comp->total;
					$error = [ 'id' => $comp->id ];
					$error = serialize($error);
				$error = urlencode($error);
					
					?>
					
					 
					     <?php 
					     if ($tipo=='cajero') {
					     ?>
					     <td>
					     <a class="btn btn-danger" href="<?php echo "eliminarCompra.php?id=" . $comp->id?>"><i class="fa fa-trash"></i></a>
					     </td>
					     <?php }?>
					 <td><a class="btn btn-info" href="<?php echo "imprimir_ticket_compra.php?ticket=".$error ?> "><i class="fa fa-print"></i></a></td>
				</tr>
				<?php } 
				}
				?>
			</tbody>
		</table>
		<div>   
		  
		</div>
			<h3>TOTAL COMPRADO:

		<?php
				
				echo $totalvendido. "  Bs."  ?> 
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $comp->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	</div>


		<script>
		$(document).ready(function() {

   if ($.fn.DataTable.isDataTable('#tabla_compras_tienda')) {
    $('#tabla_compras_tienda').DataTable().destroy();
}

$('#tabla_compras_tienda').DataTable({
	dom: 'Bflrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel" style="bakbackground-color:#5bc25b;"></i> Excel',
            className: 'btn btn-success'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf" style="bakbackground-color:#ee635c;"></i> PDF',
            className: 'btn btn-danger'
        }
    ],
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
    },
    pageLength: 10,
    ordering: true,
    searching: true
});


});

</script>
