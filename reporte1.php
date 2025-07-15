
<form name="formulario" target="_blank" action="reportes/reporte-ventas-semanal.php"
                      id="formulario" method="POST">
                      <!--div responsivo-->
                      
                      <h1>REPORTE DE VENTAS(DIARIO Y SEMANAL)</h1>
                           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>DESDE :</h3>
                            <input  style="color:black"  type="date" id="inicio" name="inicio"
                            value="<?php echo date("Y-m-d");?>">
                             <!--required-->
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h3>FIN :</h3>
                              <input  style="color:black" type="date" id="fin" name="fin"
                              value="<?php echo date("Y-m-d");?>">
                               <!--required-->
                              </div>
                              
                              
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!--buton de tipo submit el cual envia el formulario por el metodo por ajax   -->
                                <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-print"></i> IMPRIMIR</button>
                              </div>

                            </form>

                            <form name="formulario" target="_blank" action="./exportar_ventas_xsl.php"
                                id="formulario" method="POST">
                                <!--div responsivo-->
                                <h1>REPORTES DE VENTAS  CONSOLIDADAS EN EXCEL</h1>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
                                <input  style="color:black"  type="date" id="inicio" name="inicio"
                                 value="<?php echo date("Y-m-d");?>"
                                 >
                              <input  style="color:black" type="date" id="fin" name="fin"
							                    value="<?php echo date("Y-m-d");?>">
                                <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER COMPRAS (PDF)</button>
                            </form>
                            