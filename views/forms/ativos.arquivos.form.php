<style>

	#dialog-arquivos-upload {
		width: 775px;
		margin-left: -412px;
	}

	#dialog-arquivos-upload .modal-body{
		overflow: hidden;
		max-height: 800px;
		height: 450px;
	}

	#div_lista_arquivos_ativos{
		margin-top: -30px;
	}

</style>

<script type="text/javascript">

	$(document).ready(function() {

		applyDataTableByID("lista_arquivos_ativos", "330px");
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
			$("#div_lista_arquivos_ativos").fadeOut("slow");
			$("#btn_cancelar").off("click").on("click",
				function(){
					$(".btn_novo").fadeIn("slow");
					$("#div_lista_arquivos_ativos").fadeIn("slow");
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

		$("#AtivoArquivoTipoID").off("change").on("change", function(){
			if ($("#AtivoArquivoTipoID option:selected").val() > 0){
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

	$(document).off("click", "table#lista_arquivos_ativos tbody tr td a.excluir");
	$(document).on("click", "table#lista_arquivos_ativos tbody tr td a.excluir", function() {
		var ArquivoID = $(this).closest("tr").data('arquivoid');
		var ArquivoNome = $(this).closest("tr").data('arquivonome');
		var AtivoArquivoID = $(this).closest("tr").data('ativoarquivoid');
		if (!($("#AtivoDataFinalizacao").val() > 0)){
			$("#dialog-arquivos-upload").css("opacity" , 0.33);
			bootbox.confirm("Tem certeza que deseja excluir permanentemente o arquivo <b>" + ArquivoNome + "</b>?", 
			function(confirmou) { 
				if (confirmou) {
					$.ajax({
						url : app_path + "/controllers/ativos.arquivos.controller.php",
						data : {
							ac : "delete",
							ArquivoID: ArquivoID,
							AtivoArquivoID: AtivoArquivoID
						},
						dataType : "json",
						success : function(data) {
							if (data.result == true) {
								$("table#lista_arquivos_ativos tbody tr.ativoarquivo_" + AtivoArquivoID)
								.addClass("alert-danger")
								.fadeOut("slow", function() {
									pos =   $("table#lista_arquivos_ativos").dataTable().fnGetPosition(this);
									$("table#lista_arquivos_ativos").dataTable().fnDeleteRow(pos);
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

	$(document).off("click", "table#lista_arquivos_ativos tbody tr td a.visualizar");
	$(document).on("click", "table#lista_arquivos_ativos tbody tr td a.visualizar", function() {
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

		<form id='formAtivoArquivos' name='formAtivoArquivos'>

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value = '<?php echo (isset($ativo["AtivoID"])) ? $ativo["AtivoID"] : ""; ?>' ></input>

			<input type="hidden" id="AtivoArquivoID" name="AtivoArquivoID" ></input>
			
			<input type="hidden" id="AtivoDataFinalizacao" name="AtivoDataFinalizacao" 
				value = '<?php echo (isset($ativo["AtivoDataFinalizacao"])) ? $ativo["AtivoDataFinalizacao"] : ""; ?>' ></input>



			<div class="control-group in-line">
				<label class="control-label" for="ModalidadeNome">Modalidade</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="ModalidadeNome" name="ModalidadeNome" value = '<?php echo ((isset($ativo["ModalidadeNome"])) ? $ativo["ModalidadeNome"] : ""). ' - ' . ((isset($ativo["ModalidadeSetor"])) ? $ativo["ModalidadeSetor"] : ""); ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="AtivoCodigoSIOPM">Código SIOPM</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="AtivoCodigoSIOPM" name="AtivoCodigoSIOPM" value = '<?php echo (isset($ativo["AtivoCodigoSIOPM"])) ? $ativo["AtivoCodigoSIOPM"] : ""; ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
					<label class="control-label" for="AtivoCodigoCetip">Código CETIP</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="AtivoCodigoCetip" name="AtivoCodigoCetip" value = '<?php echo (isset($ativo["AtivoCodigoCetip"])) ? $ativo["AtivoCodigoCetip"] : ""; ?>' ></input>
						</div>
			</div>

			<p>

			<div class="novo-arquivo control-group in-line"> 

				<div id="divTipoArquivo" class="control-group">
					<label class="control-label">Tipo de Arquivo</label>
					<div class="controls">
						<select class="span5" name="AtivoArquivoTipoID" id="AtivoArquivoTipoID" >
							<option value="">Selecione</option>
							<?php $selected = ""; ?>
							<?php if (isset($arquivosTipos)) foreach($arquivosTipos as $row): ?>
								<option value='<?php echo $row["AtivoArquivoTipoID"] ?>' >
									<?php echo $row["AtivoArquivoDescricao"]?> </option>
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

		<div id="div_lista_arquivos_ativos" class='div_lista_arquivos_ativos'>
			<?php if (!isset($ativo["AtivoDataFinalizacao"]) || $ativo["AtivoDataFinalizacao"] == "" || user_has_access("CRI_ATIVOS_EDITAR_FINALIZADO")){ ?>
				<p><button class="btn_novo btn btn-primary" type="button">Novo Arquivo</button></p>
			<?php } ?>
			<table id="lista_arquivos_ativos" class="table table-temp-hover table-condensed">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Tipo</th>
						<th class='center'>Ações</th>
					</tr>
				</thead> 
				<tbody>

					<?php if (isset($arquivos)) foreach($arquivos as $arquivo): ?>

						<?php 
							$ArquivoID						= $arquivo['ArquivoID'];
							$AtivoArquivoID					= $arquivo['AtivoArquivoID'];
							$AtivoArquivoDescricao 			= $arquivo['AtivoArquivoDescricao'];
							$ArquivoNome					= $arquivo['ArquivoNome'];
						?> 

						<tr class					= "ativoarquivo_<?php echo $AtivoArquivoID 	?>"
							data-arquivoid			= "<?php echo $ArquivoID 					?>"
							data-ativoarquivoid		= "<?php echo $AtivoArquivoID			?>"
							data-arquivodescricao	= "<?php echo $AtivoArquivoDescricao 	?>"
							data-arquivonome		= "<?php echo $ArquivoNome 					?>"
						>
							<td><div class='ArquivoNome'> <strong><?php echo $ArquivoNome; ?></strong></div></td>
							<td><div class='AtivoArquivoDescricao'> <?php echo $AtivoArquivoDescricao; ?></div></td>
							<td>
								<?php 
									echo TAG_A_VISUALIZAR; 
									if (!isset($ativo["AtivoDataFinalizacao"]) || $ativo["AtivoDataFinalizacao"] == ""|| user_has_access("CRI_ATIVOS_ARQUIVOS_FINALIZADOS")){ 
										echo TAG_A_EXCLUIR;
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

<?php $siopm->includeJS("views", "ativos.arquivos.js"); ?>
