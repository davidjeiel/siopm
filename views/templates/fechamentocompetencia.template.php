<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();
	
	$custom_head .= $siopm->getJS("views", "fechamentocompetencia.js");
	
	ob_start(); // começamos a armazenar tudo no buffer
	
?>
	<div class='conteudo-fechamentocompetencia'>

		<h3>Fechamento de Competências para Inclusão de Eventos - CRI</h3>

		<?php if (user_has_access("CRI_FECHAMENTO_COMPETENCIA_EDITAR")) { ?>
			<p><button class="btn_fechar btn btn-primary" type="button">Fechar competência</button></p>
		<?php } ?>

		<table id="lista_competencias" name="lista_competencias" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Competencia</th>
				<th>Matricula</th>
				<th>Data</th>				
				<th class='center'>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($listacompetencias as $competencia) { ?>
		<?php 

			$competenciafechadaid = $competencia['ID'];

		?>

			<tr class="competenciafechada_<?php echo $competenciafechadaid; ?>"
				data-competenciafechadaid="<?php echo $competenciafechadaid; ?>"				
			>			
				<td><?php echo PPOEntity::toDateBr($competencia['Competencia'], "m/Y"); ?></td>
				<td><?php echo $competencia['Matricula']; ?></td>
				<td><?php echo PPOEntity::toDateBr($competencia['DataFechamento'], "d/m/Y"); ?></td>	
								
				<td class="center">
					<?php 								
					if (user_has_access("CRI_FECHAMENTO_COMPETENCIA_VISUALIZAR"))	echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;					
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
