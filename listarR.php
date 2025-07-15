<?php

   $user = $_POST['usuario'];

   $password = $_POST['password'];

 

   if (($user == "adm") AND ($password == "123")) {

      header("Location: ./listar.php");

   } else {

	header("Location: ./login.php");

   }

?>
