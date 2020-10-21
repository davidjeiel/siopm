<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();
	$custom_head .= $siopm->getJS("views", "entidades.js");
	$custom_head .= $siopm->getJS("views", "entidades.contatos.js");
	ob_start(); // começamos a armazenar tudo no buffer
	
?>

	<div class='conteudo-entidade'>

		<h3>Manutenção de Entidades</h3>

		<?php if (user_has_access("CADASTRO_ENTIDADE_EDITAR")) { ?>
			<p><button class="btn_novo btn btn-primary" type="button">Nova Entidade</button></p>
		<?php } ?>

		<table id="lista_entidades" name="lista_entidades" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>CNPJ</th>
				<th>Tipo</th> 
				<th>Entidade</th>
				<th>Data Abertura</th>
				<th>Fones</th>
				<th class="center">Ações</th>
		  	</tr>
		</thead>
		<tbody>
	
		<?php foreach($db_entidades_arr as $entidade) { ?>

			<?php 

				$display_id 			= htmlspecialchars($entidade['EntidadeID'], ENT_QUOTES);
				$display_cnpj 			= htmlspecialchars($entidade['EntidadeCnpj'], ENT_QUOTES);
				$display_tipo_id 		= htmlspecialchars($entidade['EntidadeTipoID'], ENT_QUOTES);
				$display_tipo_descricao	= htmlspecialchars($entidade['EntidadeTipoDescricao'], ENT_QUOTES);
				$display_nome 			= htmlspecialchars($entidade['EntidadeNomeFantasia'], ENT_QUOTES);
				$display_data_abertura 	= htmlspecialchars($entidade['EntidadeDataAbertura'], ENT_QUOTES);
				$display_fones 			= htmlspecialchars($entidade['EntidadeFones'], ENT_QUOTES);
				
			?>

			<tr class="entidade_<?php echo $display_id; ?>" 
				data-cnpj = "<?php echo $display_cnpj; ?>" 
				data-nome = "<?php echo $display_nome; ?>" 
				data-entidadeid = "<?php echo $display_id; ?>" >
				<td><div class="entidadecnpj"><?php echo $display_cnpj; ?></div></td>
				<td><div class="entidadetipodescricao"><?php echo $display_tipo_descricao; ?></div></td>
				<td><div class="entidadenome"><?php echo $display_nome; ?></div></td>
				<td><div class="entidadedataabertura"><?php echo PPOEntity::toDateBr($display_data_abertura, "d/m/Y"); ?></div></td>
				<td><div class="entidadefones"><?php echo $display_fones; ?></div></td>
				<td class='acoes center'>

					<?php 
					if (user_has_access("CADASTRO_ENTIDADE_VISUALIZAR")) echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
					if (user_has_access("CADASTRO_ENTIDADE_EDITAR")) echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
					if (user_has_access("CADASTRO_ENTIDADE_CONTATOS")) echo TAG_A_CONTATOS; else echo TAG_I_CONTATOS;
					if (user_has_access("CADASTRO_ENTIDADE_EXCLUIR")) echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR;
					?>
				</td>

			</tr>

		<?php } ?>

		</tbody>
		</table>

	</div>

<?php

	$contents = ob_get_clean(); // transferimos o buffer para a variável

?>

