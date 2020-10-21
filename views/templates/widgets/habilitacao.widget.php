

<div class='widget-grande'>
	<h4 class='titulo'>Habilitações</h4>
	<div class='scroll'>
		<table id="lista_habilitacoes" class="table table-temp-hover table-condensed ">
			<thead>
				<tr>
					<th>Entidade</th>
					<th>Validade</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach($habilitacoes as $habilitacao): ?>

					<?php 
						$EntidadeNomeFantasia		= htmlspecialchars($habilitacao['EntidadeNomeFantasia'], ENT_QUOTES);
						$HabilitacaoValidade 		= htmlspecialchars($habilitacao['HabilitacaoValidade'], ENT_QUOTES);
						$HabilitacaoConclusaoID 	= htmlspecialchars($habilitacao['HabilitacaoConclusaoID'], ENT_QUOTES);
						$finalizada = true;
						$statusHabilitacao = "";

						switch ($HabilitacaoConclusaoID) {

							case 1:
								$statusHabilitacao = "<div style='color:#ff8a00;'>Em Atualização</div>";
								$finalizada = false;
								break;

							case 2:
							case 3:
								if (date('Y-m-d') <= PPOEntity::toDateUnicode($HabilitacaoValidade) ){
									$statusHabilitacao = "<div style='color:#279d27;'>Vigente</div>";
								}else{
									$statusHabilitacao = "<div style='color:#ff0a2d;'>Vencida</div>";
								}
								break;

							case 4:
								$statusHabilitacao = "<div style='color:#ff0a2d;'>Negada</div>";
								break;

						}

					?> 

					<tr>
						<td><div ><?php echo $EntidadeNomeFantasia; ?> 	</div></td>
						<td><div class='center'>		<?php echo PPOEntity::toDateBr($HabilitacaoValidade, "d/m/Y"); ?>		</div></td>
						<td><div class='pull-rigth'>			<?php echo $statusHabilitacao; ?>		</div></td>
					</tr>

				<?php endforeach; ?>
			
			</tbody>
		</table>
	</div>
</div>


	