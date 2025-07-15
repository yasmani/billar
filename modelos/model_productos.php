<?php


if(!isset($_POST['accion']) || empty($_POST['accion'])  ){

    die("<hr width='50%'>  ");

}

$accion = $_REQUEST['accion'];

$hoy=date("Y-m-d H:i:s");
$str="";

function JSON2Array($data){
    return  (array) json_decode(stripslashes($data));
}
include_once "../base_de_datos.php";


if($accion=='modal_editar'){

    $codigo = $_REQUEST['codigo'];
     
	
    $sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ?;");
    $sentencia->execute([$codigo]);
    $producto = $sentencia->fetch(PDO::FETCH_OBJ);
    if($producto === FALSE){
        $str.='No existe algún producto con ese ID!';
     
        
    }else{

	$str='
		
	
		<form method="post" action="guardarDatosEditados.php" enctype="multipart/form-data">
			<input type="hidden" name="id" value="'.$producto->id.'">
	
			<label for="codigo">CODIGO:</label>
			<input value="'.$producto->codigo.'" class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
			<label for="nombre">NOMBRE:</label>
			<textarea required id="nombre" name="nombre" cols="30" rows="1" class="form-control">'.$producto->nombre.'</textarea>

			<label for="descripcion">descripcion:  </label>
			<input value="'. $producto->descripcion.'" class="form-control" name="descripcion"   type="text" id="descripcion" placeholder="descripcion" >
			<label for="lote">categoria:  </label>
			<input value="'.$producto->lote.'" class="form-control" name="lote"   type="text" id="lote" placeholder="lote" >

			<label for="precioCompra">COSTO UNITARIO:</label>
			<input value="'.$producto->precioCompra.'" class="form-control" name="precioCompra"   type="number" id="precioCompra" placeholder="Precio de compra" step="0.01">

			<label for="precioVenta">PRECIO DE VENTA:</label>
			<input value="'.$producto->precioVenta.'" class="form-control" name="precioVenta" required type="number" id="precioVenta" placeholder="Precio de venta" step="0.01">
			<label for="precioVenta">PRECIO AL PERSONAL:</label>
			<input value="'.$producto->precioVenta2.'" class="form-control" name="precioVenta2" required type="number" id="precioVenta2" placeholder="Precio de venta" step="0.01">
				<div class="row">
				<div class="col-lg-4" >
				<label>PRECIO ESPECIAL:</label>
					<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value="'.$producto->precioVenta3.'" name="precioVenta3" id="precioVenta3">
			</div>
				<div class="col-lg-6" >
				<label >PROMO ESPECIAL:</label>
					<input class="form-control"    type="text"  name="especial" id="especial" value="'.$producto->titulo.'">
			</div>
			</div>
			<label for="existencia">CANTIDAD:</label>
			<input value="'.$producto->tienda.'" class="form-control" name="tienda" type="text" id="tienda"  >
			<!--<label for="existencia">ALMACEN:</label>-->
			<input value="'.$producto->existencia.'" class="form-control" name="existencia" type="hidden" id="existencia"  >
			<!--<label for="existencia">STOCK MINIMO:</label>-->
			<input value="'.$producto->stockminimo.'" class="form-control" name="stockminimo" type="hidden" id="existencia"  >

  
			
			<label style="display: none;" for="">NUEVA FOTO</label>
			
 		<label>IMAGEN:</label>
		 <input type="file" class="form-control" name="imagen" id="imagen">

		<input type="hidden" value="'.$producto->imagen.'" name="imagenactual" id="imagenactual">

		<center><img src="files/articulos/'.$producto->imagen.'"  width="150px" height="120px" id="imagenmuestra"></center>
	
	<br><br>
			<center><input class="btn btn-info" type="submit" value="GUARDAR PRODUCTO">
			<a class="btn btn-warning" href="#" data-dismiss="modal" aria-label="Cerrar">CANCELAR</a>
            </center>
			
		</form>
	';

    }
     
  
        
}



if($accion=='modal_eliminar'){

    $codigo = $_REQUEST['codigo'];
     
	
     $sentencia = $base_de_datos->prepare("UPDATE productos SET estado = 0 WHERE id = ?;");
    $sentencia->execute([$codigo]);

    if ($sentencia->rowCount() > 0) {
        $str = 'Producto eliminado con éxito...!';
    } else {
        $str = 'No existe algún producto con ese ID o ya estaba eliminado.';
    }
}



