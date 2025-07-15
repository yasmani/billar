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

$sentencia = $base_de_datos->query("SELECT * FROM productos  ORDER BY id desc ;");
if(isset($_GET['codigo'])){
    $codigo=$_GET['codigo'];
    $sentencia = $base_de_datos->query("SELECT * FROM productos where codigo='$codigo' or nombre like '%$codigo%' ;");
}
//$sentencia = $base_de_datos->query("SELECT * FROM productos ;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>


	<div  class="col-xs-8">
		<h1>LISTAS DE PRODUCTOS</h1>
		<div>
		  <!--<a class="btn btn-success" href="./formularioR.php">NUEVO ITEM <i class="fa fa-plus"></i></a>  -->
		  <!--<a class="btn btn-info" href="./listar-inventario.php">VER INVENTARIO <i class="fa fa-plus"></i></a>  -->
		  <a class="btn btn-danger" href="./ventaseliminado.php">ELIMINAR VENTA <i class="fa fa-plus"></i></a>  
		   <a class="btn btn-info" href="./reporte.php">REPORTE DE VENTAS <i class="fa fa-plus"></i></a>  

		   <a class="btn btn-info" href="./verventas.php">buscar ventas por cliente <i class="fa fa-plus"></i></a> 
		   <li><a class="btn btn-success"  href="./todasLasCompras.php">REPORTE COMPRAS</a></li>
		     

  <div style="display:none" class="btn-group">
		  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
     REPORTES <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <!-- <li><a class="btn btn-warning" href="./reporteegresos.php">REPORTE INSUMOS</a></li> -->
      <!-- <li><a class="btn btn-warning" href="./reporteegresos.php">REPORTE DE VENTAS </a></li> -->
      <li><a class="btn btn-danger"  href="./reporteadm.php">REPORTE GASTOS ADM</a></li>
      <li><a class="btn btn-success" href="./reporte.php">REPORTE VENTAS</a></li>
      <!-- <li><a class="btn btn-primary" href="./reporteegresosdes.php">REPORTE DE BAJAS</a></li> -->
      <li><a class="btn btn-success"  href="./todasLasCompras.php">REPORTE COMPRAS</a></li>
    </ul>

		</div>

		<!--<a class="btn btn-warning btn-lg"  href="./listar1.php">LISTA POR COBRAR <i class="fa fa-user"></i></a>
		<a class="btn btn-danger btn-lg"  href="./listar4.php">LISTA POR PAGAR <i class="fa fa-user"></i></a>-->
		

		  <!-- <a class="btn btn-warning" href="reporteegresos.php">REPORTE DE GASTOS <i class="fa fa-plus"></i></a>   -->
		  <!--<a class="btn btn-warning" href="./reporte.php">REPORTE DE VENTAS <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-warning" href="./todasLasCompras.php">REPORTE DE COMPRAS <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-warning" href="./reporteegresos.php">REPORTE DE INSUMOS <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-warning" href="./reporteadm.php">REPORTE DE ADM <i class="fa fa-plus"></i></a> --> 
					<!-- <li><a style="color:white" href="./reporte.php">Reporte de ventas</a></li> -->
		</div>
		<br>
		<br>
		<form  metodo="GET" action="listar.php">
  <label for="fname">buscar codigo:</label><br>
  <input style="color:black" type="text" name="codigo" ><br>
   
  <input style="color:black" type="submit" value="BUSCAR">
