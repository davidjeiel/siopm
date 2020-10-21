<style>

	#dialog-captura-eventos {
		width: 790px;
		margin-left: -412px;
	}

	#dialog-captura-eventos .modal-body{
		/*overflow: hidden;*/
		max-height: 150px;
		height: 150px;
	}


</style>


<script type="text/javascript">

	$(document).ready(function() {

		$("#btn_cancelar").off("click").on("click",
			function(){
				$("#dialog-arquivos-upload").modal("hide");
			}
		);

	});

</script>

<div id="dialog-captura-eventos" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>

	<div class="modal-body">

		<form id='formCapturaEventos' name='formCapturaEventos'>

			<div class="novo-arquivo control-group in-line"> 

				<div class="control-group in-line">					
					<div class="controls">
						<input class="span3" type="hidden" type="text" id="ArquivoDescricao" name="ArquivoDescricao" value = 'planilhaGecof' ></input>
					</div>
				</div>

				<div id="ArquivoUploader" name="ArquivoUploader" >
					<div class="controls up-list input-prepend input-append">
					<label class="control-label">Arquivo</label>
						<button id="add_Arquivo" class="btn up-add" type="button"><i class="icon-plus"></i></button>
						<input type='text' readonly class='span7 nome-arquivo' placeholder='Nenhum arquivo selecionado'></input>
						<button id="del_Arquivo" class="btn btn-snall up-remove" type="button"><i class="icon-remove"></i></button><b></b>
						<button id="up_Arquivo" class="btn btn-primary up-upload" type="button"><i class="icon-arrow-up icon-white"></i><span>Upload</span></button>
						<div class="controls progress">
							<div class=" bar bar-info barra-progresso"></div>
						</div>
					</div>
				</div>

			</div>
		</form>	

		

	</div>

	<div class="modal-footer">
		<button id="btn_cancelar" class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Sair</button>
	</div>

</div>


<?php $siopm->includeJS("views", "ativos.arquivos.capturaeventos.js"); ?>