if($accion=='delete_usuario'){

    $codigo = $_REQUEST['codigo'];
     
	
     $sentencia = $base_de_datos->prepare("UPDATE usuario SET ip = 0 WHERE id = ?;");
    $sentencia->execute([$codigo]);

    if ($sentencia->rowCount() > 0) {
        $str = 'Usuario eliminado con éxito...!';
    } else {
        $str = 'No existe algún Usuario con ese ID o ya estaba eliminado.';
    }
}


if($accion=='modal_editar_usuario'){

    $codigo = $_REQUEST['codigo'];
     
	
   	$sentencia = $base_de_datos->prepare("SELECT * FROM usuario WHERE id = ?;");
    $sentencia->execute([$codigo]);
    $usuario = $sentencia->fetch(PDO::FETCH_OBJ);
    if($usuario === FALSE){
        $str.='No existe algún usuario con ese ID!';
     
        
    }else{

	$str='
	<form method="post" action="guardarDatosEditadosUsuario.php" enctype="multipart/form-data">
	
			<input value="'.$usuario->id.'" class="form-control" name="id" required type="hidden" id="codigo" placeholder="Escribe el código">

			<label for="descripcion">USUARIO:  </label>
			<input value="'.$usuario->usuario.'" class="form-control" name="usuario"   type="text" id="descripcion" placeholder="descripcion" >
			<label for="lote">contraseña:  </label>
			<input value="'.$usuario->clave.'" class="form-control" name="clave"   type="text" id="lote" placeholder="lote" >

			<label for="precioCompra">TIPO: administrador/cajero</label>
			<select required id="tipo" name="tipo"class="form-control">
			<option value="none" disabled>..Seleccione...</option>
			<option value="administrador">administrador</option>
			<option value="ambulante">ambulante</option>
			<option value="cajero">cajero</option>
			
		</select>
 
			<br>
	</div>
	<br><br>
	<center>
			<input class="btn btn-info" type="submit" value="GUARDAR">
			<a class="btn btn-warning"href="#" data-dismiss="modal" aria-label="Cerrar">CANCELAR</a>
			</center>
			
		</form>';

	}
}



if($accion=='modal_seleccion'){

    $codigo = $_REQUEST['codigo'];
	 $cantidad = $_REQUEST['cantidad'];
	 $usuario = $_REQUEST['usuario'];
	 $idmesa = $_REQUEST['idmesa'];
	 $categoria = $_REQUEST['categoria'];

		
					
				
     
	
    $sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ?;");
    $sentencia->execute([$codigo]);
    $producto = $sentencia->fetch(PDO::FETCH_OBJ);
    if($producto === FALSE){
        $str.='No existe algún producto con ese ID!';
     
        
    }else{

		if($producto->imagen !==''){
		 $imagen = '<img src="./files/articulos/'.$producto->imagen.'" height="60px" width="60px">';

									
		}else{
			 $imagen = '<img src="./files/articulos/nulo.jpg" height="60px" width="60px">';
										
										
		 }
	$str='
		
	
		 <form   method="post" action="agregarAlCarritoMesa.php?categoria='.$categoria.'" width="100%">
						 
						 <input   name="id" type="hidden"  value="'.$codigo.'" >
						 <input   name="usuario" type="hidden"  value="'.$usuario.'" >
						 <input   name="idmesa" type="hidden"  value="'.$idmesa.'" >
						 <input name="precio"    type="hidden" value="'.$producto->precioVenta.'">
						 <input name="precio3"    type="hidden" value="'.$producto->precioVenta3.'">
						 
			  <div class="row">
    <div class="col-lg-6">
        <div class="metric">
            '.$imagen.'
            <p>
              
                <span class="number"><input type="radio" id="opcion" style="width: 25px; height: 25px;" name="opcion" value="1"></span>
                  <br>
                <span class="title">'.$producto->tienda.'<br>'.$producto->nombre .'  '. number_format($producto->precioVenta , 1, ',', ' ') .'bs
				</span>
            </p>
        </div>
        </div>
        <div class="col-lg-6">
            <div class="metric">
                '.$imagen.'
                <p>                   
                <span class="number"><input type="radio" id="opcion" style="width: 25px; height: 25px;" name="opcion" value="2"></span>
                  <br>
                    <span class="title">'.$producto->tienda.'<br>'.$producto->titulo .'  '. number_format($producto->precioVenta3 , 1, ',', ' ') .'bs</span>
                </p>
            </div>
       		</div>
    
   			</div>
			<input   autocomplete="off"  value="1" type="hidden" name="cantidad" id="cantidad">
			<br><br>
	<div class="row">
	<div class="col-lg-12">
	
			<center><input class="btn btn-success" type="submit" value="AGREGAR AL CARRITO">
			
            </center>
			</div>
    
   			</div>
		</form>
	';

    }
     
  
        
}




