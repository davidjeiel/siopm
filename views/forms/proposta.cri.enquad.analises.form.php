
<style type="text/css">
	
	.tab-content{
		overflow:hidden;
	}

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-enquad-analises {
		/*margin-top: -65px;*/
		width: 985px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -480px;
	}

	#dialog-enquad-analises .control-label {
		margin-right: 20px;
	}

	#dialog-enquad-analises .modal-body{
		overflow: hidden;
		max-height: 900px;
	}

	#dialog-enquad-analises.tab-content, #dialog-enquad-analises.tab-pane{
		overflow: hidden;
	}

	#dialog-enquad-analises .input-append.date input{
		background:#FFF;
	}

	#dialog-enquad-analises input{
		padding-right: 8px;
	}

	#dialog-enquad-analises .date{
		margin-top: -25px;
	}
	
	#dialog-enquad-analises .popover{
		opacity: 1!important;
		-moz-opacity: 1!important;
		filter: alpha(opacity=100)!important;
	}

	#dialog-enquad-analises H5{
		margin-top: 0px;
	}

</style>


<script type="text/javascript">

	$(document).ready(function() {

		var valorMaximo =  $("#PropostaFaixaVlrMax").val();
		var valorMinimo =  $("#PropostaFaixaVlrMin").val();
		var jurosMaximo =  $("#JurosMaximoPermitido").val();
		var prazoMaximo =  $("#PrazoMaximoPermitido").val();
		
		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  

		});

		maskFormBr(2,8);

		$("#ValorMaximo").popover({
			trigger: "focus",
			title: "ATENÇÃO!",
			placement : 'top',
			delay: 0,
			template: "<div  class=\"popover\"><div class=\"arrow\"></div><b><h3 class='popover-title alert-error'></h3></b>" + 
				"<div class=\"popover-inner\">" + 
				"<div class=\"popover-content alert-error\">" + 
				"<b> MÍN:  </b> R$ " + valorMinimo + " <br /> <b> MÁX: </b> R$ " + valorMaximo + 
				"</div></div></div>"
		});


		$("#ValorMinimo").popover({
			trigger: "focus",
			title: "ATENÇÃO!",
			placement : 'top',
			delay: 0,
			template: "<div  class=\"popover\"><div class=\"arrow\"></div><b><h3 class='popover-title alert-error'></h3></b>" + 
				"<div class=\"popover-inner\">" + 
				"<div class=\"popover-content alert-error\">" + 
				"<b> MÍN:  </b> R$ " + valorMinimo + " <br /> <b> MÁX: </b> R$ " + valorMaximo + 
				"</div></div></div>"
		});

		$("#TxJurosMaxima").popover({
			trigger: "focus",
			title: "ATENÇÃO!",
			placement : 'top',
			delay: 0,
			template: "<div  class=\"popover\"><div class=\"arrow\"></div><b><h3 class='popover-title alert-error'></h3></b>" + 
				"<div class=\"popover-inner\">" + 
				"<div class=\"popover-content alert-error\">" + 
				"<b> MÁX:  </b> % " + jurosMaximo + "</div></div></div>"
		});

		$("#PrazoMaximo").popover({
			trigger: "focus",
			title: "ATENÇÃO!",
			placement : 'top',
			delay: 0,
			template: "<div  class=\"popover\"><div class=\"arrow\"></div><b><h3 class='popover-title alert-error'></h3></b>" + 
				"<div class=\"popover-inner\">" + 
				"<div class=\"popover-content alert-error\">" + 
				"<b> MÁX:  </b> " + prazoMaximo + " Meses </div></div></div>"
		});

		
	});

	function selectRating(e){
		$("#PropTaxaNominal").val($(e).find(":selected").data("taxa"));
		$(".campo-formatado").unmask();
		maskFormBr(2,8);
	}

</script>

