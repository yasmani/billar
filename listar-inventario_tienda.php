   <?php 
session_start();
if(!isset($_COOKIE["usuario"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
}

 if($tipo=='administrador'){
include_once "encabezado.php";
}
if($tipo=='cajero'){
include_once "encabezado3.php";
}
if($tipo=='ambulante'){
	include_once "encabezado4.php";
}

?>
<?php
include_once "base_de_datos.php";
  
$sentencia = $base_de_datos->query("SELECT * FROM productos where estado=1;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {


include_once "base_de_datos.php";
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$lote = $_POST["lote"];
list($id_categoria, $nlote) = explode('|', $lote);
$precioVenta = $_POST["precioVenta"];
$precio2 = $_POST["precio2"];
$precio3 = $_POST["precio3"];
$precioCompra = $_POST["precioCompra"];
$existencia = $_POST["existencia"];
$tienda = $_POST["tienda"];
$stockminimo = $_POST["stockminimo"];
$fecha = $_POST["fecha"];
$especial = $_POST["especial"];
$imagen='' ;
// $imagen = $_POST["imagen"];
if(empty($fecha)){
	$fecha='2030-12-12';
}

// echo $imagen;
if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen='' ;
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "files/articulos/" . $imagen);
			}
		}

// echo $imagen;
$sentencia = $base_de_datos->prepare("INSERT INTO productos(codigo,nombre,descripcion,lote, precioVenta,precioVenta2,precioVenta3, precioCompra, existencia,tienda,imagen,stockminimo,fecha,id_categoria,estado,titulo) VALUES (?,?,?,?,?, ?, ?, ?, ?, ?,?,?,?,?,?,?);");
$resultado = $sentencia->execute([$codigo,$nombre, $descripcion,$nlote, $precioVenta,$precio2,$precio3, $precioCompra, $existencia,$tienda,$imagen,$stockminimo,$fecha,$id_categoria,1,$especial]);


if ($resultado === TRUE) {
    // Mostrar mensaje JS desde PHP
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Producto guardado',
            text: 'Se agregó correctamente.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = './listar-inventario_tienda.php';
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Algo salió mal. Por favor verifica que la tabla exista.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.reload();
        });
    </script>";
}

}


				$cantidad_total_de_productos=0;
				$monto_total_de_productos=0;
				foreach($productos as $producto){ 
				$cantidad_total_de_productos+=$producto->tienda;
				$monto_total_de_productos+=$producto->precioCompra*$producto->tienda;
				}
