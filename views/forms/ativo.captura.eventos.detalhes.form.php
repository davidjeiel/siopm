<script type="text/javascript">

	$(document).ready(function() {


	   $('table#lista_eventos_capturados').dataTable({
			"oLanguage": {
				"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
				"sInfoThousands": "."
			},
			"sEmptyTable": "Nenhum registro encontrado.",
			"aoColumnDefs":[
			    { "sType": "date-br", "aTargets": [ 0 ] }, 				 
				{ "sType": "money-br", "aTargets": [ 3 ] }, 			
				{ "orderable": false, "aTargets": [ 4 ] }
			],
			"sDom": '<"top">rt<"bottom"iflp><"clear">',
			 "bPaginate": false,
			"sScrollY": "410px"
		});

	});

</script>


<style>

	#dialog-manut-ativo-eventos-capturados {
		width: 975px;
		margin-left: -500px;
	}

	#dialog-manut-ativo-eventos-capturados .modal-body{
		/*overflow: hidden;*/
		max-height: 550px;
		height: 550px;
	}

</style>

<div id="dialog-manut-ativo-eventos-capturados" class="modal hide fade " >

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "�"--></button>
		<h3 id="titulo-manut"> <?php echo $tituloForm; ?></h3>
	</div>

	<div class="modal-body">

		<form id='formEventosDetalhes' name='formEventosDetalhes'>

			<div class="arquivo control-group in-line"> 

				<div class="control-group in-line">					
					<div class="controls">
						<label><?php echo $listaeventoscapturados['1']['ArquivoNome']; ?></label>
					</div>
				</div>

			</div>
		</form>	

		<div id="div_lista_eventos_capturados">
			<table id="lista_eventos_capturados" class="table table-striped table-temp-hover table-condensed">
				<thead>
					<tr>						
						<th>Data Evento</th>
						<th>Ativo</th>							
						<th>Evento</th>
						<th>Valor</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>

				<?php foreach($listaeventoscapturados as $eventos) { ?>
				<?php 

					$display_id = htmlspecialchars($eventos['PlanilhaEventosID'], ENT_QUOTES);
					
				?>
					<tr class="eventos_<?php echo $display_id; ?>"
					    data-eventosid="<?php echo $display_id ?>"						    
					>						
						<td><?php echo PPOEntity::toDateBr($eventos['DataEvento'], "d/m/Y"); ?></td>
						<td><?php echo $eventos['CodigoAtivo']; ?></td>							
						<td><?php echo $eventos['Evento']; ?></td>
						<td class="right"><?php echo  "R$ ". PPOEntity::toMoneyBr($eventos['Valor'], 2); ?></td>
						<td>	
						</td>
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