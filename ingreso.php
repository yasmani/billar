<?php include_once "encabezado.php" ?>

<div class="col-xs-12">
	<h1>registrar Ingreso</h1>
	<form method="post" enctype="multipart/form-data" action="ingresoController.php" >
		<label for="codigo">nombre:</label>
		<input class="form-control" name="nombre" required type="text" id="nombre" placeholder="Escribe nombre">

		<label for="descripcion">detalle:</label>
		<textarea required id="detalle" name="detalle" cols="2" rows="1" class="form-control"></textarea>

		<label for="precioCompra">total:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="total" id="total" required>
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