?>
	<div class="col-xs-12">
		<h1>LISTAS DE PRODUCTOS</h1>
		<div>
		 <!-- <a class="btn btn-success" href="./formularioRtienda.php">NUEVO ITEM <i class="fa fa-plus"></i></a> -->
		
		<a class="btn btn-success" data-toggle="modal" href="#"  data-target="#producto_nuevo" >NUEVO ITEM <i class="fa fa-plus"></i></a>
		  <a   class="btn btn-warning" target="_blank" href="./reportes/imprimirinv.php">IMPRIMIR INVENTARIO <i class="fa fa-print"></i></a> 
		 <!-- <a class="btn btn-warning" href="./compras.php">AUMENTAR STOCK <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-info" href="./listar-inventario.php">INVENTARIO <i class="fa fa-plus"></i></a>  
		  <a class="btn btn-danger" href="./listar.php">VOLVER A LISTA <i class=""></i></a>  -->
			<a class="btn btn-success" style="background-color: green;margin-left:200px;">cantidad de productos : <i class="fa fa-book"></i> <?php echo $cantidad_total_de_productos ?></a>
			<a class="btn btn-success" style="background-color:hsl(224, 66.30%, 32.50%);" > Monto total en inventario: <i class="fa fa-dollar-sign"></i> <?php echo $monto_total_de_productos ?></a>
							
	

		</div>
	
		<br>
		<table id="tabla_productos" class="table table-bordered" style="color:black; border-color:black;">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue; align-items:center;">
					
					<th>CODIGO</th>
					<th>IMAGEN</th>
					<th>NOMBRE</th>
					
					<th>CATEGORIA</th>
					<th>FECHA VENCIMIENTO</th>
					
					<th>PRECIO DE VENTA </th>
          <th>PRECIO ESPECIAL </th>
          <th>PRECIO AL PERSONAL </th>
	
					<th>STOCK</th>
					<th>OPCIONES</th>
	
				</tr>
			</thead>
			<tbody style="border-color:black;">
				<?php 
				
				foreach($productos as $producto){ 
				
				?>
				<tr>
					
					<td><?php echo $producto->codigo ?></td>
							<td> <?php 
							if($producto->imagen !==''){
										echo  "<img src='files/articulos/".$producto->imagen."' height='50px' width='50px' >"
										?>
											
									
									<?php
										}else{
											?>
											<img src='files/articulos/nulo.jpg' height='50px' width='50px' title="SIN IMAGEN" >
										
										<?php }
									 ?>
						</td>
					<td><?php echo $producto->nombre ?></td>
					
					<td><?php echo $producto->lote ?></td>
					<td><?php
					if($producto->fecha!=null){
					$fecha_actual = new DateTime(date('Y-m-d'));
                    $fecha_final = new DateTime($producto->fecha);
                    $dias = $fecha_actual->diff($fecha_final)->format('%r%a');
                
                    // Si la fecha final es igual a la fecha actual o anterior
                    if ($dias <= 0 && $dias>=-100) {
                        echo '<p style="background-color:red">vencido</p>';
                    } elseif ($dias <= 40 && $dias>0) {
                        echo '<p style="background-color:yellow;color:black" >Está a ' . $dias . ' días de vencer</p>';
                    } else {
                        echo '<p></p>';
                    }}
					
					?>
					</td>
					<td><?php echo $producto->precioVenta ?></td>

              <td><?php echo $producto->precioVenta3 ?></td>

          <td><?php echo $producto->precioVenta2 ?></td>
				
					<td><?php echo $producto->tienda ?></td>
					<td>
						<a title="Editar" id="editar_producto" class="btn btn-warning" data="<?php echo $producto->id?>" data-toggle="modal" href="#"  data-target="#producto_editar" ><i class="fa fa-edit"></i></a> 
				<a title="Eliminar" id="eliminar_producto" class="btn btn-danger" href="#" data="<?php echo $producto->id?>"><i class="fa fa-trash"></i></a></td>
					
					
				</tr>
	
				<?php } ?>
							
			</tbody>
		</table>
		
	</div>




	  	<!-- modal producto nuevo -->
<div class="modal fade" id="producto_nuevo"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Encabezado -->
      <div class="modal-header" style="background-color:#397748; color: white;">
       <center> <h5 class="modal-title" id="tituloModal">AGREGAR NUEVO PRODUCTO</h5> </center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Cuerpo -->
      <div class="modal-body">
      
		 <?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos order by id desc limit 1 ;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
$codigo=0;
  foreach($productos as $producto){  
		$codigo=$producto->codigo ;
		
		}
		$codigo=$codigo+1;

	$categorias = $base_de_datos->query("SELECT * FROM categorias where estado=1 ;");
	$lista_categorias = $categorias->fetchAll(PDO::FETCH_OBJ);
?>
   
	<form method="post" enctype="multipart/form-data" action="listar-inventario_tienda.php" >
		<label for="codigo">CODIGO :</label>
		<input autofocus class="form-control" name="codigo" required type="text" id="codigo" value="<?php echo $codigo ?>" readonly>
		<label for="nombre">NOMBRE DEL PRODUCTO:</label>
		<textarea required id="nombre" name="nombre" cols="2" rows="1" class="form-control"></textarea>
	 <input value="." class="form-control" name="descripcion"   type="hidden" id="lote" placeholder="Escribe el lote">
	 
		<label for="lote">CATEGORIA</label>
		<select  class="form-control" name="lote"  id="lote">
		<?php
		  foreach($lista_categorias as $cate){  
			?>
			<option value="<?php echo $cate->id . '|' . $cate->nombre; ?>"><?php echo $cate->nombre ; ?></option>
		<?php
		
		}
		?>
		</select>
		 <label for="lote">PRECIO DE COSTO</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="text" step="0.01" value='00.00' name="precioCompra" id="precioCompra" required>

		<label for="precioVenta">PRECIO DE VENTA:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precioVenta" id="precioVenta">
    
		<label for="precio2">PRECIO AL PERSONAL:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"     type="number" step="0.01" value='00.00' name="precio2" id="precio2">
		<div class="row">
      <div class="col-lg-4" >
      <label>PRECIO ESPECIAL:</label>
		<input class="form-control"  pattern="^\d*(\.\d{0,2})?$"    type="number" step="0.01" value='00.00' name="precio3" id="precio3">
  </div>
    <div class="col-lg-6" >
      <label >PROMO ESPECIAL:</label>
		<input class="form-control"    type="text"  name="especial" id="especial">
   </div>
  </div>
		<input  class="form-control"  name="existencia" value="0"   step="0.01" value='00.00' type="hidden" id="existencia" placeholder="Cantidad o existencia">
		<label   for="existencia">CANTIDAD:</label> 
		<input  class="form-control"  name="tienda"   step="0.01" value='' type="text" id="tienda" placeholder="Cantidad en tienda">
			<label   for="existencia">VENCIMIENTO (OPCIONAL):</label> 
		<input  class="form-control"  name="fecha"     type="date" id="fecha"  >
 
		<input  value="0" class="form-control" name="stockminimo"  step="0.01" value='00.00'  type="hidden" id="stockminimo" placeholder="minimo">
		<div class="form-group">
		<label for="imagen">IMAGEN:</label>
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="imagen" name="imagen">
			<label class="custom-file-label" for="imagen">Seleccionar archivo</label>
		</div>
		</div>
		<br><br><center><input class="btn btn-info" onclick="hizoClick()" type="submit" value="GUARDAR PRODUCTO"></center>
	</form>
