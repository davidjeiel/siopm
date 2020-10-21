
//VER 3

$(document).ready(function() {
	aplicaDataTablePropostas();
});

function aplicaDataTablePropostas(){
	
  $('table#lista_propostas').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"order": [[ 3, 'des' ], [ 0, 'asc' ]],
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[		    
      		{ "sType": "money-br", "aTargets": [ 5 ] },
			{ "orderable": false, "aTargets": [7] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

$(document).off("click", ".lista-propostas table tbody tr td a.excluir");
$(document).on("click", ".lista-propostas table tbody tr td a.excluir", function() {
	var PropostaID                 = $(this).closest("tr").data("propostaid");
	var PropostaNumero             = $(this).closest("tr").data("propostanumero");
	var SecuritizadoraNomeRazao    = $(this).closest("tr").data("securitizadora");
	var DataFinalizacao            = $(this).closest("tr").data("datafinalizacao");
	//if (DataFinalizacao == ""){
		bootbox.confirm("Tem certeza que deseja apagar a proposta <b>" + 
			PropostaNumero + "</b> da securitizadora <b> " + SecuritizadoraNomeRazao + "</b>?", 
			function(confirmou) {
				if (confirmou) {excluirProposta(PropostaID);}
		});
	// }else{
	// 	bootbox.alert("<b>Proposta Finalizada! Não é possível a exclusão.</b>");
	// }
});

$(document).off("click", '.btn_nova_proposta');
$(document).on("click", '.btn_nova_proposta', function() {
	editarDadosBasicos("");
});

$(document).off("click", ".lista-propostas table tbody tr td a.dados-basicos");
$(document).on("click", ".lista-propostas table tbody tr td a.dados-basicos", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarDadosBasicos(PropostaDetalheID);
});

$(document).off("click", ".lista-propostas table tbody tr td a.contatos"); 
$(document).on("click", ".lista-propostas table tbody tr td a.contatos", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarPropostaContatos(PropostaDetalheID);
});

$(document).off("click", ".lista-propostas table tbody tr td a.prop-enquadramento-analises");
$(document).on("click", ".lista-propostas table tbody tr td a.prop-enquadramento-analises", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarEnquadramentoAnalises(PropostaDetalheID);
});

$(document).off("click", ".lista-propostas table tbody tr td a.prop-manifestacao-securitizadora");
$(document).on("click", ".lista-propostas table tbody tr td a.prop-manifestacao-securitizadora", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarManifestacaoSecuritizadora(PropostaDetalheID);
});

$(document).on("click", ".lista-propostas table tbody tr td a.prop-manifestacao-agente-operador", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarManifestacaoAgente(PropostaDetalheID);
});

$(document).off("click", ".lista-propostas table tbody tr td a.finalizar"); 
$(document).on("click", ".lista-propostas table tbody tr td a.finalizar", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarFinalizacao(PropostaDetalheID);
});

$(document).off("click", ".lista-propostas table tbody tr td a.visualizar"); 
$(document).on("click", ".lista-propostas table tbody tr td a.visualizar", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	visualizarProposta(PropostaDetalheID);
});


$(document).off("click", ".lista-propostas table tbody tr td a.arquivos"); 
$(document).on("click", ".lista-propostas table tbody tr td a.arquivos", function() {
	var PropostaDetalheID  = $(this).closest("tr").data("propostadetalheid");
	editarArquivos(PropostaDetalheID);
});


