<script type="text/javascript">
	$(document).ready(function() {
		$('table#lista_transacoes_view').dataTable({
			"oLanguage": {
				"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
				"sInfoThousands": "."
			},
			"sEmptyTable": "Nenhum registro encontrado.",
			"aoColumnDefs":[
				{ "sType": "date-br", "aTargets": [ 0 ] }, 
				{ "sType": "money-br", "aTargets": [ 1 ] },
				{ "sType": "money-br", "aTargets": [ 2 ] },
				{ "sType": "money-br", "aTargets": [ 3 ] },
				{ "sType": "money-br", "aTargets": [ 4 ] },
				{ "sType": "money-br", "aTargets": [ 5 ] },
				{ "sType": "money-br", "aTargets": [ 6 ] },
				{ "sType": "money-br", "aTargets": [ 7 ] },
				{ "sType": "money-br", "aTargets": [ 8 ] },
				{ "sType": "money-br", "aTargets": [ 9 ] },
				{ "sType": "money-br", "aTargets": [ 10 ] },
				{ "sType": "money-br", "aTargets": [ 11 ] }
			],
			"sDom": '<"top">rt<"bottom"iflp><"clear">',
			 "bPaginate": false,
			"sScrollY": "200px"
		});
	});
</script>

<style type="text/css">

	#dialog-ativos-transacoes-view {
		width: 1224px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -600px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	}

	#dialog-ativos-transacoes-view .modal-body{
		padding-left: 30px;
		overflow: auto;
		max-height: 700px;
	}

	.TransacaoData{
		text-align: center;
	}

	.EventoValor, .saldos, .SaldoDevedor{
		text-align: right;
		padding-right: 8px;
	}

</style>

<div id="dialog-ativos-transacoes-view" class = 'modal hide fade in'>

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
	
			<div id="div_lista" class='div_lista'>

				<div class='roll'>

					<table id="lista_transacoes_view" class="table table-temp-hover table-condensed">
						<thead>
							<tr>
								<th class="center" style="vertical-align: middle;">Data</th>

								<?php 
									$eventosTipos = $ativosTiposEventosTiposDAO->listAllEventosTiposCRI();
									$totalEventos = 0;
									foreach($eventosTipos as $eventotipo):
										$totalEventos++;
								?>
									<th class="center" style="vertical-align: middle;"><?php echo $eventotipo['EventoTipoNome']; ?></th>
								<?php 
									endforeach; 
								?>
								<th class="center" style="vertical-align: middle;">Juros + Taxa Risco</th>
								<th class="center" style="vertical-align: middle;">Total da Transação</th>
								<th class="center" style="vertical-align: middle;">Saldo Devedor</th>
							</tr>
						</thead> 
						<tbody>
							<?php 
								$TotalTransacao = 0.00;
								$SaldoDevedor = 0.00;
								$TotalTransacaoFinal = 0.00;
								
								if (isset($transacoes)) foreach($transacoes as $transacao): 
									$TotalJurosTaxaRisco = 0.00;
									$TransacaoID		= $transacao['TransacaoID'];
									$AtivoID			= $transacao['AtivoID'];
									$TransacaoData 		= $transacao['TransacaoData'];
									$SaldoDevedor		= $transacao['SaldoDevedor'];
									$TotalTransacao		= $transacao['TotalTransacao'];
									$TotalTransacaoFinal += $TotalTransacao;
								?>

								<tr class					= "transacao_<?php echo $TransacaoID ?>"
									data-ativoid			= "<?php echo $AtivoID ?>"
									data-transacaoid		= "<?php echo $TransacaoID ?>"
								><td class='TransacaoData alert-info center'> <?php echo PPOEntity::toDateBr($TransacaoData, "d/m/Y"); ?></td>
								
								<?php foreach($eventosTipos as $eventotipo): 

									$EventoValor = $eventosDAO->getEventoValorByTransacaoTipoEventoID($transacao['TransacaoID'], $eventotipo['EventoTipoID']); 
									//3 - Juros; 4 - Taxa Risco
									if ($eventotipo['EventoTipoID'] == 3) $TotalJurosTaxaRisco += $EventoValor;
									if ($eventotipo['EventoTipoID'] == 4) $TotalJurosTaxaRisco += $EventoValor;

								?>
									<td class='EventoValor alert-success right'> 
										<?php echo PPOEntity::toMoneyBr($EventoValor);?>
									</td>
								<?php endforeach; ?> 
									<td class='saldos alert-danger right'><?php echo PPOEntity::toMoneyBr($TotalJurosTaxaRisco); ?></td>
									<td class='saldos alert-info right'><?php echo PPOEntity::toMoneyBr($TotalTransacao); ?></td>
									<td class='saldos alert-info right'><?php echo PPOEntity::toMoneyBr($SaldoDevedor); ?></td>
								</tr>

							<?php endforeach; ?>
						</tbody>
					
					</table>
					<div class="control-group in-line pull-right" >
						<label class="control-label" for="TotSaldo">Último Saldo Devedor</label>
						<div class="controls">
							<input class="saldos span3 moeda campo-formatado" readonly type="text" 
								id="TotSaldo" name="TotSaldo" 
								value = '<?php echo PPOEntity::toMoneyBr($SaldoDevedor)?>' >
							</input>
						</div>
					</div>
					<div class="control-group in-line pull-right" >
						<label class="control-label" for="TotTransacoes">Total das Transações</label>
						<div class="controls">
							<input class="saldos span3 moeda campo-formatado" readonly type="text" 
								id="TotTransacoes" name="TotTransacoes"
								value='<?php echo PPOEntity::toMoneyBr($TotalTransacaoFinal)?>'>
							</input>
						</div>
					</div>
				</div>
			</div>
		</form>	
	</div>

	<div class="modal-footer">
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Fechar</button>
	</div>

</div>
