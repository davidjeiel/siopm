$(function () {

	var hab_risco_uploader = new plupload.Uploader({
		
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'add_HabRiscoArquivo', // you can pass in id...
        container: 'HabRiscoArquivoUploader', //document.getElementById('HabRiscoArquivoUploader'), // Apenas funciona gerElementById
        url : app_path + '/controllers/upload.arquivos.controller.php',
        flash_swf_url :  app_path + '/lib/plupload/js/Moxie.swf',
        silverlight_xap_url : app_path + '/lib/plupload/js/Moxie.xap',
        multi_selection: false,
        unique_names : true, // envia os arquivos com nomes aleatórios
        max_file_size : '50mb',
        chunk_size : '5mb',
        multipart : true,
        multipart_params : {
            "ac" : "upload",
            "sender" : "hab_risco",
    	},
        filters : [
	  		{title : "Imagem", extensions : "jpeg,jpg,gif,png"},
            {title : "Zip", extensions : "zip"},
            {title : "7-zip", extensions : "7z"},
			{title : "PDFs", extensions : "pdf"},
			{title : "Word", extensions : "doc,docx"},
			{title : "Excel", extensions : "xls,xlsx"}
        ],

        init: {

            PostInit: function() {

                $('#listFilesHabRiscoArquivo').html("");
                $('#up_HabRiscoArquivo').off().on('click', function() {
                	hab_risco_uploader.start();
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
            	/* Bloqueia para apenas um arquivo */
                if(up.files.length > 1){
					f = up.files[0];
				    hab_risco_uploader.removeFile(f);
				    $('#' + f.id).hide("slow");
				    hab_risco_uploader.refresh();
				}

				/* Adicona arquivo no list */
				plupload.each(files,function(file, i) {

					$('#listFilesHabRiscoArquivo').append(
						'<div class="" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) 
						+ ') <a href="#" class="remove btn btn-small"><i class="icon-remove"></i> Remover </a> <b></b> </div>'
					);

					$('#' + file.id + ' a.remove').off().on("click", function() {
				   		hab_risco_uploader.removeFile(file.id);
					  	$('#' + file.id).hide("slow");
					});

				});

            },	
			
            UploadProgress: function(up, file) {
            	/* Mostra progresso upload */
            	$('#' + file.id + ' a.remove').hide();
                $('#' + file.id + ' b').first().html('<span>' + file.percent + '%</span>');
            },

            FileUploaded: function(up, file, response) {
            	if (!response.result){
					up.trigger('Error', {
                        code : -300, // IO_ERROR
                        message : 'Upload Failed',
                        details : file.name + ' failed',
                        file : file
               		});
            		return;
            	}
            },

            //Disparado quando todos os arquivos forem enviados
            UploadComplete: function(up, file){

    			$.ajax({

					url : app_path + "/controllers/habilitacao.files.controller.php",
					data : {
						ac : "upload",
						HabilitacaoID : $('#HabilitacaoID').val(),
						HabRiscoArquivoID : $('#HabRiscoArquivoID').val(),
						HabRiscoID : $('#HabRiscoID').val()
					},
					type : 'POST',
					dataType: 'json',
					success : function(dados) {

						if (dados.resultado == true){
							
							$('#HabRiscoArquivoUploader .up-file-name').html(dados.filename);
							$('#HabRiscoArquivoID').val(dados.arquivoid);
							$('#HabRiscoArquivoUploader .area-up-files').hide('slow'); 
							$('#HabRiscoArquivoUploader .area-view-files').show('slow');

							success_message(dados.mensagem);
							
						}else{
							error_message(dados.mensagem);
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alerta = ("ERRO habilitacao.file.risco.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ jqXHR.status + " - " + errorThrown + ")");
						console.log(alerta);
						error_message(alerta);
					}
				});
				
				$('#listFilesHabRiscoArquivo').html("");

            },

            Error: function(up, err) {   
            	msg_err = "Error #" + err.code + ": " + err.message;
            	hab_risco_uploader.splice;
            	hab_risco_uploader.refresh;
            	error_message(msg_err);
            	console.log(msg_err);
            }
        }

	});

	hab_risco_uploader.init();

	$('#HabRiscoArquivoUploader .up-del').off("click").on("click", function(){
		var result = confirm("Deseja excluir PERMANENTEMENTE este arquivo do banco de dados?");
		if (result) excluirHabRiscoFile();
	});

	$('#HabRiscoArquivoNome').off("click").on("click", function(){
		downloadHabRiscoFile();		
	});

	function downloadHabRiscoFile() {
		  
		window.open( app_path + "/controllers/habilitacao.files.controller.php" 
			+ "?ac=download&HabilitacaoID=" 
			+ $('#HabilitacaoID').val() 
			+ "&HabRiscoArquivoID="
			+ $('#HabRiscoArquivoID').val()
			+ "&HabRiscoID=" 
			+ $('#HabRiscoID').val());

	};


	function excluirHabRiscoFile() {

		$
		.ajax({
			url : app_path + "/controllers/habilitacao.files.controller.php",
			data : {
				"ac" : "delete",
				"HabRiscoArquivoID" : $('#HabRiscoArquivoID').val(),
				"HabRiscoID" : $('#HabRiscoID').val()
			},
			dataType : "json",
			success : function(data) {
				if (data.resultado == true) {

					$('#HabRiscoArquivoUploader .up-file-name').html("");
					$('#HabRiscoArquivoUploader .area-view-files').hide();
					$('#HabRiscoArquivoUploader .area-up-files').show('slow'); 
					$('#HabRiscoArquivoID').val("");
					$('#listFilesHabRiscoArquivo').html("");
					success_message(data.mensagem);

				} else {
					error_message(data.mensagem);
					console.log(data.mensagem + "\r\n" + data.exception);
				}
			},
			error : function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO habilitacao.file.risco.js excluirHabRiscoFile:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ xhr.status + " - " + thrownError + ")");
			}
		});

	}


})