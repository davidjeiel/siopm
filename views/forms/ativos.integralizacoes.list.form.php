<table id="lista_integralizacoes" class="table table-striped table-temp-hover table-condensed">
	<thead>
		<tr>
			<th>Data da Integralização</th>
			<th class="right">Quantidade &nbsp;</th>
			<th class="right">Valor Nominal Unitário &nbsp;</th>
			<th class="right">Volume &nbsp;</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($listaintegralizacoes as $integralizacao) { ?>
	<?php 
		$display_id 			  = htmlspecialchars($integralizacao['IntegralizacaoID'], ENT_QUOTES);
		$display_id_ativo	  	  = htmlspecialchars($integralizacao['AtivoID'], ENT_QUOTES);
	?>
		<tr class="integralizacao_<?php echo $display_id; ?>"
		    data-integralizacaoid="<?php echo $display_id ?>"
		    data-ativoid="<?php echo $display_id_ativo ?>"
		>
			<td class="dataintegralizacao"><?php echo PPOEntity::toDateBr($integralizacao['IntegralizacaoData'], "d/m/Y"); ?></td>
			<td class="right quantidade" ><?php echo  PPOEntity::toMoneyOitoCasasDecimais($integralizacao['IntegralizacaoQuantidade']); ?></td>
			<td class="right valorunitario"><?php echo  "R$ ". PPOEntity::toMoneyOitoCasasDecimais($integralizacao['IntegralizacaoValorUnitario']); ?></td>
			<td class="right volume"><?php echo  "R$ ". PPOEntity::toMoneyOitoCasasDecimais($integralizacao['IntegralizacaoVolume']); ?></td>
			<td><?php
					if (user_has_access("CRI_ATIVOS_INTEGRALIZACAO"))echo TAG_A_EDITAR;
					if (user_has_access("CRI_ATIVOS_INTEGRALIZACAO_EXCLUIR"))echo TAG_A_EXCLUIR;
				?>
			</td>
		</tr>

	<?php }; ?>

	</tbody>
</table>