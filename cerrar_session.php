<?php
date_default_timezone_set("America/La_Paz");
include_once "base_de_datos.php";
  
   //$sentencia = $base_de_datos->query("SELECT * FROM usuario where  usuario='admin' and  condicion='0';");
   $sentencia = $base_de_datos->query("SELECT * FROM usuario where condicion='0';");
   $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
    
     foreach($productos as $producto){
        echo $producto->usuario;
        $id= $producto->id;
        $sentencia = $base_de_datos->prepare("UPDATE usuario SET   condicion = ? WHERE id = ?;");
        $resultado = $sentencia->execute(['1', $id]);

         if($resultado === TRUE){
            //header("Location: ./listar.php");
            //exit;
            setcookie('usuario','',time()-100);
            setcookie('password','',time()-100);
            echo "session cerrado";
            header("Location: ./login2.php");
         }
         else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";

    }     
            //if (($user == "admin") AND ($password == "123")) {

            //  header("Location: ./listar.php");

           // } else {

	           //header("Location: ./login2.php");

   //}
   header("Location: ./login2.php");

?>
