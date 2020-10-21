

<style type="text/css">
	
	#dialog-historico-habilitacao {
		width: 990px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -505px;
    	/*margin-top: -25px;*/ /* 0 0 -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
		/*
		width: 750px; 
		margin-left: -360px;
		*/
	}

	#dialog-historico-habilitacao .modal-body{
		
		max-height: 410px;
		height: 400px;			

	}

</style>
	
<div id='dialog-historico-habilitacao' class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="titulo-habilitacao">Historico de Habilitações da Entidade</h3>
	</div>

	<div class="modal-body">

		<table id="lista_historico_habilitacoes" class="table table-temp-hover table-condensed" >
			<thead>
				<tr>
			    	<th>Entidade</th>
			    	<th>Tipo de Agente</th>
			    	<th>GIFUG</th>
			    	<th>UF</th>
			    	<th>Finalização</th>
			    	<th>Validade</th>
			    	<th>Status</th>
			    	<th>Rating</th>
			    	<th>Ações</th>
			  	</tr>
			</thead>
			<tbody>

			<?php foreach($historico_habilitacao as $singlehabilitacao): ?>

				<?php 

					$HabilitacaoID				= htmlspecialchars($singlehabilitacao['HabilitacaoID'], ENT_QUOTES);
					$HabilitacaoConclusaoID 	= htmlspecialchars($singlehabilitacao['HabilitacaoConclusaoID'], ENT_QUOTES);
					$EntidadeCnpj				= htmlspecialchars($singlehabilitacao['EntidadeCnpj'], ENT_QUOTES);
					$EntidadeNomeFantasia		= htmlspecialchars($singlehabilitacao['EntidadeNomeFantasia'], ENT_QUOTES);//htmlspecialchars($habilitacao['EntidadeNomeRazao'], ENT_QUOTES, 'UTF_8');
					$EntidadeTipoDescricao		= htmlspecialchars($singlehabilitacao['EntidadeTipoDescricao'], ENT_QUOTES);
					$UnidadeSigla				= htmlspecialchars($singlehabilitacao['UnidadeSigla'], ENT_QUOTES);
					$EntidadeUF 				= htmlspecialchars($singlehabilitacao['EntidadeUF'], ENT_QUOTES);
					$HabilitacaoDataFinalizacao	= htmlspecialchars($singlehabilitacao['HabilitacaoDataFinalizacao'], ENT_QUOTES);
					$HabilitacaoValidade 		= htmlspecialchars($singlehabilitacao['HabilitacaoValidade'], ENT_QUOTES);
					$HabilitacaoRating			= htmlspecialchars($singlehabilitacao['HabilitacaoRating'], ENT_QUOTES);

					$finalizada = false;
					$statusHabilitacao = "";
					$classe = "";

					switch ($HabilitacaoConclusaoID) {

						case 1:
							$statusHabilitacao = "<div style='color:#ff8a00;'>Em Atualização</div>";
							$classe = "alert";
							break;

						case 2:
						case 3:
							if (date('Y-m-d') <= PPOEntity::toDateUnicode($HabilitacaoValidade) ){
								$statusHabilitacao = "<div style='color:#279d27;'>Vigente</div>";
								$classe = "alert-success";
							}else{
								$statusHabilitacao = "<div style='color:#ff0a2d;'>Vencida</div>";
								$classe = "alert-error";
							}
							break;

						case 4:
							$statusHabilitacao = "<div style='color:#ff0a2d;'>Negada</div>";
							$classe = "alert-error";
							break;
						case 5:
							$statusHabilitacao = "<div style='color:#ff0a2d;'>Desistência</div>";
							$classe = "alert-error";
						break;

					}

				?> 				

				<tr class="habilitacao_<?php echo $HabilitacaoID . ' ' . $classe ?>"  
					data-habilitacaoid = "<?php echo $HabilitacaoID; ?>" 
					data-entidadenomefantasia = "<?php echo $EntidadeNomeFantasia; ?>" 
					data-habilitacaovalidade = "<?php echo $HabilitacaoValidade; ?>" >
					
					<td><div class='habilitacao-EntidadeNomeFantasia'>		<?php echo $EntidadeNomeFantasia; ?> 		</div></td>
					<td><div class='habilitacao-EntidadeTipoDescricao'>		<?php echo $EntidadeTipoDescricao; ?>	</div></td>				
					<td><div class='habilitacao-UnidadeSigla'>				<?php echo $UnidadeSigla; ?>			</div></td>
					<td><div class='habilitacao-EntidadeUF'>				<?php echo $EntidadeUF; ?>				</div></td>
					<td><div class='habilitacao-HabilitacaoDataFinalizacao'><?php echo PPOEntity::toDateBr($HabilitacaoDataFinalizacao, "d/m/Y"); ?></div></td>
					<td><div class='habilitacao-HabilitacaoValidade'>		<?php echo PPOEntity::toDateBr($HabilitacaoValidade, "d/m/Y"); ?>	</div></td>
					<td><div class='habilitacao-statusHabilitacao'>			<?php echo $statusHabilitacao; ?>		</div></td>
					<td><div class='habilitacao-HabilitacaoRating'>			<?php echo $HabilitacaoRating; ?>		</div></td>
		
					<td>


					<?php if (user_has_access("HABILITACAO_VISUALIZAR")) echo TAG_A_VISUALIZAR; ?>

					</td>

				</tr>

			<?php endforeach; ?>

			</tbody>

		</table>

	</div>

	<div class="modal-footer form-actions">
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>		
	</div>

</div>

<script> 

	$("table#lista_historico_habilitacoes a.visualizar").off("click").on("click", function() {
		HabilitacaoID = $(this).closest("tr").data('habilitacaoid');		
		editarHabilitacao("VISUALIZAR_HABILITACAO", HabilitacaoID);
	});

</script>