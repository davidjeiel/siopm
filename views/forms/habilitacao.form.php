
<script type="text/javascript">

$(document).ready(function() {
	
	$('.input-append.date').each(function () {

		var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
		$(this).datepicker(config).on('changeDate', function(ev){
			  $(this).datepicker('hide');
		});  

	});

	var selected = $("#EntidadeID").find('option:selected');
  	var entidadetipoid = selected.data('entidadetipoid');
  	if (entidadetipoid == 2){
  		$(".analise-esconder").hide();  	
  	}

});


</script>

<style type="text/css">

	#form_hab_risco_fileupload .control-label {
		margin-right: 20px;
	}

	#dialog-manut-habilitacao {
		width: 990px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -495px;
    	/*margin-top: -50px;*/ /* 0 0 -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
		/*
		width: 750px; 
		margin-left: -360px;
		*/
	}

	#dialog-manut-habilitacao .modal-body{		
		max-height: 410px;
		height: 460px;		
		overflow: hidden;
	}

	#dialog-manut-habilitacao .add-on{		
		margin-bottom: 25px;
	}

	.tab-content{
		padding-left: 10px;
		overflow:hidden;
	}

	.tab-content legend{
		margin-top: -10px;
		margin-bottom: 10px;
	}

	td input {
		color: #ff0a2d!important;
	}

	#lista_habilitacoes_contatos tr {
		height: 18px!important;
	}

	.input-append.date input{
		background:#FFF;
	}
	.dataTables_scrollBody table thead { display:none; }

</style>

