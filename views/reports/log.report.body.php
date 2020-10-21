
<style>
	#lista_log{
		0font-family: 'consolas';
		font-size: 12px;
	}

	#lista_log .popover{
		max-width: 100%;
	}

	#lista_log .cinza{
		background-color: #F5F5F5; 
	}

	#LogBodyReport .header .itens{
		margin-top: 10px;
		display: inline-block;
		margin-right: 5px;
		width: 300px;
	}

	#LogBodyReport{
		padding: 0 10px 18px 10px;
	}

	#LogBodyReport.footer{
		padding: 10px!important;
	}

	#LogBodyReport.tr_total{
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
<div id='LogBodyReport' class='body-eventos'>
	<div class='header'>
		<h3><?php echo $tituloPagina ; ?></h3>
		<div class="navbar-inner">
			<div class='itens'>
				<label><strong>Matrícula:</strong> <?php echo $matricula ?> </label>
			</div>
			<div class='itens'>
				<label><strong>Módulo:</strong> <?php echo $modulo ?> </label>
			</div>
			<div class='itens'>
				<label><strong>Tipo:</strong> <?php echo $tipo ?> </label>
			</div>
			<div class='itens'>
				<label><strong>Período:</strong> <?php echo $dataInicial . " à " . $dataFinal;  ?></label>
			</div>
		</div>
	</div>
	<div class='body'>
	 <table id="lista_log" class="table table-condensed">
		<thead>
			<tr>
				<th>Matrícula</th>
				<th>Nome</th>
				<th>Agrupamento</th>
				<th>Modulo</th>
				<th>Tipo</th>
				<th>Data e Hora</th>
				<th colspan='2'>Conteúdo</th>
			</tr>
		</thead>
		<tbody>

<?php
	$grupo = "";
	$classeGrupo = "";
	foreach ($logs as $log) {

		if ($log['Grupo'] != $grupo){
			$conteudoGrupo = "[".$log['Grupo']."]";
			if ($classeGrupo == "cinza") $classeGrupo = ""; else $classeGrupo = "cinza";
		}else{
			$conteudoGrupo = "";
		}


 ?>

	<tr class='<?php echo $classeGrupo;?>'>
		<td><?php echo $log['Matricula'] ?></td>
		<td><?php echo $log['NomeUsuario'] ?></td>
		<td class='center'><?php echo $conteudoGrupo; ?></td>
		<td><?php echo $log['Modulo'] ?></td>
		<td><?php echo $log['TDescricao'] ?></td>
		<td><?php echo PPOEntity::toDateBr($log['DataHora']); ?></td>
		<td>
			<?php 
				$len = 150; 
				$qtdChars = explode(":",serialize($log["Conteudo"]))[1];
				if ( $qtdChars > $len ){
					echo substr($log["Conteudo"], 0, $len ) . " <strong> ... </strong> ";
				} else echo	$log["Conteudo"];
			?>
		</td>
		<td>
			<a data-content='<div style="margin:0;" class="alert alert-danger"><?php echo rtrim(ltrim(json_pretty($log["Conteudo"], array("format" => "html")), "{"), "}"); ?></div>' 
				title="LOG" data-toggle="popover" class="" href="#" 
				data-original-title=""><i class="icon-search"></i>
			</a>
		</td>
	</tr>
	
	<?php
		$grupo = $log['Grupo'];
	} ?>

	</tbody>
	<tfoot>
		<tr class='line-top'></tr>
	</tfoot>
</table>
<div class='footer'> 
	<div class='pull-left'><sup> <?php echo $user->getUsuarioMatricula()." - ". $user->getUsuarioNome(); ?></sup> </div>
	<div class='pull-right'><sup> <?php echo date("d/m/Y H:i:s", time()); ?> </sup></div>
</div>
<script type="text/javascript">
	var pop = $('#lista_log a[data-toggle="popover"]', this.el).popover({
		trigger: 'click',
		html : true,
		placement: 'left'
	});
</script>