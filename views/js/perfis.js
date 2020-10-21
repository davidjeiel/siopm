/*
 * Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
 * Em 24/04/2013
 * Para GIFUG/SP
 * Adaptado ao SIOPM por Alan Ferreira de Lima Filho, c066868 em 04/06/2013
 */

$(document).ready(function() {

    applyDataTableByID("lista_perfis");

});

    //$("#lista_perfis a.excluir").off("click").on("click" , function () {

$(document).on("click", "table#lista_perfis tbody tr a.excluir", function() {
    var perfilnome = $(this).closest("tr").data('nome');
    var perfilid = $(this).closest("tr").data('perfilid');
    bootbox.confirm("Tem certeza que deseja apagar o perfil \"" + htmlEscape(perfilnome) + "\"?", 
        function(confirmou) { 
        if (confirmou) {      
        excluirPerfil(perfilid);
        }
    });
});

$(document).on("click", '.btn_novo', function() {
    editarPerfil(0);  
});

$(document).on("click", "table#lista_perfis tbody tr a.editar", function() { 
    editarPerfil($(this).closest("tr").data('perfilid'));
});  

$(document).on("click", "table#lista_perfis a.visualizar" , function() { 
    visualizarPerfil($(this).closest("tr").data('perfilid'));
}); 

function editarPerfil(PerfilID) {
 
  $.ajax({
	url: app_path + "/controllers/perfis.controller.php", 
	data: {"ac":"EDITAR_PERFIL", "PerfilID": PerfilID},
	dataType:"html",
	success:  function(dados) {
	  
		$('#spanForm').html(dados);
		$(".btn_salvar_perfil").off("click").on("click", function(){salvarAlteracoesPerfil()});
		$("#dialog-manut-perfil").modal('show');
			  },
	error: function (xhr, ajaxOptions, thrownError) {
        bootbox.alert("ERRO perfil.js excluirPerfis:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
			xhr.status + " - " + thrownError + ")");
        }
    });
}

/*
 * Escrito por Alan Ferreira de Lima Filho
 * c066868 Em 17/06/2013
 * Posta para o Controller
 */
function excluirPerfil(PerfilID) {

    $.ajax({
        url: app_path + "/controllers/perfis.controller.php",
        data: { "ac": "EXCLUIR_PERFIL", "PerfilID": PerfilID },
        dataType: "json",    
	
        success: function (dados) {
	  
            if (dados.resultado == true) { 

                /*
                * Excluindo um perfil da DATATABLE...
                */

                // Pegamos a TR específica através de uma classe identificadora (no caso 'perfil_') com o id concatenado.
                tr  =    $("table#lista_perfis tbody tr.perfil_" + PerfilID).get(0);
                // Como se trata de um DATATABLE, devemos pegar a posição dessa tr no datatable.
                pos =   $("table#lista_perfis").dataTable().fnGetPosition(tr);
                // Agora excluimos a linha dessa posição no DATATABLE
                $("table#lista_perfis").dataTable().fnDeleteRow(pos);

                success_message(dados.mensagem);

            } else {
                
                error_message(dados.mensagem);
                console.log(dados.mensagem + "\r\n" + dados.exception);

            }
        },
	
        error: function (xhr, ajaxOptions, thrownError) {  
            bootbox.alert("ERRO perfil.js excluirPerfil:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
            xhr.status + " - " + thrownError + ")");
        }

    }); 

}

