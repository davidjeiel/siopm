
 $(function () {

 	//VER .0005
 	path_post			=  app_path + "/controllers/propostas.files.controller.php";
 	container_id 		=  'PropJuridicaArquivoUploader';
 	
 	//container 			= $("#" + container_id);
	
 	browse_button_id 	= $("#" + container_id + " .up-add").attr('id');
 	div_file_list 		= $("#" + container_id + " .up-list");
 	bt_up 				= $("#" + container_id + " .up-upload");
 	div_area_up_files   = $("#" + container_id + " .area-up-files");
	div_area_view_files = $("#" + container_id + " .area-view-files");
	
 	a_file_name 		= $("#" + container_id + " .up-file-name");
 	bt_up_del  			= $("#" + container_id + " .up-del");

	var uploader_prop_jur = new plupload.Uploader({
		
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : browse_button_id, // you can pass in id...
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
	  		{title : "Imagem", extensions : "jpeg,jpg,gif,png"},
            {title : "Zip", extensions : "zip"},
            {title : "7-zip", extensions : "7z"},
			{title : "PDFs", extensions : "pdf"},
			{title : "Word", extensions : "doc,docx"},
			{title : "Excel", extensions : "xls,xlsx"}
        ],
  
        init: {

            PostInit: function(up) {

                $(div_file_list).html("");

                $(bt_up).off().on('click', function() {
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

					$(div_file_list).append(
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
						PropJuridicaID 			: $('#PropJuridicaID').val(),
						PropostaDetalheID 		: $('#PropostaDetalheID').val(),
						PropJuridicaArquivoID 	: $('#PropJuridicaArquivoID').val(),
						PropostaFaseNome		: $('#PropostaFaseNome').val()
					},
					type : 'POST',
					dataType: 'json',
					success : function(dados) {

						if (dados.resultado == true){

							$('#PropJuridicaArquivoID').val(dados.arquivoid);

							$(a_file_name).html(dados.filename);
							$(div_area_up_files).hide('slow'); 
							$(div_area_view_files).show('slow');

							success_message(dados.mensagem);
							
						}else{
							error_message(dados.mensagem);
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alerta = ("ERRO propostas.file.juridica.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
								+ jqXHR.status + " - " + errorThrown + ")");
						console.log(alerta);
						error_message(alerta);
					}
				});
			
				$(div_file_list).html("");

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

            	$(div_file_list).html("");
				$(div_area_up_files).show('slow'); 
				$(div_area_view_files).hide('slow');				

            	error_message(msg_err);
            	console.log(msg_err);
            }
        }

	}); 

	uploader_prop_jur.init();

	$(bt_up_del).off("click").on("click", function(){
		
		var result = confirm("Deseja excluir PERMANENTEMENTE este arquivo do banco de dados?");		
		
		if (result) {

			$.ajax({
				url : path_post,
				data : {
					"ac" : "delete",
					"PropJuridicaArquivoID" : $('#PropJuridicaArquivoID').val(),
					"PropJuridicaID" : $('#PropJuridicaID').val()
				},
				dataType : "json",
				success : function(data) {
					if (data.resultado == true) {

						$(a_file_name).html("");
						$(div_file_list).html("");
						$(div_area_up_files).show('slow'); 
						$(div_area_view_files).hide('slow');				

						$('#PropJuridicaArquivoID').val("");
						
						success_message(data.mensagem);

					} else {
						error_message(data.mensagem);
						console.log(data.mensagem + "\r\n" + data.exception);
					}
				},
				error : function(xhr, ajaxOptions, thrownError) {
					error_message("ERRO propostas.file.juridica.js excluir File:\r\nNão foi possível carregar os dados\r\n\r\n("
									+ xhr.status + " - " + thrownError + ")");
				}
			});

		}

	});

	$(a_file_name).off("click").on("click", function(){

		window.open( path_post 	+ "?ac=download&ArquivoID=" + $('#PropJuridicaArquivoID').val() );
		
		// window.open( path_post 
		// + "?ac=download&PropostaDetalheID=" 
		// + $('#PropostaDetalheID').val() 
		// + "&PropJuridicaArquivoID="
		// + $('#PropJuridicaArquivoID').val()
		// + "&PropJuridicaID=" 
		// + $('#PropJuridicaID').val());

	});

});