function goErroPropostaCRI(acao, PropostaID, PropostaDetalheID, AbaID, CampoID){

	if (acao == 'EDITAR_PROPOSTA_DADOS_BASICOS') {
		editarDadosBasicos(PropostaDetalheID);
		$("#dialog-dados-basicos .nav li").removeClass("active in");
		$("#dialog-dados-basicos .tab-pane").removeClass("active in");
		$("#tabPropostas #" + AbaID).addClass("active in");
		$("#navPropostas a[href='#"+ AbaID + "']").closest("li").addClass("active");
	}

	if (acao == 'EDITAR_PROPOSTA_ENQUADRAMENTO_ANALISE') {
		editarEnquadramentoAnalises(PropostaDetalheID);
		$("#dialog-enquad-analises .nav li").removeClass("active in");
		$("#dialog-enquad-analises .tab-pane").removeClass("active in");
		$("#tabPropostas #" + AbaID).addClass("active in");
		$("#navPropostas a[href='#"+ AbaID + "']").closest("li").addClass("active");
	}

	if (acao == 'EDITAR_PROPOSTA_MANIFESTACAO_SECURITIZADORA') {
		editarManifestacaoSecuritizadora(PropostaDetalheID);
		$("#dialog-manif-securitizadora .nav li").removeClass("active in");
		$("#dialog-manif-securitizadora .tab-pane").removeClass("active in");
		$("#tabPropostas #" + AbaID).addClass("active in");
		$("#navPropostas a[href='#"+ AbaID + "']").closest("li").addClass("active");
	}

	if (acao == 'EDITAR_PROPOSTA_MANIFESTACAO_AGENTES') {
		editarManifestacaoAgente(PropostaDetalheID);
		$("#dialog-manif-agentes .nav li").removeClass("active in");
		$("#dialog-manif-agentes .tab-pane").removeClass("active in");
		$("#tabPropostas #" + AbaID).addClass("active in");
		$("#navPropostas a[href='#"+ AbaID + "']").closest("li").addClass("active");
	}

	$("#dialog-finalizacao").modal('hide');
}

