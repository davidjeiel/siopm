

<style type="text/css">
	
/*	.body-eventos{
		padding: 10px;
	}

	.body-eventos table td {
		vertical-align: middle;
	}
	.body-eventos table th{
		border-bottom: 1px solid black;
	}

	.evento-valor, .saldos, .titulo-eventos{
		text-align: right;
	}

	.body-eventos .body-eventos-header .modalildade .conteudo{
		width: 280px;
	}
	.body-eventos .body-eventos-header .iten-selecao{
		padding-bottom: 12px; 
	}

	.body-eventos .body-eventos-header .titulo, 
	.body-eventos .body-eventos-header .conteudo{
		font-size: 16px;
		margin-right: 10px;
		display: inline-block;
		vertical-align: center;
	}

	#lista_por_ativos{
		border-top: 1px solid black;
	}
*/
	#eventosBodyReport .header .itens{
		margin-top: 10px;
		display: inline-block;
		margin-right: 5px;
		width: 300px;
	}

	#eventosBodyReport{
		padding: 0 10px 18px 10px;
	}

	#eventosBodyReport.footer{
		padding: 10px!important;
	}

	#eventosBodyReport.tr_total{
		font-weight:bolder;
		border-bottom: 1px solid black;
	}

	.center{
		text-align: center!important;
	}

	.direita{
		text-align: right!important;
	}

	.header {
		margin-bottom: 10px;
	}

