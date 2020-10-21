<script type="text/javascript">

	$(document).ready(function() {

		$('#dialog-manut-ativo-dados-basicos .input-append.date').each(function () {

			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  

		});

		maskMoedaBR(8);
		maskNumeroBR(8);
		maskPorcentagemBR(6);
		maskInteiro();

	});

	$("#dialog-manut-ativo-dados-basicos form").validate({
	  rules: {
	  	ModalidadeID: {required: true},
	  	AtivoSubtipoID: {required: true},
	  	AtivoCodigoSIOPM: {required: true, minlength: 7},
	  	AtivoTaxaRiscoNominal: { required: true},
	  	AtivoTaxaEstruturacaoNominal: {required: true},
	  	AtivoNumeroEmissao: {required: true, min:1},
	  	AtivoNumeroSerie: {required: true, min:1},
	  	AtivoDataEmissao: {required: true},
	  	AtivoDataVencimento: {required: true},
	  	AtivoLiquidacaoTipoID: {required: true},
	  	AtivoRegistroEsforcoRestrito: {required: true},
	  	AtivoRegistroDataCVM: {required: true},
	  },

	  messages: {
	  	ModalidadeID: {required: 'Campo obrigatório'},
	  	AtivoSubtipoID: {required: 'Campo obrigatório'},
	  	AtivoCodigoSIOPM: {required: 'Campo obrigatório',  minlength: 'Esse número possue 7 caracteres!',  },
	  	AtivoTaxaRiscoNominal: {required: 'Campo obrigatório'},
	  	AtivoTaxaEstruturacaoNominal: {required: 'Campo obrigatório'},
	  	AtivoNumeroEmissao: {required: 'Campo obrigatório', min:'Inserir uma quantidade válida'},
	  	AtivoNumeroSerie:{required: 'Campo obrigatório', min:'Inserir uma quantidade válida'},
	  	AtivoDataEmissao: {required: 'Campo obrigatório'},
	  	AtivoDataVencimento: {required: 'Campo obrigatório'},
	  	AtivoLiquidacaoTipoID: {required: 'Campo obrigatório'},
	  	AtivoRegistroEsforcoRestrito: {required: 'Campo obrigatório'},
	  	AtivoRegistroDataCVM: {required: 'Campo obrigatório'},
	  },

	  showErrors: function(errorMap, errorList) {
	    $.each(this.successList, function(index, value) {
	      return $(value).popover("hide");
	    });
	    return $.each(errorList, function(index, value) {
	      var _popover;
	      _popover = $(value.element).popover({
	        trigger: "manual",
	        placement: "top", 
	        content: value.message,
	        template: "<div  class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content alert-error\"><p></p></div></div></div>"
	      });
	      _popover.data("popover").options.content = value.message;
	      return $(value.element).popover("show");
	    });
	  }
	});

</script>

<style>

	#dialog-manut-ativo-dados-basicos {
		width: 1000px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	   /* margin-top: -60px!important;*/
	}

	#dialog-manut-ativo-dados-basicos .modal-body{
		padding-bottom: 30px;
		overflow: hidden;
		max-height: 510px;
		
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
	
	.date input {
		margin-bottom: 10px;
		width: 179px;
	}

</style>

