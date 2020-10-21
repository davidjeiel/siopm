<script type="text/javascript">

	$(document).ready(function() {
		aplicaDataTable();
	});

</script>

<style>

	#dialog-manut-orcamento-valor-aplicado {
		width: 1024px; /* SET THE WIDTH OF THE MODAL */
		margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
		margin-top: -60px!important;
	}

	#dialog-manut-orcamento-valor-aplicado .modal-body{
		max-height: 550px;		
		overflow: hidden;	
	}

</style>


<div id="dialog-manut-orcamento-valor-aplicado" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"><?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">

		<form id='OrcamentoValorAplicado' name='OrcamentoValorAplicado'>	

				<!-- Cabeçalho para mostrar informações do ativo financeiro-->

			<div class="control-group in-line">
				<label class="control-label" for="OrcamentoAno">Ano</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="OrcamentoAno" name="OrcamentoAno" value = '<?php echo (isset($orcamento["OrcamentoAno"])) ? $orcamento["OrcamentoAno"] : ""; ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="OrcamentoSaldoInicial">Valor do Orçamento</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="OrcamentoSaldoInicial" name="OrcamentoSaldoInicial" value = '<?php echo (isset($orcamento["OrcamentoSaldoInicial"])) ?  "R$ ". PPOEntity::toMoneyBr($orcamento["OrcamentoSaldoInicial"] , 2) : ""; ?>' ></input>
					</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="Aplicado">Aplicado</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="Aplicado" name="Aplicado" value = ""></input>
					</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="Saldo">Saldo</label>
					<div class="controls">
						<input class="span3" readonly type="text" id="Saldo" name="Saldo" value = ""></input>
					</div>
			</div>

			<table id="lista_subscricoes" class="table table-striped table-temp-hover table-condensed">
				<thead>
					<tr>
						<th>Proposta</th>
						<th>Codigo SIOPM</th>
						<th>Data da Subscrição</th>
						<th class='right'>Quantidade &nbsp;</th>
						<th class='right'>Valor Nominal Unitário &nbsp;</th>
						<th class='right'>Volume &nbsp;</th>
					</tr>
				</thead>
				<tbody>

				<?php foreach($listasubscricoes as $subscricao) { ?>
				<?php 
					$display_id 		= htmlspecialchars($subscricao['SubscricoesID'], ENT_QUOTES);
					$display_id_ativo	= htmlspecialchars($subscricao['AtivoID'], ENT_QUOTES);
				?>
					<tr class="subscricao_<?php echo $display_id; ?>"
						data-subscricaoid="<?php echo $display_id ?>"
						data-ativoid="<?php echo $display_id_ativo ?>"
					>
						<td><?php echo $subscricao['PropostaNumero']; ?></td>
						<td><?php echo $subscricao['AtivoCodigoSIOPM']; ?></td>
						<td><?php echo PPOEntity::toDateBr($subscricao['SubscricoesData'], "d/m/Y"); ?></td>
						<td class='right'><?php echo  PPOEntity::toMoneyBr($subscricao['SubscricoesQuantidade'], 2); ?></td>
						<td class='right'><?php echo  "R$ ". PPOEntity::toMoneyBr($subscricao['SubscricoesValorUnitario'], 2); ?></td>
						<td class='right'><?php echo  "R$ ". PPOEntity::toMoneyBr($subscricao['SubscricoesVolume'], 2); ?></td>	
					</tr>

				<?php }; ?>

				</tbody>
				
			</table>

		</form>	
		
	</div>

	<div class="modal-footer">	
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Sair</button>
	</div>

</div>