if($accion=='reporte_buscar_compras'){

    $inicio = $_REQUEST['inicio'];
	 $fin = $_REQUEST['fin'];
	 $producto = $_REQUEST['producto'];

	 
date_default_timezone_set("America/La_Paz");
if($producto==0){
$sentencia = $base_de_datos->query("SELECT * FROM `comprastienda` where fecha BETWEEN '$inicio' and '$fin' ORDER by id DESC");

}else{

$sentencia = $base_de_datos->query("SELECT c.* FROM comprastienda c
INNER JOIN productos_comprados_tienda p ON p.id_compra=c.id
where c.fecha BETWEEN '$inicio' and '$fin'
and p.id_producto='$producto'

ORDER by c.id DESC");
}

$compras = $sentencia->fetchAll(PDO::FETCH_OBJ);



 $str.='<div class="col-xs-12">
	<h1>COMPRAS</h1>
	
	<br>
	<table id="tabla_compras_tienda" style="color:black; width:80%;" name="tabla" class="table table-bordered">
		<thead style="color:white; " name="tabla" class="table table-darger">
			<tr style="background-color: #46818a;">
				<th>NUMERO</th>
				<th>FECHA</th>
				<th>HORA</th>
				<th>PRODUCTOS</th>
				<th>TOTAL</th>
				<th>ELIMINAR</th>					
				<th>IMPRIMIR</th>
				</tr>
			</thead>
			<tbody>';
				
				$totalvendido=0;

				foreach($compras as $comp){ 
						if($comp->condicion=="1"){
							
						
				 $str.='<tr> 
					
					<td>'.$comp->id.'</td>
					<td>'.date("d/m/Y", strtotime($comp->fecha)).'</td>
					<td>'.$comp->HORA.'</td>
					<td>
						<table style="background-color:#43ab9b ;color:white" class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>nombre</th>
									<th>Cantidad</th>
									<th>precio compra</th>
									<th>subtotal</th>
								</tr>
							</thead>
							<tbody style="background-color:#28293B ;color:white">';
							
								$detallesql = $base_de_datos->query("SELECT productos_comprados_tienda.id, productos.id,productos.codigo,productos.nombre,productos_comprados_tienda.precio,productos_comprados_tienda.cantidad,productos_comprados_tienda.precio *productos_comprados_tienda.cantidad as total 
								FROM `productos_comprados_tienda`, productos 
								WHERE productos_comprados_tienda.id_compra='$comp->id' and  productos_comprados_tienda.id_producto=productos.id;");
								$detalle = $detallesql->fetchAll(PDO::FETCH_OBJ);
								foreach($detalle as $de){ 
									
								$str.='<tr>
								 
									<td>'.$de->codigo.'</td>
									<td>'.$de->nombre.'</td>
									<td>'. $de->cantidad.'</td>
									<td>'.$de->precio.'</td>
									<td>'.$de->total.'</td>
								 
								</tr>';
								 } 
								
							$str.='</tbody>
						</table>
					</td>
					<td>
					
				 
					'.$comp->total.'
				 
					
					</td>';
				 
					
					$totalvendido=$totalvendido+$comp->total;

					$error = [ 'id' => $comp->id ];
					$error = serialize($error);
				$error = urlencode($error);

					 $str.=' <td>
					     <a class="btn btn-danger" href="eliminarCompra.php?id='. $comp->id.'"><i class="fa fa-trash"></i></a>
					     </td>

					 <td><a class="btn btn-info" href="imprimir_ticket_compra.php?ticket='.$error.'"><i class="fa fa-print"></i></a></td>
				</tr>';
				 } 
				}
				
		 $str.='</tbody>
		</table>
		<div>   
		  
		</div>
			<h3>TOTAL COMPRADO: '.$totalvendido.'  Bs';
			
					


}


echo $str;

?>