<div id="dialog-manut-ativo-dados-basicos" class="modal">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"> <?php echo $tituloForm; ?> </h3>
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
				<li					><a href="#tabGarantias" 		data-toggle="tab">Garantias</a></li>
			</ul>

			<div id="tabAtivos" class="tab-content">

				<!-- =========================================================== INICIO tabDadosBasicos 			=========================================================== -->
				<div class="tab-pane active fade in" id='tabDadosBasicos'>

					<div class="control-group in-line">
						<label class="control-label"  for="ModalidadeID">Modalidade</label>
							<div class="controls">
								<select class="span3" disabled name="ModalidadeID" id="ModalidadeID">
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
								<input class="span3" maxlength="7" disabled type="text" id="AtivoCodigoSIOPM" name="AtivoCodigoSIOPM" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoSIOPM"])) ? $AtivoDadoBasico["AtivoCodigoSIOPM"] : ""; ?>' ></input>
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
								<input class="span3" maxlength="10" type="text" id="AtivoCodigoCetip" name="AtivoCodigoCetip" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoCetip"])) ? $AtivoDadoBasico["AtivoCodigoCetip"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoCodigoBmfBovespa">Código BM&amp;FBOVESPA</label>
							<div class="controls">
								<input class="span3" maxlength="10" type="text" id="AtivoCodigoBmfBovespa" name="AtivoCodigoBmfBovespa" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoBmfBovespa"])) ? $AtivoDadoBasico["AtivoCodigoBmfBovespa"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoCodigoIsin">Código ISIN</label>
							<div class="controls">
								<input class="span3" maxlength="12" type="text" id="AtivoCodigoIsin" name="AtivoCodigoIsin" value = '<?php echo (isset($AtivoDadoBasico["AtivoCodigoIsin"])) ? $AtivoDadoBasico["AtivoCodigoIsin"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoNumeroEmissao">Número da Emissão</label>
							<div class="controls">
								<input class="span3 inteiro" maxlength="10" type="text" id="AtivoNumeroEmissao" name="AtivoNumeroEmissao" value = '<?php echo (isset($AtivoDadoBasico["AtivoNumeroEmissao"])) ? $AtivoDadoBasico["AtivoNumeroEmissao"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoNumeroSerie">Número da Série</label>
							<div class="controls">
								<input class="span3 inteiro" maxlength="10" type="text" id="AtivoNumeroSerie" name="AtivoNumeroSerie" value='<?php echo (isset($AtivoDadoBasico["AtivoNumeroSerie"])) ? $AtivoDadoBasico["AtivoNumeroSerie"] : ""; ?>'></input>
							</div>
					</div>

					<div class="control-group in-line input-append date" id="AtivoDataEmissao" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataEmissao">Data da Emissão</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataEmissao" name="AtivoDataEmissao"  
							value = '<?php echo (isset($AtivoDadoBasico["AtivoDataEmissao"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoDataEmissao"], "d/m/Y") : ""; ?>'  /> 
							<span class="add-on"><i class="icon-th"></i></span>
					</div> 

					<div class="control-group in-line input-append date" id="AtivoDataVencimento" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataVencimento">Data do Vencimento</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataVencimento" name="AtivoDataVencimento"  
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
							<input class="span3 numero" maxlength="30" type="text" id="AtivoQuantidade" name="AtivoQuantidade" 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoQuantidade"])) ? $AtivoDadoBasico["AtivoQuantidade"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoValorNominalUnitario">Valor Unitário (Emissão)</label>
						<div class="controls">
							<input class="span3 moeda  maxlength="30" type="text" id="AtivoValorNominalUnitario" name="AtivoValorNominalUnitario" 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoValorNominalUnitario"])) ? $AtivoDadoBasico["AtivoValorNominalUnitario"]: ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line" >
						<label class="control-label" for="AtivoVolume">Volume (Emissão)</label>
						<div class="controls">
							<input class="span3 moeda  maxlength="30" type="text" id="AtivoVolume" name="AtivoVolume"
							 value='<?php echo (isset($AtivoDadoBasico["AtivoVolume"])) ? $AtivoDadoBasico["AtivoVolume"] : ""; ?>'></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoTaxaRiscoNominal">Taxa de Risco Nominal</label>
							<div class="controls">
								<input class="span3 porcentagem" maxlength="20" type="text" id="AtivoTaxaRiscoNominal" name="AtivoTaxaRiscoNominal" value = '<?php echo (isset($AtivoDadoBasico["AtivoTaxaRiscoNominal"])) ? $AtivoDadoBasico["AtivoTaxaRiscoNominal"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AtivoTaxaEstruturacaoNominal">Taxa de Estruturação Nominal</label>
							<div class="controls">
								<input class="span3 porcentagem" maxlength="20" type="text" id="AtivoTaxaEstruturacaoNominal" name="AtivoTaxaEstruturacaoNominal"
								 value = '<?php echo (isset($AtivoDadoBasico["AtivoTaxaEstruturacaoNominal"])) ? $AtivoDadoBasico["AtivoTaxaEstruturacaoNominal"] : ""; ?>' ></input>
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
								<select class="span3" name="AtivoLiquidacaoTipoID" id="AtivoLiquidacaoTipo">
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
								<input class="span3" type="text" maxlength="50" id="AtivoRegistroCVM" name="AtivoRegistroCVM" value = '<?php echo (isset($AtivoDadoBasico["AtivoRegistroCVM"])) ? $AtivoDadoBasico["AtivoRegistroCVM"] : ""; ?>' ></input>
							</div>
					</div>

					<div class="control-group in-line input-append date" id="AtivoRegistroDataCVM" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoRegistroDataCVM">Data de Registro</label>
								<input  style='width: 178px;' maxlength="16" type="text" id="AtivoRegistroDataCVM" name="AtivoRegistroDataCVM" readonly 
								value = '<?php echo (isset($AtivoDadoBasico["AtivoRegistroDataCVM"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoRegistroDataCVM"], "d/m/Y") : ""; ?>'  /> 
							<span class="add-on"><i class="icon-th"></i></span>
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
							<span  class="add-on"><i class="icon-th"></i></span>
					</div> 

					<div class="control-group in-line input-append date" id="AtivoDataPrimeiraAmortizacao" data-date="" data-date-format="dd/mm/yyyy">
							<label for="AtivoDataPrimeiraAmortizacao">Data da 1ª Amortização</label>
							<input  style='width: 178px;' maxlength="16" type="text" id="AtivoDataPrimeiraAmortizacao" name="AtivoDataPrimeiraAmortizacao" readonly 
							value = '<?php echo (isset($AtivoDadoBasico["AtivoDataPrimeiraAmortizacao"])) ?  PPOEntity::toDateBr($AtivoDadoBasico["AtivoDataPrimeiraAmortizacao"], "d/m/Y") : ""; ?>'  /> 
							<span class="add-on"><i class="icon-th"></i></span>
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
						<label class="control-label" for="IntervaloRemuneracaoID">Intervalo entre Remunerações</label>
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
						<label class="control-label" for="IntervaloAmortizacaoID">Intervalo entre Amortizações</label>
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

				<!-- =========================================================== INICIO tabGarantias			=========================================================== -->
				<div class="tab-pane fade in" id='tabGarantias'>

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

			</div>	<!--Fim tabAtivos-->

		</form>
	</div>
	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>

<?php $siopm->includeJS("views", "ativos.dados.basicos.js"); ?>
