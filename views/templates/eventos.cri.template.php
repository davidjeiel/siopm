<?php
	//Testa se o usuário tem acesso ao módulo.
	if (!user_has_access("CRI_EVENTOS")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	// Configurações do document_top
	$title = $siopm->getTitle();
	$custom_head .= $siopm->getJS("views", "ativos.cri.eventos.js");
	$custom_head .= $siopm->getJS("views", "ativos.js");
	ob_start(); // começamos a armazenar tudo no buffer

?>
	<div class='conteudo-ativos-cri'>

		<h3>Eventos Financeiros - CRI </h3>

		<!-- <p><button class="btn_novo btn btn-primary" type="button">Novo CRI</button></p> -->

		<table id="listaAtivosEventos" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th class='center'>Cód. SIOPM</th>
				<th class='center'>Cód. Sist. de Custódia</th>
				<th class='center'>Data da Subscrição  &nbsp;</th>
				<th class="right">Volume Subscrito &nbsp;</th>
				<th class="right">Último Saldo Devedor  &nbsp;</th>
				<th class="right">Volume Amortizado  &nbsp;</th>
				<th class="right">Percentual Amortizado  &nbsp;</th>
				<th class='center'>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($ativos as $ativo) { ?>
		<?php 

			$id 			  	  = $ativo['AtivoID'];
			$cod_SIOPM 	  		  = $ativo['AtivoCodigoSIOPM'];
			$cod_CETIP 		  	  = $ativo['AtivoCodigoCetip'];
			$saldoDevedor	  	  = $ativo['SaldoDevedor'];
			$volumeAmortizado 	  = $ativo['VolumeAmortizado'];
			$percentualAmortizado = $ativo['PercentualAmortizado'];
			$data_subscricao 	  = $ativo['Subscricao'];
			$valor_subscricao	  = $ativo['VolumeSubscrito'];

		?>
			<!-- Exemplo de dados. -->

			<tr class="ativo_<?php echo $id; ?>"
				data-ativoid="<?php echo $id ?>"
			>
				<td class='center'> <a class="visualizarAtivo" style="cursor: pointer"><?php echo $cod_SIOPM; ?> </a></td>
				<td class='center'>	<?php echo $cod_CETIP; ?></td>
				<td class='center'>	<?php echo PPOEntity::toDateBr($data_subscricao, "d/m/Y"); ?></td>
				<td class="right">	<?php echo "R$ " . PPOEntity::toMoneyBr($valor_subscricao); ?></td>
				<td class="right">	<?php echo "R$ " . PPOEntity::toMoneyBr($saldoDevedor); ?></td>
				<td class="right">	<?php echo "R$ " . PPOEntity::toMoneyBr($volumeAmortizado); ?></td>
				<td class="right">	<?php echo "% " . PPOEntity::toMoneyBr($percentualAmortizado); ?></td>
				<td class='center'>
					<?php
							if (user_has_access("CRI_EVENTOS_VISUALIZAR"))echo TAG_A_VISUALIZAR;
							if (user_has_access("CRI_EVENTOS_TRANSACOES"))echo TAG_A_ATIVO_TRANSACOES;
							if (user_has_access("CRI_EVENTOS_SALDOS"))echo TAG_A_ATIVO_SALDO;
						?>
				</td>
			</tr>

		<?php }; ?>

		</tbody>
		</table>
		<span id="spanFormTrasacoes">  </span>
	</div>

<?php

	$contents = ob_get_clean(); // Transferimos o buffer para a variável.

?>
