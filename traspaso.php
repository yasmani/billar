   <?php 
session_start();
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
if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
$granTotal = 0;
?>

<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos limit 0;");
$listaclientes = $base_de_datos->query("SELECT * FROM cliente order by id desc;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ); 
$cantidad=-1;
$descuento=0;
$sentencia = $base_de_datos->query("SELECT * FROM apertura_tienda where estado='0';");
$aperturados = $sentencia->fetchAll(PDO::FETCH_OBJ);
$existe=null;
	foreach($aperturados as $producto){ 
	$existe++;
}
?>
<?php
include_once "base_de_datos.php";
  
$sentencia1 = $base_de_datos->query("SELECT * FROM productos WHERE codigo ;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
$sentencia3 = $base_de_datos->query("SELECT * FROM productos WHERE codigo >=0 and codigo <0;");
$products3 = $sentencia3->fetchAll(PDO::FETCH_OBJ);

?>

<?php
include_once "base_de_datos.php";
  
$sentencia2 = $base_de_datos->query("SELECT * FROM productos WHERE codigo >=0 and codigo <=0;");
$products2 = $sentencia2->fetchAll(PDO::FETCH_OBJ);

$sentencia4 = $base_de_datos->query("SELECT * FROM productos WHERE codigo >=0 and codigo <0;");
$products4 = $sentencia4->fetchAll(PDO::FETCH_OBJ);
?>
<div>
 
<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-success">
							<strong>¡Correcto!</strong> Venta realizada correctamente
						</div>
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-info">
							<strong>BAJA cancelada</strong>
						</div>
					<?php
				}else if($_GET["status"] === "3"){
					?>
					<div class="alert alert-info">
							<strong>Ok</strong> Producto quitado de la lista
						</div>
					<?php
				}else if($_GET["status"] === "4"){
					?>
					<div class="alert alert-warning">
							<strong>Error:</strong> El producto que buscas no existe
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
				}else if($_GET["status"] === "6"){
					?>
					<div class="alert alert-danger">
							<strong>Error: </strong>precio fuera de rango
						</div>
					<?php
				}else if($_GET["status"] === "7"){
					?>
					<div class="alert alert-success">
							<strong>OK: </strong>precio modificado 
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
		<br>
 

	<div class="col-xs-12">
	<h2>BAJAS   <?php
	 
	 ?>
	</h2>
	<div   class="col-md-3">
		<form method="post" action="agregarAlCarritoTraspaso.php">
			<label for="codigo">BUSCAR POR CODIGO:</label>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
		</form> 
	</div>
		<div class="col-md-9">
				<label for="buscar">BUSCAR :</label>
				<input autofocus class="form-control" type="text" name="caja_busqueda_traspaso" id="caja_busqueda_traspaso"></input>
				<div id="datos_venta"></div>
		</div>
</div>
		
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					 
				  <th>CODIGO</th> 
					<th>NOMBRE</th>
					<th>DESCRIPCION</th>
					<th>CATEG.</th>
					<th>PRECIO</th>
					<th>CANTIDAD</th>
					<!-- <th>DESCUENTO</th> -->
					<th>TOTAL</th>					
					<th>QUITAR</th>
				</tr>
			</thead>
			<tbody style='color:black'>
				<?php foreach($_SESSION["carrito"] as $indice => $producto){ 
						$granTotal += $producto->total;
					?>
				<tr>
					 
					<td><?php echo $producto->codigo ?></td>
					<td><?php echo $producto->nombre ?></td>
					<td><?php echo $producto->descripcion ?></td>
					<td><?php echo $producto->lote ?></td>

					<td>
					<form action="./aumentarPrecioTraspaso.php" method="post">
					<input style="color:black; width:60px; height: 30px" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:60px;background-color:white; height: 30px" name="precio" id="precio" value="<?php echo $producto->precioVenta ?>" type="text"   >
					
					<button class="btn btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
				</td>
					<td>
					<form action="./aumentarCantidadTraspaso.php" method="post">
					<input style="color:black" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black;background-color:white; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad ?>" type="text"   >
					
					<button class="btn btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
					<form style="display: none;" action="./aumentarCantidadTienda.php" method="post">
					<input style="color:black;background-color:white" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:white; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad+1 ?>" type="hidden"   >
					
					<button class="btn btn-info" type="submit"  > <i  class="  fa fa-plus "></i></button>
					</form>
					<form style="display: none;" action="./aumentarCantidadTienda.php" method="post">
					<input style="color:black" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad-1 ?>" type="hidden"   >
					
					<button class="btn btn-warning" type="submit"  > <i  class="  fa fa-minus "></i></button>
					</form>
					<td style="display: none;" >
					<form action="./RebajarPrecio.php" method="post">
						<input name="codigo" value="<?php echo $producto->id?>" type="hidden">
						<input name="indice" value="<?php echo $indice?>" type="hidden">
						<input style="color:black;background-color:white"   name="rebajar" id="rebajar" value="<?php echo $producto->descuento ?>" type="text">

						<button class="btn-sm btn-danger" type="submit"  > BS.<i  class="  fa fa-money-bill-alt "></i></button>


						</form>
					</td>
				</td>
										 
					<td><?php echo $producto->total ?></td>

					<td><a  class="btn btn-danger" href="<?php echo "quitarDelCarritoTraspaso.php?tipo=compra&&indice=" . $indice?>"><i class="fa fa-trash"></i></a>


					</td>

				</tr>

				<?php } ?>  
				
			</tbody>
		</table>
		
		<!-- <h3  style="font-size:40px;display:none">subt÷otal: <?php echo $granTotal.' Bs.'; ?></h3>  -->
		
		<form action="./terminarTraspaso.php" method="POST">
		<input     style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="nombre_de_usuario"  id="nombre_de_usuario" value="<?php echo $_COOKIE["usuario"]?>">
		<input    style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="idUsuario"  id="idUsuario" value="<?php echo $id?>">
		<label style="font-size: 40px" for="">sub total</label>
		<input style="font-size:40px;color:black;width:150px;background-color:white" disabled id="montito" type="text" value="<?php echo $granTotal; ?>"> 
		<input style="display:none" id="total" type="text" value="<?php echo $granTotal; ?>">
		<BR></BR>
				<!-- 	<label  for="">Descuento:</label>   -->
			<input id="descuento" value="0" style="margin-left: 10px; color:black;font-size:20px;width:150px" name="descuento" type="hidden">
			<br>
		<!-- 	<label  for="">TRANSFERENCIA:</label>-->
			<input id="transferencia" value="0" style="margin-left: 10px; color:black;font-size:20px;width:150px" name="transferencia" type="hidden">
			<br>
			<!-- 	<label  for="">TARJETA:</label>-->
			<input id="tarjeta" value="0" style="margin-left: 70px; color:black;font-size:20px;width:150px" name="tarjeta" type="hidden">
			
			        
			<input value="0"  style="margin-left: 70px; color:black;font-size:25px; align-content:right;width:150px" name="Thing" id="Thing" type="hidden">
			
			 
			<input  value="0" style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="devolver"  id="devolver" value="">
			
		 
			<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		 <div style="color:black" class="col-lg-12">
			<br>
			<button  style="color:black;display:none" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2">NUEVO </button>
<br>   
			<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
			<script src="./select/bootstrap.min.js"></script>
			<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->
			<link href="./select//bootstrap.min.css" rel="stylesheet" />
			<!-- <script src="./select//bootstrap.min.css"></script> -->
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> -->
			<script src="./select/bootstrap-select.min.js"></script>
			<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->
			<link href="./select/bootstrap-select.min.css" rel="stylesheet" />

 
				<select style="display:none"  name="cliente" class="form-control selectpicker"  data-live-search="true">
				         
					<?php 
					 
                    echo '<option selected  value="1" > </option>';
					foreach($listaclientes as $cliente){ 
					     
                   // echo '<option   value="'.$cliente->id.'" > '.$cliente->nombre.'-'.$cliente->telefono.'</option>';
					}
					?>
			   </select>
				<script>
					$(function() {
				$('.selectpicker').selectpicker();
				});
				</script>
		    </div> 
			<br>
			<div style="display:none"  class="col-lg-12">
				
			  
				<select style="color:black" name="tipoDeVenta" class="form-control selectpicker">
					<option selected  style="color:black"value="1">CONTADO</option>
					<option style="color:black" value="2" >POR COBRAR</option>
				</select>
				<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		    </div> 
			<br>
			<br>
			<!-- <label  for="">#ORDEN</label> -->
			<!--<input  style="display:none" style="color:black;font-size:20px" name="orden" type="text">
			<br>-->
			<label for="">NOTA</label>
			<br>
			<input style="margin-left: 14px; color:black;font-size:20px;width:100%" name="detalle" type="text"> <br>
			<?php 	 
						if($existe!=null && $granTotal>0){
							echo ' 
										<button style="margin-left: 140px; type="submit" class="btn btn-primary"  >REGISTRAR BAJA</button><a href="./cancelarVenta.php" class="btn btn-danger">CANCELAR  </a>
										 ';
						}else{
						}
					?>	
			
		</form>
	</div>
	 
       
<script>
 document.getElementsByName("Thing")[0].addEventListener('change', doThing);
document.getElementById("montito").value;

function doThing(){
	var s=parseFloat($("#tarjeta").val())+parseFloat($("#transferencia").val());
		document.getElementById('devolver').value =parseFloat( this.value)+parseFloat(s) - parseFloat(document.getElementById("montito").value - parseFloat(document.getElementById("descuento").value)) ;
}
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
