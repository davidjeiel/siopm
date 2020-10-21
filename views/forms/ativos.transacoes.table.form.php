<div id="div_lista" class='div_lista'>

	<div class='roll'>

		<table id="lista_transacoes" class="table table-temp-hover table-condensed">
			<thead>
				<tr>
					<th>Data da Transação</th>
					<th class='right'>Total da Transação &nbsp;</th>
					<th class='right'>Saldo Devedor &nbsp;</th>
					<th class='center'>Ações</th>
				</tr>
			</thead> 
			<tbody>

				<?php 

					$TotalTransacao = 0.00;
					if (isset($transacoes)) foreach($transacoes as $transacao): 

				?>
					<?php 
						$TransacaoID		= $transacao['TransacaoID'];
						$AtivoID			= $transacao['AtivoID'];
						$TransacaoData 		= $transacao['TransacaoData'];
						$SaldoDevedor		= $transacao['SaldoDevedor'];
						$TotalTransacao		= $transacao['TotalTransacao'];
					?> 

					<tr class					= "transacao_<?php echo $TransacaoID ?>"
						data-ativoid			= "<?php echo $AtivoID ?>"
						data-transacaoid		= "<?php echo $TransacaoID ?>"
					>
						<td class="TransacaoData"><?php echo PPOEntity::toDateBr($TransacaoData, "d/m/Y"); ?></td>
						<td class='right'><?php echo  "R$ ". PPOEntity::toMoneyBr($TotalTransacao); ?></td>
						<td class='right'><?php echo  "R$ ". PPOEntity::toMoneyBr($SaldoDevedor); ?></td>
						<td class='center'>
							<?php 
								if (user_has_access("CRI_EVENTOS_TRANSACOES_EDITAR")) echo TAG_A_EDITAR;
								if (user_has_access("CRI_EVENTOS_TRANSACOES_EXCLUIR")) echo TAG_A_EXCLUIR;
							?>
						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>
			
		</table>
	</div>
</div>