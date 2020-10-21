
	// function UpFile (containerId, pathFilesController, pathUrlUp, flashSwfUrl, silverlightXapUrl, dataPost, dataDelete, inputArquivoId) {

	// 	this.browseButtonId 	= $("#" + containerId + " .up-add").attr('id');
	//  	this.divFileList 		= $("#" + containerId + " .up-list");
	//  	this.btUp 				= $("#" + containerId + " .up-upload");
	//  	this.divAreaUpFiles  	= $("#" + containerId + " .area-up-files");
	// 	this.divAreaViewFiles 	= $("#" + containerId + " .area-view-files");
		
	//  	this.aFileName 			= $("#" + containerId + " .up-file-name");
	//  	this.btDel  			= $("#" + containerId + " .up-del");

	//  	this.uploader = new plupload.Uploader({

	//  		runtimes : 'html5,flash,silverlight,html4',
	//         browse_button : this.browseButtonId, // you can pass in id...
	//         container: containerId, // you can pass in id...
	//         url : pathUrlUp,
	//         flash_swf_url : flashSwfUrl,
	//         silverlight_xap_url : silverlightXapUrl,
	//         multi_selection: false,
	//         unique_names : true, // envia os arquivos com nomes aleatórios
	//         max_file_size : '50mb',
	//         chunk_size : '5mb',
	//         multipart : true,
	//         multipart_params : {
	//             "ac" : "upload"
	//     	},

	//         filters : [
	// 	  		{title : "Imagem", extensions : "jpeg,jpg,gif,png"},
	//             {title : "Zip", extensions : "zip"},
	//             {title : "7-zip", extensions : "7z"},
	// 			{title : "PDFs", extensions : "pdf"},
	// 			{title : "Word", extensions : "doc,docx"},
	// 			{title : "Excel", extensions : "xls,xlsx"}
	//         ],

	//         init: {

	//             PostInit: function(up) {                
	//                 $(this.btUp).off().on('click', function() {
	//                 	up.start();
	//                     return false;
	//                 });
	//             },

	//             BeforeUpload: function(up, file) {
	//             	up.settings.multipart_params['fileId'] = file.id;
	//             	up.settings.multipart_params['fileName'] = file.name;
	//             	up.settings.multipart_params['fileSize'] = file.size; 
	//             	/* 
	//             	*	É necessário enviar o File Type, pois arquivos maiores que o chunk sem esse envio são montados errados. 
	//             	*/
	//             	up.settings.multipart_params['fileType'] = file.type; 
	//             },

	// 			FilesAdded: function(up, files) {
	//                 if(up.files.length > 1){
	// 					f = up.files[0];
	// 				    up.removeFile(f);
	// 				    $('#' + f.id).hide("slow");
	// 				    up.refresh();
	// 				}
	// 				plupload.each(files,function(file, i) {
	// 					$(this.divFileList).append(
	// 						'<div class="" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) 
	// 						+ ') <a href="#" class="remove btn btn-small"><i class="icon-remove"></i> Remover </a> <b></b> </div>'
	// 					);

	// 					$('#' + file.id + ' a.remove').off().on("click", function() {
	// 				   		up.removeFile(file.id);
	// 					  	$('#' + file.id).hide("slow");
	// 					});
	// 				});

	//             },	

				
	//             UploadProgress: function(up, file) {
	//             	$('#' + file.id + ' a.remove').hide();
	//                 $('#' + file.id + ' b').first().html('<span>' + file.percent + '%</span>');
	//             },

	//              //Disparado quando todos os arquivos forem enviados
	//             UploadComplete: function(up, file){
	// 				$.ajax({
	// 					url : pathFilesController,
	// 					data : dataPost,
	// 					type : 'POST',
	// 					dataType: 'json',
	// 					success : function(dados) {

	// 						if (dados.resultado == true){

	// 							$('#' + inputArquivoId).val(dados.arquivoid);

	// 							$(this.aFileName).html(dados.filename);
	// 							$(this.divAreaUpFiles).hide('slow'); 
	// 							$(this.divAreaViewFiles).show('slow');

	// 							success_message(dados.mensagem);
								
	// 						}else{
	// 							error_message(dados.mensagem);
	// 						}
	// 					},
	// 					error : function(jqXHR, textStatus, errorThrown) {
	// 						alerta = ("ERRO propostas.file.gefom.js UploadComplete:\r\nNão foi possível carregar os dados\r\n\r\n("
	// 								+ jqXHR.status + " - " + errorThrown + ")");
	// 						console.log(alerta);
	// 						error_message(alerta);
	// 					}
	// 				});
				
	// 				$(this.divFileList).html("");

	//             },

	//             FileUploaded: function(up, file, response) {
	//             	if (!response.result){
	// 					up.trigger('Error', {
	//                         code : -300, // IO_ERROR
	//                         message : 'Upload Failed',
	//                         details : file.name + ' failed',
	//                         file : file
	//                		});
	//             		return;
	//             	}
	//             },

	//             Error: function(up, err) {   
	//             	msg_err = "Error #" + err.code + ": " + err.message;

	//             	up.splice;
	//             	up.refresh;

	//             	$(this.divFileList).html("");
	// 				$(this.divAreaUpFiles).show('slow'); 
	// 				$(this.divAreaViewFiles).hide('slow');				

	//             	error_message(msg_err);
	//             	console.log(msg_err);
	//             }
	//         }

	//  	});

	// 	this.uploader.init(); 

	// 	$(this.btDel).off("click").on("click", function(){
			
	// 		var result = confirm("Deseja excluir PERMANENTEMENTE este arquivo do banco de dados?");		
			
	// 		if (result) {

	// 			$.ajax({
	// 				url : pathFilesController,
	// 				data : dataDelete,
	// 				dataType : "json",
	// 				success : function(data) {
	// 					if (data.resultado == true) {

	// 						$(this.aFileName).html("");
	// 						$(this.divFileList).html("");
	// 						$(this.divAreaUpFiles).show('slow'); 
	// 						$(this.divAreaViewFiles).hide('slow');				

	// 						$('#' + inputArquivoId).val("");
							
	// 						success_message(data.mensagem);

	// 					} else {
	// 						error_message(data.mensagem);
	// 						console.log(data.mensagem + "\r\n" + data.exception);
	// 					}
	// 				},
	// 				error : function(xhr, ajaxOptions, thrownError) {
	// 					error_message("ERRO up.file.js excluir File:\r\nNão foi possível carregar os dados\r\n\r\n("
	// 									+ xhr.status + " - " + thrownError + ")");
	// 				}
	// 			});

	// 		}

	// 	});

	// 	$(this.aFileName).off("click").on("click", function(){
	// 		window.open( path_post 	+ "?ac=download&ArquivoID=" + $('#' + inputArquivoId).val() );
	// 	});

	// }
