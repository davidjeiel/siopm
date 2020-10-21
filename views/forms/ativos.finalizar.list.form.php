<?php 
	$totalErros = count($inconsistencias); 
	if ($totalErros>0){ ?>
		<div id='div_lista_erros'>
			<p><strong>Foram encontradas pendências que impedem a finalização do cadastro do ativo financeiro.</strong></p>
			<table id='lista_erros' class='table table-striped table-condensed'>
				<thead>
					<tr>									
						<th>Formulário</th>
						<th>Aba</th>
						<th>Descrição do Erro</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>

					<?php if (isset($inconsistencias)) foreach($inconsistencias as $inconsistencia): ?>

					<?php 
						$acao 		= $inconsistencia["Acao"];
						$local 		= $inconsistencia["Local"];
						$aba 		= $inconsistencia["Aba"];
						$campo		= $inconsistencia["Campo"];

						$msgErro	= ($inconsistencia["MsgErro"] == "") ? "O campo <strong>$campo</strong> não foi informado corretamente." : $inconsistencia["MsgErro"];

						$abaID 		= $inconsistencia["AbaID"];
						$campoID	= $inconsistencia["CampoID"];
						$ativoID 	= $inconsistencia["AtivoID"];
						
					?>

						<tr class='alert-error' data-acao='$acao'>										
							<td> <?php echo $local ?> </td>
							<td> <?php echo $aba ?> </td>
							<td> <?php echo $msgErro ?> </td>
							<td> <a href='#' onClick='<?php echo "goErroAtivo(\"$acao\", $ativoID, \"$abaID\", \"$campoID\");" ?>' > Exibir </a></td>
						</tr>
					
					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
<?php } ?>