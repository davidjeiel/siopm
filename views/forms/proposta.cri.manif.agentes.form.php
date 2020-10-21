<style type="text/css">

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-manif-agentes .tab-pane{
		overflow: hidden;
	}

	#dialog-manif-agentes .control-label {
		margin-right: 20px;
	}

	#dialog-manif-agentes .modal-body{	
		overflow: hidden;
		max-height: 900px;
	}

	#dialog-manif-agentes .input-append.date input{
		background:#FFF;
	}

	#dialog-manif-agentes input{
		padding-right: 8px;
	}

	#dialog-manif-agentes .date{
		margin-top: -25px;
	}

	#dialog-manif-agentes{
		width: 760px;
		margin-left:-330px;
	}
	
</style>

<script type="text/javascript">

	$(document).ready(function() {

		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  

		});

		maskFormBr(2,5);

	});

</script>

<div id="dialog-manif-agentes" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>
	<div class="modal-body">

		<form id="formManifAgentes" name="formManifAgentes" >

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaFaseID" name="PropostaFaseID" 
				value = '<?php echo (isset($proposta["PropostaFaseID"])) ? $proposta["PropostaFaseID"] : "$fase"; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>

			<input type="hidden" id="PropManifGifugID" name="PropManifGifugID" 
				value = '<?php echo (isset($manifGifug["PropManifGifugID"])) ? $manifGifug["PropManifGifugID"] : ""; ?>' ></input>

			<input type="hidden" id="DataFinalizacao" name="DataFinalizacao" 
				value = '<?php echo (isset($proposta["DataFinalizacao"])) ? $proposta["DataFinalizacao"] : ""; ?>' ></input>

			<div class="control-group in-line">
				<label class="control-label" for="PropostaNumero">Número</label>
				<div class="controls">
					<input class="span2 gravar" readonly type="text" id="PropostaNumero" name="PropostaNumero" 
					value = '<?php echo (isset($proposta["PropostaNumero"])) ? $proposta["PropostaNumero"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="StatusNome">Status</label>
				<div class="controls">
					<input class="span2 gravar" readonly type="text" id="StatusNome" name="StatusNome" 
						value = '<?php echo (isset($proposta["StatusNome"])) ? $proposta["StatusNome"] : "Nova Proposta"; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropostaFaseNome">Fase</label>
				<div class="controls">
					<input class="span2 gravar" readonly type="text" id="PropostaFaseNome" name="PropostaFaseNome" 
						value = '<?php echo (isset($proposta["PropostaFaseNome"])) ? $proposta["PropostaFaseNome"] : (($fase == 1) ? "PRELIMINAR" : "DEFINITIVA") ; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
			    <label class="control-label" for="DataRecepcao">Data de Recepção</label>
			    <div class="controls">
			        <input id="DataRecepcao" name="DataRecepcao" class="gravar span2" type="text" 
			        	value= '<?php echo (isset($proposta["DataRecepcao"])) ? 
														PPOEntity::toDateBr($proposta["DataRecepcao"], "d/m/Y") : ""; ?>' 
			        	readonly="readonly"></input>
			    </div>
			</div>

			<?php
				$show_gifug = "hide";
				$show_gefom = "hide";
				$show_resolucao = "hide";
				
				if (user_has_access("CRI_PRELIMINAR_MANIF_OPERADOR") || user_has_access("CRI_DEFINITIVA_MANIF_OPERADOR"))
					$show_gifug = "active";

				if (user_has_access("CRI_PRELIMINAR_MANIF_GEFOM") || user_has_access("CRI_DEFINITIVA_MANIF_GEFOM")) {
					if ($show_gifug == "hide") {
						$show_gefom = "active";
					} else {
						$show_gefom = "";
					}
				}

				if ($fase == 2) {
					if (user_has_access("CRI_DEFINITIVA_RESOL_CONSELHO")) {
						$show_resolucao = "";
					}
				}
			?>

			<ul class="nav nav-tabs" id="navPropostas">
				<?php
					/*if (user_has_access("CRI_PRELIMINAR_MANIF_OPERADOR") || user_has_access("CRI_DEFINITIVA_MANIF_OPERADOR"))
						echo '<li class="active"><a href="#tabManifGifug" data-toggle="tab">Manifestação GIFUG</a></li>';

					if (user_has_access("CRI_PRELIMINAR_MANIF_GEFOM") || user_has_access("CRI_DEFINITIVA_MANIF_GEFOM"))
						echo '<li><a href="#tabManifGefom" data-toggle="tab">Manifestação GEFOM</a></li>';*/
				?>
				<li class="<?php echo $show_gifug; ?>"><a href="#tabManifGifug" data-toggle="tab">Manifestação GIFUG</a></li>
				<li class="<?php echo $show_gefom; ?>"><a href="#tabManifGefom" data-toggle="tab"><?php echo ($fase == 1)? "Manifestação SUFUG" : "Manifestação VIFUG" ?></a></li>
				<li class="<?php echo $show_resolucao; ?>"><a href="#tabResolucao" data-toggle="tab">Resolução Conselho</a></li>
			</ul>

			<div id="tabPropostas" class="tab-content">

				<!-- =========================================================== INICIO tabManifGifug 			=========================================================== -->
				<div class="tab-pane fade in<?php echo ($show_gifug == "active") ? " ".$show_gifug : ""; ?>" id='tabManifGifug'>


					<div class="control-group input-append date in-line" id="dpManifGifugData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="ManifGifugData">Data</label>
						<div class="controls">
							<input style="width:100px;" maxlength="16" class="gravar" readonly="readonly" type="text" id="ManifGifugData" 
								name="ManifGifugData" value = '<?php echo (isset($manifGifug["ManifGifugData"])) ? 
								PPOEntity::toDateBr($manifGifug["ManifGifugData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="span2" name="GifugConclusaoID" id="GifugConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($conclusoes)) foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($manifGifug["GifugConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($manifGifug["GifugConclusaoID"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ConclusaoID"] ?>' >
										<?php echo $row["ConclusaoDescricao"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					
					<div class="control-group in-line">
						<label class="control-label" for="ManifGifugObs">Texto Conclusivo</label>
						<div class="controls">
							<textarea class="span9" class="gravar" maxlength="1000" type="text" id="ManifGifugObs" name="ManifGifugObs" ><?php echo (isset($manifGifug["ManifGifugObs"])) ? $manifGifug["ManifGifugObs"] : ""; ?></textarea>
						</div>
					</div>

					<?php 

					$area_up_gif 	= "hide";
					$area_down 		= "";
					$area_up 		= "";

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da Análise Jurídica.
					*/
					if (isset($manifGifug["PropManifGifugID"]) && $manifGifug["PropManifGifugID"] > 0) {
						$area_up_gif = "";
					}

					/* 
					* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
					* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
					* Caso contrário permite o upload de um novo.
					*/
					if (isset($manifGifug["GifugArquivoID"]) && (int)$manifGifug["GifugArquivoID"] > 0) { 
						$area_up = "hide";
					} else {
						$area_down = "hide";
					}

					?>	


					<!-- Container do controle de UPLOAD de arquivo para Manifestação da GEFOM -->
					<div id = "prop_gif_view_files_up" class="<?php echo $area_up_gif ?>">
						
						<div id="PropGifugArquivoUploader" name="PropGifugArquivoUploader"  style="position: relative;" class="controls">

							<input type="hidden" id="GifugArquivoID" name="GifugArquivoID" 
								value = '<?php echo (isset($manifGifug["GifugArquivoID"])) ? $manifGifug["GifugArquivoID"] : ""; ?>' ></input>

							<label class="control-label" for="GifugArquivoNome">Arquivo: &nbsp;
								<span class='area-view-files <?php echo $area_down; ?>' > 
									<a id="GifugArquivoNome" href='#' class='up-file-name'>
										<?php echo (isset($manifGifug["GifugArquivoNome"])) ? $manifGifug["GifugArquivoNome"] : ""; ?></a>
									<a id="del_GifugArquivo" name="del_GifugArquivo"  href="#" 
										class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
								</span>
							</label>
						
							<div class='area-up-files <?php echo $area_up; ?>' > 
								
								<div class="control-group up-list" id="listFilesGifugArquivo" name="listFilesGifugArquivo"></div>
								
								<div class="control-group in-line">
									<button id="add_GifugArquivo" class="btn up-add" type="button">
										<i class="icon-plus"></i>
										<span>Selecionar Arquivo</span>
									</button>
								</div>
								
								<div class="control-group in-line">
									<button id="up_GifugArquivo" class="btn btn-primary up-upload" type="button">
										<i class="icon-arrow-up icon-white"></i>
										<span>Upload</span>
									</button>
								</div>

							</div>

						</div>

					</div><!-- Fim do CONTAINER do upload de arquivo -->

				</div> <!-- Fim tabManifGifug -->
				
				<!-- =========================================================== INICIO tabManifGefom 			=========================================================== -->
				<div class="tab-pane fade in<?php echo ($show_gefom == "active") ? " ".$show_gefom : ""; ?>" id='tabManifGefom'>
			
					<input type="hidden" id="PropManifGefomID" name="PropManifGefomID" 
						value = '<?php echo (isset($manifGefom["PropManifGefomID"])) ? $manifGefom["PropManifGefomID"] : ""; ?>' ></input>

					<input type="hidden" id="PropostaFaseNome" name="PropostaFaseNome" 
								value = '<?php echo (isset($proposta["PropostaFaseNome"])) ? $proposta["PropostaFaseNome"] : ($fase == 1) ? "PRELIMINAR" : "DEFINITIVA"  ; ?>' ></input>

					<div class="control-group input-append date in-line" id="dpManifGefomData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="ManifGefomData">Data</label>
						<div class="controls">
							<input style="width:100px;" maxlength="16" class="gravar" readonly="readonly" type="text" id="ManifGefomData" 
								name="ManifGefomData" value = '<?php echo (isset($manifGefom["ManifGefomData"])) ? 
								PPOEntity::toDateBr($manifGefom["ManifGefomData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<?php if ($fase == 2) { ?>

						<div class="control-group in-line ">
							<label class="control-label" for="GefomOficioVoto">Voto VIFUG</label>
							<div class="controls">
								<input class="span2 gravar" maxlength="10" type="text" id="GefomOficioVoto" name="GefomOficioVoto" 
									value = '<?php echo (isset($manifGefom["GefomOficioVoto"])) ? $manifGefom["GefomOficioVoto"] : ""; ?>' ></input>
							</div>
						</div>

					<?php } ?>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="span2" name="GefomConclusaoID" id="GefomConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($conclusoes)) foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($manifGefom["GefomConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($manifGefom["GefomConclusaoID"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ConclusaoID"] ?>' >
										<?php echo $row["ConclusaoDescricao"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ValorAprovadoGEFOM">Valor Aprovado GEFOM</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda"  maxlength="20" <?php if ($fase == 2) echo "readonly"; ?> type="text" id="ValorAprovadoGEFOM" name="ValorAprovadoGEFOM" 
							value = '<?php echo (isset($proposta["ValorAprovadoGEFOM"])) ?  PPOEntity::toMoneyBr($proposta["ValorAprovadoGEFOM"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ManifGefomObs">Texto Conclusivo</label>
						<div class="controls">
							<textarea class="span9" class="gravar" maxlength="1000" type="text" id="ManifGefomObs" name="ManifGefomObs" ><?php echo (isset($manifGefom["ManifGefomObs"])) ? $manifGefom["ManifGefomObs"] : ""; ?></textarea>
						</div>
					</div>

					<?php 

					$area_up_gef 	= "hide";
					$area_down 		= "";
					$area_up 		= "";

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da Análise Jurídica.
					*/
					if (isset($manifGefom["PropManifGefomID"]) && $manifGefom["PropManifGefomID"] > 0) {
						$area_up_gef = "";
					}

					/* 
					* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
					* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
					* Caso contrário permite o upload de um novo.
					*/
					if (isset($manifGefom["GefomArquivoID"]) && (int)$manifGefom["GefomArquivoID"] > 0) { 
						$area_up = "hide";
					} else {
						$area_down = "hide";
					}

					?>	

					<!-- Container do controle de UPLOAD de arquivo para GEFOM -->
					<div id = "prop_gef_view_files_up" class="<?php echo $area_up_gef ?>">		
						
						<div id="PropGefomArquivoUploader" style="position: relative;" class="controls">

							<input type="hidden" id="GefomArquivoID" name="GefomArquivoID" 
								value = '<?php echo (isset($manifGefom["GefomArquivoID"])) ? $manifGefom["GefomArquivoID"] : ""; ?>' ></input>

							<label class="control-label" for="GefomArquivoNome">Arquivo: &nbsp;
								<span class='area-view-files <?php echo $area_down; ?>' > 
									<a id="GefomArquivoNome" href='#' class='up-file-name'>
										<?php echo (isset($manifGefom["GefomArquivoNome"])) ? $manifGefom["GefomArquivoNome"] : ""; ?></a>
									<a id="del_GefomArquivo" name="del_GefomArquivo"  href="#" 
										class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
								</span>
							</label>
						
							<div class='area-up-files <?php echo $area_up; ?>' > 
								
								<div class="control-group up-list" id="listFilesGefomArquivo" name="listFilesGefomArquivo"></div>
								
								<div class="control-group in-line">
									<button id="add_GefomArquivo" class="btn up-add" type="button">
										<i class="icon-plus"></i>
										<span>Selecionar Arquivo</span>
									</button>
								</div>
								
								<div class="control-group in-line">
									<button id="up_GefomArquivo" class="btn btn-primary up-upload" type="button">
										<i class="icon-arrow-up icon-white"></i>
										<span>Upload</span>
									</button>
								</div>

							</div>

						</div>

					</div><!-- Fim do CONTAINER do upload de arquivo -->
						
				</div> <!-- Fim tabManifGefom -->

				<!-- =========================================================== INICIO tabResolucao 			=========================================================== -->
				<div class="tab-pane fade in" id='tabResolucao'>

					<input type="hidden" id="PropResolucaoConselhoID" name="PropResolucaoConselhoID" 
						value = '<?php echo (isset($resolucao["PropResolucaoConselhoID"])) ? $resolucao["PropResolucaoConselhoID"] : ""; ?>' ></input>

					<input type="hidden" id="PropostaFaseNome" name="PropostaFaseNome" 
								value = '<?php echo (isset($proposta["PropostaFaseNome"])) ? $proposta["PropostaFaseNome"] : ($fase == 1) ? "PRELIMINAR" : "DEFINITIVA"  ; ?>' ></input>

					<div class="control-group input-append date in-line" id="dpPropResolucaoData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="PropResolucaoData">Data</label>
						<div class="controls">
							<input style="width:100px;" maxlength="16" class="gravar" readonly="readonly" type="text" id="PropResolucaoData" 
								name="PropResolucaoData" value = '<?php echo (isset($resolucao["PropResolucaoData"])) ? 
								PPOEntity::toDateBr($resolucao["PropResolucaoData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line ">
						<label class="control-label" for="PropResolucaoNumero">Número da Resolução</label>
						<div class="controls">
							<input class="span2 gravar" maxlength="10" type="text" id="PropResolucaoNumero" name="PropResolucaoNumero" 
								value = '<?php echo (isset($resolucao["PropResolucaoNumero"])) ? $resolucao["PropResolucaoNumero"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="span2" name="PropResolucaoConclusaoID" id="PropResolucaoConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($conclusoes)) foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($resolucao["PropResolucaoConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($resolucao["PropResolucaoConclusaoID"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ConclusaoID"] ?>' >
										<?php echo $row["ConclusaoDescricao"]?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropResolucaoObs">Texto Conclusivo</label>
						<div class="controls">
							<textarea class="span6" class="gravar" maxlength="1000" type="text" id="PropResolucaoObs" name="PropResolucaoObs" ><?php echo (isset($resolucao["PropResolucaoObs"])) ? $resolucao["PropResolucaoObs"] : ""; ?></textarea>
						</div>
					</div>

					<?php 

					$area_up_res 	= "hide";
					$area_down 		= "";
					$area_up 		= "";
				
					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da Análise Jurídica.
					*/
					if (isset($resolucao["PropResolucaoConselhoID"]) && $resolucao["PropResolucaoConselhoID"] > 0) {
						$area_up_res = "";
					}

					/* 
					* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
					* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
					* Caso contrário permite o upload de um novo.
					*/
					if (isset($resolucao["PropResolucaoArquivoID"]) && (int)$resolucao["PropResolucaoArquivoID"] > 0) { 
						$area_up = "hide";
					} else {
						$area_down = "hide";
					}

					?>	

					<!-- Container do controle de UPLOAD de arquivo para a análise jurídica -->
					<div id = "prop_res_view_files_up" class="<?php echo $area_up_res ?>">		
						
						<div id="PropResolucaoArquivoUploader" style="position: relative;" class="controls">

							<input type="hidden" id="PropResolucaoArquivoID" name="PropResolucaoArquivoID" 
								value = '<?php echo (isset($resolucao["PropResolucaoArquivoID"])) ? $resolucao["PropResolucaoArquivoID"] : ""; ?>' ></input>

							<label class="control-label" for="PropResolucaoArquivoNome">Arquivo: &nbsp;
								<span class='area-view-files <?php echo $area_down; ?>' > 
									<a id="PropResolucaoArquivoNome" href='#' class='up-file-name'>
										<?php echo (isset($resolucao["PropResolucaoArquivoNome"])) ? $resolucao["PropResolucaoArquivoNome"] : ""; ?></a>
									<a id="del_ResolucaoArquivo" name="del_ResolucaoArquivo"  href="#" 
										class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
								</span>
							</label>
						
							<div class='area-up-files <?php echo $area_up; ?>' > 
								
								<div class="control-group up-list" id="listFilesResolucaoArquivo" name="listFilesResolucaoArquivo"></div>
								
								<div class="control-group in-line">
									<button id="add_ResolucaoArquivo" class="btn up-add" type="button">
										<i class="icon-plus"></i>
										<span>Selecionar Arquivo</span>
									</button>
								</div>
								
								<div class="control-group in-line">
									<button id="up_ResolucaoArquivo" class="btn btn-primary up-upload" type="button">
										<i class="icon-arrow-up icon-white"></i>
										<span>Upload</span>
									</button>
								</div>

							</div>

						</div>

					</div><!-- Fim do CONTAINER do upload de arquivo -->
						
				</div> <!-- Fim tabManifGefom -->

			</div> <!-- FIM tab-content -->

		</form>		

	</div>
	<div class="modal-footer">
		<button id="btn_salvar" class="btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>

</div>

<?php 
	
	$siopm->includeJS("views", "propostas.file.gefom.js"); 
	$siopm->includeJS("views", "propostas.file.gifug.js");
	$siopm->includeJS("views", "propostas.file.resolucao.js"); 
	
?>
