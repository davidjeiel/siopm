
	<div class='widget-medio'>
		<h4 class='titulo'>Saldo Devedores</h4>
		<div class='scroll'>
			<table id="saldos_devedores_securitizadora" class="table table-condensed">
				<thead>
					<tr>
						<th class="pull-left">Securitizadora</th>
						<th class="pull-right">Valor&nbsp;&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($saldos as $saldo) { ?>
					<?php 
						$valor	= ($saldo["Saldo"] > 0) ? $saldo["Saldo"] : 0.00;
						$valor = number_format( $valor , 2, ',', '.');
						$valor = "R$ " . $valor;
					?>
					<tr>
						<td><div class="pull-left"><?php echo $saldo["Securitizadora"]; ?>		</div></td>
						<td><div class="pull-right"><?php echo $valor ?>						</div></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

