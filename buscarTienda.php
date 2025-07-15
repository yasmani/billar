<?php
 
 
include_once "principal.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";

    $query = "SELECT * FROM productos  ORDER By id LIMIT 0";

    if (isset($_POST['consulta'])) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM productos WHERE id LIKE '%$q%' OR codigo LIKE '%$q%' OR nombre LIKE '%$q%' OR descripcion LIKE '%$q%' OR lote LIKE '%$q%' OR precioVenta LIKE '%$q%' ";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='table table-bordered' overflow:auto;>
    			<thead>
    				<tr id='titulo'>
    					<td>Codigo</td>
    					<td>Nombre</td>
    					
    			 
     					<td style='display:none;background-color:green'>Precio Compra</td>
    					<td style='background-color:yellow;color:black'>Precio venta </td>
    	 
              <td>STOCK </td>
    				</tr>

    			</thead>
    			

    	<tbody>";

    	while ($fila = $resultado->fetch_assoc()) {
          $codigo="value='".$fila['id']."'";
    		$salida.="<tr>
    					<td>".$fila['codigo']."</td>
    					<td>".$fila['nombre']."</td>
    					
    				 
    				 
    					<td style='display:none;background-color:#7CB95C'>".$fila['precioCompra']."</td>
    					<td style='background-color:#FFFF7F;color:black'>".$fila['precioVenta']."</td>
     
              <td>".$fila['tienda']."</td>
    					<td>".	"<form method='post' action='agregar-carrito-compras-tienda.php'>
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
