
<table id="lista_subscricoes" class="table table-striped table-temp-hover table-condensed">
	<thead>
		<tr>						
			<th>Data da Subscrição</th>
			<th class="right">Quantidade &nbsp;</th>
			<th class="right">Valor Nominal Unitário &nbsp;</th>
			<th class="right">Volume &nbsp;</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

<?php 

?>
	<?php foreach($listasubscricoes as $subscricao) { ?>
	<?php 
		$display_id 			  = htmlspecialchars($subscricao['SubscricoesID'], ENT_QUOTES);
		$display_id_ativo	  	  = htmlspecialchars($subscricao['AtivoID'], ENT_QUOTES);
	?>
		<tr class="subscricao_<?php echo $display_id; ?>"
		    data-subscricaoid="<?php echo $display_id ?>"
		    data-ativoid="<?php echo $display_id_ativo ?>"
		>						
			<td class="datasubscricao"><?php echo PPOEntity::toDateBr($subscricao['SubscricoesData'], "d/m/Y"); ?></td>
			<td class="right quantidade"><?php echo  PPOEntity::toMoneyBr($subscricao['SubscricoesQuantidade'], 8); ?></td>
			<td class="right valorunitario">R$ <?php echo PPOEntity::toMoneyOitoCasasDecimais($subscricao['SubscricoesValorUnitario']); ?></td>
			<td class="right volume">R$ <?php echo  PPOEntity::toMoneyOitoCasasDecimais($subscricao['SubscricoesVolume']); ?></td>
			<td>
				<?php	
					if (user_has_access("CRI_ATIVOS_SUBSCRICAO"))echo TAG_A_EDITAR;
					if (user_has_access("CRI_ATIVOS_INTEGRALIZACAO"))echo TAG_A_INTEGRALIZACAO;												
					if (user_has_access("CRI_ATIVOS_SUBSCRICAO_EXCLUIR"))echo TAG_A_EXCLUIR;
				?>
			</td>
		</tr>

	<?php }; ?>

	</tbody>
	
</table>