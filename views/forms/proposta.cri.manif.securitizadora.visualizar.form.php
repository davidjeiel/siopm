<style type="text/css">
	#formManifSecuritizadora{
		margin: 0px;
	}

	.tab-content{
		overflow:hidden;
	}

</style>
<form id="formManifSecuritizadora" name="formManifSecuritizadora" >
	<h3>Manifestação da Securitizadora</h3>
	<ul class="nav nav-tabs" id="navPropostas">
		<li	 class="active"	><a href="#tabManifestacao" 			data-toggle="tab">Manifestação</a></li>
		<li					><a href="#tabGarantias" 				data-toggle="tab">Garantias</a></li>
		<li 				><a href="#tabConclusao"				data-toggle="tab">Conclusão</a></li>
	</ul>

	<div id="tabPropostas" class="tab-content">
		<!-- =========================================================== INICIO tabManifestacao  =========================================================== -->
		<div class="tab-pane active fade in" id='tabManifestacao'>

			<div class="control-group in-line">
				<label class="control-label" for="PropManifSecurAnaliseEngImoveis">Análise Técnica de Engenharia dos Imóveis/Empreendimentos</label>
				<div class="controls">
					<textarea class="span12" readonly type="text" maxlength="500" id="PropManifSecurAnaliseEngImoveis" name="PropManifSecurAnaliseEngImoveis" ><?php echo (isset($manifSecuritizadora["PropManifSecurAnaliseEngImoveis"])) ? $manifSecuritizadora["PropManifSecurAnaliseEngImoveis"] : ""; ?></textarea>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropManifSecurAnaliseTrabSocial">Análise Técnica de Trabalho Social do Empreendimento</label>
				<div class="controls">
					<textarea class="span12" readonly type="text" maxlength="500" id="PropManifSecurAnaliseTrabSocial" name="PropManifSecurAnaliseTrabSocial" ><?php echo (isset($manifSecuritizadora["PropManifSecurAnaliseTrabSocial"])) ? $manifSecuritizadora["PropManifSecurAnaliseTrabSocial"] : ""; ?></textarea>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropManifSecurAnaliseJurImoveis">Análise Jurídica dos Imóveis/Empreendimento</label>
				<div class="controls">
					<textarea class="span12" readonly type="text" maxlength="500" id="PropManifSecurAnaliseJurImoveis" name="PropManifSecurAnaliseJurImoveis" ><?php echo (isset($manifSecuritizadora["PropManifSecurAnaliseJurImoveis"])) ? $manifSecuritizadora["PropManifSecurAnaliseJurImoveis"] : ""; ?></textarea>
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
							<input disabled type="checkbox" <?php echo (in_array($row["GarantiaID"], $manifSecurGarantiasExistentes)) ? "checked='checked'" : ""; ?>
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

			<div class="control-group">
				<label class="control-label" for="DataConclusaoManifSecuritizadora">Data</label>
				<div class="controls">
					<input class="span3 " readonly type="text" id="DataConclusaoManifSecuritizadora" name="DataConclusaoManifSecuritizadora" 
						value = '<?php echo (isset($manifSecuritizadora["DataConclusaoManifSecuritizadora"])) ? 
									PPOEntity::toDateBr($manifSecuritizadora["DataConclusaoManifSecuritizadora"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ConclusaoManifSecuritizadora">Texto Conclusivo</label>
				<div class="controls">
					<textarea class="span12" type="text" readonly maxlength="1000" id="ConclusaoManifSecuritizadora" name="ConclusaoManifSecuritizadora" ><?php echo (isset($manifSecuritizadora["ConclusaoManifSecuritizadora"])) ? $manifSecuritizadora["ConclusaoManifSecuritizadora"] : ""; ?></textarea>
				</div>
			</div>

		</div> <!-- Fim tabConclusao -->

	</div> <!-- Fim TAB CONTENT -->

</form>