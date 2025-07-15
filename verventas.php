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
		include_once "encabezado3.php"; 
	//  header("Location: ./vender.php");
 }
 ?>
<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
 

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$codigo_cliente=!isset($_GET['cliente'])?0:$_GET['cliente'];
$sentencia = $base_de_datos->query("SELECT ventastienda.nombre_de_usuario,ventastienda.cliente, ventastienda.tipoDeVenta, ventastienda.saldo,ventastienda.hora,ventastienda.nombre_de_usuario,ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT(	productos.codigo, '..',  productos.nombre, '..', productos_vendidos_tienda.cantidad , '..', productos_vendidos_tienda.descuento SEPARATOR '__') AS productos FROM ventastienda  INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto GROUP BY ventastienda.id ORDER BY ventastienda.id DESC;");
$ventastienda = $sentencia->fetchAll(PDO::FETCH_OBJ);
$listaclientes = $base_de_datos->query("SELECT * FROM cliente order by id desc;");
$id_cliente='';
$nombre_cliente='';
$cajero='';
?>

	<div style="background-color: rgba(191, 216, 185, 1);" class="col-xs-12">
		<h1>buscar ventas</h1>
		<br>
		<label  style="color:white"> ver creditos por cliente</label> 
 				<form action="verventas.php" method="get">
					 <div class="col-xl-6 col-md-5 col-sm-4">

					
				 <select  required name="cliente" class="form-control"  >
				         
						 <?php 
						  
						 foreach($listaclientes as $cliente){ 
							   if ($codigo_cliente==$cliente->id){
                                echo '<option  selected value="'.$cliente->id.'" > '.$cliente->nombre.'-'.$cliente->telefono.'</option>';
                               }else{
                                echo '<option   value="'.$cliente->id.'" > '.$cliente->nombre.'-'.$cliente->telefono.'</option>';
                               }
						 
						 }
						 ?>
					</select>
					</div>
					<input style="color:black" type="submit" value="buscar">
				 </form>
				
		<hr>
		<table style="color:white" name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
					<th>NUMERO</th>
					<th>FECHA</th>
					<th>HORA</th>
					<th>tipo </th>
					<th>Cliente</th>
					<th>VENDEDOR</th>
					<th>PRODUCTOS VENDIDOS</th>
					<th>TOTAL</th>
					<th>saldo</th>
					<th>ABONAR</th>
					<th>eliminar</th>
					<th>Imprimir productos</th>
					<th>imprimir abonos</th>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				$saldo_total=0;
				foreach($ventastienda as $venta){ 
					// if("0"=="0"){

					if(  $venta->cliente==$codigo_cliente ){
						$id_cliente=$venta->cliente;
						$sql_cliente = $base_de_datos->query("SELECT  nombre from cliente where id='$id_cliente'");
						$clientes = $base_de_datos->query("SELECT id, nombre from cliente ");
						//$sql_cliente->execute();
						$resultado_cliente = $sql_cliente->fetch(PDO::FETCH_OBJ);
						//$todos_los_clientes = $clientes->fetch(PDO::FETCH_OBJ);
						
						//$idVenta = $resultado === false ? 1 : $resultado->id;
					//	$resultado_cliente = $sql_cliente->fetchAll(PDO::FETCH_OBJ);

							$nombre_cliente=$resultado_cliente->nombre;
						//	$cajero=$resultado_cliente->nombre_de_usuario;
						?>
				<tr> 
				
					<td><?php echo $venta->orden ?></td>
					<td><?php echo date("d/m/Y", strtotime($venta->fecha)) ?></td>
					<td><?php echo  $venta->hora ?></td>
					<td>
					<form action="guardartipoventa.php" method="post">
					    <input type="hidden" name="id_cliente" value="<?php echo $codigo_cliente ?>">	
						<input name="id" value='<?php echo $venta->id?>' type="hidden">
					<?php 
					if ($venta->tipoDeVenta==1) {
						 
					echo 	'<input type="radio" name="tipo"  checked   value="1">contado </>';
					echo 	'<input type="radio" name="tipo"      value="2">credito </>';
				}else{
					echo 	'<input type="radio" name="tipo"     value="1">contado </>';
					echo 	'<input type="radio" name="tipo"   checked   value="2">credito </>';
					}
				 ?>
					<input type="submit" style="color: black;" value="actualizar">
						 
					</form>
					</td>
					
					
					<td style="color:yellow;font-size:20px" ><?php echo $nombre_cliente ?>
				
						<span style="color: white;" >cambiar </span>
						<form action="guardarcliente.php" method="get">
						 <input type="hidden" name="id_cliente" value="<?php echo $codigo_cliente ?>">			
						 <input type="hidden" name="id_venta" value="<?php echo $venta->id ?>">			
						 <select  required name="id_cliente_nuevo" class="form-control" >
						 <?php 
						 foreach($clientes as $cliente){ 
                                echo '<option style="color:black"  value="'.$cliente->id.'" > '.$cliente->nombre.'-'.$cliente->telefono.'</option>';
						 }
						 ?>
					</select> 
					<input style="color: black;" type="submit" value="cambiar">
						</form>
						<?php 
						?>
				</td>
					<td><?php echo $venta->nombre_de_usuario ;
					$cajero=$venta->nombre_de_usuario 
					?></td>
					<td>
						<table style="background-color:#28293B ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>nombre</th>
									<th>Cantidad</th>
									<th>descuento</th>
								</tr>
							</thead>
							<tbody style="background-color:#28293B ;color:white">
								<?php foreach(explode("__", $venta->productos) as $productosConcatenados){ 
									$producto = explode("..", $productosConcatenados)
									?>
								<tr>
									<td><?php echo $producto[0] ?></td>
									<td><?php echo $producto[1] ?></td>
									<td><?php echo $producto[2] ?></td>
									<td><?php echo $producto[3] ?></td>
								</tr>
								<?php } 
								?>
							</tbody>
						</table>
					</td>
					<td>
					<?php
					$totalvendido=$totalvendido+$venta->total;
					echo $venta->total;
					$error = [ 'id' => $venta->id,'cajero'=> $venta->nombre_de_usuario ];
					$error = serialize($error);
				$error = urlencode($error);
					?></td>
					<td>
						<?php 
						
						echo $venta->total-$venta->saldo;
						?>
					</td>
					<td>  
						<?php 
                        $saldo_total+=$venta->total-$venta->saldo;
						if($venta->total-$venta->saldo>0){

							echo '<form action="abonar.php" method="post">
							<input    style="margin-left: 80px; background-color: #7D7B7A;font-size:25px;width:150px"  type="hidden" name="id_usuario"  id="idUsuario" value="'.$id.'">
							<input required  name="codigo" style="color: black;" value="'.$venta->id.'" type="hidden">
							<input required name="monto" style="color:black" type="text">
							<button style="color:black" type="submit">abonar</button>						
							</form>';
						}
							
									?>
	 

					</td>
					 <td>
					     <?php 
					     if ($tipo=='administrador') {
					     ?>
					     <a class="btn btn-danger" href="<?php echo "eliminarVenta.php?id=" . $venta->id?>"><i class="fa fa-trash"></i></a>
					     <?php  }?>
					     </td>
					 <td><a class="btn btn-info" href="<?php echo "imprimir_tienda.php?ticket=".$error ?> "><i class="fa fa-print"></i></a></td>

					 <td><a class="btn btn-info" href="<?php echo "imprimir_creditostienda.php?ticket=".$error ?> "><i class="fa fa-print"></i></a></td>
				</tr>
				<?php } 
				}
				?>
			</tbody>
		</table>
		<div>   
		  
		</div>
			<h3  > saldo por cobrar:

		<?php
				
				echo $saldo_total. "  Bs."  ?> 
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	</div>
	

