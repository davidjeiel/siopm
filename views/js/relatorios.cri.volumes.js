$(function() {

	var dataGer = [ ["2010", 6.49], ["2011", 20.54], ["2012", 26.49], ["2013", 27.03], ["2014", 19.46] ];
	var dataCri = [ ["CRI00004", 31.58], ["CRI00005", 15.79], ["CRI00006", 26.32], ["CRI00007", 26.32] ];
	var dataSec = [ ["Cibrasec", 47.37], ["Brazilian Securities", 26.32], ["Gaiasec", 26.32] ];
	var dataCed = [ ["Caixa", 31.58], ["Itaú Unibanco", 26.32], ["Banco do Brasil", 26.32], ["Banrisul", 15.79] ];

	$('#aTabGeralTabGrafico').on('shown.bs.tab', function() {
		drawChart('#grafico-1', dataGer);
	});

	$('#aTabCriTabGrafico').on('shown.bs.tab', function() {
		drawChart('#grafico-2', dataCri);
	});

	$('#aTabSecTabGrafico').on('shown.bs.tab', function() {
		drawChart('#grafico-3', dataSec);
	});

	$('#aTabCedTabGrafico').on('shown.bs.tab', function() {
		drawChart('#grafico-4', dataCed);
	});

});

function drawChart(id, data) {
	$.plot(id, [ data ], {
		label: "Test Label",
		series: {
			bars: {
				show: true,
				barWidth: 0.6,
				align: "center"
			}
		},
		xaxis: {
			mode: "categories",
			tickLength: 0
		}
	});
}