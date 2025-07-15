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

    if (isset($_POST['consulta'])&&strlen($_POST['consulta'])>=2) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM productos WHERE codigo LIKE '%$q%' OR nombre LIKE '%$q%' OR descripcion LIKE '%$q%' OR precioVenta LIKE '%$q%' OR lote LIKE '%$q%'";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='table table-bordered' overflow:auto;>
    			<thead>
    				<tr id='titulo'>
    					<td>CODIGO</td>
    					<td>NOMBRE</td>
    					<td>DESCRIPCION</td>
    					<td>CATEGORIA</td>
              <td>ALMACEN</td>
              <td>TIENDA</td>
               
              <td>  
                <div class='row'>
                  <div class='col col-lg-4'>
                    <label>CANTIDAD</label>
                    </div>
                    
                    <div class='col col-lg-4'>
                    <label>PRECIO</label>
                    </div>
                </div>
              </td>
    				</tr>

    			</thead>
    			

    	<tbody>";

    	while ($fila = $resultado->fetch_assoc()) {
			
          $codigo="value='".$fila['id']."'";
          $precioVenta="value='".$fila['precioVenta']."'";
          $precioVenta2="value='".$fila['precioVenta2']."'";
          $precioVenta3="value='".$fila['precioVenta3']."'";
    		$salida.="<tr>
    					<td>".$fila['codigo']."</td>
    					<td>".$fila['nombre']."</td>
						
    					<td>".$fila['descripcion']."</td>
    					<td>".$fila['lote']."</td>
            <td>".$fila['existencia']."</td>
            <td>".$fila['tienda']."</td>
			 
              
             <td>  
               <div class='row'>
               
               <form method='post' action='agregarAlCarrito_3precios.php'>
                    <input name='codigo' type='hidden' ".$codigo." >
                    <div class='col col-lg-4'>
                    <input style='color:black;width:67px' value='1' type='number' name='cantidad'>
                    </div>
                    <div class='col col-lg-3'>
                      <input name='precio'   style='color:black;width:50px' type='hidden' value='".$fila['precioVenta']."'>
                      <input name='precio' disabled  style='color:black;width:50px' type='text' value='".$fila['precioVenta']."'>
                     </div>
                    <div class='col col-lg-4'>
                    <input style='background-color:green;color:white;width:60px' value='precio1' type='submit' >
                     </div>
                </form>
               </div>
               <div class='row'>
               <form method='post' action='agregarAlCarrito_3precios.php'>
                    <input name='codigo' type='hidden' ".$codigo." >
                    <div class='col col-lg-4'>
                    <input style='color:black;width:67px' value='1' type='number' name='cantidad'>
                    </div>
                    <div class='col col-lg-3'>
                     
                      <input name='precio'    style='color:black;width:50px' type='text' value='".$fila['precioVenta2']."'>
                     </div>
                    <div class='col col-lg-4'>
                    <input style='background-color:yellow;color:black;width:60px' value='precio2' type='submit' >
                     </div>
                </form>
               </div>
               <div class='row'>
               <form method='post' action='agregarAlCarrito_3precios.php'>
                    <input name='codigo' type='hidden' ".$codigo." >
                    <div class='col col-lg-4'>
                    <input style='color:black;width:67px' value='1' type='number' name='cantidad'>
                    </div>
                    <div class='col col-lg-3'>
                     <input name='precio'    style='color:black;width:50px' type='hidden' value='".$fila['precioVenta3']."'>
                      <input name='precio' disabled  style='color:black;width:50px' type='text' value='".$fila['precioVenta3']."'>
                     </div>
                    <div class='col col-lg-4'>
                    <input style='background-color:orange;color:white;width:60px' value='precio3' type='submit' >
                     </div>
                </form>
               </div>
              </td>
    				 
    				</tr>";
					?>
 
<?php
    	}
      $salida.="</tbody>
      </table>";
    }else{
    	$salida.="NO HAY DATOS :(";
    }


    echo $salida;

    $conn->close();
