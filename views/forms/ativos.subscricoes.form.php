
<?php $siopm->includeJS("views", "ativos.subscricoes.js"); ?>

<script type="text/javascript">

	$(document).ready(function() {

    	applyDataTableByID("lista_subscricoes", "150px");
		
		$('.input-append.date').each(function () {

			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  
		});

		maskMoedaBR(8);
		maskNumeroBR(8);

	});

	$("#dialog-manut-subscricoes form").validate({
	  rules: {	
	  	SubscricoesData: {required: true},
	  	SubscricoesQuantidade: {required: true},
	  	SubscricoesValorUnitario: {required: true},
	  	SubscricoesVolume: {required: true} 	
	  },
	  messages: { 	  	
	  	SubscricoesData: {required: 'Campo obrigatório'},
	  	SubscricoesQuantidade: { required: 'Campo obrigatório'},
	  	SubscricoesValorUnitario: { required: 'Campo obrigatório'},
	  	SubscricoesVolume: { required: 'Campo obrigatório'}
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

	#dialog-manut-subscricoes {
		width: 1024px; /* SET THE WIDTH OF THE MODAL */		
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	   /* margin-top: -60px!important;*/
	}

	#dialog-manut-subscricoes .modal-body{
		padding-left: 18px;
		overflow: hidden;
		max-height: 650px;
	}
	#campossubscricoes{
		border: 1px;
		border-color: #CCC;
	}

	/*#div_lista_subscricoes{
		height: 350px;
	}*/

	.date{
		margin-top: -17px;
	}
	
	.date input {
		margin-bottom: 10px;
		width: 179px;
	}

</style>


<div id="dialog-manut-subscricoes" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='Subscricoes' name='Subscricoes'>	

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

			<div class="control-group in-line">
					<label class="control-label" for="AtivoCodigoCetip">Data da Emissão</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="AtivoDataEmissao" name="AtivoDataEmissao"  
									value = '<?php echo (isset($ativoDadoBasico["AtivoDataEmissao"])) ?  PPOEntity::toDateBr($ativoDadoBasico["AtivoDataEmissao"], "d/m/Y") : ""; ?>'  /> 
							</input>
						</div>
			</div>			

			<!-- Cabeçalho para mostrar informações do ativo financeiro-->	

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value='<?php echo (isset($ativoDadoBasico["AtivoID"])) ? $ativoDadoBasico["AtivoID"] : ""; ?>' >
			</input>

			
			
			<input type="hidden"  id="AtivoDataVencimento" name="AtivoDataVencimento"  
					value = '<?php echo (isset($ativoDadoBasico["AtivoDataVencimento"])) ?  PPOEntity::toDateBr($ativoDadoBasico["AtivoDataVencimento"], "d/m/Y") : ""; ?>'  /> 
			</input>	

			<div id="campossubscricoes" class="hide well">
				

				<input type="hidden" id="SubscricoesID" name="SubscricoesID" 
					value='<?php echo (isset($subscricao["SubscricoesID"])) ? $subscricao["SubscricoesID"] : ""; ?>' >
				</input>

				<div class="control-group in-line input-append date" id="dpSubscricoesData" data-date="" data-date-format="dd/mm/yyyy">
					<label for="SubscricoesData">Data da Subscrição</label>
					<input  style='width: 178px;' maxlength="16" type="text" id="SubscricoesData" name="SubscricoesData" 
					value = '<?php echo (isset($subscricao["SubscricoesData"])) ?  PPOEntity::toDateBr($subscricao["SubscricoesData"], "d/m/Y") : ""; ?>'  /> 
					<span class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group in-line">
					<label class="control-label" for="SubscricoesQuantidade">Quantidade</label>
					<div class="controls">
						<input class="span3 campo-formatado numero" maxlength="20" type="text" id="SubscricoesQuantidade" name="SubscricoesQuantidade" value = '<?php echo (isset($subscricao["SubscricoesQuantidade"])) ? $subscricao["SubscricoesQuantidade"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="SubscricoesValorUnitario">Valor Nominal Unitário</label>
					<div class="controls">
						<input class="span3 form-control moeda campo-formatado" maxlength="40" type="text" id="SubscricoesValorUnitario" name="SubscricoesValorUnitario" value = '<?php echo (isset($subscricao["SubscricoesValorUnitario"])) ? $subscricao["SubscricoesValorUnitario"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="SubscricoesVolume">Volume</label>
					<div class="controls">
						<input class="span3 form-control moeda campo-formatado" maxlength="40" type="text" id="SubscricoesVolume" name="SubscricoesVolume" value = '<?php echo (isset($subscricao["SubscricoesVolume"])) ? $subscricao["SubscricoesVolume"] : ""; ?>' ></input>
					</div>
				</div>				

			</div>	

		

		<div id="div_lista_subscricoes">

			<p><button class="btn_novo_subscricao btn btn-primary" type="button">Nova Subscrição</button></p>

			<spam id="spanListaConteudoSubscricoes">
				
				<?php require $siopm->getForm('ativos.subscricoes.list'); ?>

			</spam>	

		</div>

	</form>	
		
	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary hide well">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" aria-hidden="true" >Sair</button>
	</div>

</div>

