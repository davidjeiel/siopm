<table id="lista_ativos_juros" class="table table-striped table-temp-hover table-condensed">
	<thead>
		<tr>
			<th>Data Inicial de Vigência</th>
			<th>Data Final de Vigência</th>
			<th>Taxa Nominal</th>
			<th>Taxa Efetiva</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($listajuros as $juros) { ?>
	<?php 

		$display_id 		  = htmlspecialchars($juros['JurosID'], ENT_QUOTES);
		$display_id_ativo	  = htmlspecialchars($juros['AtivoID'], ENT_QUOTES);
	?>
		<tr class="juros_<?php echo $display_id; ?>"
		    data-jurosid="<?php echo $display_id ?>"
		    data-ativoid="<?php echo $display_id_ativo ?>"
		>
			<td class="data_inicial"><?php echo PPOEntity::toDateBr($juros['JurosDataInicialVigencia'], "d/m/Y"); ?></td>
			<td class="data_final"><?php echo PPOEntity::toDateBr($juros['JurosDataFinalVigencia'], "d/m/Y"); ?></td>
			<td class="taxa_nominal"><?php echo  "% ". PPOEntity::toMoneyBr($juros['JurosTaxaNominal'], 6) ; ?></td>
			<td class="taxa_efetiva"><?php echo  "% ". PPOEntity::toMoneyBr($juros['JurosTaxaEfetiva'], 6); ?></td>
			<td>
				<?php	
						if (user_has_access("CRI_ATIVOS_JUROS"))echo TAG_A_EDITAR;					
						if (user_has_access("CRI_ATIVOS_JUROS_EXCLUIR"))echo TAG_A_EXCLUIR;
					?>
			</td>
		</tr>

	<?php }; ?>

	</tbody>
</table>