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
	var nome   = document.getElementById("Carteira").value;
	var result = document.getElementById("Resultado");
	var xmlreq = CriaRequest();
	var xmlreq2 = CriaRequest();
	var xmlreq3 = CriaRequest();
	
	// Exibi a imagem de progresso
	result.innerHTML = '<img class="text-center" src="img/loading.gif" style="height: 25px; width: 25px;"/>';

	// Iniciar uma requisição
	xmlreq.open("GET", "./_app/control/AtendimentoDash.php?Q=1&Cart=" + nome, true);

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {

			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200) {
				var TxFunil = JSON.parse(xmlreq.responseText);
				document.getElementById("Funil").innerHTML = 
					"<div class='text-primary form-row'><h3 class='col-sm'>Clientes</h3><h3 class-col-sm-4>" + TxFunil['Clientes'] + "</h3></div>" +
					"<div class='text-success form-row'><h3 class='col-sm'>Sucesso</h3><h3 class-col-sm-4>" + TxFunil['Atendidas'] + "</h3></div>" +
					"<div class='text-info form-row'><h3 class='col-sm'>Cpc</h3><h3 class-col-sm-4>" + TxFunil['CPC'] + "</h3></div>" +
					"<div class='text-danger form-row'><h3 class='col-sm'>Efetivo</h3><h3 class-col-sm-4>" + TxFunil['Efetivo'] + "</h3></div>" +
					"<hr><div class='card-body' id='GrFunil' style='height: 300px; width: 100%;'></div>"
				;
				
				var Percent = 
					'[{"category":"Efetivo","value":"' + ((TxFunil['Efetivo']/TxFunil['CPC'])*100).toFixed(2) +'","full":"100"},'+
					'{"category":"CPC","value":"' + ((TxFunil['CPC']/TxFunil['Atendidas'])*100).toFixed(2) +'","full":"100"},'+
					'{"category":"Sucesso","value":"' + ((TxFunil['Atendidas']/TxFunil['Clientes'])*100).toFixed(2) + '","full":"100"}]';
				
				am4core.ready(function() {

					// Themes begin
					// am4core.useTheme(am4themes_material);
					// am4core.useTheme(am4themes_animated);
					// Themes end
					
					// Create chart instance
					var chart = am4core.create("GrFunil", am4charts.RadarChart);

					// Add data
					chart.data = JSON.parse(Percent);

					// Make chart not full circle
					chart.startAngle = -90;
					chart.endAngle = 180;
					chart.innerRadius = am4core.percent(30);

					// Set number format
					chart.numberFormatter.numberFormat = "#.##'%'";

					// Create axes
					var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
					categoryAxis.dataFields.category = "category";
					categoryAxis.renderer.grid.template.location = 0;
					categoryAxis.renderer.grid.template.strokeOpacity = 0;
					categoryAxis.renderer.labels.template.horizontalCenter = "right";
					categoryAxis.renderer.labels.template.fontWeight = 500;
					categoryAxis.renderer.labels.template.adapter.add("fill", function(fill, target) {
					  return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;
					});
					categoryAxis.renderer.minGridDistance = 10;

					var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
					valueAxis.renderer.grid.template.strokeOpacity = 0;
					valueAxis.min = 0;
					valueAxis.max = 70;
					valueAxis.strictMinMax = true;

					// Create series
					var series1 = chart.series.push(new am4charts.RadarColumnSeries());
					series1.dataFields.valueX = "full";
					series1.dataFields.categoryY = "category";
					series1.clustered = false;
					series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
					series1.columns.template.fillOpacity = 0.08;
					series1.columns.template.cornerRadiusTopLeft = 20;
					series1.columns.template.strokeWidth = 0;
					series1.columns.template.radarColumn.cornerRadius = 20;

					var series2 = chart.series.push(new am4charts.RadarColumnSeries());
					series2.dataFields.valueX = "value";
					series2.dataFields.categoryY = "category";
					series2.clustered = false;
					series2.columns.template.strokeWidth = 0;
					series2.columns.template.tooltipText = "{category}: [bold]{value}[/]";
					series2.columns.template.radarColumn.cornerRadius = 20;

					series2.columns.template.adapter.add("fill", function(fill, target) {
					  return chart.colors.getIndex(target.dataItem.index);
					});

				});
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText;
			}
		}
	};
	
	xmlreq.send(null);
	
	xmlreq2.open("GET", "./_app/control/AtendimentoDash.php?Q=2&Cart=" + nome, true);

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq2.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq2.readyState == 4) {

			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq2.status == 200) {
				var TxDisc = (xmlreq2.responseText == '') ? '' : JSON.parse(xmlreq2.responseText);
				
				/* Grafico Discador */
				am4core.ready(function() {

					// Themes begin
					// am4core.useTheme(am4themes_material);
					// am4core.useTheme(am4themes_animated);
					// Themes end

					// Create chart instance
					var chart = am4core.create("Discador", am4charts.SlicedChart);

					// Add and configure Series
					var series = chart.series.push(new am4charts.FunnelSeries());
					series.colors.step = 2;
					series.dataFields.value = "Qtd";
					series.dataFields.category = "Ocorrencia";
					series.alignLabels = true;
					
					series.labelsContainer.paddingLeft = 15;
					// series.labelsContainer.width = 200;

					chart.data = TxDisc;

				});
			}else{
				result.innerHTML = "Erro: " + xmlreq2.statusText;
			}
		}
	};
	
	xmlreq2.send(null);
	
	xmlreq3.open("GET", "./_app/control/AtendimentoDash.php?Q=3&Cart=" + nome, true);

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq3.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq3.readyState == 4) {

			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq3.status == 200) {
				var TxOp = JSON.parse(xmlreq3.responseText);
				
				/* Grafico Operador */
				am4core.ready(function() {

					// Themes begin
					// am4core.useTheme(am4themes_material);
					// am4core.useTheme(am4themes_animated);
					// Themes end

					// Create chart instance
					var chart = am4core.create("Operador", am4charts.SlicedChart);

					// Add and configure Series
					var series = chart.series.push(new am4charts.FunnelSeries());
					series.colors.step = 2;
					series.dataFields.value = "Qtd";
					series.dataFields.category = "Ocorrencia";
					series.alignLabels = true;
					
					series.labelsContainer.paddingLeft = 15;
					// series.labelsContainer.width = 200;

					chart.data = TxOp;

				});

				
				result.innerHTML = "";
			}else{
				result.innerHTML = "Erro: " + xmlreq3.statusText;
			}
		}
	};
	xmlreq3.send(null);
	
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