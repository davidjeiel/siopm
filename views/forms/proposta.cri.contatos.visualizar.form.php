
<div id="div_lista_proposta_contatos" class='div_lista_proposta_contatos'>
	<table id="lista_proposta_contatos" class="table table-temp-hover table-condensed">
		<thead>
			<tr>
		    	<th>Nome</th>
		    	<th>Email</th>
		    	<th>Fone 1</th>
		    	<th>Fone 2</th>
		    	<th>Observações</th>
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
				</tr>

			<?php endforeach; ?>

		</tbody>

	</table>

</div>
