<?php 
session_start();
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
	include_once "encabezado3.php"; 
}
if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
$granTotal = 0;
?>	
<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos;");
$listado_de_proveedores = $base_de_datos->query("SELECT * FROM proveedor order by id desc;");

$listado_de_proveedores = $listado_de_proveedores->fetchAll(PDO::FETCH_OBJ); 
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ); 
$cantidad=-1;
$decuento=0;
?>
<div>
 
<?php
	if(isset($_GET["status"])){
		if($_GET["status"] === "1"){
			?>
				<div class="alert alert-success">
					<strong>¡Correcto!</strong> Compra registrada correctamente
				</div>
			<?php
		}else if($_GET["status"] === "2"){
			?>
			<div class="alert alert-info">
					<strong>compra cancelada</strong>
				</div>
			<?php
		}else if($_GET["status"] === "3"){
			?>
			<div class="alert alert-info">
					<strong></strong> Producto quitado de la lista!!
				</div>
			<?php
		}else if($_GET["status"] === "no-existe"){
			?>
			<div class="alert alert-warning">
					<strong>Error:</strong> El producto que buscas no existe,registra como nuevo producto 
				</div>
			<?php
		}else if($_GET["status"] === "cantidadsuperada"){
			?>
			<div class="alert alert-warning">
					<strong>Error:</strong> cantidad superada
				</div>
			<?php
		}else if($_GET["status"] === "5"){
			?>
			<div class="alert alert-danger">
					<strong>Error: </strong>El producto está agotado
				</div>
			<?php
		}else{
			?>
			<div class="alert alert-danger">
					<strong>Error:</strong> Algo salió mal mientras se realizaba la venta
				</div>
			<?php
		}
	}
?></div>
	<div class="col-xs-12">
		<br>
		<h1>REGISTRO DE COMPRAS</h1>
 		<div class="row">
  <div class="col-md-6">
	<form method="post" action="agregar-carrito-compras.php">
			<label for="codigo">BUSCAR POR CODIGO:</label>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
		</form> 
	</div>
  <div class="col-md-6">
			<label for="buscar">BUSCAR POR NOMBRE:</label>
			<input autofocus class="form-control" type="text" name="caja_busqueda" id="caja_busqueda_tienda"></input>
			<div id="datos"></div>
	</div>
</div>
		<br><br>
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">	 
					<th>PRODUCTO</th>
					<th>CODIGO</th>
					<th>NOMBRE</th>
					<th>DESCRIPCION</th>
					<th style='background-color:green' >PRECIO DE COMPRA</th>
					<th style='background-color:yellow;color:black'>PRECIO 1</th>
					<th style='background-color:orange;color:black'>PRECIO 2</th>
					<th style='background-color:red;color:black'>PRECIO 3</th>
					<th>CANTIDAD</th>
					<th>TOTAL</th>
					<th>QUITAR</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($_SESSION["carrito"] as $indice => $producto){ 
						$granTotal += $producto->total;
					?>
				<tr>
					<td> <?php echo  "<img src='files/articulos/".$producto->imagen."' height='50px' width='50px' >" ?></td>
					<td><?php echo $producto->codigo ?></td>
					<td><?php echo $producto->nombre ?></td>
					<td><?php echo $producto->descripcion ?></td>
					<td>
					<!--  precio compra -->
					<form action="./aumentarPrecioCompra.php" method="post">
					<input name="compras" value="compras" type="hidden">
					<input name="codigo" value="<?php echo $producto->codigo?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:120px; height: 30px" name="precioCompra" id="precioCompra" value="<?php echo $producto->precioCompra ?>" type="text">
					<button class="btn-sm btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
					</td>
					<!-- actulizamos el precio de venta1 -->
					<td>
					<form action="./aumentarPrecioVenta.php" method="post">
					<input name="compras" value="compras" type="hidden">
					<input name="codigo" value="<?php echo $producto->codigo?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:120px; height: 30" name="precioVenta" id="precioVenta" value="<?php echo $producto->precioVenta ?>" type="text">
					<button class="btn-sm btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
					 </td>
					<!-- actulizamos el precio de venta2 -->
					<td>
					<form action="./aumentarPrecioVenta2.php" method="post">
					<input name="compras" value="compras" type="hidden">
					<input name="codigo" value="<?php echo $producto->codigo?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:120px; height: 30" name="precioVenta" id="precioVenta" value="<?php echo $producto->precioVenta2 ?>" type="text">
					<button class="btn-sm btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
					 </td>
					<!-- actulizamos el precio de venta3 -->
					<td>
					<form action="./aumentarPrecioVenta3.php" method="post">
					<input name="compras" value="compras" type="hidden">
					<input name="codigo" value="<?php echo $producto->codigo?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:120px; height: 30" name="precioVenta" id="precioVenta" value="<?php echo $producto->precioVenta3 ?>" type="text">
					<button class="btn-sm btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
					 </td>
					 <!-- sirve para actualizar -->
					<td>
					<form action="./aumentarCantidadCompras.php?" method="post">
					<input name="compras" value="compras" type="hidden">
					<input name="codigo" value="<?php echo $producto->codigo?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:120px; height: 30" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad ?>" type="text">
					<button class="btn-sm btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
					 </td>
					<td><?php echo $producto->total ?></td>
					<!-- quitar del carrito -->
					<td><a  class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice?>"><i class="fa fa-trash"></i></a></td>
				</tr>
				<?php } ?>  
				
			</tbody>
		</table>
		<button  style="color:black" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_proveedor">Regisgtrar encargado de compras </button>                 
			<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
			<script src="./select/bootstrap.min.js"></script>
			<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->
			<link href="./select//bootstrap.min.css" rel="stylesheet" />
			<!-- <script src="./select//bootstrap.min.css"></script> -->
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> -->
			<script src="./select/bootstrap-select.min.js"></script>
			<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->
			<link href="./select/bootstrap-select.min.css" rel="stylesheet" />

		
 		<h3>TOTAL: <?php echo $granTotal.' Bs'; ?></h3>
		<form action="./terminarCompra.php" method="POST">
		<select name="proveedor" class="form-control selectpicker" id="select-country" data-live-search="true">
					<?php foreach($listado_de_proveedores as $proveedor){ 
                    echo '<option   value="'.$proveedor->id.'" data-tokens=""> '.$proveedor->nombre.'-'.$proveedor->telefono.'</option>';
					}
					?>
			   </select>
				<script>
					$(function() {
				$('.selectpicker').selectpicker();
				});
				</script>
			
			<input required name="total" type="hidden" value="<?php echo $granTotal;?>"> 
			<?php
			if ($granTotal>0){
				echo '<button type="submit" class="btn-sm btn-success">TERMINAR COMPRAS</button>
				<a href="./cancelarCompra.php" class="btn btn-danger">CANCELAR COMPRAS</a>
				';
			}
			?>
			
			
		</form>
	</div>
<script>
function SUMA(){
  var X=0;
  var total=0;
  X = $("#recibido").val();
  total = $("#total_venta").val();
  document.getElementById('spTotal').innerHTML = X-$granTotal;
  // document.getElementByName("cambio").innerHTML = x;
} 
function actualizar_cantidad(){
var dato = $('#cantidad').val();
    $.ajax({
       data: {"dato" : dato},
       url: "vender.php",
       type: "post",
     });
}
</script>
<?php include_once "pie.php" ?>