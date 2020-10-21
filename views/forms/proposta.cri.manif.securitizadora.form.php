<style type="text/css">

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-manif-securitizadora {
		/*margin-top: -40px;*/
		width: 675px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -310px;
	}

	#dialog-manif-securitizadora .control-label {
		margin-right: 20px;
	}

	#dialog-manif-securitizadora .modal-body{
		overflow: hidden;
		max-height: 900px;
	}

	#dialog-manif-securitizadora .input-append.date input{
		background:#FFF;
	}

	#dialog-manif-securitizadora input{
		padding-right: 8px;
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

		maskFormBr(2,8);

	});

</script>

<div id="dialog-manif-securitizadora" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>
	<div class="modal-body">

		<form id="formManifSecuritizadora" name="formManifSecuritizadora" >

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaFaseID" name="PropostaFaseID" 
				value = '<?php echo (isset($proposta["PropostaFaseID"])) ? $proposta["PropostaFaseID"] : "$fase"; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>

			<input type="hidden" id="PropManifSecurID" name="PropManifSecurID" 
				value = '<?php echo (isset($manifSecuritizadora["PropManifSecurID"])) ? $manifSecuritizadora["PropManifSecurID"] : ""; ?>' ></input>

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

			<ul class="nav nav-tabs" id="navPropostas">
				<li	 class="active"	><a href="#tabManifestacao" 			data-toggle="tab">Manifestação</a></li>
				<li					><a href="#tabGarantias" 				data-toggle="tab">Garantias</a></li>
				<li 				><a href="#tabConclusao"				data-toggle="tab">Conclusão</a></li>
			</ul>

			<div id="tabPropostas" class="tab-content">

				<!-- =========================================================== INICIO tabManifestacao  =========================================================== -->
				<div class="tab-pane active fade in" id='tabManifestacao'>

					<div class="control-group in-line">
						<label class="control-label" for="PropManifSecurAnaliseEngImoveis">Análise Técnica de Engenharia dos Imóveis/Empreendimento</label>
						<div class="controls">
							<textarea class="span8" type="text" maxlength="500" id="PropManifSecurAnaliseEngImoveis" name="PropManifSecurAnaliseEngImoveis" ><?php echo (isset($manifSecuritizadora["PropManifSecurAnaliseEngImoveis"])) ? $manifSecuritizadora["PropManifSecurAnaliseEngImoveis"] : ""; ?></textarea>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropManifSecurAnaliseTrabSocial">Análise Técnica de Trabalho Social do Empreendimento</label>
						<div class="controls">
							<textarea class="span8" type="text" maxlength="500" id="PropManifSecurAnaliseTrabSocial" name="PropManifSecurAnaliseTrabSocial" ><?php echo (isset($manifSecuritizadora["PropManifSecurAnaliseTrabSocial"])) ? $manifSecuritizadora["PropManifSecurAnaliseTrabSocial"] : ""; ?></textarea>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropManifSecurAnaliseJurImoveis">Análise Jurídica dos Imóveis/Empreendimento</label>
						<div class="controls">
							<textarea class="span8" type="text" maxlength="500" id="PropManifSecurAnaliseJurImoveis" name="PropManifSecurAnaliseJurImoveis" ><?php echo (isset($manifSecuritizadora["PropManifSecurAnaliseJurImoveis"])) ? $manifSecuritizadora["PropManifSecurAnaliseJurImoveis"] : ""; ?></textarea>
						</div>
					</div>

				</div> <!-- Fim tabManifestacao -->

				<!-- =========================================================== INICIO tabGarantias 		=========================================================== -->
				<div class="tab-pane fade " id='tabGarantias'>


					<div class="listaGarantias" >

						<?php 

						foreach($garantias as $row): ?>

							<div class="controls span4 inline">
								
							<label class="checkbox"> <!-- <i class="icon-warning-sign"></i> -->
								<input type="checkbox" <?php echo (in_array($row["GarantiaID"], $manifSecurGarantiasExistentes)) ? "checked='checked'" : ""; ?>
									name='<?php echo (isset($row["GarantiaID"])) ? $row["GarantiaID"] : ""; ?>'
									id='<?php echo (isset($row["GarantiaID"])) ? "GARANTIA_" . $row["GarantiaID"] : ""; ?>' >
								</input> 
								<?php echo (isset($row["GarantiaNome"])) ? $row["GarantiaNome"] : ""; ?> 
							</label>
							
						</div>

						<?php endforeach; ?>

					</div>

				</div> <!-- Fim tabGarantias -->

				<!-- =========================================================== INICIO tabConclusao =========================================================== -->
				<div class="tab-pane" id='tabConclusao'>

					<div class="control-group in-line input-append date" id="dpDataConclusaoManifSecuritizadora" 
						data-date="" data-date-format="dd/mm/yyyy" >
						<label class="control-label" for="DataConclusaoManifSecuritizadora"> Data </label>
						<div class="controls">
							<input  maxlength="16" class="gravar span2" type="text" readonly style='width:180px;' 
								id="DataConclusaoManifSecuritizadora" 
								name="DataConclusaoManifSecuritizadora" 
								value = '<?php echo (isset($manifSecuritizadora["DataConclusaoManifSecuritizadora"])) ? PPOEntity::toDateBr($manifSecuritizadora["DataConclusaoManifSecuritizadora"], "d/m/Y") : ""; ?>' >
							</input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ConclusaoManifSecuritizadora">Texto Conclusivo</label>
						<div class="controls">
							<textarea class="span8" type="text" maxlength="1000" id="ConclusaoManifSecuritizadora" name="ConclusaoManifSecuritizadora" ><?php echo (isset($manifSecuritizadora["ConclusaoManifSecuritizadora"])) ? $manifSecuritizadora["ConclusaoManifSecuritizadora"] : ""; ?></textarea>
						</div>
					</div>

					
				</div> <!-- Fim tabConclusao -->

			</div> <!-- Fim TAB CONTENT -->

		</form>

	</div>
	<div class="modal-footer">
		<button id="btn_salvar" class="btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Fechar</button>
	</div>
</div>