<script type="text/javascript">

	$(document).ready(function() {

		maskMoedaBR(8);
		maskInteiro();
		maskNumeroBR(8);
		maskPorcentagemBR(6);
		
		$(document).off("click", "table#lista_arquivos a.visualizar");
		$(document).on("click", "table#lista_arquivos a.visualizar", function() {
			var ArquivoID = $(this).closest("tr").data('arquivoid');
			window.open( app_path + "/controllers/ativos.arquivos.controller.php" + "?ac=download&ArquivoID=" + ArquivoID );
		});

	});	


</script>

<style>

	#dialog-manut-ativo-view {
		width: 1000px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	   /* margin-top: -60px!important;*/
	}

	#dialog-manut-ativo-view .modal-body{
		padding-bottom: 30px;
		overflow: hidden;
		max-height: 530px;
	}

	.tab-content{
		padding-left: 10px;
		overflow:hidden;
	}

	.tab-content legend{
		margin-top: -10px;
		margin-bottom: 10px;
	}

	.date{
		margin-top: -17px;
	}

	.direita{
		text-align: right!important;
	}
	
	.date input {
		margin-bottom: 10px;
		width: 179px;		
	}

</style>

<div id="dialog-manut-ativo-view" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">

		<form id='formAtivosDadosBasicos' name='formAtivosDadosBasicos' >

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value='<?php echo (isset($AtivoDadoBasico["AtivoID"])) ? $AtivoDadoBasico["AtivoID"] : ""; ?>' >
			</input>
			<input type="hidden" id="AtivoTipoID" name="AtivoTipoID" 
				value='<?php echo (isset($AtivoDadoBasico["AtivoTipoID"])) ? $AtivoDadoBasico["AtivoTipoID"] : ""; ?>' >
			</input>
			<input type="hidden" id="PropostaID" name="PropostaID" 
				value='<?php echo (isset($AtivoDadoBasico["PropostaID"])) ? $AtivoDadoBasico["PropostaID"] : ""; ?>'>
			</input>
			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value='<?php echo (isset($AtivoDadoBasico["PropostaDetalheID"])) ? $AtivoDadoBasico["PropostaDetalheID"] : ""; ?>'>
			</input>			

			<input type="hidden" id="AtivoAtivo" name="AtivoAtivo" 
				value='<?php echo (isset($AtivoDadoBasico["AtivoAtivo"])) ? $AtivoDadoBasico["AtivoAtivo"] : ""; ?>'>
			</input>
			<input type="hidden" id="AtivoRegistroID" name="AtivoRegistroID" 
				value='<?php echo (isset($AtivoDadoBasico["AtivoRegistroID"])) ? $AtivoDadoBasico["AtivoRegistroID"] : ""; ?>'>
			</input>

			<ul class="nav nav-tabs" id="navAtivos">
				<li class="active"	><a href="#tabDadosBasicos"		data-toggle="tab">Dados Básicos</a></li>
				<li					><a href="#tabRegistros" 		data-toggle="tab">Registro</a></li>				
				<li					><a href="#tabCalculos" 		data-toggle="tab">Cálculo</a></li>
				<li					><a href="#tabGarantiasAtivo" 	data-toggle="tab">Garantias</a></li>
				<li					><a href="#tabJuros" 			data-toggle="tab">Juros</a></li>
				<li					><a href="#tabSubscricoes" 		data-toggle="tab">Subscrições</a></li>
				<li					><a href="#tabEntidadesAtivo"	data-toggle="tab">Entidades</a></li>				
				<li					><a href="#tabArquivos" 		data-toggle="tab">Arquivos</a></li>
			</ul>

			<div id="tabAtivos" class="tab-content">
				<!-- =========================================================== INICIO tabDadosBasicos 			=========================================================== -->
				<div class="tab-pane active fade in" id='tabDadosBasicos'>

					<div class="control-group in-line">
						<label class="control-label" for="ModalidadeID">Modalidade</label>
							<div class="controls">
								<select class="span3" name="ModalidadeID" id="ModalidadeID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($modalidades)) foreach($modalidades as $row): ?>
											<?php 
												if (isset($row["ModalidadeID"])){
													 if (isset($AtivoDadoBasico["ModalidadeID"]) && $row["ModalidadeID"] == $AtivoDadoBasico["ModalidadeID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["ModalidadeID"] ?>' ><?php echo $row["ModalidadeNome"] . " - " . $row["ModalidadeSetor"]; ?> </option>
										<?php endforeach; ?>
									</select>						
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoCodigoSIOPM">Código SIOPM</label>
							<div class="controls">
								<input class="span3" type="text" id="AtivoCodigoSIOPM" name="AtivoCodigoSIOPM" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoSIOPM"])) ? $AtivoDadoBasico["AtivoCodigoSIOPM"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoSubtipoID">Subtipo do Ativo</label>
							<div class="controls">		
								<select class="span3" name="AtivoSubtipoID" id="AtivoSubtipoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($ativosSubtipos)) foreach($ativosSubtipos as $row): ?>
											<?php 
												if (isset($row["AtivoSubtipoID"])){
													 if (isset($AtivoDadoBasico["AtivoSubtipoID"]) && $row["AtivoSubtipoID"] == $AtivoDadoBasico["AtivoSubtipoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["AtivoSubtipoID"] ?>' ><?php echo $row["AtivoSubtipoNome"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoCodigoCetip">Código CETIP</label>
							<div class="controls">
								<input class="span3" type="text" id="AtivoCodigoCetip" name="AtivoCodigoCetip" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoCetip"])) ? $AtivoDadoBasico["AtivoCodigoCetip"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoCodigoBmfBovespa">Código BM&amp;FBOVESPA</label>
							<div class="controls">
								<input class="span3" type="text" id="AtivoCodigoBmfBovespa" name="AtivoCodigoBmfBovespa" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoBmfBovespa"])) ? $AtivoDadoBasico["AtivoCodigoBmfBovespa"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoCodigoIsin">Código ISIN</label>
							<div class="controls">
								<input class="span3" type="text" id="AtivoCodigoIsin" name="AtivoCodigoIsin" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoIsin"])) ? $AtivoDadoBasico["AtivoCodigoIsin"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoNumeroEmissao">Número da Emissão</label>
							<div class="controls">
								<input class="span3" type="text" id="AtivoNumeroEmissao" name="AtivoNumeroEmissao" value = '<?php echo (isset($AtivoDadoBasico["AtivoNumeroEmissao"])) ? $AtivoDadoBasico["AtivoNumeroEmissao"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
								<label class="control-label" for="AtivoNumeroSerie">Número da Série</label>
								<div class="controls">
									<input class="span3" type="text" id="AtivoNumeroSerie" name="AtivoNumeroSerie" value="<?php echo (isset($AtivoDadoBasico["AtivoNumeroSerie"])) ? $AtivoDadoBasico["AtivoNumeroSerie"] : ""; ?>"></input>
								</div>
					</div>

					<div class="control-group in-line input-append date" id="AtivoDataEmissao" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataEmissao">Data da Emissão</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataEmissao" name="AtivoDataEmissao" readonly 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoDataEmissao"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoDataEmissao"], "d/m/Y") : ""; ?>'  /> 
							<span  class="add-on"><i class="icon-th"></i></span>
					</div> 

					<div class="control-group in-line input-append date" id="AtivoDataVencimento" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataVencimento">Data do Vencimento</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataVencimento" name="AtivoDataVencimento" readonly 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoDataVencimento"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoDataVencimento"], "d/m/Y") : ""; ?>'  /> 
							<span class="add-on"><i class="icon-th"></i></span>
					</div> 

					<div class="control-group in-line">
						<label class="control-label" for="IndexadorID">Indexador</label>
							<div class="controls">
								<select class="span6" name="IndexadorID" id="IndexadorID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($indexadores)) foreach($indexadores as $row): ?>
											<?php 
												if (isset($row["IndexadorID"])){
													 if (isset($AtivoDadoBasico["IndexadorID"]) && $row["IndexadorID"] == $AtivoDadoBasico["IndexadorID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["IndexadorID"] ?>' ><?php echo $row["IndexadorNome"]." (".$row["IndexadorAbreviatura"].")"; ?> </option>
										<?php endforeach; ?>
								</select>

							</div>
					</div>


					<div class="control-group in-line">
						<label class="control-label" for="AtivoSituacaoID">Situação Financeira</label>
							<div class="controls">
								<select class="span3" name="AtivoSituacaoID" id="AtivoSituacaoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($ativosSituacoes)) foreach($ativosSituacoes as $row): ?>
											<?php 
												if (isset($row["AtivoSituacaoID"])){
													 if (isset($AtivoDadoBasico["AtivoSituacaoID"]) && $row["AtivoSituacaoID"] == $AtivoDadoBasico["AtivoSituacaoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["AtivoSituacaoID"] ?>' ><?php echo $row["AtivoSituacaoNome"]; ?> </option>
										<?php endforeach; ?>
								</select>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoQuantidade">Quantidade (Emissão)</label>
							<div class="controls">
								<input class="span3 numero campo-formatado" type="text" id="AtivoQuantidade" name="AtivoQuantidade" value = '<?php echo (isset($AtivoDadoBasico["AtivoQuantidade"])) ? $AtivoDadoBasico["AtivoQuantidade"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoValorNominalUnitario">Valor Unitário (Emissão)</label>
							<div class="controls">
								<input class="span3 moeda campo-formatado" type="text" id="AtivoValorNominalUnitario" name="AtivoValorNominalUnitario" value = '<?php echo (isset($AtivoDadoBasico["AtivoValorNominalUnitario"])) ? $AtivoDadoBasico["AtivoValorNominalUnitario"] : ""; ?>' ></input>
							</div>
					</div>

							<!-- O campo de volume é meramente informativo, sendo calculado pela multiplicação dos campos Quantidade e Valor Nominal Unitário. -->
					<div class="control-group in-line">
						<label class="control-label" for="AtivoVolume">Volume (Emissão)</label>
							<div class="controls">
								<input class="span3 moeda campo-formatado" type="text" id="AtivoVolume" name="AtivoVolume" value='<?php echo (isset($AtivoDadoBasico["AtivoVolume"])) ? $AtivoDadoBasico["AtivoVolume"] : ""; ?>'></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoTaxaRiscoNominal">Taxa de Risco Nominal</label>
							<div class="controls">
								<input class="span3 porcentagem campo-formatado" type="text" id="AtivoTaxaRiscoNominal" name="AtivoTaxaRiscoNominal" value = '<?php echo (isset($AtivoDadoBasico["AtivoTaxaRiscoNominal"])) ? $AtivoDadoBasico["AtivoTaxaRiscoNominal"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoTaxaEstruturacaoNominal">Taxa de Estruturação Nominal</label>
							<div class="controls">
								<input class="span3 porcentagem campo-formatado" type="text" id="AtivoTaxaEstruturacaoNominal" name="AtivoTaxaEstruturacaoNominal" value = '<?php echo (isset($AtivoDadoBasico["AtivoTaxaEstruturacaoNominal"])) ? $AtivoDadoBasico["AtivoTaxaEstruturacaoNominal"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoObservacoes">Observações</label>
						<div class="controls">
							<textarea class="span12" type="text" id="AtivoObservacoes" maxlength="250" name="AtivoObservacoes"><?php echo (isset($AtivoDadoBasico["AtivoObservacoes"])) ? $AtivoDadoBasico["AtivoObservacoes"] : ""; ?></textarea>
						</div>
					</div>		

				</div> <!-- Fim tabDadosBasicos -->

				<!-- =========================================================== INICIO tabRegistros 			=========================================================== -->
				<div class="tab-pane fade in" id='tabRegistros'>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoLiquidacaoTipoID">Liquidação e Custódia</label>
							<div class="controls">
								<select class="span3" name="AtivoLiquidacaoTipoID" id="AtivoLiquidacaoTipoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($liquidacoes)) foreach($liquidacoes as $row): ?>
											<?php 
												if (isset($row["AtivoLiquidacaoTipoID"])){
													 if (isset($AtivoDadoBasico["AtivoLiquidacaoTipoID"]) && $row["AtivoLiquidacaoTipoID"] == $AtivoDadoBasico["AtivoLiquidacaoTipoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["AtivoLiquidacaoTipoID"] ?>' ><?php echo $row["AtivoLiquidacaoTipoNome"] ; ?> </option>
										<?php endforeach; ?>
									</select>						
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoRegistroEsforcoRestrito">Esforços Restritos</label>
							<div class="controls">
								<select class="span3" name="AtivoRegistroEsforcoRestrito" id="AtivoRegistroEsforcoRestrito">
									<?php 
										$selSim = "";
										$selNao = "";
										if (isset($AtivoDadoBasico["AtivoRegistroEsforcoRestrito"]) && $AtivoDadoBasico["AtivoRegistroEsforcoRestrito"]=='1'){
											$selSim ="selected = 'selected'";
										}
										if (isset($AtivoDadoBasico["AtivoRegistroEsforcoRestrito"]) && $AtivoDadoBasico["AtivoRegistroEsforcoRestrito"]=='0'){
											$selNao ="selected = 'selected'";
										}
									?>
									<option value="">Selecione</option>
									<option <?php echo $selSim; ?> value="1">Sim</option>
									<option <?php echo $selNao; ?> value="0">Não</option>
								</select>						
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoRegistroCVM">Registro na CVM</label>
							<div class="controls">
								<input class="span3" type="text" id="AtivoRegistroCVM" name="AtivoRegistroCVM" value = '<?php echo (isset($AtivoDadoBasico["AtivoRegistroCVM"])) ? $AtivoDadoBasico["AtivoRegistroCVM"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line input-append date" id="AtivoRegistroDataCVM" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoRegistroDataCVM">Data de Registro</label>
								<input  style='width: 178px;' maxlength="16" type="text" id="AtivoRegistroDataCVM" name="AtivoRegistroDataCVM" readonly 
								value = '<?php echo (isset($AtivoDadoBasico["AtivoRegistroDataCVM"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoRegistroDataCVM"], "d/m/Y") : ""; ?>'  /> 
							<span  class="add-on"><i class="icon-th"></i></span>
					</div> 


				</div> <!-- Fim tabRegistros -->

				<!-- =========================================================== INICIO tabCalculos 			=========================================================== -->
				<div class="tab-pane fade in" id='tabCalculos'>

					<div class="control-group in-line">
						<label class="control-label" for="DiasAnoIndexadorID">Ano Indexador</label>
							<div class="controls">		
								<select class="span3" name="DiasAnoIndexadorID" id="DiasAnoIndexadorID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($diasano)) foreach($diasano as $row): ?>
											<?php 
												if (isset($row["DiasAnoID"])){
													 if (isset($AtivoDadoBasico["DiasAnoIndexadorID"]) && $row["DiasAnoID"] == $AtivoDadoBasico["DiasAnoIndexadorID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["DiasAnoID"] ?>' ><?php echo $row["DiasAnoQuantidade"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="DiaAnoJurosID">Ano Juros</label>
							<div class="controls">		
								<select class="span3" name="DiaAnoJurosID" id="DiaAnoJurosID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($diasano)) foreach($diasano as $row): ?>
											<?php 
												if (isset($row["DiasAnoID"])){
													 if (isset($AtivoDadoBasico["DiaAnoJurosID"]) && $row["DiasAnoID"] == $AtivoDadoBasico["DiaAnoJurosID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["DiasAnoID"] ?>' ><?php echo $row["DiasAnoQuantidade"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="DiasAnoAmortizacaoID">Ano Amortização</label>
							<div class="controls">		
								<select class="span3" name="DiasAnoAmortizacaoID" id="DiasAnoAmortizacaoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($diasano)) foreach($diasano as $row): ?>
											<?php 
												if (isset($row["DiasAnoID"])){
													 if (isset($AtivoDadoBasico["DiasAnoAmortizacaoID"]) && $row["DiasAnoID"] == $AtivoDadoBasico["DiasAnoAmortizacaoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["DiasAnoID"] ?>' ><?php echo $row["DiasAnoQuantidade"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line input-append date" id="AtivoDataPrimeiraRemuneracao" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataPrimeiraRemuneracao">Data da 1ª Remuneração</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataPrimeiraRemuneracao" name="AtivoDataPrimeiraRemuneracao" readonly 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoDataPrimeiraRemuneracao"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoDataPrimeiraRemuneracao"], "d/m/Y") : ""; ?>'  /> 
							<span class="add-on"><i class="icon-th"></i></span>
					</div> 

					<div class="control-group in-line input-append date" id="AtivoDataPrimeiraAmortizacao" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataPrimeiraAmortizacao">Data da 1ª Amortização</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataPrimeiraAmortizacao" name="AtivoDataPrimeiraAmortizacao" readonly 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoDataPrimeiraAmortizacao"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoDataPrimeiraAmortizacao"], "d/m/Y") : ""; ?>'  /> 
							<span  class="add-on"><i class="icon-th"></i></span>
					</div> 

					<div class="control-group in-line">
						<label class="control-label" for="DiasBaseRemuneracaoID">Dia Base da Remuneração</label>
							<div class="controls">		
								<select class="span3" name="DiasBaseRemuneracaoID" id="DiasBaseRemuneracaoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($diasbase)) foreach($diasbase as $row): ?>
											<?php 
												if (isset($row["DiasBaseID"])){
													 if (isset($AtivoDadoBasico["DiasBaseRemuneracaoID"]) && $row["DiasBaseID"] == $AtivoDadoBasico["DiasBaseRemuneracaoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["DiasBaseID"] ?>' ><?php echo $row["DiasBaseQuantidade"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="DiasBaseAmortizacaoID">Dia Base da Amortização</label>
							<div class="controls">		
								<select class="span3" name="DiasBaseAmortizacaoID" id="DiasBaseAmortizacaoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($diasbase)) foreach($diasbase as $row): ?>
											<?php 
												if (isset($row["DiasBaseID"])){
													 if (isset($AtivoDadoBasico["DiasBaseAmortizacaoID"]) && $row["DiasBaseID"] == $AtivoDadoBasico["DiasBaseAmortizacaoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["DiasBaseID"] ?>' ><?php echo $row["DiasBaseQuantidade"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="IntervaloRemuneracaoID">Intervalo Entre Remunerações</label>
							<div class="controls">		
								<select class="span3" name="IntervaloRemuneracaoID" id="IntervaloRemuneracaoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($intervalos)) foreach($intervalos as $row): ?>
											<?php 
												if (isset($row["IntervaloID"])){
													 if (isset($AtivoDadoBasico["IntervaloRemuneracaoID"]) && $row["IntervaloID"] == $AtivoDadoBasico["IntervaloRemuneracaoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["IntervaloID"] ?>' ><?php echo $row["IntervaloNome"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>


					<div class="control-group in-line">
						<label class="control-label" for="IntervaloAmortizacaoID">Intervalo Entre Amortizações</label>
							<div class="controls">		
								<select class="span3" name="IntervaloAmortizacaoID" id="IntervaloAmortizacaoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($intervalos)) foreach($intervalos as $row): ?>
											<?php 
												if (isset($row["IntervaloID"])){
													 if (isset($AtivoDadoBasico["IntervaloAmortizacaoID"]) && $row["IntervaloID"] == $AtivoDadoBasico["IntervaloAmortizacaoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["IntervaloID"] ?>' ><?php echo $row["IntervaloNome"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoJurosTipoID">Tipo de Juros</label>
							<div class="controls">		
								<select class="span3" name="AtivoJurosTipoID" id="AtivoJurosTipoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($jurostipos)) foreach($jurostipos as $row): ?>
											<?php 
												if (isset($row["AtivoJurosTipoID"])){
													 if (isset($AtivoDadoBasico["AtivoJurosTipoID"]) && $row["AtivoJurosTipoID"] == $AtivoDadoBasico["AtivoJurosTipoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["AtivoJurosTipoID"] ?>' ><?php echo $row["AtivoJurosTipoNome"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoAmortizacaoTipoID">Tipo de Amortização</label>
							<div class="controls">		
								<select class="span3" name="AtivoAmortizacaoTipoID" id="AtivoAmortizacaoTipoID">
									<option value="">Selecione</option>
										<?php $selected = ""; ?>
										<?php if (isset($amortizacaostipos)) foreach($amortizacaostipos as $row): ?>
											<?php 
												if (isset($row["AtivoAmortizacaoTipoID"])){
													 if (isset($AtivoDadoBasico["AtivoAmortizacaoTipoID"]) && $row["AtivoAmortizacaoTipoID"] == $AtivoDadoBasico["AtivoAmortizacaoTipoID"]) 
															$selected = "selected = 'selected'"; else $selected="";
												} 
											?>
											<option <?php echo $selected; ?> value='<?php echo $row["AtivoAmortizacaoTipoID"] ?>' ><?php echo $row["AtivoAmortizacaoTipoNome"]; ?> </option>
										<?php endforeach; ?>
								</select>		
							</div>
					</div>

				</div> <!-- Fim tabCalculos -->

				<!-- =========================================================== INICIO tabCalculos 			=========================================================== -->
				<div class="tab-pane fade in" id='tabGarantiasAtivo'>

					<div class="listaGarantias" >

						<?php 

						foreach($garantias as $row): ?>

							<div class="controls span4 inline">				
								
							<label class="checkbox">
								<input type="checkbox" <?php echo (in_array($row["GarantiaID"], $ativosGarantiasExistentes)) ? "checked='checked'" : ""; ?>
									name='<?php echo (isset($row["GarantiaID"])) ? $row["GarantiaID"] : ""; ?>'
									id='<?php echo (isset($row["GarantiaID"])) ? "GARANTIA_" . $row["GarantiaID"] : ""; ?>' >
								</input> 
								<?php echo (isset($row["GarantiaNome"])) ? $row["GarantiaNome"] : ""; ?> 
							</label>
							
						</div>

						<?php endforeach; ?>

					</div>

				</div> <!-- Fim tabGarantias -->

				<!-- =========================================================== INICIO tabJuros	 			=========================================================== -->
				<div class="tab-pane fade in" id='tabJuros'>

					<div class="listaJuros" >

						<div id="div_lista_ativos_juros">

							<table id="lista_ativos_juros" class="table table-striped table-temp-hover table-condensed">
								<thead>
									<tr>
										<th>Data Inicial de Vigência</th>
										<th>Data Final de Vigência</th>
										<th>Taxa Nominal</th>
										<th>Taxa Efetiva</th>										
									</tr>
								</thead>
								<tbody>

								<?php foreach($listajuros as $juros) { ?>
								<?php 

									$display_id 		  = htmlspecialchars($juros['JurosID'], ENT_QUOTES);
									$display_id_ativo	  = htmlspecialchars($juros['AtivoID'], ENT_QUOTES);
								?>
									<tr class="juros_<?php echo $display_id; ?>">
										<td><div class="data_inicial"><?php echo PPOEntity::toDateBr($juros['JurosDataInicialVigencia'], "d/m/Y"); ?></div></td>
										<td><div class="data_final"><?php echo PPOEntity::toDateBr($juros['JurosDataFinalVigencia'], "d/m/Y"); ?></div></td>
										<td><div class="taxa_nominal"><?php echo  "% ". PPOEntity::toMoneyBr($juros['JurosTaxaNominal'], 6) ; ?></div></td>
										<td><div class="taxa_efetiva"><?php echo  "% ". PPOEntity::toMoneyBr($juros['JurosTaxaEfetiva'], 6); ?></div></td>
									</tr>

								<?php }; ?>

								</tbody>
							</table>
						</div>

					</div>

				</div> <!-- Fim tabJuros -->

				<!-- =========================================================== INICIO tabIntegralizacoes			=========================================================== -->
				<div class="tab-pane fade in" id='tabSubscricoes'>

					<div class="listaSubscricoes" >

						<div id="div_lista_subscricoes">
							
							<table id="lista_subscricoes" class="table table-striped table-temp-hover table-condensed">
								<thead>
									<tr>						
										<th>Data da Subscrição</th>
										<th class="direita">Quantidade</th>
										<th class="direita">Valor Nominal Unitário</th>
										<th class="direita">Volume</th>
										<th>Ação</th>
									</tr>
								</thead>
								<tbody>

								<?php foreach($listasubscricoes as $subscricao) { ?>
								<?php 
									$display_id 			  = htmlspecialchars($subscricao['SubscricoesID'], ENT_QUOTES);
									$display_id_ativo	  	  = htmlspecialchars($subscricao['AtivoID'], ENT_QUOTES);
								?>
									<tr class="subscricao_<?php echo $display_id; ?>"
									    data-subscricaoid="<?php echo $display_id ?>"
									    data-ativoid="<?php echo $display_id_ativo ?>"
									>						
										<td><div class="datasubscricao"><?php echo PPOEntity::toDateBr($subscricao['SubscricoesData'], "d/m/Y"); ?></div></td>
										<td><div class="quantidade direita"><?php echo  PPOEntity::toMoneyBr($subscricao['SubscricoesQuantidade'], 8); ?></div></td>
										<td><div class="valorunitario direita "><?php echo  "R$ ". PPOEntity::toMoneyOitoCasasDecimais($subscricao['SubscricoesValorUnitario']); ?></div></td>
										<td><div class="volume direita"><?php echo  "R$ ". PPOEntity::toMoneyOitoCasasDecimais($subscricao['SubscricoesVolume']); ?></div></td>
										<td>
											<?php	
													if (user_has_access("CRI_ATIVOS_INTEGRALIZACAO"))echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;													
												?>
										</td>
									</tr>

								<?php }; ?>

								</tbody>
							</table>

						</div>

					</div>

				</div> <!-- Fim tabIntegralizacoes -->

				<!-- =========================================================== INICIO tabentidades 			=========================================================== -->
				<div class="tab-pane fade in" id='tabEntidadesAtivo'>

					<div class="listaEntidades" >

						<div id="div_lista_ativos_entidades">						

							<table id="lista_ativos_entidades" class="table table-striped table-temp-hover table-condensed">
								<thead>
									<tr>
										<th>CNPJ</th>
										<th>Nome</th>
										<th>Papel (Emissão)</th>										
									</tr>
								</thead>
								<tbody>

								<?php foreach($listaentidades as $entidades) { ?>
								<?php 

									$display_id 			  	= htmlspecialchars($entidades['AtivoEntidadeID'], ENT_QUOTES);
									$display_id_ativo	  		= htmlspecialchars($entidades['AtivoID'], ENT_QUOTES);
									$display_id_entidadeid	  	= htmlspecialchars($entidades['EntidadeID'], ENT_QUOTES);
									$display_id_entidadepapelid = htmlspecialchars($entidades['EntidadePapelID'], ENT_QUOTES);								
								?>
									<tr class="ativoentidade_<?php echo $display_id; ?>">
										<td><div class="entidadeCNPJ"><?php echo  $entidades['EntidadeCnpj']; ?></div></td>
										<td><div class="entidadenomefantasia"><?php echo  $entidades['EntidadeNomeFantasia']; ?></div></td>
										<td><div class="entidadepapelnome"><?php echo  $entidades['EntidadePapelNome']; ?></div></td>									
									</tr>

								<?php }; ?>

								</tbody>
							</table>

						</div>

					</div>

				</div> <!-- Fim tabentidades -->

					<!-- =========================================================== INICIO tabArquivos			=========================================================== -->
				<div class="tab-pane fade in" id='tabArquivos'>

					<div class="listaArquivos" >

						<table id="lista_arquivos_ativos" class="table table-temp-hover table-condensed">
							<thead>
								<tr>
							    	<th>Arquivo</th>
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
											<?php echo TAG_A_VISUALIZAR; ?>
									    </td>

									</tr>

								<?php endforeach; ?>

							</tbody>

						</table>

					</div>

				</div> <!-- Fim tabArquivos -->

			</div>	<!--Fim tabAtivos-->				
	
		</form>
	</div>
	<div class="modal-footer">
		<button id="btn_visualizarProposta" class="btn_visualizarProposta btn btn-primary" aria-hidden="true" type="button" >Ver Proposta</button>		
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Sair</button>
	</div>
</div>
