<?php include_once "encabezado.php" ?>
<form name="formulario" target="_blank" action="reportes/reporte-compras-semanal.php"
                      id="formulario" method="POST">
  <h1 style="color:white">REPORTE DE COMPRAS</h1>
                      <!--div responsivo-->
                           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>DESDE :</h3>
                            <input  style="color:black"  type="date" id="inicio" name="inicio"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">
                             <!--required-->
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h3>HASTA :</h3>
                              <input  style="color:black" type="date" id="fin" name="fin"
                                name="meeting-time" value="2020-06-12T19:30"
                                min="2020-06-07T00:00" max="2021-06-14T00:00">
                               <!--required-->
                              </div>
                              
                              
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!--buton de tipo submit el cual envia el formulario por el metodo por ajax   -->
                                <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-print"></i> IMPRIMIR</button>
                              </div>
                              <?php include_once "pie.php" ?> -->