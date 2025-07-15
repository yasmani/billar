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


include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
?>
<style>
	

.metric {

-webkit-border-radius: 3px;

-moz-border-radius: 3px;

border-radius: 3px;

padding: 20px;

margin-bottom: 30px;

border: 1px solid #DCE6EB; }



 

.metric p {

  margin-bottom: 0;

  line-height: 1.2;

  text-align: right; }

.metric .number {

  display: block;

  font-size: 28px;

  font-weight: 300; }

.metric .title {

  font-size: 16px; 
    color:green;
}


</style>

</div>
</div>

<div style="width:100%; margin-top:15px;margin-left:180px;">

<li><a class="btn btn-danger" href="./ventaseliminado.php">ELIMINAR VENTA <i class="fa fa-plus"></i></a>  
		   <a class="btn btn-info" href="./reporte.php">REPORTE DE VENTAS <i class="fa fa-plus"></i></a>  

		   <a class="btn btn-info" href="./verventas.php">buscar ventas por cliente <i class="fa fa-plus"></i></a> 
		   <a class="btn btn-success"  href="./todasLasCompras.php">REPORTE COMPRAS</a></li>

</br>

<div  class="col-lg-2">
       <div class="metric">
            <img src="./files/articulos/fotos/bienes.png" height="80px" width="80px">
            <p>
              
                <span class="number"><input type="radio" id="ventas" style="width: 25px; height: 25px;" name="opcion" value="1"></span>
                  <br>
                <span class="title">Reporte de Ventas
				</span>
            </p>
        </div>
</div>
<div class="col-lg-2">
            <div class="metric">
                <img src="./files/articulos/fotos/compras.png" height="80px" width="80px">
                <p>                   
                <span class="number"><input type="radio" id="compras" style="width: 25px; height: 25px;" name="opcion" value="2"></span>
                  <br>
                    <span class="title">Reporte de Compras</span>
                </p>
            </div>
       		</div>
    


<!--<div class="col-lg-2">
            <div class="metric">
                <img src="./files/articulos/fotos/biometrico.png" height="80px" width="80px">
                <p>                   
                <span class="number"><input type="radio" id="personal" style="width: 25px; height: 25px;" name="opcion" value="3"></span>
                  <br>
                    <span class="title">Reporte de personal</span>
                </p>
            </div>
</div>-->
    


<div id="ventas_reporte">

<div class="col-lg-1">
<form action="./imprimir_arqueo_2.php" method="post" >


                             
    <input type="date" class="form-control" id="inicio" name="inicio" style="width: 150px;" >
    
</div>

<div class="col-lg-1">
                             
    <input type="date" class="form-control" id="fin" name="fin" style="width: 150px;" >
    
</div>



<div class="col-lg-1">
                             
    <button  class="btn btn-success" id="buscar" name="buscar" style="width: 80px;" type="submit" >
    BUSCAR
    </button>
    

</form>
</div>
</div>




<div id="compras_reporte" style="display:none;">

<div class="col-lg-1">
                             
    <input type="date" class="form-control" id="inicio2" name="inicio2" style="width: 150px;" >
    
</div>

<div class="col-lg-1">
                             
    <input type="date" class="form-control" id="fin2" name="fin2" style="width: 150px;" >
    
</div>

<div class="col-lg-2" >
                             
    <select  class="form-control" id="productos" name="productos" style="width: 250px;" >
      <option value="0"> Seleccione... </option>
      <?php
include_once "base_de_datos.php";
  
$sentencia = $base_de_datos->query("SELECT * FROM productos where estado=1;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
	foreach($productos as $producto){ 
    ?>
    <option value="<?php echo $producto->id; ?>"><?php echo $producto->nombre; ?></option>

 <?php }
?>
    
    </select>

</div>

<div class="col-lg-1">
                             
    <button  class="btn btn-success" id="buscar_compras" name="buscar_compras" style="width: 80px;" type="submit" >
    BUSCAR
    </button>
    


</div>
</div>

</div>


<div   id="datos_reporte" style="width:90%; margin-top:15px;margin-left:150px;">

					
	</div>


		<script>
		$(document).ready(function() {

   if ($.fn.DataTable.isDataTable('#tabla_compras_tienda')) {
    $('#tabla_compras_tienda').DataTable().destroy();
}

$('#tabla_compras_tienda').DataTable({
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

</div>
</div>
