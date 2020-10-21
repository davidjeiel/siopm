<style type="text/css">
	#formEnquadramentoAnalises{
		margin: 0px;
	}

	.tab-content{
		overflow:hidden;
	}

</style>
<script type="text/javascript">

$(document).ready(function() {

	$("#PropJuridicaArquivoNome").off("click").on("click", function(){
		window.open(app_path + "/controllers/propostas.arquivos.controller.php" 	+ "?ac=download&ArquivoID=" + $('#PropJuridicaArquivoID').val() );
	});
	$("#PropRiscoArquivoNome").off("click").on("click", function(){
		window.open(app_path + "/controllers/propostas.arquivos.controller.php" 	+ "?ac=download&ArquivoID=" + $('#PropRiscoArquivoID').val() );
	});
});

</script>
<form id="formEnquadramentoAnalises" name="formEnquadramentoAnalises" >
	
	<h3>Enquadramento e Análises</h3>
	<?php
		$show_analise_risco = "";
		if ($fase == 1){
			$show_analise_risco = "hide";
		}
	?>
	<ul class="nav nav-tabs" id="navPropostas">

		<li	 class="active"	><a href="#tabAspectosCadSecuritizadoera" 	data-toggle="tab">Aspectos Cadastrais da Securitizadora</a></li>
		<li					><a href="#tabEnquadramento" 				data-toggle="tab">Enquadramento</a></li>
		<li 				><a href="#tabAnaliseJuridica"				data-toggle="tab">Análise Jurídica</a></li>
		<li  class= "<?php echo $show_analise_risco; ?>" ><a href="#tabAnaliseRisco"					data-toggle="tab">Análise de Risco</a></li>
		
	</ul>

	<div id="tabPropostas" class="tab-content">

		<!-- =========================================================== INICIO tabAspectosCadSecuritizadoera  =========================================================== -->
		<div class="tab-pane active fade in" id='tabAspectosCadSecuritizadoera'>

			<div class="control-group in-line">
				<label class="control-label" for="CRFRegular">CRF</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="CRFRegular" name="CRFRegular" 
						value = '<?php if(isset($propPesqSecur["CRFRegular"]) && $propPesqSecur["CRFRegular"] == 1) echo "Regular"; else echo "Irregular"; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="CRFValidade">Validade do CRF</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="CRFValidade" name="CRFValidade" 
						value = '<?php echo (isset($propPesqSecur["CRFValidade"])) ? 
												PPOEntity::toDateBr($propPesqSecur["CRFValidade"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>
			
			<div class="control-group in-line">
				<label class="control-label" for="CADINRegular">CADIN</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="CADINRegular" name="CADINRegular" 
						value = '<?php if(isset($propPesqSecur["CADINRegular"]) && $propPesqSecur["CADINRegular"] == 1) echo "Regular"; else echo "Irregular"; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="CADINDataPesquisa">Data da Pesquisa (CADIN)</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="CADINDataPesquisa" name="CADINDataPesquisa" 
						value = '<?php echo (isset($propPesqSecur["CADINDataPesquisa"])) ? 
												PPOEntity::toDateBr($propPesqSecur["CADINDataPesquisa"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

		</div> <!-- Fim tabAspectosCadSecuritizadoera -->

		<!-- =========================================================== INICIO tabEnquadramento 		=========================================================== -->
		<div class="tab-pane fade " id='tabEnquadramento'>

			<p><strong>Valores Atuais dos Imóveis </p></strong>

			<div class="control-group in-line">
				<label class="control-label" for="ValorMaximo">Valor Máximo</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda" readonly maxlength="14" type="text" id="ValorMaximo" name="ValorMaximo" maxlength="13"
						value = '<?php echo (isset($propEnquad["ValorMaximo"])) ? "R$ " . PPOEntity::toMoneyBr($propEnquad["ValorMaximo"]) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ValorMinimo">Valor Mínimo</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda" readonly maxlength="14" type="text" id="ValorMinimo" name="ValorMinimo" maxlength="13"
						value = '<?php echo (isset($propEnquad["ValorMinimo"])) ? "R$ " . PPOEntity::toMoneyBr($propEnquad["ValorMinimo"]) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ValorMedio">Valor Médio</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda" readonly maxlength="14" type="text" id="ValorMedio" name="ValorMedio" maxlength="13"
						value = '<?php echo (isset($propEnquad["ValorMedio"])) ? "R$ " . PPOEntity::toMoneyBr($propEnquad["ValorMedio"]) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ValorTotal">Valor Total</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorTotal" name="ValorTotal" maxlength="13"
						value = '<?php echo (isset($propEnquad["ValorTotal"])) ? "R$ " . PPOEntity::toMoneyBr($propEnquad["ValorTotal"]) : ""; ?>' ></input>
				</div>
			</div>

			<p><strong>Taxa de Juros</p></strong>

			<div class="control-group in-line">
				<label class="control-label" for="TxJurosMaxima">Taxa de Juros Máxima</label>
				<div class="controls">
					<input class="span3 campo-formatado porcentagem" readonly type="text" id="TxJurosMaxima" name="TxJurosMaxima" maxlength="13" 
						value = '<?php echo (isset($propEnquad["TxJurosMaxima"])) ? "% " . PPOEntity::toMoneyBr($propEnquad["TxJurosMaxima"], 8) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="TxJurosMinima">Taxa de Juros Mínima</label>
				<div class="controls">
					<input class="span3 campo-formatado porcentagem" readonly type="text" id="TxJurosMinima" name="TxJurosMinima" maxlength="13"
						value = '<?php echo (isset($propEnquad["TxJurosMinima"])) ? "% " . PPOEntity::toMoneyBr($propEnquad["TxJurosMinima"], 8) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="TxJurosMedia">Taxa de Juros Média</label>
				<div class="controls">
					<input class="span3 campo-formatado porcentagem" readonly type="text" id="TxJurosMedia" name="TxJurosMedia" maxlength="13"
						value = '<?php echo (isset($propEnquad["TxJurosMedia"])) ? "% " . PPOEntity::toMoneyBr($propEnquad["TxJurosMedia"], 8) : ""; ?>' ></input>
				</div>
			</div>

			<p><strong>Prazo dos Financiamentos </p></strong>

			<div class="control-group in-line">
				<label class="control-label" for="PrazoMaximo">Prazo Máximo</label>
				<div class="controls">
					<input class="span3 campo-formatado inteiro" readonly maxlength="4" type="text" id="PrazoMaximo" name="PrazoMaximo" 
						value = '<?php echo (isset($propEnquad["PrazoMaximo"])) ? $propEnquad["PrazoMaximo"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PrazoMinimo">Prazo Mínimo</label>
				<div class="controls">
					<input class="span3 campo-formatado inteiro" readonly maxlength="4" type="text" id="PrazoMinimo" name="PrazoMinimo" 
						value = '<?php echo (isset($propEnquad["PrazoMinimo"])) ? $propEnquad["PrazoMinimo"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PrazoMedio">Prazo Médio</label>
				<div class="controls">
					<input class="span3 campo-formatado inteiro" readonly maxlength="4" type="text" id="PrazoMedio" name="PrazoMedio" 
						value = '<?php echo (isset($propEnquad["PrazoMedio"])) ? $propEnquad["PrazoMedio"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="Observacoes">Observações</label>
				<div class="">
					<textarea class="span12" type="text" id="Observacoes" readonly maxlength="1000" name="Observacoes"><?php echo (isset($propEnquad["Observacoes"])) ? $propEnquad["Observacoes"] : ""; ?></textarea>
				</div>
			</div>

		</div> <!-- Fim tabEnquadramento -->

		<!-- =========================================================== INICIO tabAnaliseJuridica =========================================================== -->
		<div class="tab-pane" id='tabAnaliseJuridica'>

			<input type="hidden" id="PropJuridicaArquivoID" name="PropJuridicaArquivoID" 
				value = '<?php echo (isset($analiseJur["PropJuridicaArquivoID"])) ? $analiseJur["PropJuridicaArquivoID"] : ""; ?>' ></input>

			<div class="control-group in-line">
				<label class="control-label" for="PropJuridicaNumParecer">Número do Parecer</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="PropJuridicaNumParecer" name="PropJuridicaNumParecer" 
					value = '<?php echo (isset($analiseJur["PropJuridicaNumParecer"])) ? $analiseJur["PropJuridicaNumParecer"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropJuridicaData">Data</label>
				<div class="controls">
					<input class="span2 " readonly type="text" id="PropJuridicaData" name="PropJuridicaData" 
						value = '<?php echo (isset($analiseJur["PropJuridicaData"])) ? 
									PPOEntity::toDateBr($analiseJur["PropJuridicaData"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ConclusaoDescricao">Conclusão</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="ConclusaoDescricao" name="ConclusaoDescricao" 
					value = '<?php echo (isset($analiseJur["ConclusaoDescricao"])) ? $analiseJur["ConclusaoDescricao"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropJuridicaObs">Observações</label>
				<div class="controls">
					<textarea class="span12" class="gravar" readonly maxlength="1000" type="text" id="PropJuridicaObs" name="PropJuridicaObs" ><?php echo (isset($analiseJur["PropJuridicaObs"])) ? $analiseJur["PropJuridicaObs"] : ""; ?></textarea>
				</div>
			</div>

			<div class="ccontrol-group in-line">
				<label class="control-label">
				<?php 
					if (isset($analiseJur["PropJuridicaArquivoNome"])) 
						echo '<a id="PropJuridicaArquivoNome" href="#" class="up-file-name">'.$analiseJur["PropJuridicaArquivoNome"]."</a>";
					else 
						echo "<span class='alert-danger'>Arquivo não encontrado!</span>"; 
				?>
				</label>
			</div><!-- Fim do CONTAINER do upload de arquivo -->

		</div> <!-- Fim tabAnaliseJuridica -->

		<!-- =========================================================== INICIO tabAnaliseRisco 		=========================================================== -->
		<div class="tab-pane fade " id='tabAnaliseRisco'>

			<input type="hidden" id="PropRiscoArquivoID" name="PropRiscoArquivoID" 
				value = '<?php echo (isset($analiseRisco["PropRiscoArquivoID"])) ? $analiseRisco["PropRiscoArquivoID"] : ""; ?>' ></input>
			
			<input  type="hidden" id="PropRiscoID" name="PropRiscoID" 
				value = '<?php echo (isset($analiseRisco["PropRiscoID"])) ? $analiseRisco["PropRiscoID"] : ""; ?>' ></input>

			<div class="control-group in-line">
				<label class="control-label" for="PropRiscoNumParecer">Número do Parecer</label>
				<div class="controls">
					<input class="span3" readonly maxlength="10" type="text" id="PropRiscoNumParecer" name="PropRiscoNumParecer" 
						value = '<?php echo (isset($analiseRisco["PropRiscoNumParecer"])) ? $analiseRisco["PropRiscoNumParecer"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropRiscoData">Data</label>
				<div class="controls">
					<input class="span2 " readonly type="text" id="PropRiscoData" name="PropRiscoData" 
						value = '<?php echo (isset($analiseRisco["PropRiscoData"])) ? 
							PPOEntity::toDateBr($analiseRisco["PropRiscoData"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ConclusaoDescricao">Conclusão</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="ConclusaoDescricao" name="ConclusaoDescricao" 
					value = '<?php echo (isset($analiseRisco["ConclusaoDescricao"])) ? $analiseRisco["ConclusaoDescricao"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropRiscoRating">Rating</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="PropRiscoRating" name="PropRiscoRating" 
					value = '<?php echo (isset($analiseRisco["PropRiscoRating"])) ? $analiseRisco["PropRiscoRating"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropTaxaNominal">Taxa Nominal de Risco</label>
				<div class="controls">
					<input class="span3 campo-formatado porcentagem" readonly type="text" id="PropTaxaNominal" name="PropTaxaNominal" 
						value = '<?php echo (isset($analiseRisco["PropTaxaNominal"])) ? PPOEntity::toMoneyBr($analiseRisco["PropTaxaNominal"], 4) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group  in-line">
				<label class="control-label" for="PropRiscoObs">Observações</label>
				<div class="controls">
					<textarea class="span12" readonly maxlength="1000" type="text" id="PropRiscoObs" name="PropRiscoObs" ><?php echo (isset($analiseRisco["PropRiscoObs"])) ? $analiseRisco["PropRiscoObs"] : ""; ?></textarea>
				</div>
			</div>
			<div class="ccontrol-group in-line">
				<label class="control-label">
				<?php 
					if (isset($analiseRisco["PropRiscoArquivoNome"])) 
						echo '<a id="PropRiscoArquivoNome" href="#" class="up-file-name">' . $analiseRisco["PropRiscoArquivoNome"] . "</a>";
					else 
						echo "<span class='alert-danger'>Arquivo não encontrado!</span>"; 
				?>
				</label>
			</div><!-- Fim do CONTAINER do upload de arquivo -->
		</div> <!-- Fim tabAnaliseRisco -->

	</div> <!-- Fim TAB CONTENT -->

</form>
