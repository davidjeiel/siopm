<?php
	$title = $siopm->getTitle();
	$custom_head .= $siopm->getJS("views", "report.orcamentos.js");
	ob_start(); // Começamos a armazenar tudo no buffer.
?>

	<script type="text/javascript">

		$(document).ready(function() {

			
			$('.input-daterange').datepicker({
				//startDate: new Date("2014-12-01"),
				startView: "decade",
				format: "yyyy",
				minViewMode: 1,
				language: "pt-BR",
				todayHighlight: true,
				autoclose: true
			});

			$(".cabecalho-report form").validate({
				rules: {	  	
					DataInicial: {required: true},
					DataFinal: {required: true}
				},
				messages: { 
					DataInicial: {required: 'Campo obrigatório'},
					DataFinal: { required: 'Campo obrigatório'}
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
<div id=''
	<div class='cabecalho-report'>
		<h3 style="padding-left: 0px;"><?php echo $tituloPagina; ?></h3>
		<form class="navbar">
			<div class="navbar-inner ">	

				<div class="control-group in-line">
					<label class="control-label" for="TipoRelatorio">Tipo</label>
					<div class="controls">
						<select class="span3" name="TipoRelatorio" id="TipoRelatorio">
							<option value="1">Por CRI</option>
							<option value="2">Por Emissor</option>
							<option value="3">Por Cedente</option>
						</select>
					</div>
				</div>


				<input type="hidden" id="ModalidadeID" name="ModalidadeID" 
					value='1'>
				</input>

			<!-- 

				<div class="control-group in-line hide">
					<label class="control-label" for="ModalidadeID">Modalidade</label>
					<div class="controls">
						<select class="span4" name="ModalidadeID" id="ModalidadeID">
							<option value="">Todas</option>
							<?php if (isset($modalidades)) foreach($modalidades as $row): ?>
								<option value='<?php echo $row["ModalidadeID"] ?>' ><?php echo $row["ModalidadeNome"] . " - " . $row["ModalidadeSetor"]; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div> -->

				

				<div class="control-group in-line">
					<label class="control-label"><b>Período</b> </label>
					<!-- <div class="input-daterange" id="datepicker"> -->
					<div class="input-daterange" >
						<div class="controls in-line">
							<select class="span2" name="DataInicial" id="DataInicial">
								<option value="">Selecione</option>
								<?php if (isset($anosOrcamentarios)) foreach($anosOrcamentarios as $row): ?>
									<option value='<?php echo $row["OrcamentoAno"] ?>' ><?php echo $row["OrcamentoAno"]; ?> </option>
								<?php endforeach; ?>
							</select>
							<span class="in-line"> à </span>
							<select class="span2" name="DataFinal" id="DataFinal">
								<option value="">Selecione</option>
								<?php if (isset($anosOrcamentarios)) foreach($anosOrcamentarios as $row): ?>
									<option value='<?php echo $row["OrcamentoAno"] ?>' ><?php echo $row["OrcamentoAno"]; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<a class="btn btn-primary gerar-relatorio"> Gerar Relatório </a>
				<a class="btn btn-primary gerar-excel"> Gerar Excel </a>
			</div>
		</form>
	</div>

	<div class='corpo-report'>
		<span id='spanBody'></span>
	</div>
	
	<div class='rodape-report'>
		<span id='spanFooter'></span>
	</div>
<?php

	$contents = ob_get_clean(); // Transferimos o buffer para a variável.
	
?>
