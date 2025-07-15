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
    // para la latoneria
		$query = "SELECT * FROM `vehiculostaller` WHERE proceso='iniciadoLatoneria'  or proceso='terminadoLatoneria' ";
		// para preparacion
		$query2 = "SELECT * FROM `vehiculostaller` WHERE proceso='iniciadoPreparacion'  or proceso='terminadoPreparacion' ";
		// para pintura
		$query3 = "SELECT * FROM `vehiculostaller` WHERE proceso='iniciadoPintura'  or proceso='terminadoPintura' ";
		// para armado
    $query4 = "SELECT * FROM `vehiculostaller` WHERE proceso='iniciadoArmado'  or proceso='terminadoArmado' ";
    
    $resultado = $conn->query($query);
    $resultado2 = $conn->query($query2);
    $resultado3 = $conn->query($query3);
    $resultado4 = $conn->query($query4);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='table table-bordered' overflow:auto;>
    			<thead>
    				<tr id='titulo'>
    					<td> <h2> Latoneria </h2></td>
    					<td><h2>Preparacion</h2></td>
    					<td><h2>Pintura</h2></td>
    					<td><h2>Armado</h2></td>
    				</tr>
    			</thead>
    	<tbody>";
// listado de latoneria
			$salida.="<td><tr><td>";
    	while ($fila = $resultado->fetch_assoc()) {
				$salida.=" 
				 ".$fila['placa'] .'<br>'.$fila['tipoVehiculo'].'<br>'.$fila['proceso'].'<br>'.$fila['asesor'].' <br>----------------------- <br> '; 
			}
// listado de preparacion
			$salida.="</td><td>";
    	while ($fila2 = $resultado2->fetch_assoc()) {
				$salida.=" 
				".$fila2['placa'] .'<br>'.$fila2['tipoVehiculo'].'<br>'.$fila2['proceso'].'<br>'.$fila2['asesor'].'<br>---------------- <br>'; 	
			}
// listado de  pintura
			$salida.="</td><td>";
    	while ($fila2 = $resultado3->fetch_assoc()) {
				$salida.="
				".$fila2['placa'] .'<br>'.$fila2['tipoVehiculo'].'<br>'.$fila2['proceso'].'<br>'.$fila2['asesor'].'<br>---------------- <br>'; 	
			}
//listado de armado
			$salida.="</td><td>";
    	while ($fila2 = $resultado4->fetch_assoc()) {
				$salida.="
				".$fila2['placa'] .'<br>'.$fila2['tipoVehiculo'].'<br>'.$fila2['proceso'].'<br>'.$fila2['asesor'].'<br>---------------- <br>'; 	
			}
			$salida.="</tr></td >
			</tbody>
      </table>";
    }else{
    	$salida.="NO HAY DATOS";
    }


    echo $salida;

    $conn->close();
		?>