<?php

/*

Array
(
    [OrcamentoAno] => 2011
    [OrcamentoSaldoInicial] => 2840000000.0000
    [AtivoCodigoSIOPM] => CRI0006
    [Custodiante] => 11L0019693
    [Volume] => 318061530.42000000
    [P_Orcamento] => 11.199300
    [Aplicado] => 318061530.42000000
    [P_Aplicado] => 11.199300
    [Saldo] => 2521938469.58000000
)
*/
?>
<style>
	#orcamentosBodyReport .header .itens{
		margin-top: 10px;
		display: inline-block;
		margin-right: 5px;
		width: 300px;
	}

	#orcamentosBodyReport{
		padding: 0 10px 18px 10px;
	}

	#orcamentosBodyReport.footer{
		padding: 10px!important;
	}

	#orcamentosBodyReport.tr_total{
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

	.line-top{
		border-top: 2px solid #555;
	}

</style>
<div id='orcamentosBodyReport' class='body-eventos'>
	<div class='header'>
		<h3><?php echo $tituloPagina ; ?></h3>
		<div class="navbar-inner">
			<div class='itens'>
				<label><strong>Tipo de Relatório:</strong> <?php echo $tipoRelatorio ?> </label>
			</div>
			<div class='itens'>
				<label><strong>Período:</strong> <?php echo $anoInicial . " à " . $anoFinal;  ?></label>
			</div>
		</div>
	</div>
	<div class='body'>
	 <table id="lista_por_ativos" class="table table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Ano</th>
				<th class='center'>Orçamento</th>
				<?php if ($_REQUEST["TipoRelatorio"] == '1'){?>
					<th class='center'>Cód. SIOPM</th><th class='center'>Cód. Sist. Custódia</th>
				<?php } elseif ($_REQUEST["TipoRelatorio"] == '2'){ ?>
					<th >Emissor</th>
				<?php } else{ ?>
					<th >Cedente</th>
				<?php } ?>
				<th class='direita'>Volume</th>
				<th class='direita'>% Orçamento</th>
				<th class='direita'>Aplicado</th>
				<th class='direita'>% Aplicado</th>
				<th class='direita'>Saldo</th>
			</tr>
		</thead>
		<tbody>

<?php
		$class="";
		$anoAnterior = null;
		
		$saldo = 0.00;
		$P_Orcamento = 0.00;
		$P_Aplicado = 0.00;
		$volumeAcumulado = 0.00;
		//$aplicadoAcumulado = 0.00;


		foreach ($relatorioOrcamento as $key => $orcamento) {

			if ($orcamento['OrcamentoAno'] != $anoAnterior) $mudouAno = true; else $mudouAno = false;
			
			if ($mudouAno) {
				$class = ' line-top ';
				$volumeAcumulado = $orcamento['Volume'];
				//$aplicadoAcumulado = $orcamento['Aplicado'];
			} else {
				$class='';
				$volumeAcumulado += $orcamento['Volume'];
				//$aplicadoAcumulado += $orcamento['Aplicado'];
			}



			//$P_Aplicado = $aplicadoAcumulado / $orcamento['OrcamentoSaldoInicial'] * 100;
			$P_Orcamento = $orcamento['Volume'] / $orcamento['OrcamentoSaldoInicial'] * 100;
			$P_Aplicado = $volumeAcumulado / $orcamento['OrcamentoSaldoInicial'] * 100;

			//$saldo =  $orcamento['OrcamentoSaldoInicial'] - $aplicadoAcumulado;
			$saldo =  $orcamento['OrcamentoSaldoInicial'] - $volumeAcumulado;
			$anoAnterior = $orcamento['OrcamentoAno'];

 ?>

	<tr class='<?php echo $class; ?>'>
		<td><?php echo ($mudouAno)? $orcamento['OrcamentoAno']: ""; ?></td>
		<td class='direita'><?php echo ($mudouAno)? PPOEntity::toMoneyBr($orcamento['OrcamentoSaldoInicial']) :""; ?></td>
		
		<?php if ($_REQUEST["TipoRelatorio"] == '1'){?>
			<td class='center'><?php echo  $orcamento['AtivoCodigoSIOPM']; ?></td>
			<td class='center'><?php echo  $orcamento['Custodiante']; ?></td>
		<?php } else { ?>
			<td><?php echo  $orcamento['EntidadeNomeFantasia']; ?></td>
		<?php } ?>

		<td class='direita'><?php echo PPOEntity::toMoneyBr($orcamento['Volume']); ?></td>
		<td class='direita'><?php echo PPOEntity::toMoneyBr($P_Orcamento) . " %"; ?></td>
		<td class='direita'><?php echo PPOEntity::toMoneyBr($volumeAcumulado); ?></td>
		<td class='direita'><?php echo PPOEntity::toMoneyBr($P_Aplicado) . " %"; ?></td>
		<td class='direita'><?php echo PPOEntity::toMoneyBr($saldo); ?></td>
	</tr>

<?php	} ?>

	</tbody>
	<tfoot>
		<tr class='line-top'></tr>
	</tfoot>
</table>
<div class='footer'> 
	<div class='pull-left'><sup> <?php echo $user->getUsuarioMatricula()." - ". $user->getUsuarioNome(); ?></sup> </div>
	<div class='pull-right'><sup> <?php echo date("d/m/Y H:i:s", time()); ?> </sup></div>
</div>