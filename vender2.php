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
$products='';

  if(isset($_GET['categoria'])){
        $categoria=($_GET['categoria']);
      $sentencia1 = $base_de_datos->query("SELECT * FROM productos where lote='$categoria'  ;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
  }else{
      $sentencia1 = $base_de_datos->query("SELECT * FROM productos where lote='PLATOS' and condicion='0' ;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
  }

  $sentencia1 = $base_de_datos->query("SELECT * FROM productos where lote='PROMOCIONES' and condicion='0'  ;");
$promociones = $sentencia1->fetchAll(PDO::FETCH_OBJ);
?>

<?php
include_once "base_de_datos.php";
  
 
 
$cat = $base_de_datos->query("SELECT lote as categorias FROM `productos` GROUP by lote;");
$categorias = $cat->fetchAll(PDO::FETCH_OBJ);
?>
<div>
 
		</div>
	 
 <table style='color:white;background-color:green' border='1' class="default">
		    <tr>
		       
		<?php
		$i=0;
		
		foreach($categorias as $platos){ 
		     //echo '<h2> hola</h2>';
		    $i++;
		    ?>
		    	<form action="./venderTienda.php" method="GET">
		    	    <input type="hidden" name="categoria" value="<?php echo $platos->categorias ?>">
		    	<?php	    
		   echo ' <th style="color:black;background-color:yellow;font-size:20px">';
		   
		    echo '<input type="submit" value=" '.$platos->categorias.'">';
		    // echo ;
		     //echo '<br>';
		    echo '</th>';
		    if($i%8==0){
		        echo '<tr></tr>';
		    }
		    
		    echo '</form>';
		    
		}
		?>
		</tr>
		
		</table>
		<div   class="col-xs-12"  >
<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
					<strong style="background-color:yellow; color:black" >VENTA REALIZADA EXITOSAMENTE </strong>
						<!-- <div class="alert alert-success">
							<strong>¡Correcto!</strong> Venta realizada correctamente
						</div> -->
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-info">
							<strong>Venta cancelada</strong>
						</div>
					<?php
				}else if($_GET["status"] === "3"){
					?>
					<!-- <div class="alert alert-info"> -->
							<!-- <strong>Ok</strong> Producto quitado de la lista -->
					 
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
					<!-- <div class="alert alert-danger"> -->
							<strong style="background-color:yellow; color:black" >Error:El producto está agotado </strong>
					 
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
		?>
		</div>
		<div   class="col-xs-4"  >
		<form method="post" action="agregarAlCarrito2.php">
			<label for="codigo">BUSCAR POR CODIGO:</label>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
		</form> 
		</div >
		<div  class="col-md-7">
				<label for="buscar">BUSCAR :</label>
				<input autofocus class="form-control" type="text" name="caja_busqueda_venta" id="caja_busqueda_ventaTienda"></input>
				<div id="datos_venta"></div>
		</div>
  
          
	<div class="col-md-5" >
			<table class="table table-bordered ">
		
				<?php 
				$i=0;
				foreach($products as $product){ 
					$i+=1;
					?>
				
					<th  >
					 <?php //echo  "<img src='files/articulos/".$product->imagen."' height='70px' width='70px' >" ?> 
					 <?php // echo $product->precioVenta ?>
					 
					 
					 <form method='post' action='agregarAlCarrito_3precios_tienda.php'>
						 
						 <input name='codigo' type='hidden'  value="<?php echo $product->id?>" >
						 <div class='col col-lg-6'>
							 
							 </div>
							 <div class='col col-lg-6'>
								 <input name='precio'   style='color:black;width:50px' type='hidden' value="<?php echo $product->precioVenta?>">
								 <input name='precio' disabled  style='color:black;width:50px' type='hidden' value="<?php echo $product->precioVenta?>">
								</div>
								<div class='col col-lg-6'>
 									 
									<button class="" style='width:130px;border-radius:10px;background-color:white;color:black;font-size:17px' type="submit">
										
										<?php echo $product->nombre  ?>

										<h4> 	 <?php  echo number_format($product->precioVenta , 0, ',', ' '); ?>bs</h4>
																			 									<input autocomplete="off" style='font-size:20px;color:black;width:100px' value='1' type='number' name='cantidad'>

									</button>
								

                    <!-- <input style='background-color:green;color:white;width:90px;font-size:20px' value='<?php echo $product->precioVenta ?>' type='submit' >
					<?php //echo  "<img src='files/articulos/".$product->imagen."' height='70px' width='70px' >" ?>
						</input> -->
                     </div>
                </form>
					
					
					
					<!--<form method='post' action='agregar-carrito-compras-tienda.php'>-->
     <!--         <input type='hidden' value="<?php echo $product->id?>"-->
              
     <!--         autocomplete='off' autofocus class='form-control' name='codigo' required type='text' id='codigo' placeholder='Escribe el código'>-->
     <!--         <button class='btn btn-warning' type='submit'><i class='fa fa-check'></i></button>-->
     <!--       </form>-->
					
					
				<!--	<form method="post" action="agregarAlCarrito.php">-->
					 
				<!--	<input type="hidden" value="<?php echo $product->codigo?>" autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">-->
				<!--	<button class="btn btn-warning" type="submit"><i class="fa fa-check"></i></button>-->
				<!--</form>-->
					
				</th>
				<?php
				if($i%2==0){
					echo '<tr></tr>';
				}
			 } ?>
   <tr></tr>
     </table>
 
	</div>
		 
 
	<div class="col-md-5" >
			<table class="table table-bordered ">
		
				<?php 
				$i=0;
				foreach($promociones as $product){ 
					$i+=1;
					?>
				
					<th  >
					 <?php //echo  "<img src='files/articulos/".$product->imagen."' height='70px' width='70px' >" ?> 
					 <?php // echo $product->precioVenta ?>
					 
					 
					 <form method='post' action='agregarAlCarrito_3precios_tienda.php'>
						 
						 <input name='codigo' type='hidden'  value="<?php echo $product->id?>" >
						 <div class='col col-lg-6'>
							 
							 </div>
							 <div class='col col-lg-6'>
								 <input name='precio'   style='color:black;width:50px' type='hidden' value="<?php echo $product->precioVenta?>">
								 <input name='precio' disabled  style='color:black;width:50px' type='hidden' value="<?php echo $product->precioVenta?>">
								</div>
								<div class='col col-lg-6'>
 									 
									<button class="" style='width:170px;border-radius:10px;background-color:white;color:black;font-size:17px' type="submit">
										
										<?php echo $product->nombre  ?>

										<h4> 	 <?php  echo number_format($product->precioVenta , 0, ',', ' '); ?>bs</h4>
																			 									<input autocomplete="off" style='font-size:20px;color:black;width:100px' value='1' type='number' name='cantidad'>

									</button>
								

                     
                     </div>
                </form>
					
					
				 
					
				</th>
				<?php
				if($i%2==0){
					echo '<tr></tr>';
				}
			 } ?>
   <tr></tr>
     </table>
 
	</div>
		 
 
 
	<div class="col-xs-2">
 <br>
	
 

		
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					 
				  <th style="display:none">CODIGO</th> 
					<th>NOMBRE</th>
				 
				 
					<th style="display:none" >PRECIO</th>
					<th style="display:none">CANTIDAD</th>
					<!-- <th>DESCUENTO</th> -->
					<th>TOTAL</th>					
					<th>QUITAR</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$cantidad_de_productos=0;
				foreach($_SESSION["carrito"] as $indice => $producto){ 
						$granTotal += $producto->total;
						$cantidad_de_productos+=$producto->cantidad;
					?>
				<tr>
					 
					<td style="display:none"><?php echo $producto->codigo ?></td>
					<td style="background-color:white;color:black"  > <?php echo  "<img src='files/articulos/".$producto->imagen."' height='40px' width='60px' >" ?><?php echo $producto->nombre   ?></td>
				 
				 

					<td  style="display:none">
					<form action="./aumentarPrecioTienda.php" method="post">
					<input style="color:black; width:60px; height: 30px" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="indice" value="<?php echo $indice?>" type="hidden">
					<input disabled style="color:black; width:60px;background-color:white; height: 30px" name="precio" id="precio" value="<?php echo $producto->precioVenta ?>" type="text"   >
					
					<button style="display:none" class="btn btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
				</td>
					<td style="display:none">
					<form action="./aumentarCantidadTienda.php" method="post">
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
										 
					<td><?php echo $producto->cantidad."X".number_format($producto->precioVenta)."=". $producto->total ?>Bs</td>

					<td><a  class="btn btn-danger" href="<?php echo "quitarDelCarritoTienda.php?tipo=compra&&indice=" . $indice?>"><i class="fa fa-trash"></i></a>


					</td>

				</tr>

				<?php } ?>  
				
			</tbody>
		</table>
		
		<!-- <h3  style="font-size:40px;display:none">subt÷otal: <?php echo $granTotal.' Bs.'; ?></h3>  -->
		
		<form action="./terminarVentaTienda.php" method="POST">
		<input     style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="nombre_de_usuario"  id="nombre_de_usuario" value="<?php echo $_COOKIE["usuario"]?>">
		<input    style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="idUsuario"  id="idUsuario" value="<?php echo $id?>">
		<label style="font-size: 20px" for="">sub total <?php echo $granTotal; ?> bs </label>
		<input style="display:none;font-size:20px;color:black;width:100px;background-color:white" disabled id="montito" type="text" value="<?php echo $granTotal; ?>"> 
		<br>
		<label style="font-size: 12px" for="">cantidad <?php echo $cantidad_de_productos ?></label>
		
		<input style="display:none" id="total" type="text" value="<?php echo $granTotal; ?>">
	 <!--<br>-->
			<!--<label  for="">Descuento:</label>-->
			<input value="0" id="descuento" value="0" style=" color:black;font-size:20px;width:100px" name="descuento" type="hidden">
			 <!--<br>-->
		<!--<label  for="">QR:</label>-->
		<!--<br>-->
			<input value="0" id="transferencia"  required style="color:black;font-size:20px; align-content:right;width:100px" name="transferencia" type="hidden">
		 
			<!--<label  for="">TARJETA:</label>-->
			<input value="0" id="tarjeta"  required style="margin-left: 70px; color:black;font-size:20px;width:150px" name="tarjeta" type="hidden">
			<br>
			EFECTIV     
			<input value="0"  style="background-color: #7D7B7A;font-size:20px;width:100px" name="Thing" id="Thing" type="text">
			<br>
			CAMBIO
			<input  value="0" style="  background-color: #7D7B7A;font-size:20px;width:100px"  type="text" name="devolver"  id="devolver" value="">
			<br>
		 
			<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		 <div style="color:black" class="col-lg-12">
			 
				<button  style="color:black" type="button" class="btn btn-info btn-sx" data-toggle="modal" data-target="#myModal2">NUEVO </button>
  
			<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
			<script src="./select/bootstrap.min.js"></script>
			<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->
			<link href="./select//bootstrap.min.css" rel="stylesheet" />
			<!-- <script src="./select//bootstrap.min.css"></script> -->
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> -->
			<script src="./select/bootstrap-select.min.js"></script>
			<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->
			<link href="./select/bootstrap-select.min.css" rel="stylesheet" />

			  <div  >
					<label style="color:white" for="cliente">cliente</label>
					<br>
				<select    required name="cliente" class="form-control selectpicker"  data-live-search="true">
				         
					<?php 
					 
					foreach($listaclientes as $cliente){ 
					     
                    echo '<option selected  value="'.$cliente->id.'" > '.$cliente->nombre.'-'.$cliente->telefono.'</option>';
					}
					?>
			   </select> 
			   </div>
				<script>
					$(function() {
				$('.selectpicker').selectpicker();
				});
				</script>
		    </div> 
		
			<div    class="col-lg-12">
				<label for="">ENTREGA</label>
			  <select required name="entrega" class="form-control selectpicker"  data-live-search="true">
			    <option   value="1" > PARA MESA </option>
			    <option   value="2" > PARA LLEVAR </option>
			     </select>
		    </div> 
		    <div style='display:none'   class="col-lg-12">
				<!--<label for="">tipo de salida</label>-->
				 
				<select style="color:black" name="tipoDeVenta" class="form-control selectpicker">
					<option selected  style="color:black"value="1"> CONTADO</option>
					<!--<option style="color:black" value="2" >CREDITO</option>-->
				</select>
				<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		    </div> 
			<!-- <div    class="col-lg-12">
				<label for="">TIPO DE VENTA</label>
				 
				<select style="color:black" name="tipoDeVenta" class="form-control selectpicker">
					<option selected  style="color:black"value="1"> CONTADO</option>
					<option style="color:black" value="2" >CREDITO</option>
				</select>
				<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		    </div>  -->
			<br>
			<br>
			<!-- <label  for="">#ORDEN</label> -->
			<!--<input  style="display:none" style="color:black;font-size:20px" name="orden" type="text">
			<br>-->
			<!--<select required name="mesa" class="form-control selectpicker"  data-live-search="true">-->
			<!--    <option   value="para mesa" > mesa </option>-->
			<!--    <option   value="para llevar" > mesa </option>-->
			<!--     </select>-->
			<label for="">  NOTA</label>
			<br>
			<input style="margin-left: 14px; color:black;font-size:20px;width:100%" name="detalle" type="text"> <br>
			<?php 	 
						if($existe!=null && $granTotal>0){
							echo ' 
										<button style="   type="submit" class="btn btn-primary"  >TERMINAR VENTA</button><a style="display:none;" href="./cancelarVenta.php" class="btn btn-danger">CANCELAR VENTA</a>
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
