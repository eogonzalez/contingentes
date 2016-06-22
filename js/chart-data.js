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


	var pieData = [
				{
					value: 14,
					color:"#30a5ff",
					highlight: "#62b9fb",
					label: "Arroz Granza"
				},
				{
					value: 4,
					color: "#ffb53e",
					highlight: "#fac878",
					label: "Arroz Pilado"
				},
				{
					value: 11,
					color: "#1ebfae",
					highlight: "#3cdfce",
					label: "Carne de Bovino"
				},
				{
					value: 39,
					color: "#40FF00",
					highlight: "#BEF781",
					label: "Carne de Cerdo"
				},
				{
					value: 11,
					color: "#0000FF",
					highlight: "#8181F7",
					label: "Helado"
				},
				{
					value: 6,
					color: "#ffb53e",
					highlight: "#f6495f",
					label: "Leche"
				},
				{
					value: 4,
					color: "#30a5ff",
					highlight: "#f6495f",
					label: "Queso"
				},
				{
					value: 1,
					color: "#1ebfae",
					highlight: "#f6495f",
					label: "Maiz Blanco"
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
	

	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(LlenoLinea(), {
		responsive: true
	});

/*
	var chart2 = document.getElementById("bar-chart").getContext("2d");
	window.myBar = new Chart(chart2).Bar(barChartData, {
		responsive : true
	});
	var chart3 = document.getElementById("doughnut-chart").getContext("2d");
	window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive : true
	});
*/
	var chart4 = document.getElementById("pie-chart").getContext("2d");
	window.myPie = new Chart(chart4).Pie(pieData, {responsive : true
	});
	
};

	function LlenoLinea(){


		$.ajax({
			async: false,	
			url: 'actions.php',
			type: 'GET',
			dataType: 'json',
			data: "action=getDatosTablero&idTratado=0",
			cache:false
		})
		.done(function(response){
			if (response.result == true) {	
			
				$(response.datos).each(function(i,v){	
					//console.log('entra a llenar arreglos')			
					labelChart.push(v.mes);
					//console.log(labelChart);
					dataChart.push(v.vAsignado);
				})
				
			}else{
				alert(response.mensaje);
			}
		})
		.fail(function(jqXHR, estado){
			//console.log(estado);
			//console.log(jqXHR);
			console.log('Ha ocurrido un error al consultar datos del tablero.')
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
