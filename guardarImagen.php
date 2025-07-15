<?php 
include "barcode.php";
$filepath = $_POST['filepath'];
$text = $_POST['text'];
//barcode( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
barcode( $filepath, $text,'70','horizontal','code128',true,1);

?>