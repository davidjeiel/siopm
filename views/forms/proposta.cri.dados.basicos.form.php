<style type="text/css">

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-dados-basicos {
		width: 985px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -490px;
	}

	#dialog-dados-basicos .control-label {
		margin-right: 20px;
	}

	#dialog-dados-basicos .modal-body{	
		overflow: hidden;
	}

	#dialog-dados-basicos .input-append.date input{
		background:#FFF;
	}

	#dialog-dados-basicos input{
		padding-right: 8px;
	}

	#dialog-dados-basicos .add-on{
		margin-bottom: 25px;
	}

</style>

<script type="text/javascript">

	$(document).ready(function() {

		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true,  "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  
		});

		maskFormBr(2,5);

	});

	function selecionaDadosSecuritizadora(e){
		$("#SecuritizadoraRating").val($(e).find(":selected").data("rating"));
		$("#SecuritizadoraStatus").val($(e).find(":selected").data("status"));
		$("#SecuritizadoraValidade").val($(e).find(":selected").data("validade"));
	}

	function selecionaDadosAgenteFiduciario(e){
		$("#AgenteFiduciarioRating").val($(e).find(":selected").data("rating"));
		$("#AgenteFiduciarioStatus").val($(e).find(":selected").data("status"));
		$("#AgenteFiduciarioValidade").val($(e).find(":selected").data("validade"));
	}

	function selectFaixa(e){

		$("#PropostaFaixaVlrMin").val($(e).find(":selected").data("valorminimo"));
		$("#PropostaFaixaVlrMax").val($(e).find(":selected").data("valormaximo"));
		$("#PropostaFaixaTaxaJurosNominal").val($(e).find(":selected").data("taxanominal"));
		$("#PropostaFaixaTaxaJurosEfetiva").val($(e).find(":selected").data("taxaefetiva"));

		$(".campo-formatado").unmask();

	}

	$("#dialog-dados-basicos form").validate({
		rules: {
			ProgramaID: {required: true},
			OrcamentoID: {required: true},
			DataRecepcao: {required: true},
			UnidadeID: {required: true},
			SecuritizadoraID: {required: true},
			PropostaFaixaID: {required: true},
			ValorCRISenior: {required: true},
			AgenteFiduciarioID: {required: true},
			OriginadorID: {required: true},
			CoordenadorLiderID: {required: true},
			PropEmpreendTipoID: {required: true},
			PrazoAmortizacao:{required: true}
		},
		messages: { 
			ProgramaID: { required: 'Campo obrigatório'},
			OrcamentoID: { required: 'Campo obrigatório'},
			DataRecepcao: {required: 'Campo obrigatório'},
			UnidadeID: { required: 'Campo obrigatório'},
			SecuritizadoraID: { required: 'Campo obrigatório'},
			PropostaFaixaID: { required: 'Campo obrigatório'},
			ValorCRISenior: { required: 'Campo obrigatório'},
			AgenteFiduciarioID: { required: 'Campo obrigatório'},
			OriginadorID: { required: 'Campo obrigatório'},
			CoordenadorLiderID: {required: 'Campo obrigatório'},
			PropEmpreendTipoID: { required: 'Campo obrigatório'},
			PrazoAmortizacao: { required: 'Campo obrigatório'}
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

<div id="dialog-dados-basicos" class = 'modal  fade in'>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>
	<div class="modal-body">

		<form id="formPropostaDadosBasicos" name="formPropostaDadosBasicos" >
			
			<input type="hidden" id="UnidadeUsuario" name="UnidadeUsuario" value = '<?php echo $user->getUnidadeID(); ?>' ></input>

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="DataFinalizacao" name="DataFinalizacao" 
				value = '<?php echo (isset($proposta["DataFinalizacao"])) ? $proposta["DataFinalizacao"] : ""; ?>' ></input>
			
			<input type="hidden" id="PropostaFaseID" name="PropostaFaseID" 
				value = '<?php echo (isset($proposta["PropostaFaseID"])) ? $proposta["PropostaFaseID"] : "$fase"; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>

			<input type="hidden" id="PropDetStatusID" name="PropDetStatusID" 
				value = '<?php echo (isset($proposta["PropDetStatusID"])) ? $proposta["PropDetStatusID"] : "1"; ?>' ></input>
	
			<input type="hidden" id="PropostaAtiva" name="PropostaAtiva" 
				value = '<?php echo (isset($proposta["PropostaAtiva"])) ? $proposta["PropostaAtiva"] : "1"; ?>' ></input>
		
			<ul class="nav nav-tabs" id="navPropostas">
				<li class="active"	><a href="#tabCadProp" 	 		data-toggle="tab">Cadastramento de Proposta</a></li>
				<li					><a href="#tabEntidades" 		data-toggle="tab">Entidades Envolvidas na Operação</a></li>
				<li					><a href="#tabCaracteristicas" 	data-toggle="tab">Características Gerais da Carteira</a></li>
				<li					><a href="#tabCondBasicas" 		data-toggle="tab">Condições Básicas da Operação</a></li>
			</ul>

			<div id="tabPropostas" class="tab-content">

				<!-- =========================================================== INICIO tabCadProp 			=========================================================== -->

				<div class="tab-pane active fade in" id='tabCadProp'>

					<div class="control-group in-line">
						<label class="control-label">Programa</label>
						<div class="control">
							<select class="span6" name="ProgramaID" id="ProgramaID" <?php if ($fase == 2) echo "disabled"; ?> >
				
								<?php $selected = ""; ?>
								<?php if (isset($programas)) foreach($programas as $row): ?>
									<?php 
										if (isset($row["ProgramaID"])){
											 if (isset($proposta["ProgramaID"]) && $row["ProgramaID"] == $proposta["ProgramaID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["ProgramaID"] ?>' ><?php echo $row["ProgramaNome"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropostaNumero">Número</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="PropostaNumero" name="PropostaNumero" value = '<?php echo (isset($proposta["PropostaNumero"])) ? $proposta["PropostaNumero"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line input-append date" id="dpDataRecepcao" 
						data-date="" data-date-format="dd/mm/yyyy" >
						<label class="control-label" for="DataRecepcao">Data da Recepção</label>
						<div class="controls">
							<input  maxlength="10" class="gravar span2" type="text" readonly style='width:100px;' 
								id="DataRecepcao" 
								name="DataRecepcao" 
								value = '<?php echo (isset($proposta["DataRecepcao"])) ? 
										PPOEntity::toDateBr($proposta["DataRecepcao"], 
										"d/m/Y") : ""; ?>' >
							</input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">GIFUG</label>
						<div class="control">
							<select class="span2" name="UnidadeID" id="UnidadeID">
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($unidades)) foreach($unidades as $row): ?>
									<?php 
										
										if (isset($row["UnidadeID"])){

											if (isset($proposta["PropostaID"]) && $proposta["PropostaID"] > 0){ 
												if (isset($proposta["UnidadeID"]) && $row["UnidadeID"] == $proposta["UnidadeID"]) 
													$selected = "selected = 'selected'"; 				
												else $selected="";
											}else{
												if ($row["UnidadeID"] == $user->getUnidadeID()) 
													$selected = "selected = 'selected'"; 				
												else $selected="";
											}

										} 
									
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["UnidadeID"] ?>' ><?php echo $row["UnidadeSigla"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Ano Orçamentário</label>
						<div class="control">
							<select class="span4" name="OrcamentoID" id="OrcamentoID" <?php if ($fase == 2) echo "disabled"; ?>>
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($orcamentos)) foreach($orcamentos as $row): ?>
									<?php 
										if (isset($row["OrcamentoID"])){
											 if (isset($proposta["OrcamentoID"]) && $row["OrcamentoID"] == $proposta["OrcamentoID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option 
										<?php echo $selected; ?> 
										data-orcamentoano = '<?php echo $row["OrcamentoAno"] ?>'
										value='<?php echo $row["OrcamentoID"] ?>' ><?php echo $row["OrcamentoAno"] . " - " . $row["OrcamentoResolucao"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="StatusNome">Status</label>
						<div class="controls">
							<input class="span4 gravar" readonly type="text" id="StatusNome" name="StatusNome" 
								value = '<?php echo (isset($proposta["StatusNome"])) ? $proposta["StatusNome"] : "Nova Proposta"; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropostaFaseNome">Fase</label>
						<div class="controls">
							<input class="span4 gravar" readonly type="text" id="PropostaFaseNome" name="PropostaFaseNome" 
								value = '<?php echo (isset($proposta["PropostaFaseNome"])) ? $proposta["PropostaFaseNome"] : (($fase == 1) ? "PRELIMINAR" : "DEFINITIVA")  ; ?>' ></input>
						</div>
					</div>

				</div> <!-- Fim tabCadProp -->

				<!-- =========================================================== INICIO tabEntidades 		=========================================================== -->
				<div class="tab-pane fade " id='tabEntidades'>

					<!-- <legend> Entidades envolvidas na Operação </legend> -->

					<div class="control-group in-line">

						<label class="control-label">Securitizadora</label>
						<div class="control">
							<select class="span6" name="SecuritizadoraID" id="SecuritizadoraID" onChange = "selecionaDadosSecuritizadora(this);" <?php if ($fase == 2) echo "disabled"; ?>>
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($securitizadoras)) foreach($securitizadoras as $row): ?>
									<?php 
										if (isset($row["EntidadeID"])){
											 if (isset($proposta["SecuritizadoraID"]) && $row["EntidadeID"] == $proposta["SecuritizadoraID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option data-entidadetipodescricao 	= '<?php echo (isset($row["EntidadeTipoDescricao"])) 	? $row["EntidadeTipoDescricao"] 							: ""; ?>'
											data-rating					= '<?php echo (isset($row["HabilitacaoRating"])) 		? $row["HabilitacaoRating"] 								: ""; ?>'
											data-validade				= '<?php echo (isset($row["HabilitacaoValidade"])) 		? PPOEntity::toDateBr($row["HabilitacaoValidade"], "d/m/Y") : ""; ?>' 
											data-conclusaoid			= '<?php echo (isset($row["HabilitacaoConclusaoID"])) 	? $row["HabilitacaoConclusaoID"] 							: ""; ?>' 
											data-status					= '<?php echo (isset($row["StatusHabilitacao"])) 		? $row["StatusHabilitacao"] 								: ""; ?>' 
											data-entidadeuf				= '<?php echo (isset($row["EntidadeUF"])) 				? $row["EntidadeUF"] 										: ""; ?>' 
											cnpj 						= '<?php echo (isset($row["EntidadeCnpj"])) 			? $row["EntidadeCnpj"] 										: ""; ?>' 
											value 						= '<?php echo (isset($row["EntidadeID"])) 				? $row["EntidadeID"] 										: ""; ?>' 
											<?php echo $selected; ?>  ><?php echo $row["EntidadeNomeFantasia"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="SecuritizadoraRating">Rating</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="SecuritizadoraRating" name="SecuritizadoraRating" 
							value = '<?php echo (isset($proposta["SecuritizadoraRating"])) ? $proposta["SecuritizadoraRating"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="SecuritizadoraStatus">Status</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="SecuritizadoraStatus" name="SecuritizadoraStatus" 
							value = '<?php echo (isset($proposta["SecuritizadoraStatus"])) ? $proposta["SecuritizadoraStatus"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="SecuritizadoraValidade">Validade</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="SecuritizadoraValidade" name="SecuritizadoraValidade" 
							value = '<?php echo (isset($proposta["SecuritizadoraValidade"])) ? PPOEntity::toDateBr($proposta["SecuritizadoraValidade"], 'd/m/Y') : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Originador dos Créditos</label>
						<div class="control">
							<select class="span6" name="OriginadorID" id="OriginadorID">
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($originadoresCreditos)) foreach($originadoresCreditos as $row): ?>
									<?php 
										if (isset($row["EntidadeID"])){
											 if (isset($proposta["OriginadorID"]) && $row["EntidadeID"] == 
											 	$proposta["OriginadorID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option data-entidadetipodescricao='<?php echo $row["EntidadeTipoDescricao"] ?>'  
											data-entidadeuf='<?php echo $row["EntidadeUF"] ?>' 
											cnpj = '<?php echo $row["EntidadeCnpj"] ?>' 
											value='<?php echo $row["EntidadeID"] ?>' 
											<?php echo $selected; ?>  ><?php echo $row["EntidadeNomeFantasia"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Coordenador Líder</label>
						<div class="control">
							<select class="span6" name="CoordenadorLiderID" id="CoordenadorLiderID">
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($coordenadoresLideres)) foreach($coordenadoresLideres as $row): ?>
									<?php 
										if (isset($row["EntidadeID"])){
											 if (isset($proposta["CoordenadorLiderID"]) && $row["EntidadeID"] 
											 	== $proposta["CoordenadorLiderID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									
									<option data-entidadetipodescricao='<?php echo $row["EntidadeTipoDescricao"] ?>'
											data-entidadeuf='<?php echo $row["EntidadeUF"] ?>' 
											cnpj = '<?php echo $row["EntidadeCnpj"] ?>' 
											value='<?php echo $row["EntidadeID"] ?>' 
											<?php echo $selected; ?>  ><?php echo $row["EntidadeNomeFantasia"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Agente Fiduciário</label>
						<div class="control">
							<select class="span6" name="AgenteFiduciarioID" id="AgenteFiduciarioID" onChange = "selecionaDadosAgenteFiduciario(this);">
							<option value="">Selecione</option>
								<?php $selected = ""; ?>
								<?php if (isset($agentesFiduciarios)) foreach($agentesFiduciarios as $row): ?>
									<?php 
										if (isset($row["EntidadeID"])){
											 if (isset($proposta["AgenteFiduciarioID"]) && $row["EntidadeID"] == $proposta["AgenteFiduciarioID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option data-entidadetipodescricao 	= '<?php echo (isset($row["EntidadeTipoDescricao"])) 	? $row["EntidadeTipoDescricao"] 							: ""; ?>'
											data-rating					= '<?php echo (isset($row["HabilitacaoRating"])) 		? $row["HabilitacaoRating"] 								: ""; ?>'
											data-validade				= '<?php echo (isset($row["HabilitacaoValidade"])) 		? PPOEntity::toDateBr($row["HabilitacaoValidade"], "d/m/Y") : ""; ?>' 
											data-conclusaoid			= '<?php echo (isset($row["HabilitacaoConclusaoID"])) 	? $row["HabilitacaoConclusaoID"] 							: ""; ?>' 
											data-status					= '<?php echo (isset($row["StatusHabilitacao"])) 		? $row["StatusHabilitacao"] 								: ""; ?>' 
											data-entidadeuf				= '<?php echo (isset($row["EntidadeUF"])) 				? $row["EntidadeUF"] 										: ""; ?>' 
											cnpj 						= '<?php echo (isset($row["EntidadeCnpj"])) 			? $row["EntidadeCnpj"] 										: ""; ?>' 
											value 						= '<?php echo (isset($row["EntidadeID"])) 				? $row["EntidadeID"] 										: ""; ?>' 
											<?php echo $selected; ?>  ><?php echo $row["EntidadeNomeFantasia"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>	

					<div class="hide">
						<label class="control-label" for="AgenteFiduciarioRating">Rating</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="AgenteFiduciarioRating" name="AgenteFiduciarioRating" 
							value = '<?php echo (isset($proposta["AgenteFiduciarioRating"])) ? $proposta["AgenteFiduciarioRating"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AgenteFiduciarioStatus">Status</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="AgenteFiduciarioStatus" name="AgenteFiduciarioStatus" 
							value = '<?php echo (isset($proposta["AgenteFiduciarioStatus"])) ? $proposta["AgenteFiduciarioStatus"] : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="AgenteFiduciarioValidade">Validade</label>
						<div class="controls">
							<input class="span2 gravar" readonly type="text" id="AgenteFiduciarioValidade" name="AgenteFiduciarioValidade" 
							value = '<?php echo (isset($proposta["AgenteFiduciarioValidade"])) ? PPOEntity::toDateBr($proposta["AgenteFiduciarioValidade"], 'd/m/Y') : ""; ?>' ></input>
						</div>
					</div>

				</div> <!-- Fim tabEntidades -->

				<!-- =========================================================== INICIO tabCaracteristicas  =========================================================== -->
				<div class="tab-pane fade " id='tabCaracteristicas'>

					<!-- <legend> Características Gerais da Carteira </legend> -->

					<div class="control-group in-line">

						<label class="control-label">Faixa</label>
						<div class="controls">
							<select class="span3" name="PropostaFaixaID" id="PropostaFaixaID" onChange="selectFaixa(this)" <?php if ($fase == 2) echo "disabled"; ?> >	
							<option value="">Selecione</option>
						   		<?php $selected = "";?> 
						   		<?php if (isset($faixas)) foreach($faixas as $row): ?>

						   			<?php 
							   			if (isset($row["PropostaFaixaID"]) && isset($proposta["PropostaFaixaID"]) && $row["PropostaFaixaID"] == $proposta["PropostaFaixaID"]) 
							   				$selected = "selected = 'selected'"; else $selected="";
						   			?>
						   			<option 
						   				<?php echo $selected; ?> 
										data-valorminimo = '<?php echo PPOEntity::toMoneyBr($row["ValorMinimo"]) ?>'
										data-valormaximo = '<?php echo PPOEntity::toMoneyBr($row["ValorMaximo"]) ?>' 
										data-taxanominal = '<?php echo PPOEntity::toMoneyBr($row["TaxaJurosNominal"], 5) ?>'
										data-taxaefetiva = '<?php echo PPOEntity::toMoneyBr($row["TaxaJurosEfetiva"], 5) ?>'
						   				value='<?php echo $row["PropostaFaixaID"] ?>'>
					   					<span class='label label-success'> <?php echo $row["PropostaFaixaTipoNome"]; ?> </span>		
						   			</option>

						    	<?php endforeach; ?>
							</select>
						</div>

					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropostaFaixaVlrMin">Valor Mínimo do Imóvel</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" readonly type="text" id="PropostaFaixaVlrMin" name="PropostaFaixaVlrMin" 
							value = '<?php echo (isset($proposta["PropostaFaixaVlrMin"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaVlrMin"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropostaFaixaVlrMax">Valor Máximo do Imóvel</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" readonly type="text" id="PropostaFaixaVlrMax" name="PropostaFaixaVlrMax" 
							value = '<?php echo (isset($proposta["PropostaFaixaVlrMax"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaVlrMax"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PropostaFaixaTaxaJurosNominal">Taxa de Juros Nominal</label>
						<div class="controls">
							<input class="span3 campo-formatado porcentagem" readonly type="text" id="PropostaFaixaTaxaJurosNominal" name="PropostaFaixaTaxaJurosNominal" 
							value = '<?php echo (isset($proposta["PropostaFaixaTaxaJurosNominal"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaTaxaJurosNominal"], 5) : ""; ?>' ></input>
						</div>
					</div>

					<!-- TAXA EFETIVA -->
					<div class="control-group in-line">
						<label class="control-label" for="PropostaFaixaTaxaJurosEfetiva">Taxa de Juros Efetiva</label>
						<div class="controls">
							<input class="span3 campo-formatado porcentagem" readonly type="text" id="PropostaFaixaTaxaJurosEfetiva" name="PropostaFaixaTaxaJurosEfetiva" 
							value = '<?php echo (isset($proposta["PropostaFaixaTaxaJurosEfetiva"])) ? PPOEntity::toMoneyBr($proposta["PropostaFaixaTaxaJurosEfetiva"], 5) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label">Tipo de Empreendimento</label>
						<div class="control">
							<select class="span6" name="PropEmpreendTipoID" id="PropEmpreendTipoID" <?php if ($fase == 2) echo "disabled"; ?>>
								<?php $selected = ""; ?>
								<?php if (isset($empreendTipos)) foreach($empreendTipos as $row): ?>
									<?php 
										if (isset($row["PropEmpreendTipoID"])){
											 if (isset($proposta["PropEmpreendTipoID"]) && $row["PropEmpreendTipoID"] == $proposta["PropEmpreendTipoID"]) 
													$selected = "selected = 'selected'"; else $selected="";
										} 
									?>
									<option <?php echo $selected; ?> value='<?php echo $row["PropEmpreendTipoID"] ?>' ><?php echo $row["PropEmpreendNome"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>


				</div> <!-- Fim tabCaracteristicas -->

				<!-- =========================================================== INICIO tabCondBasicas 		=========================================================== -->
				<div class="tab-pane fade " id='tabCondBasicas'>

					<!-- <legend> Condições Básicas da Operação </legend> -->

					<?php if ($fase == 2) $show_definitiva = ""; else $show_definitiva = "hide" ?> 

	
					<div class="<?php echo $show_definitiva ?> control-group in-line">
						<label class="control-label" for="ValorAprovadoGEFOM">Valor Aprovado pela GEFOM</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="20" type="text" id="ValorAprovadoGEFOM" name="ValorAprovadoGEFOM" readonly
							value = '<?php echo (isset($proposta["ValorAprovadoGEFOM"])) ?  PPOEntity::toMoneyBr($proposta["ValorAprovadoGEFOM"]) : ""; ?>' ></input>
						</div>
					</div>

			

					<div class="control-group in-line">
						<label class="control-label" for="ValorGlobalProposta">Valor Global da Proposta</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="20" type="text" id="ValorGlobalProposta" name="ValorGlobalProposta" 
							value = '<?php echo (isset($proposta["ValorGlobalProposta"])) ?  PPOEntity::toMoneyBr($proposta["ValorGlobalProposta"]) : ""; ?>' ></input>
						</div>
					</div>
					<?php
						$valorseniormaior = " hide ";
						if (isset($proposta["ValorAprovadoGEFOM"]) && isset($proposta["ValorCRISenior"]) &&
							$proposta["ValorCRISenior"] > $proposta["ValorAprovadoGEFOM"] ){
							$valorseniormaior = " "; 
						}

					?>

					<div class="control-group .valorseniormaior">
						<div class='<?php echo $valorseniormaior . " " . $show_definitiva; ?> alert'> Valor do CRI (Sêncior) da proposta supera o valor aprovado pela GEFOM </div>
					</div>

					<div class='clear'></div>

					<div class="control-group in-line">
						<label class="control-label" for="ValorCRISenior">Valor do CRI (Sênior)</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="20" type="text" id="ValorCRISenior" name="ValorCRISenior" 
							value = '<?php echo (isset($proposta["ValorCRISenior"])) ?  PPOEntity::toMoneyBr($proposta["ValorCRISenior"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="QuantidadeSenior">Quantidade de CRI (Sênior)</label>
						<div class="controls">
							<input class="span3 campo-formatado inteiro" maxlength="5" type="text" id="QuantidadeSenior" name="QuantidadeSenior" 
							value = '<?php echo (isset($proposta["QuantidadeSenior"])) ? $proposta["QuantidadeSenior"] : ""; ?>' ></input>
						</div>
					</div>
					
					<div class="control-group in-line">
						<label class="control-label" for="ValorUnitarioSenior">Valor Unitário do CRI (Sênior)</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorUnitarioSenior" name="ValorUnitarioSenior" 
							value = '<?php echo (isset($proposta["ValorUnitarioSenior"])) ?  PPOEntity::toMoneyBr($proposta["ValorUnitarioSenior"]) : ""; ?>' ></input>
						</div>
					</div>

					<br>
					<div class="control-group in-line">
						<label class="control-label" for="PrazoCarencia">Prazo de Carência (Sênior)</label>
						<div class="controls">
							<input class="span2 campo-formatado inteiro" maxlength="9" type="text" id="PrazoCarencia" name="PrazoCarencia" 
							value = '<?php echo (isset($proposta["PrazoCarencia"])) ? $proposta["PrazoCarencia"] : ""; ?>' ></input>
							<span class="help-inline">(Meses)</span>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="PrazoAmortizacao">Prazo de Amortização (Sênior)</label>
						<div class="controls">
							<input class="span2 campo-formatado inteiro" maxlength="9" type="text" id="PrazoAmortizacao" name="PrazoAmortizacao" 
							value = '<?php echo (isset($proposta["PrazoAmortizacao"])) ? $proposta["PrazoAmortizacao"] : ""; ?>' ></input>
							<span class="help-inline">(Meses)</span>
						</div>
					</div>					
					<br>
					<div class="control-group in-line">
						<label class="control-label" for="ValorSubordinado">Valor do CRI (Júnior)</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="20" type="text" id="ValorSubordinado" name="ValorSubordinado"
							value = '<?php echo (isset($proposta["ValorSubordinado"])) ?  PPOEntity::toMoneyBr($proposta["ValorSubordinado"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="ValorUnitarioSubordinado">Valor Unitário do CRI (Júnior)</label>
						<div class="controls">
							<input class="span3 campo-formatado moeda" maxlength="20" type="text" id="ValorUnitarioSubordinado" name="ValorUnitarioSubordinado"
							value = '<?php echo (isset($proposta["ValorUnitarioSubordinado"])) ?  PPOEntity::toMoneyBr($proposta["ValorUnitarioSubordinado"]) : ""; ?>' ></input>
						</div>
					</div>

					<div class="control-group in-line">
						<label class="control-label" for="QuantidadeSubordinado">Quantidade de CRI (Júnior)</label>
						<div class="controls">
							<input class="span3 campo-formatado inteiro" maxlength="5" type="text" id="QuantidadeSubordinado" name="QuantidadeSubordinado" 
							value = '<?php echo (isset($proposta["QuantidadeSubordinado"])) ? $proposta["QuantidadeSubordinado"] : ""; ?>' ></input>
						</div>
					</div>

				</div> <!-- Fim tabCondBasicas -->

			</div> <!-- Fim TAB CONTENT -->

		</form>

	</div>
	<div class="modal-footer">
		<button id="btn_salvar" class="btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>
