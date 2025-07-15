<?php include_once "encabezado.php" ?>

<div class="col-xs-12">
	<h1>Nuevo producto</h1>
	<form method="post" enctype="multipart/form-data" action="nuevo.php" >
		<label for="codigo">Código de barras:</label>
		<input class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
		<label for="nombre">nombre:</label>
		<textarea required id="nombre" name="nombre" cols="2" rows="1" class="form-control"></textarea>
		<label for="descripcion">nombre:</label>
		<textarea required id="descripcion" name="descripcion" cols="2" rows="1" class="form-control"></textarea>

		<label for="precioCompra">Precio de compra:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precioCompra" id="precioCompra" required>

		<label for="precioVenta">Precio de venta:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precioVenta" id="precioVenta">

		<!-- <input class="form-control" name="precioVenta" required type="number" id="precioVenta" placeholder="Precio de venta"> -->


		<!-- <input class="form-control" name="precioCompra" required type="number" id="precioCompra" placeholder="Precio de compra"> -->

		<label for="existencia">Existencia:</label>
		<input class="form-control" name="existencia" required type="number" id="existencia" placeholder="Cantidad o existencia">
		<label for="existencia">Stock Minimo:</label>
		<input class="form-control" name="stockminimo" required type="number" id="stockminimo" placeholder="minimo">
		<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
		<label>Imagen:</label>
		<input type="file" class="form-control" name="imagen" id="imagen">
		<input type="hidden" name="imagenactual" id="imagenactual">
		<img src="" width="150px" height="120px" id="imagenmuestra">
		
	</div>
		<br><br><input class="btn btn-info" type="submit" value="Guardar">
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