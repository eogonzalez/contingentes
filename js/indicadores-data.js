var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};
	


window.onload = function(){

/*
1 - CAFTA-DR
2 - TLC PANAMA
3 - TLC COLOMBIA
4 - TLC CHILE
5 - TLC MEXICO
6 - AAP BELICE
7 - AAP ECUADOR
9 - OMC IMPORTACION
11 - ADA IMPORTACIONES
*/

/*
8 - ADA EXPORTACIONES
10 - OMC EXPORTACION

*/

/*Contingentes de Importacion*/

	//Lleno grafica de pie de cafta con datos de la base de datos
	var arregloTopImpoContingentes = [];
	arregloTopImpoContingentes = LlenoTopContingentes(2016, 1);

	if (arregloTopImpoContingentes['labels'].length > 0) {
		var chartTopConti = document.getElementById("pieTopImpoContingentes").getContext("2d");

		var myPieTopConti = new Chart(chartTopConti, {
			type: 'doughnut',
			data: arregloTopImpoContingentes
		});

	}else{
		$("#legendTopContingentesImpo").attr('class', 'alert alert-warning');
		$("#legendTopContingentesImpo").attr("role", 'alert');
		$("#legendTopContingentesImpo").text("No se encontraron datos para esta grafica.");
	}

	var arregloTopEmpresasImpo = [];
	arregloTopEmpresasImpo = LlenoTopEmpresas(2016, 1);

	if (arregloTopEmpresasImpo['labels'].length > 0) {
		var chartTopEmpresas = document.getElementById("pieTopImpoEmpresas").getContext("2d");

		var myPieTopEmpresas = new Chart(chartTopEmpresas, {
			type: 'doughnut',
			data: arregloTopEmpresasImpo
		});

	}else{
		$("#legendTopEmpresasImpo").attr('class', 'alert alert-warning');
		$("#legendTopEmpresasImpo").attr("role", 'alert');
		$("#legendTopEmpresasImpo").text("No se encontraron datos para esta grafica.");
	}

	var arregloCAFTA = [];
	arregloCAFTA = LLenoPie(2016,1);

	if (arregloCAFTA['labels'].length > 0) {
		var chart_cafta = document.getElementById("pie-CAFTA").getContext("2d");

		var myPieCafta = new Chart(chart_cafta, {
			type: "pie",
			data: arregloCAFTA
		});

		//document.getElementById("legendCAFTA").innerHTML = myPieCafta.generateLegend();
		//var myCafta = myPieCafta.generateLegend();
		//$("#legendCAFTA").html(myCafta);

	}else{
		$("#legendCAFTA").attr('class', 'alert alert-warning');
		$("#legendCAFTA").attr("role", 'alert');
		$("#legendCAFTA").text("No se encontraron datos para este tratado.");
	}


	var arregloPanama = [];
	arregloPanama = LLenoPie(2016, 2);

	if (arregloPanama['labels'].length > 0) {
		var chart_panama = document.getElementById("pie-Panama").getContext("2d");
		var myPiePanana = new Chart(chart_panama,{
			type: 'pie',
			data: arregloPanama
		});
	}else{
		$("#legendPanama").attr('class', 'alert alert-warning');
		$("#legendPanama").attr('role', 'alert');
		$("#legendPanama").text("No se encontraron datos para este tratado.");
	}
	


	var arregloColombia = [];
	//arregloColombia = LLenoPie(2016,3);
	var colorEtiqueta = getRandomColor();

	arregloColombia = {
		labels: ['Alimentos para perros y gatos : 0 TM'],
		datasets: [{
	           label: '# of Votes',
	           data: [0],
	           backgroundColor: colorEtiqueta,
	           borderColor: colorEtiqueta,
	           borderWidth: 1
	       }]
    };

	if (arregloColombia['labels'].length > 0) {
		var chart_colombia = document.getElementById("pie-Colombia").getContext("2d");
		var myPieColombia = new Chart(chart_colombia,{
			type: 'pie',
			data: arregloColombia
		});

	}else{
		$("#legendColombia").attr('class', 'alert alert-warning');
		$("#legendColombia").attr('role', 'alert');
		$("#legendColombia").text("No se encontraron datos para este tratado.");
	}


	var arregloChile = [];
	arregloChile = LLenoPie(2016,4);

	if (arregloChile['labels'].length > 0) {
		var chart_chile = document.getElementById("pie-chile").getContext("2d");
		var myPieCHILE = new Chart(chart_chile,{
			type: 'pie',
			data: arregloChile
		});
		
	}else{
		$("#legendChile").attr('class', 'alert alert-warning');
		$("#legendChile").attr('role', 'alert');
		$("#legendChile").text("No se encontraron datos para este tratado.");
	}


	var arregloMexico = [];
	arregloMexico = LLenoPie(2016,5);

	if (arregloMexico['labels'].length >0) {
		var chart_mexico = document.getElementById("pie-mexico").getContext("2d");
		var myPieMEXICO = new Chart(chart_mexico,{
			type: 'pie',
			data: arregloMexico
		});
		
	}else{
		$("#legendMEXICO").attr('class', 'alert alert-warning');
		$("#legendMEXICO").attr('role', 'alert');
		$("#legendMEXICO").text("No se encontraron datos para este tratado.");
	}

	var arregloBelice = [];
	arregloBelice = LLenoPie(2016,6);

	if (arregloBelice['labels'].length > 0) {
		var chart_belice = document.getElementById("pie-belice").getContext("2d");
		var myPieBELICE = new Chart(chart_belice, {
			type:'pie',
			data: arregloBelice
		});
	
	}else{
		$("#legendBELICE").attr('class', 'alert alert-warning');
		$("#legendBELICE").attr('role', 'alert');
		$("#legendBELICE").text("No se encontraron datos para este tratado.");
	}

	
	var arregloEcuador = [];
	arregloEcuador = LLenoPie(2016,7);

	if (arregloEcuador['labels'].length>0) {
		var chart_ecuador = document.getElementById("pie-Ecuador").getContext("2d");
		var myPieEcuador = new Chart(chart_ecuador,{
			type: 'pie',
			data: arregloEcuador
		});
		
	}else{
		$("#legendEcuador").attr('class', 'alert alert-warning');
		$("#legendEcuador").attr('role', 'alert');
		$("#legendEcuador").text("No se encontraron datos para este tratado.");
	}


	var arregloOMC = [];
	arregloOMC = LLenoPie(2016,9);
	if (arregloOMC['labels'].length>0) {
		var chart_omc = document.getElementById("pie-OMC").getContext("2d");
		var myPieOMC = new Chart(chart_omc, {
			type: 'pie',
			data: arregloOMC
		});
		
	}else{
		$("#legendOMC").attr('class', 'alert alert-warning');
		$("#legendOMC").attr('role', 'alert');
		$("#legendOMC").text("No se encontraron datos para este tratado.");
	}




/*Contingentes de Exportacion*/

	var arregloTopContingentesExpo = [];
	arregloTopContingentesExpo = LlenoTopContingentes(2016, 2);

	if (arregloTopContingentesExpo['labels'].length > 0) {
		var chartTopContiExpo = document.getElementById("pieTopContingentesExpo").getContext("2d");
		var myPieTopContiExpo = new Chart(chartTopContiExpo, {
			type: 'doughnut',
			data: arregloTopContingentesExpo
		});

	}else{
		$("#legendTopContingentesExpo").attr('class', 'alert alert-warning');
		$("#legendTopContingentesExpo").attr('role', 'alert');
		$("#legendTopContingentesExpo").text("No se encontraron datos para esta grafica.");
	}


	var arregloTopEmpresasExpo = [];
	arregloTopEmpresasExpo = LlenoTopEmpresas(2016, 2);

	if (arregloTopEmpresasExpo['labels'].length > 0) {
		var chartTopEmpresasExpo = document.getElementById("pieTopEmpresasExpo").getContext("2d");

		var myPieTopEmpresasExpo = new Chart(chartTopEmpresasExpo, {
			type: 'doughnut',
			data: arregloTopEmpresasExpo
		});

	}else{
		$("#legendTopEmpresasExpo").attr('class', 'alert alert-warning');
		$("#legendTopEmpresasExpo").attr("role", 'alert');
		$("#legendTopEmpresasExpo").text("No se encontraron datos para esta grafica.");
	}

	var arregloADA = [];
	arregloADA = LLenoPie(2016,8);

	if (arregloADA['labels'].length>0) {
		var chart_ADA = document.getElementById("pie-ADA").getContext("2d");
		var myPieADA = new Chart(chart_ADA, {
			type:'pie',
			data: arregloADA
		});
		
	}else{
		$("#legendADA").attr('class', 'alert alert-warning');
		$("#legendADA").attr('role', 'alert');
		$("#legendADA").text("No se encontraron datos para este tratado.");
	}


	var arregloOMCExpo = [];
	arregloOMCExpo = LLenoPie(2016,10);

	if (arregloOMCExpo['labels'].length>0) {
		var chart_omcExpo = document.getElementById("pie-OMCExpo").getContext("2d");
		var myPieOMCExpo = new Chart(chart_omcExpo, {
			type:'pie',
			data: arregloOMCExpo
		});

	}else{
		$("#legendOMCExpo").attr('class', 'alert alert-warning');
		$("#legendOMCExpo").attr('role', 'alert');
		$("#legendOMCExpo").text("No se encontraron datos para este tratado.");
	}



};


