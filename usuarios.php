<?php 
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

$sentencia = $base_de_datos->query("SELECT * FROM usuario  where    ip='1';");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>


	<div class="col-xs-12">
		<h1>LISTAS DE USUARIOS</h1>
		<div>
		  <a class="btn btn-success" href="#" data-toggle="modal" href="#"  data-target="#usuario_nuevo">NUEVO  <i class="fa fa-plus"></i></a>  
		   

		</div>

	
		
</br>
</br>

		<table id="tabla_usuarios" name="tabla_usuarios" class="table table-bordered">
			<thead style="color:white " name="tabla" class="table table-darger">
				<tr style="background-color: blue">
				
					<th>CODIGO</th>
					<th>USUARIO</th>
					<th>CLAVE</th>
					<th>TIPO</th>
					<th>EDITAR</th>
					<th>ELIMINAR</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($productos as $producto){ ?>
				<tr>
					
					<td><?php echo $producto->id ?></td>
					<td><?php echo $producto->usuario ?></td>
					<td>
						<input disabled style="color:black" type="password" value="<?php echo $producto->clave ?>" name="" id="">
						</td>
					<td><?php echo $producto->tipo ?></td>
			 
					
					<td><a class="btn btn-warning" title="Editar" id="editar_usuario" data-toggle="modal" href="#"  data-target="#usuario_editar" data="<?php echo $producto->id?>"><i class="fa fa-edit"></i></a></td>
					<td><a title="Eliminar" id="eliminar_usuario" class="btn btn-danger" href="#" data="<?php echo $producto->id?>"><i class="fa fa-trash"></i></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>


	  	<!-- modal usuario nuevo -->
<div class="modal fade" id="usuario_nuevo"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Encabezado -->
      <div class="modal-header" style="background-color:#397748; color: white;">
       <center> <h5 class="modal-title" id="tituloModal">AGREGAR NUEVO USUARIO</h5> </center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Cuerpo -->
      <div class="modal-body">
      
		
   
	<form method="post" enctype="multipart/form-data" action="nuevo_usuario.php" >
		<label for="codigo">usuario :</label>
		<input autofocus class="form-control" name="usuario"   type="text" id="codigo" >
		<label for="nombre">clave:</label>
		<textarea required id="nombre" name="clave" cols="2" rows="1" class="form-control"></textarea>
		<label for="descripcion">tipo: administrador/cajero</label>

		<select required id="tipo" name="tipo"class="form-control">
			<option value="none" disabled>..Seleccione...</option>
			<option value="administrador">administrador</option>
			<option value="ambulante">ambulante</option>
			<option value="cajero">cajero</option>
			
		</select>
		 
		 
	
		<br><br>
		<center><input class="btn btn-info" onclick="hizoClick()" type="submit" value="REGISTRAR"></center>
	</form>
</div>

    </div>
  </div>
</div>




<!-- modal usuario editar -->
<div class="modal fade" id="usuario_editar"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Encabezado -->
      <div class="modal-header" style="background-color:#397748; color: white;">
       <center> <h5 class="modal-title" id="tituloModal">EDITAR USUARIO</h5> </center>
   
      </div>
      
      <!-- Cuerpo -->
      <div class="modal-body" id="body_editar_usuario">
      
	</div>

    </div>
  </div>
</div>



	<script>
		$(document).ready(function() {

   if ($.fn.DataTable.isDataTable('#tabla_usuarios')) {
    $('#tabla_usuarios').DataTable().destroy();
}

$('#tabla_usuarios').DataTable({
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





  $(document).on("click", "#editar_usuario", function () {

             let valor =  $(this).attr("data");
    

			 
          return $.ajax({
                      url: 'modelos/model_productos.php',
                      type: 'POST',
                      data: {
                          accion: 'modal_editar_usuario',
                          codigo: valor
                      },
                      success: function(respuesta) { 
						
                            
                         $("#body_editar_usuario").html(respuesta);
                        
                          $('#usuario_editar').modal('show');
             
              
                      }
                  });
                            

});


 $(document).on("click", "#eliminar_usuario", function () {

             let valor =  $(this).attr("data");
    
			  Swal.fire({
                    title: "¿Esta seguro de eliminar el usuario?",
                    text: "Esta acción eliminará el usuario.",
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
                          accion: 'delete_usuario',
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