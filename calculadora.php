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
$tarifa=0;
$inicio=0;
$fin=0;
	if(isset($_POST["hora"])){
	    $tarifa=$_POST["hora"];
	     $inicio=$_POST["inicio"];
	     $fin=$_POST["fin"];
	}

?>

<div class="col-xs-6">
	<h1>FRACIONAMIENTO </h1>
	<form method="post" enctype="multipart/form-data" action="calculadora.php" >
		<label for="codigo">TARIFA HORA :</label>
		<input class="form-control" value="<?php echo $tarifa?>" name="hora" autofocus   type="number" id="nombre"  >
		
		<label for="cantidad">HORA INICIO :</label>
		<input class="form-control" value="<?php echo $inicio?>" name="inicio"   required type="time" id="cantidad"  >
				<label for="codigo">HORA FIN :</label>
		<input class="form-control" value="<?php echo $fin?>" name="fin"  required type="time" id="nombre"  >
			 

	 

		<label for="precioCompra">CALCULAR:</label>
		
	 
 
		<br><br><input class="btn btn-info" type="submit" value="CALCULAR">
	</form>
	 
 
</div>
<div class="col-xs-6">
    		<label for="precioCompra">REGISTRADOS:</label>
    		
    		
    		
    		<?php
    		if(isset($_POST["hora"])){
    		$tarifa=$_POST["hora"];
    		$inicio=$_POST["inicio"];
    		$fin=$_POST["fin"];
    // 		echo 'tarifa'. $tarifa; 
    		
    		$fechaUno=new DateTime($inicio);
$fechaDos=new DateTime($fin);

$dateInterval = $fechaUno->diff($fechaDos);
$data= $dateInterval->format(' %H horas %i minutos %s segundos');
$total=($dateInterval->format('%H')*$tarifa)+$dateInterval->format('%i')*0.25
?>
 <h1> <?php echo "TARIFA:".$tarifa;?>  </h1>
 <h1> <?php echo "INICIO:".$inicio;?>  </h1>
 <h1> <?php echo "FIN:".$fin;?>  </h1>
 <h1> <?php echo $data;?> bs</h1>
 <h1> <?php echo "TOTAL ".number_format($total, 0, ',', ' ');?> bs</h1>
<?php
    		
    		}
    		
 
?>


 
		 
 
	 
		
		</table>
		
		
		
    </div>
 
<?php //include_once "pie.php"; ?>