<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();
	
	$custom_head .= $siopm->getJS("views", "capturasaldomensal.js");
	
	ob_start(); // começamos a armazenar tudo no buffer
	
?>
	<div class='conteudo-capturar'>

		<h3>Controle de Captura de Saldos Contábeis Mensais- CRI</h3>

		<table id="lista_saldos" name="lista_saldos" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Data</th>				
				<th>Data da confirmação</th>					
				<th class='center'>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($listaSaldosMensaisCapturados as $saldocapturado) { ?>
					
			<tr class="capturadata_<?php echo PPOEntity::toDateBr($saldocapturado['Data'], "d/m/Y"); ?>"
				data-capturadata="<?php echo PPOEntity::toDateBr($saldocapturado['Data'], "d/m/Y"); ?>"				
			>
				<td><?php echo PPOEntity::toDateBr($saldocapturado['Data'], "d/m/Y"); ?></td>				
				<td><?php echo PPOEntity::toDateBr($saldocapturado['DataConciliacao'], "d/m/Y"); ?></td>					
				<td class="center">
					<?php 
					// if (user_has_access("CRI_ORCAMENTO_EDITAR")) 	echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
					if (empty($saldocapturado['DataConciliacao']) 
						//and !empty($saldocapturado['DataCaptura']) 
						and user_has_access("CRI_CAPTURA_CONCILIAR_VALORES_SALDO_MENSAL")) echo TAG_A_CONFIRMAR_CAPTURA; else echo TAG_I_CONFIRMAR_CAPTURA;	 		
					if (user_has_access("CRI_CAPTURA_SALDO_MENSAL_DETALHES"))	echo TAG_A_DETALHES; else echo TAG_I_DETALHES;
					if (user_has_access("CRI_CAPTURA_EVENTOS_EXCLUIR") and (!$saldocapturado["DataConciliacao"] > 0 )
						) echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR;
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
