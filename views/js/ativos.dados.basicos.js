//Versao 1

$(document).on("blur", "#dialog-manut-ativo-dados-basicos #AtivoCodigoCetip", function() {
	var codigoCetip = $(this).val();
	var ativoID = $("#dialog-manut-ativo-dados-basicos #AtivoID").val();
	var tipo = "Cetip";
	if(codigoCetip.length > 0){
		findCodigo(codigoCetip, tipo, ativoID);''
	}else{
		return;
	}
});

$(document).on("blur", "#dialog-manut-ativo-dados-basicos #AtivoCodigoBmfBovespa", function() {
	var codigoBmfBovespa = $(this).val();
	var ativoID = $("#dialog-manut-ativo-dados-basicos #AtivoID").val(); 
	var tipo = "BmfBovespa";
	if(codigoBmfBovespa.length > 0){
		findCodigo(codigoBmfBovespa, tipo, ativoID);
	}else{
		return;
	}
});

$(document).on("blur", "#dialog-manut-ativo-dados-basicos #AtivoCodigoIsin", function() {
	var codigoIsin = $(this).val();
	//codigoIsin = jquery.trim(codigoIsin);
	var ativoID = $("#dialog-manut-ativo-dados-basicos #AtivoID").val(); 
	var tipo = "Isin";
	if(codigoIsin.length > 0){
		findCodigo(codigoIsin, tipo, ativoID);
	}else{
		return;
	}
});

function findCodigo(codigo, tipo, ativoid){	

	$.ajax(
		{
			url: app_path + "/controllers/ativos.dados.basicos.controller.php",
			data: {
				"ac": "PROCURAR_ATIVO",
				"tipo": tipo,
				"ativoid": ativoid,
				"codigo": codigo
			},

			dataType: "json",

			success: function(dados) {

				if (dados.resultado){

					if(dados.tipo == 'Cetip') {

						var codigo = htmlEscape(dados.AtivoCodigoCetip);
						$("#dialog-manut-ativo-dados-basicos #AtivoCodigoCetip").val('');
					}

					if(dados.tipo == 'BmfBovespa') {

						var codigo = htmlEscape(dados.AtivoCodigoBmfBovespa);
						$("#dialog-manut-ativo-dados-basicos #AtivoCodigoBmfBovespa").val('');
					}

					if(dados.tipo == 'Isin') {

						var codigo = htmlEscape(dados.AtivoCodigoIsin);
						$("#dialog-manut-ativo-dados-basicos #AtivoCodigoIsin").val('');
					}

					var mensagem = "O codigo " + htmlEscape(dados.tipo)+ " : " + codigo +
								   " ja esta cadastrato no CRI -  " 
								   + htmlEscape(dados.AtivoCodigoSIOPM);							
					
					error_message(mensagem);									 			

      			}else{

      				if(dados.tipo == 'Cetip') {						
						$("#dialog-manut-ativo-dados-basicos #AtivoCodigoBmfBovespa").val('');
					}else if(dados.tipo == 'BmfBovespa') {						
						$("#dialog-manut-ativo-dados-basicos #AtivoCodigoCetip").val('');
					}

      				return;

      			}

			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.dados.basicos.js findCodigo:\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}

function salvarDadosBasicos(){


	maskMoedaUn(8); 
	maskPorcentagemUn(6);
	maskNumeroUm(8);

	$( "#dialog-manut-ativo-dados-basicos #AtivoQuantidade" ).rules( "add", {
  		required: true,
  		min:0.00000001,
  		messages: {
    	required: "Campo obrigatório",
    	min: ("Por Favor, inserir uma quantidade válida")
  		}
	});
	
	$( "#dialog-manut-ativo-dados-basicos #AtivoValorNominalUnitario" ).rules( "add", {
  		required: true,
  		min:0.00000001,
  		messages: {
    	required: "Campo obrigatório",
    	min: ("Por Favor, inserir uma quantidade válida")
  		}
	});

	$( "#dialog-manut-ativo-dados-basicos #AtivoVolume" ).rules( "add", {
  		required: true,
  		min:0.00000001,
  		messages: {
    	required: "Campo obrigatório",
    	min: ("Por Favor, inserir uma quantidade válida")
  		}
	});
	
	var form = $('#dialog-manut-ativo-dados-basicos form');
	var abaValidada = true;		

	$(".tab-pane").each(function() {

		if(abaValidada){			 		

			$("#navAtivos li").removeClass("active");
			$(".tab-pane").removeClass("active in");
			$(this).addClass("active in");
			$("a[href=#"+ $(this).attr("id") + "]").closest("li").addClass("active");		
			if(!$(form).valid()) abaValidada = false;
		}

	});
	

	if (abaValidada) {	 	

	 	$.ajax({

	 	  url: app_path + "/controllers/ativos.dados.basicos.controller.php",
	 	  data: "ac=SALVAR_DADOS_GERAIS&" + form.serialize(),
	 	  dataType: "json",

	 	  success: function(dados) {

	 		if (dados.resultado == true) {

	 			$('a[href=#tabDadosBasicos]').tab('show');
	 			//$(this).Class("active in").tab('show');

	 			if($("#dialog-manut-ativo-finalizar").is(':visible')) atualizarListaErrosAtivos(dados.ativoid);
	 			
	 			atualizarListaAtivo();
	 			
	 			success_message(dados.mensagem);

	 		} else {

	 			//$("#navAtivos li").removeClass("active");
				//$(".tab-pane").removeClass("active in");

	 			$('a[href=#tabDadosBasicos]').tab('show');

	 			//$(this).Class("active in").tab('show');

	 			error_message(dados.mensagem);
	 			console.log(dados.mensagem + "\r\n"
	 					+ dados.exception);
	 		}

	 	  },
	 	  error: function(xhr, ajaxOptions, thrownError) {
	 		error_message("ERRO ativo.js salvarDadosBasicos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
	 		  xhr.status + " - " + thrownError + ")");
	 	  }

	 	});

	}

	$("#dialog-manut-ativo-dados-basicos #AtivoQuantidade").rules("remove");
	$("#dialog-manut-ativo-dados-basicos #AtivoValorNominalUnitario").rules("remove");
	$("#dialog-manut-ativo-dados-basicos #AtivoVolume").rules("remove");

	maskMoedaBR(8);
	maskNumeroBR(8);
	maskPorcentagemBR(6);	

}