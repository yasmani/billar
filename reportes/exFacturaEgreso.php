<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['acceso']==1)
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase egreso
require_once "../modelos/Egresos.php";
//Instanaciamos a la clase con el objeto egreso
$egreso = new Egresos();
//En el objeto $rspta Obtenemos los valores devueltos del método egresocabecera del modelo
$rspta = $egreso->getEgreso($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = "TV OFFERT";
$documento = "telefono : 78182221";
$direccion = "santa cruz bolivia  ";
$telefono = " ";
$email = " ";

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        </td>
    </tr>
    <tr>
        <td align="center"><?php echo ""; ?></td>
    </tr>
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <!-- <td>Cliente: <?php echo ""; ?></td> -->
    </tr>
    <tr>
        <td><?php echo  ": " ?></td>
    </tr>
    <tr>
        <td>CODIGO: <?php echo  $reg->egresoid ?></td>
    </tr>    
</table>
<br>
<!-- Mostramos los detalles de la egreso en el documento HTML -->
<table border="0" align="center" width="300px">
    <tr>
        <td>CANT.</td>
        <td>DESCRIPCIÓN</td>
        <td align="right">MONTO</td>
    </tr>
    <tr>
      <td colspan="3">==========================================</td>
    </tr>
    <?php
    $rsptad = $egreso->getEgreso($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".'1'."</td>";
        echo "<td>".$regd->nombre;
        echo "<td align='right'>BS/ ".$regd->total."</td>";
        echo "</tr>";
        // $cantidad+=$regd->cantidad;
    }
    ?>
    <!-- Mostramos los totales de la egreso en el documento HTML -->
    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL:</b></td>
    <td align="right"><b>BS/  <?php echo $reg->total;  ?></b></td>
    </tr>
    <tr>
      <!-- <td colspan="3">Nº de artículos: <?php echo '  ' ?></td> -->
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>      
    <tr>
      <td colspan="3" align="center">¡Gracias!</td>
    </tr>
    <tr>
      <td colspan="3" align="center">TV OFFERT</td>
    </tr>
    <tr>
      <td colspan="3" align="center">SANTA CRUZ  - BOLIVIA</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>