</form>
		<table style="" name="tabla" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<!-- <th>ID</th> -->
					<th>CODIGO</th>
					<th>foto</th>
					<th>NOMBRE</th>
					<!--<th>DESCRIPCION</th>-->
					<th>categoria</th>
					<th>COSTO</th>
					<th>PRECIO</th>
					<!--<th>PRECIO2</th>-->
					<!--<th>PRECIO3</th>-->
					<th style="display:none" >ALMACEN</th>
					<th>CANTIDAD</th>
					<!--<th   >ALMACEN</th>-->
					<!--<th>STOCK MINIMO</th>-->
					<th>EDITAR</th>
					<th>ELIMINAR</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($productos as $producto){ ?>
				<tr>
					
					<td><?php echo $producto->codigo ?></td>
						<td> <?php echo  "<img src='files/articulos/".$producto->imagen."' height='50px' width='50px' >" ?></td>
					<td><?php echo $producto->nombre ?></td>
					<!--<td><?php echo $producto->descripcion ?></td>-->
					<td><?php echo $producto->lote ?></td>
					<td><?php echo $producto->precioCompra ?></td>
					<td><?php echo $producto->precioVenta ?></td>
					<!--<td><?php echo $producto->precioVenta2 ?></td>-->
					<!--<td><?php echo $producto->precioVenta3 ?></td>-->
					<td style="display:none" ><?php echo $producto->existencia ?></td>
					<td><?php echo $producto->tienda ?></td>
					<!--<td  ><?php echo $producto->existencia ?></td>-->
					<!--<td><?php echo $producto->stockminimo ?></td>-->
					<td style="display: none;">   <?php echo  "<img src='./files/articulos/".$producto->imagen."' height='50px' width='50px' >" ?></td>
					<td><a class="btn btn-warning" target="" href="<?php echo "editar.php?id=" . $producto->id?>"><i class="fa fa-edit"></i></a></td>
					<td><a class="btn btn-danger" href="<?php echo "eliminar.php?id=" . $producto->id?>"><i class="fa fa-trash"></i></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div  style='padding-left:100px'  class="col-xs-3">
	<h1>AGREGAR NUEVO PRODUCTO</h1>
	<?php 
	$sentencia = $base_de_datos->query("SELECT * FROM productos order by id desc limit 1 ;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
$codigo=0;
$nombre='';
  foreach($productos as $producto){  
		$codigo=$producto->codigo ;
		$nombre=$producto->nombre ;
		echo $nombre, '  codigo='.$codigo.'-  '.$producto->tienda.'- '.$producto->precioVenta3.' producto ' ;	
		}
?>
	<form method="post" enctype="multipart/form-data" action="nuevoRtienda.php" >
		<label for="codigo">CODIGO :</label>
		<input  class="form-control" name="codigo" required type="text" id="codigo" value='<?php echo $codigo+1?>'>
		<label for="nombre">NOMBRE DEL PRODUCTO:</label>
		<textarea  autofocus required id="nombre" name="nombre" cols="2" rows="1" class="form-control"></textarea>
	 <input value="." class="form-control" name="descripcion"   type="hidden" id="lote" placeholder="Escribe el lote">
	 
		<label for="lote">CATEGORIA</label>
		<input value="" class="form-control" name="lote" required type="text" id="lote" placeholder="Escribe el lote">
		 <label for="lote">PRECIO DE COSTO</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="text" step="0.01" value='00.00' name="precioCompra" id="precioCompra" required>

		<label for="precioVenta">PRECIO DE VENTA:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precioVenta" id="precioVenta">
		<!--<label for="precio2">PRECIO 2:</label>-->
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"     type="hidden" step="0.01" value='00.00' name="precio2" id="precio2">
		<!--<label for="precioVenta">PRECIO 3:</label>-->
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="hidden" step="0.01" value='00.00' name="precio3" id="precio3">
		<!-- <input class="form-control" name="precioVenta" required type="number" id="precioVenta" placeholder="Precio de venta"> -->
		 <!--<input class="form-control" name="precioCompra" required type="number" id="precioCompra" placeholder="Precio de compra"> -->
		<!-- <label   for="existencia">ALMACEN:</label>  -->
		<input  class="form-control"  name="existencia" value="0"   step="0.01" value='00.00' type="hidden" id="existencia" placeholder="Cantidad o existencia">
		<label   for="existencia">CANTIDAD:</label> 
		<input  class="form-control"  name="tienda"   step="0.01" value='' type="text" id="tienda" placeholder="Cantidad en tienda">
			<label   for="existencia">VENCIMIENTO (OPCIONAL):</label> 
		<input  class="form-control"  name="fecha"     type="date" id="fecha"  >
 
		<input  value="0" class="form-control" name="stockminimo"  step="0.01" value='00.00'  type="hidden" id="stockminimo" placeholder="minimo">
		<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
		<label   >IMAGEN:</label>
		<input   type="file" class="form-control" name="imagen" id="imagen">
		<input type="hidden" name="imagenactual" id="imagenactual">
		<img   src="" width="150px" height="120px" id="imagenmuestra">
		
	</div>
		<br><br><input class="btn btn-info" onclick="hizoClick()" type="submit" value="GUARDAR PRODUCTO">
	</form>
</div>
<?php include_once "pie.php" ?>