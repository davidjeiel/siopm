/*
 * Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
 * Em 24/04/2013
 * Para GIFUG/SP
 * Adaptado para o SIOPM por Hugo Alves Richard, c075530, em 28/02/2014
 */
$(document).ready(function() {
	aplicaDataTableOrcamentos();
});

$(document).off("click", "#lista_orcamentos td a.excluir");
$(document).on("click", "#lista_orcamentos td a.excluir", function() {
	var orcamentoid  = $(this).closest("tr").data('orcamentoid');
	var orcamentoano = $(this).closest("tr").data('orcamentoano');
	
	bootbox.confirm("Tem certeza que deseja apagar o orçamento de "+orcamentoano+"?", function(confirmou) {
		if (confirmou) {
			excluirOrcamento(orcamentoid);
		}
	});
});

/*
* http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
*/
$(document).on("click", '.btn_novo', function() {
	editarOrcamento(0);
});

/*
* http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
* Adaptado por Alan Lima Em 17/06/2013
*/

$(document).off("click", "#lista_orcamentos td a.editar");
$(document).on("click", "#lista_orcamentos td a.editar", function() {
	var orcamentoid = $(this).closest("tr").data('orcamentoid');
	editarOrcamento(orcamentoid);
});

$(document).off("click", "#lista_orcamentos td a.detalhes");
$(document).on("click", "#lista_orcamentos td a.detalhes", function() {
	var valorAplicado = $(this).closest("tr").data('totalsubscricao');
	var valorSaldo = $(this).closest("tr").data('saldoorcamento');
	var orcamentoid = $(this).closest("tr").data('orcamentoid');
	visualizarValorAplicado(orcamentoid, valorAplicado, valorSaldo);
});

function aplicaDataTableOrcamentos(){
	$('table#lista_orcamentos').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 2 ] }, 
			{ "sType": "date-br", "aTargets": [ 3 ] }, 
			{ "sType": "money-br", "aTargets": [ 4 ] },
			{ "sType": "money-br", "aTargets": [ 5 ] },
			{ "sType": "money-br", "aTargets": [ 6 ] },
			{ "orderable": false, "aTargets": [ 7 ] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

function aplicaDataTable(){
	$('table#lista_subscricoes').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 2 ] }, 
			{ "sType": "money-br", "aTargets": [ 3 ] },
			{ "sType": "money-br", "aTargets": [ 4 ] },
			{ "sType": "money-br", "aTargets": [ 5 ] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		"bPaginate": false,
		"sScrollY": "250px"
	});
}

function visualizarValorAplicado(orcamentoid, valorAplicado, valorSaldo){
	
	 $.ajax({
		url: app_path + "/controllers/orcamentos.controller.php",
		data : {
			"ac" : "VISUALIZAR_VALOR_APLICADO",
			"OrcamentoID" : orcamentoid
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$('#Aplicado').val(valorAplicado);
			$('#Saldo').val(valorSaldo);
			$("#dialog-manut-orcamento-valor-aplicado").modal('show');
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  orcamento.js visualizarValorAplicado:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});

}

function editarOrcamento(orcamentoid) {

	$.ajax(
		{
			url: app_path + "/controllers/orcamentos.controller.php",
			data: {
				"ac": "EDITAR_ORCAMENTO",
				"OrcamentoID": orcamentoid
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$('#btn_salvar').on('click', function(){
					salvarAlteracoesOrcamento();
				});
				$("#dialog-manut-orcamento").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO instrumentos.js editarOrcamento():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

/*
 * Escrito por Alan Ferreira de Lima Filho
 * c066868 Em 17/06/2013
 * Posta para o Controller
 */

function excluirOrcamento(orcamentoid) {
	
	$.ajax(
		{
			url: app_path + "/controllers/orcamentos.controller.php",
			data: {
				"ac": "EXCLUIR_ORCAMENTO",
				"OrcamentoID": orcamentoid
			},
			dataType: "json",
			success: function(json) {
				if (json.resultado == true) {
					 tr = $("table#lista_orcamentos tbody tr.orcamento_" + orcamentoid ).get(0);
					 pos = $("table#lista_orcamentos").dataTable().fnGetPosition(tr);
					 $("table#lista_orcamentos").dataTable().fnDeleteRow(pos);
					 success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO instrumentos.js excluirOrcamento:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}

function salvarAlteracoesOrcamento(){

	var form = $('#dialog-manut-orcamento form');

	if ($(form).valid()){

		maskFormUn();

		$(".campo-formatado").each(function( index ){
            if ( $(this).val() == "" || $(this).val() == null ) $(this).val("0");
        });

		$.ajax({

		  url: app_path + "/controllers/orcamentos.controller.php",
		  data: "ac=SALVAR_ORCAMENTO&" + form.serialize(),
		  dataType: "json",

		  success: function(dados) {

			if (dados.resultado == true) {	 				
                atualizarListaOrcamentos();
				$("#dialog-manut-orcamento").modal('hide');
				success_message(dados.mensagem);

			} else {

				error_message(dados.mensagem);
				console.log(dados.mensagem + "\r\n"
						+ dados.exception);
			}

		  },
		  error: function(xhr, ajaxOptions, thrownError) {
			error_message("ERRO orcamentos.js salvarAlteracoesOrcamento:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			  xhr.status + " - " + thrownError + ")");
		  }
		});

		maskFormBr();

	}// Validação de Usuário

}


function atualizarListaOrcamentos(){
		
	$.ajax({
		url: app_path + "/controllers/orcamentos.controller.php",
		data : {
			"ac" : "LISTAR_ORCAMENTOS_ATUALIZACAO",
		},
		dataType : "html",
		success : function(lista) {
			$('#spanConteudo').html(lista);			
			aplicaDataTableOrcamentos();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO orcamentos.js atualizarListaAtivo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
	
}