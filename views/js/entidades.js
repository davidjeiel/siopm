/*
 * Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
 * Em 24/04/2013
 * Para GIFUG/SP
 * Adaptado ao SIOPM por Alan Ferreira de Lima Filho, c066868 em 04/06/2013
 */
$(document).ready(function() {
	applyDataTableByID("lista_entidades");
});

/*
 * http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
 * Adaptado por Alan Lima Em 17/06/2013
 */
$(document).on("click", "table#lista_entidades tbody tr a.excluir", function() {
			var entidadeid = $(this).closest("tr").data('entidadeid');
			var cnpj = $(this).closest("tr").data('cnpj');
			var nome = $(this).closest("tr").data('nome');
		  bootbox.confirm("Tem certeza que deseja apagar a entidade \"" + htmlEscape(cnpj) + " - " + htmlEscape(nome) + "\"?", function(confirmou) {
			    if (confirmou) {
			      excluirEntidade(cnpj, entidadeid);
			    }
		  });

	});

$(document).on("click", '.btn_novo', function() {
	editarEntidade(0);
});

$(document).on("click", '.visualizar', function() {
	visualizarEntidade(($(this).closest("tr").data('entidadeid')));
});

$(document).on("click", "table#lista_entidades tbody tr a.editar", function() {
	editarEntidade($(this).closest("tr").data('entidadeid'));
});

$(document).on("blur", "#EntidadeCnpj", function() {
	var cnpj = $(this).val();
	if (cnpj != "__.___.___/____-__"){
		findCNPJ (cnpj);
	}
});

