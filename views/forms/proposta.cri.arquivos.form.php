
<style>

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-arquivos-upload {
		width: 795px;
	    margin-left: -412px;
	}

	#dialog-arquivos-upload .modal-body{
		overflow: hidden;
		max-height: 800px;
		height: 450px;
	}

	#div_lista_arquivos{
		margin-top: -30px;
	}

</style>

<script type="text/javascript">

	$(document).ready(function() {

		applyDataTableByID("lista_arquivos", "330px");
		$("#ArquivoUploader").hide();
		$("#divTipoArquivo").hide();

		$(".btn_novo").off("click").on("click", function(){
			$(this).hide();
			$("#ArquivoUploader .up-list input").val("");
			$("#ArquivoUploader .barra-progresso").removeClass("bar-sucess");
            $("#ArquivoUploader .barra-progresso").removeClass("bar-danger");
			$("#ArquivoUploader .barra-progresso").addClass("bar-info");
			$("#ArquivoUploader .barra-progresso").css("width", "0");
			$("#ArquivoUploader .barra-progresso").html("");
			$("#divTipoArquivo").fadeIn("slow");
			$("#div_lista_arquivos").fadeOut("slow");
			$("#btn_cancelar").off("click").on("click",
				function(){
					$(".btn_novo").fadeIn("slow");
					$("#div_lista_arquivos").fadeIn("slow");
					$("#divTipoArquivo").hide();
					$("#ArquivoUploader").hide();
					$(this).off("click").on("click",
						function(){
							$("#dialog-arquivos-upload").modal("hide");
						}
					);
				}
			);
		});

		$("#PropostaArquivoTipoID").off("change").on("change", function(){
			if ($("#PropostaArquivoTipoID option:selected").val() > 0){
				$("#ArquivoUploader").fadeIn("slow");
			}else{
				$("#ArquivoUploader").fadeOut("slow");
			}
		});

		$("#btn_cancelar").off("click").on("click",
			function(){
				$("#dialog-arquivos-upload").modal("hide");
			}
		);

	});

	$(document).off("click", "table#lista_arquivos tbody tr td a.excluir");
	$(document).on("click", "table#lista_arquivos tbody tr td a.excluir", function() {
		var ArquivoID = $(this).closest("tr").data('arquivoid');
		var ArquivoNome = $(this).closest("tr").data('arquivonome');
		var PropostaArquivoID = $(this).closest("tr").data('propostaarquivoid');
		if (!($("#DataFinalizacao").val() > 0)){
			$("#dialog-arquivos-upload").css("opacity" , 0.33);
			bootbox.confirm("Tem certeza que deseja excluir permanentemente o arquivo <b>" + ArquivoNome + "</b>?", 
			function(confirmou) { 
				if (confirmou) {
					$.ajax({
						url : app_path + "/controllers/propostas.arquivos.controller.php",
						data : {
							ac : "delete",
							ArquivoID: ArquivoID,
							PropostaArquivoID: PropostaArquivoID
						},
						dataType : "json",
						success : function(data) {
							if (data.result == true) {
				               	$("table#lista_arquivos tbody tr.propostaarquivo_" + PropostaArquivoID)
				               	.addClass("alert-danger")
				               	.fadeOut("slow", function() {
									pos =   $("table#lista_arquivos").dataTable().fnGetPosition(this);
				                	$("table#lista_arquivos").dataTable().fnDeleteRow(pos);
									success_message(data.mensagem);
								});
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
				$("#dialog-arquivos-upload").css("opacity" , 1);
			});
		}		
	});

	$(document).off("click", "table#lista_arquivos tbody tr td a.visualizar");
	$(document).on("click", "table#lista_arquivos tbody tr td a.visualizar", function() {
		var ArquivoID = $(this).closest("tr").data('arquivoid');
		window.open( path_post 	+ "?ac=download&ArquivoID=" + ArquivoID );
	});


</script>

<div id="dialog-arquivos-upload" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='formPropostaArquivos' name='formPropostaArquivos'>

			<!-- MAX_FILE_SIZE must precede the file input field. 
			Serve apenas para o navegador não se dar ao
  			trabalho de enviar arquivos maiores que o aceito pelo PHP. -->
			<input type="hidden" name="MAX_FILE_SIZE" value="8388608" />

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>
				
			<input type="hidden" id="PropostaArquivoID" name="PropostaArquivoID" ></input>
			
			
			<input type="hidden" id="DataFinalizacao" name="DataFinalizacao" 
				value = '<?php echo (isset($proposta["DataFinalizacao"])) ? $proposta["DataFinalizacao"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaFaseNome" name="PropostaFaseNome" 
				value = '<?php echo (isset($proposta["PropostaFaseNome"])) ? $proposta["PropostaFaseNome"] : (($fase == 1) ? "PRELIMINAR" : "DEFINITIVA") ; ?>' ></input>

			
			<div class="novo-arquivo control-group in-line"> 

				<div id="divTipoArquivo" class="control-group">
					<label class="control-label">Tipo de Arquivo</label>
					<div class="controls">
						<select class="span5" name="PropostaArquivoTipoID" id="PropostaArquivoTipoID" >
							<option value="">Selecione</option>
							<?php $selected = ""; ?>
							<?php if (isset($arquivosTipos)) foreach($arquivosTipos as $row): ?>
								<option value='<?php echo $row["PropostaArquivoTipoID"] ?>' >
									<?php echo $row["PropostaArquivoDescricao"]?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div id="ArquivoUploader" name="ArquivoUploader" >
					<div class="controls up-list input-prepend input-append">
					<label class="control-label">Arquivo</label>				
						<button id="add_Arquivo" class="btn up-add" type="button"><i class="icon-plus"></i></button>
						<input type='text' readonly class='span7 nome-arquivo' placeholder='Nenhum arquivo selecionado'></input>
						<button id="del_Arquivo" class="btn btn-snall up-remove" type="button"><i class="icon-remove"></i></button><b></b>
						<button id="up_Arquivo" class="btn btn-primary up-upload" type="button"><i class="icon-arrow-up icon-white"></i><span>Upload</span></button>
						<div class="controls progress">
							<div class=" bar bar-info barra-progresso"></div>
						</div>
					</div>
				</div>

			</div>
		</form>	

		<div id="div_lista_arquivos" class='div_lista_arquivos'>
			<?php if (!isset($proposta["DataFinalizacao"]) || $proposta["DataFinalizacao"] == "" || user_has_access("CRI_DEFINITIVA_EDITAR_FINALIZADA")){ ?>
				<p><button class="btn_novo btn btn-primary" type="button">Novo Arquivo</button></p>
			<?php } ?>
			<table id="lista_arquivos" class="table table-temp-hover table-condensed">
				<thead>
					<tr>
				    	<th>Arquivo</th>
				    	<th>Tipo</th>
				    	<th>Ações</th>
				  	</tr>
				</thead> 
				<tbody>

					<?php if (isset($arquivos)) foreach($arquivos as $arquivo): ?>

						<?php 
							$ArquivoID						= $arquivo['ArquivoID'];
							$PropostaArquivoID				= $arquivo['PropostaArquivoID'];
							$PropostaArquivoDescricao 		= $arquivo['PropostaArquivoDescricao'];
							$ArquivoNome					= $arquivo['ArquivoNome'];
						?> 

						<tr class					= "propostaarquivo_<?php echo $PropostaArquivoID 	?>"
							data-arquivoid			= "<?php echo $ArquivoID 					?>"
							data-propostaarquivoid	= "<?php echo $PropostaArquivoID			?>"
							data-arquivodescricao	= "<?php echo $PropostaArquivoDescricao 	?>"
							data-arquivonome		= "<?php echo $ArquivoNome 					?>"
						>
							<td><div class='ArquivoNome'> <strong><?php echo $ArquivoNome; ?></strong></div></td>
							<td><div class='PropostaArquivoDescricao'> <?php echo $PropostaArquivoDescricao; ?></div></td>
							<td>
								<?php 
									echo TAG_A_VISUALIZAR . TAG_A_EXCLUIR; 
									if (!isset($proposta["DataFinalizacao"]) || $proposta["DataFinalizacao"] == ""){ 
										TAG_A_EXCLUIR;
									} 
								?>
						    </td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>
			
		</div>

	</div>

	<div class="modal-footer">
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Sair</button>
	</div>

</div>

<?php $siopm->includeJS("views", "propostas.arquivos.js"); ?>
