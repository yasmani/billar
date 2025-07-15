setInterval('listar()',1000);

function listar(consulta){
	$.ajax({
		url: 'listarEnTiempoRealbackEnd.php' ,
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

 