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

<div class="col-lg-4" style="margin-left:-35px;">
	<h1>GASTOS </h1>
	<form method="post" enctype="multipart/form-data" action="EgresoControlleradm.php" >
		<label for="codigo">NOMBRE :</label>
		<input class="form-control" name="nombre" autofocus required type="text" id="nombre" placeholder="Escribe nombre">
		<label for="cantidad">DESCRIPCION :</label>
    <input class="form-control" name="detalle"  required type="text" id="detalle" placeholder="Escribe la descripcion">
    <label for="cantidad">CANTIDAD :</label>
		<input class="form-control" name="cantidad"  required type="number" id="cantidad" placeholder="Escribe la cantidad">
			<input class="form-control" name="usuario" value ="<?php  echo $_COOKIE["usuario"]?>" required type="hidden" id="usuario">

	

		<label for="precioCompra">TOTAL:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="total" id="total" required>

		<br><br><input class="btn btn-info" type="submit" value="GUARDAR">
	</form>
	</div>
  <div class="col-lg-8">
  	<h1 style="color:black">REPORTE DE GASTOS ADMINISTRATIVOS</h1>
  <!--
	<form name="formulario" target="_blank" action="reportes/reporteegresosadm.php"
                      id="formulario" method="POST">
	<h1 style="color:black">REPORTE DE GASTOS ADMINISTRATIVOS</h1>-->
                      <!--div responsivo-->
                            <!-- <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>FECHA INICIO:</h3>
                            <input value="<?php echo date('m-d-Y') ?>" style="color:black"  type="date" id="inicio" name="inicio"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">-->
                             <!--required-->
                             <!-- </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h3>FECHA FINAL:</h3>
                              <input  style="color:black" type="date" id="fin" name="fin"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">-->
                               <!--required-->
                               <!-- </div>
                              
                              
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
                                <!--buton de tipo submit el cual envia el formulario por el metodo por ajax   -->
                              <!--    <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-print"></i> IMPRIMIR</button>
                              </div>-->



                              <?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';



date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT * FROM egresosadm WHERE condicion='0' ORDER by fecha desc");
$gastos = $sentencia->fetchAll(PDO::FETCH_OBJ);

?>


	
	<br>
	<table id="tabla_gastos_adm" style="color:black" name="tabla" class="table table-bordered">
		<thead style="color:white; " name="tabla" class="table table-darger">
			<tr style="background-color: #46818a;">
				<th>FECHA</th>
				<th>NOMBRE</th>
				<th>DETALLE</th>
        <th>CANTIDAD</th>
				<th>TOTAL</th>
        	<th>USUARIO</th>
				<?php 
					     if ($tipo=='cajero') {
							 echo '<th>ELIMINAR</th>';
							}
							?>
				</tr>
			</thead>
			<tbody>
				<?php
				$totalgastado=0;

				
				foreach($gastos as $gas){ 

							
							?>
				<tr> 
						<td><?php echo date("d/m/Y", strtotime($gas->fecha)) ?></td>
					<td><?php echo $gas->nombre ?></td>
				
					<td><?php echo $gas->detalle ?></td>
          <td><?php echo $gas->cantidad ?></td>
          <td><?php echo $gas->total ?></td>
          <td><?php echo $gas->usuario ?></td>
           <?php 
					     if ($tipo=='cajero') {
					     ?>
					     <td>
					     <a class="btn btn-danger" href="#"><i class="fa fa-trash"></i></a>
					     </td>

					     <?php }
         
          $totalgastado=$totalgastado+$gas->total;?>
           </tr>
        <?php }?>
       

</tbody>
		</table>
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

		$(document).ready(function() {

   if ($.fn.DataTable.isDataTable('#tabla_gastos_adm')) {
    $('#tabla_gastos_adm').DataTable().destroy();
}

$('#tabla_gastos_adm').DataTable({
	dom: 'Bflrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel" style="bakbackground-color:#5bc25b;"></i> Excel',
            className: 'btn btn-success'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf" style="bakbackground-color:#ee635c;"></i> PDF',
            className: 'btn btn-danger'
        }
    ],
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
    },
    pageLength: 10,
    ordering: true,
    searching: true
});


});

</script>