function findCNPJ(entidadecnpj){

	if($('#EntidadeID').val()>0) return;

	$.ajax(
		{
			url: app_path + "/controllers/entidades.controller.php",
			data: {
				"ac": "PROCURAR_ENTIDADE",
				"EntidadeCnpj": entidadecnpj
			},
			dataType: "json",

			success: function(dados) {

				if (dados.EntidadeID > 0){

					var mensagem = "A empresa \"" + htmlEscape(dados.EntidadeCnpj) + " - " + htmlEscape(dados.EntidadeNomeFantasia) + "\"" + 
								" foi excluída do SIOPM. Deseja resgatar as informações?";

					if(dados.EntidadeAtiva == 1 ) {

						mensagem = "A empresa \"" + htmlEscape(dados.EntidadeCnpj) + " - " + htmlEscape(dados.EntidadeNomeFantasia) + "\"" + 
									" já está cadastrada. Deseja editá-la?";

					}

					bootbox.confirm(mensagem, function(confirmou) {						    
					    if (confirmou) {
							$('#EntidadeID').val(dados.EntidadeID);
			      			$('#EntidadeAtiva').val(1);
			      			$('#EntidadeCnpj').val(dados.EntidadeCnpj);
			      			$('#EntidadeCnpj').attr("readonly", "readonly");
			      			$('#matriculaCOP').val(dados.matriculaCOP);
			      			$('#EntidadeTipoID').val(dados.EntidadeTipoID);
			      			$('#EntidadeNomeRazao').val(dados.EntidadeNomeRazao);
			      			$('#EntidadeNomeFantasia').val(dados.EntidadeNomeFantasia);
			      			$('#EntidadeDataAbertura').val(dados.EntidadeDataAbertura);
			      			$('#EntidadeObs').val(dados.EntidadeObs);
			      			$('#EntidadeFones').val(dados.EntidadeFones);	      			
			      			$('#EntidadeDataAbertura').val(dados.EntidadeDataAbertura);
			      			$('#EntidadeEmail').val(dados.EntidadeFones);
			      			$('#EntidadeCEP').val(dados.EntidadeCEP);	      			
			      			$('#EntidadeLogradouro').val(dados.EntidadeObs);
			      			$('#EntidadeNumero').val(dados.EntidadeObs);
			      			$('#EntidadeComplemento').val(dados.EntidadeComplemento);
			      			$('#EntidadeBairro').val(dados.EntidadeBairro);
			      			$('#EntidadeCidade').val(dados.EntidadeCidade);
			      			$('#EntidadeUF').val(dados.EntidadeUF);  
			      			$('#EntidadeResponsavelFones').val(dados.EntidadeResponsavelFones);
			      			$('#EntidadeResponsavelEmail').val(dados.EntidadeResponsavelEmail);
						} else{
							$('#EntidadeCnpj').val("");							
						}


					});									 			

      			}		
		
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidade.js findCNPJ:\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}

function visualizarEntidade(entidadeid) {

	$.ajax(
		{
			url: app_path + "/controllers/entidades.controller.php",
			data: {
				"ac": "VISUALIZAR_ENTIDADE",
				"EntidadeID": entidadeid
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$('#btn_salvar').hide();
				$('#btn_cancelar').text("Fechar");
				$("#dialog-manut-entidade form :input").attr("disabled", "disabled");
				$("#dialog-manut-entidade").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidade.js visualizarEntidade:\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function editarEntidade(entidadeid) {

	$.ajax(
		{
			url: app_path + "/controllers/entidades.controller.php",
			data: {
				"ac": "EDITAR_ENTIDADE",
				"EntidadeID": entidadeid
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$('#btn_salvar').on('click', function(){
					salvarAlteracoesEntidade();
				});
				if ($("#EntidadeID").val() > 0) $("#EntidadeCnpj").attr("readonly", "readonly");
				$("#dialog-manut-entidade").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidade.js editarEntidade:\r\nNão foi possível carregar os dados.");
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

function excluirEntidade(cnpj, entidadeid) {

	$.ajax(
		{
			url: app_path + "/controllers/entidades.controller.php",
			data: {
				"ac": "EXCLUIR_ENTIDADE",
				"EntidadeCnpj": cnpj,
				"EntidadeID": entidadeid
			},
			dataType: "json",
			success: function(json) {

				if (json.resultado == true) {

					tr = $("table#lista_entidades tbody tr.entidade_" + entidadeid ).get(0);
					pos = $("table#lista_entidades").dataTable().fnGetPosition(tr);
					$("table#lista_entidades").dataTable().fnDeleteRow(pos);

					success_message(json.mensagem);
					
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidade.js excluirEntidade:\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function salvarAlteracoesEntidade(){

	var form = $('#dialog-manut-entidade form');

	if ($(form).valid()){

		$.ajax({

		  url: app_path + "/controllers/entidades.controller.php",
		  data: "ac=SALVAR_ENTIDADE&" + form.serialize(),
		  dataType: "json",

		  success: function(dados) {

			if (dados.resultado == true) {
				
				//Criamos as variáveis que serão usadas na DATATABLE e preenchemos com o que foi digitado no FORM
                    EntidadeID            	= $(form).find("input[name=EntidadeID]").val();
                    EntidadeCnpj         	= $(form).find("input[name=EntidadeCnpj]").val();
                    EntidadeTipoID     		= $(form).find("input[name=EntidadeTipoID]").val();
                    EntidadeTipoDescricao	= $(form).find("#EntidadeTipoID :selected").text();
                    EntidadeNomeRazao		= $(form).find("input[name=EntidadeNomeRazao]").val();
                    EntidadeDataAbertura	= $(form).find("input[name=EntidadeDataAbertura]").val();
                    EntidadeFones			= $(form).find("input[name=EntidadeFones]").val();

                    //Verificamos de já existe uma TR com o ID gravado. Se sim editamos. Se não criamos uma TR nova.
                    if ($("table#lista_entidades tbody tr.entidade_" + EntidadeID).length > 0){

                        // Atualiza a tr existente
                        tr =  $("table#lista_entidades tbody tr.entidade_" + EntidadeID); 

                        //Atualizamos os valores dos atributos data
						$(tr).data('cnpj', EntidadeCnpj);
                        $(tr).data('nome', EntidadeNomeRazao);
                        $(tr).data('entidadeid', EntidadeID);
                                               
                        //Atualizamos os valores da TR
                        $(tr).find(".entidadecnpj"       	).text(EntidadeCnpj);
                        $(tr).find(".entidadetipodescricao" ).text(EntidadeTipoDescricao);
                        $(tr).find(".entidadenome"      	).text(EntidadeNomeRazao);
                        $(tr).find(".entidadedataabertura"  ).text(EntidadeDataAbertura);
                        $(tr).find(".entidadefones"       	).text(EntidadeFones);
                       
                    //Caso não exista, criamos uma TR Nova.
                    }else{

                    	EntidadeID = dados.entidadeid;
                        //Concatenamos as tags para adicionar no final na ultima TD do DATATABLE
                        links_html = $('<span></span>')
                            .append(TAG_A_VISUALIZAR)
                            .append(TAG_A_EDITAR)
                            .append(TAG_A_EXCLUIR).html();

                        // Armazenamos todos os dados a serem inseridos na nova linha em uma array
                        arr = new Array(
                            '<div class="entidadecnpj">'         	+ htmlEscape(EntidadeCnpj)        	+ '</div>', 
                            '<div class="entidadetipodescricao">'   + htmlEscape(EntidadeTipoDescricao) + '</div>', 
                            '<div class="entidadenome">'         	+ htmlEscape(EntidadeNomeRazao)     + '</div>', 
                            '<div class="entidadedataabertura">'    + htmlEscape(EntidadeDataAbertura)  + '</div>', 
                            '<div class="entidadefones">'    		+ htmlEscape(EntidadeFones)   		+ '</div>',
                            links_html
                        );

                        // Criamos uma nova linha, com os dados a serem exibidos
                        // http://stackoverflow.com/questions/8239118/jquery-datatables-how-do-i-add-a-row-id-to-each-dynamically-added-row
                        var addId   = $('table#lista_entidades').dataTable().fnAddData( arr );
                        var tr      = $('table#lista_entidades').dataTable().fnSettings().aoData[addId[0]].nTr;

                        // Setamos os atributos do tr
                        $(tr).addClass("entidade_" + EntidadeID)
                        	.data('cnpj', EntidadeCnpj)
                        	.data('nome', EntidadeNomeRazao)
                        	.data('entidadeid', EntidadeID);
                    }			
				
				$("#dialog-manut-entidade").modal('hide');

				success_message(dados.mensagem);

			} else {

				error_message(dados.mensagem);
				console.log(dados.mensagem + "\r\n"
						+ dados.exception);
			}

		  },
		  error: function(xhr, ajaxOptions, thrownError) {
			error_message("ERRO entidades.js salvarAlteracoesEntidade:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			  xhr.status + " - " + thrownError + ")");
		  }
		});

	}// Validação de Usuário

}
