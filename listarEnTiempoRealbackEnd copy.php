<?php
	$servername = "localhost";
    $username = "root";
  	$password = "";
  	$dbname = "ventas2";

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";

    $query = "SELECT * FROM productos";
    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='table table-bordered' overflow:auto;>
    			<thead>
    				<tr id='titulo'>
    					<td>ID</td>
    					<td>NOMBRE</td>
    					<td>PRECIO</td>
    					<td>CODIGO</td>
    				</tr>
    			</thead>
    	<tbody>";

    	while ($fila = $resultado->fetch_assoc()) {
          $codigo="value='".$fila['codigo']."'";
    		$salida.="<tr>
    					<td>".$fila['id']."</td>
    					<td>".$fila['descripcion']."</td>
    					<td>".$fila['precioVenta']."</td>
    					<td>".$fila['codigo']."</td>
    				</tr>";

    	}
      $salida.="</tbody>
      </table>";
    }else{
    	$salida.="NO HAY DATOS";
    }


    echo $salida;

    $conn->close();
