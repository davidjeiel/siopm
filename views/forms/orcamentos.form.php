<script type="text/javascript">
		
	$(document).ready(function() {

		maskFormBr();
		
		$('.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			if ($(this).data("startDate") != undefined) {
				config.startDate = $(this).data("startDate");
			}
			$(this).datepicker(config).on('changeDate', function(ev){
				$(this).datepicker('hide');
			});
		});

	});


	$("#dialog-manut-orcamento form").validate({
		rules: {
			OrcamentoAno: {required: true},
			OrcamentoDataIni: {required: true},
			OrcamentoDataFim: {required: true},
			OrcamentoSaldoInicial: {required: true},
			OrcamentoResolucao: {required: true}
		},
		messages: {
			OrcamentoAno: {required: 'Campo obrigatório'},
			OrcamentoDataIni: { required: 'Campo obrigatório'},
			OrcamentoDataFim: {required: 'Campo obrigatório'},
			OrcamentoSaldoInicial: { required: 'Campo obrigatório'},
			OrcamentoResolucao:  { required: 'Campo obrigatório'},
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

	#dialog-manut-orcamento {
		width: 790px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -412px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	    /*margin-top: -10px!important;*/
	}

	#dialog-manut-orcamento .modal-body{
		overflow: hidden;
	}

	#formOrcamentos.tab-content{
		height: 350px!important;		  
	}

	#dialog-manut-orcamento .input-append.date input{
		background:#FFF;
	}

	#dialog-manut-orcamento input{
		padding-right: 8px;
	}

	#dialog-manut-orcamento .date{
		margin-top: -25px;
	}

</style>


<div id="dialog-manut-orcamento" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut">Orçamento</h3>
	</div>
	
	<div class="modal-body">

		<form id='formOrcamentos' name='formOrcamentos'>	

			<fieldset>
				
				<legend><?php echo $subTitulo; ?> de Orçamento</legend>

				<input class="span3 gravar" type="hidden" id="OrcamentoID" name="OrcamentoID" value = '<?php echo (isset($arr["OrcamentoID"])) ? $arr["OrcamentoID"] : ""; ?>' />
				<input class="span3 gravar" type="hidden" id="OrcamentoTipoID" name="OrcamentoTipoID" value = '<?php echo (isset($arr["OrcamentoTipoID"])) ? $arr["OrcamentoTipoID"] : "1"; ?>'  /> 
				<input class="span3 gravar moeda campo-formatado" type="hidden" id="OrcamentoSaldoAtual" name="OrcamentoSaldoAtual" value = '<?php echo (isset($arr["OrcamentoSaldoAtual"])) ? PPOEntity::toMoneyBr($arr["OrcamentoSaldoAtual"]) : "0"; ?>'  />
				<input class="span3 gravar" type="hidden" id="OrcamentoAtivo" name="OrcamentoAtivo" value = '<?php echo (isset($arr["OrcamentoAtivo"])) ? $arr["OrcamentoAtivo"] : "1"; ?>'  />

				<div class="control-group in-line">
					<label for="OrcamentoAno">Ano</label>
					<input class="span3 campo-formatado inteiro" type="text"  maxlength="4" id="OrcamentoAno" name="OrcamentoAno" maxlenght="4" 
					value = '<?php echo (isset($arr["OrcamentoAno"])) ? $arr["OrcamentoAno"] : ""; ?>'  /> 
				</div>

				<div class="control-group in-line input-append date" id="dpOrcamentoDataIni" data-date="" data-date-format="dd/mm/yyyy">
					<label for="OrcamentoDataIni">Data Inicial</label>
					<input  style='width: 178px;' maxlength="16" type="text" id="OrcamentoDataIni" name="OrcamentoDataIni" readonly 
					value = '<?php echo (isset($arr["OrcamentoDataIni"])) ? PPOEntity::toDateBr($arr["OrcamentoDataIni"], "d/m/Y") : ""; ?>'  /> 
					<span class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group in-line input-append date" id="dpOrcamentoDataFim" data-date="" data-date-format="dd/mm/yyyy">
					<label for="OrcamentoDataFim">Data Final</label>
					<input  style='width: 178px;' maxlength="16" type="text" id="OrcamentoDataFim" name="OrcamentoDataFim" readonly 
					value = '<?php echo (isset($arr["OrcamentoDataFim"])) ? PPOEntity::toDateBr($arr["OrcamentoDataFim"], "d/m/Y") : ""; ?>'  /> 
					<span class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group in-line">
					<label for="OrcamentoSaldoInicial">Valor do Orçamento</label>
					<input class="span3 form-control moeda campo-formatado"  maxlength="24" type="text" id="OrcamentoSaldoInicial" name="OrcamentoSaldoInicial" maxlenght="5" value = '<?php echo (isset($arr["OrcamentoSaldoInicial"])) ? PPOEntity::toMoneyBr($arr["OrcamentoSaldoInicial"]) : ""; ?>'  /> 
				</div>	

				<div class="control-group in-line">
					<label for="OrcamentoResolucao">Resolução Orçamentária</label>
					<input class="span6 " type="text" id="OrcamentoResolucao"  maxlength="150" name="OrcamentoResolucao" maxlenght="5" value = '<?php echo (isset($arr["OrcamentoResolucao"])) ? $arr["OrcamentoResolucao"] : ""; ?>'  /> 
				</div>
				
			</fieldset>

		</form>
	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>