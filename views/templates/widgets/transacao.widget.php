
	<div class='widget-grande'>
		<h4 class='titulo'>Últimas Transações</h4>
		<div class='scroll'>
			<table id="transacoes" class="table table-condensed">
				<thead>
					<tr>
						<th class="center">Cetip</th>
						<th class="center">Data</th>
						<th><div class="pull-right">Valor&nbsp;&nbsp;</div></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($transacoes as $transacao) { ?>
					<?php 
						$valor	= ($transacao["somaEvento"] > 0) ? $transacao["somaEvento"] : 0.00;
						$valor = number_format( $valor , 2, ',', '.');
						$valor = "R$ " . $valor;
					?>
					<tr>
						<td><div class="center">	<?php echo $transacao["AtivoCodigoCetip"]; ?>		</div></td>
						<td><div class="center">	<?php echo PPOEntity::toDateBr($transacao["TransacaoData"], "d/m/Y"); ?></div></td>
						<td><div class="pull-right">	<?php echo $valor ?></div></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
