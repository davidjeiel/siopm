/*
 * Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
 * Em 24/04/2013
 * Para GIFUG/SP
 * Adaptado ao SIOPM por Alan Ferreira de Lima Filho, c066868 em 04/06/2013
 */

// versão 1.0

$(document).ready(function() {
    aplicaDataTableUsuarios();  
});

function aplicaDataTableUsuarios(){
  
  $('.conteudo-usuario table#lista_usuarios').dataTable({
    "oLanguage": {
      "sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
      "sInfoThousands": "."
    },
    "order": [ 1, 'asc' ],
    "sEmptyTable": "Nenhum registro encontrado.",
    "aoColumnDefs":[
      {"orderable": false, "aTargets": [4] }
    ],
    "sDom": '<"top">rt<"bottom"iflp><"clear">',
     "bPaginate": false,
    "sScrollY": "400px"
  });
}


$(document).on("click", "table#lista_usuarios tbody tr a.excluir", function () {
  var matricula = $(this).closest("tr").data('matricula');
  var nome = $(this).closest("tr").data('nome');
  bootbox.confirm("Tem certeza que deseja apagar o usuário \"" + htmlEscape(matricula) + " - " + htmlEscape(nome) + "\"?", 
    function(confirmou) { 
    if (confirmou) {
      excluirUsuario(matricula);
    }
  });
});

/*
 * http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
 */
 /*
 * http://stackoverflow.com/questions/10626885/passing-data-to-a-bootstrap-modal
 * Adaptado por Alan Lima Em 17/06/2013
 */

$(document).on("click", '.btn_novo_usuario', function() {
  editarUsuario(0);
});

$(document).on("click", "table#lista_usuarios tbody tr a.editar", function() {
  editarUsuario($(this).closest("tr").data('matricula'));
});

$(document).on("click", '.visualizar', function() {
  visualizarUsuario(($(this).closest("tr").data('matricula')));
});

function editarUsuario(matricula) {
  
  $.ajax({
    url: app_path + "/controllers/usuarios.controller.php",
    data: { 
      "ac": "EDITAR_USUARIO", 
      "UsuarioMatricula": matricula 
    },
    dataType: "html",
    success: function (dados) {
      
      $('#spanUsuariosForm').html(dados);
      if ($("input[name=UsuarioMatricula]").val().length == 7 ) $("#divPesquisaMatricula").hide();
      $(".btn_pesquisa_usuario").off("click").on("click", function(){pesquisaMatricula()});
      $(".btn_salvar_usuario").off("click").on("click", function(){salvarAlteracoesUsusario()});
    },  
     error: function (xhr, ajaxOptions, thrownError) {
      error_message("ERRO usuarios.js editarUsuario:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
              xhr.status + " - " + thrownError + ")");
    } 

  });

  $("#dialog-manut-usuario").modal('show');
  
}

/*
 * Escrito por Alan Ferreira de Lima Filho
 * c066868 Em 17/06/2013
 * Posta para o Controller
 */
function excluirUsuario(matricula) {
      
  $.ajax({
    url: app_path + "/controllers/usuarios.controller.php",
    data: { 
      "ac": "EXCLUIR_USUARIO", 
      "UsuarioMatricula": matricula 
    },
    dataType: "json",    
    success: function (data) {
      
      if (data.resultado == true) { 

        // Excluímos o perfil na tabela de usuários
        tr =    $("table#lista_usuarios tbody tr.usuario_" + matricula).get(0);
        pos =   $("table#lista_usuarios").dataTable().fnGetPosition(tr);
        $("table#lista_usuarios").dataTable().fnDeleteRow(pos);

        success_message(data.mensagem);
      } else {
        error_message(data.mensagem);
        console.log(data.mensagem + "\r\n" + data.exception);
      }

    },
    error: function (xhr, ajaxOptions, thrownError) {
      error_message("ERRO usuarios.js excluirUsuario:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
              xhr.status + " - " + thrownError + ")");
    } 
  });

}

