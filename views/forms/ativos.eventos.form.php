
<script type="text/javascript">

	$(document).ready(function() {
		
		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  
		});

		maskFormBr(2,4);

		$("#dialog-ativos-eventos form").validate({
			rules: {
				TransacaoData: {required: true},
				SaldoDevedor: {required: true}
			},
			messages: { 
				TransacaoData: { required: 'Campo obrigatório'},
				SaldoDevedor: { required: 'Campo obrigatório'}
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

	});

</script>
<style type="text/css">

	#dialog-ativos-eventos {
		width: 1004px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -480px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	    /*margin-top: -50px;*/
	}

	#dialog-ativos-eventos .modal-body{
		padding-left: 30px;
		overflow: hidden;
		max-height: 540px;
	}

	#dialog-ativos-eventos #roll{
		overflow: auto;
		height: 230px;
	}
</style>

<div id="dialog-ativos-eventos" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>

	<div class="modal-body">

		<form id='formEventos' name='formEvento'>

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value = '<?php echo (isset($ativo["AtivoID"])) ? $ativo["AtivoID"] : ""; ?>' ></input>

			<input type="hidden" id="TransacaoID" name="TransacaoID" 
				value = '<?php echo (isset($transacao["TransacaoID"])) ? $transacao["TransacaoID"] : ""; ?>' ></input>

			<div class='controls'>

				<div class="control-group ">
					<label class="control-label" for="ModalidadeNome">Modalidade</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="ModalidadeNome" name="ModalidadeNome" 
								value = '<?php echo (isset($ativo["ModalidadeNome"])) ? $ativo["ModalidadeNome"]  . " - " . $ativo["ModalidadeSetor"] : ""; ?>' ></input>
						</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="AtivoCodigoSIOPM">Código SIOPM</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="AtivoCodigoSIOPM" name="AtivoCodigoSIOPM" 
								value = '<?php echo (isset($ativo["AtivoCodigoSIOPM"])) ? $ativo["AtivoCodigoSIOPM"] : ""; ?>' ></input>
						</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="AtivoCodigoCetip">Código CETIP</label>
						<div class="controls">
							<input class="span3" maxlength="10" readonly type="text" id="AtivoCodigoCetip" name="AtivoCodigoCetip" value = '<?php echo (isset($ativo["AtivoCodigoCetip"])) ? $ativo["AtivoCodigoCetip"] : ""; ?>' ></input>
						</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="AtivoDataEmissao">Data de Emissão</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="AtivoDataEmissao" name="AtivoDataEmissao" 
							value = '<?php echo (isset($ativo["AtivoDataEmissao"])) ? PPOEntity::toDateBr($ativo["AtivoDataEmissao"], "d/m/Y") : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="AtivoDataVencimento">Data de Vencimento</label>
						<div class="controls">
							<input class="span3" maxlength="10" readonly type="text" id="AtivoDataVencimento" name="AtivoDataVencimento" 
								value = '<?php echo (isset($ativo["AtivoDataVencimento"])) ? PPOEntity::toDateBr($ativo["AtivoDataVencimento"], "d/m/Y") : ""; ?>' ></input>
						</div>
				</div>

			</div> 

			<hr>

			<div id="div_campos" class='div_campos'>

				<div id='roll'>

					<div style='margin-top:-24px;' class="control-group in-line input-append date" 
							id="dpTransacaoData" data-date="" data-date-format="dd/mm/yyyy">
						<label  class="control-label" for="TransacaoData">Data da Transação </label>
						<input  style='width: 180px; background:#FFF;' maxlength="16" type="text" id="TransacaoData" name="TransacaoData" readonly 
							value = '<?php echo (isset($transacao["TransacaoData"])) ?  PPOEntity::toDateBr($transacao["TransacaoData"], "d/m/Y") : ""; ?>'  /> 
						<span  class="add-on"><i class="icon-th"></i></span>
					</div> 

					<?php 

						$TotalEventos =  0.00;
						$TotalJurosTaxaRisco = 0.00;

						if (isset($eventosExistentes[3])) $TotalJurosTaxaRisco = $eventosExistentes[3];
						if (isset($eventosExistentes[4])) $TotalJurosTaxaRisco += $eventosExistentes[4];

						if (isset($eventosTipos)) foreach($eventosTipos as $eventoTipo): 
							
							$EventoTipoID		= $eventoTipo['EventoTipoID'];
							$EventoTipoNome		= $eventoTipo['EventoTipoNome'];
							
							if (isset($eventosExistentes[$EventoTipoID])) $TotalEventos += $eventosExistentes[$EventoTipoID];
		
							$inputName =  "eventotipo_" . $EventoTipoID;
					?> 

						<div class="input-eventos control-group in-line">
							<label class="control-label" for="<?php echo $inputName; ?>"><?php echo $EventoTipoNome; ?></label>
							<div class="controls">
								<input class = "campo-formatado moeda eventovalor eventotipo_<?php echo $EventoTipoID	?>"
									type="text" id="<?php echo $inputName; ?>" name="<?php echo $inputName; ?>" 
									value = '<?php echo (isset($eventosExistentes[$EventoTipoID])) ? PPOEntity::toMoneyBr($eventosExistentes[$EventoTipoID]) : "R$ 0,00"; ?>' >
								</input>
							</div>
						</div>
						
					<?php endforeach; ?>

					<div class="control-group in-line">
						<label class="control-label" for="SaldoInformado">Saldo Devedor</label>
						<div class="controls ">
							<input class="span3 campo-formatado moeda" type="text" 
								id="SaldoDevedor" name="SaldoDevedor" 
								value = '<?php echo (isset($transacao["SaldoDevedor"])) ? PPOEntity::toMoneyBr($transacao["SaldoDevedor"]) : "R$ 0,00"; ?>' >
							</input>
						</div>
					</div>

				</div>

			</div>
			<hr>
			<?php
				$hideTotais = " hide ";
				if (isset($transacao["TransacaoID"]) && $transacao["TransacaoID"] > 0) $hideTotais = "";
			?>	
			<!-- <div id="totaisEventos" class='pull-right <?php echo $hideTotais ?>'> -->
				<div class="control-group in-line">
					 <label class="control-label" for="TotalJurosTaxaRisco">Juros + Taxa de Risco</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda " readonly type="text" id="TotalJurosTaxaRisco" name="TotalJurosTaxaRisco" 
							value = '<?php echo PPOEntity::toMoneyBr($TotalJurosTaxaRisco) ?>' ></input>
					</div>
				</div>
				<div class="control-group in-line">
					<label class="control-label" for="TotalEventos">Total da Transação</label>
					<div class="controls">
						<input class="span3 campo-formatado moeda " readonly type="text" id="TotalEventos" name="TotalEventos" 
							value = '<?php echo PPOEntity::toMoneyBr($TotalEventos) ?>' ></input>
					</div>
				</div>

			<!-- </div> -->
		</form>	
	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn-salvar btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>

</div>
