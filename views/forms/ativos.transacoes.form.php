<script type="text/javascript">

	$(document).ready(function() {
		applicaDataTableTransacoesForm();
	});

	$(document).off("click", "table#lista_transacoes tbody tr td a.editar");
	$(document).on("click", "table#lista_transacoes tbody tr td a.editar", function() {
		var AtivoID = $(this).closest("tr").data('ativoid');
		var TransacaoID = $(this).closest("tr").data('transacaoid');
		editarEventos(AtivoID, TransacaoID);
	});

	$(document).off("click", "#dialog-ativos-transacoes button.novo");
	$(document).on("click", "#dialog-ativos-transacoes button.novo", function() {
		var AtivoID = $("#AtivoID").val();
		editarEventos(AtivoID, "");
	});
	
	$(document).off("click", "table#lista_transacoes tbody tr td a.excluir");
	$(document).on("click", "table#lista_transacoes tbody tr td a.excluir", function() {
		var TransacaoID = $(this).closest("tr").data('transacaoid');
		var TransacaoData = $(this).closest("tr").find('.TransacaoData').text();

		$("#dialog-ativos-transacoes").css("opacity" , 0.33);

		bootbox.confirm("Tem certeza que deseja excluir a transação do dia <b>" + TransacaoData + "</b>?", 
		function(confirmou) { 
			if (confirmou) {
				excluirEventos(TransacaoID);
			}
			$("#dialog-ativos-transacoes").css("opacity" , 1);
		});

		
	});



</script>
<style type="text/css">

	#dialog-ativos-transacoes {
		width: 775px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -400px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	}

	#dialog-ativos-transacoes .modal-body{
		padding-left: 30px;
		overflow: auto;
		max-height: 500px;
	}


</style>

<div id="dialog-ativos-transacoes" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>

	<div class="modal-body">

		<form id='formTransacao' name='formTransacao'>

			<input type="hidden" id="AtivoID" name="AtivoID" value = '<?php echo (isset($ativo["AtivoID"])) ? $ativo["AtivoID"] : ""; ?>' ></input>

			<div class='controls'>

				<div class="control-group in-line">
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

			</div> 
	
			<?php 
				if (user_has_access("CRI_EVENTOS_TRANSACOES_EDITAR")) { ?>
					<p><button class="novo btn btn-primary" type="button">Nova Transação</button></p>
			<?php } ?>
			
			<span id='spanListaTransacoes'>
				<?php require $siopm->getForm('ativos.transacoes.table'); ?>
			</span>

		</form>	
	</div>

	<div class="modal-footer">
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Fechar</button>
	</div>

</div>
