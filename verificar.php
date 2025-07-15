<?php
date_default_timezone_set("America/La_Paz");
include_once "base_de_datos.php";
//$ip = $_SERVER['REMOTE_ADDR'];
//$sentencia = $base_de_datos->query("SELECT * FROM usuario where ip='$ip' and usuario='admin' and clave='123' and condicion='0';");
//$sentencia = $base_de_datos->query("SELECT * FROM usuario where   usuario='admin' and clave='123' and condicion='0';");
$usuario=$_COOKIE["usuario"];
$password=$_COOKIE["password"];
$sentencia = $base_de_datos->query("SELECT * FROM usuario where usuario='$usuario' and clave='$password' ;");
 
   $usuario = $sentencia->fetchAll(PDO::FETCH_OBJ);
    $id=-1;
    $tipo="";
    $nombre_de_usuario="";
     foreach($usuario as $usr){
        $id= $usr->id;       
        $tipo=$usr->tipo;
        $nombre_de_usuario=$usr->usuario;
            
      } 
      if($id == -1){
       header("Location: ./login2.php");
      } 
 
 
     

?>