<div id='dialog-manut-habilitacao' class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="titulo-habilitacao"><?php echo $titulo_form;?></h3>
	</div>

	<div class="modal-body">

		<form id='formHabilitacao' name='formHabilitacao' >

			<input type="hidden" id="HabilitacaoID" 					name="HabilitacaoID" 					value = '<?php echo (isset($habilitacao["HabilitacaoID"])) ? $habilitacao["HabilitacaoID"] : ""; ?>' ></input>
			<input type="hidden" id="HabilitacaoDataCadastro" 			name="HabilitacaoDataCadastro" 			value = '<?php echo (isset($habilitacao["HabilitacaoDataCadastro"])) ? $habilitacao["HabilitacaoDataCadastro"] : ""; ?>' ></input>
			<input type="hidden" id="HabilitacaoDataUltimaAtualizacao" 	name="HabilitacaoDataUltimaAtualizacao" value = '<?php echo (isset($habilitacao["HabilitacaoDataUltimaAtualizacao"])) ? $habilitacao["HabilitacaoDataUltimaAtualizacao"] : ""; ?>' ></input>
			<input type="hidden" id="HabilitacaoAtiva" 					name="HabilitacaoAtiva" 				value = "1"/> 
			<input type="hidden" id="HabRiscoID" 						name="HabRiscoID" 						value = '<?php echo (isset($hab_risco["HabRiscoID"])) ? $hab_risco["HabRiscoID"] : ""; ?>' ></input>
			<input type="hidden" id="HabJuridicaID" 					name="HabJuridicaID" 					value = '<?php echo (isset($hab_juridica["HabJuridicaID"])) ? $hab_juridica["HabJuridicaID"] : ""; ?>' ></input>
			<input type="hidden" id="HabRiscoExtID" 					name="HabRiscoExtID" 					value = '<?php echo (isset($hab_risco_ext["HabRiscoExtID"])) ? $hab_risco_ext["HabRiscoExtID"] : ""; ?>' ></input>
			<input type="hidden" id="HabCertID" 						name="HabCertID" 						value = '<?php echo (isset($hab_cert["HabCertID"])) ? $hab_cert["HabCertID"] : ""; ?>' ></input>


			<!-- MAX_FILE_SIZE must precede the file input field. 
			Serve apenas para o navegador não se dar ao
  			trabalho de enviar arquivos maiores que o aceito pelo PHP. -->
			<input type="hidden" name="MAX_FILE_SIZE" value="8388608" />

			<ul class="nav nav-tabs" id="navHabilitacao">
				<li class="active"><a href="#tabDadosHabilitacao" data-toggle="tab">Dados Básicos</a></li>
				<li><a href="#tabAnaliseJuridica" data-toggle="tab">Análise Jurídica</a></li>
				<li><a href="#tabAnaliseRiscos" 	   class="analise-esconder" data-toggle="tab">Análise de Risco</a></li>
				<li><a href="#tabAnaliseRiscoExterno"  class="analise-esconder" data-toggle="tab">Risco Externo</a></li>
				<li><a href="#tabCertificacao" 		   class="analise-esconder" data-toggle="tab">Certificação</a></li>		
				
			</ul>

			<div class="tab-content">

				<div class="tab-pane active fade in" id='tabDadosHabilitacao'>

					<legend>Dados Básicos</legend>

					<div class="control-group in-line">
						<label class="control-label">Razão Social</label>
						<div class="control">
							<select class="span_2" name="EntidadeID" id="EntidadeID">
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php foreach($entidades as $row): ?>
									<?php 
										if (isset($row["EntidadeID"]) and (isset($habilitacao["EntidadeID"])) ){
											 if ($row["EntidadeID"] == $habilitacao["EntidadeID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option data-entidadetipoid= '<?php echo $row["EntidadeTipoID"] ?>' data-entidadetipodescricao='<?php echo $row["EntidadeTipoDescricao"] ?>'  data-entidadeuf='<?php echo $row["EntidadeUF"] ?>' <?php echo $selected; ?> cnpj = '<?php echo $row["EntidadeCnpj"] ?>' value='<?php echo $row["EntidadeID"] ?>' ><?php echo $row["EntidadeNomeRazao"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label for="EntidadeTipoDescricao">Tipo Agente</label>
						<div class="control">
							<input class="gravar span2" readonly="readonly" type="text" id="EntidadeTipoDescricao" name="EntidadeTipoDescricao" value = '<?php echo (isset($habilitacao["EntidadeTipoDescricao"])) ? $habilitacao["EntidadeTipoDescricao"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label for="EntidadeUF">UF</label>
						<div class="control">
							<input class="gravar span2" readonly="readonly" type="text" id="EntidadeUF" name="EntidadeUF" value = '<?php echo (isset($habilitacao["EntidadeUF"])) ? $habilitacao["EntidadeUF"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">GIFUG</label>
						<div class="control">
							<select class="gravar span2" name="UnidadeID" id="UnidadeID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php foreach($unidades as $row): ?>
									<?php 
										if (isset($row["UnidadeID"]) and isset($habilitacao["UnidadeID"])){
											 if ($row["UnidadeID"] == $habilitacao["UnidadeID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
								 <option <?php echo $selected; ?> value='<?php echo $row["UnidadeID"] ?>' ><?php echo $row["UnidadeSigla"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label for="HabilitacaoObservacoes">Observações</label>
						<div class="control">
							<textarea  style='width:914px;' type="text" maxlength="1000" id="HabilitacaoObservacoes" name="HabilitacaoObservacoes" ><?php echo (isset($habilitacao["HabilitacaoObservacoes"])) ? $habilitacao["HabilitacaoObservacoes"] : ""; ?></textarea>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpHabilitacaoDataRecebimento" 
						data-date="" data-date-format="dd/mm/yyyy" >
						<label class="control-label" for="HabilitacaoDataRecebimento">Data Recebimento Ofício</label>
						<div class="controls">
							<input style="width:180px;" maxlength="16" class="gravar" type="text" readonly
								id="HabilitacaoDataRecebimento" 
								name="HabilitacaoDataRecebimento" 
								value = '<?php echo (isset($habilitacao["HabilitacaoDataRecebimento"])) ? PPOEntity::toDateBr($habilitacao["HabilitacaoDataRecebimento"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label for="HabilitacaoDataFinalizacao">Data da Finalização</label>
						<div class="control">
							<input class="gravar span2" readonly="readonly" type="text" id="HabilitacaoDataFinalizacao" name="HabilitacaoDataFinalizacao" value = '<?php echo (isset($habilitacao["HabilitacaoDataFinalizacao"])) ? PPOEntity::toDateBr($habilitacao["HabilitacaoDataFinalizacao"], "d/m/Y") : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label for="ConclusaoDescricao">Conclusão</label>
						<div class="control">
							<input class="gravar" readonly="readonly" type="text" 
							id="ConclusaoDescricao" name="ConclusaoDescricao" 
							value = '<?php echo (isset($habilitacao["ConclusaoDescricao"])) ? $habilitacao["ConclusaoDescricao"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="HabilitacaoRating">Rating</label>
						<div class="controls">
							<input class="gravar span2" style="text-transform:uppercase" readonly="readonly"  type="text" id="HabilitacaoRating" name="HabilitacaoRating" 
							value = '<?php echo (isset($habilitacao["HabilitacaoRating"])) ? $habilitacao["HabilitacaoRating"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label for="HabilitacaoValidade">Validade</label>
						<div class="control">
							<input class="gravar span2" readonly="readonly" type="text" id="HabilitacaoValidade" name="HabilitacaoValidade"
							value = '<?php echo (isset($habilitacao["HabilitacaoValidade"])) ? PPOEntity::toDateBr($habilitacao["HabilitacaoValidade"], "d/m/Y") : ""; ?>' ></input>
						</div>
					</div>

				</div>

				<div class="tab-pane fade " id='tabAnaliseJuridica'>

					<legend>Análise Jurídica</legend>

					<div class="control-group in-line">
						<label class="control-label" for="HabJuridicaNumero">Número Parecer</label>
						<div class="controls">
							<input class="gravar" type="text" maxlength="12" id="HabJuridicaNumero" name="HabJuridicaNumero" value = '<?php echo (isset($hab_juridica["HabJuridicaNumero"])) ? $hab_juridica["HabJuridicaNumero"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpHabJuridicaData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="HabJuridicaData">Data</label>
						<div class="controls">
							<input style="width:180px;" maxlength="16" class="gravar" readonly="readonly" type="text" id="HabJuridicaData" 
								name="HabJuridicaData" value = '<?php echo (isset($hab_juridica["HabJuridicaData"])) ? PPOEntity::toDateBr($hab_juridica["HabJuridicaData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="gravar" name="HabJuridicaConclusaoID" id="HabJuridicaConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($hab_juridica["HabJuridicaConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($hab_juridica["HabJuridicaConclusaoID"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ConclusaoID"] ?>' ><?php echo $row["ConclusaoDescricao"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="HabJuridicaConsideracaoes">Considerações</label>
						<div class="controls">
							<textarea class="span_3" class="gravar" maxlength="1000" type="text" id="HabJuridicaConsideracaoes" name="HabJuridicaConsideracaoes" ><?php echo (isset($hab_juridica["HabJuridicaConsideracaoes"])) ? $hab_juridica["HabJuridicaConsideracaoes"] : ""; ?></textarea>
						</div>
					</div>

<?php 

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da Análise Jurídica.
					*/
					if (isset($hab_juridica["HabJuridicaID"]) && (int)$hab_juridica["HabJuridicaID"] > 0) {

						$area_down_analise_juridica = "";
						$area_up_analise_juridica = "";

						/* 
						* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
						* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
						* Caso contrário permite o upload de um novo.
						*/
						if (isset($hab_juridica["HabJuridicaArquivoID"]) && (int)$hab_juridica["HabJuridicaArquivoID"] > 0) { 
							$area_down_analise_juridica = "";
							$area_up_analise_juridica = "hide";
						} else {
							$area_down_analise_juridica = "hide";
							$area_up_analise_juridica = "";
						}

?>	
						<div class="control-group in-line">			
						
							<div id="HabJuridicaArquivoUploader" style="position: relative;" class="controls">
								
								<input type="hidden" id="HabJuridicaArquivoID" name="HabJuridicaArquivoID" value = '<?php echo (isset($hab_juridica["HabJuridicaArquivoID"])) ? $hab_juridica["HabJuridicaArquivoID"] : ""; ?>' ></input>

								<label class="control-label" for="HabJuridicaArquivoNome">Arquivo: &nbsp;
									<span class='area-view-files <?php echo $area_down_analise_juridica; ?>' > 
										<a id="HabJuridicaArquivoNome" href='#' class='up-file-name'><?php echo (isset($hab_juridica["HabJuridicaArquivoNome"])) ? $hab_juridica["HabJuridicaArquivoNome"] : ""; ?></a>
										<a id="del_HabJuridicaArquivo" name="del_HabJuridicaArquivo"  href="#" class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
									</span>
								</label>
							
								<div class='area-up-files <?php echo $area_up_analise_juridica; ?>' > 
									
									<div class="control-group up-list" id="listFilesHabJuridicaArquivo" name="listFilesHabJuridicaArquivo"></div>
									
									<div class="control-group in-line">
										<button id="add_HabJuridicaArquivo" class="btn up-add" type="button">
											<i class="icon-plus"></i>
											<span>Selecionar Arquivo</span>
										</button>
									</div>
									
									<div class="control-group in-line">
										<button id="up_HabJuridicaArquivo" class="btn btn-primary up-upload" type="button">
											<i class="icon-arrow-up icon-white"></i>
											<span>Upload</span>
										</button>
									</div>

								</div>

							</div>

						</div><!-- Fim do grupo de controle do upload de arquivo -->

					<?php } ?>

				</div>

				<div class="tab-pane fade " id='tabAnaliseRiscos'>

					<legend>Análise de Risco</legend>

					<div class="control-group in-line">
						<label class="control-label" for="Número Parecer">Número Parecer</label>
						<div class="controls">
							<input class="gravar span2" maxlength="10" type="text" id="HabRiscoNumero" name="HabRiscoNumero" value = '<?php echo (isset($hab_risco["HabRiscoNumero"])) ? $hab_risco["HabRiscoNumero"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpHabRiscoData" data-date="" data-date-format="dd/mm/yyyy">
						<label for="HabRiscoData">Data</label>
						<div class="controls">	
							<input style="width:140px;" maxlength="16" class="gravar" type="text" readonly type="text" id="HabRiscoData" 
							name="HabRiscoData" value = '<?php echo (isset($hab_risco["HabRiscoData"])) ? PPOEntity::toDateBr($hab_risco["HabRiscoData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="gravar span3" name="HabRiscoConclusaoID" id="HabRiscoConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($hab_risco["HabRiscoConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($hab_risco["HabRiscoConclusaoID"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ConclusaoID"] ?>' ><?php echo $row["ConclusaoDescricao"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="HabRiscoRating">Rating</label>
						<div class="controls">
							<input class="gravar span2" style="text-transform:uppercase" maxlength="5" type="text" id="HabRiscoRating" name="HabRiscoRating" value = '<?php echo (isset($hab_risco["HabRiscoRating"])) ? $hab_risco["HabRiscoRating"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpHabRiscoValidade" data-date="" data-date-format="dd/mm/yyyy">
						<label for="HabRiscoValidade">Validade</label>
						<div class="controls">	
							<input style="width:140px;background:#FFF;" maxlength="10" class="gravar" type="text" readonly type="text" id="HabRiscoValidade" 
							name="HabRiscoValidade" value = '<?php echo (isset($hab_risco["HabRiscoValidade"])) ? PPOEntity::toDateBr($hab_risco["HabRiscoValidade"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line ">
						<label class="control-label" for="HabRiscoConsideracaoes">Considerações</label>
						<div class="controls">
							<textarea style='width:914px;' maxlength="1000" type="text" id="HabRiscoConsideracaoes" name="HabRiscoConsideracaoes"><?php echo (isset($hab_risco["HabRiscoConsideracaoes"])) ? $hab_risco["HabRiscoConsideracaoes"] : ""; ?></textarea>
						</div>
					</div>
	
					
<?php 

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da avaliaçcao de Risco.
					*/
					if (isset($hab_risco["HabRiscoID"]) && (int)$hab_risco["HabRiscoID"] > 0) {

						$area_down_analise_risco = "";
						$area_up_analise_risco = "";

						/* 
						* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
						* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
						* Caso contrário permite o upload de um novo.
						*/
						if (isset($hab_risco["HabRiscoArquivoID"]) && (int)$hab_risco["HabRiscoArquivoID"] > 0) { 
							$area_down_analise_risco = "";
							$area_up_analise_risco = "hide";
						} else {
							$area_down_analise_risco = "hide";
							$area_up_analise_risco = "";
						}

?>

						<div class="control-group in-line">			
						
							<div id="HabRiscoArquivoUploader" style="position: relative;" class="controls">
								
								<input type="hidden" id="HabRiscoArquivoID" name="HabRiscoArquivoID" value = '<?php echo (isset($hab_risco["HabRiscoArquivoID"])) ? $hab_risco["HabRiscoArquivoID"] : ""; ?>' ></input>
							
								<label class="control-label" for="HabRiscoArquivoNome">Arquivo: &nbsp;
									<span class='area-view-files <?php echo $area_down_analise_risco; ?>' > 
										<a id="HabRiscoArquivoNome"  href='#' class='up-file-name'><?php echo (isset($hab_risco["HabRiscoArquivoNome"])) ? $hab_risco["HabRiscoArquivoNome"] : ""; ?></a>
										<a id="del_HabRiscoArquivo" name="del_HabRiscoArquivo" href="#" class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
									</span>
								</label>
							
								<div class='area-up-files <?php echo $area_up_analise_risco; ?>' > 
									
									<div class="control-group up-list" id="listFilesHabRiscoArquivo" name="listFilesHabRiscoArquivo"></div>
							
									<div class="control-group in-line">
										<button id="add_HabRiscoArquivo" class="btn up-add" type="button">
											<i class="icon-plus"></i>
											<span>Selecionar Arquivo</span>
										</button>
									</div>
									
									<div class="control-group in-line">
										<button id="up_HabRiscoArquivo" class="btn btn-primary up-upload" type="button">
											<i class="icon-arrow-up icon-white"></i>
											<span>Upload</span>
										</button>
									</div>

								</div>

							</div>

						</div><!-- Fim do grupo de controle do upload de arquivo -->

					<?php } ?>

				</div> 

				<div class="tab-pane fade " id='tabAnaliseRiscoExterno'>

					<legend>Análise de Risco Externo</legend>

					<div class="control-group in-line">
						<label class="control-label">Agência de Rating</label>
						<div class="control">
							<select class="span_2" name="HabRiscoExtEntidadeID" id="HabRiscoExtEntidadeID" >
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php foreach($entidadesrating as $row): ?>
									<?php 
										if (isset($row["EntidadeID"])){
											 if (isset($hab_risco_ext["HabRiscoExtEntidadeID"]) && $row["EntidadeID"] == $hab_risco_ext["HabRiscoExtEntidadeID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option <?php echo $selected; ?> cnpj = '<?php echo $row["EntidadeCnpj"] ?>' value='<?php echo $row["EntidadeID"] ?>' ><?php echo (isset($row["EntidadeNomeFantasia"])) ? $row["EntidadeNomeFantasia"]:""; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="HabRiscoExtRating">Rating</label>
						<div class="controls">
							<input class="gravar" type="text" style="text-transform:uppercase" maxlength="5" id="HabRiscoExtRating" name="HabRiscoExtRating" value = '<?php echo (isset($hab_risco_ext["HabRiscoExtRating"])) ? $hab_risco_ext["HabRiscoExtRating"] : ""; ?>' ></input>
						</div>
					</div>

					<br>

					<div class="control-group in-line">
						<label class="control-label" for="HabRiscoExtConsideracoes">Considerações</label>
						<div class="controls">
							<textarea class="span_3" type="text" maxlength="1000" id="HabRiscoExtConsideracoes" name="HabRiscoExtConsideracoes"><?php echo (isset($hab_risco_ext["HabRiscoExtConsideracoes"])) ? $hab_risco_ext["HabRiscoExtConsideracoes"] : ""; ?></textarea>
						</div>
					</div>			

				<?php 

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da avaliaçcao de Risco.
					*/
					if (isset($hab_risco_ext["HabRiscoExtID"]) && (int)$hab_risco_ext["HabRiscoExtID"] > 0) {

						$area_down_risco_ext = "";
						$area_up_risco_ext = "";

						/* 
						* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
						* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
						* Caso contrário permite o upload de um novo.
						*/
						if (isset($hab_risco_ext["HabRiscoExtArquivoID"]) && (int)$hab_risco_ext["HabRiscoExtArquivoID"] > 0) { 
							$area_down_risco_ext = "";
							$area_up_risco_ext = "hide";
						} else {
							$area_down_risco_ext = "hide";
							$area_up_risco_ext = "";
						}

?>	
						<div class="control-group in-line">			
						
							<div id="HabRiscoExtArquivoUploader" style="position: relative;" class="controls">
								
								<input type="hidden" id="HabRiscoExtArquivoID" name="HabRiscoExtArquivoID" value = '<?php echo (isset($hab_risco_ext["HabRiscoExtArquivoID"])) ? $hab_risco_ext["HabRiscoExtArquivoID"] : ""; ?>' ></input>
							
								<label class="control-label" for="HabRiscoExtArquivoNome">Arquivo: &nbsp;
									<span class='area-view-files <?php echo $area_down_risco_ext; ?>' > 
										<a id="HabRiscoExtArquivoNome" href='#' class='up-file-name'><?php echo (isset($hab_risco_ext["HabRiscoExtArquivoNome"])) ? $hab_risco_ext["HabRiscoExtArquivoNome"] : ""; ?></a>
										<a id="del_HabRiscoExtArquivo" name="del_HabRiscoExtArquivo" href="#" class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
									</span>
								</label>
							
								<div class='area-up-files <?php echo $area_up_risco_ext; ?>' > 
									
									<div class="control-group up-list" id="listFilesHabRiscoExtArquivo" name="listFilesHabRiscoExtArquivo"></div>
									
									<div class="control-group in-line">
										<button id="add_HabRiscoExtArquivo" class="btn up-add" type="button">
											<i class="icon-plus"></i>
											<span>Selecionar Arquivo</span>
										</button>
									</div>
									
									<div class="control-group in-line">
										<button id="up_HabRiscoExtArquivo" class="btn btn-primary up-upload" type="button">
											<i class="icon-arrow-up icon-white"></i>
											<span>Upload</span>
										</button>
									</div>

								</div>

							</div>

						</div><!-- Fim do grupo de controle do upload de arquivo -->

					<?php } ?>


				</div>

				<div class="tab-pane fade " id='tabCertificacao'>

					<legend>Certificação</legend>

					<div class="control-group in-line">
						<label class="control-label" for="HabCertNumero">Número Parecer</label>
						<div class="controls">
							<input class="gravar span2" maxlength="12" type="text" id="HabCertNumero" name="HabCertNumero" value = '<?php echo (isset($hab_cert["HabCertNumero"])) ? $hab_cert["HabCertNumero"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpHabCertData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="HabCertData">Data</label>
						<div class="controls">
							<input style="width:140px;" maxlength="16" class="gravar" type="text" readonly type="text" id="HabCertData" 
								name="HabCertData" value = '<?php echo (isset($hab_cert["HabCertData"])) ? PPOEntity::toDateBr($hab_cert["HabCertData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="gravar" name="HabCertConclusaoID" id="HabCertConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($hab_cert["HabCertConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($hab_cert["HabCertConclusaoID"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ConclusaoID"] ?>' ><?php echo $row["ConclusaoDescricao"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="HabCertRating">Rating</label>
						<div class="controls">
							<input class="gravar span2"  style="text-transform:uppercase" maxlength="5" type="text" id="HabCertRating" name="HabCertRating" value = '<?php echo (isset($hab_cert["HabCertRating"])) ? $hab_cert["HabCertRating"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpHabCertValidade" data-date="" data-date-format="dd/mm/yyyy">
						<label for="HabCertValidade">Validade</label>
						<div class="controls">	
							<input style="width:140px;" maxlength="16" class="gravar" type="text" readonly type="text" id="HabCertValidade" 
							name="HabCertValidade" value = '<?php echo (isset($hab_cert["HabCertValidade"])) ? PPOEntity::toDateBr($hab_cert["HabCertValidade"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="HabCertConsideracoes">Considerações</label>
						<div class="controls">
							<textarea style='width:914px;' maxlength="1000" type="text" id="HabCertConsideracoes" name="HabCertConsideracoes" ><?php echo (isset($hab_cert["HabCertConsideracoes"])) ? $hab_cert["HabCertConsideracoes"] : ""; ?></textarea>
						</div>
					</div>

				<?php 

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID.
					*/
					if (isset($hab_cert["HabCertID"]) && (int)$hab_cert["HabCertID"] > 0) {

						$area_down_cert = "";
						$area_up_cert = "";

						/* 
						* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
						* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
						* Caso contrário permite o upload de um novo.
						*/
						if (isset($hab_cert["HabCertArquivoID"]) && (int)$hab_cert["HabCertArquivoID"] > 0) { 
							$area_down_cert = "";
							$area_up_cert = "hide";
						} else {
							$area_down_cert = "hide";
							$area_up_cert = "";
						}

				?>	
						<div class="control-group in-line">			
						
							<div id="HabCertUploader" style="position: relative;" class="controls">
								
								<input type="hidden" id="HabCertArquivoID" name="HabCertArquivoID" 
								value = '<?php echo (isset($hab_cert["HabCertArquivoID"])) ? $hab_cert["HabCertArquivoID"] : ""; ?>' ></input>
							
								<label class="control-label" for="HabCertArquivoNome">Arquivo: &nbsp;
									<span class='area-view-files <?php echo $area_down_cert; ?>' > 
										<a id="HabCertArquivoNome" href='#' class='up-file-name'><?php echo (isset($hab_cert["HabCertArquivoNome"])) ? $hab_cert["HabCertArquivoNome"] : ""; ?></a>
										<a id="del_HabCertArquivo" name="del_HabCertArquivo" href="#" class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
									</span>
								</label>
							
								<div class='area-up-files <?php echo $area_up_cert; ?>' > 
									
									<div class="control-group up-list" id="listFilesHabCertArquivo" name="listFilesHabCertArquivo"></div>
									
									<div class="control-group in-line">
										<button id="add_HabCertArquivo" class="btn up-add" type="button">
											<i class="icon-plus"></i>
											<span>Selecionar Arquivo</span>
										</button>
									</div>
									
									<div class="control-group in-line">
										<button id="up_HabCertArquivo" class="btn btn-primary up-upload" type="button">
											<i class="icon-arrow-up icon-white"></i>
											<span>Upload</span>
										</button>
									</div>

								</div>

							</div>

						</div><!-- Fim do grupo de controle do upload de arquivo -->

					<?php } ?>

				</div>

			</div>


		</form>
	
	</div>
	
	<div class="modal-footer form-actions">
		<button id="btn_salvar" class="btn_salvar btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
	
</div>

<?php 
	
	$siopm->includeJS("views", "habilitacao.form.js");
	$siopm->includeJS("views", "habilitacao.file.risco.js");
	$siopm->includeJS("views", "habilitacao.file.juridica.js"); 
	$siopm->includeJS("views", "habilitacao.file.externo.js"); 
	$siopm->includeJS("views", "habilitacao.file.certificacao.js"); 

?>
