<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();
	
	$custom_head .= $siopm->getJS("views", "orcamentos.js");
	
	ob_start(); // começamos a armazenar tudo no buffer
	
?>
	<div class='conteudo-orcamentos'>

		<h3>Orçamentos - CRI</h3>

		<?php if (user_has_access("CRI_ORCAMENTO_EDITAR")) { ?>
			<p><button class="btn_novo btn btn-primary" type="button">Novo Orçamento</button></p>
		<?php } ?>

		<table id="lista_orcamentos" name="lista_orcamentos" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Ano</th>
				<th>Resolução</th>
				<th>Início</th>
				<th>Fim</th>
				<th class='right'>Valor do Orçamento &nbsp;</th>
				<th class='right'>Aplicado &nbsp;</th>
				<th class='right'>Saldo &nbsp;</th> 
				<th class='center'>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($db_orcamentos_arr as $orcamento) { ?>
		<?php 

			$orcamentoid = $orcamento['OrcamentoID'];

		?>

			<tr class="orcamento_<?php echo $orcamentoid; ?>"
				data-orcamentoid="<?php echo $orcamentoid; ?>"
				data-orcamentoano="<?php echo $orcamento['OrcamentoAno'] ?>"
				data-totalsubscricao="<?php echo "R$ " . PPOEntity::toMoneyBr($orcamento['TotalSubscricao']); ?>"
				data-saldoorcamento="<?php echo "R$ " . PPOEntity::toMoneyBr($orcamento['SaldoOrcamento']); ?>"
			>

				<td>				<?php echo $orcamento['OrcamentoAno']; ?>											</td>
				<td width=350>				<?php echo $orcamento['OrcamentoResolucao']; ?>										</td>
				<td>				<?php echo  PPOEntity::toDateBr($orcamento['OrcamentoDataIni'], "d/m/Y"); ?>		</td>
				<td>				<?php echo  PPOEntity::toDateBr($orcamento['OrcamentoDataFim'], "d/m/Y"); ?>		</td>
				<td class='right'>	<?php echo "R$ " . PPOEntity::toMoneyBr($orcamento['OrcamentoSaldoInicial']); ?> 	</td>
				<td class='right'>	<?php echo "R$ " . PPOEntity::toMoneyBr($orcamento['TotalSubscricao']); ?>			</td>
				<td class='right'>	<?php echo "R$ " . PPOEntity::toMoneyBr($orcamento['SaldoOrcamento']); ?>			</td>
				<td class='center'>
					<?php 
					if (user_has_access("CRI_ORCAMENTO_EDITAR")) 		echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
					if (user_has_access("CRI_ORCAMENTO_DETALHES"))	echo TAG_A_DETALHES; else echo TAG_I_DETALHES;
					if (user_has_access("CRI_ORCAMENTO_EXCLUIR")) 		echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR;
					?>
					
				</td>

			</tr>

		<?php } ?>

		</tbody>
		</table>

	</div>

<?php

	$contents = ob_get_clean(); // Transferimos o buffer para a variável.
?>
