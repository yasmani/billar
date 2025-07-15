<?php
 
 
  $password = "Wf[pECa=o6";
$username = "u269279962_ulaofi";
$dbname = "u269279962_dbbillarlaofi";
  	
	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";

    $query = "SELECT * FROM productos WHERE descripcion NOT LIKE '' ORDER By id LIMIT 0";

    if (isset($_POST['consulta'])) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM productos WHERE id LIKE '%$q%' OR codigo LIKE '%$q%' OR nombre LIKE '%$q%' OR descripcion LIKE '%$q%' OR precioVenta LIKE '%$q%'";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='table table-bordered' overflow:auto;>
    			<thead>
    				<tr id='titulo'>
    					<td>Codigo</td>
    					<td>Nombre</td>
    					
    					<td>Descripcion</td>
    					<td style='background-color:green'>Precio Compra</td>
    					<td style='background-color:yellow;color:black'>Precio venta </td>
    				 
              <td>DISPONIBLES</td>
    				</tr>

    			</thead>
    			

    	<tbody>";

    	while ($fila = $resultado->fetch_assoc()) {
          $codigo="value='".$fila['id']."'";
    		$salida.="<tr>
    					<td>".$fila['codigo']."</td>
    					<td>".$fila['nombre']."</td>
    					
    					<td>".$fila['descripcion']."</td>
    					<td style='background-color:#7CB95C'>".$fila['precioCompra']."</td>
    					<td style='background-color:#FFFF7F;color:black'>".$fila['precioVenta']."</td>
    				 
              <td>".$fila['existencia']."</td>
    					<td>".	"<form method='post' action='agregar-carrito-compras.php'>
              <input type='hidden' ".$codigo."
              
              autocomplete='off' autofocus class='form-control' name='codigo' required type='text' id='codigo' placeholder='Escribe el código'>
              <button class='btn btn-warning' type='submit'><i class='fa fa-check'></i></button>
            </form>
             </td>
    				 
    				</tr>";

    	}
      $salida.="</tbody>
      </table>";
    }else{
    	$salida.="NO HAY DATOS :(";
    }


    echo $salida;

    $conn->close();
