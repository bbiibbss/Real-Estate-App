$(function(){
	$.ajax({
		url: 'http://localhost/PWII-PROJECT/php/chart_data.php',
		type: 'GET',
		success : function(data) {
			chartData = data;
			var chartProperties = {
				"caption": "Lucros Totais de Vendas em 2017",
				"xAxisName": "Meses",
				"yAxisName": "Lucro",
				"rotatevalues": "1",
				"theme": "ocean"
			};
			apiChart = new FusionCharts({
	        type: 'column2d',
	        renderAt: 'chart-container',
	        width: '100%',
	        height: '60%',
	        dataFormat: 'json',
	        dataSource: {
	        	"chart": chartProperties,
	        	"data": chartData
	        }
		});
		apiChart.render();
	    }
	});
});

$(function(){
	$.ajax({
		url: 'http://localhost/PWII-PROJECT/php/chart_data_year.php',
		type: 'GET',
		success : function(data) {
			chartData = data;
			var chartProperties = {
				"caption": "Lucros Totais de Vendas por Ano",
				"xAxisName": "Anos",
				"yAxisName": "Lucro",
				"rotatevalues": "1",
				"theme": "ocean"
			};
			apiChart = new FusionCharts({
	        type: 'column2d',
	        renderAt: 'chart-container1',
	        width: '100%',
	        height: '60%',
	        dataFormat: 'json',
	        dataSource: {
	        	"chart": chartProperties,
	        	"data": chartData
	        }
		});
		apiChart.render();
	    }
	});
});