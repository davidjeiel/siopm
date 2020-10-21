<?php $siopm->includeJS("views", "ativos.integralizacoes.js"); ?>
<script type="text/javascript">

	$(document).ready(function() {

    	//applyDataTableByID("lista_integralizacoes", "150px");

    	$('table#lista_integralizacoes').dataTable({
			"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
							{ "sType": "date-br", "aTargets": [ 0 ] }, 
							{ "sType": "money-br", "aTargets": [ 2 ] },
							{ "sType": "money-br", "aTargets": [ 3 ] },
							{ "orderable": false, "aTargets": [4] }
						],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',	
		"bPaginate": false,	
		"sScrollY": "150px"
		});
		
		$('.input-append.date').each(function () {

			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  
		});

		maskMoedaBR(8);
		maskNumeroBR(8);

	});

	$("#dialog-manut-integralizacoes form").validate({
	  rules: {
	  	IntegralizacaoSubscricaoData: {required: true},
	  	IntegralizacaoData: {required: true},
	  	IntegralizacaoQuantidade: {required: true},
	  	IntegralizacaoValorUnitario: {required: true},
	  	IntegralizacaoVolume: {required: true} 	
	  },
	  messages: { 
	  	IntegralizacaoSubscricaoData: { required: 'Campo obrigatório'},
	  	IntegralizacaoData: {required: 'Campo obrigatório'},
	  	IntegralizacaoQuantidade: { required: 'Campo obrigatório'},
	  	IntegralizacaoValorUnitario: { required: 'Campo obrigatório'},
	  	IntegralizacaoVolume: { required: 'Campo obrigatório'}
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

	#dialog-manut-integralizacoes {
		width: 1024px; /* SET THE WIDTH OF THE MODAL */		
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	    /*margin-top: -60px!important;*/
	}

	#dialog-manut-integralizacoes .modal-body{
		padding-left: 18px;
		overflow: hidden;
		max-height: 650px;
	}
	#camposjuros{
		border: 1px;
		border-color: #CCC;
	}

	/*#div_lista_integralizacoes{
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


<div id="dialog-manut-integralizacoes" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='Integralizacoes' name='Integralizacoes'>	

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
					<label class="control-label" for="SubscricoesData">Data da Subscrição</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="SubscricoesData" name="SubscricoesData" value = '<?php echo (isset($ativoSubscricao["SubscricoesData"])) ?  PPOEntity::toDateBr($ativoSubscricao["SubscricoesData"], "d/m/Y") : ""; ?>' ></input>
						</div>
			</div>
			

			<!-- Cabeçalho para mostrar informações do ativo financeiro-->	

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value='<?php echo (isset($ativoDadoBasico["AtivoID"])) ? $ativoDadoBasico["AtivoID"] : ""; ?>' >
			</input>

			<input type="hidden"  id="AtivoDataVencimento" name="AtivoDataVencimento"  
					value = '<?php echo (isset($ativoDadoBasico["AtivoDataVencimento"])) ?  PPOEntity::toDateBr($ativoDadoBasico["AtivoDataVencimento"], "d/m/Y") : ""; ?>'  /> 
			</input>

			<input type="hidden" id="SubscricoesID" name="SubscricoesID" 
					value='<?php echo (isset($ativoSubscricao["SubscricoesID"])) ? $ativoSubscricao["SubscricoesID"] : ""; ?>' >
				</input>
			

			<div id="camposintegralizacao" class="hide well">

				<input type="hidden" id="IntegralizacaoID" name="IntegralizacaoID" 
					value='<?php echo (isset($integralizacao["IntegralizacaoID"])) ? $integralizacao["IntegralizacaoID"] : ""; ?>' >
				</input>
				
				<div class="control-group in-line input-append date" id="dpIntegralizacaoData" data-date="" data-date-format="dd/mm/yyyy">
					<label for="IntegralizacaoData">Data da Integralização</label>
					<input  style='width: 178;' maxlength="16" type="text" id="IntegralizacaoData" name="IntegralizacaoData"  
					value = '<?php echo (isset($integralizacao["IntegralizacaoData"])) ?  PPOEntity::toDateBr($integralizacao["IntegralizacaoData"], "d/m/Y") : ""; ?>'  /> 
					<span class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group in-line">
					<label class="control-label" for="IntegralizacaoQuantidade">Quantidade</label>
					<div class="controls">
						<input class="span3 campo-formatado numero" maxlength="20" type="text" id="IntegralizacaoQuantidade" name="IntegralizacaoQuantidade" value = '<?php echo (isset($integralizacao["IntegralizacaoQuantidade"])) ? $integralizacao["IntegralizacaoQuantidade"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="IntegralizacaoValorUnitario">Valor Nominal Unitário</label>
					<div class="controls">
						<input class="span3 form-control moeda campo-formatado" maxlength="40" type="text" id="IntegralizacaoValorUnitario" name="IntegralizacaoValorUnitario" value = '<?php echo (isset($integralizacao["IntegralizacaoValorUnitario"])) ? $integralizacao["IntegralizacaoValorUnitario"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="IntegralizacaoVolume">Volume</label>
					<div class="controls">
						<input class="span3 form-control moeda campo-formatado" maxlength="40" type="text" id="IntegralizacaoVolume" name="IntegralizacaoVolume" value = '<?php echo (isset($integralizacao["IntegralizacaoVolume"])) ? $integralizacao["IntegralizacaoVolume"] : ""; ?>' ></input>
					</div>
				</div>				

			</div>	

		
		
		<div id="div_lista_integralizacoes">

			<p><button class="btn_novo_integralizacao btn btn-primary" type="button">Nova Integralização</button></p>

			<spam id="spanListaConteudoIntegralizacoes">
				
				<?php require $siopm->getForm('ativos.integralizacoes.list'); ?>

			</spam>

			<hr>	


			<div class="control-group in-line pull-right" >
				<label class="control-label" for="AtivoVolume">Volume</label>
				<div class="controls">
					<input class="span3 moeda campo-formatado"   disable="disable" type="text" id="AtivoVolume" name="AtivoVolume"
					 value='<?php echo (isset($somatorio["AtivoVolume"])) ? PPOEntity::toMoneyOitoCasasDecimais($somatorio["AtivoVolume"]) : ""; ?>'></input>
				</div>
			</div>

			<div class="control-group in-line pull-right" >
				<label class="control-label" for="Ativomedia">Valor Unitário Médio</label>
				<div class="controls">
					<input class="span3 moeda campo-formatado" disable="disable" type="text" id="Ativomedia" name="Ativomedia" 
					value = '<?php echo (isset($somatorio["media"])) ? PPOEntity::toMoneyOitoCasasDecimais($somatorio["media"]) : ""; ?>' ></input>
				</div>
			</div>

			<!-- O campo de volume é meramente informativo, sendo calculado pela multiplicação dos campos Quantidade e Valor Nominal Unitário. -->
			
			<div class="control-group in-line pull-right "  >
				<label class="control-label" for="AtivoQuantidade">Quantidade Total</label>
				<div class="controls">
					<input class="span3 numero campo-formatado"  disable="disable" type="text" id="AtivoQuantidade" name="AtivoQuantidade" value = '<?php echo (isset($somatorio["AtivoQuantidade"])) ? $somatorio["AtivoQuantidade"] : ""; ?>' ></input>
				</div>
			</div>

		</div>
		

	</form>	
		
	</div>


	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary hide well">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" aria-hidden="true" >Sair</button>
	</div>

</div>

