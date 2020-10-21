<style type="text/css">

	#saldosBodyReport .header .itens{
		margin-top: 10px;
		display: inline-block;
		margin-right: 5px;
		width: 300px;
	}

	#saldosBodyReport .body .competencia{
		padding: 5px;
		background: #E9E9E9;
	}

	#saldosBodyReport{
		padding: 0 10px 18px 10px;
	}

	#saldosBodyReport.footer{
		padding: 10px!important;
	}

	#saldosBodyReport.tr_total{
		font-weight:bolder;
		border-bottom: 1px solid black;
	}

	.center{
		text-align: center!important;
	}

	.direita{
		text-align: right!important;
	}

	.competencia {
		margin-bottom: 10px;
	}
<?php
function ultimoDiaDoMes($competencia) {
	return date("t/m/Y", strtotime(substr($competencia, 3, 4) . '-' . substr($competencia, 0, 2) . '-01'));
}
?>
</style>
<div id='saldosBodyReport' class='body-saldos'>
	<div class='header'>
		<h3><?php echo $tituloPagina ; ?></h3>
		<div class="navbar-inner">	
			<div class='itens'>
				<label><strong>Tipo:</strong> <?php echo $tipoRelatorio; ?> </label>
			</div>	
			<!-- <div class='itens'>
				<label><strong>Modalidade:</strong> <?php echo $modalidade ?> </label>
			</div>	 -->
			<div class='itens'>
				<label><strong>Período:</strong> <?php echo $periodoInicial . " à " . $periodoFinal;  ?></label>
			</div>
		</div>
	</div>
	<br>
	<div class='body'>
		<?php 
			define("COD_AMORTIZACAO", 1);
			define("COD_AMORTIZACAO_EXTRAORDINARIA", 2);
		?>

		<?php foreach ($competencias as $dataCompetencia => $competencia): ?>
			<div class='competencia'>Competência: <b><?php echo $dataCompetencia ?></b></div>
			<table id="listaRelatorio" class="table table-condensed">
				<thead>
					<tr>
						<th>Cód. SIOPM</th>
						<th class="center">Cód. Sist. de Custódia</th>
						<th><div class='direita'>Saldo em <?php echo ultimoDiaDoMes($competencia["competencia_saldo_anterior"]); ?></div></th>
						<?php

							$totaisEventos = array();
							$totalEventosFinal = 0.00;
							$totalRendimentoFinal = 0.00;
							$totalPosicaoAtualFinal = 0.00;
							$valorAmortizacaoFinal = 0.00;
							$totalPosicaoAnteriorFinal = 0.00;
							$headers = $competencia["headers"];

							if ( array_key_exists(COD_AMORTIZACAO, $headers) || array_key_exists(COD_AMORTIZACAO_EXTRAORDINARIA, $headers)){
								echo "<th><div class='direita'>Amortização</div></th>";	
							}

							foreach($headers as  $eventotipoid => $eventotipo) {
								$totaisEventos[$eventotipoid] = 0.00;
								if ($eventotipoid != COD_AMORTIZACAO && $eventotipoid != COD_AMORTIZACAO_EXTRAORDINARIA) {
									echo "<th><div class='direita'>". $eventotipo. "</div></th>";
								}
							}

						?>
						<th><div class='direita'>Total dos Eventos</div></th>
						<th><div class='direita'>Rendimento</div></th>
						<th><div class='direita'>Saldo em <?php echo ultimoDiaDoMes($dataCompetencia); ?></div></th>
					</tr>
				</thead>
				<tbody>

					<?php if (isset($competencia["ativos"])) foreach( $competencia["ativos"] as $ativo): ?> 

						<tr>
							<td> <?php echo $ativo["AtivoCodigoSIOPM"]; ?></td>
							<td class="center"> <?php echo $ativo["AtivoCodigoCetip"]; ?></td>
							<!-- <td><div class='direita'><?php echo ($ativo["saldo_anterior"] == "ERRO_CADASTRO")? "<b class='alert-danger'>Saldo?</b>" : PPOEntity::toMoneyBr($ativo["saldo_anterior"]) ?></div></td>
							 -->
							 <td><div class='direita'><?php echo PPOEntity::toMoneyBr($ativo["saldo_anterior"]) ?></div></td>

							<?php

								$rendimento = 0.00;
								$totalEventos = 0.00;
								$valorAmortizacao = 0.00;

								if (array_key_exists(COD_AMORTIZACAO, $headers) || array_key_exists(COD_AMORTIZACAO_EXTRAORDINARIA, $headers)) {
									if (isset($ativo["eventos"][COD_AMORTIZACAO]) && $ativo["eventos"][COD_AMORTIZACAO] > 0){
										$valorAmortizacao += (double) $ativo["eventos"][COD_AMORTIZACAO]["TOTALEVENTO"];
									} 
									if (isset($ativo["eventos"][COD_AMORTIZACAO_EXTRAORDINARIA]) && $ativo["eventos"][COD_AMORTIZACAO_EXTRAORDINARIA] > 0) {
										$valorAmortizacao += (double) $ativo["eventos"][COD_AMORTIZACAO_EXTRAORDINARIA]["TOTALEVENTO"];
									} 
									echo "<td><div class='direita'>" . PPOEntity::toMoneyBr($valorAmortizacao) . "</div></td>";
								}

								foreach( $headers as $eventotipoid => $value) {
									$eventoValor = 0.00;
									if (isset($ativo["eventos"][$eventotipoid]) && ($ativo["eventos"][$eventotipoid] > 0)){
										$eventoValor = (double) $ativo["eventos"][$eventotipoid]["TOTALEVENTO"];
										$totalEventos += $eventoValor;
										$totaisEventos[$eventotipoid] += $eventoValor;

									}
									if ($eventotipoid != COD_AMORTIZACAO && $eventotipoid != COD_AMORTIZACAO_EXTRAORDINARIA) {
											echo "<td><div class='direita'>" . PPOEntity::toMoneyBr($eventoValor) . "</div></td>";
									} 
								}

								// if ($valorAmortizacao > 0){
								// 	echo "<td><div class='direita'>" . PPOEntity::toMoneyBr($valorAmortizacao) . "</div></td>";
								// }

								/* Subtrai o valor da Taxa de Risco do cálculo do rendimento */
								// if ($ativo["saldo_anterior"] == "ERRO_CADASTRO" || $ativo["saldo_atual"] == "ERRO_CADASTRO") {
								// 	$rendimento = 0.00;	
								// } else $rendimento = ( (double)$ativo["saldo_atual"] - (double)$ativo["saldo_anterior"]) + $valorAmortizacao + $totalEventos;
								//$rendimento = ( (double)$ativo["saldo_atual"] - (double)$ativo["saldo_anterior"]) + $valorAmortizacao + $totalEventos;
								$rendimento = ( (double)$ativo["saldo_atual"] - (double)$ativo["saldo_anterior"]) + $totalEventos;


								$totalRendimentoFinal += $rendimento;
								$valorAmortizacaoFinal += $valorAmortizacao;
								$totalEventosFinal += $totalEventos;
								$totalPosicaoAtualFinal += $ativo["saldo_atual"];
								$totalPosicaoAnteriorFinal += $ativo["saldo_anterior"];

							?> 
							<td><div class='direita'><?php echo  PPOEntity::toMoneyBr($totalEventos) ?></div></td>
							<td><div class='direita'><?php echo  PPOEntity::toMoneyBr($rendimento) ?></div></td>
							<!-- <td><div class='direita'><?php echo ($ativo["saldo_atual"] == "ERRO_CADASTRO")? "<b class='alert-danger'>Saldo?</b>" : PPOEntity::toMoneyBr($ativo["saldo_atual"]) ?></div></td>
							 -->
							<td><div class='direita'><?php echo PPOEntity::toMoneyBr($ativo["saldo_atual"]) ?></div></td>
							
						</tr>
					<?php endforeach; ?>
						<tr class='tr_total'>
							<td class='direita' colspan='2'><strong>Total</strong></td>
							<td class='direita'><strong><?php echo PPOEntity::toMoneyBr($totalPosicaoAnteriorFinal) ?></strong></td>
							<?php 

								if (array_key_exists(COD_AMORTIZACAO, $headers) || array_key_exists(COD_AMORTIZACAO_EXTRAORDINARIA, $headers)){
									echo "<td class='direita'><strong>" . PPOEntity::toMoneyBr($valorAmortizacaoFinal) . "</strong></td>";
								}

								foreach($headers as $eventotipoid => $eventotipo): 
									if ($eventotipoid != COD_AMORTIZACAO && $eventotipoid != COD_AMORTIZACAO_EXTRAORDINARIA) {
										echo "<td class='direita'><strong>" . PPOEntity::toMoneyBr($totaisEventos[$eventotipoid]) ."</strong></td>";
									}
								endforeach; 
							?>
							<td class='direita'><strong><?php echo PPOEntity::toMoneyBr($totalEventosFinal) ?></strong></td>
							<td class='direita'><strong><?php echo PPOEntity::toMoneyBr($totalRendimentoFinal) ?></strong></td>
							<td class='direita'><strong><?php echo PPOEntity::toMoneyBr($totalPosicaoAtualFinal) ?></strong></td>
						</tr>
				</tbody>
			</table>
		<?php endforeach;?>
	</div>
	<div class='footer'> 
		<div class='usuario pull-left'><sup><?php echo $user->getUsuarioMatricula()." - ". $user->getUsuarioNome(); ?></sup></div>
		<div class='matricula pull-right'><sup> <?php echo date("d/m/Y H:i:s", time()); ?> </sup></div>
	</div>
</div>