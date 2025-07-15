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


// <?php include_once "encabezado.php"  
 
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT compras.id,compras.total, compras.fecha, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_comprados.cantidad SEPARATOR '__') AS productos FROM compras INNER JOIN productos_comprados ON productos_comprados.id_compra = compras.id INNER JOIN productos ON productos.id = productos_comprados.id_producto GROUP BY compras.id ORDER BY compras.id DESC");
$compras = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>
<?php //include_once "todasLasCompras1.php" ?>
<form name="formulario" target="_blank" action="./exportar_compras_no_consolidadosxsl.php"
                      id="formulario" method="POST">
                      <!--div responsivo-->
                      <h1>REPORTES DE NO CONSOLIDADO DE  COMPRAS EN EXCEL</h1>
                           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
                           <input  style="color:black"  type="date" id="inicio" name="inicio"
                                 value="<?php echo date("Y-m-d");?>"
                                 >
                              <input  style="color:black" type="date" id="fin" name="fin"
							  value="<?php echo date("Y-m-d");?>">
                                <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER COMPRAS (excel)</button>
</form>	 
					
	</div>
<?php include_once "pie.php" ?>