function salvarAlteracoesPerfil(){

    var form = $('#dialog-manut-perfil form');
    var PerfilID = "";

    if ( $(form).valid() ) {

        $.ajax({

            url : app_path + "/controllers/perfis.controller.php",
            data : "ac=SALVAR_PERFIL&" + form.serialize(),
            dataType : "json",

            success : function(dados) {

                if (dados.resultado == true) {

                    //Criamos as variáveis que serão usadas na DATATABLE e preenchemos com o que foi digitado no FORM
                    PerfilID            = $(form).find("input[name=PerfilID]").val();
                    PerfilNome          = $(form).find("input[name=PerfilNome]").val();
                    PerfilDescricao     = $(form).find("input[name=PerfilDescricao]").val();

                    //Verificamos de já existe uma TR com o ID gravado. Se sim editamos. Se não criamos uma TR nova.
                    if ($("table#lista_perfis tbody tr.perfil_" + PerfilID).length > 0){

                        // Atualiza a tr existente
                        tr =  $("table#lista_perfis tbody tr.perfil_" + PerfilID); 

                        //Atulizamos os valores dos atributos data
                        $(tr).data('nome', PerfilNome);
                        $(tr).data('descricao', PerfilDescricao);

                        //Atualizamos os valores da TR
                        $(tr).find(".perfil-nome"       ).text(PerfilNome);
                        $(tr).find(".perfil-descricao"  ).text(PerfilDescricao);

                    //Caso não exista, criamos uma TR Nova.
                    }else{

                        // Criamos os links, TAG A de edição e exclusão
                        // a_visualizar    = $("<a></a>").attr('class',"visualizar").attr('href',"javascript:void(0);").append(img_tag_visualizar);
                        // a_editar        = $("<a></a>").attr('class',"editar").attr('href',"javascript:void(0);").append(img_tag_editar);
                        // a_excluir       = $("<a></a>").attr('class',"excluir").attr('href',"javascript:void(0);").append(img_tag_excluir);                        

                        //Concatenamos as tags para adicionar no final na ultima TD do DATATABLE
                        links_html = $('<span></span>')
                            .append(TAG_A_VISUALIZAR)
                            .append(TAG_A_EDITAR)
                            .append(TAG_A_EXCLUIR).html();

                        // Armazenamos todos os dados a serem inseridos na nova linha em uma array
                        arr = new Array(
                            '<div class="perfil-nome">'         + htmlEscape(PerfilNome)        + '</div>', 
                            '<div class="perfil-descricao">'    + htmlEscape(PerfilDescricao)   + '</div>', 
                            links_html
                        );

                        // Criamos uma nova linha, com os dados a serem exibidos
                        // http://stackoverflow.com/questions/8239118/jquery-datatables-how-do-i-add-a-row-id-to-each-dynamically-added-row
                        var addId   = $('table#lista_perfis').dataTable().fnAddData( arr );
                        var tr      = $('table#lista_perfis').dataTable().fnSettings().aoData[addId[0]].nTr;

                        // Setamos os atributos do tr
                        $(tr).addClass("perfil_" + dados.perfilid)
                            .data("perfilid", dados.perfilid)
                            .data("nome", PerfilNome)
                            .data("descricao", PerfilDescricao);

                    }

                    $("#dialog-manut-perfil").modal('hide');
                    
                    success_message(dados.mensagem);

                } else {

                    error_message(dados.mensagem);
                    console.log(dados.mensagem + "\r\n"
                    + dados.exception);

                }

            },

            error : function(xhr, ajaxOptions, thrownError) {

            bootbox.alert("ERRO perfil.js salvarAlteracoesPerfil:\r\nNão foi possível carregar os dados\r\n\r\n("
                + xhr.status
                + " - "
                + thrownError
                + ")");
            }

        });

    }

}

function visualizarPerfil(PerfilID) {

    $.ajax({
        url: app_path + "/controllers/perfis.controller.php",
        data: {
        "ac": "VISUALIZAR_PERFIL",
        "PerfilID": PerfilID
        },
        dataType: "html",
            success: function(form_retorno) {
            $('#spanForm').html(form_retorno);
            $('#btn_salvar').hide();
            $('#btn_cancelar').text("Fechar");
            $("#dialog-manut-perfil form :input").attr("disabled", "disabled");
            $("#dialog-manut-perfil").modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            error_message("ERRO perfil.js visualizarPerfil:\r\nNão foi possível carregar os dados.");
            console.log(xhr.status + " - " + thrownError );
        }
    });

}