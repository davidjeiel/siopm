
$(document).on("click", "table tbody tr a.contatos", function() {
	editarEntidadeContato($(this).closest("tr").data('entidadeid'));
});


function editarEntidadeContato(entidadeid) {

	$.ajax({
			url: app_path + "/controllers/entidades.controller.php",
			data: {
				"ac": "EDITAR_ENTIDADE_CONTATO",
				"EntidadeID": entidadeid
			},
			dataType: "html",
			success: function(form_retorno) {

				$('#spanForm').html(form_retorno);

				$("#dialog-entidade-contato .btn_salvar").off("click").on("click", function() {
					if ($('#divCamposContato').is(':visible')) salvarEntidadeContato();
				});

				$('#dialog-entidade-contato .btn_cancelar').on('click', function(){
					if ($('#divCamposContato').is(':visible')){
						$("#divCamposContato").hide();
						$('#divCamposContato input').val('');
						$("#div_lista_entidade_contatos").show();
					}else{
					   $("#dialog-entidade-contato").modal('hide');
					}
				});

				$('#div_lista_entidade_contatos .btn_novo_contato').on('click', function(){
					$("#divCamposContato").show();
					$("#div_lista_entidade_contatos").hide();
				});

				$("#dialog-entidade-contato").modal('show');

			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidade.js editarEntidadeContato:\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}


function excluirEntidadeContato(EntidadeContatoID){
	
	$.ajax(
	 	{
	 		url: app_path + "/controllers/entidades.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ENTIDADE_CONTATO",
	 			"EntidadeContatoID": EntidadeContatoID
	 		},
	 		dataType: "json",
	 		success: function(data) {
				if (data.resultado == true) {
					tr = $("table#lista_entidade_contatos tbody tr.entidadecontato_" + EntidadeContatoID ).get(0);
					pos = $("table#lista_entidade_contatos").dataTable().fnGetPosition(tr);
					$("table#lista_entidade_contatos").dataTable().fnDeleteRow(pos);
					success_message(data.mensagem);
				} else {
					error_message(data.mensagem);
					console.log(data.mensagem + "\r\n" + data.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidades.js excluirEntidadeContato:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}

function salvarEntidadeContato(){

	var form = $('#dialog-entidade-contato form');

	ContatoID          = $(form).find("input[name=ContatoID]").val();
	EntidadeContatoID  = $(form).find("input[name=EntidadeContatoID]").val();
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

			url: app_path + "/controllers/entidades.controller.php",
			data: "ac=SALVAR_ENTIDADE_CONTATO&" + form.serialize(),
			dataType: "json",

			success: function(dados) {

				if (dados.resultado == true) {

					//Verificamos de já existe uma TR com o ID gravado. Se sim editamos. Se não criamos uma TR nova.
					if ($("table#lista_entidade_contatos tbody tr.entidadecontato_" + EntidadeContatoID).length > 0){

						// Atualiza a tr existente
						tr =  $("table#lista_entidade_contatos tbody tr.entidadecontato_" + EntidadeContatoID);

						//Atualizamos os valores dos atributos data
						$(tr).data('contatoid', ContatoID);
						$(tr).data('entidadecontatoid', EntidadeContatoID);
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
						EntidadeContatoID = dados.entidadecontatoid;
						
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
						var addId   = $("table#lista_entidade_contatos").dataTable().fnAddData( arr );
						var tr      = $("table#lista_entidade_contatos").dataTable().fnSettings().aoData[addId[0]].nTr;

						// Setamos os atributos do tr
						$(tr).addClass("entidadecontato_" + EntidadeContatoID)
							.data('contatoid', ContatoID)
							.data('entidadecontatoid', EntidadeContatoID)
							.data('contatonome', ContatoNome);
					}

					$("#divCamposContato").hide();
					$('#divCamposContato input').val('');
								
					$("#div_lista_entidade_contatos").show();
					applyDataTableByID("lista_entidade_contatos", "130px");                  

					success_message(dados.mensagem);

				} else {

					error_message(dados.mensagem);
					console.log(dados.mensagem + "\r\n"
							+ dados.exception);
				}

		  	},

			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO entidades.js salvarEntidadeContato:\r\nNão foi possível carregar os dados\r\n\r\n(" +
				  xhr.status + " - " + thrownError + ")");
			}

		});

	}

}
