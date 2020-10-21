//VER 2.5
$(document).ready(function() {
	aplicaDataTable();
});

$(document).on("blur", "#div_campos .eventovalor", function() {
	
	valorTotal = new BigNumber(0);

	for (i = 1; i < 9; i++) {
		valorEvento = $("#eventotipo_" + i).val();
		valorEvento = valorEvento.replaceAll('R$','');
		valorEvento = valorEvento.replaceAll('.','');
		valorEvento = valorEvento.replaceAll(',','.');
		valorTotal = new BigNumber(valorTotal.add(valorEvento));
	}

	console.log("total");
	console.log(valorTotal);
	console.log(valorTotal.toString());	
	
	$("#TotalEventos").val(parseFloat(valorTotal.toString()).toFixed(2));

	maskFormBr();
});

$(document).on("blur", "#eventotipo_3", function() {
	
	somaJurosTaxaRisco();

});

$(document).on("blur", "#eventotipo_4", function() {
	
	somaJurosTaxaRisco();

});


function somaJurosTaxaRisco(){

	somaJTR = new BigNumber(0);

	valorJuros = $("#eventotipo_3").val();
	valorJuros = valorJuros.replaceAll('R$','');
	valorJuros = valorJuros.replaceAll('.','');
 	valorJuros = valorJuros.replaceAll(',','.');

	valorTaxaRisco = $("#eventotipo_4").val();
	valorTaxaRisco = valorTaxaRisco.replaceAll('R$','');
	valorTaxaRisco = valorTaxaRisco.replaceAll('.','');
	valorTaxaRisco = valorTaxaRisco.replaceAll(',','.');

  	somaJTR = new BigNumber(somaJTR.add(valorJuros));
  	somaJTR = new BigNumber(somaJTR.add(valorTaxaRisco)); 
	
	$("#TotalJurosTaxaRisco").val(parseFloat(somaJTR.toString()).toFixed(2));

	maskFormBr();

}

function aplicaDataTableSaldos(){
	
	$('table#lista_ativos_saldos').dataTable({
			"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 0 ] }, 
			{ "sType": "money-br", "aTargets": [ 1 ] },
			{ "sType": "money-br", "aTargets": [ 2 ] },
			{ "orderable": false, "aTargets": [3] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "150px"
	});
}

function aplicaDataTable(){
	$('table#listaAtivosEventos').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 2 ] }, 
			{ "sType": "money-br", "aTargets": [ 3 ] },
			{ "sType": "money-br", "aTargets": [ 4 ] },
			{ "sType": "money-br", "aTargets": [ 5 ] },
			{ "sType": "money-br", "aTargets": [ 6] },
			{ "orderable": false, "aTargets": [7] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

function applicaDataTableTransacoesForm(){
    $('table#lista_transacoes').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"order": [[ 0, 'desc' ]],
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [0] }, 			
			{ "sType": "money-br", "aTargets": [1] },
			{ "sType": "money-br", "aTargets": [2] },
			{ "orderable": false, "aTargets": [3] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "150px"
	});
}

$(document).off("click", "#listaAtivosEventos td a.visualizarAtivo");
$(document).on("click", "#listaAtivosEventos td a.visualizarAtivo", function() {
	var AtivoID  = $(this).closest("tr").data("ativoid");
	consultarAtivo(AtivoID);
});

$(document).off("click", "table#listaAtivosEventos tbody tr td a.ativo-transacoes");
$(document).on("click", "table#listaAtivosEventos tbody tr td a.ativo-transacoes", function() {
	var AtivoID = $(this).closest("tr").data('ativoid');
	editarTransacoesForm(AtivoID);
});

$(document).off("click", "table#listaAtivosEventos tbody tr td a.visualizar");
$(document).on("click", "table#listaAtivosEventos tbody tr td a.visualizar", function() {
	var AtivoID = $(this).closest("tr").data('ativoid');
	listarTransacoesForView(AtivoID);
});

$(document).off("click", "table#listaAtivosEventos tbody tr td a.ativo-saldo");
$(document).on("click", "table#listaAtivosEventos tbody tr td a.ativo-saldo", function() {
	var AtivoID = $(this).closest("tr").data('ativoid');
	editarSaldo(AtivoID);
});

