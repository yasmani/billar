 <?php
date_default_timezone_set("America/La_Paz");
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM apertura_tienda where estado='0';");
$apertura = $sentencia->fetchAll(PDO::FETCH_OBJ);

$fecha = date("Y-m-d");
$abonossql = $base_de_datos->query("SELECT abonos.fecha,abonos.hora,cliente.nombre as cliente,abonos.monto FROM `abonos` ,ventastienda,cliente WHERE abonos.fecha='$fecha' and ventastienda.id=abonos.id_venta and ventastienda.cliente=cliente.id;");
$abonos = $abonossql->fetchAll(PDO::FETCH_OBJ);
$idmesa=0;
$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT ventastienda.tipoDeVenta, ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos_tienda.cantidad SEPARATOR '__') AS productos FROM ventastienda  INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto GROUP BY ventastienda.id ORDER BY ventastienda.id;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
$totalvendido=0;
$total_vendido_credito=0;
foreach($ventas as $venta){ 
	if($venta->arqueo=="0" && $venta->tipoDeVenta==1){
		$totalvendido=$totalvendido+$venta->total;
	}if ($venta->arqueo=="0"  ) {
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
	<title>BILLAR </title>
	<link rel="stylesheet" href="./css/fontawesome-all.min.css">
	<link rel="stylesheet" href="./css/2.css">
	<link rel="stylesheet" href="./css/estilo.css">
	 <link rel="stylesheet" href="jss/bootstrap.min.css">
	 <!-- Bootstrap Select desde CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

	<!-- <link rel="stylesheet" href="../dist/css/bootstrap-select.css"> -->
	   <script src="jss/jquery.min.js"></script>





  
  <script src="jss/bootstrap.min.js"></script>
  <!-- Agrega esto en el <head> o antes de cerrar el <body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



<!-- jQuery (si aún no está) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Botones de exportación -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<script src="js/main.js"></script>



<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>


</head>
<body style="margin-rigth:-150px;margin-left:-150px; background-color:#f7f9f7 ;color:black">
	<nav  style="background-color:#69906b;color:white" class="navbar navbar-inverse navbar-fixed-top">
		<div  style="margin-left:20px;pading-right:100px" class=" ">
			 
		 
			<div   id="navbar" class="collapse navbar-collapse">
				<ul  class="nav navbar-nav">
					
					 
					
					<!-- <li><a style="color:white" href="./listar.php">MENU</a></li>  -->
					<!-- <li><a href="./formularioR.php">registrar</a></li> -->
					
					 <!-- <li><a style="color:white" href="./compras.php">Compras</a></li>  -->
					<?php 	 
						if(1==1){
						    echo ' <li><a style="color:white;font-size:12PX;border:white 1px solid" href="./usuarios.php"> <b> USUARIOS</b></a></li>';
						    echo '<li><a style="color:white;font-size:12PX;border:white 1px solid" href="./listar-inventario_tienda.php">INVENTARIOS</a></li>';
						   // echo '<li><a style="color:black;font-size:15PX;border:white 1px solid" href="./traspaso.php">BAJAS</a></li>';
						  // echo '<li><a style="color:black;font-size:15PX;border:white 1px solid" href="./imprimir_traspaso.php">IMP BAJAS</a></li>';
						    echo '<li><a style="color:white;font-size:12PX;border:white 1px solid" href="./comprasTienda.php">COMPRAS</a></li>';
						    echo '<li><a style="color:white;font-size:12PX;border:white 1px solid" href="./imprimir_compras_tienda.php">IMP. COMPRAS</a></li>';
						     
							//echo '<li><a style="background-color:orange;color:black;font-size:12PX;border:white 1px solid" href="./venderTienda.php">VENDER </a></li>';
							echo '<li><a style="color:white;font-size:12PX;border:white 1px solid" href="./mesas.php">MESAS</a></li>';
							echo '<li><a style="color:white;font-size:12PX;border:white 1px solid" href="./imprimir_ventas_tienda.php">IMP. VENTAS</a></li>';
								// echo '<li><a style="color:yellow;font-size:12PX;border:white 1px solid" href="./imprimir_ventas_tienda2.php">entregados</a></li>';
								// echo '<li><a style="color:yellow;font-size:12PX;border:white 1px solid" href="./cocina.php">PANTALLA</a></li>';
							//echo '<li><a style="display:none;color:black;font-size:15PX;border:white 1px solid"href="./imprimir_ventas_creditos_tienda.php">Cred.</a></li>';
						//	echo '<li><a style="color:white;font-size:12PX;border:white 1px solid"href="./listar.php">ADM</a></li>';
							echo '<li><a style="color:white;font-size:15PX;border:white 1px solid"href="./vista_reporte.php">REPORTES</a></li>
							<li><a style="color:white;font-size:15PX;border:white 1px solid"href="./egresoadm.php">GASTOS</a></li>
							<li><a style="color:white;font-size:15PX;border:white 1px solid"href="./cambio.php">FRACCIO.</a></li>
							<li><a style="display:none;color:white;font-size:15PX;border:white 1px solid"href="egresoadministrador.php">GASTOS  </a></li>
							<li><a style="color:white;font-size:15PX;border:white 1px solid"href="calculadora.php">CAL</a></li>
							
							        ';
						}else{
						}
						?>	
						<!-- <li ><a style="color:yellow" href="./arqueos.php";>ARQUEOS</a></li> -->
						<li><a style="color:white;font-size:12PX;border:white 1px solid"href="./arqueos_tienda.php">ARQUEOS</a></li>
                    <li ><a style="color:white;font-size:12PX;border:white 1px solid" href="login2.php";>SALIR</a></li> 
                    <li ><a style="background-color:#f37763;color:white;font-size:12PX;border:white 1px solid" href="venderMesa.php";>ACTUALIZAR</a></li> 
                    <li > 
                    <?php 
		 
			if($existe!=null){
				echo '<button  style="color:black;margin-left:5px; margin-top:2px;" type="button" class="btn btn-warning btn-sx" data-toggle="modal" data-target="#myModal">Cerrar Caja </button>';
			}else{
				echo '<button  style="color:black;margin-left:5px; margin-top:2px;" type="button" class="btn btn-warning btn-sx" data-toggle="modal" data-target="#myModal">Abrir Caja  </button>';
			}
			$usuario=$_COOKIE["id"];
			$sqlAtencion = $base_de_datos->query("SELECT * from atencion where usuario='$usuario'");
			$atencion = $sqlAtencion->fetchAll(PDO::FETCH_OBJ);
		
			foreach($atencion as $m){ 
				$idmesa=$m->idmesa;
			//	echo '<button  style="background-color:;color:white" type="button" class="btn btn-success btn-lg" data-toggle="modal"  > MESA '.$m->idmesa.'  </button>';
				 
			}
			 
			$totalxCobrar = $base_de_datos->query("SELECT * from carrito  ");
			$listc = $totalxCobrar->fetchAll(PDO::FETCH_OBJ);
			$monto=0;
			foreach($listc as $m2){ 
				$monto+=$m2->cantidad*$m2->precio;
			}
			echo '<button  style="color:white;margin-left:5px; margin-top:4px;" type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#por_cobrar" > por cobrar '.$monto.'  </button>';
		    

			$totalV = $base_de_datos->query("SELECT ventastienda.entrega,cliente.nombre as cliente, ventastienda.transferencia,ventastienda.detalle,ventastienda.descuento,ventastienda.tipoDeVenta, ventastienda.hora,ventastienda.nombre_de_usuario,ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_vendidos_tienda.cantidad , '..', productos_vendidos_tienda.precio SEPARATOR '__') AS productos FROM ventastienda INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto INNER JOIN cliente on cliente.id=ventastienda.cliente and ventastienda.arqueo=0   GROUP BY ventastienda.id  ORDER BY ventastienda.id DESC ;");
			$listv = $totalV->fetchAll(PDO::FETCH_OBJ);
			$montoV=0;
			foreach($listv as $m2){ 
				$montoV+=$m2->total;
			}
			echo '<button  style="background-color:#232f48;margin-left:5px; margin-top:2px;color:white" type="button" class="btn btn-success btn-lg" data-toggle="modal"  > TOTAL '.$montoV.'  </button>';
		?></li> 
				</ul>
			</div>
		</div>
	</nav>  
<div class="container">
 
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
				<input class="form-control"  type="text"   required name="cajero"  value="'.$_COOKIE["usuario"].'"   >
 				<label for="monto">MONTO DE APERTURA EN BS:</label>
				
				<input    class="form-control"    type="number"   required name="monto" min="0" value="0" step="0.01"  >
				</div>
				<br><br>
				<center> <input class="btn btn-info" type="submit" value="APERTURAR CAJA"></center>
			</form>
				';
			}
		?>

		
	
	<!--<center> <h3>MONTO VENDIDO AL CONTADO <?php echo $totalvendido?>bs.</h3></center>-->
 
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
						
						<?php //echo 'ABONOS COBRADOS'?>
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
					  echo '<td> </td>';
					  echo '</tr>';
					  //	echo '<br>total='.$total;
					?></tr>
					</td>
				</tr>
			</tbody>
		</table>
        </div>
        <div class="modal-footer">
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




  	<!-- modal por cobrar  -->
<div class="modal fade" id="por_cobrar"  role="dialog">
  <div class="modal-dialog" role="document" style="max-width: 70% !important;">
    <div class="modal-content">
      
      <!-- Encabezado -->
      <div class="modal-header" style="background-color:hsl(0, 85.50%, 29.80%); color: white;">
       <center> <h5 class="modal-title" id="tituloModal">CUENTAS POR COBRAR</h5> </center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span style="color:white;" aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Cuerpo -->
      <div class="modal-body"  style=" width: 95%;">
					  
	  	 <?php
include_once "base_de_datos.php";
$carrito_sql = $base_de_datos->query("SELECT c.*,
p.nombre as producto,
u.usuario as cajero
FROM carrito c
LEFT JOIN productos p ON p.id=c.idproducto
LEFT JOIN usuario u ON u.id=c.usuario
order by c.idmesa;");
$carrito = $carrito_sql->fetchAll(PDO::FETCH_OBJ);
?>

<table id="tabla_carrito" class="table table-bordered" style="color:black; border-color:black;">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: #782b0f; align-items:center;">
					
					<th>FECHA</th>
					<th>PRODUCTO</th>
					<th>CANTIDAD</th>
					<th>PRECIO</th>					
					<th>MESA</th>
					<th>USUARIO</th>
					<th>OPCIONES</th>
	
				</tr>
			</thead>
			<tbody style="border-color:black;">
				<?php	
  			foreach($carrito as $carritos){ 
				?>
				<tr>
					<td><?php echo $carritos->fechaInicio ?></td>	
					<td><?php echo $carritos->producto ?></td>	
					<td><?php echo $carritos->cantidad ?></td>	
					<td><?php echo $carritos->precio ?></td>
					<td>
						
					<?php
						if($carritos->idmesa==26){
							echo "personal";
						}else{
							echo $carritos->idmesa ?>
						<?php } ?>
					 </td>	
					<td><?php echo $carritos->cajero ?></td>	
					<td><a href="agregar_mesa.php?id=<?php echo $carritos->idmesa ?>&idusuario=<?php echo $carritos->usuario ?>" ><i class="fa fa-eye"></i> Revisar</a> </td>	
		
		
		<?php }
			?>
			</tbody>
		</table>
   
	
		
		
	
</div>

    </div>
  </div>
</div>
  

  <!--  EN MODAL-->

 
</div>
	<div class="container">
		<div class="row">