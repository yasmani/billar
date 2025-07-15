<?php
  
 

include_once "principal.php";

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";

    $query = "SELECT * FROM productos WHERE descripcion NOT LIKE '' ORDER By id LIMIT 0";

    if (isset($_POST['consulta'])&&strlen($_POST['consulta'])>=1&&strlen($_POST['consulta'])!=0) {
    	$q = $conn->real_escape_string($_POST['consulta']);
    	$query = "SELECT * FROM productos WHERE codigo LIKE '%$q%' OR nombre LIKE '%$q%' OR descripcion LIKE '%$q%' limit 20 ";
    }

    $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='table table-bordered' overflow:auto;>
    			<thead>
    				<tr id='titulo'>
    					<td>CODIGO</td>
    					<td>FOTO</td>
    					<td>NOMBRE</td>
    					 
    				 
              <td>STOCK </td>
             
              <td>  
                <div class='row'>
                  <div class='col col-lg-4'>
                    <label>cant.</label>
                    </div>
                    <br>
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
    					<td><img src='files/articulos/".$fila['imagen']."' height='50px' width='50px' >
						<br>
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>
						ver
						</button>
						</td>
    					<td>".$fila['nombre']."</td>
						
    				 
    				 
            <td>".$fila['tienda']."</td>
             
			
             <td>  
               <div class='row'>
               
               <form method='post' action='agregarAlCarrito_3precios_tienda.php'>
                    <input name='codigo' type='hidden' ".$codigo." >
                    <div class='col col-lg-4'>
                    <input style='color:black;width:60px' value='1' type='number' name='cantidad'>
                    </div>
                    <div class='col col-lg-3'>
                      <input name='precio'   style='color:black;width:60px' type='hidden' value='".$fila['precioVenta']."'>
                      <input name='precio' disabled  style='color:black;width:50px' type='text' value='".$fila['precioVenta']."'>
                     </div>
                    <div class='col col-lg-6'>
                    <input style='background-color:green;color:white;width:70px' value='agregar' type='submit' >
                     </div>
                </form>
               </div>
               <div style='display:none' class='row'>
               <form method='post' action='agregarAlCarrito_3precios_tienda.php'>
                    <input name='codigo' type='hidden' ".$codigo." >
                    <div class='col col-lg-4'>
                    <input style='color:black;width:65px' value='1' type='number' name='cantidad'>
                    </div>
                    <div class='col col-lg-3'>
                     
                      <input name='precio'  min='".$fila['precioVenta']."' max='".$fila['precioVenta3']."'  style='color:black;width:70px' type='number' step='0.01' value='".$fila['precioVenta2']."'>
                     </div>
                    <div class='col col-lg-4'>
                    <input  style='background-color:yellow;color:black;width:60px' value='precio2' type='submit' >
                     </div>
                </form>
               </div>
               <div style='display:none' class='row'>
               <form method='post' action='agregarAlCarrito_3precios_tienda.php'>
                    <input name='codigo' type='hidden' ".$codigo." >
                    <div class='col col-lg-4'>
                    <input style='color:black;width:55px' value='1' type='number' name='cantidad'>
                    </div>
                    <div class='col col-lg-3'>
                     <input name='precio'    style='color:black;width:60px' type='hidden' value='".$fila['precioVenta3']."'>
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
					<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	   
	  <img src="files/articulos/<?php echo $fila['imagen'] ?>"  class="img-fluid img-thumbnail" alt="Responsive image">

      </div>
      <div class="modal-footer">
        <button style="color:black" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
 
<?php
    	}
      $salida.="</tbody>
      </table>";
    }else{
    	$salida.="NO HAY DATOS :(";
    }


    echo $salida;

    $conn->close();
