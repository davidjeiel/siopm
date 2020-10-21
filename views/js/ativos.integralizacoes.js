//

function aplicaDataTableIntegralizacoes(){
	
	$('table#lista_integralizacoes').dataTable({
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


function excluirIntegralizacao(IntegralizacaoID) {
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.integralizacoes.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ATIVO_INTEGRALIZACAO",
	 			"IntegralizacaoID": IntegralizacaoID
	 		},
	 		dataType: "json",
	 		success: function(dados) {
				if (dados.resultado == true) {					
					atualizarListaIntegralizacoes(dados.subscricoesid);
					$("#AtivoQuantidade").val(dados.ativoquantidade);
                	$("#AtivoValorNominalUnitario").val(dados.ativomedia);
                	$("#AtivoVolume").val(dados.ativovolume);
					success_message(dados.mensagem);
				} else {
					error_message(dados.mensagem);
					console.log(dados.mensagem + "\r\n" + dados.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.integralizacoes.js excluirIntegralizacao:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function salvarIntegralizacao(){

	var form = $('#dialog-manut-integralizacoes form');

	
    AtivoID         				= $(form).find("input[name=AtivoID]").val();
    SubscricoesID         			= $(form).find("input[name=SubscricoesID]").val();
    IntegralizacaoSubscricaoData  	= $(form).find("input[name=IntegralizacaoSubscricaoData]").val();
    IntegralizacaoData				= $(form).find("input[name=IntegralizacaoData]").val()
    IntegralizacaoQuantidade		= $(form).find("input[name=IntegralizacaoQuantidade]").val();
    IntegralizacaoValorUnitario		= $(form).find("input[name=IntegralizacaoValorUnitario]").val();
    IntegralizacaoVolume			= $(form).find("input[name=IntegralizacaoVolume]").val();

	maskMoedaUn(8); 	
	maskNumeroUm(8); 

	if ($(form).valid()){

	 	$.ajax({

	 	  url: app_path + "/controllers/ativos.integralizacoes.controller.php",
	 	  data: "ac=SALVAR_ATIVO_INTEGRALIZACAO&" + form.serialize(),
	 	  dataType: "json",

	 	  success: function(dados) {

	 		if (dados.resultado == true) {

                $("#AtivoQuantidade").val(dados.ativoquantidade);
                $("#Ativomedia").val(dados.ativomedia);
                $("#AtivoVolume").val(dados.ativovolume);
                $("#camposintegralizacao").hide('slow');
                $("#dialog-manut-integralizacoes #btn_cancelar").text("Sair");				
				$('#camposintegralizacao input').val('');
				$("#div_lista_integralizacoes").show();

	 			atualizarListaIntegralizacoes(SubscricoesID);

	 			$("#dialog-manut-integralizacoes #btn_salvar").hide();	 		
	 			success_message(dados.mensagem);

	 		} else {

	 			error_message(dados.mensagem);
	 			console.log(dados.mensagem + "\r\n"
	 					+ dados.exception);
	 		}

	 	  },
	 	  error: function(xhr, ajaxOptions, thrownError) {
	 		error_message("ERRO ativos.integralizacoes.js salvarJuros:\r\nNão foi possível carregar os dados\r\n\r\n(" +
	 		  xhr.status + " - " + thrownError + ")");
	 	  }
	 	});

	}// Validação de Usuário

	maskMoedaBR(8);
	maskNumeroBR(8);

}


function atualizarListaIntegralizacoes(SubscricoesID){
		
	$.ajax({
		url: app_path + "/controllers/ativos.integralizacoes.controller.php",
		data : {
			"ac" : "LISTAR_ATIVO_INTEGRALIZACOES",
			"SubscricoesID": SubscricoesID
		},
		dataType : "html",
		success : function(lista) {
			$('#spanListaConteudoIntegralizacoes').html(lista);
			aplicaDataTableIntegralizacoes();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativos.integralizacoes.js editarAtivoIntegralizacoes:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}