<?php

	// Configurações do document_top
	$title = $siopm->getTitle();
	$custom_head .= $siopm->getJS("views", "habilitacao.js");
	$custom_head .= $siopm->getJS("views", "entidades.contatos.js");

	ob_start();
?>  

	<h3>Habilitações - Entidades</h3>

	<?php if (user_has_access("HABILITACAO_EDITAR")) { ?>
		<p><button class="btn_nova_habilitacao btn btn-primary" type="button">Nova Habilitação</button></p>
	<?php } ?>

	<table id="lista_habilitacoes" class="table table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Entidade</th>
				<th>Tipo de Agente</th>
				<th>GIFUG</th>
				<th>UF</th>
				<th>Finalização</th>
				<th>Validade</th>
				<th>Status</th>
				<th>Rating</th>
				<th class='center'>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($habilitacoes as $habilitacao): ?>

			<?php 

				$HabilitacaoID				= htmlspecialchars($habilitacao['HabilitacaoID'], ENT_QUOTES);
				$HabilitacaoConclusaoID 	= htmlspecialchars($habilitacao['HabilitacaoConclusaoID'], ENT_QUOTES);
				$EntidadeCnpj				= htmlspecialchars($habilitacao['EntidadeCnpj'], ENT_QUOTES);
				$EntidadeID					= htmlspecialchars($habilitacao['EntidadeID'], ENT_QUOTES);
				$EntidadeNomeFantasia		= htmlspecialchars($habilitacao['EntidadeNomeFantasia'], ENT_QUOTES);//htmlspecialchars($habilitacao['EntidadeNomeRazao'], ENT_QUOTES, 'UTF_8');
				$EntidadeTipoID				= htmlspecialchars($habilitacao['EntidadeTipoID'], ENT_QUOTES);
				$EntidadeTipoDescricao		= htmlspecialchars($habilitacao['EntidadeTipoDescricao'], ENT_QUOTES);
				$UnidadeSigla				= htmlspecialchars($habilitacao['UnidadeSigla'], ENT_QUOTES);
				$EntidadeUF 				= htmlspecialchars($habilitacao['EntidadeUF'], ENT_QUOTES);
				$HabilitacaoDataFinalizacao	= htmlspecialchars($habilitacao['HabilitacaoDataFinalizacao'], ENT_QUOTES);
				$HabilitacaoValidade 		= htmlspecialchars($habilitacao['HabilitacaoValidade'], ENT_QUOTES);
				$HabilitacaoRating			= htmlspecialchars($habilitacao['HabilitacaoRating'], ENT_QUOTES);

				$finalizada = true;
				$statusHabilitacao = "";
				$classe = "";

				switch ($HabilitacaoConclusaoID) {

					case 1:
						$statusHabilitacao = "<div style='color:#ff8a00;'>Em Atualização</div>";
						$classe = "alert";
						$finalizada = false;
						break;

					case 2:
					case 3:
						if (date('Y-m-d') <= PPOEntity::toDateUnicode($HabilitacaoValidade) ){
							$statusHabilitacao = "<div style='color:#279d27;'>Vigente</div>";
							$classe = "alert-success";
						}else{
							$statusHabilitacao = "<div style='color:#ff0a2d;'>Vencida</div>";
							$classe = "alert-error";
						}
						break;

					case 4:
						$statusHabilitacao = "<div style='color:#ff0a2d;'>Negada</div>";
						$classe = "alert-error";
						break;
					case 5:
						$statusHabilitacao = "<div style='color:#ff0a2d;'>Desistência</div>";
						$classe = "alert-error";
						break;

				}

			?> 

			<tr class="habilitacao_<?php echo $HabilitacaoID . ' ' . $classe ?>"  
				data-habilitacaoid = "<?php echo $HabilitacaoID; ?>" 
				data-entidadeid = "<?php echo $EntidadeID; ?>" 
				data-entidadetipoid = "<?php echo $EntidadeTipoID; ?>"
				data-entidadenomerazao = "<?php echo $EntidadeNomeFantasia; ?>" 
				data-habilitacaovalidade = "<?php echo $HabilitacaoValidade; ?>" >
				
				<td><div class='habilitacao-EntidadeNomeFantasia'>		<?php echo $EntidadeNomeFantasia; ?> 	</div></td>
				<td><div class='habilitacao-EntidadeTipoDescricao'>		<?php echo $EntidadeTipoDescricao; ?>	</div></td>
				<td><div class='habilitacao-UnidadeSigla'>				<?php echo $UnidadeSigla; ?>			</div></td>
				<td><div class='habilitacao-EntidadeUF'>				<?php echo $EntidadeUF; ?>				</div></td>
				<td><div class='habilitacao-HabilitacaoDataFinalizacao'><?php echo PPOEntity::toDateBr($HabilitacaoDataFinalizacao, "d/m/Y"); ?></div></td>
				<td><div class='habilitacao-HabilitacaoValidade'>		<?php echo PPOEntity::toDateBr($HabilitacaoValidade, "d/m/Y"); ?>		</div></td>
				<td><div class='habilitacao-statusHabilitacao'>			<?php echo $statusHabilitacao; ?>		</div></td>
				<td><div class='habilitacao-HabilitacaoRating'>			<?php echo $HabilitacaoRating; ?>		</div></td>
	
				<td class='center'>

					<?php 
						if (user_has_access("HABILITACAO_VISUALIZAR"))echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
						if (user_has_access("HABILITACAO_HISTORICO"))echo TAG_A_HISTORICO; else echo TAG_I_HISTORICO;
						if (user_has_access("HABILITACAO_CONTATO"))echo TAG_A_CONTATOS; else echo TAG_I_CONTATOS;
						if (!$finalizada || user_has_access("HABILITACAO_EDITAR_FINALIZADA")) {
							if (user_has_access("HABILITACAO_EDITAR")) echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
							if (user_has_access("HABILITACAO_FINALIZAR")) echo TAG_A_FINALIZAR; else echo TAG_I_FINALIZAR;
							if (user_has_access("HABILITACAO_EXCLUIR")) echo TAG_A_EXCLUIR;  else echo TAG_I_EXCLUIR;
						}else{
							echo TAG_I_EDITAR;
							echo TAG_I_FINALIZAR;
							echo TAG_I_EXCLUIR;
						}
					?>

				</td>

			</tr>

		<?php endforeach; ?>

		</tbody>

	</table>

	<span id="spanFormHistorico">  </span>

<?php

	$contents = ob_get_clean(); // transferimos o buffer para a variável
	
?>

