<?php 
//Ip de la pc servidor de base de datos
define("DB_HOST","localhost");

include_once "principal.php";
 


//Nombre de la base de datos
//define("DB_NAME", "json");
define("DB_NAME", $dbname);

//Usuario de la base de datos
define("DB_USERNAME", $username );

//Contraseña del usuario de la base de datos
define("DB_PASSWORD",$password);

//definimos la codificación de los caracteres
define("DB_ENCODE","utf8");

//Definimos una constante como nombre del proyecto
define("PRO_NOMBRE","willian");
 
?>

 