function salvarAlteracoesUsusario(){

    var form = $('#dialog-manut-usuario form');

    var matricula = "";

    matricula = $(form).find("input[name=UsuarioMatricula]").val();
   
    if ( $(form).find("input[name=UsuarioMatricula]").val().length == 7 ){

      $.ajax({

        url: app_path + "/controllers/usuarios.controller.php",
        data: "ac=SALVAR_USUARIO&" + form.serialize(),
        dataType: "json",

        success: function (data) {

          $("#dialog-manut-usuario").modal('hide');

          if (data.resultado == true) { 

            atualizarListaUsuarios()
            success_message(data.mensagem);

          }else {
            error_message(data.mensagem);
            console.log(data.mensagem + "\r\n" + data.exception);
          }

        },
        error: function (xhr, ajaxOptions, thrownError) {
          error_message("ERRO usuarios.js salvarAlteracoesUsusario:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
              xhr.status + " - " + thrownError + ")"); 
        }
      });
    }else{ bootbox.alert("Pesquise uma matrícula válida antes de salvar!")}
}

function pesquisaMatricula() {

  matricula = $(".btn_pesquisa_usuario").parent().find("input").val();

  $.ajax({
    url: app_path + "/controllers/usuarios.controller.php",
    data: {
      "ac": "PROCURAR_USUARIO",
      "UsuarioMatricula" : matricula
    },
    type: 'POST',
    dataType: 'json',
    success: function(usuario) {

      // var nomeUsuario = usuario.UsuarioNome;

      // nomeUsuario = nomeUsuario.substr(0, 1).toUpperCase() + nomeUsuario.substr(1).toLowerCase();

      $('#UsuarioMatricula').val(usuario.UsuarioMatricula);
      $('#UnidadeID').val(usuario.UnidadeID);
      $('#UsuarioNome').val(usuario.UsuarioNome);
      $('#UsuarioDataCadastro').val(usuario.UsuarioDataCadastro);
      $('#UsuarioAtivo').val(usuario.UsuarioAtivo);
      $('#UnidadeNome').val(usuario.UnidadeNome);
      $('#UnidadeSigla').val(usuario.UnidadeSigla);
      $('#UnidadeEmail').val(usuario.UnidadeEmail);
      $("#PerfilID option[value=" + usuario.PerfilID + "]").attr('selected', 'selected');

    },
    error: function(jqXHR, textStatus, errorThrown) {
      bootbox.alert("ERRO usuarios.js pesqusiaMatricula:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
              xhr.status + " - " + thrownError + ")"); 
    }
  });

}

function visualizarUsuario(matricula) {

 $.ajax({
    url: app_path + "/controllers/usuarios.controller.php",
    data: { 
      "ac": "VISUALIZAR_USUARIO",
      "UsuarioMatricula": matricula
    },
    dataType: "html",
    success: function (dados) {
  $('#spanUsuariosForm').html(dados);
        $("#divPesquisaMatricula").hide();
        $('#btn_salvar_usuario').hide();
        $('#btn_cancelar_usuario').text("Fechar");
        $("#dialog-manut-usuario form :input").attr("disabled", "disabled");
        $("#dialog-manut-usuario").modal('show');      
      
    },  
     error: function (xhr, ajaxOptions, thrownError) {
      error_message("ERRO usuarios.js visualizarUsuario:\r\nNão foi possível carregar os dados\r\n\r\n(" + 
              xhr.status + " - " + thrownError + ")");
    } 
  });

  $("#dialog-manut-usuario").modal('show');
  
}

function atualizarListaUsuarios(){
    
  $.ajax({
    url: app_path + "/controllers/usuarios.controller.php",
    data : {
      "ac" : "LISTAR_USUARIOS_ATUALIZACAO",
    },
    dataType : "html",
    success : function(lista) {
      $('#spanConteudo').html(lista);     
      aplicaDataTableUsuarios();
    },
     error: function(xhr, ajaxOptions, thrownError) {
    bootbox.alert("ERRO usuarios.js atualizarListaAtivo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
      xhr.status + " - " + thrownError + ")");
    }
  });
  
}