
<?php $siopm->includeJS("views", "ativos.finalizar.js"); ?>

<style>

	#dialog-manut-ativo-finalizar {
		width: 1000px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	  /*  margin-top: -60px!important;*/
	}

	#dialog-manut-ativo-finalizar .modal-body{
		padding-bottom: 30px;
		overflow: hidden;
		max-height: 500px;
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

<script type="text/javascript">

	$(document).ready(function() {
		aplicaDataTableErros();
	});

</script>

<div id="dialog-manut-ativo-finalizar" class="modal">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='formFinalizar' name='formFinalizar'>	

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
					<label class="control-label" for="AtivoDataFinalizacao">Data da Finalização</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="AtivoDataFinalizacao" name="AtivoDataFinalizacao" value = '<?php echo (isset($ativoDadoBasico["AtivoDataFinalizacao"])) ? PPOEntity::toDateBr($ativoDadoBasico["AtivoDataFinalizacao"], "d/m/Y") : ""; ?>' ></input>
						</div>
			</div>	

			<input type="hidden" id="AtivoID" name="AtivoID" 
				value='<?php echo (isset($ativoDadoBasico["AtivoID"])) ? $ativoDadoBasico["AtivoID"] : ""; ?>' >
			</input>


			<spam id="spanListaConteudoErros">
				
				<?php require $siopm->getForm('ativos.finalizar.list'); ?>

			</spam>	
		
		</form>
	
	</div>

	<div class="modal-footer">
		<button id="btn_finalizar" class="btn btn_finalizar btn-danger <?php if($totalErros > 0 )echo "hide"; ?> ">Finalizar</button>
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true">Sair</button>
	</div>

</div>

