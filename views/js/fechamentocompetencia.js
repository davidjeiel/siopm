/*
 * Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
 * Em 24/04/2013
 * Para GIFUG/SP
 * Adaptado para o SIOPM por Paulo Cesar Vidal Souto, c091636, em 12/06/2015
 */
$(document).ready(function() {
	aplicarDatatableListaCompetenciasFechadas();
});

/*
* http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
*/
$(document).on("click", '.btn_fechar', function() {
	fecharCompetencia(0);
});

/*
* http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
* Adaptado por Alan Lima Em 17/06/2013
*/

$(document).off("click", "#lista_competencias td a.visualizar");
$(document).on("click", "#lista_competencias td a.visualizar", function() {
	var competenciafechadaid = $(this).closest("tr").data('competenciafechadaid');
	fecharCompetencia(competenciafechadaid);
});


function aplicarDatatableListaCompetenciasFechadas(){
	$('table#lista_competencias').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 2 ] }, 
			{ "orderable": false, "aTargets": [ 3 ] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}



function fecharCompetencia(competenciafechadaid) {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.fechamento.competencia.controller.php",
			data: {
				"ac": "FECHAR_COMPETENCIA",
				"competenciafechadaID": competenciafechadaid
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);
				$('#btn_finalizar').on('click', function(){	
					bootbox.confirm("Tem certeza que deseja fechar a competência \"" + htmlEscape($("#Competencia").val()) + "\"?", 
						function(confirmou) {
							if (confirmou) {
							  salvarAlteracoesCompetencias();
							}
					});		       
				      
				});
				aplicaDataTableTransacoesnaCompetencia();
				$("#dialog-manut-fechamento-competencia").modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO fechamentocompetencia.js editarOrcamento():\r\nNão foi possível carregar os dados.");
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

function salvarAlteracoesCompetencias(){

	var form = $('#dialog-manut-fechamento-competencia form');

	if ($(form).valid()){

		$.ajax({

		  url: app_path + "/controllers/ativos.fechamento.competencia.controller.php",
		  data: "ac=CONFIRMAR_FECHAMENTO_COMPETENCIA&" + form.serialize(),
		  dataType: "json",

		  success: function(dados) {

			if (dados.resultado == true) {	 				
                atualizarListaCompetencia();
				$("#dialog-manut-fechamento-competencia").modal('hide');
				success_message(dados.mensagem);

			} else {

				error_message(dados.mensagem);
				console.log(dados.mensagem + "\r\n"
						+ dados.exception);
			}

		  },
		  error: function(xhr, ajaxOptions, thrownError) {
			error_message("ERRO fechamentocompetencia.js CONFIRMAR_FECHAMENTO_COMPETENCIA:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			  xhr.status + " - " + thrownError + ")");
		  }
		});

	}// Validação de Usuário

}


function atualizarListaCompetencia(){
		
	$.ajax({
		url: app_path + "/controllers/ativos.fechamento.competencia.controller.php",
		data : {
			"ac" : "LISTAR_COMPETENCIAS_FECHADAS_ATUALIZACAO",
		},
		dataType : "html",
		success : function(lista) {
			$('#spanConteudo').html(lista);			
			aplicarDatatableListaCompetenciasFechadas();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO fechamentocompetencia.js atualizarListaAtivo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
	
}

//VER 1.0

function aplicaDataTableTransacoesnaCompetencia(){
	
	$('table#lista_trasancoes').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",		
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		"bPaginate": false,
		"sScrollY": "340px"
	});

}
