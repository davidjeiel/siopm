
 $(function () {

 	//VER .092
 	path_post			=  app_path + "/controllers/ativos.arquivos.controller.php";
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
	  		{title : "Imagem", extensions : "jpeg,jpg,gif,png"},
            {title : "Zip", extensions : "zip"},
            {title : "7-zip", extensions : "7z"},
			{title : "PDFs", extensions : "pdf"},
			{title : "Word", extensions : "doc,docx"},
			{title : "Excel", extensions : "xls,xlsx"}
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
							AtivoID : $('#AtivoID').val(),
							AtivoArquivoTipoID : $("#AtivoArquivoTipoID option:selected").val()
						},
						type : 'POST',
						dataType: 'json',
						success : function(dados) {
							
							progressClear();
							
							$(".btn_novo").fadeIn("slow");
							$("#div_lista_arquivos_ativos").fadeIn("slow");
							$("#divTipoArquivo").hide();
							$("#ArquivoUploader").hide();	

							if (dados.result == true){
			 					//Concatenamos as tags para adicionar no final na ultima TD do DATATABLE
		                        links_html = $('<span></span>')
		                            .append(TAG_A_VISUALIZAR)
		                            .append(TAG_A_EXCLUIR).html();

		                        // Armazenamos todos os dados a serem inseridos na nova linha em uma array
		                        arr = new Array(
		                        	'<div class="ArquivoNome"><strong>'	+ dados.filename + '<strong></div>',
									'<div class="AtivoArquivoDescricao">' + dados.ativoarquivodescricao + '</div>',
		                            links_html
		                        );

		                        // Criamos uma nova linha, com os dados a serem exibidos
		                        // http://stackoverflow.com/questions/8239118/jquery-datatables-how-do-i-add-a-row-id-to-each-dynamically-added-row
		                        var addId   = $('table#lista_arquivos_ativos').dataTable().fnAddData( arr );
		                        var tr      = $('table#lista_arquivos_ativos').dataTable().fnSettings().aoData[addId[0]].nTr;

		                        // Setamos os atributos do tr
		                        $(tr).addClass("alert ativoarquivo_" + dados.ativoarquivoid);
		                        $(tr).attr('data-arquivoid',  dados.arquivoid);
		                        $(tr).attr('data-ativoarquivoid',  dados.ativoarquivoid);
		                        $(tr).attr('data-arquivonome',  dados.filename);
		                        $(tr).attr('data-arquivodescricao', dados.ativoarquivodescricao);

								applyDataTableByID("lista_arquivos_ativos", "330px");
								
								if($("#dialog-manut-ativo-finalizar").is(':visible')) alert("cehgou");//atualizarListaErrosAtivos(dados.ativoid);
								
								success_message(dados.mensagem);
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



