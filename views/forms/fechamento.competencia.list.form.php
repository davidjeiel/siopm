<?php 
	$total = count($listaativos); 	
	if ($total > 0){ ?>
		<div id='div_lista_trasancoes'>
			<p><strong>Lista de transações da competência <?php echo $competenciaFormatadaParaBusca; ?>.</strong></p>
			<table id='lista_trasancoes' class='table table-striped table-condensed'>
				<thead>
					<tr>									
						<th>Cód SIOPM </th>
						<th>CETIP</th>
						<th>Data da Transação</th>
						<th class='right'> Valor da Transação &nbsp;</th>							
					</tr>
				</thead>
				<tbody>
					<?php foreach($listaativos as $ativo): ?>

					<?php 						
					?>

						<tr class='alert-error' data-acao='$acao'>	
							<td> <?php echo $ativo['AtivoCodigoSIOPM'] ?> </td>									
							<td> <?php echo $ativo['AtivoCodigoCetip'] ?> </td>
							<td> <?php echo PPOEntity::toDateBr($ativo['TransacaoData'], "d/m/Y")?> </td>
							<td class='right'> <?php echo "R$ " . PPOEntity::toMoneyBR($ativo['ValorTotal']) ?> </td>
						</tr>
					
					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
<?php } else { ?>

	<h3> Competência não possui lançamento! <h3>
	
<?php } ?>