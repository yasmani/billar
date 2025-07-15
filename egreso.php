<?php 
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
	header("Location: ./vender.php");
	# code...
}

?>

<div class="col-xs-12">
	<h1>COMPRAS DE INSUMOS</h1>
	<form method="post" enctype="multipart/form-data" action="EgresoController.php" >
		<label for="codigo">NOMBRE DEL INSUMO:</label>
		<input class="form-control" name="nombre"  required type="text" id="nombre" placeholder="Escribe nombre">
		<label for="cantidad">CANTIDAD DE INSUMO:</label>
		<input class="form-control" name="cantidad"  required type="text" id="cantidad" placeholder="Escribe la cantidad ">

			<input class="form-control" name="detalle" value ="<?php  echo $idCajera?>" required type="hidden" id="detalle" placeholder="Escribe nombre">

		<!-- <label for="descripcion">detalle:</label> -->

		<label for="precioCompra">PRECIO DE INSUMO:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="total" id="total" required>
	</div>
		<br><br><input class="btn btn-info" type="submit" value="GUARDAR">
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