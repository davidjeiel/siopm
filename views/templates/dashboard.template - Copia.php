<link href='/views/css/dashboard.css' rel='stylesheet'>

<?php 
	ob_start(); 
?>



<div id='dashboard' class='container-fluid'>
	<!-- HABILITACAO -->
	<?php foreach($widgets as $widget) require "/views/templates/widgets/$widget.widget.php"; ?>
		
	<!-- <div class='widget-container '>
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
	</div> 

	<div class='widget-container'>
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
	</div>

	<div class='widget-container  '>
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
	</div>
</div> -->

<?php $contents = ob_get_clean(); ?>