	<form id="formPropostaDadosBasicos" name="formPropostaDadosBasicos" >
		
		<h3>Dados Básicos</h3>
		
		<ul class="nav nav-tabs" id="navDadosBasicos">
			<li class="active"	><a href="#tabCadProp" 	 		data-toggle="tab">Cadastramento de Proposta</a></li>
			<li					><a href="#tabEntidades" 		data-toggle="tab">Entidades Envolvidas na Operação</a></li>
			<li					><a href="#tabCaracteristicas" 	data-toggle="tab">Características Gerais da Carteira</a></li>
			<li					><a href="#tabCondBasicas" 		data-toggle="tab">Condições Básicas da Operação</a></li>
		</ul>

		<div id="tabDadosBasicos" class="tab-content">
			<!-- =========================================================== INICIO tabCadProp 			=========================================================== -->
			<div class="tab-pane active fade in" id='tabCadProp'>

				<div class="control-group in-line">
					<label class="control-label" for="ProgramaNome">Programa</label>
					<div class="controls">
						<input class="span6 " readonly type="text" id="ProgramaNome" 
							name="ProgramaNome" 
							value = '<?php echo (isset($proposta["ProgramaNome"])) ? $proposta["ProgramaNome"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="PropostaNumero">Número</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="PropostaNumero" name="PropostaNumero" 
							value = '<?php echo (isset($proposta["PropostaNumero"])) ? $proposta["PropostaNumero"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line" >
					<label class="control-label" for="DataRecepcao">Data da Recepção</label>
					<div class="controls">
						<input  maxlength="10" class=" span2" type="text" readonly 
							id="DataRecepcao" 
							name="DataRecepcao" 
							value = '<?php echo (isset($proposta["DataRecepcao"])) ? PPOEntity::toDateBr($proposta["DataRecepcao"],	"d/m/Y") : ""; ?>' >
						</input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label">GIFUG</label>
					<div class="control">
						<input class="span2 " readonly type="text" id="UnidadeID" name="UnidadeID" 
							value='<?php echo (isset($proposta["UnidadeSigla"])) ? $proposta["UnidadeSigla"] : ""; ?>' >
						</input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label">Ano Orçamentário</label>
					<div class="control">
						<input class="span4 " readonly type="text" id="OrcamentoID" name="OrcamentoID" 
							value='<?php  echo (isset($proposta["OrcamentoID"])) ? $proposta["OrcamentoAno"] . " - " . $proposta["OrcamentoResolucao"] : ""; ?>' >
						</input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="StatusNome">Status</label>
					<div class="controls">
						<input class="span4 " readonly type="text" id="StatusNome" name="StatusNome" 
							value = '<?php echo (isset($proposta["StatusNome"])) ? $proposta["StatusNome"] : "Nova Proposta"; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="PropostaFaseNome">Fase</label>
					<div class="controls">
						<input class="span4 " readonly type="text" id="PropostaFaseNome" name="PropostaFaseNome" 
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
						<input class="span6" readonly type="text" name="SecuritizadoraID" id="SecuritizadoraID" 
							value = '<?php echo (isset($proposta["SecuritizadoraNome"])) ? $proposta["SecuritizadoraNome"]: ""; ?>' 
						</input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="SecuritizadoraRating">Rating</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="SecuritizadoraRating" name="SecuritizadoraRating" 
						value = '<?php echo (isset($proposta["SecuritizadoraRating"])) ? $proposta["SecuritizadoraRating"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="SecuritizadoraStatus">Status</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="SecuritizadoraStatus" name="SecuritizadoraStatus" 
						value = '<?php echo (isset($proposta["SecuritizadoraStatus"])) ? $proposta["SecuritizadoraStatus"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="SecuritizadoraValidade">Validade</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="SecuritizadoraValidade" name="SecuritizadoraValidade" 
						value = '<?php echo (isset($proposta["SecuritizadoraValidade"])) ? PPOEntity::toDateBr($proposta["SecuritizadoraValidade"], 'd/m/Y') : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label">Originador dos Creditos</label>
					<div class="control">
						<input class="span6" readonly type="text" name="OriginadorID" id="OriginadorID" 
							value = '<?php echo (isset($proposta["OriginadorNome"])) ? $proposta["OriginadorNome"]: ""; ?>' 
						</input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label">Coordenador Líder</label>
					<div class="control">
						<input class="span6" readonly type="text" name="CoordenadorLiderID" id="CoordenadorLiderID" 
							value = '<?php echo (isset($proposta["CoordenadorLiderNome"])) ? $proposta["CoordenadorLiderNome"]: ""; ?>' 
						</input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label">Agente Fiduciário</label>
					<div class="control">
						<input class="span6" readonly type="text" name="AgenteFiduciarioID" id="AgenteFiduciarioID" 
							value = '<?php echo (isset($proposta["AgenteFiduciarioNome"])) ? $proposta["AgenteFiduciarioNome"]: ""; ?>' 
						</input>
					</div>
				</div>

				<div class="hide">
					<label class="control-label" for="AgenteFiduciarioRating">Rating</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="AgenteFiduciarioRating" name="AgenteFiduciarioRating" 
						value = '<?php echo (isset($proposta["AgenteFiduciarioRating"])) ? $proposta["AgenteFiduciarioRating"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="AgenteFiduciarioStatus">Status</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="AgenteFiduciarioStatus" name="AgenteFiduciarioStatus" 
						value = '<?php echo (isset($proposta["AgenteFiduciarioStatus"])) ? $proposta["AgenteFiduciarioStatus"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="AgenteFiduciarioValidade">Validade</label>
					<div class="controls">
						<input class="span2 " readonly type="text" id="AgenteFiduciarioValidade" name="AgenteFiduciarioValidade" 
						value = '<?php echo (isset($proposta["AgenteFiduciarioValidade"])) ? PPOEntity::toDateBr($proposta["AgenteFiduciarioValidade"], 'd/m/Y') : ""; ?>' ></input>
					</div>
				</div>

			</div> <!-- Fim tabEntidades -->

			<!-- =========================================================== INICIO tabCaracteristicas  =========================================================== -->
			<div class="tab-pane fade " id='tabCaracteristicas'>

				<!-- <legend> Características Gerais da Carteira </legend> -->
				<div class="control-group in-line">
					<label class="control-label" for="PropostaFaixaID">Faixa</label>
					<div class="controls">
						<input class="span3 " readonly type="text" id="PropostaFaixaID" name="PropostaFaixaID" 
						value = '<?php echo (isset($proposta["PropostaFaixaTipoNome"])) ? $proposta["PropostaFaixaTipoNome"] : ""; ?>' ></input>
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
					<label class="control-label" for="PropEmpreendTipoID">Tipo de Empreendimento</label>
					<div class="controls">
						<input class="span6 " readonly type="text" id="PropEmpreendTipoID" name="PropEmpreendTipoID" 
						value = '<?php echo (isset($proposta["PropEmpreendNome"])) ? $proposta["PropEmpreendNome"] : ""; ?>' ></input>
					</div>
				</div>

			</div> <!-- Fim tabCaracteristicas -->

			<?php if ($fase == 2) $show_definitiva = ""; else $show_definitiva = "hide" ?> 

			<!-- =========================================================== INICIO tabCondBasicas 		=========================================================== -->
			<div class="tab-pane fade " id='tabCondBasicas'>

				<!-- <legend> Condições Básicas da Operação </legend> -->

				<div class="control-group in-line <?php echo $show_definitiva ?>">
					<label class="control-label" for="ValorAprovadoGEFOM">Valor Aprovado pela GEFOM</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorAprovadoGEFOM" name="ValorAprovadoGEFOM" readonly
						value = '<?php echo (isset($proposta["ValorAprovadoGEFOM"])) ?  PPOEntity::toMoneyBr($proposta["ValorAprovadoGEFOM"]) : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ValorGlobalProposta">Valor Global da Proposta</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorGlobalProposta" name="ValorGlobalProposta" 
						value = '<?php echo (isset($proposta["ValorGlobalProposta"])) ?  PPOEntity::toMoneyBr($proposta["ValorGlobalProposta"]) : ""; ?>' ></input>
					</div>
				</div>

				<div class='clear'></div>

				<div class="control-group in-line">
					<label class="control-label" for="ValorCRISenior">Valor do CRI (Sênior)</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorCRISenior" name="ValorCRISenior" 
						value = '<?php echo (isset($proposta["ValorCRISenior"])) ?  PPOEntity::toMoneyBr($proposta["ValorCRISenior"]) : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ValorUnitarioSenior">Valor Unitário do CRI (Sênior)</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorUnitarioSenior" name="ValorUnitarioSenior" 
						value = '<?php echo (isset($proposta["ValorUnitarioSenior"])) ?  PPOEntity::toMoneyBr($proposta["ValorUnitarioSenior"]) : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="QuantidadeSenior">Quantidade de CRI (Sênior)</label>
					<div class="controls">
						<input class="span3 campo-formatado inteiro" readonly maxlength="5" type="text" id="QuantidadeSenior" name="QuantidadeSenior" 
						value = '<?php echo (isset($proposta["QuantidadeSenior"])) ? $proposta["QuantidadeSenior"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="PrazoCarencia">Prazo de Carência (Sênior)</label>
					<div class="controls">
						<input class="span3 campo-formatado inteiro" readonly maxlength="9" type="text" id="PrazoCarencia" name="PrazoCarencia" 
						value = '<?php echo (isset($proposta["PrazoCarencia"])) ? $proposta["PrazoCarencia"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="PrazoAmortizacao">Prazo de Amortização (Sênior)</label>
					<div class="controls">
						<input class="span3 campo-formatado inteiro" readonly maxlength="9" type="text" id="PrazoAmortizacao" name="PrazoAmortizacao" 
						value = '<?php echo (isset($proposta["PrazoAmortizacao"])) ? $proposta["PrazoAmortizacao"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ValorSubordinado">Valor do CRI (Júnior)</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorSubordinado" name="ValorSubordinado"
						value = '<?php echo (isset($proposta["ValorSubordinado"])) ?  PPOEntity::toMoneyBr($proposta["ValorSubordinado"]) : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ValorUnitarioSubordinado">Valor Unitário do CRI (Júnior)</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda" readonly maxlength="20" type="text" id="ValorUnitarioSubordinado" name="ValorUnitarioSubordinado"
						value = '<?php echo (isset($proposta["ValorUnitarioSubordinado"])) ?  PPOEntity::toMoneyBr($proposta["ValorUnitarioSubordinado"]) : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="QuantidadeSubordinado">Quantidade de CRI (Júnior)</label>
					<div class="controls">
						<input class="span3 campo-formatado inteiro" readonly maxlength="5" type="text" id="QuantidadeSubordinado" name="QuantidadeSubordinado" 
						value = '<?php echo (isset($proposta["QuantidadeSubordinado"])) ? $proposta["QuantidadeSubordinado"] : ""; ?>' ></input>
					</div>
				</div>

			</div> <!-- Fim tabCondBasicas -->

		</div> <!-- Fim TAB CONTENT -->

	</form>