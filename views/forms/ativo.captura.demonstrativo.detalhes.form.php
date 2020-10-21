<script type="text/javascript">

	$(document).ready(function() {


	   $('table#lista_demonstrativo_capturados').dataTable({
			"oLanguage": {
				"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
				"sInfoThousands": "."
			},
			"sEmptyTable": "Nenhum registro encontrado.",
			"aoColumnDefs":[			   		 
				{ "sType": "money-br", "aTargets": [ 1 ] }
			],
			"sDom": '<"top">rt<"bottom"iflp><"clear">',
			 "bPaginate": false,
			"sScrollY": "410px"
		});

	});

</script>


<style>

	#dialog-manut-ativo-demonstrativo-capturados {
		width: 700px;
		margin-left: -300px;
	}

	#dialog-manut-ativo-demonstrativo-capturados .modal-body{
		/*overflow: hidden;*/
		max-height: 550px;
		height: 550px;
	}

</style>

<div id="dialog-manut-ativo-demonstrativo-capturados" class="modal hide fade " >

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut"> <?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">

		<form id='formdemonstrativoDetalhes' name='formdemonstrativoDetalhes'>

			<div class="arquivo control-group in-line"> 

				<div class="control-group in-line">					
					<div class="controls">
						<label>Demonstrativo da data:&nbsp <?php echo PPOEntity::toDateBr($listademonstrativocapturados['1']['Data'], "d/m/Y") ; ?></label>
					</div>
				</div>

			</div>
		</form>	

		<div id="div_lista_demonstrativo_capturados">
			<table id="lista_demonstrativo_capturados" class="table table-striped table-temp-hover table-condensed">
				<thead>
					<tr>				
						<th>Ativo</th>													
						<th>Valor</th>						
					</tr>
				</thead>
				<tbody>

				<?php foreach($listademonstrativocapturados as $demonstrativo) { ?>
				<?php 

					$display_id = htmlspecialchars($demonstrativo['Id'], ENT_QUOTES);
					
				?>
					<tr class="demonstrativo_<?php echo $display_id; ?>"
					    data-demonstrativoid="<?php echo $display_id ?>"						    
					>						
						
						<td><?php echo $demonstrativo['TitulosPrivados']; ?></td>
						<td class="right"><?php echo  "R$ ". PPOEntity::toMoneyBr($demonstrativo['ValorContabil'], 2); ?></td>						
					</tr>

				<?php }; ?>

				</tbody>
			</table>	
		</div> 
	</div>

	<div class="modal-footer">		
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Sair</button>	
	</div>

</div>