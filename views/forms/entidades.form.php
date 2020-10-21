<script type="text/javascript">
	
$(document).ready(function() {

	$('#navCadEntidades a').click(function (e) {
    	e.preventDefault();
    	$(this).tab('show');
	});

	
	$('.date').each(function () {
		var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
		if ($(this).data("startDate") != undefined) {
			config.startDate = $(this).data("startDate");
		}
		$(this).datepicker(config).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});  
	});

	$("#dialog-manut-entidade form").validate({
	  rules: {
	  	EntidadeCnpj: {minlength: 14, required: true, cnpj: true},
	  	EntidadeTipoID: {required: true},
	  	EntidadeNomeRazao: {minlength: 4, required: true},
	  	EntidadeNomeFantasia: {minlength: 4, required: true},
	  	EntidadeDataAbertura: {required: true}
	  },
	  messages: { 
	  	EntidadeCnpj: { required: 'Campo obrigatório',  minlength: 'Esse número requer 14 caracteres!', cnpj: 'CNPJ inválido'},
	  	EntidadeTipoID: {required: 'Campo obrigatório'},
	  	EntidadeNomeRazao: { required: 'Campo obrigatório',  minlength: 'Mínimo de 4 caracteres!' },
	  	EntidadeNomeFantasia: { required: 'Campo obrigatório',  minlength: 'Mínimo de 4 caracteres!' },
	  	EntidadeDataAbertura: { required: 'Campo obrigatório'},	  	
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
	        template: "<div style='z-index:1043'  class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content alert-error\"><p></p></div></div></div>"
	      });
	      _popover.data("popover").options.content = value.message;
	      return $(value.element).popover("show");
	    });
	  }
	});

	$("#EntidadeCnpj").mask("99.999.999/9999-99");
	$("#EntidadeCEP").mask("99999-999");
	$("#MatriculaCOP").mask("99999-9");
	//$("#EntidadeFones").mask("(99)9999-9999?9");
	//$("#EntidadeResponsavelFones").mask("(99)?9999-9999?9");
	
	$(".fone").focusout(function(){
	    var phone, element;
	    element = $(this);
	    element.unmask();
	    phone = element.val().replace(/\D/g, '');
	    if(phone.length > 10) {
	        element.mask("(99) 99999-999?9");
	    } else {
	        element.mask("(99) 9999-9999?9");
	    }
	}).trigger('focusout');

});

$(document).on("blur", "#EntidadeNomeRazao", function() {
	if ($('#EntidadeNomeFantasia').val() == "") {
		$('#EntidadeNomeFantasia').val($(this).val());
	}
 }
);

</script> 

<style>

	#dialog-manut-entidade {
		width: 1024px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	    /*margin-top: -60px!important;*/
	}

	#dialog-manut-entidade .modal-body{
		max-height: 550px;
		height: 510px;
		overflow: hidden;
	}

	#formEntidades.tab-content{
		height: 350px!important;		  
	}

</style>


