var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};
	


window.onload = function(){
$("#graficas").hide();

	var chartLineas = document.getElementById("line-chart").getContext("2d");
	myLineaTotal = new Chart.Line(chartLineas, 
		{data: LlenoLinea(0,0), 
		options: {responsive: true}
	});

	/*var legend = myLineaTotal.generateLegend();
	$("#legendTotal").append(legend);*/

	//document.getElementById("legendTotal").innerHTML = myLineaTotal.generateLegend();
};


function LlenoLinea(idTratado, idContingente){
	var labelChart = new Array();
	var dataChart = new Array();
	var dataChart2 = new Array();
	var dataChart3 = new Array();

	$.ajax({
		async: false,	
		url: 'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getEstadoContingente&idTratado="+idTratado+"&idContingente="+idContingente,
		cache:false
	})
	.done(function(response){


		if (response.result == true) {	
		
			$(response.datos).each(function(i,v){

				var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

				//console.log('entra a llenar arreglos')			
				labelChart.push(meses[v.mes-1]);
				//console.log(labelChart);

				if (idTratado == 0) {
					
					

					dataChart.push(v.emitido);
				}else{

					


					dataChart.push(v.totalEmitido);
					dataChart2.push(v.vActivado);
					dataChart3.push(v.vEmitido);	
				}

				
			})
			
		}else{
			alert(response.mensaje);
		}
	})
	.fail(function(jqXHR, estado){
		//console.log(estado);
		//console.log(jqXHR);
		console.log('Ha ocurrido un error al consultar estado del contingente.')
	})
	.always(function(){
		console.log("Datos del tablero se ejecuto");
	});


	if (idTratado == 0) {
		var lineChartData = {
			labels : labelChart,
			datasets : [
				{
					label: "Total Emitido",
					backgroundColor: "rgba(48, 164, 255, 0.2)",
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 1)",
					pointColor : "rgba(48, 164, 255, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : dataChart
				}
			]

		}
	}else{
		var lineChartData = {
			labels : labelChart,
			datasets : [
				{
					label: "Total Emitido",
					backgroundColor: "rgba(48, 164, 255, 0.2)",
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 1)",
					pointColor : "rgba(48, 164, 255, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : dataChart
				},
				{
					label: "Total Activado del Contingente",
					backgroundColor: "rgba(0, 65, 151, 0.7)",
					fillColor : "rgba(0, 65, 151, 0.7)",
					strokeColor : "rgba(48, 164, 0, 1)",
					pointColor : "rgba(48, 164, 0, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : dataChart2	
				},
				{
					label: "Total Emitido del Contingente",
					backgroundColor: "rgba(234, 194, 85, 0.8)",
					fillColor : "rgba(234, 194, 85, 0.8)",
					strokeColor : "rgba(255, 164, 0, 1)",
					pointColor : "rgba(255, 164, 0, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : dataChart3
				}
			]

		}
	}


	return lineChartData;
};


function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
};