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


?>

<div class="col-xs-12">
	<h1>GASTOS DE ADMINISTRACION</h1>
	<form method="post" enctype="multipart/form-data" action="EgresoControlleradm2.php" >
		<label for="codigo">NOMBRE :</label>
		<input class="form-control" name="nombre" autofocus required type="text" id="nombre" placeholder="Escribe nombre">
		<label for="cantidad">DESCRIPCION :</label>
		<input class="form-control" name="cantidad"  required type="text" id="cantidad" placeholder="Escribe la descripcion">
			<input class="form-control" name="detalle" value ="<?php  echo $idCajera?>" required type="hidden" id="detalle" placeholder="Escribe nombre">

		<!-- <label for="descripcion">detalle:</label> -->

		<label for="precioCompra">TOTAL:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="total" id="total" required>
	</div>
		<br><br><input class="btn btn-info" type="submit" value="GUARDAR">
	</form>
	<form name="formulario" target="_blank" action="reportes/reporteegresosadministrador.php"
                      id="formulario" method="POST">
	<h1 style="color:white">REPORTE DE GASTOS ADMINISTRATIVOS</h1>
                      <!--div responsivo-->
                           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>FECHA INICIO:</h3>
                            <input value="<?php echo date('m-d-Y') ?>" style="color:black"  type="date" id="inicio" name="inicio"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">
                             <!--required-->
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h3>FECHA FINAL:</h3>
                              <input  style="color:black" type="date" id="fin" name="fin"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">
                               <!--required-->
                              </div>
                              
                              
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!--buton de tipo submit el cual envia el formulario por el metodo por ajax   -->
                                <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-print"></i> IMPRIMIR</button>
                              </div>
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