function LLenoPie($idPeriodo, $idTratado){

	var respuesta;


	$.ajax({
		async: false,
		url:'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getDatosPieTratado&idPeriodo="+$idPeriodo+"&idTratado="+$idTratado,
		cache: false
	})
	.done(function(response){
		
		//var json_string = JSON.stringify(response.datos);
		//var obj = $.parseJSON(json_string);
		//respuesta = json_string;

		var data = [];
		var etiquetas = [];
		var colores = [];
		var contenido = [];

		$(response.datos).each(function(i,v){
			var colorlabel = getRandomColor();

			etiquetas.push(v.nombre+": "+v.vEmitido+" TM ");
			data.push(parseInt(v.vEmitido));
			colores.push(colorlabel);
		});
		
		contenido = {
	        labels: etiquetas,
	        datasets: [{
	            label: '# of Votes',
	            data: data,
	            backgroundColor: colores,
	            borderColor: colores,
	            borderWidth: 1
	        }]
    	};
	
		respuesta = contenido;

	})
	.fail(function(jqXHR, estado){
		console.log("Ha ocurrido un error al consultar datos para el Pie.");
	})
	.always(function(){
		console.log("Datos del pie se ejecuto.")
	})

	return respuesta;
};

function LlenoTopContingentes($idPeriodo, $tipoTLC){
	var respuesta;

	$.ajax({
		async: false,
		url:'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getTopContingentes&idPeriodo="+$idPeriodo+"&tipoTLC="+$tipoTLC,
		cache: false

	})
	.done(function(response){
		var data = [];
		var etiquetas = [];
		var colores = [];
		var contenido = [];

		$(response.datos).each(function(i, v){
			var colorlabel = getRandomColor();

			etiquetas.push(v.pNombre+" - "+v.tlcNombreCorto+":"+v.vemitido);
			data.push(parseInt(v.vemitido));
			colores.push(colorlabel);
		});

		contenido = {
			labels: etiquetas,
			datasets: [{
				label: 'Top Contingentes',
				data: data,
				backgroundColor: colores,
				borderColor: colores,
				borderWidth: 1
			}]
		};

		respuesta = contenido;
	})
	.fail(function(jqXHR, estado){
		console.log("Ha ocurrido un error al consultar datos para el Top.");
	})
	.always(function(){
		console.log("Datos del Top se ejecuto.");
	})

	return respuesta;
};

function LlenoTopEmpresas($idPeriodo, $tipoTLC){
	var respuesta;

	$.ajax({
		async: false,
		url:'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getTopEmpresas&idPeriodo="+$idPeriodo+"&tipoTLC="+$tipoTLC,
		cache: false

	})
	.done(function(response){
		var data = [];
		var etiquetas = [];
		var colores = [];
		var contenido = [];

		$(response.datos).each(function(i, v){
			var colorlabel = getRandomColor();

			etiquetas.push(v.nombre+" - "+v.tlcNombreCorto+":"+v.vemitido);
			data.push(parseInt(v.vemitido));
			colores.push(colorlabel);
		});

		contenido = {
			labels: etiquetas,
			datasets: [{
				label: 'Top Empresas',
				data: data,
				backgroundColor: colores,
				borderColor: colores,
				borderWidth: 1
			}]
		};

		respuesta = contenido;
	})
	.fail(function(jqXHR, estado){
		console.log("Ha ocurrido un error al consultar datos para el Top de Empresas.");
	})
	.always(function(){
		console.log("Datos del Top de empresas se ejecuto.");
	})

	return respuesta;
};

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
};