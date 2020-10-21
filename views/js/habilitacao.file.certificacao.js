


$(function () {

	var hab_cert = new plupload.Uploader({
		
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'add_HabCertArquivo', // you can pass in id...
        container: 'HabCertUploader', //document.getElementById('HabCertUploader'), // Apenas funciona gerElementById
        url : app_path + '/controllers/upload.arquivos.controller.php',
        flash_swf_url :  app_path + '/lib/plupload/js/Moxie.swf',
        silverlight_xap_url : app_path + '/lib/plupload/js/Moxie.xap',
        multi_selection: false,
        unique_names : true, // envia os arquivos com nomes aleatórios
        max_file_size : '50mb',
        chunk_size : '5mb',
        filters : [
	  		{title : "Imagem", extensions : "jpeg,jpg,gif,png"},
            {title : "Zip", extensions : "zip"},
            {title : "7-zip", extensions : "7z"},
			{title : "PDFs", extensions : "pdf"},
			{title : "Word", extensions : "doc,docx"},
			{title : "Excel", extensions : "xls,xlsx"}
        ],

        multipart_params : {
            "ac" : "upload"
    	},
  
        init: {

            PostInit: function() {

                $('#listFilesHabCertArquivo').html("");
                $('#up_HabCertArquivo').off().on('click', function() {
                	hab_cert.start();
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
				    hab_cert.removeFile(f);
				    $('#' + f.id).hide("slow");
				    hab_cert.refresh();
				}

				plupload.each(files,function(file, i) {

					$('#listFilesHabCertArquivo').append(
						'<div class="" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) 
						+ ') <a href="#" class="remove btn btn-small"><i class="icon-remove"></i> Remover </a> <b></b> </div>'
					);

					$('#' + file.id + ' a.remove').off().on("click", function() {
				   		hab_cert.removeFile(file.id);
					  	$('#' + file.id).hide("slow");
					});

				});

            },	
			
            UploadProgress: function(up, file) {
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
						HabCertArquivoID : $('#HabCertArquivoID').val(),
						HabCertID : $('#HabCertID').val()
					},
					type : 'POST',
					dataType: 'json',
					success : function(dados) {

						if (dados.resultado == true){
							
							$('#HabCertUploader .up-file-name').html(dados.filename);
							$('#HabCertArquivoID').val(dados.arquivoid);
							$('#HabCertUploader .area-up-files').hide('slow'); 
							$('#HabCertUploader .area-view-files').show('slow');

							success_message(dados.mensagem);
							
						}else{
							error_message(dados.mensagem);
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alerta = ("ERRO habilitacao.file.externo.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ jqXHR.status + " - " + errorThrown + ")");
						console.log(alerta);
						error_message(alerta);
					}
				});
				
				$('#listFilesHabCertArquivo').html("");

            },

            Error: function(up, err) {   
            	msg_err = "Error #" + err.code + ": " + err.message;
            	hab_cert.splice;
            	hab_cert.refresh;
            	error_message(msg_err);
            	console.log(msg_err);
            }
        }

	});

	hab_cert.init();

	$('#HabCertUploader .up-del').off("click").on("click", function(){
		var result = confirm("Deseja excluir PERMANENTEMENTE este arquivo do banco de dados?");
		if (result) excluirHabCertFile();
	});

	$('#HabCertArquivoNome').off("click").on("click", function(){
		downloadHabCertFile();		
	});


});

function downloadHabCertFile() {
	  
	window.open( app_path + "/controllers/habilitacao.files.controller.php" 
		+ "?ac=download&HabilitacaoID=" 
		+ $('#HabilitacaoID').val() 
		+ "&HabCertArquivoID="
		+ $('#HabCertArquivoID').val()
		+ "&HabCertID=" 
		+ $('#HabCertID').val());

};


function excluirHabCertFile() {

	$
	.ajax({
		url : app_path + "/controllers/habilitacao.files.controller.php",
		data : {
			"ac" : "delete",
			"HabCertArquivoID" : $('#HabCertArquivoID').val(),
			"HabCertID" : $('#HabCertID').val()
		},
		dataType : "json",
		success : function(data) {
			if (data.resultado == true) {

				$('#HabCertUploader .up-file-name').html("");
				$('#HabCertUploader .area-view-files').hide();
				$('#HabCertUploader .area-up-files').show('slow'); 
				$('#HabCertArquivoID').val("");
				$('#listFilesHabCertArquivo').html("");
				success_message(data.mensagem);

			} else {
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
			error_message("ERRO habilitacao.file.externo.js excluirHabRiscoExtFile:\r\nNão foi possível carregar os dados\r\n\r\n("
							+ xhr.status + " - " + thrownError + ")");
		}
	});

}


