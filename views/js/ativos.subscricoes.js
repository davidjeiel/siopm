
//VER 2.0

//funções do formulário do Ativo

function aplicaDataTableSubscricoes(){
	
	$('table#lista_subscricoes').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
					{ "sType": "date-br", "aTargets": [ 0 ] }, 
					{ "sType": "money-br", "aTargets": [ 1 ] },
					{ "sType": "money-br", "aTargets": [ 2 ] },
					{ "sType": "money-br", "aTargets": [ 3 ] },
					{ "orderable": false, "aTargets": [4] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		"bPaginate": false,
		"sScrollY": "150px"
	});
}


function excluirSubscricao(subscricoesID) {

	AtivoID = $("#dialog-manut-subscricoes form").find("input[name=AtivoID]").val();
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.subscricoes.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ATIVO_INTEGRALIZACAO",
	 			"SubscricoesID": subscricoesID
	 		},
	 		dataType: "json",
	 		success: function(dados) {
				if (dados.resultado == true) {
					atualizarListaSubscricoes(AtivoID);
					atualizarListaAtivo();
					success_message(dados.mensagem);
				} else {
					error_message(dados.mensagem);
					console.log(dados.mensagem + "\r\n" + dados.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.subscricaoes.js excluirSubscricao:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function salvarSubscricao(){

	var form = $('#dialog-manut-subscricoes form');
	
    AtivoID         			= $(form).find("input[name=AtivoID]").val();
	maskMoedaUn(8); 	
	maskNumeroUm(8); 

	if ($(form).valid()){

	 	$.ajax({

	 	  url: app_path + "/controllers/ativos.subscricoes.controller.php",
	 	  data: "ac=SALVAR_ATIVO_SUBSCRICAO&" + form.serialize(),
	 	  dataType: "json",

	 	  success: function(dados) {

	 		if (dados.resultado == true) {

     			atualizarListaSubscricoes(AtivoID);
                $("#campossubscricoes").hide('slow');
                $("#dialog-manut-subscricoes #btn_cancelar").text("Sair");
				$('#campossubscricoes input').val('');					
				$("#div_lista_subscricoes").show();
	 			$("#dialog-manut-subscricoes #btn_salvar").hide();
	 			atualizarListaAtivo();	 		
	 			success_message(dados.mensagem);

	 		} else {

	 			error_message(dados.mensagem);
	 			console.log(dados.mensagem + "\r\n"
	 					+ dados.exception);
	 		}

	 	  },
	 	  error: function(xhr, ajaxOptions, thrownError) {
	 		error_message("ERRO ativos.js salvarJuros:\r\nNão foi possível carregar os dados\r\n\r\n(" +
	 		  xhr.status + " - " + thrownError + ")");
	 	  }
	 	});

	}// Validação de Usuário

	maskMoedaBR(8);
	maskNumeroBR(8);

}

function atualizarListaSubscricoes(AtivoID){
		
	$.ajax({
		url: app_path + "/controllers/ativos.subscricoes.controller.php",
		data : {
			"ac" : "LISTAR_ATIVO_SUBSCRICOES",
			"AtivoID": AtivoID
		},
		dataType : "html",
		success : function(lista) {
			$('#spanListaConteudoSubscricoes').html(lista);
			aplicaDataTableSubscricoes();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.subscricoes.js editarAtivoSubscricoes:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}


$(document).off("click", "#lista_subscricoes td a.integralizacao");
$(document).on("click", "#lista_subscricoes td a.integralizacao", function() { 
	var SubscricoesID  = $(this).closest("tr").data("subscricaoid");
	$("#dialog-manut-subscricoes").css("opacity" , 0.33);	
	editarAtivoIntegralizacoes(SubscricoesID);  
});


//função editar do formulário integralizações

function editarAtivoIntegralizacoes(SubscricoesID) {

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
				$("#dialog-manut-integralizacoes #btn_salvar").hide();
				$('#dialog-manut-integralizacoes #btn_salvar').on('click', function(){
					if ($('#camposintegralizacao').is(':visible')) salvarIntegralizacao();
				});
				$('.btn_cancelar').on('click', function(){
					if ($('#camposintegralizacao').is(':visible')){
						$("#dialog-manut-integralizacoes #btn_cancelar").text("Sair");
						$("#camposintegralizacao").hide('slow');
						$("#dialog-manut-integralizacoes #btn_salvar").hide();						
						$('#camposintegralizacao input').val('');
						$("#div_lista_integralizacoes").show('slow');
					}else{
						$("#dialog-manut-integralizacoes").modal('hide');
						$("#dialog-manut-subscricoes").css("opacity" , 1);
					}
				});

				$('.btn_novo_integralizacao').on('click', function(){					
					$("#camposintegralizacao").show("slow");
					$("#dialog-manut-integralizacoes #btn_cancelar").text("Cancelar");
					$("#dialog-manut-integralizacoes #btn_salvar").show();
					$("#div_lista_integralizacoes").hide('slow');
				});

				// $('#lista_integralizacoes table tbody tr td .editar').on('click', function(){
				$(document).off("click", "#lista_integralizacoes .editar");
				$(document).on("click", "#lista_integralizacoes .editar", function() {
					tr=$(this).closest('tr');							
					$("#div_lista_integralizacoes").hide('slow');
					$("#dialog-manut-integralizacoes #btn_cancelar").text("Cancelar");
					$('#IntegralizacaoSubscricaoData').val($(tr).find('.datasubscricao').text());
					$('#IntegralizacaoData').val($(tr).find('.dataintegralizacao').text());
					$('#IntegralizacaoQuantidade').val($(tr).find('.quantidade').text());
					$('#IntegralizacaoValorUnitario').val($(tr).find('.valorunitario').text());
					$('#IntegralizacaoVolume').val($(tr).find('.volume').text());
					$('#IntegralizacaoID').val($(tr).data('integralizacaoid'));
					$("#camposintegralizacao").show("slow");
					$("#dialog-manut-integralizacoes #btn_salvar").show();
				});

				$(document).off("click", "#lista_integralizacoes .excluir");
				$(document).on("click", "#lista_integralizacoes .excluir", function() { 
					var IntegralizacaoID = $(this).closest("tr").data('integralizacaoid');
					$("#dialog-manut-subscricoes").css("opacity" , 0);
					$("#dialog-manut-integralizacoes").css("opacity" , 0.33);
					bootbox.confirm("Tem certeza que deseja apagar a Integralizacao cadastrada?", 
					 function(confirmou) { 
					    if (confirmou) {
					      excluirIntegralizacao(IntegralizacaoID);
					    }
					    $("#dialog-manut-integralizacoes").css("opacity" , 1);
					    $("#dialog-manut-subscricoes").css("opacity" , 0.33);
					});
				});					 
			
				$("#dialog-manut-integralizacoes").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js editarAtivoIntegralizacoes():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}