<div id="dialog-manut-entidade" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut">Entidades - <?php echo $titulo_form; ?> </h3>
	</div>
	
	<div class="modal-body">

		<form id='formEntidades' name='formEntidades' >	

			<fieldset>

				<input class="span6 gravar" type="hidden" id="EntidadeID" name="EntidadeID" value = '<?php echo (isset($arr["EntidadeID"])) ? $arr["EntidadeID"] : ""; ?>' />
				<input class="span3 gravar" type="hidden" id="EntidadeMatriculaCadastro" name="EntidadeMatriculaCadastro" value = '<?php echo (isset($arr["EntidadeMatriculaCadastro"])) ? $arr["EntidadeMatriculaCadastro"] : ""; ?>'  /> 
				<input class="span3 gravar" type="hidden" id="EntidadeDataCadastro" name="EntidadeDataCadastro" value = '<?php echo (isset($arr["EntidadeDataCadastro"])) ? $arr["EntidadeDataCadastro"] : ""; ?>'  /> 
				<input class="span3 gravar" type="hidden" id="EntidadeDataUltimaAlteracao" name="EntidadeDataUltimaAlteracao" value = '<?php echo (isset($arr["EntidadeDataUltimaAlteracao"])) ? $arr["EntidadeDataUltimaAlteracao"] : ""; ?>'  /> 
				<input class="span3 gravar" type="hidden" id="EntidadeAtiva" name="EntidadeAtiva" value = "1"  /> 
								
				<div class="control-group span4">
					<label for="EntidadeCnpj">CNPJ</label>
					<input class="span4 " type="text" id="EntidadeCnpj" name="EntidadeCnpj"  
					value = '<?php echo (isset($arr["EntidadeCnpj"])) ? $arr["EntidadeCnpj"] : ""; ?>'  /> 
				</div>

				<div class="control-group span4">
					<label for="MatriculaCOP">Matrícula COP</label>
					<input class="span4 " type="text" id="MatriculaCOP" name="MatriculaCOP" maxlength="7" 
						value = '<?php echo (isset($arr["MatriculaCOP"])) ? $arr["MatriculaCOP"] : ""; ?>'  /> 
				</div>

				<div class="control-group span4">

					<label class="control-label">Tipo de Entidade</label>

					<select class="gravar span4" name="EntidadeTipoID" id="EntidadeTipoID" >
						<option value="">Selecione</option>
				   		<?php $selected = ""; ?>
				   		<?php foreach($arr_tipo_entidades as $row){ ?>
				   			<?php 
					   			if (isset($arr["EntidadeTipoID"]) and isset($arr["EntidadeTipoID"])){
					   				 if ($row["EntidadeTipoID"] == $arr["EntidadeTipoID"]) 
					   				 		$selected = "selected = 'selected'"; else $selected="";
					   			} 
				   			?>
				    		<option <?php echo $selected; ?> value='<?php echo $row["EntidadeTipoID"] ?>' ><?php echo $row["EntidadeTipoDescricao"]; ?> </option>
				    	<?php }; ?>
					</select>
					
				</div>

				<div class="control-group span6">
					<label for="EntidadeNomeRazao">Razão Social</label>
					<input class="span6 " maxlength="80" type="text" id="EntidadeNomeRazao" name="EntidadeNomeRazao"  
					value = '<?php echo (isset($arr["EntidadeNomeRazao"])) ? $arr["EntidadeNomeRazao"] : ""; ?>'  /> 
				</div>

				<div class="control-group span6">
					<label for="EntidadeNomeFantasia">Nome de Fantasia ou Nome Abreviado</label>
					<input class="span6 " maxlength="80"  type="text" id="EntidadeNomeFantasia" name="EntidadeNomeFantasia" 
						value = '<?php echo (isset($arr["EntidadeNomeFantasia"])) ? $arr["EntidadeNomeFantasia"] : ""; ?>'  /> 
				</div>

				<div class="control-group span3 input-append date" id="dpDataAbertura" data-date="" data-date-format="dd/mm/yyyy">
					<label for="EntidadeDataAbertura">Data Abertura</label>
					<input  style='width: 178px;' maxlength="16" type="text" id="EntidadeDataAbertura" name="EntidadeDataAbertura" readonly 
					value = '<?php echo (isset($arr["EntidadeDataAbertura"])) ? PPOEntity::toDateBr($arr["EntidadeDataAbertura"], "d/m/Y") : ""; ?>'  /> 
					<span  class="add-on"><i class="icon-th"></i></span>
				</div> 

				<div class="control-group span9">
					<label for="EntidadeObs">Obs</label>
					<input class="span9" type="text" id="EntidadeObs" name="EntidadeObs" maxlength="100" value = '<?php echo (isset($arr["EntidadeObs"])) ? $arr["EntidadeObs"] : ""; ?>'  /> 
				</div>	

				<ul class="nav nav-tabs" id="navCadEntidades">
					<li class="active"><a href="#tabEntidade"		>Endereço</a></li>
					<li				  ><a href="#tabResponsavel"	>Dados do Responsável</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active fade in" id='tabEntidade'>
						
						<div class="control-group span3">
							<label for="EntidadeFones">Telefone</label>
							<input class="span3 fone" maxlength="16" type="text" id="EntidadeFones" name="EntidadeFones" value = '<?php echo (isset($arr["EntidadeFones"])) ? $arr["EntidadeFones"] : ""; ?>'  /> 
						</div>

						<div class="control-group span6">
							<label for="EntidadeEmail">Email</label>
							<input class="span6 " maxlength="50" type="text" id="EntidadeEmail" name="EntidadeEmail" value = '<?php echo (isset($arr["EntidadeEmail"])) ? $arr["EntidadeEmail"] : ""; ?>'  /> 
						</div>

						<div class="control-group span3">
							<label for="EntidadeCEP">CEP</label>
							<input class="span3 " maxlength="11" type="text" id="EntidadeCEP" name="EntidadeCEP" 
							value = '<?php echo (isset($arr["EntidadeCEP"])) ? $arr["EntidadeCEP"] : ""; ?>'  /> 
						</div>

						<div class="control-group span6">
							<label for="EntidadeLogradouro">Logradouro</label>
							<input class="span6 gravar" maxlength="50" type="text" id="EntidadeLogradouro" name="EntidadeLogradouro" value = '<?php echo (isset($arr["EntidadeLogradouro"])) ? $arr["EntidadeLogradouro"] : ""; ?>'  /> 
						</div>

						<div class="control-group span3">
							<label for="EntidadeNumero">Número</label>
							<input class="span3 " type="text" maxlength="10" id="EntidadeNumero" name="EntidadeNumero" value = '<?php echo (isset($arr["EntidadeNumero"])) ? $arr["EntidadeNumero"] : ""; ?>'  /> 
						</div>

						<div class="control-group span3">
							<label for="EntidadeComplemento">Complemento</label>
							<input class="span3 " type="text" maxlength="30" id="EntidadeComplemento" name="EntidadeComplemento" value = '<?php echo (isset($arr["EntidadeComplemento"])) ? $arr["EntidadeComplemento"] : ""; ?>'  /> 
						</div>

						<div class="control-group span3">
							<label for="EntidadeBairro">Bairro</label>
							<input class="span3 " type="text" maxlength="30" id="EntidadeBairro" name="EntidadeBairro" value = '<?php echo (isset($arr["EntidadeBairro"])) ? $arr["EntidadeBairro"] : ""; ?>'  /> 
						</div>

						<div class="control-group span3">
							<label for="EntidadeCidade">Cidade</label>
							<input class="span3 " type="text" maxlength="30" id="EntidadeCidade" name="EntidadeCidade" value = '<?php echo (isset($arr["EntidadeCidade"])) ? $arr["EntidadeCidade"] : ""; ?>'  /> 
						</div>

						<div class="control-group span3">

							<label class="control-label">Unidade da Federação</label>

							<select class="gravar span3" name="EntidadeUF" id="EntidadeUF" >
						    	<option value="">Selecione</option>
						   		<?php $selected = ""; ?>
						   		<?php foreach($unidadesFederacao as $row){ ?>
						   			<?php 
							   			if (isset($row["UnidadeFederacaoSigla"]) and isset($arr["EntidadeUF"])){
							   				 if (trim($row["UnidadeFederacaoSigla"]) == trim($arr["EntidadeUF"]))
							   				 		$selected = "selected = 'selected'"; else $selected=" ";
							   			} 
						   			?>
						    		<option <?php echo $selected; ?> value='<?php echo $row["UnidadeFederacaoSigla"] ?>' ><?php echo $row["UnidadeFederacaoSigla"] . " - " . $row["UnidadeFederacaoNome"]; ?> </option>
						    	<?php }; ?>
							</select>
						
						</div>
			
					</div> <!-- FIM tabEntidade -->

					<div class="tab-pane fade" id='tabResponsavel'>

						<div class="control-group span12">
							<label for="EntidadeResponsavel">Responsável</label>
							<input class="span6 gravar" type="text" maxlength="50" id="EntidadeResponsavel" name="EntidadeResponsavel" value = '<?php echo (isset($arr["EntidadeResponsavel"])) ? $arr["EntidadeResponsavel"] : ""; ?>'  /> 
						</div>

						<div class="control-group span12">
							<label for="EntidadeResponsavelFones">Telefone do Responsável</label>
							<input class="span6 gravar fone" type="text" maxlength="16" id="EntidadeResponsavelFones" name="EntidadeResponsavelFones" value = '<?php echo (isset($arr["EntidadeResponsavelFones"])) ? $arr["EntidadeResponsavelFones"] : ""; ?>'  /> 
						</div>

						<div class="control-group span12">
							<label for="EntidadeResponsavelEmail">Email do Responsável</label>
							<input class="span6 gravar" type="text" maxlength="50" id="EntidadeResponsavelEmail" name="EntidadeResponsavelEmail" value = '<?php echo (isset($arr["EntidadeResponsavelEmail"])) ? $arr["EntidadeResponsavelEmail"] : ""; ?>'  /> 
						</div>

					</div> <!-- FIM tabResponsavel -->

				</div> <!-- FIM tab-content -->
					
			</fieldset>

		</form>
	</div>
	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>



