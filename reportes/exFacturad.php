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
if ($_SESSION['escritorio']==1)
{ 
  //Obtenemos los datos de la cabecera de la despacho actual
require_once "../modelos/Despacho.php";
$despacho= new Despacho();
$rsptav = $despacho->despachocabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();
//Incluímos el archivo Factura.php
require('Facturad.php');

//Establecemos los datos de la empresa
$logo = "../w/assets/images/empresa/logo (1).png";
$ext_logo = "png";
$empresa = "NOTA DE DESPACHO";
$documento = "TV OFFERT "."\n"."De: SANTA CRUZ"."\n"."A:".$regv->num_comprobante;
$direccion = "av radial 13 ,calle #3";
$telefono = "61599811";
$email = "wilianrojasa@gmail.com";



//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("Dirección: ").utf8_decode($direccion)."\n".
                  utf8_decode("Teléfono: ").$telefono."\n" .
                  "CORREO : ".$email,$logo,$ext_logo);
$pdf->fact_dev( "CODIGO 000".$_GET["id"], " $regv->num_comprobante" );
$pdf->fact_dev( "DESPACHO A ".$regv->num_comprobante." COD-000".$_GET["id"], "");
$pdf->temporaire( "" );
$pdf->addDate( $regv->fecha);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse(utf8_decode($regv->cliente),"Domicilio: ".utf8_decode($regv->direccion),$regv->tipo_documento.": ".$regv->num_documento,"Email: ".$regv->email,"Telefono: ".$regv->telefono);

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la despacho
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             "P.U."=>25,
             "DSCTO"=>20,
             "SUBTOTAL"=>22);
$pdf->addCols( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             "P.U."=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 89;

//Obtenemos todos los detalles de la despacho actual
$rsptad = $despacho->despachodetalle($_GET["id"]);

while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=> utf8_decode("$regd->articulo"),
                "CANTIDAD"=> "$regd->cantidad",
                "P.U."=> "$regd->precio_despacho",
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL"=> "$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
// $con_letra=strtoupper($V->ValorEnLetras($regv->total_despacho,"BOLIVINANOS"));
// $pdf->addCadreTVAs("---".$con_letra);

//Mostramos el impuesto
$pdf->addTVAs( $regv->impuesto, $regv->total_despacho,"BS/ ");
$pdf->addCadreEurosFrancs(""." ");
// $pdf->addCadreEurosFrancs("IVA"." $regv->impuesto %");
$pdf->Output('Reporte de despacho','I');


}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>