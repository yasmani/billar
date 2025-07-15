<?php
date_default_timezone_set("America/La_Paz");
include_once "base_de_datos.php";
   $user = $_POST['usuario'];

   $password = $_POST['password'];
/*
   if (($user != "admin")|| ($password != "123")) {
        header("Location: ./login2.php");
       }
*/
//$base_de_datos->beginTransaction();
   $sentencia = $base_de_datos->query("SELECT * FROM usuario where usuario='$user' and clave='$password' and ip=1;");
   $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
    
     foreach($productos as $producto){
        echo $producto->usuario;
        $id= $producto->id;
        $sentencia = $base_de_datos->prepare("UPDATE usuario SET   condicion = ? WHERE id = ?;");
        $resultado = $sentencia->execute(['0', $id]);

         if($resultado == TRUE){
            setcookie("id", $id); 
            setcookie("usuario", $user); 
            setcookie("password", $password); 
            header("Location: ./mesas.php");
            //return;
         } 
            
      }   
      if(empty($productos)){

         header("Location: ./login2.php");
      }   
    // $base_de_datos->commit();
?>
