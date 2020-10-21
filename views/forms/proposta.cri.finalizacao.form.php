<?php

	/* variáveir utilizadas para controlar a vizuzlização de componentes no FORM */
	
	$hideFinalizar = " hide ";
	$propostaFinalizadaHide = "";
	$totalErros = count($inconsistencias); 

	if ($totalErros == 0 && isset($proposta["PropostaFaseID"]) || 
		(($proposta["PropostaFaseID"] == 1 && user_has_access("CRI_PRELIMINAR_FINALIZAR_COM_ERRO")) ||
		($proposta["PropostaFaseID"] == 2 && user_has_access("CRI_DEFINITIVA_FINALIZAR_COM_ERRO")))
	){
		$hideFinalizar = " ";
	}
 
	if( isset($proposta["DataFinalizacao"]) && $proposta["DataFinalizacao"] > 0){
		$propostaFinalizadaHide = " hide ";
	}

?>

<style type="text/css">

	#PropostaNumero{
		font-weight: bold;
	}

	#dialog-finalizacao{
		width: 1024px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -505px;
	}

	#dialog-finalizacao #lista_erros_proposta td{
		font-maxlength: 12px;
	}

	#dialog-finalizacao .control-label {
		margin-right: 20px;
	}

	#dialog-finalizacao .modal-body{	
		overflow: hidden;
		max-height: 975px;
	}

	#dialog-finalizacao .input-append.date input{
		background:#FFF;
	}

	#dialog-finalizacao input{
		padding-right: 8px;
	}

	#dialog-finalizacao .date{
		margin-top: -25px;
	}

</style>

