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
	<h1>AGREGAR NUEVO</h1>
	<form method="post" enctype="multipart/form-data" action="nuevo_usuario.php" >
		<label for="codigo">usuario :</label>
		<input autofocus class="form-control" name="usuario"   type="text" id="codigo" >
		<label for="nombre">clave:</label>
		<textarea required id="nombre" name="clave" cols="2" rows="1" class="form-control"></textarea>
		<label for="descripcion">tipo: administrador/cajero</label>
		<textarea required id="descripcion" name="tipo" cols="2" rows="1" class="form-control"></textarea>
		 
		 
	</div>
		<br><br><input class="btn btn-info" onclick="hizoClick()" type="submit" value="REGISTRAR">
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