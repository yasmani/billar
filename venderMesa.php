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
<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos where estado=1 limit 0;");
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
 
date_default_timezone_set("America/La_Paz");

$products='';
$categoria='';
  if(isset($_GET['categoria'])&&$_GET['categoria']!=''){
      $categoria=($_GET['categoria']);
      if($categoria==''){
          $categoria='3';
      }
	  
	  if($categoria=='21'){
		$sentencia1 = $base_de_datos->query("SELECT * FROM productos where precioventa2 != 0 AND condicion='0' and estado='1';");
		$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
	  }else{
		$sentencia1 = $base_de_datos->query("SELECT * FROM productos where id_categoria='$categoria' AND condicion='0' and estado='1';");
		$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
	  }
        
      
  }else{

	if($idmesa==26){

		$sentencia1 = $base_de_datos->query("SELECT * FROM productos where precioventa2 != 0 AND condicion='0' and estado='1';");
		$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
	}else{
		$sentencia1 = $base_de_datos->query("SELECT * FROM productos where id_categoria='3' AND condicion='0' and estado='1' ;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
	}
      
  }

 
?>

<?php
include_once "base_de_datos.php";
  
 

if($idmesa==26){
	$cat = $base_de_datos->query("SELECT id, nombre as categorias FROM `categorias` where id=21;");
	$categorias = $cat->fetchAll(PDO::FETCH_OBJ);

}else{

	$cat = $base_de_datos->query("SELECT id_categoria as id, lote as categorias FROM `productos` where estado=1 GROUP by lote;");
$categorias = $cat->fetchAll(PDO::FETCH_OBJ);

}
 




$sqlorden = $base_de_datos->query("SELECT orden FROM ventastienda order by id desc limit 1;");
$data_orden = $sqlorden->fetchAll(PDO::FETCH_OBJ);
 
foreach($data_orden as $ord){ 
   $orden=$ord->orden+1;
    
}
$fecha=date("d-m-Y H:i:s"); 


      //$orden=$orden>=100?($orden%100)+1:$orden;
					//$i+=1;
					?>
				
				<div class="col-lg-12">
						 <input type='hidden' id="orden" value="<?php echo $orden?>"/>
	 <input type='hidden' id="fecha" value="<?php echo $fecha?>"/>
	 <h1>
	     
	     <?php 
	     if($idmesa==19){
	         echo 'BARRA IZQUIERDA';
	     }elseif($idmesa==20){
	     
	         echo 'BARRA DERECHA';
		 }elseif($idmesa==26){
			echo 'CONSUMO DEL PERSONAL';
	     }else{
	     echo 'MESA #'.$idmesa;    
	     }
	     
	     
	     ?>
					
					  
  
 
	
	     
	     </h1>
		 </div>
		
		
 <table style="color:white; background-color:#eceee0; margin-top:-10px;margin-left:-28px; width: 100%; table-layout: fixed;" border="1" class="default">
    <tr>
    <?php
    $i = 0;
    foreach ($categorias as $platos) { 
        $i++;
        echo '<th style="color:black; font-size:20px; background-color:#eceee0; padding:10px;">';
        echo '<form action="./venderMesa.php" method="GET" style="margin:0;">';
        echo '<input type="hidden" name="categoria" value="' . $platos->id . '">';
        echo '<input class="btn btn-success"   style="width:100%; 
                             background-color:#5d8951; 
                             white-space: normal; 
                             word-break: break-word; 
                             padding: 5px; 
                             font-size: 10px;" background-color:#5d8951;" type="submit" value="' . $platos->categorias . '">';
        echo '</form>';
        echo '</th>';

        // Cambiar de fila cada 8 columnas
        if ($i % 8 == 0) {
            echo '</tr><tr>';
        }
    }
    ?>
    </tr>
</table>


		
		
	 
	</br>
	 		 
			 
 
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
		<div style="display:none;"  class="col-xs-3"  >
		<form method="post" action="agregarAlCarrito2.php">
			<label for="codigo">BUSCAR POR CODIGO  :</label>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
		</form> 
		</div >
		<div style="display:none" class="col-md-5">
				<label for="buscar">BUSCAR :</label>
				<input autofocus class="form-control" type="text" name="caja_busqueda_venta" id="caja_busqueda_ventaTienda"></input>
				<div id="datos_venta"></div>
		</div>
  
          <br>
	<div class="col-xs-8" style='margin-left:-70px'>
			<table class="table table-bordered ">
		
				<?php 
				$i=0;
				foreach($products as $product){ 
					$i+=1;
					?>
				
					<th  >
					 <?php //echo  "<img src='files/articulos/".$product->imagen."' height='70px' width='70px' >" ?> 
					 <?php // echo $product->precioVenta ?>
					 
					 
					 <form  style='margin-left:20px' method='post' action='agregarAlCarritoMesa.php?categoria=<?php echo $categoria?>'>
						 
						 <input id="id"  name='id' type='hidden'  value="<?php echo $product->id?>" >
						 <input  id="usuario" name='usuario' type='hidden'  value="<?php echo $_COOKIE["id"]?>" >
						 <input  id="idmesa" name='idmesa' type='hidden'  value="<?php echo $idmesa?>" >
						  <input  id="categoria_y" name='categoria_y' type='hidden'  value="<?php echo $product->id_categoria?>" >
						 
							 		<?php
									if($idmesa==26){
										$precio_exacto=$product->precioVenta2;
									
									}else{
										$precio_exacto=$product->precioVenta;

									} ?>
								 
								 <input name='precio'   style='color:black;width:60px' type='hidden' value="<?php echo $precio_exacto?>">
								</div>
								
									<?php 
									$contenido = '';

									if ($product->imagen !== '') {
										$contenido .= "<img src='files/articulos/{$product->imagen}' height='120px' width='100px'><br>";
									} else {
										$contenido .= "<img src='files/articulos/nulo.jpg' height='120px' width='100px' title='SIN IMAGEN'><br>";
									}

									$contenido .= "<div style='font-weight:bold'>{$product->tienda}</div>";
									$contenido .= "{$product->nombre} " . number_format($precio_exacto, 1, ',', ' ') . "bs";
									?>

									<?php if ($product->precioVenta3 > 0): ?>
										<a id="pedido_especial"
										data="<?php echo $product->id ?>"
										href="#"
										data-toggle="modal"
										data-target="#seleccion"
										style="display:inline-block;width:120px;border-radius:10px;background-color:green;color:white;font-size:12px;padding:5px;text-align:center;text-decoration:none;">
											<?php echo $contenido; ?>
										</a>
									<?php else: ?>
										<button type="submit"
												style="display:inline-block;width:120px;border-radius:10px;background-color:green;color:white;font-size:12px;padding:5px;text-align:center;">
											<?php echo $contenido; ?>
										</button>
									<?php endif; ?>
								   
					<input   autocomplete="off" style='font-size:20px;color:black;width:220px' value='1' type='hidden' name='cantidad' id="cantidad">
                       </form>
					
					
					
				 
					
				</th>
				<?php
				if($i%3==0){
					echo '<tr></tr>';
				}
			 } ?>
   <tr></tr>
     </table>
 
	</div>
		 
 
 
	<div class="col-xs-4" style='margin-left:50px'  style="border: 1px; border-color:black;">
 <br>
	
 

		<center><h4>CARRITO</h4> <center>
		<br>
		<table style="color:white;margin-top:-20px;" name="tabla" class="table table-bordered" >
		    
			<thead style="color:white; border: 1px; border-color:black;" name="tabla" class="table table-darger">
				<tr style="background-color: #3e98af;">
				<th  > </th>  
				  <th style='width:110px' >TIEMPO BILLAR 
			 		 <a class="btn btn-danger" 
					 href="<?php echo 'venderMesa.php' ?>" 
   						target="_blank">
					 NUEVA VENTA</a>

				  </th> 
					<th style=' ' >NOMBRE</th>
				 
				 
					<th style="display:none" >PRECIO</th>
					<th style="display:none">CANTIDAD</th>
					<!-- <th>DESCUENTO</th> -->
					<th>TOTAL</th>					
					<th>QUITAR</th>
				</tr>
			</thead>
			<tbody>
				<?php 
 
				$cantidad_de_productos=0;
				$numero=0;

				$idUsuario=$_COOKIE["id"];
				
				
				$sentencia = $base_de_datos->query("SELECT productos.tienda, productos.id as idproducto ,  productos.lote,carrito.idproducto, productos.id as billar, carrito.precio, carrito.titulo,carrito.fechaInicio,carrito.fechaFin,productos.precioVenta, carrito.id,productos.nombre,carrito.cantidad,carrito.usuario,carrito.idmesa,productos.imagen ,carrito.cantidad*carrito.precio as total FROM `carrito`,productos WHERE productos.id=carrito.idproducto and carrito.idmesa='$idmesa' ;");
				// if($tipo=='ambulante'){
				    
				// $sentencia = $base_de_datos->query("SELECT productos.id as idproducto ,productos.lote,carrito.idproducto,productos.id as billar, carrito.precio, carrito.fechaInicio,carrito.fechaFin,productos.precioVenta, carrito.id ,productos.nombre,carrito.cantidad,carrito.usuario,carrito.idmesa,productos.imagen ,carrito.cantidad*carrito.precio as total FROM `carrito`,productos WHERE productos.id=carrito.idproducto and carrito.idmesa='$idmesa' ;");
				// }
				$aperturados = $sentencia->fetchAll(PDO::FETCH_OBJ);
				 
					foreach($aperturados as $producto){ 
				    $numero++;
					
						$cantidad_de_productos+=$producto->cantidad;
					?>
				<tr>
				   
				    <?php 
				    $can=0;
				if($producto->lote!=='BILLAR' ){
				    $can=$producto->cantidad;
				    $esconder='display:none';
				    $esconderreducir='display:none';
				    
				    if($producto->tienda>0){
				    $esconder="";    
				    }
				    if($producto->cantidad>1){
				    $esconderreducir="";    
				    }
				    ?>
				     <td> 
				     
					 <?php

					 
								?>
				        <form  style="<?php echo $esconder  ?>"   action="./aumentar.php?categoria=<?php echo $categoria ?>" method="post">
					  <input style="color:black;background-color:white" name="id" value="<?php echo $producto->id?>" type="hidden">
					  <input style="color:black;background-color:white" name="descontar" value="1" type="hidden">
					  <input style="color:black;background-color:white" name="idproducto" value="<?php echo $producto->idproducto?>" type="hidden">
					  <!--<input name="indice" value="<?php echo $indice?>" type="hidden">-->
					<input style="color:white; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad+1 ?>" type="hidden"   >
					
					<button class="btn btn-success" type="submit"  > <i  class="  fa fa-plus "> </i></button>
					</form>
					
					<form  style="<?php echo $esconderreducir  ?>"   action="./reducir.php?categoria=<?php echo $categoria ?>" method="post">
					<input style="color:black" name="id" value="<?php echo $producto->id?>" type="hidden">
					<!--<input name="indice" value="<?php echo $indice?>" type="hidden">-->
					<input style="color:black;background-color:white" name="descontar" value="1" type="hidden">
					<input style="color:black;background-color:white" name="idproducto" value="<?php echo $producto->idproducto?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad-1 ?>" type="hidden"   >
					
					<button class="btn btn-danger" type="submit"  >   <i  class="  fa fa-minus "> </i></button>
					</form>
					
					<?php  ?>
				    </td>
				    
				    <?php 
				} 
				    else if ($producto->lote=='BILLAR' && is_null($producto->fechaFin) ) {
				    ?>
				      <td> 
						<?php
						if($tipo=='cajero' || $tipo=='ambulante'){?>
				        <form style='color:black' action="./aumentar2.php" method="post" >
					  <input style="color:black;background-color:white" name="id" value="<?php echo $producto->id?>" type="hidden">
					 
					  <?php
				
                        $date_future= strtotime('+1 hour +10 second', strtotime( $producto->fechaInicio));
                        // $date_future= strtotime('+1 Minute', strtotime( $date_future));
                        $date_future = date('Y-m-d H:i:s', $date_future);
                             $date_future2= strtotime('-1 hour - 10 second', strtotime( $producto->fechaInicio));
                        $date_future2 = date('Y-m-d H:i:s', $date_future2);
                        // echo $date_future;


					  ?>
					
					<input style="color:black;  height: 30px" name="fechaInicio" id="cantidad" value="<?php echo $date_future ?>" type="hidden"   >
					
					<button class="btn btn-info" type="submit"  > <i  class="  fa fa-minus "></i></button>
					
					</form>
					<form   style='display;none'  action="./aumentar2.php" method="post">
					<input style="color:black" name="id" value="<?php echo $producto->id?>" type="hidden">
					
					
					<input style="color:black;  height: 30px" name="fechaInicio" value="<?php echo $date_future2 ?>" type="hidden"   >
					
					<button class="btn btn-warning" type="submit"  > <i  class="  fa fa-plus "></i></button>
					</form>
						<form   style='display:none'  action="./aumentart.php" method="post">
					<input style="color:black" name="id" value="<?php echo $producto->id?>" type="hidden">
					
					<input style="color:black; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad-1 ?>" type="hidden"   >
					
					<button class="btn btn-success" type="submit"  > <i  class="  fa fa-plus "></i></button>
					</form> 
							<?php }else{
						$dato=$producto->id;
							$sqlBloqueo = $base_de_datos->prepare("SELECT estado FROM pausas_billar WHERE id_carrito = ? and estado=1 LIMIT 1;");
							$sqlBloqueo->execute([$dato]);
							$resultado = $sqlBloqueo->fetch(PDO::FETCH_OBJ);

							if (!$resultado) { ?>

					    <form style='color:black' action="./pausar.php" method="post" >
					  <input style="color:black;background-color:white" name="id" value="<?php echo $producto->id?>" type="hidden">

					
					
					<button class="btn btn-warning" type="submit" title="Pausar tiempo">
					<i class="fa fa-pause">&nbsp;&nbsp; Pausar &nbsp;&nbsp;</i> 
					</button>
					
					</form>
					<?php }else{ ?>

					<form  action="./reanudar.php" method="post">
					<input style="color:black" name="id" value="<?php echo $producto->id?>" type="hidden">
					
					
				
					
					<button class="btn btn-success" type="submit">
						<i class="fa fa-play"></i> Reanudar
						</button>
					</form>
					
					<?php } } ?>

				    </td>
				    <?php 
				    
				}else{
				?>
				<td></td>
				<?php
				} 
				    
			 
				    ?>
					 <td style='color:black;font-size:20px'>
					 
					 <?php  
				 
                                
                               //  echo $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
$fecha22=date("Y-m-d H:i:s");
 $date1 = new DateTime($producto->fechaInicio);
$date2 = new DateTime($fecha22);
$diff = $date1->diff($date2);
// will output 2 days
$b=true;
if($producto->lote=='BILLAR' ){
	
	if(is_null($producto->fechaFin)){
	$b=false;
	//	echo '    '.$diff->h . ' '.$diff->i . '  ';    
// 		echo '    '.$diff->i . ' m ';  
		?>
	 <p style="font-size:15px">incio: <?php echo  date("H:i ", strtotime($producto->fechaInicio))   ?></p>


	 <?php
	/* if($tipo=='cajero' || $tipo=='ambulante'){
	 $sqlpausas = $base_de_datos->query("SELECT * from pausas_billar where id_carrito='$producto->id'");
		$pausas = $sqlpausas->fetchAll(PDO::FETCH_OBJ);
	 
		foreach($pausas as $pausa){ ?>
			
			<p style="font-size:15px">Pausa: <?php echo  date("H:i ", strtotime($pausa->inicio))   ?></p>
			<?php
			if($pausa->fin){ ?>
				<p style="font-size:15px">Reanuda: <?php echo  date("H:i ", strtotime($pausa->fin))   ?></p>
			
			<?php
			}
	
		}
	}*/
	 ?>
	 	
	 <?php
		
	}else{

		if($tipo=='cajero' || $tipo=='ambulante'){
	    $DD=0;
		$ini = new DateTime($producto->fechaInicio);
$d = new DateTime($producto->fechaFin);
$diferencia = $ini->diff($d);
		echo '    '.$diferencia->h . 'h   ';    
		echo '    '.$diferencia->i . ' m '; 
		

				         $DD += ( number_format((($diff->i*($producto->precioVenta/60)+$diff->h*$producto->precioVenta)), 0, '.', ' '));
		
	?>
	<p> <?php echo  date("H:i a", strtotime($producto->fechaInicio))." " .date("H:i a", strtotime($producto->fechaFin)) ?></p>
	
	 
			<?php /*$dato=$producto->id;
							$sqlBloqueo = $base_de_datos->prepare("SELECT bloqueo FROM carrito WHERE id = ? LIMIT 1;");
							$sqlBloqueo->execute([$dato]);
							$resultado = $sqlBloqueo->fetch(PDO::FETCH_OBJ);*/

		}else{

			
							

							$DD = 0;
							$ini = new DateTime($producto->fechaInicio);
							$fin = new DateTime($producto->fechaFin);

							echo 'Inicio:'.date("H:i a", strtotime($producto->fechaInicio)).'</br>';
							echo 'Fin:'.date("H:i a", strtotime($producto->fechaFin)).'</br>';
							echo 'Tiempo:';
							// 1. Calcular diferencia total (sin pausa)
							$diferencia = $ini->diff($fin);
							echo ' ' . $diferencia->h . 'h ';
							echo ' ' . $diferencia->i . ' m ';

							// 2. Consultar pausas de ese carrito
							$sqlPausas = $base_de_datos->prepare("SELECT inicio, fin FROM pausas_billar WHERE id_carrito = ?");
							$sqlPausas->execute([$producto->id]);
							$pausas = $sqlPausas->fetchAll(PDO::FETCH_OBJ);

							// 3. Restar duración total de las pausas
							$minutosEnPausa = 0;

							foreach ($pausas as $pausa) {
								$pInicio = new DateTime($pausa->inicio);

								// Si el campo 'fin' está vacío o es NULL, usamos $producto->fechaFin
								if (empty($pausa->fin) || $pausa->fin == '0000-00-00 00:00:00') {
									$pFin = new DateTime($producto->fechaFin);
								} else {
									$pFin = new DateTime($pausa->fin);
								}

								$diffPausa = $pInicio->diff($pFin);
								$minutosEnPausa += ($diffPausa->h * 60) + $diffPausa->i;
							}

							// 4. Calcular duración total en minutos
							$duracionTotal = ($diferencia->h * 60) + $diferencia->i;

							// 5. Restar pausas
							$minutosTrabajados = max($duracionTotal - $minutosEnPausa, 0);

							// 6. Calcular monto
							$monto = $minutosTrabajados * ($producto->precio / 60);
							$DD += number_format($monto, 0, '.', ' ');
							?>				
							<p>Tiempo real: <?php echo floor($minutosTrabajados / 60) . "h " . ($minutosTrabajados % 60) . "m"; ?></p>
							<p><strong>Total a cobrar: <?php echo $DD; ?> Bs</strong></p>

						
							<?php }
									?>
					
		<form     action="./detenerTiempo2.php" method="post">

					<input style="color:black; width:60px; height: 30px" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="monto"  step='any' type="number">
					<input style="color:black; width:60px; height: 30px" name="inicio" value="<?php echo $producto->fechaInicio ?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="indice" value="<?php echo $indice?>" type="hidden">
			 
					<a href="#"  data-toggle="modal" data-target="#resultadoModal" title="Calcular"><img src="./files/articulos/fotos/calculadora.png" width="25px" height="25px"></a>
					</br></br>
					<center>
					<button   class="btn btn-success" type="submit" value="actualizar">   MONTO BS  </button></center>
					
					</form>
 
 	<?php
		
	
	}

        
    }
	 	
		
					 ?>
					 
					<form  style='display:none'  action="./aumentarCantidadTienda2.php" method="post"  >
					  <input style="color:black;background-color:white" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					  <input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:white; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad+1 ?>" type="hidden"   >
					
					<button class="btn btn-info" type="submit"  > <i  class="  fa fa-plus "></i></button>
					</form>
					<form  style='display:none' action="./aumentarCantidadTienda2.php" method="post">
					<input style="color:black" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input name="indice" value="<?php echo $indice?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="cantidad" id="cantidad" value="<?php echo $producto->cantidad-1 ?>" type="hidden"   >
					
					<button class="btn btn-warning" type="submit"  > <i  class="  fa fa-minus "></i></button>
					</form>
					 
					
					 </td>

                       
                       
					<td style="background-color:white;color:black"  > 
						<?php 
									if($producto->imagen !==''){
										echo  "<img src='files/articulos/".$producto->imagen."' height='40px' width='60px' >"
										?>
											
									
									<?php
										}else{
											?>
											<img src='files/articulos/nulo.jpg' height='40px' width='60px' title="SIN IMAGEN" >
										
										<?php }
									 ?>	
					
					
					<input type='hidden' id='n<?php echo $indice   ?>' value='<?php echo $producto->titulo  ?>' >  </input>  <?php echo $producto->titulo   ?>
					
					 
					
						<input type="hidden"  id='c<?php echo $indice   ?>' value='<?php echo $producto->cantidad  ?>' >  </input>
						<input type='hidden'  id='t<?php echo $indice   ?>' value='<?php echo ($producto->total) ?>' >  </input>
					
					</td>
				 
				 

					<td  style="display:none">
					<form action="./aumentarPrecioTienda.php" method="post">
					<input style="color:black; width:60px; height: 30px" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="indice" value="<?php echo $indice?>" type="hidden">
					<input disabled style="color:black; width:60px;background-color:white; height: 30px" name="precio" id="precio" value="<?php echo $producto->precioVenta ?>" type="text"   >
					
					<button style="display:none" class="btn btn-success" type="submit" value="actualizar"> <i  class="  fa fa-recycle "></i></button>
					</form>
				</td>
					 
										 
					<td style='color:black'>
					<?php 
				//	echo 'id'.$producto->id;
				// 	if()
				
					if($producto->lote=='BILLAR' && is_null($producto->fechaFin) ){
				        echo number_format((($diff->i*($producto->precioVenta/60)+$diff->h*$producto->precioVenta)), 0, ',', ' ')." bs";
				        $granTotal += ( number_format((($diff->i*($producto->precioVenta/60)+$diff->h*$producto->precioVenta)), 0, '.', ' '));
				         

						  
						 
						 ?>
				         
				         	<form action="./detenerTiempo.php" method="post">
					<input style="color:black; width:60px; height: 30px" name="codigo" value="<?php echo $producto->id?>" type="hidden">
					<input style="color:black; width:60px; height: 30px" name="monto" value="<?php echo number_format((($diff->i*($producto->precioVenta/60)+$diff->h*$producto->precioVenta)), 0, '.', ' ')?>" type="hidden">
				
					<input style="color:black; width:60px; height: 30px" name="indice" value="<?php echo $indice?>" type="hidden">
			 
					
					<button   class="btn btn-success" type="submit" value="actualizar" 
						onclick="setTimeout(() => location.reload(), 500);">   FINALIZAR  </button>
					</form>
					
					<?php
					}else{
					    
					    	if($producto->lote=='BILLAR' ){
					    	    
					           $granTotal += $producto->precio ;
					    	   // number_format((($diff->i*0.2833+$diff->h*17)), 2, ',', ' ');
					            echo number_format(($producto->precio/$producto->precioVenta), 0, ',', ' ')."X".number_format($producto->precioVenta, 0, ',', ' ')."=".number_format(($producto->precio*$producto->cantidad), 0, ',', ' ')."bs"  ;
							  
					    	}else{
					    	    
					     $granTotal += $producto->precio*$producto->cantidad;
					    	    echo '<p style="font-size:18px">'.number_format( $producto->cantidad, 0, ',', ' ')."X".number_format( $producto->precio, 0, ',', ' ').'='.number_format( ($producto->precio*$producto->cantidad), 0, ',', ' ')."bs</p>"  ;
					    	}
 
				}
					
					?>
					</td>

                        <?php 
						
                        if($tipo=='cajero' || $tipo=='ambulante'){
							
							
                        ?>
					<td>
						<a  class="btn btn-danger" href="<?php echo "detener.php?id=" . $producto->id."&cantidad=".
						$producto->cantidad."&idproducto=".$producto->billar."&categoria=".$categoria?>"><i class="fa fa-trash"></i></a>
                        
						 
					</td>
					<?php
                     
					}
                        ?>

				</tr>

				<?php } ?>  
				<input type='hidden' id='idplatos' type="number" style='color:white'  value="<?php echo $numero?>">
				
			</tbody>
		</table>
		
		<!-- <h3  style="font-size:40px;display:none">subt÷otal: <?php //echo $granTotal.' Bs.'; ?></h3>  -->
		<a class="btn btn-info" 
		href="<?php echo 'imprimir_tienda22.php?total=' . $granTotal . '&mesa=' . $idmesa; ?>" 
		target="_blank"
		onclick="setTimeout(() => location.reload(), 500);">
		<i class="fa fa-print"></i> CUENTA
		</a>

		<form action="./terminarVentaMesa.php" method="POST">
		<input     style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="nombre_de_usuario"  id="nombre_de_usuario" value="<?php echo $_COOKIE["usuario"]?>">
		<input    style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="idUsuario"  id="idUsuario" value="<?php echo $id?>">
		<input    style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="idmesa"   value="<?php echo $idmesa?>">
		<label style="font-size: 50px;color:red" for="">   TOTAL <?php echo number_format(($granTotal), 0, ',', ' '); ?> bs </label>
		<input style="display:none;font-size:20px;color:black;width:100px;background-color:white" disabled id="montito" type="text" value="<?php echo $granTotal; ?>"> 
		<br>
		<label style="font-size: 12px" for="">cantidad <?php echo $cantidad_de_productos ?></label>
		
		<input style="display:none" id="total" type="text" value="<?php echo $granTotal; ?>">
	 <!--<br>-->
			<!--<label  for="">Descuento:</label>-->
			<input value="0" id="descuento" value="0" style=" color:black;font-size:20px;width:100px" name="descuento" type="hidden">
			 <!--<br>-->
			 <br>
		<label  for="">QR:</label>
 			<input value="0" id="transferencia"  required style="color:black;font-size:20px; align-content:right;width:100px" name="transferencia" type="number">
		 <br>
			<!--<label  for="">DEBE:</label>-->
			<input value="0" id="tarjeta"    style="margin-left: 10px; color:black;font-size:20px;width:150px" name="tarjeta" type="hidden">
			<br>
			<br>
			<table width="100%">
				<tr>
					<td>
						EFECTIVO	
					</td>
					<td>
							<input value="0" class="form-control"  style="background-color:hsl(20, 5.80%, 79.60%);font-size:20px;width:120px; margin-left: 2px; " name="Thing" id="Thing" type="text">
					</td>
				</tr>
				<tr>
						<td>
							CAMBIO
						</td>
						<td>
							<input  value="0" class="form-control" style=" background-color:hsl(20, 2.50%, 76.30%);font-size:20px;width:120px;margin-left: 2px; margin-top: 10px;"  type="text" name="devolver"  id="devolver" value="">
						</td>
				</tr>

			</table>
			     
			
			
			
			
			<br>
		 
			<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		 <div style="color:black" class="col-lg-12">
			 
				<center><button  style="color:black" type="button" class="btn btn-info btn-sx" data-toggle="modal" data-target="#myModal2">NUEVO </button></center>
  
			
			
			
			
			


			  <div  >
					<label style="color:white" for="cliente">cliente</label>
					<br>
				<select    required name="cliente" class="form-control selectpicker"  data-live-search="true">
				         
					<?php 
					 
					foreach($listaclientes as $cliente){ 
					     
                    echo '<option selected  value="'.$cliente->id.'" > '.$cliente->nombre.'-'.$cliente->telefono.'</option>';
					}
					?>
			   </select> 
			   </div>
				<script>
					$(function() {
				$('.selectpicker').selectpicker();
				});
				</script>
		    </div> 
		
			<div  style='display:none'   class="col-lg-12">
				<label for="">ENTREGA</label>
			  <select id='tipoEntrega' required name="entrega" class="form-control selectpicker"  data-live-search="true">
			    <option   value="1" > PARA MESA </option>
			    <option   value="2" > PARA LLEVAR </option>
			     </select>
		    </div> 
		    <div style='display:none'   class="col-lg-12">
				<!--<label for="">tipo de salida</label>-->
				 
				<select style="color:black" name="tipoDeVenta" class="form-control selectpicker">
					<option selected  style="color:black"value="1"> CONTADO</option>
					<!--<option style="color:black" value="2" >CREDITO</option>-->
				</select>
				<input name="total" type="hidden" value="<?php echo $granTotal;?>">
		    </div> 
			 
			<br>
			<br>
			 
			<label style="display:none" for="">  NOTA</label>
			<br>
			<input id='nota' style="margin-left: 14px; color:black;font-size:20px;width:100%" name="detalle" type="hidden"> </br>
			<?php 	 
						if($existe!=null && $granTotal>0 && $b==true){
							echo ' </br>
										<button id="btnImprimir" style="   type="submit" class="btn btn-primary"  >COBRAR</button>
										
										
										
										<a style="display:none;" href="./cancelarVenta.php" class="btn btn-danger">CANCELAR VENTA</a>
										 ';
						}else{
						}
					?>	
			
		</form>
					</br>
					</br>
	</div>
	 
       

	<!-- Modal CALCULADORA -->
<div class="modal fade" id="resultadoModal" tabindex="-1" role="dialog" aria-labelledby="resultadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    
      <div class="modal-header bg-primary text-white">
        <center><h5 class="modal-title" id="resultadoModalLabel">Calcular Tarifa</h5></center>

      </div>
      
      <div class="modal-body">
  
						
          <div class="form-group">
            <label for="tarifa">Tarifa por hora (Bs):</label>
            <input type="number" class="form-control" id="tarifa" required>
          </div>

          <div class="form-group">
            <label for="inicio">Hora inicio:</label>
            <input type="time" class="form-control" id="inicio" required>
          </div>

          <div class="form-group">
            <label for="fin">Hora fin:</label>
            <input type="time" class="form-control" id="fin" required>
          </div>

          <center><button type="button" class="btn btn-success" onclick="calcularTarifa()">Calcular</button></center>
        

        <hr>
        <p><strong>Resultado:</strong> <strong id="resultado"></strong></p>
      

      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      
    </div>
  </div>
</div>





<!-- Modal SELECCION -->
<div class="modal fade" id="seleccion" tabindex="-1" role="dialog" aaria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    
      <div class="modal-header" style="background-color: rgba(12, 87, 41, 1);color: #ffffff;">
        <center><h5 class="modal-title" id="resultadoModalLabel">Selecciona una opcion</h5></center>

      </div>
      
      <div class="modal-body" id="body_seleccion">
   
						
         
      

      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      
    </div>
  </div>
</div>



<script>
 document.getElementsByName("Thing")[0].addEventListener('change', doThing);
document.getElementById("montito").value;

function doThing(){
	var s=parseFloat($("#tarjeta").val())+parseFloat($("#transferencia").val());
		document.getElementById('devolver').value =parseFloat( this.value)+parseFloat(s) - parseFloat(document.getElementById("montito").value - parseFloat(document.getElementById("descuento").value)) ;
}
function SUMA(){
  var X=0;
  var total=0;
  X = $("#recibido").val();
  total = $("#total_venta").val();
  document.getElementById('spTotal').innerHTML = X-$granTotal;
  // document.getElementByName("cambio").innerHTML = x;
} 
function actualizar_cantidad(){
var dato = $('#cantidad').val();
    $.ajax({
       data: {"dato" : dato},
       url: "vender.php",
       type: "post",
     });
}



function calcularTarifa(){
   const tarifa = parseFloat(document.getElementById("tarifa").value);
    const inicio = document.getElementById("inicio").value;
    const fin = document.getElementById("fin").value;

    if (!tarifa || !inicio || !fin) {
        document.getElementById("resultado").textContent = "Todos los campos son obligatorios.";
        return;
    }

    const inicioDate = new Date("2024-01-01T" + inicio + ":00");
    const finDate = new Date("2024-01-01T" + fin + ":00");

    let diffMs = finDate - inicioDate;
    if (diffMs < 0) {
        document.getElementById("resultado").textContent = "La hora de fin debe ser posterior a la de inicio.";
        return;
    }

    const diffMin = diffMs / 60000; // Total minutos
    const horas = Math.floor(diffMin / 60);
    const minutos = Math.round(diffMin % 60);
    const horasDecimales = diffMin / 60;

    const total = tarifa * horasDecimales;

    document.getElementById("resultado").textContent = `Duración: ${horas}h ${minutos}min — Total: Bs ${total.toFixed(2)}`;
}

 
   
	
     $(document).on("click", "#pedido_especial", function () {

             let valor =  $(this).attr("data");
			var cantidad = $("#cantidad").val();
			var usuario = $("#usuario").val();
			var idmesa = $("#idmesa").val();
			var categoria = $("#categoria_y").val();
		


    

			 
          return $.ajax({
                      url: 'modelos/model_productos.php',
                      type: 'POST',
                      data: {
                          accion: 'modal_seleccion',
                          codigo: valor,
						  cantidad: cantidad,
						  usuario:usuario,
						  idmesa:idmesa,
						  categoria:categoria
                      },
                      success: function(respuesta) { 
						
                            
                         $("#body_seleccion").html(respuesta);
                        
                          $('#seleccion').modal('show');
             
              
                      }
                  });
                            

});

       
</script>



