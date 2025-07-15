//$(buscar_datos());
//$(buscar_datos_venta());
//$(buscar_datos_venta_tienda());
//$(buscar_datos_tienda());
function buscar_datos_traspaso(consulta){
	$.ajax({
		url: 'buscarTraspaso.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		$("#datos_venta").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}
function buscar_datos_tienda(consulta){
	$.ajax({
		url: 'buscarTienda.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}
function buscar_datos_venta(consulta){
	$.ajax({
		url: 'buscarVenta.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		$("#datos_venta").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}
function buscar_datos_venta_tienda(consulta){
	$.ajax({
		url: 'buscarVentaTienda.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		$("#datos_venta").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}
$(document).on('keyup','#caja_busqueda_venta', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos_venta(valor);
	}else{
		buscar_datos_venta();
	}
});
$(document).on('keyup','#caja_busqueda_ventaTienda', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos_venta_tienda(valor);
	}else{
	//	buscar_datos_venta_tienda();
	}
});
function buscar_datos(consulta){
	$.ajax({
		url: 'buscar.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}




$(document).on('keyup','#caja_busqueda', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos(valor);
	}else{
		buscar_datos();
	}
});
$(document).on('keyup','#caja_busqueda_tienda', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos_tienda(valor);
	}else{
		buscar_datos_tienda();
	}
});


$(document).on('keyup','#caja_busqueda_traspaso', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos_traspaso(valor);
	}else{
	//	buscar_datos_venta_tienda();
	}
});



/****** REPORTES *********/
$(document).on("change", "input[name='opcion']", function() {
  if ($(this).val() === "1") {
      $("#ventas_reporte").css({ display: 'block', position: 'relative', right: '100%' })
          .animate({ right: '0%' }, 1000);  // Desliza hacia la derecha
      $("#compras_reporte").hide("slow");

     $('#datos_reporte').html("");
  } else if ($(this).val() === "2") {
    $("#compras_reporte").css({ 
      display: 'block', 
      position: 'relative', 
      right: '100%' 
  }).animate({ 
      right: '0%' 
  }, 1000); 
      $("#ventas_reporte").hide("slow");

      $('#datos_reporte').html("");
  }
});



 $(document).on("click", "#buscar_compras", function () {

    var inicio=$('#inicio2').val();
    var fin=$('#fin2').val();
    var producto=$('#productos').val();
    

			 
          return $.ajax({
                      url: 'modelos/model_productos.php',
                      type: 'POST',
                      data: {
                          accion: 'reporte_buscar_compras',
                          inicio: inicio,
						  fin:fin,
						  producto:producto
                      },
                      success: function(respuesta) { 
						
                            
                         $("#datos_reporte").html(respuesta);
                        
                          
             
              
                      }
                  });
                            

});

