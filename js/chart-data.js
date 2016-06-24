var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};
	
	var labelChart = new Array();
	var dataChart = new Array();


	var barChartData = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
				},
				{
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 0.8)",
					highlightFill : "rgba(48, 164, 255, 0.75)",
					highlightStroke : "rgba(48, 164, 255, 1)",
					data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
				}
			]
	
		}

	var pieDataOMC = [
				{
					value: 10,
					color:getRandomColor(),
					highlight: getRandomColor(),
					label: "Maiz Banco"
				},
				{
					value: 9,
					color: getRandomColor(),
					highlight: getRandomColor(),
					label: "Arroz Granza"
				}
			];

	var pieDataBelice = [
				{
					value: 1,
					color:getRandomColor(),
					highlight: getRandomColor(),
					label: "Maiz Amarillo"
				}
		];

	var pieDataMexico = [
		{
			value: 9,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Queso"
		}
	];

	var pieDataChile = [
		{
			value: 1,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Queso gouda"
		},
		{
			value: 1,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Leche condensada"
		}
	];
			
	var pieDataCAUE = [
		{
			value: 18,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Azucar"
		},
		{
			value: 1,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Ron a granel"
		},
		{
			value: 85,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Banano"
		},
		{
			value: 5,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Carne porcina"
		},
		{
			value: 7,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Queso"
		}
	];


	var pieDataDesperdicios = [
		{
			value: 112,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Desperdicios y desechos de metal"
		},
		{
			value: 5,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Desperdicios y desechos de otros metales"
		},
		{
			value: 5,
			color: getRandomColor(),
			highlight: getRandomColor(),
			label: "Desperdicios y desechos de cobre"
		}
	];

	var doughnutData = [
					{
						value: 300,
						color:"#30a5ff",
						highlight: "#62b9fb",
						label: "Blue"
					},
					{
						value: 50,
						color: "#ffb53e",
						highlight: "#fac878",
						label: "Orange"
					},
					{
						value: 100,
						color: "#1ebfae",
						highlight: "#3cdfce",
						label: "Teal"
					},
					{
						value: 120,
						color: "#f9243f",
						highlight: "#f6495f",
						label: "Red"
					}
	
				];

window.onload = function(){

	var chartLineas = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chartLineas).Line(LlenoLinea(), {
		responsive: true
	});

	//Lleno grafica de pie de cafta con datos de la base de datos
	var chart_cafta = document.getElementById("pie-CAFTA").getContext("2d");
	myPieCafta = new Chart(chart_cafta).Pie(LLenoPie(2016,1), {responsive : true});
	document.getElementById("legendCAFTA").innerHTML = myPieCafta.generateLegend();


	var chart_omc = document.getElementById("pie-OMC").getContext("2d");
	myPieOMC = new Chart(chart_omc).Pie(LLenoPie(2016,9), {responsive: true});
	document.getElementById("legendOMC").innerHTML = myPieOMC.generateLegend();

	var chart_belice = document.getElementById("pie-belice").getContext("2d");
	myPieBELICE = new Chart(chart_belice).Pie(LLenoPie(2016,6), {responsive: true});
	document.getElementById("legendBELICE").innerHTML = myPieBELICE.generateLegend();
	
	var chart_mexico = document.getElementById("pie-mexico").getContext("2d");
	myPieMEXICO = new Chart(chart_mexico).Pie(LLenoPie(2016,5), {recursive: true});
	document.getElementById("legendMEXICO").innerHTML = myPieMEXICO.generateLegend();

	var chart_chile = document.getElementById("pie-chile").getContext("2d");
	myPieCHILE = new Chart(chart_chile).Pie(LLenoPie(2016,4), {recursive: true});
	document.getElementById("legendCHILE").innerHTML = myPieCHILE.generateLegend();

	var chart_ca = document.getElementById("pie-CA").getContext("2d");
	myPieCA = new Chart(chart_ca).Pie(pieDataCAUE, {recursive: true});
	document.getElementById("legendCA").innerHTML = myPieCA.generateLegend();

/*
	var chart_desperdicio = document.getElementById("pie-desperdicios").getContext("2d");
	window.myPie = new Chart(chart_desperdicio).Pie(pieData, {recursive: true});
	*/

};


function LlenoLinea(){


	$.ajax({
		async: false,	
		url: 'actions.php',
		type: 'GET',
		dataType: 'json',
		data: "action=getEstadoContingente",
		cache:false
	})
	.done(function(response){
		if (response.result == true) {	
		
			$(response.datos).each(function(i,v){

				var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

				//console.log('entra a llenar arreglos')			
				labelChart.push(meses[v.mes-1]);
				//console.log(labelChart);
				dataChart.push(v.emitido);
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


	var lineChartData = {
		labels : labelChart,
		datasets : [
			{
				label: "My First dataset",
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

	return lineChartData;
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

		$(response.datos).each(function(i,v){

			data.push( 
			{
				value: parseInt(v.vEmitido),
				color:getRandomColor(),
				highlight: getRandomColor(),
				label: v.nombre
				});
			
		});

		respuesta = data;

	})
	.fail(function(jqXHR, estado){
		console.log("Ha ocurrido un error al consultar datos para el Pie.");
	})
	.always(function(){
		console.log("Datos del pie se ejecuto.")
	})

	return respuesta;
}

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
};