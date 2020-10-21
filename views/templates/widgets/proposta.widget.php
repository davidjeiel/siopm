

<div class='widget-medio'>
	<h4 class='titulo'>Propostas Recentes</h4>
	<div class='scroll'>
		<table id="propostas_recentes" class="table table-temp-hover table-condensed">
			<thead>
				<tr>
					<th ><div class=''>Núm - Fase<div></th>
					<th ><div class=''>Securitizadora<div></th>
					<th ><div class=''>Valor CRI Sênior&nbsp;&nbsp;<div></th>
					<th ><div class=''>Status<div></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($propostas as $proposta) { ?>
				<?php 
					$ValorCRISenior	= ($proposta["ValorCRISenior"] > 0) ? $proposta["ValorCRISenior"] : 0.00;
					$ValorCRISenior = number_format( $ValorCRISenior , 2, ',', '.');
					$ValorCRISenior = "R$ " . $ValorCRISenior;

					$fase = "P";
					if ($proposta["PropostaFaseID"] == 2) $fase = "D";
				?>
				<tr>
					<td><div class="center"><?php echo $proposta["PropostaNumero"] . " - $fase"; ?>		</div></td>
					<td><div class="pull-left">	<?php echo $proposta["SecuritizadoraNome"]; ?>	</div></td>
					<td><div class="pull-right">	<?php echo $ValorCRISenior ?>			</div></td>
					<td><div class="pull-left">	<?php echo $proposta["StatusNome"]; ?>			</div></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>


