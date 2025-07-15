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

<div class="col-xs-12">
	<h1>AGREGAR NUEVO PRODUCTO</h1>
	<form method="post" enctype="multipart/form-data" action="nuevoR.php" >
		<label for="codigo">CODIGO :</label>
		<input autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
		<label for="nombre">NOMBRE DEL PRODUCTO:</label>
		<textarea required id="nombre" name="nombre" cols="2" rows="1" class="form-control"></textarea>
		<label for="descripcion">DESCRIPCION:</label>
		<textarea required id="descripcion" name="descripcion" cols="2" rows="1" class="form-control"></textarea>
		<label for="lote">Categoria</label>
		<input class="form-control" name="lote" required type="text" id="lote" placeholder="Escribe el lote">
		<label for="precioCompra">PRECIO DE COMPRA:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precioCompra" id="precioCompra" required>

		<label for="precioVenta">PRECIO 1:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precioVenta" id="precioVenta">
		<label for="precio2">PRECIO 2:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precio2" id="precio2">
		<label for="precioVenta">PRECIO 3:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precio3" id="precio3">
		<!-- <input class="form-control" name="precioVenta" required type="number" id="precioVenta" placeholder="Precio de venta"> -->
		<!-- <input class="form-control" name="precioCompra" required type="number" id="precioCompra" placeholder="Precio de compra"> -->
		
		<label for="existencia">STOCK EN TIENDA:</label> 
		<input  class="form-control"  name="tienda"   step="0.01" value='00.00' type="number" id="tienda" placeholder="Cantidad en tienda">
		<label  for="existencia"> ALMACEN:</label> 
		<input  class="form-control"  name="existencia"   step="0.01" value='00.00' type="text" id="existencia" placeholder="Cantidad o existencia">
		<label for="existencia">STOCK MINIMO:</label>
		<input  value="0" class="form-control" name="stockminimo"  step="0.01" value='00.00'required type="number" id="stockminimo" placeholder="minimo">
		<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
		<label style="display: none;" >IMAGEN:</label>
		<input style="display: none;" type="file" class="form-control" name="imagen" id="imagen">
		<input type="hidden" name="imagenactual" id="imagenactual">
		<img style="display: none;" src="" width="150px" height="120px" id="imagenmuestra">
		
	</div>
		<br><br><input class="btn btn-info" onclick="hizoClick()" type="submit" value="GUARDAR PRODUCTO">
	</form>
</div>

<script> 
$(document).on('keydown', 'input[pattern]', function(e){
  var input = $(this);
  var oldVal = input.val();
  var regex = new RegExp(input.attr('pattern'), 'g');

  setTimeout(function(){
    var newVal = input.val();
    if(!regex.test(newVal)){
      input.val(oldVal); 
    }
  }, 0);
}); 
function setTwoNumberDecimal(el) {
        el.value = parseFloat(el.value).toFixed(2);
    };

		</script>

<?php include_once "pie.php" ?>