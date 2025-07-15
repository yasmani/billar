 <?php
date_default_timezone_set("America/La_Paz");
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM apertura where estado='0';");
$apertura = $sentencia->fetchAll(PDO::FETCH_OBJ);

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT ventas.arqueo,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos FROM ventas  INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id INNER JOIN productos ON productos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
$totalvendido=0;
foreach($ventas as $venta){ 
	if($venta->arqueo=="0"){
		$totalvendido=$totalvendido+$venta->total;
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
				<a style="color:white; font-size: x-large " class="navbar-brand" href="#">  BOLIVIAN SOFTWARE </a>
			</div>
			<br>
			<div  id="navbar" class="collapse navbar-collapse">
				<ul  class="nav navbar-nav">
				    <!-- <li><a style="color:white" href="./codigo_barra.php">  Codigo de barra</a></li> -->
					<!-- <li ><a style="color:white" href="./egreso.php">COMPRA INSUMO</a></li> 
					<li><a style="color:white" href="./home.php">BALANCE</a></li>
					<li><a style="color:white" href="./egresoadm.php">GASTO ADMINISTRATIVOS</a></li>-->
					<li><a style="color:white" href="./usuarios.php">USUARIOS</a></li>  
					<li><a style="color:white" href="./listar-inventario.php">INVENTARIO</a></li>
					<li><a style="color:white" href="./usuarios.php">usuarios</a></li>
					 <li><a style="color:white"  href="./compras.php">INGRESOS A ALMACEN</a></li>
					 
					
					<!-- <li><a style="color:white" href="./listar.php">MENU</a></li>  -->
					<!-- <li><a href="./formularioR.php">registrar</a></li> -->
					
					 <!-- <li><a style="color:white" href="./compras.php">Compras</a></li>  -->
					<?php 	 
						if($existe!=null){
							echo '<li><a style="color:white" href="./vender.php">SALIDAS A TIENDA</a></li>';
						}else{
						}
						?>	
					
					<li><a style="color:white" href="./imprimir_ventas.php">IMPRIMIR SALIDAS DE ALMACEN</a></li>
					<li><a style="color:white" href="./imprimir_ventas_creditos.php">SALIDAS Al Credito</a></li>
					
					<!-- <li><a style="color:white" href="./egresodes.php">BAJAS</a></li> -->
					<!-- <li><a style="color:white" href="./reporte.php">Reporte de ventas</a></li>  -->
					<!-- <li><a style="color:white" href="reporteegresos.php">Reporte de gastos</a></li>  -->
					<!-- <li><a style="color:white" href="./reporteCompras.php">Reporte de Compras</a></li>   -->
					<!-- <li><a style="color:white" href="./apertura.php">apertura de caja</a></li> <li><a style="color:white" href="./grafico/index.php">GRAFICA</a></li>-->
					<!-- <li><a style="color:white" href="./ventas.php">ARQUEO</a></li>  -->
					<!-- <li><a style="color:white" href="./todasLasVentas.php">TODAS LAS VENTAS</a></li> --> 
					<!-- <li><a style="color:white;" href="./todasLasCompras.php">REPORTE DE COMPRAS</a></li> --> 
					<li ><a style="color:white" href="./listar.php";>REPORTES</a></li> 
					<li ><a style="color:yellow" href="./arqueos.php";>ARQUEOS</a></li>  
					
					<?php 	 
						if($existe!=null){
							
							echo '';
							echo '';
						}else{
						}
						?>
						<li ><a style="color:yellow;font-size:15PX;border:white 1px solid" href="./imprimir_ventas_tienda.php">Ventas en Tieda</a></li>
<li><a style="color:white;font-size:15PX;border:white 1px solid" href="./imprimir_ventas_creditos_tienda.php">CREDITOS</a></li>
					<li ><a style="color:white" href="./cerrar_session.php";>CERRAR</a></li> 
					<li><a href="./productos-con-stock-minimo.php"> <p><img width="15px" src="./files/imagenes/icono de alerta transparente.jpg" alt=""></p> </a></li>

				</ul>
			</div>
		</div>
	</nav>  
<div class="container">
	<br><br><br>
  <h3>ABRIR  </h3>
  <!-- Trigger the modal with a button -->
  <?php 
		 
			if($existe!=null){
				echo '<button  style="color:black" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">CERRAR  ALMACEN </button>';
			}else{
				echo '<button  style="color:black" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">ABRIR  ALMACEN </button>';
			}
		?>
  <!-- <input style="color: black;" class="btn btn-success btn-lg"  value="actualizar" type="button" onclick="document.location.reload();"> -->



  <!-- Modal -->
  <div style="color:black" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center> <h4 style="color:black" class="modal-title">caja</h4></center>
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
				echo '<form method="post" enctype="multipart/form-data" action="apertura.php" >
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

		
	
	<center> <h1>MONTO TODAL DE SALIDAS <?php echo $totalvendido?>bs.</h1></center>
	<table class="table table-bordered">
			<thead>
				<tr>
					<th>MONTO APERTURA</th>
					<th>MONTO VENDIDO</th>
					<th>CAJER@</th>
					<th>FECHA Y HORA DE APERTURA</th>
					<th>CERRAR CAJA</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($apertura as $ap){ ?>
				<tr>
					<td><?php echo $ap->monto ?>bs.</td>
					<td><?php echo $totalvendido?>bs.</td>
					<td><?php echo $ap->cajera ?></td>
					<td><?php echo date("d-m-Y h:m:s", strtotime($ap->fecha));     ?></td>
					<td><a class="btn btn-danger" href="<?php echo "guardarCierre.php?id=" . $ap->id?>"><i class="fa fa-save"></i>CERRAR ALMACEN</a></td>
				</tr>
				<?php } ?>
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
		 
		
				 <form method="post" enctype="multipart/form-data" action="registrar_cliente.php" >
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
  <div style="color:black" class="modal fade" id="myModalTienda" role="dialog">
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
          <center> <h4 style="color:black" class="modal-title">Registrar Responsable de compras</h4></center>
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