</style>
<div id='eventosBodyReport' class='body-eventos'>
	<div class='header'>
		<h3><?php echo $titulo_pagina ; ?></h3>
		<div class="navbar-inner">
			<div class='itens'>
				<label><strong>Tipo de Relatório:</strong> <?php echo $tipo_relatorio ?> </label>
			</div>
			<!-- <div class='itens'>
				<label><strong>Modalidade:</strong> <?php echo $modalidade ?> </label>
			</div> -->
			<div class='itens'>
				<label><strong>Período:</strong> <?php echo $datainicial . " à " . $datafinal;  ?></label>
			</div>
		</div>
	</div>
	<div class='body'>
		<?php
			define("COD_JUROS", 3);
			define("COD_TAXA_RISCO", 4);
			define("REMUNERACAO_SELIC", 17);
			 if ($EntidadePapelID == "0"){ 
		?>
			<table id="lista_por_ativos" class="table table-temp-hover table-condensed">
				<thead>
					<tr>
						<th>Cód. SIOPM</th>
						<th class="center">Cód. Sist. de Custódia</th>
						
						<?php 

							$totaisEventos = array();
							$totalEventosFinal = 0.00;
							$totalJurosTaxaRisco = 0.00;
							$totalJurosTaxaRiscoFinal = 0.00;
							$inversaoOrdemVisualizacaoRemuneracaoSelic = "";

							foreach($eventosHeaderAtivos as  $eventotipoid => $eventotipo): 

								$totaisEventos[$eventotipoid] = 0.00;

								if  ($eventotipoid == REMUNERACAO_SELIC) {
									$inversaoOrdemVisualizacaoRemuneracaoSelic = "<th><div class='direita'>". $eventotipo . "</div></th>";
								}else echo "<th><div class='direita'>". $eventotipo . "</div></th>";

							endforeach; 

							if (array_key_exists(COD_JUROS, $eventosHeaderAtivos) && array_key_exists(COD_TAXA_RISCO, $eventosHeaderAtivos)){
								echo "<th><div class='direita'>Juros + Taxa de Risco</div></th>";
							}

							echo $inversaoOrdemVisualizacaoRemuneracaoSelic;

						?>

						<th><div class='direita'>Total da Transação</div></th>
					</tr>
				</thead> 
				<tbody>
				<?php 
					$TotalTransacaoFinal = 0.00;
					if (isset($ativos)) foreach($ativos as $row): 
				?>
					<tr><td><?php echo $row["AtivoCodigoSIOPM"]; ?></td>
					<td class="center"><?php echo $row["AtivoCodigoCetip"]; ?></td>
				<?php

					$TotalTransacao = 0.00;
					$inversaoOrdemVisualizacaoRemuneracaoSelic = "";

					foreach( $eventosHeaderAtivos as $key => $value): 
						$eventoValor = 0.00;
						if (isset($row["Eventos"][$key]) && ($row["Eventos"][$key] > 0)){
							$eventoValor = (double) $row["Eventos"][$key]["TOTALEVENTO"];
							$TotalTransacao += $eventoValor;
							$totaisEventos[$key] += $eventoValor;
							if ($key == COD_JUROS || $key == COD_TAXA_RISCO) $totalJurosTaxaRisco += $eventoValor;
						}

						if  ($key == REMUNERACAO_SELIC) {
							$inversaoOrdemVisualizacaoRemuneracaoSelic = "<td> <div class='direita'>" . PPOEntity::toMoneyBr($eventoValor) . "</div> </td>";
						}else echo "<td> <div class='direita'>" . PPOEntity::toMoneyBr($eventoValor) . "</div> </td>";

					endforeach; 

					$TotalTransacaoFinal += $TotalTransacao;
					$totalJurosTaxaRiscoFinal += $totalJurosTaxaRisco;

					if (array_key_exists(COD_JUROS, $eventosHeaderAtivos) && array_key_exists(COD_TAXA_RISCO, $eventosHeaderAtivos)){
						echo  "<td> <div class='direita'>" . PPOEntity::toMoneyBr($totalJurosTaxaRisco) ."</div></td>";
					}

					echo $inversaoOrdemVisualizacaoRemuneracaoSelic;

					$totalJurosTaxaRisco = 0.00;
				?> 
					<td><div class='saldos direita'><?php echo PPOEntity::toMoneyBr($TotalTransacao); ?></div></td></tr>
				<?php endforeach; ?>
					<tr>
						<td colspan='2'><div class='direita'><strong>Total</strong></div></td>
						<?php 
							foreach($eventosHeaderAtivos as $eventotipoid => $eventotipo): 
								if  ($eventotipoid == REMUNERACAO_SELIC) {
									$inversaoOrdemVisualizacaoRemuneracaoSelic = "<td> <div class='direita'><strong>" . PPOEntity::toMoneyBr($totaisEventos[$eventotipoid]) ."</strong></div></td>";
								}else echo "<td> <div class='direita'><strong>" . PPOEntity::toMoneyBr($totaisEventos[$eventotipoid]) ."</strong></div></td>";
							endforeach; 
							if (array_key_exists(COD_JUROS, $eventosHeaderAtivos) && array_key_exists(COD_TAXA_RISCO, $eventosHeaderAtivos)){
								echo  "<td> <div class='direita'><strong>" . PPOEntity::toMoneyBr($totalJurosTaxaRiscoFinal) ."</strong></div></td>";
							}
							echo $inversaoOrdemVisualizacaoRemuneracaoSelic;	
						?>
						<td><div class='direita'><strong> <?php echo PPOEntity::toMoneyBr($TotalTransacaoFinal); ?> </strong></div></td>
					</tr>
				</tbody>
			</table>
		<?php } else { ?>
			<table id="lista_por_entidade" class="table table-temp-hover table-condensed">
				<thead>
					<tr>
						<th class='titulo-eventos'>Entidade</th>
						<?php 

							$totaisEventos = array();
							$totalEventosFinal = 0.00;
							$totalJurosTaxaRisco = 0.00;
							$totalJurosTaxaRiscoFinal = 0.00;

							foreach($eventosHeaderPapel as $eventotipoid => $eventotipo): 
								$totaisEventos[$eventotipoid] = 0.00;
								echo "<th class='direita'> $eventotipo </th>";
							endforeach; 

							if (array_key_exists(COD_JUROS, $eventosHeaderPapel) && array_key_exists(COD_TAXA_RISCO, $eventosHeaderPapel)){
								echo "<th><div class='direita'>Juros + Taxa de Risco</div></th>";
							}

						?>
						<th class='direita'>Total da Transação</th>
					</tr>
				</thead> 
				<tbody>
					<?php 
						$TotalTransacaoFinal = 0.00;
						if (isset($ativosEntidades)) foreach($ativosEntidades as $row): 
					?>
							<tr>
								<td><div class='entidade-fantasia'> <?php echo $row["EntidadesNomes"]; ?></div></td>
					<?php
							$TotalTransacao = 0.00;
							foreach( $eventosHeaderPapel as $key => $value): 
								$eventoValor = 0.00;

								if (isset($row["Eventos"][$key]) && ($row["Eventos"][$key] > 0)){
									$eventoValor = (double) $row["Eventos"][$key]["TOTALEVENTO"];
									$TotalTransacao += $eventoValor;
									$totaisEventos[$key] += $eventoValor;
									if ($key == COD_JUROS || $key == COD_TAXA_RISCO) $totalJurosTaxaRisco += $eventoValor;
								}
								echo "<td><div class='direita'>" . PPOEntity::toMoneyBr($eventoValor) . "</div></td>";

							endforeach; 
							$TotalTransacaoFinal += $TotalTransacao;
							$totalJurosTaxaRiscoFinal += $totalJurosTaxaRisco;

							if (array_key_exists(COD_JUROS, $eventosHeaderPapel) && array_key_exists(COD_TAXA_RISCO, $eventosHeaderPapel)){
								echo  "<td> <div class='direita'>" . PPOEntity::toMoneyBr($totalJurosTaxaRisco) ."</div></td>";	
							}

							$totalJurosTaxaRisco = 0.00;

					?> 
							<td><div class='direita'><?php echo PPOEntity::toMoneyBr($TotalTransacao); ?></div></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td><div class='direita'><strong>Total</strong></div></td>
						 <?php 

							foreach($eventosHeaderPapel as $eventotipoid => $eventotipo): 								
								echo "<td> <div class='direita'><strong>" . PPOEntity::toMoneyBr($totaisEventos[$eventotipoid]) ."</strong></div></td>";
							endforeach; 

							if (array_key_exists(COD_JUROS, $eventosHeaderPapel) && array_key_exists(COD_TAXA_RISCO, $eventosHeaderPapel)){
								echo  "<td> <div class='direita'><strong>" . PPOEntity::toMoneyBr($totalJurosTaxaRiscoFinal) ."</strong></div></td>";
							}

							?>
						<td><div class='direita'><strong> <?php echo PPOEntity::toMoneyBr($TotalTransacaoFinal); ?> </strong></div></td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
	</div>
	<div class='footer'> 
		<div class='pull-left'><sup> <?php echo $user->getUsuarioMatricula()." - ". $user->getUsuarioNome(); ?></sup> </div>
		<div class='pull-right'><sup> <?php echo date("d/m/Y H:i:s", time()); ?> </sup></div>
	</div>
</div>