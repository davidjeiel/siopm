<script type="text/javascript">

$(document).ready(function() {

	$('.input-append.date').each(function () {
		var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
		$(this).datepicker(config).on('changeDate', function(ev){
			  $(this).datepicker('hide');
		});  

	});

	$("#formFinalizarHabilitacao").validate({

		rules: {
			HabilitacaoDataFinalizacao: {required: true},
			HabilitacaoConclusaoID: {required: true},
			HabilitacaoValidade: {
				required: {
	                depends: function(element) {
	                    return $("#HabilitacaoConclusaoID").val() == "2";
	                }
	            }
            }
		},

		messages: { 
			HabilitacaoDataFinalizacao: { required: 'Campo obrigatório'},
			HabilitacaoConclusaoID: { required: 'Campo obrigatório' },
			HabilitacaoValidade: { required: 'Campo obrigatório' }
		}, 
	  
	  showErrors: function(errorMap, errorList) {
		$.each(this.successList, function(index, value) {
		  return $(value).popover("hide");
		});
		return $.each(errorList, function(index, value) {
		  var _popover;
		  _popover = $(value.element).popover({
			trigger: "manual",
			placement: "top", 
			content: value.message,
			template: "<div  class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content alert-error\"><p></p></div></div></div>"
		  });
		  _popover.data("popover").options.content = value.message;
		  return $(value.element).popover("show");
		});
	  }

	});

});


</script>

<style type="text/css">

	#dialog-finalizar-habilitacao {	
		width: 980px; 
		margin-left: -520px;
	}

	#dialog-finalizar-habilitacao .modal-body{
		max-height: 380px;
		overflow: hidden;
	}

	#dialog-finalizar-habilitacao .add-on{
		margin-bottom: 25px;
	}

</style>


<div id="dialog-finalizar-habilitacao" class="modal" tabindex="-1" role="dialog" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut-usuario">Habilitação</h3>
	</div>

	<div class="modal-body">

		<legend>Finalizar Habilitação</legend>

		<form id="formFinalizarHabilitacao" name="formFinalizarHabilitacao" >

			<input type="hidden" id="HabilitacaoID" name="HabilitacaoID" 
			 value = '<?php echo (isset($habilitacao["HabilitacaoID"])) ? $habilitacao["HabilitacaoID"] : ""; ?>' ></input>

					<div class="control-group input-append date in-line" id="dpHabilitacaoDataFinalizacao" 
						data-date="" data-date-format="dd/mm/yyyy" >
						<label class="control-label" for="HabilitacaoDataFinalizacao">Data da Finalização</label>
						<div class="controls">
							<input style="width:180px;background:#FFF;" maxlength="10" class="gravar" type="text" readonly 
								id="HabilitacaoDataFinalizacao" 
								name="HabilitacaoDataFinalizacao" 
								value = '<?php echo (isset($habilitacao["HabilitacaoDataFinalizacao"])) ? PPOEntity::toDateBr($habilitacao["HabilitacaoDataFinalizacao"], "d/m/Y") : ""; ?>' ></input>
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>		
		

					<div class="control-group in-line">
						<label class="control-label">Conclusão</label>
						<div class="control">
							<select class="gravar span3" name="HabilitacaoConclusaoID" id="HabilitacaoConclusaoID" >
								<option value="">Selecione</option>
								<?php 
									$selected = "";
									foreach($conclusoes as $row){ 

										if ($hab_juridica['HabJuridicaConclusaoID'] == 4){
											if($row["ConclusaoID"] == 4){
												$selected = "selected = 'selected'"; 
												echo "<option $selected; value='$row[ConclusaoID]' >$row[ConclusaoAliasHabilitacao]</option>";
											}
										}else {
											if (isset($row["ConclusaoID"]) && trim($row["ConclusaoID"]) == trim($habilitacao["HabilitacaoConclusaoID"])){
												$selected = "selected = 'selected'"; 
											}else $selected=" ";	

											if($row["ConclusaoID"] != 3){
												echo "<option $selected; value='$row[ConclusaoID]' >$row[ConclusaoAliasHabilitacao]</option>";
											}	
										}
									}
								?>
							</select>
						</div>
					</div>			

			<?php

				$readonly 	= "";
				$rating 	= "";

				if ($hab_risco["HabRiscoRating"] !== ""){ 

					$readonly 	= "readonly";
					$rating 	= $hab_risco["HabRiscoRating"];

				}

			?>

			<div class="control-group in-line">
				<label class="control-label" for="HabilitacaoRating">Rating</label>
				<div class="controls">
					<input <?php echo $readonly; ?> class="gravar span3" style="text-transform:uppercase" maxlength="5" type="text" id="HabilitacaoRating" name="HabilitacaoRating" 
					value = '<?php echo $rating; ?>' ></input>
				</div>
			</div>


		<?php

			$HabilitacaoValidade = "";

			if ($hab_risco["HabRiscoValidade"] > 0){

				$HabilitacaoValidade = PPOEntity::toDateBr($hab_risco["HabRiscoValidade"], "d/m/Y"); ?>

				<div class="control-group in-line">
					<label class="control-label" for="HabilitacaoValidade">Validade</label>
					<div class="controls">
						<input  type="text" maxlength="10" readonly class="gravar span3" id="HabilitacaoValidade" name="HabilitacaoValidade" 
							value = '<?php echo PPOEntity::toDateBr($HabilitacaoValidade, "d/m/Y") ?>' ></input>
					</div>
				</div>

		<?php 

			}else{ 	?>

				<div class="control-group input-append date" id="dpHabilitacaoValidade" 
					data-date="" data-date-format="dd/mm/yyyy" >
					<label class="control-label" for="HabilitacaoValidade">Validade</label>
					<div class="controls">
						<input style="width:180px;background:#FFF;" maxlength="10" class="gravar" type="text" readonly
							id="HabilitacaoValidade" 
							name="HabilitacaoValidade" 
							value = '<?php echo (isset($habilitacao["HabilitacaoValidade"])) ? $habilitacao["HabilitacaoValidade"] : ""; ?>' ></input>
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>
				</div>

		<?php } ?>

			<div class="control-group in-line">
				<label for="HabilitacaoObservacoes">Observações</label>
				<div class="control">
					<textarea class='span12' maxlength="1000" type="text" id="HabilitacaoObservacoes" name="HabilitacaoObservacoes" ><?php echo (isset($habilitacao["HabilitacaoObservacoes"])) ? $habilitacao["HabilitacaoObservacoes"] : ""; ?></textarea>
				</div>
			</div>

		</form>

	</div>

	<div class="modal-footer">
		<button id="btn_finalizar" class="btn btn-primary">Finalizar Habilitação</button>
		<button class="btn_cancelar btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>

</div>
