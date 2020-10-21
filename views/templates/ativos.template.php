<?php
	//Testa se o usuário tem acesso ao módulo.
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	// Configurações do document_top
	$title = $siopm->getTitle();
	$custom_head .= $siopm->getJS("views", "ativos.js");

	ob_start(); // começamos a armazenar tudo no buffer
	
?>
	<div class='conteudo-ativos'>

		<h3>Ativos Financeiros - CRI</h3>

		<!-- <p><button class="btn_novo btn btn-primary" type="button">Novo CRI</button></p> -->
		
		<table id="lista_ativos" class="table table-striped table-temp-hover table-condensed">
			<thead>
				<tr>
					<th class='center'>Cód. SIOPM</th>
					<th class='center'>Cód. Sist. de Custódia</th>
					<th class='center'>Nº. da Proposta</th>
					<th>Emissor</th>
					<th>Cedente(s)</th>
					<th class='center' >Data da Subscrição</th>
					<th class='right'>Volume Subscrito &nbsp;</th>
					<th class='center'>Status</th>
					<th class='center'>Ações</th>
				</tr>
			</thead>
			<tbody>

			<?php foreach($db_ativos_arr as $ativo) { ?>
			<?php 

				$display_id 			  	= $ativo['AtivoID'];
				$display_propostaDetalheid	= $ativo['PropostaDetalheID'];
				$display_Proposta	  	  	= $ativo['PropostaNumero'];
				$display_cod_SIOPM 	  	  	= $ativo['AtivoCodigoSIOPM'];
				$display_cod_CETIP 		  	= $ativo['Custodiante'];
				$display_emissora		  	= $ativo['Emissor'];
				$display_cedente 		  	= str_replace(";", "<br>", $ativo['Cedentes']);
				$display_data_subscricao  	= $ativo['Subscricao'];
				$display_valor_subscricao 	= $ativo['VolumeSubscrito'];
				$status =  "Incluindo";
				if ( isset($ativo["AtivoDataFinalizacao"]) and $ativo["AtivoDataFinalizacao"] > 0 )  $status =  "Finalizada" ;

			?>

				<?php 
					switch ($status) {
						case "Finalizada":

							$statusAtivo = $ativo['Status'];
							if ($statusAtivo == "Adimplente") {
								$statusAtivo = "<div style='color:#279d27;'>". $ativo['Status']. "</div>";
								$classe = "alert-success";
							}elseif ($statusAtivo == "Liquidado" OR $statusAtivo == "Liquidado Antecipadamente"){
								$statusAtivo = "<div style='color:blue;'>". $ativo['Status']. "</div>";
								$classe = "alert-info";
							}else{
								$statusAtivo = "<div style='color:red;'>". $ativo['Status']. "</div>";
								$classe = "alert-error";
							}

							break;

						case "Incluindo":
							$statusAtivo = "<div style='color:#ff8a00;'>Em Atualização</div>";
							$classe = "alert";
							break;
					}
				?>

				<!-- Exemplo de dados. -->

				<tr class="ativo_<?php echo $display_id . ' ' . $classe ?>"
				    data-ativoid="<?php echo $display_id ?>"
				    data-propostadetalheid="<?php echo $display_propostaDetalheid ?>"
				>
					<td class='center'><?php echo $display_cod_SIOPM; ?></td>
					<td class='center'><?php echo $display_cod_CETIP; ?></td>
					<td class='center'><?php echo $display_Proposta; ?> </td>
					<td><?php echo $display_emissora; ?></td>
					<td><?php echo $display_cedente; ?></td>
					<td class='center'><?php echo PPOEntity::toDateBr($display_data_subscricao, "d/m/Y"); ?></td>
					<td class='right' ><?php echo "R$ " . PPOEntity::toMoneyBr($display_valor_subscricao); ?></td>
					<td class='center' ><?php echo $statusAtivo; ?></td>
					<td class='center'>
						<?php
							if (user_has_access("CRI_ATIVOS_VISUALIZAR")) echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
							
							if ($status != "Finalizada" || user_has_access("CRI_ATIVOS_EDITAR_FINALIZADO")) {
								if (user_has_access("CRI_ATIVOS_DADOS_GERAIS"))echo TAG_A_DADOS_GERAIS; else echo TAG_I_DADOS_GERAIS;
								if (user_has_access("CRI_ATIVOS_JUROS"))echo TAG_A_JUROS; else echo TAG_I_JUROS; 
								if (user_has_access("CRI_ATIVOS_SUBSCRICAO"))echo TAG_A_SUBSCRICAO; else echo TAG_I_SUBSCRICAO; 
								if (user_has_access("CRI_ATIVOS_ENTIDADE"))echo TAG_A_ENTIDADES; else echo TAG_I_ENTIDADES; 
								if (user_has_access("CRI_ATIVOS_ARQUIVOS"))echo TAG_A_ARQUIVOS; else echo TAG_I_ARQUIVOS; 
								if ($status != "Finalizada" && user_has_access("CRI_ATIVOS_FINALIZAR")) echo TAG_A_FINALIZAR; else echo TAG_I_FINALIZAR; 
								if (user_has_access("CRI_ATIVOS_EXCLUIR"))echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR; 
							} else {
								echo TAG_I_DADOS_GERAIS; 
								echo TAG_I_JUROS;
								echo TAG_I_SUBSCRICAO; 
								echo TAG_I_ENTIDADES;
								echo TAG_I_ARQUIVOS;
								echo TAG_I_FINALIZAR;
								echo TAG_I_EXCLUIR;
							}

						?>

					</td>
				</tr>

			<?php }; ?>

			</tbody>
		</table>

	</div>

<?php
	$contents = ob_get_clean(); // Transferimos o buffer para a variável.
?>
