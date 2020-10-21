
$(document).ready(function() {
	aplicaDataTableHabilitacoes();
});

function aplicaDataTableHabilitacoes(){
	
  $('table#lista_habilitacoes').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
		    { "sType": "date-br", "aTargets": [ 4 ] }, 
      		{ "sType": "date-br", "aTargets": [ 5 ] },
			{ "orderable": false, "aTargets": [8] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

$(document).on("click", "table#lista_habilitacoes tr a.excluir", function() {
	HabilitacaoID = $(this).closest("tr").data('habilitacaoid');
	EntidadeNomeFantasia = $(this).closest("tr").data('entidadenomerazao');
	bootbox.confirm("Tem certeza que deseja excluir a Habilitacao da empresa \"" + htmlEscape(EntidadeNomeFantasia) + "\"?", 
      function(confirmou) { 
      if (confirmou) {      
        excluirHabilitacao(HabilitacaoID);
      }
    });
});

$(document).on("click", '.btn_nova_habilitacao', function() {	
  editarHabilitacao("EDITAR_HABILITACAO", ""); 
});

$(document).on("click", "table#lista_habilitacoes a.finalizar", function() {
	HabilitacaoID = $(this).closest("tr").data('habilitacaoid');
	editarHabilitacao("EDITAR_FINALIZAR_HABILITACAO", HabilitacaoID);
});

$(document).on("click","table#lista_habilitacoes a.visualizar", function() {
	HabilitacaoID = $(this).closest("tr").data('habilitacaoid');
	editarHabilitacao("VISUALIZAR_HABILITACAO", HabilitacaoID);
});

$(document).on("click", "table#lista_habilitacoes a.editar", function() {
	HabilitacaoID = $(this).closest("tr").data('habilitacaoid');
	editarHabilitacao("EDITAR_HABILITACAO", HabilitacaoID);
});

$(document).on("click", "table#lista_habilitacoes a.historico", function() {
	EntidadeID = $(this).closest("tr").data('entidadeid');
 	historicoHabilitacao("VISUALIZAR_HISTORICO_HABILITACAO", EntidadeID);
});

function historicoHabilitacao(acao, EntidadeID){

	$.ajax({
		url : app_path + "/controllers/habilitacao.controller.php",
		data : {
			"ac" : acao,
			"EntidadeID" : EntidadeID
		},
		dataType : "html",

		success : function(data) {

			$('#spanFormHistorico').html(data);
			$("#dialog-historico-habilitacao").modal('show');

		},
		error : function(xhr, ajaxOptions, thrownError) {
			bootbox
					.alert("ERRO habilitacao.js historicoHabilitacao:\r\nNão foi possível carregar os dados\r\n\r\n("
							+ xhr.status + " - " + thrownError + ")");
		}
	});

}

function editarHabilitacao(acao, HabilitacaoID) {

	json = {
		"ac" : acao,
		"HabilitacaoID" : HabilitacaoID
	};

 	$.post(
		app_path + "/controllers/habilitacao.controller.php", 
		json,
		function(dados) {

			$('#spanForm').html(dados);

			if (acao == "EDITAR_FINALIZAR_HABILITACAO"){

				$("#btn_finalizar").off("click").on("click", function() {
					bootbox.confirm(
						"Ao finalizar uma habilitação, nenhum dado poderá ser alterado posteriormente. Deseja finalizar?", 
						function(confirmou) { 
							if (confirmou) {      
								finalizarHabilitacao(HabilitacaoID);
							}
						});
				});

				$("#dialog-finalizar-habilitacao").modal('show');
				
			}else if (acao == "EDITAR_HABILITACAO"){

				$("#btn_salvar").off("click").on("click", function() {
					salvarAlteracoesHabilitacao();
				});
				
				if (HabilitacaoID > 0 ) $("#dialog-manut-habilitacao #EntidadeID").prop("disabled", "disabled");				

				$("#dialog-manut-habilitacao").modal('show');

			}else{

	            $('#btn_salvar').hide();
	            $('#btn_cancelar').text("Fechar");

	            $('.input-append.date input').css("background-color", "#EEEEEE !important");
	            $('.input-append.date div span').off("click");

	            $("#dialog-manut-habilitacao form :input").attr("disabled", "disabled");
	            $("#dialog-manut-habilitacao").modal('show');

			}

	}).fail(function(jqXHR, errorThrown) {
			alerta = ("ERRO habilitacao.js editarHabilitacao():\r\nNão foi possível carregar os dados\r\n\r\n("
					+ jqXHR.status + " - " + errorThrown + ")");
			console.log(alerta);
			bootbox.alert(alerta);
	});

}

function salvarAlteracoesHabilitacao() {

	$("#navHabilitacao li").removeClass("active");
	$("a[href=#tabDadosHabilitacao]").closest("li").addClass("active");

	$(".tab-content div").removeClass("active in");
	$("#tabDadosHabilitacao").addClass("active in");
	$("#dialog-manut-habilitacao #EntidadeID").removeAttr('disabled');

	var form = $('#dialog-manut-habilitacao form');

	if ( $(form).valid() ) {

		$.ajax({
		
			url : app_path + "/controllers/habilitacao.controller.php",
			data : "ac=SALVAR_HABILITACAO&" + form.serialize(),
			dataType : "json",

			success : function(dados) {

				$("#dialog-manut-habilitacao #EntidadeID").prop("disabled", "disabled");

				if (dados.resultado == true) {

					var hab = {						
						EntidadeNomeFantasia : 		$(form).find("select[name=EntidadeID] option:selected").text(),
						EntidadeTipoDescricao: 		$(form).find("input[name=EntidadeTipoDescricao]").val(),
						UnidadeSigla: 				$(form).find("select[name=UnidadeID] option:selected").text(),
						EntidadeUF: 				$(form).find("input[name=EntidadeUF]").val(),
						HabilitacaoDataFinalizacao: $(form).find("input[name=HabilitacaoDataFinalizacao]").val(),
						HabilitacaoValidade: 		$(form).find("input[name=HabilitacaoValidade]").val(),
						statusHabilitacao: 			$(form).find("input[name=statusHabilitacao]").val(),
						HabilitacaoRating: 			$(form).find("input[name=HabilitacaoRating]").val()
					}				

					$("#HabilitacaoID").val(dados.habilitacaoid);
					$("#HabilitacaoDataCadastro").val(dados.habilitacaodatacadastro);
					$("#HabRiscoID").val(dados.habriscoid);
					$("#HabJuridicaID").val(dados.habjuridicaid);
					$("#HabRiscoExtID").val(dados.habriscoextid);
					$("#HabCertID").val(dados.habcertid);

                    //Verificamos de já existe uma TR com o ID gravado. Se sim editamos. Se não criamos uma TR nova.
                    if ($("table#lista_habilitacoes tbody tr.habilitacao_" + dados.habilitacaoid).length > 0){

                        // Atualiza a tr existente
                        tr =  $("table#lista_habilitacoes tbody tr.habilitacao_" + dados.habilitacaoid); 

                        //Atualizamos os valores dos atributos data
                        $(tr).data('habilitacaoid', dados.habilitacaoid);
                        $(tr).data('EntidadeNomeFantasia', hab.EntidadeNomeFantasia);	
                        $(tr).data('habilitacaovalidade', hab.HabilitacaoValidade);

                        //Atualizamos os valores da TR
                        $(tr).find(".habilitacao-EntidadeNomeFantasia"       		).text(hab.EntidadeNomeFantasia);
                        $(tr).find(".habilitacao-EntidadeTipoDescricao"  		).text(hab.EntidadeTipoDescricao);
                        $(tr).find(".habilitacao-UnidadeSigla"  				).text(hab.UnidadeSigla);
                        $(tr).find(".habilitacao-EntidadeUF" 					).text(hab.EntidadeUF);
                        $(tr).find(".habilitacao-HabilitacaoDataFinalizacao"  	).text(hab.HabilitacaoDataFinalizacao);
                        $(tr).find(".habilitacao-HabilitacaoValidade"  			).text(hab.HabilitacaoValidade);
                        $(tr).find(".habilitacao-statusHabilitacao"  			).text(hab.statusHabilitacao);
                        $(tr).find(".habilitacao-HabilitacaoRating"  			).text(hab.HabilitacaoRating);

                    //Caso não exista, criamos uma TR Nova.
                    }else{

                        //Concatenamos as tags para adicionar no final na ultima TD do DATATABLE
                        links_html = $('<span></span>')
                            .append(TAG_A_VISUALIZAR)
                            .append(TAG_A_HISTORICO)
                            .append(TAG_A_CONTATOS)
                            .append(TAG_A_EDITAR)
                            .append(TAG_A_FINALIZAR)
                            .append(TAG_A_EXCLUIR).html();

                        // Armazenamos todos os dados a serem inseridos na nova linha em uma array
                        arr = new Array(
                        	'<div class="habilitacao-EntidadeNomeFantasia">'			+ htmlEscape(hab.EntidadeNomeFantasia) 		+ '</div>',
							'<div class="habilitacao-EntidadeTipoDescricao">'		+ htmlEscape(hab.EntidadeTipoDescricao) 		+ '</div>',
							'<div class="habilitacao-UnidadeSigla">'				+ htmlEscape(hab.UnidadeSigla) 					+ '</div>',
							'<div class="habilitacao-EntidadeUF">'					+ htmlEscape(hab.EntidadeUF)					+ '</div>',
							'<div class="habilitacao-HabilitacaoDataFinalizacao">'	+ htmlEscape(hab.HabilitacaoDataFinalizacao)	+ '</div>',
							'<div class="habilitacao-HabilitacaoValidade">'			+ htmlEscape(hab.HabilitacaoValidade)			+ '</div>',
							'<div class="habilitacao-statusHabilitacao" style="color:#ff8a00">'	 	 + htmlEscape("Em Atualização") + '</div>',
							'<div class="habilitacao-HabilitacaoRating">'			+ htmlEscape(hab.HabilitacaoRating)				+ '</div>',
                            links_html
                        );

                        // Criamos uma nova linha, com os dados a serem exibidos
                        // http://stackoverflow.com/questions/8239118/jquery-datatables-how-do-i-add-a-row-id-to-each-dynamically-added-row
                        var addId   = $('table#lista_habilitacoes').dataTable().fnAddData( arr );
                        var tr      = $('table#lista_habilitacoes').dataTable().fnSettings().aoData[addId[0]].nTr;

                        // Setamos os atributos do tr
                        $(tr).addClass("alert habilitacao_" + dados.habilitacaoid);
                        $(tr).attr('data-habilitacaoid',  dados.habilitacaoid);
                        $(tr).attr('data-entidadeid',  dados.entidadeid);
                        $(tr).attr('data-EntidadeNomeFantasia',  hab.EntidadeNomeFantasia);
                        $(tr).attr('data-habilitacaovalidade', hab.HabilitacaoValidade);
                    }

                  
                   applyDataTableByID("lista_habilitacoes");

                    //oTable.fnAdjustColumnSizing();

					success_message(dados.mensagem);

				} else {

					error_message(dados.mensagem);
					console.log(dados.mensagem + "\r\n"
							+ dados.exception);
				}

			},
			error : function(xhr, ajaxOptions, thrownError) {
				bootbox
						.alert("ERRO habilitacao.js salvarAlteracoesHabilitacao:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ xhr.status
								+ " - "
								+ thrownError
								+ ")");
			}

		});

	}

}		

function excluirHabilitacao(HabilitacaoID) {

	$.ajax({
		url : app_path + "/controllers/habilitacao.controller.php",
		data : {
			"ac" : "EXCLUIR_HABILITACAO",
			"HabilitacaoID" : HabilitacaoID
		},
		dataType : "json",

		success : function(data) {

			if (data.resultado == true) {

				// Pegamos a TR específica através de uma classe identificadora (no caso 'habilitacao_') com o id concatenado.
                tr  =    $("table#lista_habilitacoes tbody tr.habilitacao_" + HabilitacaoID).get(0);
                // Como se trata de um DATATABLE, devemos pegar a posição dessa tr no datatable.
                pos =   $("table#lista_habilitacoes").dataTable().fnGetPosition(tr);
                // Agora excluimos a linha dessa posição no DATATABLE
                $("table#lista_habilitacoes").dataTable().fnDeleteRow(pos);

				success_message(data.mensagem);
			} else {
				
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}

		},
		error : function(xhr, ajaxOptions, thrownError) {
			bootbox
					.alert("ERRO habilitacao.js excluirHabilitacao:\r\nNão foi possível carregar os dados\r\n\r\n("
							+ xhr.status + " - " + thrownError + ")");
		}
	});

}

function finalizarHabilitacao() {

	var form = $('#formFinalizarHabilitacao');

	if ( $(form).valid() ) {

		$.ajax({
		
			url : app_path + "/controllers/habilitacao.controller.php",
			data : "ac=SALVAR_FINALIZACAO_HABILITACAO&" + form.serialize(),
			dataType : "json",

			success : function(dados) {

				if (dados.resultado == true) {


					var hab = {
						HabilitacaoConclusao: 		$(form).find("select[name=HabilitacaoConclusaoID] option:selected").val(),
						HabilitacaoDataFinalizacao: $(form).find("input[name=HabilitacaoDataFinalizacao]").val(),
						HabilitacaoValidade: 		$(form).find("input[name=HabilitacaoValidade]").val(),
						HabilitacaoRating: 			$(form).find("input[name=HabilitacaoRating]").val()
					}				

					$("#HabilitacaoID").val(dados.habilitacaoid);
					
                    //Verificamos de já existe uma TR com o ID gravado. Se sim editamos. Se não criamos uma TR nova.
                    if ($("table#lista_habilitacoes tbody tr.habilitacao_" + dados.habilitacaoid).length > 0){
                    	
                        // Atualiza a tr existente
                         tr =  $("table#lista_habilitacoes tbody tr.habilitacao_" + dados.habilitacaoid);  
                        
                        //Atualizamos os valores dos atributos data
                        $(tr).data('habilitacaoid', dados.habilitacaoid);
                        $(tr).data('habilitacaovalidade', hab.HabilitacaoValidade);

                        //Atualizamos os valores da TR
                        $(tr).find(".habilitacao-HabilitacaoDataFinalizacao").text(hab.HabilitacaoDataFinalizacao);
                        $(tr).find(".habilitacao-HabilitacaoValidade").text(hab.HabilitacaoValidade);
                        $(tr).find(".habilitacao-HabilitacaoRating").text(hab.HabilitacaoRating);
                        
                        if(hab.HabilitacaoConclusao == 3){

                        	$(tr).find(".habilitacao-statusHabilitacao").text("Negada");
                        	$(tr).find(".habilitacao-statusHabilitacao").css("color", "#ff0a2d");
                 		 	$(tr).addClass("alert-error");
                        
                        }else{
                        	
                        	$(tr).find(".habilitacao-statusHabilitacao").text("Vigente");
                        	$(tr).find(".habilitacao-statusHabilitacao").css("color", "#279d27");                        	
                        	$(tr).addClass("alert-success");
                        }
                                               
                        $(tr).find("a.finalizar").remove();
                        $(tr).find("a.editar").remove();
                        $(tr).find("a.excluir").remove();

                    //Caso não exista, criamos uma TR Nova.
                    }else{

                        //Concatenamos as tags para adicionar no final na ultima TD do DATATABLE
       //                  links_html = $('<span></span>')
       //                      .append(TAG_A_VISUALIZAR)
       //                      .append(TAG_A_HISTORICO)
       //                      .append(TAG_A_EDITAR)
       //                      .append(TAG_A_FINALIZAR)
       //                      .append(TAG_A_EXCLUIR).html();

       //                  // Armazenamos todos os dados a serem inseridos na nova linha em uma array
       //                  arr = new Array(
       //                  	'<div class="habilitacao-EntidadeNomeFantasia">'			+ htmlEscape(hab.EntidadeNomeFantasia) 			+ '</div>',
							// '<div class="habilitacao-EntidadeTipoDescricao">'		+ htmlEscape(hab.EntidadeTipoDescricao) 		+ '</div>',
							// '<div class="habilitacao-UnidadeSigla">'				+ htmlEscape(hab.UnidadeSigla) 					+ '</div>',
							// '<div class="habilitacao-EntidadeUF">'					+ htmlEscape(hab.EntidadeUF)					+ '</div>',
							// '<div class="habilitacao-HabilitacaoDataFinalizacao">'	+ htmlEscape(hab.HabilitacaoDataFinalizacao)	+ '</div>',
							// '<div class="habilitacao-HabilitacaoValidade">'			+ htmlEscape(hab.HabilitacaoValidade)			+ '</div>',
							// '<div class="habilitacao-statusHabilitacao" style="color:#ff8a00">'	 		+ htmlEscape("Em Análise") 						+ '</div>',
							// '<div class="habilitacao-HabilitacaoRating">'			+ htmlEscape(hab.HabilitacaoRating)				+ '</div>',
       //                      links_html
       //                  );

       //                  // Criamos uma nova linha, com os dados a serem exibidos
       //                  // http://stackoverflow.com/questions/8239118/jquery-datatables-how-do-i-add-a-row-id-to-each-dynamically-added-row
       //                  var addId   = $('table#lista_habilitacoes').dataTable().fnAddData( arr );
       //                  var tr      = $('table#lista_habilitacoes').dataTable().fnSettings().aoData[addId[0]].nTr;

       //                  // Setamos os atributos do tr
       //                  $(tr).addClass(" alert lista_habilitacoes" + dados.habilitacaoid)
       //                      .data("habilitacaoid", dados.habilitacaoid)
       //                      .data("EntidadeNomeFantasia", hab.EntidadeNomeFantasia)
       //                      .data("habilitacaovalidade", hab.HabilitacaoValidade);

                    }

					success_message(dados.mensagem);
					$("#dialog-finalizar-habilitacao").modal('hide');

				} else {

					error_message(dados.mensagem);
					console.log(dados.mensagem + "\r\n"
							+ dados.exception);
				}

			},
			error : function(xhr, ajaxOptions, thrownError) {
				error_message("Não foi possível carregar os dados na finalização da habilitacao.");
				console.log("ERRO habilitacaofinalizar.form.js salvarAlteracoesHabilitacao:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ xhr.status
								+ " - "
								+ thrownError
								+ ")");
			}

		});

	}

}
