
<?php $siopm->includeJS("views", "ativos.entidades.js"); ?>

<script type="text/javascript">

	$(document).ready(function() {

    	applyDataTableByID("lista_ativos_entidades", "150px");
	});

	$("#dialog-manut-ativo-entidades form").validate({
		  rules: {
		  	EntidadeID: {required: true},
		  	EntidadePapelID: {required: true}
		  },
		  messages: { 
		  	EntidadeID: {required: 'Campo obrigatório'},
		  	EntidadePapelID: { required: 'Campo obrigatório'}
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

	#dialog-manut-ativo-entidades {
		width: 1000px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	   /* margin-top: -60px!important;*/
	}

	#dialog-manut-ativo-entidades .modal-body{
		padding-bottom: 30px;
		overflow: hidden;
	}

	#camposentidades{
		border: 1px;
		border-color: #CCC;
	}

	#div_lista_ativos_entidades{
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

<div id="dialog-manut-ativo-entidades" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='entidades' name='entidades'>				

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

			<!-- Cabeçalho para mostrar informações do ativo financeiro-->	

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value='<?php echo (isset($ativoDadoBasico["AtivoID"])) ? $ativoDadoBasico["AtivoID"] : ""; ?>' >
			</input>			

			<div id="camposentidades" class="hide well">

				<input type="hidden" id="AtivoEntidadeID" name="AtivoEntidadeID" 
				value='<?php echo (isset($ativoEntidades["AtivoEntidadeID"])) ? $ativoEntidades["AtivoEntidadeID"] : ""; ?>' >
				</input>

				<div class="control-group in-line">
					<label class="control-label">Nome</label>
					<div class="control">
						<select class="span6" name="EntidadeID" id="EntidadeID">
						<option value="">Selecione</option>
							<?php $selected = ""; ?>
							<?php foreach($entidades as $row): ?>
								<?php 
									if (isset($row["EntidadeID"]) and (isset($ativoEntidades["EntidadeID"])) ){
										 if ($row["EntidadeID"] == $ativoEntidades["EntidadeID"]) 
												$selected = "selected = 'selected'"; else $selected="";
									} 
								?>
								<option value='<?php echo $row["EntidadeID"] ?>' ><?php echo $row["EntidadeNomeFantasia"]; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label">Papel (Emissão)</label>
					<div class="control">
						<select class="span5" name="EntidadePapelID" id="EntidadePapelID">
						<option value="">Selecione</option>
							<?php $selected = ""; ?>
							<?php foreach($entidadesPapeis as $row): ?>
								<?php 
									if (isset($row["EntidadePapelID"]) and (isset($ativoEntidades["EntidadePapelID"])) ){
										 if ($row["EntidadePapelID"] == $ativoEntidades["EntidadePapelID"]) 
												$selected = "selected = 'selected'"; else $selected="";
									} 
								?>
								<option value='<?php echo $row["EntidadePapelID"] ?>' ><?php echo $row["EntidadePapelNome"]; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>		

			</div>

		</form>		

		<div id="div_lista_ativos_entidades">

			<p><button class="btn_novo_entidade btn btn-primary" type="button">Nova Entidade</button></p>

			<spam id="spanListaConteudoEntidades">
				
				<?php require $siopm->getForm('ativos.entidades.list'); ?>

			</spam>	

		</div>
	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary hide well">Salvar Alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" aria-hidden="true" >Sair</button>
	</div>

</div>

