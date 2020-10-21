<style>

	#dialog-manut-fechamento-competencia {
		width: 750px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -402px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	    /*margin-top: -60px!important;*/
	}

	#dialog-manut-fechamento-competencia .modal-body{
		overflow: hidden;
		max-height: 800px;
		height: 510px;
	}

	.tab-content{
		padding-left: 10px;
		overflow:hidden;
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

	// $(document).ready(function() {
	// 	aplicaDataTableErros();
	// });

</script>

<div id="dialog-manut-fechamento-competencia" class="modal">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='formFecharCompetencia' name='formFecharCompetencia'>			

			<div class="control-group in-line">
				<label class="control-label" for="Competencia">Competência</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="Competencia" name="Competencia" value = '<?php echo (isset($fechamentoCompetencia["Competencia"])) ? $fechamentoCompetencia["Competencia"] : ""; ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
					<label class="control-label" for="Matricula">Matrícula</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="Matricula" name="Matricula" value = '<?php echo (isset($fechamentoCompetencia["Matricula"])) ? $fechamentoCompetencia["Matricula"] : ""; ?>' ></input>
						</div>
			</div>

			<div class="control-group in-line">
					<label class="control-label" for="DataFechamento">Data da Fechamento</label>
						<div class="controls">
							<input class="span3" readonly type="text" id="DataFechamento" name="DataFechamento" value = '<?php echo (isset($fechamentoCompetencia["DataFechamento"])) ? PPOEntity::toDateBr($fechamentoCompetencia["DataFechamento"], "d/m/Y") : ""; ?>' ></input>
						</div>
			</div>	

			<input type="hidden" id="ModalidadeID" name="ModalidadeID" 
				value='<?php echo (isset($fechamentoCompetencia["ModalidadeID"])) ? $fechamentoCompetencia["ModalidadeID"] : "1"; ?>' >
			</input>

			<spam id="spanListaAtivosTransacoes">
				
				<?php require $siopm->getForm('fechamento.competencia.list'); ?>

			</spam>	
		
		</form>
	
	</div>

	<div class="modal-footer">
		<button id="btn_finalizar" class="btn btn_finalizar btn-danger <?php //if($totalErros > 0 )echo "hide"; ?> ">Fechar</button>
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true">Sair</button>
	</div>

</div>

