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
	 # code...
	 header("Location: ./vender.php");
 }
 
 
 ?>

<div class="col-xs-12">
	<h1>GENERADOR DE CODIGO DE BARRA</h1>
 
	<input  style="color:black" type="text" id="data" placeholder="Ingresa un valor">
  <button style="color:black" type="button" id="generar_barcode">Generar código de barras</button>
  <div id="imagen"></div>
   
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 
  <script>
    $("#generar_barcode").click(function() {
    var data = $("#data").val();
	$("#imagen").html('<img  src="barcode.php?text='+data+'&size=90&codetype=Code39&print=true"/>');
	$.post( "guardarImagen.php", { filepath: "codigosGenerados/"+data+".png", text:data } );

    });
  </script>
  
</div>
<?php
$directorio = opendir("./codigosGenerados/");
while ($imagen = readdir($directorio)) {
    if (is_dir($imagen)) {
        echo $imagen."<br/>";
    }
    else
    {
        $completo = $directorio.$imagen;
        echo  '<img src ="./codigosGenerados/'.$imagen.'"/>' ;
        echo "<br>" ;
        echo '<a style="color:white" href="./codigosGenerados/'.$imagen.'" download="descargar">
		Descargar
		</a>' ;
        echo "<br>" ;
    }
}
?>
 
<?php include_once "pie.php" ?>