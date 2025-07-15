<?php
 //if(isset($body) || $body == true)
//{
 
//} else {
  //  echo '<body style="background-color:#3CB371">';
//}

?>
 
 
 
 
 
 
 


<body style="background-color:#8fdd8e;">
<?php include_once "encabezado2.php" ?>
	<div class="center-block">

		<div  style="color:white" class="container">
		     	<div class="col-md-5 col-md-offset-3">
		     	    	<h1>SISTEMA BILLAR
		     	    	version.12022025</h1>
		        <form method="post" action="acceso.php" enctype="multipart/form-data">
        			<input type="hidden" name="id" value="<?php echo $producto->id; ?>">
        	
        			<label for="usuario">INGRESE USUARIO AUTORIZADO:</label>
        			<input class="form-control" name="usuario" required type="text" id="usuario" placeholder=" ">
        
        			 
        
        			<label for="password">INGRESE CONTRASEÑA:</label>
        			<input   class="form-control" name="password" type="password" id="password"  >
        
         
        
        	<br><br>
        			<input class="btn btn-info" type="submit" value="ACCEDER">
        			<a class="btn btn-warning" href="./login2.php">CANCELAR</a>
        			
        		</form>
        	</div>	
	       	</div>
			</div>
	</div>
<?php //include_once "pie.php" ?>
