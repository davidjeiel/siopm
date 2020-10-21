
 $(function () {

 	//VER .0005
 	path_post				=  app_path + "/controllers/propostas.files.controller.php";
 	container_id_risco 		=  'PropRiscoArquivoUploader';

	var uploader_prop_risco = new plupload.Uploader({
		
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : $("#" + container_id_risco + " .up-add").attr('id'), // you can pass in id...
        container: container_id_risco, // you can pass in id...
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
	  		{title : "Imagem", extensions : "jpeg,jpg,gif,png"},
            {title : "Zip", extensions : "zip"},
            {title : "7-zip", extensions : "7z"},
			{title : "PDFs", extensions : "pdf"},
			{title : "Word", extensions : "doc,docx"},
			{title : "Excel", extensions : "xls,xlsx"}
        ],
  
        init: {

            PostInit: function(up) {

                $("#" + container_id_risco + " .up-list").html("");

                $("#" + container_id_risco + " .up-upload").off().on('click', function() {
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
				    $('#' + f.id).hide("slow");
				    up.refresh();
				}

				plupload.each(files,function(file, i) {

					$("#" + container_id_risco + " .up-list").append(
						'<div class="" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) 
						+ ') <a href="#" class="remove btn btn-small"><i class="icon-remove"></i> Remover </a> <b></b> </div>'
					);

					$('#' + file.id + ' a.remove').off().on("click", function() {
				   		up.removeFile(file.id);
					  	$('#' + file.id).hide("slow");
					});

				});

            },	
			
            UploadProgress: function(up, file) {
            	$('#' + file.id + ' a.remove').hide();
                $('#' + file.id + ' b').first().html('<span>' + file.percent + '%</span>');
            },

             //Disparado quando todos os arquivos forem enviados
            UploadComplete: function(up, file){

				$.ajax({
					url : path_post,
					data : {
						ac : "upload",
						PropRiscoID 			: $('#PropRiscoID').val(),
						PropostaDetalheID 		: $('#PropostaDetalheID').val(),
						PropRiscoArquivoID 		: $('#PropRiscoArquivoID').val(),
						PropostaFaseNome		: $('#PropostaFaseNome').val()
					},
					type : 'POST',
					dataType: 'json',
					success : function(dados) {

						if (dados.resultado == true){

							$('#PropRiscoArquivoID').val(dados.arquivoid);

							$("#" + container_id_risco + " .up-file-name").html(dados.filename);
							$("#" + container_id_risco + " .area-up-files").hide('slow'); 
							$("#" + container_id_risco + " .area-view-files").show('slow');

							success_message(dados.mensagem);
							
						}else{
							error_message(dados.mensagem);
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alerta = ("ERRO propostas.file.risco.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ jqXHR.status + " - " + errorThrown + ")");
						console.log(alerta);
						error_message(alerta);
					}
				});
			
				$("#" + container_id_risco + " .up-list").html("");

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

            Error: function(up, err) {   
            	msg_err = "Error #" + err.code + ": " + err.message;

            	up.splice;
            	up.refresh;

            	$("#" + container_id_risco + " .up-list").html("");
				$("#" + container_id_risco + " .area-up-files").show('slow'); 
				$("#" + container_id_risco + " .area-view-files").hide('slow');				

            	error_message(msg_err);
            	console.log(msg_err);
            }
        }

	}); 

	uploader_prop_risco.init();

	$("#" + container_id_risco + " .up-del").off("click").on("click", function(){
		
		var result = confirm("Deseja excluir PERMANENTEMENTE este arquivo do banco de dados?");		
		
		if (result) {

			$.ajax({
				url : path_post,
				data : {
					"ac" : "delete",
					"PropRiscoArquivoID" : $('#PropRiscoArquivoID').val(),
					"PropRiscoID" : $('#PropRiscoID').val()
				},
				dataType : "json",
				success : function(data) {
					if (data.resultado == true) {

						$("#" + container_id_risco + " .up-file-name").html("");
						$("#" + container_id_risco + " .up-list").html("");
						$("#" + container_id_risco + " .area-up-files").show('slow'); 
						$("#" + container_id_risco + " .area-view-files").hide('slow');				

						$('#PropRiscoArquivoID').val("");
						
						success_message(data.mensagem);

					} else {
						error_message(data.mensagem);
						console.log(data.mensagem + "\r\n" + data.exception);
					}
				},
				error : function(xhr, ajaxOptions, thrownError) {
					error_message("ERRO habilitacao.file.risco.js excluir File:\r\nNão foi possível carregar os dados\r\n\r\n("
									+ xhr.status + " - " + thrownError + ")");
				}
			});

		}

	});

	$("#" + container_id_risco + " .up-file-name").off("click").on("click", function(){

		window.open( path_post 	+ "?ac=download&ArquivoID=" + $('#PropRiscoArquivoID').val() );
		
		// window.open( path_post 
		// + "?ac=download&PropostaDetalheID=" 
		// + $('#PropostaDetalheID').val() 
		// + "&PropRiscoArquivoID="
		// + $('#PropRiscoArquivoID').val()
		// + "&PropRiscoID=" 
		// + $('#PropRiscoID').val());

	});

});



