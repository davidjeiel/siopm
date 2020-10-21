
<style>

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-proposta-contato {
		width: 1024px; 
	    margin-left: -512px;
	}

	#dialog-proposta-contato .modal-body{
		overflow: hidden;
	}

</style>

<script type="text/javascript">

	
	$(document).ready(function() {
		applyDataTableByID("lista_proposta_contatos", "130px");
	});

	$(document).off("click", "table#lista_proposta_contatos tbody tr td a.excluir");

	$(document).on("click", "table#lista_proposta_contatos tbody tr td a.excluir", function() {
		var PropostaContatoID = $(this).closest("tr").data('propostacontatoid');
		var ContatoNome = $(this).closest("tr").data('contatonome');
		if (!($("#DataFinalizacao").val() > 0)){
			bootbox.confirm("Tem certeza que deseja excluir o contato <b>" + ContatoNome + "</b>?", 
			function(confirmou) { 
				if (confirmou) {
					excluirPropostaContato(PropostaContatoID);
				}
			});
		}
	});

	$(document).off("click", "table#lista_proposta_contatos tbody tr td a.editar");

	$(document).on("click", "table#lista_proposta_contatos tbody tr td a.editar", function() {
		if (!($("#DataFinalizacao").val() > 0)){
			tr=$(this).closest('tr');
							
			$("#div_lista_proposta_contatos").hide();

			$('#ContatoID').val($(tr).data("contatoid"));
			$('#PropostaContatoID').val($(tr).data("propostacontatoid"));
			$('#ContatoNome').val($(tr).data("contatonome"));
			$('#ContatoEmail').val($(tr).find('.ContatoEmail').text());
			$('#ContatoFone1').val($(tr).find('.ContatoFone1').text());
			$('#ContatoFone2').val($(tr).find('.ContatoFone2').text());
			$('#ContatoObs').val($(tr).find('.ContatoObs').text());
			$("#divCamposContato").show();
		}
	});

	$(".fone").focusout(function(){
	    var phone, element;
	    element = $(this);
	    element.unmask();
	    phone = element.val().replace(/\D/g, '');
	    if(phone.length > 10) {
	        element.mask("(99) 99999-999?9");
	    } else {
	        element.mask("(99) 9999-9999?9");
	    }
	}).trigger('focusout');

</script>

<div id="dialog-proposta-contato" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='formPropostaContatos' name='formPropostaContatos'>	

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>

			<input type="hidden" id="DataFinalizacao" name="DataFinalizacao" 
				value = '<?php echo (isset($proposta["DataFinalizacao"])) ? $proposta["DataFinalizacao"] : ""; ?>' ></input>

			<div class='controls'>

				<div class="control-group in-line">
					<label class="control-label" for="PropostaNumero">Número</label>
					<div class="controls">
						<input class="span3 gravar" readonly type="text" id="PropostaNumero" name="PropostaNumero" 
						value = '<?php echo (isset($proposta["PropostaNumero"])) ? $proposta["PropostaNumero"] : ""; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label " for="StatusNome">Status</label>
					<div class="controls">
						<input class="span3 gravar" readonly type="text" id="StatusNome" name="StatusNome" 
							value = '<?php echo (isset($proposta["StatusNome"])) ? $proposta["StatusNome"] : "Nova Proposta"; ?>' ></input>
					</div>
				</div>
		
			</div> 
			
			<div id="divCamposContato" class="hide well">

				<input type="hidden" id="ContatoID" name="ContatoID"></input>
				<input type="hidden" id="PropostaContatoID" name="PropostaContatoID"></input>

				<div class="control-group in-line">
					<label class="control-label" for="ContatoNome">Nome</label>
					<div class="controls">
						<input class="span6" maxlength="50" type="text" id="ContatoNome" name="ContatoNome" ></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ContatoEmail">Email</label>
					<div class="controls">
						<input class="span6" maxlength="50" type="text" id="ContatoEmail" name="ContatoEmail"></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ContatoFone1">Fone 1</label>
					<div class="controls">
						<input class="span3 fone" maxlength="20" type="text" id="ContatoFone1" name="ContatoFone1"></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ContatoFone2">Fone 2</label>
					<div class="controls">
						<input class="span3 fone" maxlength="20" type="text" id="ContatoFone2" name="ContatoFone2"></input>
					</div>
				</div>

				<div class="control-group in-line">
					<label class="control-label" for="ContatoObs">Observações</label>
					<div class="controls">
						<input class="span6" maxlength="50"type="text" id="ContatoObs" name="ContatoObs"></input>
					</div>
				</div>

			</div>

		</form>		

		<div id="div_lista_proposta_contatos" class='div_lista_proposta_contatos'>

			<p><button class="btn_novo_contato btn btn-primary" type="button">Novo Contato</button></p>

			<table id="lista_proposta_contatos" class="table table-temp-hover table-condensed">
				<thead>
					<tr>
				    	<th>Nome</th>
				    	<th>Email</th>
				    	<th>Fone 1</th>
				    	<th>Fone 2</th>
				    	<th>Observações</th>
				    	<th>Ações</th>
				  	</tr>
				</thead> 
				<tbody>

					<?php if (isset($contatos)) foreach($contatos as $contato): ?>

						<?php 

							$ContatoID			= $contato['ContatoID'];
							$PropostaContatoID	= $contato['PropostaContatoID'];
							$ContatoNome 		= $contato['ContatoNome'];
							$ContatoFone1		= $contato['ContatoFone1'];
							$ContatoFone2		= $contato['ContatoFone2'];
							$ContatoEmail		= $contato['ContatoEmail'];
							$ContatoObs 		= $contato['ContatoObs'];

						?> 

						<tr class					= "propostacontato_<?php echo $PropostaContatoID    ?>"
							data-contatoid			= "<?php echo $ContatoID 			?>"
							data-propostacontatoid	= "<?php echo $PropostaContatoID 	?>"
							data-contatonome		= "<?php echo $ContatoNome  		?>"
						>
							<td><div class='ContatoNome'> <?php echo $ContatoNome; ?></div></td>
							<td><div class='ContatoEmail'> <?php echo $ContatoEmail; ?></div></td>
							<td><div class='ContatoFone1'> <?php echo $ContatoFone1; ?></div></td>
							<td><div class='ContatoFone2'> <?php echo $ContatoFone2 ; ?></div></td>
							<td><div class='ContatoObs'> <?php echo $ContatoObs; ?></div></td>
							<td>
								<?php 
									if (!isset($proposta["DataFinalizacao"]) || $proposta["DataFinalizacao"] == ""){ 
										echo TAG_A_EDITAR . TAG_A_EXCLUIR;
									} 
								?>
						    </td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	</div>

	<div class="modal-footer">
		<button id="btn_salvar" class="btn_salvar btn btn-primary">Salvar alterações</button>
		<button id="btn_cancelar" class="btn_cancelar btn" aria-hidden="true" >Cancelar</button>
	</div>

</div>

