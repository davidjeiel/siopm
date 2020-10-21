<script type="text/javascript">

	$(document).ready(function() {
		applyDataTableByID("lista_arquivos", "330px");
	});

	$(document).off("click", "table#lista_arquivos tbody tr td a.visualizar");
	$(document).on("click", "table#lista_arquivos tbody tr td a.visualizar", function() {
		var ArquivoID = $(this).closest("tr").data('arquivoid');
		window.open( app_path + "/controllers/propostas.arquivos.controller.php?ac=download&ArquivoID=" + ArquivoID );
	}); 

</script>

<div id="div_lista_arquivos" class='div_lista_arquivos'>
	<table id="lista_arquivos" class="table table-temp-hover table-condensed">
		<thead>
			<tr>
		    	<th>Arquivo</th>
		    	<th>Tipo</th>
		    	<th>Ações</th>
		  	</tr>
		</thead> 
		<tbody>

			<?php if (isset($arquivos)) foreach($arquivos as $arquivo): ?>

				<?php 
					$ArquivoID						= $arquivo['ArquivoID'];
					$PropostaArquivoID				= $arquivo['PropostaArquivoID'];
					$PropostaArquivoDescricao 		= $arquivo['PropostaArquivoDescricao'];
					$ArquivoNome					= $arquivo['ArquivoNome'];
				?> 

				<tr class					= "propostaarquivo_<?php echo $PropostaArquivoID 	?>"
					data-arquivoid			= "<?php echo $ArquivoID 					?>"
					data-propostaarquivoid	= "<?php echo $PropostaArquivoID			?>"
					data-arquivodescricao	= "<?php echo $PropostaArquivoDescricao 	?>"
					data-arquivonome		= "<?php echo $ArquivoNome 					?>"
				>
					<td><div class='ArquivoNome'> <strong><?php echo $ArquivoNome; ?></strong></div></td>
					<td><div class='PropostaArquivoDescricao'> <?php echo $PropostaArquivoDescricao; ?></div></td>
					<td>
						<?php 
							echo TAG_A_VISUALIZAR;
						?>
				    </td>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
</div>


