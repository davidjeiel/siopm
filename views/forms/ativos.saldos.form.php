<script type="text/javascript">

	$(document).ready(function() {

		aplicaDataTableSaldos();
		
		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});
		});

		maskMoedaBR(2);

	});

	$("#dialog-manut-ativos-saldos form").validate({
		rules: {
			SaldoData: {required: true},
			SaldoValor: {required: true}
		},
		messages: { 
			SaldoData: { required: 'Campo obrigatório'},
			SaldoValor: {required: 'Campo obrigatório'}
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

	#dialog-manut-ativos-saldos {
		width: 800px; /* SET THE WIDTH OF THE MODAL */
		 margin-left: -412px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
		  /*margin-top: -60px!important;*/
	}

	#dialog-manut-ativos-saldos.modal-body{
		padding-bottom: 30px;
		overflow: hidden;
	}

	#camposSaldos{
		border: 1px;
		border-color: #CCC;
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

<div id="dialog-manut-ativos-saldos" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"> <?php echo $formTitulo; ?></h3>
	</div>

	<div class="modal-body">

		<form id='Saldos' name='Saldos'>

			<!-- Cabeçalho para mostrar informações do ativo financeiro-->

			<div class="control-group in-line">
				<label class="control-label" for="ModalidadeNome">Modalidade</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="ModalidadeNome" name="ModalidadeNome" value = '<?php echo ((isset($ativoDadoBasico["ModalidadeNome"])) ? $ativoDadoBasico["ModalidadeNome"] : ""). ' - ' . ((isset($ativoDadoBasico["ModalidadeSetor"])) ? $ativoDadoBasico["ModalidadeSetor"] : ""); ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="AtivoCodigoSIOPM">Código SIOPM</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="AtivoCodigoSIOPM" name="AtivoCodigoSIOPM" value = '<?php echo (isset($ativoDadoBasico["AtivoCodigoSIOPM"])) ? $ativoDadoBasico["AtivoCodigoSIOPM"] : ""; ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
					<label class="control-label" for="AtivoCodigoCetip">Código CETIP</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="AtivoCodigoCetip" name="AtivoCodigoCetip" value = '<?php echo (isset($ativoDadoBasico["AtivoCodigoCetip"])) ? $ativoDadoBasico["AtivoCodigoCetip"] : ""; ?>' ></input>
						</div>
			</div>

			

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value='<?php echo (isset($ativoDadoBasico["AtivoID"])) ? $ativoDadoBasico["AtivoID"] : ""; ?>' >
			</input>

			<div id="camposSaldos" class="hide well">

				<input type="hidden" id="SaldoID" name="SaldoID" 
				value='<?php echo (isset($ativoSaldos["SaldoID"])) ? $ativoSaldos["SaldoID"] : ""; ?>' >
				</input>

				<div class="control-group in-line input-append date" data-date="" data-date-format="dd/mm/yyyy">
					<label for="SaldoData">Posição</label>
					<input  class="span3" maxlength="16" type="text" id="SaldoData" name="SaldoData"  readonly
					value = '<?php echo (isset($ativoSaldos["SaldoData"])) ?  PPOEntity::toDateBr($ativoSaldos["SaldoData"], "d/m/Y") : ""; ?>'  /> 
					<span class="add-on"><i class="icon-th"></i></span>
				</div> 	

				<div class="control-group in-line">
					<label class="control-label" for="SaldoValor">Saldo</label>
					<div class="controls">
						<input class="span3 moeda" type="text" id="SaldoValor" name="SaldoValor" value = '<?php echo (isset($ativoSaldos["SaldoValor"])) ? $ativoSaldos["SaldoValor"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ProvisaoTaxaRisco">Taxa de Risco Provisionada</label>
					<div class="controls">
						<input class="span3 moeda" type="text" id="ProvisaoTaxaRisco" name="ProvisaoTaxaRisco" value = '<?php echo (isset($ativoSaldos["ProvisaoTaxaRisco"])) ? $ativoSaldos["ProvisaoTaxaRisco"] : ""; ?>' ></input>
					</div>
				</div>

			</div>

		</form>

		<div id="div_lista_ativos_saldos">

			<?php if (user_has_access("CRI_EVENTOS_SALDOS_EDITAR")) : ?>
			<p><button class="btn_novo_saldo btn btn-primary" type="button">Novo Saldo</button></p>
			<?php EndIf; ?>

			<spam id="spanListaConteudo">
				
				<?php require $siopm->getForm('ativos.saldos.list'); ?>

			</spam>	
			
		</div>
	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary">Salvar</button>
		<button id="btn_cancelar" class="btn_cancelar btn" aria-hidden="true" >Sair</button>
	</div>

</div>