</div>

    </div>
  </div>
</div>








<!-- modal producto editar -->
<div class="modal fade" id="producto_editar"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Encabezado -->
      <div class="modal-header" style="background-color:#397748; color: white;">
       <center> <h5 class="modal-title" id="tituloModal">EDITAR PRODUCTO</h5> </center>
   
      </div>
      
      <!-- Cuerpo -->
      <div class="modal-body" id="body_editar_producto">
      
	</div>

    </div>
  </div>
</div>

<script> 
$(document).on('keydown', 'input[pattern]', function(e){
  var input = $(this);
  var oldVal = input.val();
  var regex = new RegExp(input.attr('pattern'), 'g');

  setTimeout(function(){
    var newVal = input.val();
    if(!regex.test(newVal)){
      input.val(oldVal); 
    }
  }, 0);
}); 
function setTwoNumberDecimal(el) {
        el.value = parseFloat(el.value).toFixed(2);
    };


	  $(document).ready(function () {
    $('.custom-file-input').on('change', function () {
      var fileName = $(this).val().split('\\').pop();
      $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });
  });


 
$(document).ready(function() {
   if ($.fn.DataTable.isDataTable('#tabla_productos')) {
    $('#tabla_productos').DataTable().destroy();
}

$('#tabla_productos').DataTable({
	dom: 'Bflrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel" style="bakbackground-color:#5bc25b;"></i> Excel',
            className: 'btn btn-success'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf" style="bakbackground-color:#ee635c;"></i> PDF',
            className: 'btn btn-danger'
        }
    ],
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
    },
    pageLength: 10,
    ordering: true,
    searching: true
});


});


  $(document).on("click", "#editar_producto", function () {

             let valor =  $(this).attr("data");
    

			 
          return $.ajax({
                      url: 'modelos/model_productos.php',
                      type: 'POST',
                      data: {
                          accion: 'modal_editar',
                          codigo: valor
                      },
                      success: function(respuesta) { 
						
                            
                         $("#body_editar_producto").html(respuesta);
                        
                          $('#producto_editar').modal('show');
             
              
                      }
                  });
                            

});



  $(document).on("click", "#eliminar_producto", function () {

             let valor =  $(this).attr("data");
    
			  Swal.fire({
                    title: "¿Esta seguro de eliminar el producto?",
                    text: "Esta acción eliminará el producto.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                    return $.ajax({
                    url: 'modelos/model_productos.php',
                   	type: 'POST',
                      data: {
                          accion: 'modal_eliminar',
                          codigo: valor
                      },

                        success: function (response) {
                              Swal.fire({
                                  title: 'Respuesta',
                                  text: response,
                                  icon: 'success',
                                  confirmButtonText: 'OK'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                          },
                          error: function(error) {
                              console.error('Error:', error);
                              Swal.fire({
                                  title: 'Error',
                                  text: 'Hubo un problema al realizar la accion',
                                  icon: 'error',
                                  confirmButtonText: 'OK'
                              });
                          }


                     });
                
                     };

                    });

			 
         
                            

});

		</script>





