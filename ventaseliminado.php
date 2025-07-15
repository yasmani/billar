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
<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia= $base_de_datos->query("SELECT ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_vendidos_tienda.cantidad SEPARATOR '__') AS productos FROM ventastienda INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto GROUP BY ventastienda.id ORDER BY ventastienda.id DESC;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>ELIMINAR VENTAS REALIZADAS</h1>
		<!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
		 	<form name="formulario"   action="ventaseliminado2.php"
          id="formulario" method="POST">
          <h3>buscar ventas por fecha</h3>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
         
          <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
          <input  style="color:black"  type="date" id="inicio" name="inicio"
            value="<?php   echo date("Y-m-d");?>"
            >
        <input  style="color:black" type="date" id="fin" name="fin"
            value="<?php   echo date("Y-m-d");?>">
          <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER ventas  </button>
      </form>
		<br>
		<table  name="tabla" class="table table-bordered">
			<thead style="color:white; " name="tabla" class="table table-darger">
				<tr style="background-color: #E74C3C">
					<th>NUMERO</th>
					<th>FECHA</th>
					<th>PRODUCTOS VENDIDOS</th>
					<th>TOTAL</th>
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php
				$totalvendido=0;
				
				foreach($ventas as $venta){ 
					// if("0"=="0"){
					if($venta->arqueo=="0"){

						?>
				<tr> 
				
					<td><?php echo $venta->orden ?></td>
					<td><?php echo $venta->fecha ?></td>
					<td>
						<table style="background-color:#28293B ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>nombre</th>
									<th>Cantidad</th>
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
								</tr>
								<?php } 
								?>
							</tbody>
						</table>
					</td>
					<td>
					<?php
					$totalvendido=$totalvendido+$venta->total;
					echo $venta->total ?></td>
					<td><a class="btn btn-danger" href="<?php echo "eliminarVentaTienda.php?id=" . $venta->id?>"><i class="fa fa-trash"></i></a></td> 
				</tr>
				<?php } 
				}
				?>
			</tbody>
		</table>
		
			<h3>TOTAL VENDIDO:

		<?php
				
				echo $totalvendido. "  Bs."  ?> 
					<!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $venta->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
					
					
	</div>
	<!---///////////////////////////////////////////////////////////////////////////////////-->

