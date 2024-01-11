/**
* Função para criar um objeto XMLHTTPRequest
*/
function CriaRequest() {
	try{
		request = new XMLHttpRequest();        
	}catch (IEAtual){

		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");       
		}catch(IEAntigo){

			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");          
			}catch(falha){
				request = false;
			}
		}
	}

	if (!request) 
	alert("Seu Navegador não suporta Ajax!");
	else
	return request;
}

var tempo = 120;

/**
* Função para enviar os dados
*/
function getDados() {

	// Declaração de Variáveis
	var Prod   = document.getElementById("Produto").value;
	var De   = document.getElementById("DataDe").value;
	var Ate   = document.getElementById("DataAte").value;
	var result = document.getElementById("Resultado");
	var xmlreqUf = CriaRequest();
	var xmlreqIdade = CriaRequest();
	var xmlreqSexo = CriaRequest();
	
	// Exibi a imagem de progresso
	result.innerHTML = '<img class="text-center" src="img/loading.gif" style="height: 25px; width: 25px;"/>';

	// Iniciar uma requisição
	xmlreqUf.open("GET", "./_app/control/VendasPerfilDash.php?q=uf" + "&Prod=" + Prod + "&DataDe=" + De + "&DataAte=" + Ate, true);
	xmlreqSexo.open("GET", "./_app/control/VendasPerfilDash.php?q=sexo" + "&Prod=" + Prod + "&DataDe=" + De + "&DataAte=" + Ate, true);
	xmlreqIdade.open("GET", "./_app/control/VendasPerfilDash.php?q=idade" + "&Prod=" + Prod + "&DataDe=" + De + "&DataAte=" + Ate, true);

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreqUf.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreqUf.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreqUf.status == 200){
				am4core.ready(function() {
					jQuery.getJSON( "./json/brasil.json", function( geo ) {

						// Default map
						var defaultMap = "usaAlbersLow";

						// calculate which map to be used
						var currentMap = defaultMap;
						var title = "";
						if ( am4geodata_data_countries2[ geo.country_code ] !== undefined ) {
							currentMap = am4geodata_data_countries2[ geo.country_code ][ "maps" ][ 0 ];
						}

						// Create map instance
						var chart = am4core.create("Uf", am4maps.MapChart);

						chart.titles.create().text = title;

						// Set map definition
						chart.geodataSource.url = "./json/brazilHigh.json";
						chart.geodataSource.events.on("parseended", function(ev) {
						var data = JSON.parse(xmlreqUf.responseText);

						polygonSeries.data = data;
						})

						// Set projection
						chart.projection = new am4maps.projections.Mercator();

						// Create map polygon series
						var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

						//Set min/max fill color for each area
						polygonSeries.heatRules.push({
							property: "fill",
							target: polygonSeries.mapPolygons.template,
							min: chart.colors.getIndex(1).brighten(1),
							max: chart.colors.getIndex(1).brighten(-0.3)
						});

						// Make map load polygon data (state shapes and names) from GeoJSON
						polygonSeries.useGeodata = true;

						// Set up heat legend
						let heatLegend = chart.createChild(am4maps.HeatLegend);
						heatLegend.series = polygonSeries;
						heatLegend.align = "right";
						heatLegend.width = am4core.percent(25);
						heatLegend.marginRight = am4core.percent(4);
						heatLegend.minValue = 0;
						heatLegend.maxValue = 300;
						heatLegend.valign = "bottom";

						// Set up custom heat map legend labels using axis ranges
						var minRange = heatLegend.valueAxis.axisRanges.create();
						minRange.value = heatLegend.minValue;
						minRange.label.text = "0";
						var maxRange = heatLegend.valueAxis.axisRanges.create();
						maxRange.value = heatLegend.maxValue;
						maxRange.label.text = heatLegend.maxValue + "+";

						// Blank out internal heat legend value axis labels
						heatLegend.valueAxis.renderer.labels.template.adapter.add("text", function(labelText) {
							return "";
						});

						// Configure series tooltip
						var polygonTemplate = polygonSeries.mapPolygons.template;
						polygonTemplate.tooltipText = "{name}: {value}";
						polygonTemplate.nonScalingStroke = true;
						polygonTemplate.strokeWidth = 0.5;

						// Create hover state and set alternative fill color
						var hs = polygonTemplate.states.create("hover");
						hs.properties.fill = chart.colors.getIndex(1).brighten(-0.5);
					  
					});
				}); // end am4core.ready()
				result.innerHTML = "";
			}else{
				result.innerHTML = "Erro: " + xmlreqUf.statusText;
			}
			
			
			
		}
	};
	
	xmlreqUf.send(null);
	
	
	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreqSexo.onreadystatechange = function(){
		if (xmlreqSexo.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreqSexo.status == 200){
				am4core.ready(function() {
					var chart = am4core.create("Sexo", am4charts.PieChart);
					chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

					chart.data = JSON.parse(xmlreqSexo.responseText);
					chart.radius = am4core.percent(70);
					chart.innerRadius = am4core.percent(40);
					chart.startAngle = 180;
					chart.endAngle = 360;  

					var series = chart.series.push(new am4charts.PieSeries());
					series.dataFields.value = "value";
					series.dataFields.category = "sexo";

					
					series.slices.template.draggable = true;
					series.slices.template.inert = true;
					series.alignLabels = false;

					series.hiddenState.properties.startAngle = 90;
					series.hiddenState.properties.endAngle = 90;

					}); // end am4core.ready()

		
				result.innerHTML = "";
			}else{
				result.innerHTML = "Erro: " + xmlreqSexo.statusText;
			}
			
		}
	};
	
	xmlreqSexo.send(null);
	
	xmlreqIdade.onreadystatechange = function(){
		if (xmlreqIdade.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreqIdade.status == 200){
				am4core.ready(function() {
					var chart = am4core.create("Idade", am4charts.XYChart);
					
					var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
					categoryAxis.renderer.grid.template.location = 0;
					categoryAxis.dataFields.category = "idade";
					categoryAxis.renderer.minGridDistance = 1;
					categoryAxis.renderer.inversed = true;
					categoryAxis.renderer.grid.template.disabled = true;

					var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
					valueAxis.min = 0;

					var series = chart.series.push(new am4charts.ColumnSeries());
					series.dataFields.categoryY = "idade";
					series.dataFields.valueX = "value";
					series.tooltipText = "{valueX.value}"
					series.columns.template.strokeOpacity = 0;
					
					var labelBullet = series.bullets.push(new am4charts.LabelBullet())
					labelBullet.label.horizontalCenter = "left";
					labelBullet.label.dx = 10;
					labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#')}";
					labelBullet.locationX = 1;

					// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
					series.columns.template.adapter.add("fill", function(fill, target){
						return chart.colors.getIndex(target.dataItem.index);
					});

					categoryAxis.sortBySeries = series;
					chart.data = JSON.parse(xmlreqIdade.responseText);



				}); // end am4core.ready()
				result.innerHTML = "";
			}else{
				result.innerHTML = "Erro: " + xmlreqIdade.statusText;
			}
			
		}
	};
	
	xmlreqIdade.send(null);
	
	tempo = 120;
}


var label = document.getElementById("Time");
window.setInterval(function(){
  
  var min = parseInt(tempo/60);
  var sec = tempo%60;
  
	if(min < 10){
		min = "0"+min;
		min = min.substr(0, 2);
	}
	
	if(sec <=9){
		sec = "0"+sec;
	}
	
	label.innerHTML = " 0:" + min + ":" + sec;
  
	if(tempo <= 0){
		getDados();
		tempo = 60
	}
	tempo--;
},1000);