function listarTransacoesForTable(ativoID){
	$.ajax({
		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "LISTAR_TRANSACOES_PARA_TABELA",
			"AtivoID" : ativoID
		},
		dataType : "html",
		success : function(lista) {
			$("#spanListaTransacoes").html(lista);
			applicaDataTableTransacoesForm()
		},
		error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO ativos.eventos.js listarTransacoesForTable:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});
}

function listarTransacoesForView(AtivoID){
	$.ajax({
		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "LISTAR_TRANSACOES_PARA_VISUALIZAR",
			"AtivoID" : AtivoID
		},
		dataType : "html",
		success : function(form) {
			$("#spanFormTrasacoes").html(form);
			$("#dialog-ativos-transacoes-view").modal('show');
		},
		error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO ativos.eventos.js listarTransacoesForView:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});
}

function editarTransacoesForm(AtivoID){

	$.ajax({
		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "EDITAR_TRANSACOES",
			"AtivoID" : AtivoID
		},
		dataType : "html",
		success : function(form) {
			$("#spanFormTrasacoes").html(form);
			$("#dialog-ativos-transacoes").modal('show');
		},
		error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativos.eventos.js editarTransacoesForm:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});
}

function salvarEventos(){

	var form = $('#dialog-ativos-eventos form');

	if($(form).valid()){
		maskFormUn(2,4);
		$.ajax({
			url: app_path + "/controllers/ativos.eventos.controller.php",
			data: "ac=SALVAR_EVENTOS&" + form.serialize(),
			dataType: "json",
			success: function(data) {
				$("#dialog-ativos-eventos div .control-group").removeClass("error");
			   if (data.resultado == true) {
					$("#TransacaoID").val(data.transacaoid);
					$("#TotalEventos").val(data.totaleventos);
					$("#TotalJurosTaxaRisco").val(data.totaljurosrisco);
					$("#dialog-ativos-eventos #totaisEventos").show();
					$("#dialog-ativos-eventos").modal('hide');
					listarTransacoesForTable($("#AtivoID").val());
					success_message(data.mensagem);
				} else {

					if (data.erroID == "ERRO_DATA_INFERIOR"){
						$("#dialog-ativos-eventos #AtivoDataEmissao").closest("div.control-group").addClass("error");
						$("#dialog-ativos-eventos #dpTransacaoData").addClass("error");
					}

					if (data.erroID == "ERRO_DATA_SUPERIOR"){
						$("#dialog-ativos-eventos #AtivoDataVencimento").closest("div.control-group").addClass("error");
						$("#dialog-ativos-eventos #dpTransacaoData").addClass("error");
					}

					if (data.erroID == "ERRO_DATA_TRANSACAO"){
						$("#dialog-ativos-eventos #dpTransacaoData").addClass("error");
					}

					if (data.erroID == "TOTAL_EVENTOS_ZERADOS"){
						$("#dialog-ativos-eventos .input-eventos").addClass("error");
					}

					error_message(data.mensagem);
					console.log(data.mensagem + "\r\n" + data.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				bootbox.alert("ERRO ativos.cri.eventos.js salvarEventos() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
				xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
			}
		});
		maskFormBr(2,4); 
	}
}

function excluirEventos(TransacaoID){

	$.ajax({

		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "EXCLUIR_TRANSACAO",
			"TransacaoID" : TransacaoID
		},
		dataType: "json",
		success: function(data) {
		    if (data.resultado == true) {
				listarTransacoesForTable($("#AtivoID").val());
				success_message(data.mensagem);
			} else {
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO ativos.cri.eventos.js excluirEventos() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
		}

	});

}

function editarEventos(AtivoID, TransacaoID) {
	$.ajax({
		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "EDITAR_EVENTOS",
			"AtivoID" : AtivoID,
			"TransacaoID" : TransacaoID
		},
		dataType : "html",
		success : function(form) {
			$("#spanForm").html(form);
			$("#dialog-ativos-eventos .btn-salvar").off("click").on("click", function(){
				salvarEventos();
			});
			$("#dialog-ativos-eventos").modal('show');
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativos.eventos.js editarEventos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}

function editarSaldo(AtivoID) {

	$.ajax({
		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "EDITAR_SALDO",
			"AtivoID" : AtivoID
		},
		dataType : "html",
		success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$("#dialog-manut-ativos-saldos #btn_salvar").hide();
				$('#dialog-manut-ativos-saldos #btn_salvar').on('click', function(){
					if ($('#camposSaldos').is(':visible')) salvarSaldos();
				});
				$('.btn_cancelar').on('click', function(){
					if ($('#camposSaldos').is(':visible')){
						$("#dialog-manut-ativos-saldos #btn_cancelar").text("Sair");
						$("#dialog-manut-ativos-saldos #btn_salvar").hide();
						$("#camposSaldos").hide('slow');
						$('#camposSaldos input').val('');
						$("#div_lista_ativos_saldos").show('slow');
					}else{
						$("#dialog-manut-ativos-saldos").modal('hide');
					}
				});

				$(document).off("click", '#dialog-manut-ativos-saldos .btn_novo_saldo');
				$(document).on("click", '#dialog-manut-ativos-saldos .btn_novo_saldo', function(){
					$("#camposSaldos").show("slow");
					$("#dialog-manut-ativos-saldos #btn_cancelar").text("Cancelar");
					$("#dialog-manut-ativos-saldos #btn_salvar").show();
					$("#div_lista_ativos_saldos").hide('slow');
				});

				$(document).off("click", "#lista_ativos_saldos .editar");
				$(document).on("click", "#lista_ativos_saldos .editar", function() {
					tr=$(this).closest('tr');
					$("#div_lista_ativos_saldos").hide('slow');
					$("#dialog-manut-ativos-saldos #btn_cancelar").text("Cancelar");
					$("#dialog-manut-ativos-saldos #btn_salvar").show();
					$('#SaldoData').val($(tr).find('.saldo_data').text());
					$('#SaldoValor').val($(tr).find('.saldo_valor').text());
					$('#ProvisaoTaxaRisco').val($(tr).find('.provisao_taxa_risco').text());
					$('#SaldoID').val($(tr).data('saldoid'));
					$("#camposSaldos").show("slow");

				});
				$(document).off("click", "#lista_ativos_saldos .excluir");
				$(document).on("click", "#lista_ativos_saldos .excluir", function() {
					var SaldoID = $(this).closest("tr").data('saldoid');
					bootbox.confirm("Tem certeza que deseja apagar o saldo cadastrado?", 
					 function(confirmou) { 
					    if (confirmou) {
					      excluirSaldo(SaldoID);//excluirSaldo
					    }
					});
				});
			
				$("#dialog-manut-ativos-saldos").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativo.js editarSaldo():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function salvarSaldos(){

	var form = $('#dialog-manut-ativos-saldos form');
	SaldoID         = $(form).find("input[name=SaldoID]").val();
	AtivoID         = $(form).find("input[name=AtivoID]").val();
	SaldoData  		= $(form).find("input[name=SaldoData]").val();
	SaldoValor		= $(form).find("input[name=SaldoValor]").val();

	maskMoedaUn(2);

	if ($(form).valid()){

	 	$.ajax({

			url: app_path + "/controllers/ativos.eventos.controller.php",
			data: "ac=SALVAR_SALDO&" + form.serialize(),
			dataType: "json",

			success: function(dados) {

 				if (dados.resultado == true) {
						
						atualizarListaSaldos(AtivoID);
						$("#camposSaldos").hide('slow');
						$("#dialog-manut-ativos-saldos #btn_cancelar").text("Sair");
						$('#camposSaldos input').val('');
						$("#div_lista_ativos_saldos").show();
						$("#dialog-manut-ativos-saldos #btn_salvar").hide();
			 			success_message(dados.mensagem);

			 	}else{

			 			error_message(dados.mensagem);
			 			console.log(dados.mensagem + "\r\n"
			 					+ dados.exception);
			 	}

			 },

			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js salvarSaldo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
				xhr.status + " - " + thrownError + ")");
			}
		});

	}

	maskMoedaBR(2);

}

function excluirSaldo(SaldoID) {

	AtivoID = $("#dialog-manut-ativos-saldos form").find("input[name=AtivoID]").val();
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.eventos.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_SALDO",
	 			"SaldoID": SaldoID
	 		},
	 		dataType: "json",
	 		success: function(json) {
				if (json.resultado == true) {
					atualizarListaSaldos(AtivoID);
					success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js excluirSaldo:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function atualizarListaSaldos(AtivoID){
		
	$.ajax({
		url: app_path + "/controllers/ativos.eventos.controller.php",
		data : {
			"ac" : "LISTAR_SALDOS_CRI",
			"AtivoID": AtivoID
		},
		dataType : "html",
		success : function(lista) {
			$('#spanListaConteudo').html(lista);
			aplicaDataTableSaldos();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.cri.eventos.js atualizarListaSaldos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}