<?php include_once "encabezado.php" ?>
<?php
include_once "base_de_datos.php";
require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT * FROM egresos  GROUP BY egresos.egresoid ORDER BY egresos.egresoid DESC");

$compras = $sentencia->fetchAll(PDO::FETCH_OBJ);
$sum=0;
?>

<form name="formulario" target="_blank" action="reportes/reporteegresos.php"
                      id="formulario" method="POST">
  <h1 style="color:white">REPORTE DE COMPRAS EN INSUMOS</h1>
                      <!--div responsivo-->
                           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>FECHA INICIO :</h3>
                            <input  style="color:black"  type="date" id="inicio" name="inicio"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">
                             <!--required-->
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h3>FECHA FINAL :</h3>
                              <input  style="color:black" type="date" id="fin" name="fin"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">
                               <!--required-->
                              </div>
                              
                              
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!--buton de tipo submit el cual envia el formulario por el metodo por ajax   -->
                                <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-print"></i> IMPRIMIR</button>
                              </div>


                              <div class="col-xs-12">
    

    <!-- <input type="datetime-local" id="meeting-time"
       name="meeting-time"  
        > -->
     
    <br>
  
   
          <!-- <a class="btn btn-danger" href="<?php echo "guardar_arqueo.php?id=" . $compra->id?>"> ARQUEO <i class="fa fa-money-bill-alt"></i></a></h2>  -->
          
          
  </div>
<?php include_once "pie.php" ?> 