
<style>
	#acessosBodyReport .header .itens{
		margin-top: 10px;
		display: inline-block;
		margin-right: 5px;
		width: 300px;
	}

	#acessosBodyReport{
		padding: 0 10px 18px 10px;
	}

	#acessosBodyReport.footer{
		padding: 10px!important;
	}

	#acessosBodyReport.tr_total{
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
<div id='acessosBodyReport' class='body-eventos'>
	<div class='header'>
		<h3><?php echo $tituloPagina ; ?></h3>
		<div class="navbar-inner">
			<div class='itens'>
				<label><strong>Matrícula:</strong> <?php echo $matricula ?> </label>
			</div>
			<div class='itens'>
				<label><strong>Controller:</strong> <?php echo $controller ?> </label>
			</div>
			<div class='itens'>
				<label><strong>Período:</strong> <?php echo $dataInicial . " à " . $dataFinal;  ?></label>
			</div>
		</div>
	</div>
	<div class='body'>
	 <table id="lista_por_ativos" class="table table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Matricula</th>
				<th>Unidade</th>
				<th>DataHora</th>
				<th>Ação</th>
				<th>Controller</th>
				<th>Endereço</th>
			</tr>
		</thead>
		<tbody>

<?php
		foreach ($acessos as $acesso) {
 ?>

	<tr>
		<td><?php echo $acesso['Matricula'] ?></td>
		<td><?php echo $acesso['Unidade'] ?></td>
		<td><?php echo PPOEntity::toDateBr($acesso['DataHora']); ?></td>
		<td><?php echo $acesso['Acao']?></td>
		<td><?php echo $acesso['Controller']?></td>
		<td>
			<?php 
				echo 
					str_replace(
						str_replace(
							".controller.php", "", str_replace("/controllers/", "", $acesso['Endereco'])), 
							"<strong>" . str_replace(".controller.php", "", str_replace("/controllers/", "", $acesso['Endereco'])) . "</strong>",
							$acesso['Endereco']
					);
			?>
		</td>
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