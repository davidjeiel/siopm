$(function() {

	var dataGer = [ ["2010", 17.48], ["2011", 18.45], ["2012", 23.30], ["2013", 29.13], ["2014", 12.65] ];
	var dataCri = [ ["CRI00001", 5.26], ["CRI00002", 10.53], ["CRI00003", 10.53], ["CRI00004", 21.05], ["CRI00005", 21.05], ["CRI00006", 15.79], ["CRI00007", 15.79] ];
	var dataSec = [ ["Cibrasec", 47.37], ["Brazilian Securities", 15.79], ["Gaiasec", 36.84] ];
	var dataCed = [ ["Caixa", 47.37], ["Itaú Unibanco", 21.05], ["Banco do Brasil", 21.05], ["Banrisul", 10.53] ];

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