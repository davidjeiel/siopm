<table id="lista_ativos_saldos" class="table table-striped table-temp-hover table-condensed">
	<thead>
		<tr>
			<th>Posição</th>
			<th class="right">Saldo &nbsp;</th>
			<th class="right">Taxa de Risco Provisionada &nbsp;</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($listasaldos as $saldos) { ?>
	<?php 

		$display_id			= htmlspecialchars($saldos['SaldoID'], ENT_QUOTES);
		$display_id_ativo	= htmlspecialchars($saldos['AtivoID'], ENT_QUOTES);
	?>
		<tr class="saldo_<?php echo $display_id; ?>"
			data-saldoid="<?php echo $display_id ?>"
			data-ativoid="<?php echo $display_id_ativo ?>"
		>
			<td class="saldo_data"><?php echo PPOEntity::toDateBr($saldos['SaldoData'], "d/m/Y"); ?></td>
			<td class="right saldo_valor"><?php echo  "R$ ". PPOEntity::toMoneyBr($saldos['SaldoValor']); ?></td>
			<td class="right provisao_taxa_risco"><?php echo  "R$ ".  PPOEntity::toMoneyBr($saldos['ProvisaoTaxaRisco']); ?></td>
			<td>
				<?php	
					if (user_has_access("CRI_EVENTOS_SALDOS_EDITAR"))echo TAG_A_EDITAR;
					if (user_has_access("CRI_EVENTOS_SALDOS_EXCLUIR"))echo TAG_A_EXCLUIR;
				?>
			</td>
		</tr>

	<?php }; ?>

	</tbody>
</table>