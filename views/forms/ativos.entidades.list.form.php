<table id="lista_ativos_entidades" class="table table-striped table-temp-hover table-condensed">
	<thead>
		<tr>
			<th>CNPJ</th>
			<th>Nome</th>
			<th>Papel (Emissão)</th>						
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($listaentidades as $entidades) { ?>
	<?php 

		$display_id 			  	= htmlspecialchars($entidades['AtivoEntidadeID'], ENT_QUOTES);
		$display_id_ativo	  		= htmlspecialchars($entidades['AtivoID'], ENT_QUOTES);
		$display_id_entidadeid	  	= htmlspecialchars($entidades['EntidadeID'], ENT_QUOTES);
		$display_id_entidadepapelid	= htmlspecialchars($entidades['EntidadePapelID'], ENT_QUOTES);
		
	?>
		<tr class="ativoentidade_<?php echo $display_id; ?>"
		    data-ativoentidadeid="<?php echo $display_id ?>"
		    data-ativoid="<?php echo $display_id_ativo ?>"
		    data-entidadeid="<?php echo $display_id_entidadeid ?>"
		    data-entidadepapelid="<?php echo $display_id_entidadepapelid ?>"
		>
			<td><div class="entidadeCNPJ"><?php echo  $entidades['EntidadeCnpj']; ?></div></td>
			<td><div class="entidadenomefantasia"><?php echo  $entidades['EntidadeNomeFantasia']; ?></div></td>
			<td><div class="entidadepapelnome"><?php echo  $entidades['EntidadePapelNome']; ?></div></td>
			<td>
				<?php	
					if (user_has_access("CRI_ATIVOS_ENTIDADE"))echo TAG_A_EDITAR;														
					if (user_has_access("CRI_ATIVOS_ENTIDADE_EXCLUIR"))echo TAG_A_EXCLUIR;									
				?>
			</td>

		</tr> 

	<?php }; ?>

	</tbody>
</table>