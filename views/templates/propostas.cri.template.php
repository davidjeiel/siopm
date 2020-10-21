<?php
	//Testa se o usuário tem acesso ao módulo.
	if ($fase == 1 && !user_has_access("CRI_PRELIMINAR")) $siopm->getHtmlError("Você não possui acesso a este módulo.");
	if ($fase == 2 && !user_has_access("CRI_DEFINITIVA")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	// Configurações do document_top
	$title = $siopm->getTitle() . " " . $titulo_da_pagina;
	$custom_head .= $siopm->getJS("views", "propostas.cri.js");
	ob_start(); // começamos a armazenar tudo no buffer
?>

	<div class='conteudo-proposta-preliminar'>

		<h3><?php echo $titulo_da_pagina ?></h3>

		<div class='lista-propostas'>

			<?php if (user_has_access("CRI_PRELIMINAR_EDITAR")  &&  ($fase == 1) ){ ?>
				<p><button data-fase='<?php echo $fase ?>' class="btn_nova_proposta btn btn-primary" type="button">Nova Proposta</button></p>
			<?php } ?>

			<table id="lista_propostas" class="table table-striped table-condensed">
			<thead>
				<tr>
					<th class="center">Número</th>
					<th class="left">Securitizadora</th>
					<th class="left">Originador</th>
					<th class="center">Ano</th>
					<th class="left">Faixa</th>
					<th class="right">Valor CRI Sênior&nbsp;&nbsp;</th><!-- Valor do CRI Sênior -->
					<th class="left">Status</th>
					<th class="center">Ações</th>
				</tr>
			</thead>
			<tbody>

			<?php foreach($propostas as $proposta) { ?>

				<?php 
				
					$PropostaID 	= $proposta["PropostaID"];
					$ValorCRISenior	= ($proposta["ValorCRISenior"] > 0) ? $proposta["ValorCRISenior"] : 0.00;
					$ValorCRISenior = number_format( $ValorCRISenior , 2, ',', '.');
					$ValorCRISenior = "R$ " . $ValorCRISenior;
					
				?>

				<tr class					= "proposta_<?php echo $PropostaID; ?>" 
					data-fase 				= "<?php echo $fase; ?>" 
					data-propostaid 		= "<?php echo $PropostaID; ?>" 
					data-propostanumero 	= "<?php echo $proposta["PropostaNumero"]; ?>"
					data-propostadetalheid 	= "<?php echo $proposta["PropostaDetalheID"]; ?>"
					data-securitizadora		= "<?php echo $proposta["SecuritizadoraNome"]; ?>"
					data-datafinalizacao	= "<?php echo $proposta["DataFinalizacao"]; ?>"
				>
					<td class="center">	<?php echo $proposta["PropostaNumero"]; ?>			</td>
					<td class="left">	<?php echo $proposta["SecuritizadoraNome"]; ?>		</td>
					<td class="left">	<?php echo $proposta["OriginadorNome"]; ?>			</td>
					<td class="center">	<?php echo $proposta["OrcamentoAno"]; ?>			</td>
					<td class="left">	<?php echo $proposta["PropostaFaixaTipoNome"]; ?>	</td>
					<td class="right">	<?php echo $ValorCRISenior ?>						</td>
					<td class="left">	<?php echo $proposta["StatusNome"]; ?>				</td>

					<td class="center">
						
						<?php 
							$finalizada = ($proposta["DataFinalizacao"]>0);

							if ($fase == 1){
								if (user_has_access("CRI_PRELIMINAR_VISUALIZAR")) echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
								
								if (!$finalizada || user_has_access("CRI_PRELIMINAR_EDITAR_FINALIZADA")) {
									if (user_has_access("CRI_PRELIMINAR_EDITAR")) echo TAG_A_DADOS_BASICOS; else echo TAG_I_DADOS_BASICOS; 
									if (user_has_access("CRI_PRELIMINAR_ENQUADRAMENTO")) echo TAG_A_PROP_ENQUADRAMENTO_ANALISES; else echo TAG_I_PROP_ENQUADRAMENTO_ANALISES;
									if (user_has_access("CRI_PRELIMINAR_MANIF_SECURITIZADORA")) echo TAG_A_PROP_MANIFESTACAO_SECURITIZADORA; else echo TAG_I_PROP_MANIFESTACAO_SECURITIZADORA;
									if (user_has_access("CRI_PRELIMINAR_MANIF_OPERADOR") || user_has_access("CRI_PRELIMINAR_MANIF_GEFOM")) echo TAG_A_PROP_MANIFESTACAO_AG_OPERADOR; else echo TAG_I_PROP_MANIFESTACAO_AG_OPERADOR;
									if (user_has_access("CRI_PRELIMINAR_ARQUIVOS")) echo TAG_A_ARQUIVOS; else echo TAG_I_ARQUIVOS;
									if (user_has_access("CRI_PRELIMINAR_CONTATOS")) echo TAG_A_CONTATOS; else echo TAG_I_CONTATOS;
									if (!$finalizada && user_has_access("CRI_PRELIMINAR_FINALIZAR")) echo TAG_A_FINALIZAR; else echo TAG_I_FINALIZAR;
									if (user_has_access("CRI_PRELIMINAR_EXCLUIR")) echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR;
								} else {
									echo TAG_I_DADOS_BASICOS;
									echo TAG_I_PROP_ENQUADRAMENTO_ANALISES;
									echo TAG_I_PROP_MANIFESTACAO_SECURITIZADORA;
									echo TAG_I_PROP_MANIFESTACAO_AG_OPERADOR;
									echo TAG_I_ARQUIVOS;
									echo TAG_I_CONTATOS;
									echo TAG_I_FINALIZAR;
									echo TAG_I_EXCLUIR;
								}
							} else {
								if (user_has_access("CRI_DEFINITIVA_VISUALIZAR"))echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
								
								if (!$finalizada || user_has_access("CRI_DEFINITIVA_EDITAR_FINALIZADA")) {
									if (user_has_access("CRI_DEFINITIVA_EDITAR"))echo TAG_A_DADOS_BASICOS; else echo TAG_I_DADOS_BASICOS;
									if (user_has_access("CRI_DEFINITIVA_ENQUADRAMENTO"))echo TAG_A_PROP_ENQUADRAMENTO_ANALISES; else echo TAG_I_PROP_ENQUADRAMENTO_ANALISES;
									if (user_has_access("CRI_DEFINITIVA_MANIF_SECURITIZADORA"))echo TAG_A_PROP_MANIFESTACAO_SECURITIZADORA; else echo TAG_I_PROP_MANIFESTACAO_SECURITIZADORA;
									if (user_has_access("CRI_DEFINITIVA_MANIF_OPERADOR") || user_has_access("CRI_DEFINITIVA_MANIF_GEFOM") || user_has_access("CRI_DEFINITIVA_RESOL_CONSELHO"))echo TAG_A_PROP_MANIFESTACAO_AG_OPERADOR; else echo TAG_I_PROP_MANIFESTACAO_AG_OPERADOR;
									if (user_has_access("CRI_DEFINITIVA_ARQUIVOS"))echo TAG_A_ARQUIVOS; else echo TAG_I_ARQUIVOS;
									if (user_has_access("CRI_DEFINITIVA_CONTATOS"))echo TAG_A_CONTATOS; else echo TAG_I_CONTATOS;
									if (!$finalizada && user_has_access("CRI_DEFINITIVA_FINALIZAR"))echo TAG_A_FINALIZAR; else echo TAG_I_FINALIZAR;
									if (user_has_access("CRI_DEFINITIVA_EXCLUIR"))echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR;
								} else {
									echo TAG_I_DADOS_BASICOS; 
									echo TAG_I_PROP_ENQUADRAMENTO_ANALISES;
									echo TAG_I_PROP_MANIFESTACAO_SECURITIZADORA;
									echo TAG_I_PROP_MANIFESTACAO_AG_OPERADOR;
									echo TAG_I_ARQUIVOS;
									echo TAG_I_CONTATOS;
									echo TAG_I_FINALIZAR;
									echo TAG_I_EXCLUIR;
								}
							}
						?>

					</td>
				</tr>

			<?php } ?>

			</tbody>
			</table>

		</div>

		<span id='spanFormFinalizacao'></span>

	</div>


<?php

	$contents = ob_get_clean(); // transferimos o buffer para a variável
	
?>