<div id="dialog-enquad-analises" class = 'modal hide fade in'>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>
	<div class="modal-body">
		<form id="formEnquadramentoAnalises" name="formEnquadramentoAnalises" >

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaFaseID" name="PropostaFaseID" 
				value = '<?php echo (isset($proposta["PropostaFaseID"])) ? $proposta["PropostaFaseID"] : "$fase"; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>

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
	
				$show_analise_risco = "";

				if ($fase == 1){
					$show_analise_risco = "hide";
				}
			?>

			<ul class="nav nav-tabs" id="navPropostas">

				<li	 class="active"	><a href="#tabAspectosCadSecuritizadoera" 	data-toggle="tab">Aspectos Cadastrais da Securitizadora</a></li>
				<li					><a href="#tabEnquadramento" 				data-toggle="tab">Enquadramento</a></li>
				<li 				><a href="#tabAnaliseJuridica"				data-toggle="tab">Análise Jurídica</a></li>
				<li  class= "<?php echo $show_analise_risco; ?>" ><a href="#tabAnaliseRisco" data-toggle="tab">Análise de Risco</a></li>
				
			</ul>

			<div id="tabPropostas" class="tab-content">

				<!-- =========================================================== INICIO tabAspectosCadSecuritizadoera  =========================================================== -->
				<div class="tab-pane active fade in" id='tabAspectosCadSecuritizadoera'>

					<input  type="hidden" id="PropPesqSecurID" name="PropPesqSecurID" 
					value = '<?php echo (isset($propPesqSecur["PropPesqSecurID"])) ? $propPesqSecur["PropPesqSecurID"] : ""; ?>' ></input>

					<div class="control-group in-line">
						<label class="control-label" for="CRFRegular">CRF</label>
						<div class="control">
							<select class="span3" name="CRFRegular" id="CRFRegular">
								<option value="">Selecione</option>
								<option <?php if (isset($propPesqSecur["CRFRegular"]) && $propPesqSecur["CRFRegular"] == 1) echo "selected = 'selected'" ?> 
									value="1" >Regular</option>
								<option <?php if (isset($propPesqSecur["CRFRegular"]) && $propPesqSecur["CRFRegular"] == 2) echo "selected = 'selected'" ?> 
									value="2" >Irregular</option>
							</select>
						</div>
					</div>

					<div class="control-group in-line input-append date" id="dpValidadeCRF" 
						data-date="" data-date-format="dd/mm/yyyy" >
						<label class="control-label" for="CRFValidade">Validade CRF</label>
						<div class="controls">
							<input style="width:180px;" maxlength="16" class="gravar span3" type="text" readonly style="width:100px;"
								id="CRFValidade" 
								name="CRFValidade" 
								value = '<?php echo (isset($propPesqSecur["CRFValidade"])) ? 
														PPOEntity::toDateBr($propPesqSecur["CRFValidade"], "d/m/Y") : ""; ?>' >
							</input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="CADINRegular">CADIN</label>
						<div class="control">
							<select class="span3" name="CADINRegular" id="CADINRegular">

								<option value="">Selecione</option>
								<option <?php if (isset($propPesqSecur["CADINRegular"]) && $propPesqSecur["CADINRegular"] == 1) echo "selected = 'selected'" ?> 
									value="1" >Regular</option>
								<option <?php if (isset($propPesqSecur["CADINRegular"]) && $propPesqSecur["CADINRegular"] == 2) echo "selected = 'selected'" ?> 
									value="2" >Irregular</option>
							</select>
						</div>
					</div>

					<div class="control-group in-line input-append date" id="dpCADINDataPesquisa" 
						data-date="" data-date-format="dd/mm/yyyy" >
						<label class="control-label" for="CADINDataPesquisa">Data da Pesquisa (CADIN)</label>
						<div class="controls">
							<input style="width:180px;" maxlength="16" class="gravar span3" type="text" readonly style="width:100px;"
								id="CADINDataPesquisa" 
								name="CADINDataPesquisa" 
								value = '<?php echo (isset($propPesqSecur["CADINDataPesquisa"])) ? 
										PPOEntity::toDateBr($propPesqSecur["CADINDataPesquisa"], "d/m/Y") : ""; ?>' >
							</input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

				</div> <!-- Fim tabAspectosCadSecuritizadoera -->

				<!-- =========================================================== INICIO tabEnquadramento 		=========================================================== -->
				<div class="tab-pane fade " id='tabEnquadramento'>

					<input type="hidden" id="PropostaEnquadramentoID" name="PropostaEnquadramentoID" 	
							value = '<?php echo (isset($propEnquad["PropostaEnquadramentoID"])) ? $propEnquad["PropostaEnquadramentoID"] : ""; ?>' ></input>

					<input class="span2 campo-formatado moeda" readonly type="hidden" id="PropostaFaixaVlrMin" name="PropostaFaixaVlrMin" 
							value = '<?php echo (isset($proposta["PropostaFaixaVlrMin"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaVlrMin"]) : ""; ?>' ></input>

					<input class="span2 campo-formatado moeda" readonly type="hidden" id="PropostaFaixaVlrMax" name="PropostaFaixaVlrMax" 
							value = '<?php echo (isset($proposta["PropostaFaixaVlrMax"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaVlrMax"]) : ""; ?>' ></input>
	
					<input class="span2 campo-formatado porcentagem" readonly type="hidden" id="PropostaFaixaTaxaJurosNominal" name="PropostaFaixaTaxaJurosNominal" 
							value = '<?php echo (isset($proposta["PropostaFaixaTaxaJurosNominal"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaTaxaJurosNominal"], 4) : ""; ?>' ></input>

					<input class="span2 campo-formatado porcentagem" readonly type="hidden" id="PropostaFaixaTaxaJurosEfetiva" name="PropostaFaixaTaxaJurosEfetiva" 
							value = '<?php echo (isset($proposta["PropostaFaixaTaxaJurosEfetiva"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaTaxaJurosEfetiva"], 4) : ""; ?>' ></input>


					<input readonly type="hidden" id="JurosMaximoPermitido" name="JurosMaximoPermitido" 
							value = '<?php echo (isset($propConfig["JurosMaximoPermitido"])) ? PPOEntity::toMoneyBr($propConfig["JurosMaximoPermitido"], 4) : ""; ?>' ></input>

					<input readonly type="hidden" id="PrazoMaximoPermitido" name="PrazoMaximoPermitido" 
							value = '<?php echo (isset($propConfig["PrazoMaximoPermitido"])) ? $propConfig["PrazoMaximoPermitido"] : ""; ?>' ></input>

					<h5> Valores Atuais dos Imóveis </h5>

					<div class="control-group in-line">
						<label class="control-label" for="ValorMaximo">Valor Máximo</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="14" type="text" id="ValorMaximo" name="ValorMaximo" maxlength="13"
								value = '<?php echo (isset($propEnquad["ValorMaximo"])) ? PPOEntity::toMoneyBr($propEnquad["ValorMaximo"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ValorMinimo">Valor Mínimo</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="14" type="text" id="ValorMinimo" name="ValorMinimo" maxlength="13"
								value = '<?php echo (isset($propEnquad["ValorMinimo"])) ? PPOEntity::toMoneyBr($propEnquad["ValorMinimo"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ValorMedio">Valor Médio</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="14" type="text" id="ValorMedio" name="ValorMedio" maxlength="13"
								value = '<?php echo (isset($propEnquad["ValorMedio"])) ? PPOEntity::toMoneyBr($propEnquad["ValorMedio"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ValorTotal">Valor Total</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="20" type="text" id="ValorTotal" name="ValorTotal" maxlength="13"
								value = '<?php echo (isset($propEnquad["ValorTotal"])) ? PPOEntity::toMoneyBr($propEnquad["ValorTotal"]) : ""; ?>' ></input>
						</div>
					</div>

					<h5> Taxa de Juros </h5>

					<div class="control-group in-line">
						<label class="control-label" for="TxJurosMaxima">Taxa de Juros Máxima</label>
						<div class="controls">
							<input class="span3 campo-formatado porcentagem" type="text" id="TxJurosMaxima" name="TxJurosMaxima" maxlength="13" 
								value = '<?php echo (isset($propEnquad["TxJurosMaxima"])) ? PPOEntity::toMoneyBr($propEnquad["TxJurosMaxima"], 8) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="TxJurosMinima">Taxa de Juros Mínima</label>
						<div class="controls">
							<input class="span3 campo-formatado porcentagem" type="text" id="TxJurosMinima" name="TxJurosMinima" maxlength="13"
								value = '<?php echo (isset($propEnquad["TxJurosMinima"])) ? PPOEntity::toMoneyBr($propEnquad["TxJurosMinima"], 8) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="TxJurosMedia">Taxa de Juros Média</label>
						<div class="controls">
							<input class="span3 campo-formatado porcentagem" type="text" id="TxJurosMedia" name="TxJurosMedia" maxlength="13"
								value = '<?php echo (isset($propEnquad["TxJurosMedia"])) ? PPOEntity::toMoneyBr($propEnquad["TxJurosMedia"], 8) : ""; ?>' ></input>
						</div>
					</div>

					<h5> Prazo dos Financiamentos </h5>

					<div class="control-group in-line">
						<label class="control-label" for="PrazoMaximo">Prazo Máximo</label>
						<div class="controls">
							<input class="span3 campo-formatado inteiro" maxlength="4" type="text" id="PrazoMaximo" name="PrazoMaximo" 
								value = '<?php echo (isset($propEnquad["PrazoMaximo"])) ? $propEnquad["PrazoMaximo"] : ""; ?>' ></input>
							<span class="help-inline">(Meses)</span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PrazoMinimo">Prazo Mínimo</label>
						<div class="controls">
							<input class="span3 campo-formatado inteiro" maxlength="4" type="text" id="PrazoMinimo" name="PrazoMinimo" 
								value = '<?php echo (isset($propEnquad["PrazoMinimo"])) ? $propEnquad["PrazoMinimo"] : ""; ?>' ></input>
							<span class="help-inline">(Meses)</span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PrazoMedio">Prazo Médio</label>
						<div class="controls">
							<input class="span3 campo-formatado inteiro" maxlength="4" type="text" id="PrazoMedio" name="PrazoMedio" 
								value = '<?php echo (isset($propEnquad["PrazoMedio"])) ? $propEnquad["PrazoMedio"] : ""; ?>' ></input>
							<span class="help-inline">(Meses)</span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="Observacoes">Observações</label>
						<div class="controls">
							<textarea class="span12" type="text" id="Observacoes" maxlength="1000" name="Observacoes"><?php echo (isset($propEnquad["Observacoes"])) ? $propEnquad["Observacoes"] : ""; ?></textarea>
						</div>
					</div>

				</div> <!-- Fim tabEnquadramento -->

				<!-- =========================================================== INICIO tabAnaliseJuridica =========================================================== -->
				<div class="tab-pane" id='tabAnaliseJuridica'>

					<input type="hidden" id="PropJuridicaID" name="PropJuridicaID" 
						value = '<?php echo (isset($analiseJur["PropJuridicaID"])) ? $analiseJur["PropJuridicaID"] : ""; ?>' ></input>

					<div class="control-group in-line">
						<label class="control-label" for="PropJuridicaNumParecer">Número do Parecer</label>
						<div class="controls">
							<input class="span3" type="text" maxlength="10" id="PropJuridicaNumParecer" name="PropJuridicaNumParecer" 
							value = '<?php echo (isset($analiseJur["PropJuridicaNumParecer"])) ? $analiseJur["PropJuridicaNumParecer"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group input-append date in-line" id="dpPropJuridicaData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="PropJuridicaData">Data</label>
						<div class="controls">
							<input style="width:180px;" maxlength="16" class="gravar" readonly="readonly" type="text" id="PropJuridicaData" 
								name="PropJuridicaData" value = '<?php echo (isset($analiseJur["PropJuridicaData"])) ? 
								PPOEntity::toDateBr($analiseJur["PropJuridicaData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="span3" name="PropJuridicaConclusaoID" id="PropJuridicaConclusaoID" >
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($conclusoes)) foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($analiseJur["PropJuridicaConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($analiseJur["PropJuridicaConclusaoID"]))
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
						<label class="control-label" for="PropJuridicaObs">Observações</label>
						<div class="controls">
							<textarea class="span12" class="gravar" maxlength="1000" type="text" id="PropJuridicaObs" name="PropJuridicaObs" ><?php echo (isset($analiseJur["PropJuridicaObs"])) ? $analiseJur["PropJuridicaObs"] : ""; ?></textarea>
						</div>
					</div>

					<?php 

					$area_up_jur 	= "hide";
					$area_down 		= "";
					$area_up 		= "";

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da Análise Jurídica.
					*/
					if (isset($analiseJur["PropJuridicaID"]) && $analiseJur["PropJuridicaID"] > 0) {
						$area_up_jur = "";
					}

					/* 
					* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
					* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
					* Caso contrário permite o upload de um novo.
					*/
					if (isset($analiseJur["PropJuridicaArquivoID"]) && (int)$analiseJur["PropJuridicaArquivoID"] > 0) { 
						$area_up = "hide";
					} else {
						$area_down = "hide";
					}

					?>	

					<!-- Container do controle de UPLOAD de arquivo para a análise jurídica -->
					<div id = "prop_jur_view_files_up" class="<?php echo $area_up_jur ?>">
						
						<div id="PropJuridicaArquivoUploader" style="position: relative;" class="controls">

							<input type="hidden" id="PropJuridicaArquivoID" name="PropJuridicaArquivoID" 
								value = '<?php echo (isset($analiseJur["PropJuridicaArquivoID"])) ? $analiseJur["PropJuridicaArquivoID"] : ""; ?>' ></input>

							<label class="control-label" for="PropJuridicaArquivoNome">Arquivo: &nbsp;
								<span class='area-view-files <?php echo $area_down; ?>' > 
									<a id="PropJuridicaArquivoNome" href='#' class='up-file-name'>
										<?php echo (isset($analiseJur["PropJuridicaArquivoNome"])) ? $analiseJur["PropJuridicaArquivoNome"] : ""; ?></a>
									<a id="del_PropJuridicaArquivo" name="del_PropJuridicaArquivo"  href="#" 
										class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
								</span>
							</label>
						
							<div class='area-up-files <?php echo $area_up; ?>' > 
								
								<div class="control-group up-list" id="listFilesPropJuridicaArquivo" name="listFilesPropJuridicaArquivo"></div>
								
								<div class="control-group in-line">
									<button id="add_PropJuridicaArquivo" class="btn up-add" type="button">
										<i class="icon-plus"></i>
										<span>Selecionar Arquivo</span>
									</button>
								</div>
								
								<div class="control-group in-line">
									<button id="up_PropJuridicaArquivo" class="btn btn-primary up-upload" type="button">
										<i class="icon-arrow-up icon-white"></i>
										<span>Upload</span>
									</button>
								</div>

							</div>

						</div>

					</div><!-- Fim do CONTAINER do upload de arquivo -->

				</div> <!-- Fim tabAnaliseJuridica -->

				<!-- =========================================================== INICIO tabAnaliseRisco 		=========================================================== -->
				<div class="tab-pane fade " id='tabAnaliseRisco'>
					
					<input  type="hidden" id="PropRiscoID" name="PropRiscoID" 
						value = '<?php echo (isset($analiseRisco["PropRiscoID"])) ? $analiseRisco["PropRiscoID"] : ""; ?>' ></input>

					<div class="control-group in-line">
						<label class="control-label" for="PropRiscoNumParecer">Número do Parecer</label>
						<div class="controls">
							<input class="span3 gravar" maxlength="10" type="text" id="PropRiscoNumParecer" name="PropRiscoNumParecer" 
								value = '<?php echo (isset($analiseRisco["PropRiscoNumParecer"])) ? $analiseRisco["PropRiscoNumParecer"] : ""; ?>' ></input>
						</div>
					</div>

					<div class='clear'>&nbsp;</div>

					<div class="control-group input-append date in-line" id="dpPropRiscoData" data-date="" data-date-format="dd/mm/yyyy">
						<label class="control-label" for="PropRiscoData">Data</label>
						<div class="controls">
							<input style="width:180px;" maxlength="16" class="gravar" readonly="readonly" type="text" id="PropRiscoData" 
								name="PropRiscoData" value = '<?php echo (isset($analiseRisco["PropRiscoData"])) ? 
								PPOEntity::toDateBr($analiseRisco["PropRiscoData"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="span3" name="PropRiscoConclusaoID" id="PropRiscoConclusaoID">
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($conclusoes)) foreach($conclusoes as $row): ?>
									<?php 
										if (isset($row["ConclusaoID"]) and isset($analiseRisco["PropRiscoConclusaoID"])){
											 if (trim($row["ConclusaoID"]) == trim($analiseRisco["PropRiscoConclusaoID"]))
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
						<label class="control-label">Rating</label>
						<div class="control">
							<select class="span3" name="PropRiscoRating" id="PropRiscoRating" onChange="selectRating(this);">
								<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($rating)) foreach($rating as $row): ?>
									<?php 
										if (isset($row["PropRiscoRatingID"]) and isset($analiseRisco["PropRiscoRating"])){
											 if (trim($row["PropRiscoRatingID"]) == trim($analiseRisco["PropRiscoRating"]))
													$selected = "selected = 'selected'"; else $selected=" ";
										} 
									?>
									<option 
										data-taxa = '<?php echo PPOEntity::toMoneyBr($row["PropRiscoRatingTaxaRisco"], 8); ?>' 
										<?php echo $selected; ?> value='<?php echo $row["PropRiscoRatingID"] ?>' >
										<?php echo $row["PropRiscoRatingID"]?> 
									</option>
								<?php endforeach; ?>
							</select>
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
							<textarea class="span12" class="gravar" maxlength="1000" type="text" id="PropRiscoObs" name="PropRiscoObs" ><?php echo (isset($analiseRisco["PropRiscoObs"])) ? $analiseRisco["PropRiscoObs"] : ""; ?></textarea>
						</div>
					</div>

					<?php 

					$area_up_risco 	= "hide";
					$area_down 		= "";
					$area_up 		= "";

					/*
					*	Controla a possibilidade de Upload de arquivo. Permite apenas de existe o ID da Análise Jurídica.
					*/
					if (isset($analiseRisco["PropRiscoID"]) && $analiseRisco["PropRiscoID"] > 0) {
						$area_up_risco = "";
					}

					/* 
					* Controla a visualização da area de upload de arquivo ou visualização de arquivo.
					* Caso já exista um arquivo no banco, mostra-o para visualização ou exlusão. 
					* Caso contrário permite o upload de um novo.
					*/
					if (isset($analiseRisco["PropRiscoArquivoID"]) && (int)$analiseRisco["PropRiscoArquivoID"] > 0) { 
						$area_up = "hide";
					} else {
						$area_down = "hide";
					}

					?>	

					<!-- Container do controle de UPLOAD de arquivo para a análise de risco -->
					<div id = "prop_risco_view_files_up" class="<?php echo $area_up_risco ?>">		
						
						<div id="PropRiscoArquivoUploader" style="position: relative;" class="controls">

							<input type="hidden" id="PropRiscoArquivoID" name="PropRiscoArquivoID" 
								value = '<?php echo (isset($analiseRisco["PropRiscoArquivoID"])) ? $analiseRisco["PropRiscoArquivoID"] : ""; ?>' ></input>

							<label class="control-label" for="PropRiscoArquivoNome">Arquivo: &nbsp;
								<span class='area-view-files <?php echo $area_down; ?>' > 
									<a id="PropRiscoArquivoNome" href='#' class='up-file-name'>
										<?php echo (isset($analiseRisco["PropRiscoArquivoNome"])) ? $analiseRisco["PropRiscoArquivoNome"] : ""; ?></a>
									<a id="del_PropRiscoArquivo" name="del_PropRiscoArquivo"  href="#" 
										class="btn btn-danger up-del btn-mini "><i class="icon-trash icon-white"></i><span></span></a>
								</span>
							</label>
						
							<div class='area-up-files <?php echo $area_up; ?>' > 
								
								<div class="control-group up-list" id="listFilesPropRiscoArquivo" name="listFilesPropRiscoArquivo"></div>
								
								<div class="control-group in-line">
									<button id="add_PropRiscoArquivo" class="btn up-add" type="button">
										<i class="icon-plus"></i>
										<span>Selecionar Arquivo</span>
									</button>
								</div>
								
								<div class="control-group in-line">
									<button id="up_PropRiscoArquivo" class="btn btn-primary up-upload" type="button">
										<i class="icon-arrow-up icon-white"></i>
										<span>Upload</span>
									</button>
								</div>

							</div>

						</div>

					</div><!-- Fim do CONTAINER do upload de arquivo -->

				</div> <!-- Fim tabAnaliseRisco -->

			</div> <!-- Fim TAB CONTENT -->

		</form>
	</div>
	<div class="modal-footer">
		<button id="btn_salvar" class="btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>

<?php 
	
	$siopm->includeJS("views", "propostas.file.risco.js"); 
	$siopm->includeJS("views", "propostas.file.juridica.js"); 

?>