function atualizaListaPropostas(faseID){
	var tipoList = "";
	if (faseID == 1) tipoList = "LISTAR_PROPOSTA_PRELIMINAR_ATUALIZACAO"; else tipoList = "LISTAR_PROPOSTA_DEFINITIVA_ATUALIZACAO";
	$.ajax({
		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : tipoList,
		},
		dataType : "html",
		success : function(lista) {
			$('#spanConteudo').html(lista);
			aplicaDataTablePropostas();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  proposta.cri.js editarDadosBasicos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}


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

function editarArquivos(PropostaDetalheID){

	 $.ajax({

		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "arquivos",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$("#dialog-arquivos-upload").modal('show');
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  proposta.cri.js editarArquivos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});

}


function excluirProposta(PropostaID){
  $.ajax({
	url: app_path + "/controllers/propostas.cri.controller.php",
	data: {
	  "ac": "EXCLUIR_PROPOSTA",
	  "PropostaID": PropostaID
	},
	dataType: "json",
	success: function(data) {
		if (data.resultado == true) {
			tr = $("table#lista_propostas tbody tr.proposta_" + PropostaID).get(0);
			pos = $("table#lista_propostas").dataTable().fnGetPosition(tr);
			$("table#lista_propostas").dataTable().fnDeleteRow(pos);
			success_message(data.mensagem);
		} else {
			error_message(data.mensagem);
			console.log(data.mensagem + "\r\n" + data.exception);
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO proposta.cri.js excluirProposta:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
	}
  });
}

function atualizaErrors(PropostaDetalheID){
	$.ajax({
		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "ATUALIZAR_PROPOSTA_ERROS",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(htmlErros) {
			$('#spanErrosFinalizacao').html(htmlErros);
			if ($.trim(htmlErros) == ""){ 
				$("#dialog-finalizacao .finalizar-proposta").removeClass("hide");
				$("#dialog-finalizacao .finalizar-proposta").show();
			}else{   
				$('.atualizar-lista-errors').off().on("click", function() {
					atualizaErrors(PropostaDetalheID);
				});
				$("#btn_finalizar").addClass("hide");
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO proposta.cri.js atualizaErrors:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}

function editarPropostaContatos(PropostaDetalheID){
	$.ajax({
		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "EDITAR_CONTATO_PROPOSTA",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {

			$('#spanForm').html(form);

			//if ($("#formPropostaContatos #DataFinalizacao").val() == ""){

				$("#dialog-proposta-contato .btn_salvar").off("click").on("click", function() {
					if ($('#divCamposContato').is(':visible')) salvarPropostaContato();
				});

				$('#dialog-proposta-contato .btn_cancelar').on('click', function(){
					if ($('#divCamposContato').is(':visible')){
						$("#divCamposContato").hide();
						$('#divCamposContato input').val('');
						$("#div_lista_proposta_contatos").show();
					}else{
					   $("#dialog-proposta-contato").modal('hide');
					}
				});

				$('#div_lista_proposta_contatos .btn_novo_contato').on('click', function(){
					$("#divCamposContato").show();
					$("#div_lista_proposta_contatos").hide();
				});

			// }else{
			// 	$('#div_lista_proposta_contatos .btn_novo_contato').remove();
			// 	$('#btn_salvar').remove();
			// 	$('.input-append.date input').css("background-color", "#EEEEEE !important");
			// 	$('.input-append.date div span').off("click");
			// 	$("#dialog-proposta-contato form :input").attr("disabled", "disabled");
			// 	$('.up-del').remove();
			// 	$('.up-upload').remove();
			// 	$('.up-add').remove();
			// 	$('#dialog-proposta-contato .btn_cancelar').on('click', function(){
			// 		$("#dialog-proposta-contato").modal('hide');
			// 	});
			// }

			$("#dialog-proposta-contato").modal('show');

		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO proposta.cri.js editarPropostaContato:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}

function excluirPropostaContato(PropostaContatoID){
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/propostas.cri.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_PROPOSTA_CONTATO",
	 			"PropostaContatoID": PropostaContatoID
	 		},
	 		dataType: "json",
	 		success: function(data) {
				if (data.resultado == true) {
					tr = $("table#lista_proposta_contatos tbody tr.propostacontato_" + PropostaContatoID ).get(0);
					pos = $("table#lista_proposta_contatos").dataTable().fnGetPosition(tr);
					$("table#lista_proposta_contatos").dataTable().fnDeleteRow(pos);
					success_message(data.mensagem);
				} else {
					error_message(data.mensagem);
					console.log(data.mensagem + "\r\n" + data.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO proposta.cri.js excluirPropostaContato:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}

function salvarPropostaContato(){

	var form = $('#dialog-proposta-contato form');

	ContatoID          = $(form).find("input[name=ContatoID]").val();
	PropostaContatoID  = $(form).find("input[name=PropostaContatoID]").val();
	ContatoNome        = $(form).find("input[name=ContatoNome]").val();
	ContatoFone1       = $(form).find("input[name=ContatoFone1]").val();
	ContatoFone2       = $(form).find("input[name=ContatoFone2]").val();
	ContatoEmail       = $(form).find("input[name=ContatoEmail]").val();
	ContatoObs         = $(form).find("input[name=ContatoObs]").val();

	if (($("#ContatoNome").val().length) < 3){
		$("#ContatoNome").focus();
		error_message("Entre com um nome válido para o contato!");
	}else if(
		$("#ContatoEmail").val().length < 3 &&
		$("#ContatoFone1").val().length < 3 &&
		$("#ContatoFone2").val().length < 3 )
	{
		$("#ContatoEmail").focus();
		error_message("É Necessário ao menos uma forma de contato válida!");
	} else {

		$.ajax({

			url: app_path + "/controllers/propostas.cri.controller.php",
			data: "ac=SALVAR_PROPOSTA_CONTATO&" + form.serialize(),
			dataType: "json",

			success: function(dados) {

				if (dados.resultado == true) {

					//Verificamos de já existe uma TR com o ID gravado. Se sim editamos. Se não criamos uma TR nova.
					if ($("table#lista_proposta_contatos tbody tr.propostacontato_" + PropostaContatoID).length > 0){

						// Atualiza a tr existente
						tr =  $("table#lista_proposta_contatos tbody tr.propostacontato_" + PropostaContatoID);

						//Atualizamos os valores dos atributos data
						$(tr).data('contatoid', ContatoID);
						$(tr).data('propostacontatoid', PropostaContatoID);
						$(tr).data('contatonome', ContatoNome);                  
						  
						//Atualizamos os valores da TR
						$(tr).find(".ContatoNome").text(ContatoNome);
						$(tr).find(".ContatoEmail").text(ContatoEmail);
						$(tr).find(".ContatoFone1").text(ContatoFone1);                       
						$(tr).find(".ContatoFone2").text(ContatoFone2);
						$(tr).find(".ContatoObs").text(ContatoObs);
					   
					//Caso não exista, criamos uma TR Nova.
					}else{

						ContatoID = dados.contatoid;
						PropostaContatoID = dados.propostacontatoid;
						
						//Concatenamos as tags para adicionar no final na ultima TD do DATATABLE
						links_html = $('<span></span>')                            
							.append(TAG_A_EDITAR)
							.append(TAG_A_EXCLUIR).html();

						// Armazenamos todos os dados a serem inseridos na nova linha em uma array
						arr = new Array(
							'<div class="ContatoNome">' + ContatoNome + '</div>', 
							'<div class="ContatoEmail">' + ContatoEmail + '</div>', 
							'<div class="ContatoFone1">' + ContatoFone1 + '</div>', 
							'<div class="ContatoFone2">' + ContatoFone2 + '</div>',
							'<div class="ContatoObs">' + ContatoObs + '</div>',                          
							links_html
						);

						// Criamos uma nova linha, com os dados a serem exibidos
						// http://stackoverflow.com/questions/8239118/jquery-datatables-how-do-i-add-a-row-id-to-each-dynamically-added-row
						var addId   = $("table#lista_proposta_contatos").dataTable().fnAddData( arr );
						var tr      = $("table#lista_proposta_contatos").dataTable().fnSettings().aoData[addId[0]].nTr;

						// Setamos os atributos do tr
						$(tr).addClass("propostacontato_" + PropostaContatoID)
							.data('contatoid', ContatoID)
							.data('propostacontatoid', PropostaContatoID)
							.data('contatonome', ContatoNome);
					}

					$("#divCamposContato").hide();
					$('#divCamposContato input').val('');
								
					$("#div_lista_proposta_contatos").show();
					applyDataTableByID("lista_proposta_contatos", "130px");                  

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

	}

}


function editarFinalizacao(PropostaDetalheID){
	$.ajax({
		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "EDITAR_PROPOSTA_FINALIZACAO",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {
			$('#spanFormFinalizacao').html(form);
			//if ($("#formFinalizacao #DataFinalizacao").val() == ""){
				$("#btn_finalizar").off("click").on("click", function() {
					finalizarProposta();
				});

				$('.atualizar-lista-errors').off().on("click", function() {
					atualizaErrors(PropostaDetalheID);
				});

			// }else{
			// 	$('.atualizar-lista-errors').remove();
			// 	$('#btn_finalizar').remove();
			// 	$('.input-append.date input').css("background-color", "#EEEEEE !important");
			// 	$('.input-append.date div span').off("click");
			// 	$("#dialog-finalizacao form :input").attr("disabled", "disabled");
			// }
			$("#dialog-finalizacao").modal('show');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO proposta.cri.js editarFinalizacao:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}

function editarManifestacaoAgente(PropostaDetalheID){
	$.ajax({
		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "EDITAR_PROPOSTA_MANIFESTACAO_AGENTES",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$("#btn_salvar").off("click").on("click", function() {
				salvarManifestacoesAgentes();
			});
			$("#dialog-manif-agentes").modal('show');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO proposta.cri.js editarManifestacaoAgente:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}

function editarManifestacaoSecuritizadora(PropostaDetalheID){

	$.ajax({

		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "EDITAR_PROPOSTA_MANIFESTACAO_SECURITIZADORA",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {

			$('#spanForm').html(form);
			//if ($("#formManifSecuritizadora #DataFinalizacao").val() == ""){
			$("#btn_salvar").off("click").on("click", function() {
				salvarManifestacaoSecuritizadora();
			});

			// }else{
			// 	$('#btn_salvar').remove();
			// 	$('.up-del').remove();
			// 	$('.input-append.date input').css("background-color", "#EEEEEE !important");
			// 	$('.input-append.date div span').off("click");
			// 	$("#dialog-manif-securitizadora form :input").attr("disabled", "disabled");
			// }

			$("#dialog-manif-securitizadora").modal('show');

		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO proposta.cri.js editarManifestacaoSecuritizadora:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});

}


function editarEnquadramentoAnalises(PropostaDetalheID){

	 $.ajax({

		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "EDITAR_PROPOSTA_ENQUADRAMENTO_ANALISE",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			//if ($("#formEnquadramentoAnalises #DataFinalizacao").val() == ""){
			$("#btn_salvar").off("click").on("click", function() {
				salvarEnquadramentoAnalises();
			});

			// }else{
			// 	$('#btn_salvar').remove();
			// 	$('.up-del').remove();
			// 	$('.input-append.date input').css("background-color", "#EEEEEE !important");
			// 	$('.input-append.date div span').off("click");
			// 	$("#dialog-enquad-analises form :input").attr("disabled", "disabled");
			// }

			$("#dialog-enquad-analises").modal('show');
	
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  proposta.cri.js editarEnquadramentoAnalises:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	
	});

}

function editarDadosBasicos(PropostaDetalheID) {

	$.ajax({
		url: app_path + "/controllers/propostas.cri.controller.php",
		data : {
			"ac" : "EDITAR_PROPOSTA_DADOS_BASICOS",
			"PropostaDetalheID" : PropostaDetalheID
		},
		dataType : "html",
		success : function(form) {

			$('#spanForm').html(form);
			
			$("#btn_salvar").off("click").on("click", function() {
				salvarDadosBasicos();
			});

			$("select#UnidadeID").change(function(){
				if ($('select#UnidadeID option:selected').val() != $("#UnidadeUsuario").val())
					info_message("A GIFUG selecionada direfe da unidade do Usuário!");
			});

			$("#dialog-dados-basicos").modal('show');
			$('.input-append.date').each(function () {
				var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
				$(this).datepicker(config).on('changeDate', function(ev){
					  $(this).datepicker('hide');
				});  
			});

		 
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  proposta.cri.js editarDadosBasicos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});

}

function finalizarProposta(){
	
	var form = $('#formFinalizacao');

	if($(form).valid()) {

		bootbox.confirm("<h4>Após a Finalização, nenhum dado poderá ser alterado!" + 
			" Deseja continuar? </h4>", 
			function(confirmou) {
				if (confirmou) {        

					maskFormUn(2,5); 
					
					$.ajax({

						url: app_path + "/controllers/propostas.cri.controller.php",
						data: "ac=FINALIZAR_PROPOSTA&" + form.serialize(),
						dataType: "json",

						success: function(data) {

						   if (data.resultado == true) {
								$("#dialog-finalizacao").modal('hide');
								success_message(data.mensagem);
								atualizaListaPropostas($("#PropostaFaseID").val());
							} else {
								error_message(data.mensagem);
								console.log(data.mensagem + "\r\n" + data.exception);
							}

						},
						error: function(xhr, ajaxOptions, thrownError) {
							bootbox.alert("ERRO propostas.cri.js finalizarProposta() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
							xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
						}

					});


					maskFormBr(2,5);

				}

		});

	}
}


function salvarManifestacoesAgentes(){

	var form = $('#formManifAgentes');
	maskFormUn(2,5); 
	 $.ajax({

		url: app_path + "/controllers/propostas.cri.controller.php",
		data: "ac=SALVAR_PROPOSTA_MANIFESTACAO_AGENTES&" + form.serialize(),
		dataType: "json",

		success: function(data) {

		   if (data.resultado == true) {
			
				$("#PropResolucaoConselhoID").val(data.propresolucaoconselhoid);
				$("#PropManifGifugID").val(data.propmanifgifugid);
				$("#PropManifGefomID").val(data.propmanifgefomid);

				if(data.propresolucaoconselhoid > 0) $("#prop_res_view_files_up").show('slow');
				if(data.propmanifgifugid > 0) $("#prop_gif_view_files_up").show('slow');
				if(data.propmanifgefomid > 0) $("#prop_gef_view_files_up").show('slow');
				
				success_message(data.mensagem);

			} else {
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}

		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO propostas.cri.js salvarManifestacoesAgentes() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
		}

	});

	maskFormBr(2,5); 
}

function salvarManifestacaoSecuritizadora(){

	var form = $('#formManifSecuritizadora');

	$.ajax({

		url: app_path + "/controllers/propostas.cri.controller.php",
		data: "ac=SALVAR_MANIFESTACAO_SECURITIZADORA&" + form.serialize(),
		dataType: "json",

		success: function(data) {

		   if (data.resultado == true) {

				$("#PropManifSecurID").val(data.propmanifsecurid);

				success_message(data.mensagem);

			} else {
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}

		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO propostas.cri.js salvarManifestacaoSecuritizadora() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
		}

	});
	

}

function salvarEnquadramentoAnalises(){

	 /* Captura o form */
	var form = $('#formEnquadramentoAnalises');

	maskFormUn(2,8); 

	$.ajax({

	url: app_path + "/controllers/propostas.cri.controller.php",
	data: "ac=SALVAR_PROPOSTA_ENQUADRAMENTO_ANALISE&" + form.serialize(),
	dataType: "json",

		success: function(data) {

		   if (data.resultado == true) {

				$("#PropRiscoID").val(data.propriscoid);
				$("#PropJuridicaID").val(data.propjuridicaid);
				$("#PropPesqSecurID").val(data.proppesqsecurid);
				$("#PropostaEnquadramentoID").val(data.propenquadramentoid);

				if(data.propjuridicaid > 0) $("#prop_jur_view_files_up").show('slow');
				if(data.propriscoid > 0)    $("#prop_risco_view_files_up").show('slow');

				success_message(data.mensagem);

			} else {
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}

		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO propostas.cri.js salvarEnquadramentoAnalises() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
		}

	});

	maskFormBr(2,8);

}

function salvarDadosBasicos(){

	var PropostaID  = "";
	var liAtiva     = $("#navPropostas li.active");
	var paneAtiva   = $("#tabPropostas div.active");

	/* Captura o form */
	var form = $('#formPropostaDadosBasicos');

	/* Controla as abas para validacao */
	var abaValidada = true;
	

	$(".tab-pane").each(function() {

		if(abaValidada){

			$("#navPropostas li").removeClass("active");
			$(".tab-pane").removeClass("active in");

			$(this).addClass("active in");
			$("a[href=#"+ $(this).attr("id") + "]").closest("li").addClass("active");
		
			if(!$(form).valid()) abaValidada = false;

		}

	});

	if (abaValidada) {

		$("#navPropostas li").removeClass("active");
		$(".tab-pane").removeClass("active in");

		$(liAtiva).addClass("active");
		$(paneAtiva).addClass("active in");

		PropostaID = $(form).find("input[name=PropostaID]").val();

		$(".campo-formatado").each(function( index ){
			if ( $(this).val() == "" || $(this).val() == null ) $(this).val("0");
		});

		$(".moeda, .porcentagem").each(function( index ) {
			if($(this).val().indexOf(",") < 0) $(this).val( $(this).val() + String(",00"));
		});

		maskFormUn(2,5); 

		$.ajax({
			url: app_path + "/controllers/propostas.cri.controller.php",
			data: "ac=SALVAR_PROPOSTA_DADOS_BASICOS&" + form.serialize(),
			dataType: "json",
			success: function(data) {
			   if (data.resultado == true) {
					$("#PropostaID").val(data.propostaid);
					$("#PropostaDetalheID").val(data.propostadetalheid);
					$("#PropostaNumero").val(data.propostanumero);
					//$("#ValorUnitarioSenior").removeClass("moeda");
					$("#ValorUnitarioSenior").val(data.valorunitariosenior);
					//$("#ValorUnitarioSenior").addClass("moeda");

					if (data.valorseniormaior == true && $("#PropostaFaseID").val() == 2) {
						success_message(data.mensagem + "<p class='alert-danger'> Porém o Valor do CRI (Sênior) supera o valor aprovado pela GEFOM</p>");
						$(".valorseniormaior").show();
					} else {
						$(".valorseniormaior").hide();
						success_message(data.mensagem);
					}
					atualizaListaPropostas($("#PropostaFaseID").val());
				} else {
					error_message(data.mensagem);
					console.log(data.mensagem + "\r\n" + data.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				bootbox.alert("ERRO propostas.cri.js salvarDadosBasicos() ajax:error\r\nNão foi possível carregar os dados\r\n\r\n(" +
				xhr.status + " - " + thrownError + " - " + ajaxOptions + ")");
			}
		});

		maskFormBr(2,5);

	}

}





