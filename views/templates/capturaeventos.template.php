<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();
	
	$custom_head .= $siopm->getJS("views", "capturaeventos.js");
	
	ob_start(); // começamos a armazenar tudo no buffer
	
?>
	<div class='conteudo-capturar'>
	
		<h3>Controle de Captura de Eventos - CRI</h3>

		<?php if (user_has_access("CRI_CAPTURA_EVENTOS_IMPORTAR")) { ?>
			<p><button class="pull-left btn_importar btn btn-primary" type="button">Importar Arquivo</button></p>
		<?php } ?>
		
		<?php if ($_SERVER["SERVER_NAME"] != "siopm.caixa"){ ?>
			<p><button class=" btn_zerar btn btn-danger" type="button"> ZERAR DADOS GERADOS PELA CAPTURA </button></p>
		<?php } ?>


		<table id="lista_arquivos" name="lista_arquivos" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Data</th>
				<th>Nome do arquivo</th>
				<th>Importador</th>
				<th>Data da captura</th>
				<th>Data da conciliação</th>
				<th>Conciliador</th>				
				<th class='center'>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($listaArquivosCapturados as $arquivocapturado) { ?>
		<?php 
			$arquivocapturadoid = $arquivocapturado['Id'];
		?>
			
			<tr class="arquivocapturado_<?php echo $arquivocapturadoid; ?>"
				data-arquivocapturadoid="<?php echo $arquivocapturadoid; ?>"				
			>
				<td><?php echo PPOEntity::toDateBr($arquivocapturado['Data'], "d/m/Y"); ?></td>
				<td><?php echo $arquivocapturado['ArquivoNome']; ?></td>
				<td><?php echo $arquivocapturado['Importador']; ?></td>
				<td><?php echo PPOEntity::toDateBr($arquivocapturado['DataCaptura'], "d/m/Y"); ?></td>
				<td><?php echo PPOEntity::toDateBr($arquivocapturado['DataConciliacao'], "d/m/Y"); ?></td>				
				<td><?php echo $arquivocapturado['Conciliador']; ?></td>			
								
				<td class="center">
					<?php 
					// if (user_has_access("CRI_ORCAMENTO_EDITAR")) 	echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
					if (empty($arquivocapturado['DataConciliacao']) 
						and !empty($arquivocapturado['DataCaptura']) 
						and user_has_access("CRI_CAPTURA_CONCILIAR_VALORES_EVENTOS")) echo TAG_A_CONCILIAR_CAPTURA; else echo TAG_I_CONCILIAR_CAPTURA;
					if (!empty($arquivocapturado['DataCaptura']) 
						and user_has_access("CRI_CAPTURA_EVENTOS_DETALHES")) echo TAG_A_DEMONSTRATIVO_CAPTURA; else echo TAG_I_DEMONSTRATIVO_CAPTURA;	
					if (user_has_access("CRI_CAPTURA_EVENTOS_DETALHES"))	echo TAG_A_DETALHES; else echo TAG_I_DETALHES;
					if (user_has_access("CRI_CAPTURA_EVENTOS_EXCLUIR") and (!$arquivocapturado["DataConciliacao"] > 0 )
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
