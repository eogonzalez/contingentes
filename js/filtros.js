$(document).ready(inicio());

function inicio(){

	//Verifica si elemento existe
	if ($("#contenido").length) {
		$("#contenido").hide();	
	}
	
	LlenoTratados();

	LlenoContingentes(1);

	LlenoPeriodo();
};

function LlenoTratados(){
	$.ajax({
		url: 'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getListaTratados",
		cache:false
	})
	.done(function(response){
		if (response.result == true) {	
			//Recorro los datos y lleno el combo
			
			var options = "";
			/*
			$.each(response.datos, function(key, value){
				console.log();
				options += '<option value="key">value</option>';
			})*/
			var listaTratados = $("#cboTratados");

			listaTratados.find('option').remove();
			//listaTratados.append('<option value=0">Todos...</option>');

			$(response.datos).each(function(i,v){
				//options += '<option value="'+i.idTratado+'">'+v.nombreTratado+'</option>';
				listaTratados.append('<option value="'+v.tratadoid+'">'+v.nombre+'</option>');
			});

			//$('#cboTratados').html(options);
			listaTratados.prop('disabled', false);


			//LlenoContingentes($("#cboTratados option:selected").text());
			
		}else{
			alert(response.mensaje);
		}
	})
	.fail(function(jqXHR, estado){
		//console.log(estado);
		//console.log(jqXHR);
		console.log('Ha ocurrido un error al consultar tratados.')
	})
	.always(function(){
		console.log("Llena tratados se ejecuto");
	})
};

function LlenoContingentes(idTratado){
	
	var varData = "action=getListaContingentes&idTratado="+idTratado;
	

	$.ajax({
		url:'actions.php',
		type:'GET',
		dataType:'json',
		data: varData,
		cache:false
	})
	.done(function(response){
		if (response.result == true) {	
			//Recorro los datos y lleno el combo
			
			var options = "";
			var listaContingentes = $("#cboContingentes");

			listaContingentes.find('option').remove();
			//listaContingentes.append('<option value=0">Todos...</option>');

			$(response.datos).each(function(i,v){
				//options += '<option value="'+i.idTratado+'">'+v.nombreTratado+'</option>';
				listaContingentes.append('<option value="'+v.productoid+'">'+v.nombre+'</option>');
			})

			
			listaContingentes.prop('disabled', false);

		}else{
			alert(response.mensaje);
		}
	})
	.fail(function(jqXHR, estado){
		//console.log(estado);
		//console.log(jqXHR);
		console.log('Ha ocurrido un error al consultar contingentes.')
	})
	.always(function(){
		console.log("Llena contingentes se ejecuto");
	})
};

function LlenoPeriodo(){
	$.ajax({
		url: 'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getListaPeriodo",
		cache:false
	})
	.done(function(response){
		if (response.result == true) {	
			//Recorro los datos y lleno el combo
			
			var options = "";

			var listaPeriodo = $("#cboPeriodo");

			listaPeriodo.find('option').remove();
			listaPeriodo.append('<option value="0">Todos...</option>');

			$(response.datos).each(function(i,v){
				//options += '<option value="'+i.idTratado+'">'+v.nombreTratado+'</option>';
				listaPeriodo.append('<option value="'+v.idanio+'">'+v.periodo+'</option>');
			})

			listaPeriodo.prop('disabled', false);
			
		}else{
			alert(response.mensaje);
		}
	})
	.fail(function(jqXHR, estado){
		//console.log(estado);
		//console.log(jqXHR);
		console.log('Ha ocurrido un error al consultar periodos.')
	})
	.always(function(){
		console.log("Llena Periodos se ejecuto correctamente");
	})
};