<script type="text/javascript">

	$(document).ready(function() {


		$('.input-append.date').each(function () {
			var config = { format: "dd/mm/yyyy", weekStart: 0, language:"pt-BR", todayHighlight: true, "autoclose": true};
			$(this).datepicker(config).on('changeDate', function(ev){
				  $(this).datepicker('hide');
			});  

		});

		maskFormBr(2,8);
		
		
		$('table#lista_erros_proposta').dataTable({
			"oLanguage": {
				"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
				"sInfoThousands": "."
			},
			"sEmptyTable": "Nenhum registro encontrado.",
			"sDom": '<"top">rt<"bottom"iflp><"clear">',
			"bLengthChange": false,
			"bPaginate": false,
			"sScrollY": "240px"
		});

	});

	$("#formFinalizacao").validate({
		rules: {
			ValorAprovadoGEFOM: {required: true},
			DataFinalizacao: {required: true},
			PropostaStatusID: {required: true}
		},
		messages: { 
			ValorAprovadoGEFOM: {required: 'Campo obrigatório'},
			DataFinalizacao: {required: 'Campo obrigatório'},
			PropostaStatusID: {required: 'Campo obrigatório'}
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


</script>

<div id="dialog-finalizacao" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form?></h3>
	</div>
	<div class="modal-body">

		<form id="formFinalizacao" name="formFinalizacao" >

			<input type="hidden" id="PropostaID" name="PropostaID" 
				value = '<?php echo (isset($proposta["PropostaID"])) ? $proposta["PropostaID"] : ""; ?>' ></input>

			<input type="hidden" id="PropostaFaseID" name="PropostaFaseID" 
				value = '<?php echo (isset($proposta["PropostaFaseID"])) ? $proposta["PropostaFaseID"] : "$fase"; ?>' ></input>

			<input type="hidden" id="PropostaDetalheID" name="PropostaDetalheID" 
				value = '<?php echo (isset($proposta["PropostaDetalheID"])) ? $proposta["PropostaDetalheID"] : ""; ?>' ></input>

			<div class='controls'>

				<div class="control-group in-line">
					<label class="control-label" for="PropostaNumero">Número</label>
					<div class="controls">
						<input class="span3 gravar" readonly type="text" id="PropostaNumero" name="PropostaNumero" 
						value = '<?php echo (isset($proposta["PropostaNumero"])) ? $proposta["PropostaNumero"] : ""; ?>' ></input>
					</div>
				</div>
		
				<!-- Não será mostrado quando a proposta estiver finalizada -  Variavel de controle através do PHP: $propostaFinalizadaHide -->
				<span class=' <?php echo $propostaFinalizadaHide ?>'>
					<div class="control-group in-line">
						<label class="control-label " for="StatusNome">Status</label>
						<div class="controls">
							<input class="span3 gravar" readonly type="text" id="StatusNome" name="StatusNome" 
								value = '<?php echo (isset($proposta["StatusNome"])) ? $proposta["StatusNome"] : "Nova Proposta"; ?>' ></input>
						</div>
					</div>
				</span>
				<div class="control-group in-line">
					<label class="control-label" for="PropostaFaseNome">Fase</label>
					<div class="controls">
						<input class="span3 gravar" readonly type="text" id="PropostaFaseNome" name="PropostaFaseNome" 
							value = '<?php echo (isset($proposta["PropostaFaseNome"])) ? $proposta["PropostaFaseNome"] : (($fase == 1) ? "PRELIMINAR" : "DEFINITIVA") ; ?>' ></input>
					</div>
				</div>

				<div class="control-group in-line">
				    <label class="control-label" for="DataRecepcao">Data de Recepção</label>
				    <div class="controls">
				        <input id="DataRecepcao" name="DataRecepcao" class="gravar span3" type="text" 
				        	value= '<?php echo (isset($proposta["DataRecepcao"])) ? 
															PPOEntity::toDateBr($proposta["DataRecepcao"], "d/m/Y") : ""; ?>' 
				        	readonly="readonly"></input>
				    </div>
				</div>

			</div> 

			<div class="control-group in-line">
				<label class="control-label" for="ValorCRISenior">Valor CRI (Sênior)</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda" readonly type="text" id="ValorCRISenior" name="ValorCRISenior" 
							value = '<?php echo (isset($proposta["ValorCRISenior"])) ?  PPOEntity::toMoneyBr($proposta["ValorCRISenior"]) : ""; ?>' ></input>
				</div>
			</div>


			<div class="control-group in-line">
				<label class="control-label" for="ValorAprovadoGEFOM">Valor Aprovado GEFOM</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda"  maxlength="20" <?php if ($fase == 2) echo "readonly"; ?> type="text" id="ValorAprovadoGEFOM" name="ValorAprovadoGEFOM" 
					value = '<?php echo (isset($proposta["ValorAprovadoGEFOM"])) ?  PPOEntity::toMoneyBr($proposta["ValorAprovadoGEFOM"]) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group input-append date in-line" id="dpDataFinalizacao" data-date="" data-date-format="dd/mm/yyyy">
				<label class="control-label" for="DataFinalizacao">Data</label>
				<div class="controls">
					<input style="width:180px;" maxlength="16" class="span3" readonly="readonly" type="text" id="DataFinalizacao" 
						name="DataFinalizacao" value = '<?php echo (isset($proposta["DataFinalizacao"])) ? 
						PPOEntity::toDateBr($proposta["DataFinalizacao"], "d/m/Y") : ""; ?>' ></input>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label">Proposta Aprovada?</label>
				<div class="control">
					<select class="span3" name="PropostaStatusID" id="PropostaStatusID">
					<option value="">Selecione</option>
						<?php $selected = ""; ?>
						<?php if (isset($status)) foreach($status as $row): ?>
							<?php 
								if (isset($row["PropostaStatusID"])){
									 if (isset($proposta["PropostaStatusID"]) && $row["PropostaStatusID"] == $proposta["PropostaStatusID"]) 
											$selected = "selected = 'selected'"; else $selected="";
								} 
							?>
							<option <?php echo $selected; ?> value='<?php echo $row["PropostaStatusID"] ?>' ><?php echo $row["StatusNome"]; ?> </option>
						<?php endforeach; ?>
					</select>
				</div>

			</div>
		
			<!--<span id='spanErrosFinalizacao'></div>-->
			<?php if ($totalErros>0){ ?>
				<div id='div_lista_erros_proposta'>
					<p><strong>Foram encontrados erros que impedem a finalização da proposta.</strong></p>
					<table id='lista_erros_proposta' class='table table-striped table-condensed'>
						<thead>
							<tr>								
								<th>Local</th>
								<th>Aba</th>
								<th>Descrição do erro</th>
								<th>Ação</th>
							</tr>
						</thead>
						<tbody>

							<?php if (isset($inconsistencias)) foreach($inconsistencias as $inconsistencia): ?>

							<?php 
								$acao 		= $inconsistencia["Acao"];
								$local 		= $inconsistencia["Local"];
								$aba 		= $inconsistencia["Aba"];
								$campo		= $inconsistencia["Campo"];
								$msgErro	= ($inconsistencia["MsgErro"] == "") ? "O campo <strong>$campo</strong> não foi informado corretamente." : $inconsistencia["MsgErro"];
								$abaID 		= $inconsistencia["AbaID"];
								$campoID	= $inconsistencia["CampoID"];
								$propID 	= $inconsistencia["PropostaID"];
								$detID 		= $inconsistencia["PropostaDetalheID"];
							?>
								<tr class='alert-error' data-acao='$acao'>									
									<td> <?php echo $local ?> </td>
									<td> <?php echo $aba ?> </td>
									<td> <?php echo $msgErro ?> </td>
									<td> <a href='#' onClick='<?php echo "goErroPropostaCRI(\"$acao\", $propID, $detID, \"$abaID\", \"$campoID\");" ?>' > Exibir </a></td>
								</tr>
							
							<?php endforeach; ?>

						</tbody>
					</table>
				</div>
			<?php } ?>
		</form>

	</div>
	<div class="modal-footer">
		<button id="btn_finalizar" class="btn btn-danger finalizar-proposta <?php echo $hideFinalizar; ?> ">Finalizar Proposta</button>
		<button id="btn_cancelar" class="btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>

