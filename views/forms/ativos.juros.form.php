<?php $siopm->includeJS("views", "ativos.juros.js"); ?>

<script type="text/javascript">

	$(document).ready(function() {


    	applyDataTableByID("lista_ativos_juros", "120px");
		
		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  
		});

		maskFormBr(2,6);		

	});


	$("#dialog-manut-ativo-juros form").validate({
	  rules: {
	  	JurosDataInicialVigencia: {required: true},
	  	JurosDataFinalVigencia: {required: true},
	  	JurosTaxaNominal: {required: true},
	  	JurosTaxaEfetiva: {required: true}
	  },
	  messages: { 
	  	JurosDataInicialVigencia: { required: 'Campo obrigatório'},
	  	JurosDataFinalVigencia: {required: 'Campo obrigatório'},
	  	JurosTaxaNominal: { required: 'Campo obrigatório'},
	  	JurosTaxaEfetiva: { required: 'Campo obrigatório'}
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

	#dialog-manut-ativo-juros {
		width: 1008px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	    /*margin-top: -60px!important;*/
	}

	#dialog-manut-ativo-juros .modal-body{
		padding-bottom: 30px;
		overflow: hidden;
	}

	#camposjuros{
		border: 1px;
		border-color: #CCC;
	}

	#div_lista_ativos_juros{
		height: 320px;
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

<div id="dialog-manut-ativo-juros" class="modal">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"> <?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='Juros' name='Juros'>	
		
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

			<div id="camposjuros" class="hide well">

				<input type="hidden" id="JurosID" name="JurosID" 
					value='<?php echo (isset($ativoJuros["JurosID"])) ? $ativoJuros["JurosID"] : ""; ?>' >
				</input>

				<div class="control-group in-line input-append date" id="dpJurosDataInicialVigencia" data-date="" data-date-format="dd/mm/yyyy">
					<label for="JurosDataInicialVigencia">Data Inicial de Vigência</label>
					<input  style='width: 178px;' maxlength="16" type="text" id="JurosDataInicialVigencia" name="JurosDataInicialVigencia"  
					value = '<?php echo (isset($ativoJuros["JurosDataInicialVigencia"])) ?  PPOEntity::toDateBr($ativoJuros["JurosDataInicialVigencia"], "d/m/Y") : ""; ?>'  /> 
					<span  class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group in-line input-append date" id="dpJurosDataFinalVigencia" data-date="" data-date-format="dd/mm/yyyy">
					<label for="JurosDataFinalVigencia">Data Final de Vigência</label>
					<input  style='width: 178px;' maxlength="16" type="text" id="JurosDataFinalVigencia" name="JurosDataFinalVigencia"  
					value = '<?php echo (isset($ativoJuros["JurosDataFinalVigencia"])) ?  PPOEntity::toDateBr($ativoJuros["JurosDataFinalVigencia"], "d/m/Y") : ""; ?>'  /> 
					<span  class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group in-line">
					<label class="control-label" for="JurosTaxaNominal">Taxa Nominal</label>
					<div class="controls">
						<input class="span3 campo-formatado porcentagem" type="text" id="JurosTaxaNominal" name="JurosTaxaNominal" value = '<?php echo (isset($ativoJuros["JurosTaxaNominal"])) ? $ativoJuros["JurosTaxaNominal"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="JurosTaxaEfetiva">Taxa Efetiva</label>
					<div class="controls">
						<input class="span3 campo-formatado porcentagem" type="text" id="JurosTaxaEfetiva" name="JurosTaxaEfetiva" value = '<?php echo (isset($ativoJuros["JurosTaxaEfetiva"])) ? $ativoJuros["JurosTaxaEfetiva"] : ""; ?>' ></input>
					</div>
				</div>

			</div>

		</form>		

		<div id="div_lista_ativos_juros">

			<p><button class="btn_novo_juro btn btn-primary" type="button">Novo Juro</button></p>


			<spam id="spanListaConteudo">
				
				<?php require $siopm->getForm('ativos.juros.list'); ?>

			</spam>	
	
		</div>
	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary hide well">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" aria-hidden="true" >Sair</button>	
	</div>

</div>

