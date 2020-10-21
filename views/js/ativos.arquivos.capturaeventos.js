/*
 * Escrito por Alan Ferreira de Lima Filho, c066868
 * Adaptado para importacao e captura de eventos por  Paulo Souto,  c091636 em 14/05/2015
 */

// versão 2.0

 $(function () {

 	//VER .092
 	path_post			=  app_path + "/controllers/ativos.arquivos.captura.eventos.controller.php";
 	container_id 		=  'ArquivoUploader';

	var uploader_files = new plupload.Uploader({
		
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : $("#" + container_id + " .up-add").attr('id'), // you can pass in id...
        container: container_id, // you can pass in id...
        url : app_path + '/controllers/upload.arquivos.controller.php',
        flash_swf_url :  app_path + '/lib/plupload/js/Moxie.swf',
        silverlight_xap_url : app_path + '/lib/plupload/js/Moxie.xap',
        multi_selection: false,
        unique_names : true, // envia os arquivos com nomes aleatórios
        max_file_size : '50mb',
        chunk_size : '5mb',
        multipart : true,
        multipart_params : {

            "ac" : "upload"
    	},
        filters : [
			{title : "Excel", extensions : "xls, xlsx"}
        ],
  
        init: {

            PostInit: function(up) {
                $("#" + container_id + " .up-list input").val("");
                progressClear();
                $("#" + container_id + " .up-upload").off().on('click', function() {
                	up.start();
                    return false;
                });
            },

            BeforeUpload: function(up, file) {
            	up.settings.multipart_params['fileId'] = file.id;
            	up.settings.multipart_params['fileName'] = file.name;
            	up.settings.multipart_params['fileSize'] = file.size; 
            	/* 
            	*	É necessário enviar o File Type, pois arquivos maiores que o chunk sem esse envio são montados errados. 
            	*/
            	up.settings.multipart_params['fileType'] = file.type;             	
            	
            },

            FilesAdded: function(up, files) {
            	
				if(up.files.length > 1){
					f = up.files[0];
				    up.removeFile(f);
				    $('#' + f.id).html("");
				    up.refresh();
				}

				$("#" + container_id + " .up-list input").val("");
				progressClear();

				plupload.each(files,function(file, i) {	
                	$("#" + container_id + " .up-list input").val(file.name + ' (' + plupload.formatSize(file.size) + ')');
					$("#" + container_id + " .up-list .up-remove").off("click").on("click", function() {
				 	  	up.removeFile(file.id);
					  	progressClear();
					});
				});
            },	
			
            UploadProgress: function(up, file) {
            	$("#" + container_id + " .barra-progresso").css("width", file.percent + "%");
            	$("#" + container_id + " .barra-progresso").html(file.percent + "%");
            },

             //Disparado quando todos os arquivos forem enviados
            UploadComplete: function(up, file){
            	if (up.files.length > 0){
					$.ajax({
						url : path_post,
						data : {
							ac : "upload",
							 ArquivoDescricao : $('#ArquivoDescricao').val()
						},
						type : 'POST',
						dataType: 'json',
						success : function(dados) {
							
							progressClear();

							if (dados.result == true){
								success_message(dados.mensagem);
								atualizarListadeArquivos(); // essa funcao estao no arquivo capturaevento.js
							}else{
								progressError();
								error_message(dados.mensagem);
							}
						},
						error : function(jqXHR, textStatus, errorThrown) {
							progressError();
							alerta = ("ERRO ativos.file.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
									+ jqXHR.status + " - " + errorThrown + ")");
							console.log(alerta);
							error_message(alerta);
						}
					});
            	} 		
            },

            FileUploaded: function(up, file, response) {
            	resp = $.parseJSON(response.response);
            	if (!resp.result){
					up.trigger('Error', {
                        code : -300, // IO_ERROR
                        message : 'Upload Falhou',
                        details : file.name + ' falhou',
                        file : file
               		});
					progressError();
            		return;
            	}else{
					progressSuccess();
            	}
            },

            Error: function(up, err) {   
            	msg_err = "Error #" + err.code + ": " + err.message;
            	up.splice;
            	up.refresh;
            	progressError();
            	error_message(msg_err);
            	console.log(msg_err);
            }
        }

	}); 

	uploader_files.init();

	function progressSuccess(){
		$("#" + container_id + " .barra-progresso").removeClass("bar-info");
		$("#" + container_id + " .barra-progresso").removeClass("bar-danger");
		$("#" + container_id + " .barra-progresso").addClass("bar-success");
		$("#" + container_id + " .barra-progresso").css("width", "100%");
		$("#" + container_id + " .barra-progresso").html("Sucesso");
	}

	function progressClear(){
		$("#" + container_id + " .barra-progresso").removeClass("bar-sucess");
        $("#" + container_id + " .barra-progresso").removeClass("bar-danger");
		$("#" + container_id + " .barra-progresso").addClass("bar-info");
		$("#" + container_id + " .barra-progresso").css("width", "0");
		$("#" + container_id + " .barra-progresso").html("");
	}

	function progressError(){
		$("#" + container_id + " .barra-progresso").removeClass("bar-sucess");
        $("#" + container_id + " .barra-progresso").removeClass("bar-info");
		$("#" + container_id + " .barra-progresso").addClass("bar-danger");
		$("#" + container_id + " .barra-progresso").css("width", "100%");
		$("#" + container_id + " .barra-progresso").html("Erro");
	}

});



