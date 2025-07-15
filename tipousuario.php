<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT tipo FROM usuario WHERE condicion='0'");
$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);
$tipo = $resultado[0]->tipo;