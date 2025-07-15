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
if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
$granTotal = 0;
?>
 <script src="./ConectorJavaScript.js" type="text/javascript"></script>
<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos limit 0;");
$listaclientes = $base_de_datos->query("SELECT * FROM cliente order by id desc;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ); 

$cantidad=-1;
$descuento=0;
$sentencia = $base_de_datos->query("SELECT * FROM apertura_tienda where estado='0';");
$aperturados = $sentencia->fetchAll(PDO::FETCH_OBJ);
$existe=null;
	foreach($aperturados as $producto){ 
	$existe++;
}
?>
<?php
$products='';
$categoria='';
  if(isset($_GET['categoria'])){
      $categoria=($_GET['categoria']);
      if($categoria==''){
          $categoria='PROMOCIONES';
      }
        
      $sentencia1 = $base_de_datos->query("SELECT * FROM productos where lote='$categoria' AND condicion='0' and estado='1' ;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
  }else{
      $sentencia1 = $base_de_datos->query("SELECT * FROM productos where lote='PROMOCIONES' AND condicion='0' and estado='1' ;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
  }

 
?>

<?php
  
 
 
$cat = $base_de_datos->query("SELECT lote as categorias FROM `productos` where estado='1' GROUP by lote;");
$categorias = $cat->fetchAll(PDO::FETCH_OBJ);




$sqlorden = $base_de_datos->query("SELECT orden FROM ventastienda order by id desc limit 1;");
$data_orden = $sqlorden->fetchAll(PDO::FETCH_OBJ);
 
foreach($data_orden as $ord){ 
   $orden=$ord->orden+1;
    
}
$fecha=date("d-m-Y h:i:s"); 


      //$orden=$orden>=100?($orden%100)+1:$orden;
					//$i+=1;
					?>
				
					<th  >
					  
  
 
	 <input type='hidden' id="orden" value="<?php echo $orden?>"/>
	 <input type='hidden' id="fecha" value="<?php echo $fecha?>"/>
 <table style='color:white;background-color:#dff0cc;' border='1' class="default">
     
		    <tr>
		       
		<?php
		$i=0;
		
		 
		?>
	 
		<?php
		
		 
		?>
		</tr>
		
		</table>
		
	 
		 
	 		<div class="columns">
		 
 
		<div   class="col-xs-12"  >
<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
					<strong style="background-color:yellow; color:black" >VENTA REALIZADA EXITOSAMENTE </strong>
						<!-- <div class="alert alert-success">
							<strong>¡Correcto!</strong> Venta realizada correctamente
						</div> -->
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-info">
							<strong>Venta cancelada</strong>
						</div>
					<?php
				}else if($_GET["status"] === "3"){
					?>
					<!-- <div class="alert alert-info"> -->
							<!-- <strong>Ok</strong> Producto quitado de la lista -->
					 
					<?php
				}else if($_GET["status"] === "4"){
					?>
					<div class="alert alert-warning">
							<strong>Error:</strong> El producto que buscas no existe
						</div>
					<?php
				}else if($_GET["status"] === "cantidadsuperada"){
					?>
					<div class="alert alert-warning">
							<strong>Error:</strong> cantidad superada
						</div>
					<?php
				}else if($_GET["status"] === "5"){
					?>
					<!-- <div class="alert alert-danger"> -->
							<strong style="background-color:yellow; color:black" >Error:El producto está agotado </strong>
					 
					<?php
				}else if($_GET["status"] === "6"){
					?>
					<div class="alert alert-danger">
							<strong>Error: </strong>precio fuera de rango
						</div>
					<?php
				}else if($_GET["status"] === "7"){
					?>
					<div class="alert alert-success">
							<strong>OK: </strong>precio modificado 
						</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> Algo salió mal mientras se realizaba la venta
						</div>
					<?php
				}
			}
		?>
		</div>
		<div   class="col-xs-3"  >
		 
		</div >
		<div  class="col-md-5">
			 
		</div>
  
          
	<div class="col-xs-12" style='margin-left:-70px'>
			<table class="table table-bordered ">
		
				<?php 
				$i=0;
				$mesas = $base_de_datos->query("SELECT * from mesa limit 26 ");
		$lista_mesas = $mesas->fetchAll(PDO::FETCH_OBJ);
		
		
				foreach($lista_mesas as $product){ 
					$i+=1;


					$idUsuario=$_COOKIE["id"];
					$sentencia = $base_de_datos->query("SELECT productos.lote, carrito.fechaInicio,carrito.fechaFin,carrito.idproducto,productos.id,productos.precioVenta, carrito.id,productos.nombre,carrito.titulo,carrito.cantidad,carrito.usuario,carrito.idmesa,productos.imagen ,carrito.cantidad*carrito.precio as total FROM `carrito`,productos WHERE productos.id=carrito.idproducto and carrito.idmesa='$product->id' ;");
					if($tipo=='ambulante'){
					    $sentencia = $base_de_datos->query("SELECT productos.lote,carrito.idproducto,  productos.precioVenta,carrito.fechaFin, carrito.id,productos.nombre,carrito.titulo,carrito.cantidad,carrito.fechaInicio,carrito.usuario,carrito.idmesa,productos.imagen ,carrito.cantidad*carrito.precio as total FROM `carrito`,productos WHERE productos.id=carrito.idproducto and carrito.idmesa='$product->id'  ;");
					    
					    
					}
				
				
				$aperturados = $sentencia->fetchAll(PDO::FETCH_OBJ);
				$total=0;
				$granTotal=0;
					foreach($aperturados as $producto){ 
					$fecha22=date("Y-m-d H:i:s");
                     $date1 = new DateTime($producto->fechaInicio);
                    $date2 = new DateTime($fecha22);
                    $diff = $date1->diff($date2);
						$total += $producto->total;
						 
				if($producto->lote=='BILLAR' &&  is_null($producto->fechaFin) ){
				        // echo number_format((($diff->i*0.2711+$diff->h*16)), 2, ',', ' ');
				        $granTotal += ( number_format((($diff->i*($producto->precioVenta/60)+$diff->h*$producto->precioVenta)), 2, '.', ' '));
                             //   echo
				        //  	$granTotal +=  number_format((($diff->i*0.3+$diff->h*18)), 0, '.', ' ');
				         	 $total+=$granTotal; 
					}
				       	 
					}
						
					?>
				
					<th  >
				
					 
					 
					 <form method='post' action='agregar_mesa.php '>
						 
						 <input name='id' type='hidden'  value="<?php echo $product->id?>" >
						 <input name='idusuario' type='hidden'  value="<?php echo $_COOKIE["id"]?>" >
						 <div class='col col-lg-6'>
							 
							 </div>
							 <div class='col col-lg-12'>
								</div>
								<div  class='col col-lg-12'>
									
									<?php
									$color="#02b735"; 
									if ($product){
										// $color="green"; 

									}
									if($total>0){
										$color="red";
									}
									
									if($product->mesa == 26){
										$label = "CONSUMO DEL PERSONAL ";
									} else {
										$label = "MESA #" . $product->mesa;
									}

									echo "<center>
											<p style='background-color:{$color};color:white;margin-bottom:-10px'>
												{$label} 
												<a style='display:none;color:yellow'>" . ($total > 0 ? $total . 'bs' : '') . "</a>
											</p>
										</center>";
									?>
									 
									 <button class="form-control" style='margin-bottom:10px;border-color:<?php echo $color?>;height:140px;width:260px;border-radius:10px;background-color:<?php echo  $color ?>;color:black;font-size:17px' type="submit">
									     
 											<?php 
 											
 												if($product->id==11||$product->id==12||$product->id==13){
 											    echo  "<img src='files/mesa/cd.jpg' height='120px' width='220px' >" ;
                                                } elseif ($product->id==1||$product->id==2||$product->id==3||$product->id==4||$product->id==5||$product->id==6||$product->id==7||$product->id==8||$product->id==9||$product->id==10) {
                                                      echo  "<img src='files/mesa/mesa.png' height='120px' width='230px' >" ;
                                                } elseif ($product->id==14  ) {
													echo  "<img  src='files/mesa/mesa22.jpg' height='120px' width='240px' >" ;
                                                } elseif ( $product->id==15 ) {
													echo  "<img  src='files/mesa/mesa3.jpg' height='120px' width='240px' >" ;
                                                } elseif ( $product->id==15 ) {
													echo  "<img  src='files/mesa/loba.jpg' height='120px' width='240px' >" ;
												} elseif ( $product->id==26 ) {
													echo  "<img  src='files/mesa/cajera.jpg' height='120px' width='240px' >" ;
													} else {
														echo  "<img src='files/mesa/mesaconsumo.jpg' height='120px' width='230px' >" ;
                                                }
 											
 											// if($product->id==9||$product->id==10){
 											//     echo  "<img src='files/mesa/cacho.jpg' height='120px' width='250px' >" ;
 											// }
 											
 											// else{
 											//     echo  "<img  src='../files/mesa/mesa2.jpg' height='120px' width='240px' >" ;
 											// }
 											// mesa.jpg
 											?> 
					 <?php // echo $product->precioVenta ?>
										<?php
											$nombre="libre";
											if($total>0){
												$nombre=" (".$total .").bs" ;
											}
											if($total==0){
												$nombre=" "  ;
											}
											//echo $nombre;
												?>
									 
										
									</button>
									 </form>
								 
								<?php
								if ( $product->id!=26 ) {
									?>
								<form method='get' action='traspasar.php '>
    							 <input name="actual" type="hidden" value="<?=$product->id?>"/>
    							 <input style="width:50px" name="mesa" type="number" required  />
    							 
						 
                             <button value="confirmar" type="submit">TRASPASAR</button>
                            </form>
								<?php } ?>
                     </div>
               
					
					
					 
					
				</th>
				<?php
				if($i%5==0){
					echo '<tr></tr>';
				}
			 } ?>
   <tr></tr>
     </table>
 
	</div>
		 
 
 
	 
 <br>
	
 

		
		 
		  
<?php// include_once "pie.php" ?>
