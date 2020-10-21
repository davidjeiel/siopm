//Versao 2.0

$(document).ready(function() {
    aplicaDataTableAtivos();  
});

function aplicaDataTableAtivos(){
	
  $('.conteudo-ativos table#lista_ativos').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
		    { "sType": "date-br", "aTargets": [ 5 ] }, 
      		{ "sType": "money-br", "aTargets": [ 6 ] },
			{ "orderable": false, "aTargets": [8] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

$(document).off("click", '.btn_visualizarProposta');
$(document).on("click", '.btn_visualizarProposta', function() {		
     $("#dialog-manut-ativo-view").modal('hide');
     var PropostaDetalheID  = $("#PropostaDetalheID").val();
     visualizarProposta(PropostaDetalheID);
});

$(document).off("click", "#lista_ativos td a.visualizar");
$(document).on("click", "#lista_ativos td a.visualizar", function() {	
     var AtivoID  = $(this).closest("tr").data("ativoid");
     consultarAtivo(AtivoID);
});

$(document).off("click", "table#lista_arquivos_ativos tbody tr td a.visualizar");
$(document).on("click", "table#lista_arquivos_ativos tbody tr td a.visualizar", function() {
	var ArquivoID = $(this).closest("tr").data('arquivoid');	
	window.open( app_path + "/controllers/ativos.arquivos.controller.php" + "?ac=download&ArquivoID=" + ArquivoID );	
});

$(document).off("click", "#lista_ativos td a.dados-gerais");
$(document).on("click", "#lista_ativos td a.dados-gerais", function() {	
	 var AtivoID  = $(this).closest("tr").data("ativoid");	
	 editarAtivoDadosBasicos(AtivoID);
});

$(document).off("click", "#lista_ativos td a.juros");
$(document).on("click", "#lista_ativos td a.juros", function() {
	var AtivoID  = $(this).closest("tr").data("ativoid");	
    editarAtivoJuros(AtivoID);
});

$(document).off("click", "#lista_ativos td a.subscricao");
$(document).on("click", "#lista_ativos td a.subscricao", function() { 
	var AtivoID  = $(this).closest("tr").data("ativoid");
	editarAtivoSubscricoes(AtivoID);  
});

$(document).off("click", "#lista_ativos td a.entidades");
$(document).on("click", "#lista_ativos td a.entidades", function() {
	var AtivoID  = $(this).closest("tr").data("ativoid");	
    editarAtivoEntidade(AtivoID);
});

$(document).off("click", "#lista_ativos td a.arquivos");
$(document).on("click", "#lista_ativos td a.arquivos", function() {
	var AtivoID  = $(this).closest("tr").data("ativoid");
	editarArquivos(AtivoID);    
});

$(document).off("click", "#lista_ativos td a.finalizar");
$(document).on("click", "#lista_ativos td a.finalizar", function() {
	var AtivoID  = $(this).closest("tr").data("ativoid");
	editarFinalizarAtivo(AtivoID);    
});

$(document).off("click", "#lista_ativos td a.excluir");
$(document).on("click", "#lista_ativos td a.excluir", function() {
	var AtivoID  = $(this).closest("tr").data("ativoid");
    bootbox.confirm("Tem certeza que deseja excluir o ativo financeiro?", 
      function(confirmou) { 
      if (confirmou) {      
        excluirAtivo(AtivoID);;
      }
    });
});	

function visualizarProposta(PropostaDetalheID){

	 $.ajax({

		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "VISUALIZAR_PROPOSTA",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$("#dialog-visualizar-propostas").modal('show');
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  proposta.cri.js editarArquivos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});

}

function consultarAtivo(AtivoID){

	$.ajax(
		{
			url: app_path + "/controllers/ativos.controller.php",
			data: {
				"ac": "VISUALIZAR_DADOS_CADASTRADOS",
				"AtivoID": AtivoID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanFormAuxiliar').html(form_retorno);
				$("#dialog-manut-ativo-view form :input").attr("disabled", "disabled");				
				$("#dialog-manut-ativo-view").modal('show');
				
				$(document).off("click", "#lista_subscricoes .visualizar");
				$(document).on("click", "#lista_subscricoes .visualizar", function() {
					visualizarIntegralizacoes($(this).closest("tr").data('subscricaoid'));
				});

			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js consultarAtivo():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarAtivoDadosBasicos(AtivoID) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.dados.basicos.controller.php",
			data: {
				"ac": "EDITAR_ATIVO_DADOS_GERAIS",
				"AtivoID": AtivoID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$(document).off("click", '#dialog-manut-ativo-dados-basicos #btn_salvar');
				$(document).on("click", '#dialog-manut-ativo-dados-basicos #btn_salvar', function() {				
					salvarDadosBasicos();
				});
				$("#dialog-manut-ativo-dados-basicos").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js editarAtivoDadosBasicos():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarAtivoJuros(AtivoID) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.juros.controller.php",
			data: {
				"ac": "EDITAR_ATIVO_JUROS",
				"AtivoID": AtivoID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$("#dialog-manut-ativo-juros #btn_salvar").hide();
				$('#dialog-manut-ativo-juros #btn_salvar').on('click', function(){
					if ($('#camposjuros').is(':visible')) salvarJuros();
				});
				$('.btn_cancelar').on('click', function(){
					if ($('#camposjuros').is(':visible')){
						$("#dialog-manut-ativo-juros #btn_cancelar").text("Sair");
						$("#camposjuros").hide('slow');
						$("#dialog-manut-ativo-juros #btn_salvar").hide();						
						$('#camposjuros input').val('');
						$("#div_lista_ativos_juros").show('slow');
					}else{
						$("#dialog-manut-ativo-juros").modal('hide');
					}
				});

				$('.btn_novo_juro').on('click', function(){					
					$("#camposjuros").show("slow");
					$("#dialog-manut-ativo-juros #btn_cancelar").text("Cancelar");
					$("#dialog-manut-ativo-juros #btn_salvar").show();
					$("#div_lista_ativos_juros").hide('slow');
				});

				$(document).on("click", "#lista_ativos_juros .editar", function() {
					tr=$(this).closest('tr');										
					$("#div_lista_ativos_juros").hide('slow');
					$("#dialog-manut-ativo-juros #btn_cancelar").text("Cancelar");
					$('#JurosDataInicialVigencia').val($(tr).find('.data_inicial').text());
					$('#JurosDataFinalVigencia').val($(tr).find('.data_final').text());
					$('#JurosTaxaNominal').val($(tr).find('.taxa_nominal').text());
					$('#JurosTaxaEfetiva').val($(tr).find('.taxa_efetiva').text());
					$('#JurosID').val($(this).closest("tr").data('jurosid'));
					$("#camposjuros").show("slow");
					$("#dialog-manut-ativo-juros #btn_salvar").show();

				});
				$(document).off("click", "#lista_ativos_juros .excluir");
				$(document).on("click", "#lista_ativos_juros .excluir", function() {
					var JurosID = $(this).closest("tr").data('jurosid');
					$("#dialog-manut-ativo-juros").css("opacity" , 0.33);					
					bootbox.confirm("Tem certeza que deseja apagar a taxa de juros cadastrada?", 
					 function(confirmou) { 
					    if (confirmou) {
					      excluirJuros(JurosID);
					    }
					   	$("#dialog-manut-ativo-juros").css("opacity" , 1);
					});
				});		 
				
				$("#dialog-manut-ativo-juros").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativo.js editarAtivoJuros():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarAtivoSubscricoes(AtivoID) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.subscricoes.controller.php",
			data: {
				"ac": "EDITAR_ATIVO_SUBSCRICAO",
				"AtivoID": AtivoID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanFormAuxiliar').html(form_retorno);
				$("#dialog-manut-subscricoes #btn_salvar").hide();
				$('#dialog-manut-subscricoes #btn_salvar').on('click', function(){
					if ($('#campossubscricoes').is(':visible')) salvarSubscricao();
				});
				$('.btn_cancelar').on('click', function(){
					if ($('#campossubscricoes').is(':visible')){
						$("#campossubscricoes").hide('slow');
						$("#dialog-manut-subscricoes #btn_cancelar").text("Sair");
						$("#dialog-manut-subscricoes #btn_salvar").hide();						
						$('#campossubscricoes input').val('');
						$("#div_lista_subscricoes").show('slow');
					}else{
						$("#dialog-manut-subscricoes").modal('hide');
					}
				});

				$('.btn_novo_subscricao').on('click', function(){					
					$("#campossubscricoes").show("slow");
					$("#dialog-manut-subscricoes #btn_cancelar").text("Cancelar");
					$("#btn_salvar").show();
					$("#div_lista_subscricoes").hide('slow');
				});	
				
				$(document).off("click", "#lista_subscricoes .editar");
				$(document).on("click", "#lista_subscricoes .editar", function() {
					tr=$(this).closest('tr');										
					$("#div_lista_subscricoes").hide('slow');
					$("#dialog-manut-subscricoes #btn_cancelar").text("Cancelar");					
					$('#SubscricoesData').val($(tr).find('.datasubscricao').text());
					$('#SubscricoesQuantidade').val($(tr).find('.quantidade').text());
					$('#SubscricoesValorUnitario').val($(tr).find('.valorunitario').text());
					$('#SubscricoesVolume').val($(tr).find('.volume').text());
					$('#SubscricoesID').val($(tr).data('subscricaoid'));
					$("#campossubscricoes").show("slow");
					$("#dialog-manut-subscricoes #btn_salvar").show();
				});

				$(document).off("click", "#lista_subscricoes .excluir");
				$(document).on("click", "#lista_subscricoes .excluir", function() { 
					var subscricaoID = $(this).closest("tr").data('subscricaoid');
					$("#dialog-manut-subscricoes").css("opacity" , 0.33);
					bootbox.confirm("Tem certeza que deseja apagar a Subscricao cadastrada?", 
					 function(confirmou) { 
					    if (confirmou) {
					      excluirSubscricao(subscricaoID);
					    }
					$("#dialog-manut-subscricoes").css("opacity" , 1);
					});
				});					 
			
				$("#dialog-manut-subscricoes").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.subscricoes.js editarAtivoSubscricoes():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarAtivoEntidade(AtivoID) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.entidades.controller.php",
			data: {
				"ac": "EDITAR_ATIVO_ENTIDADE",
				"AtivoID": AtivoID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$('#dialog-manut-ativo-entidades #btn_salvar').on('click', function(){					
					if ($('#camposentidades').is(':visible')) salvarEntidade();					
				});
				$('.btn_cancelar').on('click', function(){
					if ($('#camposentidades').is(':visible')){
						$("#camposentidades").hide('slow');
						$("#dialog-manut-ativo-entidades #btn_cancelar").text("Sair");							
						$('#camposentidades option[value=""]').prop("selected", true);		
						$("#dialog-manut-ativo-entidades #btn_salvar").hide();						
						$('#camposentidades input').val('');
						$("#div_lista_ativos_entidades").show('slow');
					}else{
						$("#dialog-manut-ativo-entidades").modal('hide');
					}
				});

				$('.btn_novo_entidade').on('click', function(){					
					$("#camposentidades").show("slow");
					$("#dialog-manut-ativo-entidades #btn_cancelar").text("Cancelar");
					$("#dialog-manut-ativo-entidades #btn_salvar").show();
					$("#div_lista_ativos_entidades").hide('slow');
				});

				$(document).on("click", "#lista_ativos_entidades .editar", function() {
					tr=$(this).closest('tr');										
					$("#div_lista_ativos_entidades").hide('slow');	
					$("#dialog-manut-ativo-entidades #btn_cancelar").text("Cancelar");				
					$('#EntidadeID option[value='+ $(tr).data('entidadeid')+']').prop("selected", true);					
					$('#EntidadePapelID option[value='+ $(tr).data('entidadepapelid')+']').prop("selected", true);
					$('#AtivoEntidadeID').val($(tr).data('ativoentidadeid'));
					$("#camposentidades").show("slow");
					$("#dialog-manut-ativo-entidades #btn_salvar").show();
				});
				$(document).off("click", "#lista_ativos_entidades .excluir");
				$(document).on("click", "#lista_ativos_entidades .excluir", function(){
					var AtivoEntidadeID = $(this).closest("tr").data('ativoentidadeid');
					$("#dialog-manut-ativo-entidades").css("opacity" , 0.33);
					bootbox.confirm("Tem certeza que deseja apagar a entidade vinculada?", 
					 function(confirmou) { 
					    if (confirmou) {
					     excluirEntidade(AtivoEntidadeID);
					    }
					    $("#dialog-manut-ativo-entidades").css("opacity" , 1);
					});
				});					 
			
				$("#dialog-manut-ativo-entidades").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativo.js editarAtivoEntidade():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarFinalizarAtivo(AtivoID) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.finalizar.controller.php",
			data: {
				"ac": "FINALIZAR_ATIVO",
				"AtivoID": AtivoID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanFormAuxiliar').html(form_retorno);
				$('#dialog-manut-ativo-finalizar #btn_finalizar').off('click').on('click', function(){
					salvarFinalizacao();
				});
				$("#dialog-manut-ativo-finalizar").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js finalizarAtivo():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarArquivos(AtivoID){

	$.ajax({

		url: app_path + "/controllers/ativos.controller.php",
		data : {
			"ac" : "arquivos",
			"AtivoID" : AtivoID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$("#dialog-arquivos-upload").modal('show');
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.js editarArquivos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});

}

function excluirAtivo(AtivoID) {
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ATIVO",
	 			"AtivoID": AtivoID
	 		},
	 		dataType: "json",
	 		success: function(json) {
				if (json.resultado == true) {
					atualizarListaAtivo();
					success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js excluirEntidade:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
	
}

function atualizarListaAtivo(){
		
	$.ajax({
		url: app_path + "/controllers/ativos.controller.php",
		data : {
			"ac" : "LISTAR_ATIVOS_ATUALIZACAO",
		},
		dataType : "html",
		success : function(lista) {
			$('#spanConteudo').html(lista);			
			aplicaDataTableAtivos();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO ativo.js atualizarListaAtivo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
	
}

function visualizarIntegralizacoes(SubscricoesID) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.integralizacoes.controller.php",
			data: {
				"ac": "EDITAR_ATIVO_INTEGRALIZACAO",
				"SubscricoesID": SubscricoesID
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$('#dialog-manut-integralizacoes #btn_salvar').hide();
				$('#lista_integralizacoes .editar').hide();
				$('#lista_integralizacoes .excluir').hide();
				$('.btn_novo_integralizacao').hide();
				$("#dialog-manut-integralizacoes form :input").attr("disabled", "disabled");				
				$('.btn_cancelar').on('click', function(){
					$("#dialog-manut-integralizacoes").modal('hide');
				});

				$("#dialog-manut-integralizacoes").modal('show');

			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativo.js visualizarIntegralizacoes:\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}
