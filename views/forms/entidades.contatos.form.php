
<style>

	#dialog-entidade-contato {
		width: 1024px; 
	    margin-left: -512px;
	}

	#dialog-entidade-contato .modal-body{
		overflow: hidden;
	}

</style>

<script type="text/javascript">


	$(document).ready(function() {
		applyDataTableByID("lista_entidade_contatos", "290px");
	});

	$(document).off("click", ".div_lista_entidade_contatos table tbody tr td a.excluir");

	$(document).on("click", ".div_lista_entidade_contatos table tbody tr td a.excluir", function() {
		var EntidadeContatoID = $(this).closest("tr").data('entidadecontatoid');
		var ContatoNome = $(this).closest("tr").data('contatonome');
		bootbox.confirm("Tem certeza que deseja excluir o contato <b>" + ContatoNome + "</b>?", 
		function(confirmou) { 
			if (confirmou) {
				excluirEntidadeContato(EntidadeContatoID);
			}
		});
	});

	$(document).on("click", ".div_lista_entidade_contatos table tbody tr td a.editar", function() {
		
		tr=$(this).closest('tr');
						
		$("#div_lista_entidade_contatos").hide();

		$('#ContatoID').val($(tr).data("contatoid"));
		$('#EntidadeContatoID').val($(tr).data("entidadecontatoid"));
		$('#ContatoNome').val($(tr).data("contatonome"));
		$('#ContatoEmail').val($(tr).find('.ContatoEmail').text());
		$('#ContatoFone1').val($(tr).find('.ContatoFone1').text());
		$('#ContatoFone2').val($(tr).find('.ContatoFone2').text());
		$('#ContatoObs').val($(tr).find('.ContatoObs').text());

		$("#divCamposContato").show();
	
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

<div id="dialog-entidade-contato" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>

	<div class="modal-body">		

		<form id='formEntidadeContatos' name='formEntidadeContatos'>	

			<h4 type="text" for="EntidadeNomeFantasia" > 
				<?php echo (isset($entidade["EntidadeNomeFantasia"])) ? $entidade["EntidadeNomeFantasia"] : ""; ?> </h4>

			<input type="hidden" id="EntidadeID" name="EntidadeID" 
				value = '<?php echo (isset($entidade["EntidadeID"])) ? $entidade["EntidadeID"] : ""; ?>' ></input>
				
			<input type="hidden" id="ContatoID" name="ContatoID"></input>
			<input type="hidden" id="EntidadeContatoID" name="EntidadeContatoID"></input>
			
			<div id="divCamposContato" class="hide well">

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
						<input class="span6" maxlength="50" type="text" id="ContatoObs" name="ContatoObs"></input>
					</div>
				</div>

			</div>

		</form>		

		<div id="div_lista_entidade_contatos" class='div_lista_entidade_contatos'>

			<p><button class="btn_novo_contato btn btn-primary" type="button">Novo Contato</button></p>

			<table id="lista_entidade_contatos" class="table table-temp-hover table-condensed">
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
							$EntidadeContatoID	= $contato['EntidadeContatoID'];
							$ContatoNome 		= $contato['ContatoNome'];
							$ContatoFone1		= $contato['ContatoFone1'];
							$ContatoFone2		= $contato['ContatoFone2'];
							$ContatoEmail		= $contato['ContatoEmail'];
							$ContatoObs 		= $contato['ContatoObs'];

						?> 

						<tr class					= "entidadecontato_<?php echo $EntidadeContatoID    ?>"
							data-contatoid			= "<?php echo $ContatoID 			?>"
							data-entidadecontatoid	= "<?php echo $EntidadeContatoID 	?>"
							data-contatonome		= "<?php echo $ContatoNome  		?>"
						>
							<td width=140><div class='ContatoNome'> <?php echo $ContatoNome; ?></div></td>
							<td width=140><div class='ContatoEmail'> <?php echo $ContatoEmail; ?></div></td>
							<td><div class='ContatoFone1'> <?php echo $ContatoFone1; ?></div></td>
							<td><div class='ContatoFone2'> <?php echo $ContatoFone2 ; ?></div></td>
							<td><div class='ContatoObs'> <?php echo $ContatoObs; ?></div></td>
							<td>
								<?php 
										echo TAG_A_EDITAR . TAG_A_EXCLUIR;
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

