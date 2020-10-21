 
/* VERSAO 0.9 */

$(function () {

	var hab_juridica_uploader = new plupload.Uploader({
		
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'add_HabJuridicaArquivo', // you can pass in id...
        container: 'HabJuridicaArquivoUploader', //document.getElementById('HabJuridicaArquivoUploader'), // Apenas funciona gerElementById
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
            "sender" : "hab_juridica",
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

                $('#listFilesHabJuridicaArquivo').html("");
                $('#up_HabJuridicaArquivo').off().on('click', function() {
                	hab_juridica_uploader.start();
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
				    hab_juridica_uploader.removeFile(f);
				    $('#' + f.id).hide("slow");
				    hab_juridica_uploader.refresh();
				}

				plupload.each(files,function(file, i) {

					$('#listFilesHabJuridicaArquivo').append(
						'<div class="" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) 
						+ ') <a href="#" class="remove btn btn-small"><i class="icon-remove"></i> Remover </a> <b></b> </div>'
					);

					$('#' + file.id + ' a.remove').off().on("click", function() {
				   		hab_juridica_uploader.removeFile(file.id);
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
						HabJuridicaArquivoID : $('#HabJuridicaArquivoID').val(),
						HabJuridicaID : $('#HabJuridicaID').val()
					},
					type : 'POST',
					dataType: 'json',
					success : function(dados) {

						if (dados.resultado == true){
							
							$('#HabJuridicaArquivoUploader .up-file-name').html(dados.filename);
							$('#HabJuridicaArquivoID').val(dados.arquivoid);
							$('#HabJuridicaArquivoUploader .area-up-files').hide('slow'); 
							$('#HabJuridicaArquivoUploader .area-view-files').show('slow');

							success_message(dados.mensagem);
							
						}else{
							error_message(dados.mensagem);
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alerta = ("ERRO habilitacao.files.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ jqXHR.status + " - " + errorThrown + ")");
						console.log(alerta);
						error_message(alerta);
					}
				});
				
				$('#listFilesHabJuridicaArquivo').html("");
				
            },

            Error: function(up, err) {   
            	msg_err = "Error #" + err.code + ": " + err.message;
            	hab_juridica_uploader.splice;
            	hab_juridica_uploader.refresh;
            	error_message(msg_err);
            	console.log(msg_err);
            }
        }

	});

	hab_juridica_uploader.init();

	$('#HabJuridicaArquivoUploader .up-del').off("click").on("click", function(){
		var result = confirm("Deseja excluir PERMANENTEMENTE este arquivo do banco de dados?");		
		if (result) excluirHabJuridicaFile();
	});

	$('#HabJuridicaArquivoNome').off("click").on("click", function(){
		downloadHabJuridicaFile();		
	});

});

function downloadHabJuridicaFile() {

	
	  
	window.open( app_path + "/controllers/habilitacao.files.controller.php" 
		+ "?ac=download&HabilitacaoID=" 
		+ $('#HabilitacaoID').val() 
		+ "&HabJuridicaArquivoID="
		+ $('#HabJuridicaArquivoID').val()
		+ "&HabJuridicaID=" 
		+ $('#HabJuridicaID').val());

};


function excluirHabJuridicaFile() {
	
	$.ajax({
		url : app_path + "/controllers/habilitacao.files.controller.php",
		data : {
			"ac" : "delete",
			"HabJuridicaArquivoID" : $('#HabJuridicaArquivoID').val(),
			"HabJuridicaID" : $('#HabJuridicaID').val()
		},
		dataType : "json",
		success : function(data) {
			if (data.resultado == true) {

				$('#HabJuridicaArquivoUploader .up-file-name').html("");
				$('#HabJuridicaArquivoUploader .area-view-files').hide();
				$('#HabJuridicaArquivoUploader .area-up-files').show('slow'); 
				$('#HabJuridicaArquivoID').val("");
				$('#listFilesHabJuridicaArquivo').html("");
				success_message(data.mensagem);

			} else {
				error_message(data.mensagem);
				console.log(data.mensagem + "\r\n" + data.exception);
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
			error_message("ERRO habilitacao.file.juridica.js excluirHabJuridicaFile:\r\nNão foi possível carregar os dados\r\n\r\n("
							+ xhr.status + " - " + thrownError + ")");
		}
	});

}

