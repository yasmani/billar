<?php
date_default_timezone_set("America/La_Paz");
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM apertura_tienda where estado='0';");
$apertura = $sentencia->fetchAll(PDO::FETCH_OBJ);

$fecha = date("Y-m-d");
$abonossql = $base_de_datos->query("SELECT abonos.fecha,abonos.hora,cliente.nombre as cliente,abonos.monto FROM `abonos` ,ventastienda,cliente WHERE abonos.fecha='$fecha' and ventastienda.id=abonos.id_venta and ventastienda.cliente=cliente.id;");
$abonos = $abonossql->fetchAll(PDO::FETCH_OBJ);

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT ventastienda.tipoDeVenta, ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos_tienda.cantidad SEPARATOR '__') AS productos FROM ventastienda  INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto GROUP BY ventastienda.id ORDER BY ventastienda.id;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
$totalvendido=0;
$total_vendido_credito=0;
foreach($ventas as $venta){ 
	if($venta->arqueo=="0" && $venta->tipoDeVenta==1){
		$totalvendido=$totalvendido+$venta->total;
	}if ($venta->arqueo=="0" && $venta->tipoDeVenta==2) {
		$total_vendido_credito=$total_vendido_credito+$venta->total;
	} 
	 
}
$existe=null;
$idCajera=null;
	foreach($apertura as $ap){ 
	$existe++;
	$idCajera=$ap->id;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ventas </title>
	<link rel="stylesheet" href="./css/fontawesome-all.min.css">
	<link rel="stylesheet" href="./css/2.css">
	<link rel="stylesheet" href="./css/estilo.css">
	 <link rel="stylesheet" href="jss/bootstrap.min.css">
	 <link rel="stylesheet" href="../dist/css/bootstrap-select.css"> 

  <script src="jss/jquery.min.js"></script>

  
  <!--<script src="jss/bootstrap.min.js"></script>-->
</head>
<body style="background-color:#28293B ;color:white">
	<nav  style="background-color:red;color:black" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a style="color:white; font-size: x-large " class="navbar-brand" href="#"> BOLIVIAN SOFTWARE</a>
			</div>
			<br>
			<div  id="navbar" class="collapse navbar-collapse">
				<ul  class="nav navbar-nav">
					
					 
					
					<!-- <li><a style="color:white" href="./listar.php">MENU</a></li>  -->
					<!-- <li><a href="./formularioR.php">registrar</a></li> -->
					
					 <!-- <li><a style="color:white" href="./compras.php">Compras</a></li>  -->
					<?php 	 
						if($existe!=null){
						    echo '<li><a style="color:yellow;font-size:15PX;border:white 1px solid" href="./venderTienda.php">ATRAS</a></li>';
						    
						    
								echo '<li><a style="color:yellow;font-size:15PX;border:white 1px solid" href="./imprimir_ventas_tienda2.php">entregados</a></li>';
								echo '<li><a style="color:yellow;font-size:15PX;border:white 1px solid" href="./cocina.php">PANTALLA</a></li>';
						//	echo '<li><a style="color:yellow;font-size:15PX;border:white 1px solid"href="//./imprimir_ventas_creditos_tienda.php">COBROS</a></li>';
						 
						}else{
						}
						?>	
						<!-- <li ><a style="color:yellow" href="./arqueos.php";>ARQUEOS</a></li> -->
						<!--<li><a style="color:yellow;font-size:15PX;border:white 1px solid"href="./arqueos_tienda.php">ARQUEOS DE CAJA</a></li>-->
      <!--              <li ><a style="color:yellow;font-size:15PX;border:white 1px solid" href="./cerrar_session.php";>cerrar</a></li> 	-->
                    
				</ul>
			</div>
		</div>
	</nav>  
<div class="container">
	<br><br><br>
  <!--<h3></h3>-->
  <!-- Trigger the modal with a button -->
 
  

  <!-- Modal -->
  <div style="color:black" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center> <h4 style="color:black" class="modal-title">BOLIVIAN SOFTWARE</h4></center>
        </div>
        <div style="color:black" class="modal-body">
		<?php 
		$existe=null;
		foreach($apertura as $ap){ 
			$existe++;
			?>
		<?php 
		} 
			if($existe!=null){
			}else{
				echo '<form method="post" enctype="multipart/form-data" action="apertura_tienda.php" >
				<label for="cajero">NOMBRE DEL CAJERO:</label>
				<textarea required id="cajero" name="cajero" cols="2" rows="1" class="form-control"></textarea>
				<label for="monto">MONTO DE APERTURA EN BS:</label>
				
				<input class="form-control"  type="number" placeholder="0" required name="monto" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
				this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?"inherit":"red">
				</div>
				<br><br>
				<center> <input class="btn btn-info" type="submit" value="APERTURAR CAJA"></center>
			</form>
				';
			}
		?>

		
	
	<center> <h3>MONTO VENDIDO AL CONTADO <?php echo $totalvendido?>bs.</h3></center>
	<center> <h3>MONTO VENDIDO AL CREDITO <?php echo $total_vendido_credito?>bs.</h3></center>
	<table class="table table-bordered">
			<thead>
				<tr>
					<th>APERTURA</th>
					<th>CAJER@</th>
					<th>FECHA Y HORA DE APERTURA</th>
					<th>CERRAR TIENDA</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($apertura as $ap){ ?>
				<tr>
					<td><?php echo $ap->monto ?>bs.</td>
					<td><?php echo $ap->cajera ?></td>
					<td><?php echo date("d-m-Y h:m:s", strtotime($ap->fecha));     ?></td>
					<td><a class="btn btn-danger" href="<?php echo "guardarCierreTienda.php?id=" . $ap->id?>"><i class="fa fa-save"></i>CERRAR CAJA</a></td>
				</tr>
			 
				<tr>
					<td>
						
						<?php echo 'ABONOS COBRADOS'?>
					</td>
					<td></td>
				 <td>

					 
					</td>
				 
				</tr>
						 <tr>
					<?php } 
					$total_abonos=0;
					  foreach($abonos as $abono){
						echo '<tr>';
							echo '<td>   '.date("d-m-Y", strtotime($abono->fecha)).'</td>';
							echo '<td>   '.$abono->hora.'</td>';
							echo '<td>   '.$abono->cliente.'</td>';
							echo '<td>   '.$abono->monto.'</td>';
							$total_abonos+=$abono->monto;
							echo '</tr>';
					  } 
					  echo '<tr>';
					  echo '<td></td>';
					  echo '<td></td>';
					  echo '<td></td>';
					  echo '<td>total '.$total_abonos.'</td>';
					  echo '</tr>';
					  //	echo '<br>total='.$total;
					?></tr>
					</td>
				</tr>
			</tbody>
		</table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--  EN MODAL-->
  <div style="color:black" class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center> <h4 style="color:black" class="modal-title">REGISTRAR UN NUEVO CLIENTE</h4></center>
        </div>
        <div style="color:black" class="modal-body">
		 
		
				 <form method="post" enctype="multipart/form-data" action="registrar_cliente_tienda.php" >
				<label for="cajero">NOMBRE COMPLETO:</label>
				<textarea required id="nombre" name="nombre" cols="2" rows="1" class="form-control"></textarea>
				<label for="monto">TELEFONO:</label>
				<input required class="form-control" type="text"  max="11" id="telefono" name="telefono" >
				</div>
				<br><br>
				<center> <input class="btn btn-info" type="submit" value="REGISTRAR"></center>
			</form>
				
	<center> <h1>BOLIVIAN SOFTWARE </h1></center>
	 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div> 

	
  </div>
  <!--  EN MODAL-->
  <div style="color:black" class="modal fade" id="myModal_proveedor" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center> <h4 style="color:black" class="modal-title">REGISTRAR UN NUEVO PROVEEDOR</h4></center>
        </div>
        <div style="color:black" class="modal-body">
		 
		
				 <form method="post" enctype="multipart/form-data" action="registrar_proveedor.php" >
				<label for="cajero">NOMBRE COMPLETO:</label>
				
				<input required class="form-control" type="text"  max="40" id="nombre" name="nombre" >
				<label for="monto">TELEFONO:</label>
				<input required class="form-control" type="text"  max="11" id="telefono" name="telefono" >
				</div>
				<br><br>
				<center> <input class="btn btn-info" type="submit" value="REGISTRAR"></center>
			</form>
				
	<center> <h1>BOLIVIAN SOFTWARE </h1></center>
	 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div> 


  </div>
  <!--  EN MODAL-->
</div>
	<div class="container">
		<div class="row">