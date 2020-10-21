<?php
	$title = $siopm->getTitle();
	$custom_head .= $siopm->getJS("views", "report.eventos.js");
	ob_start(); // Começamos a armazenar tudo no buffer.
?>

	<script type="text/javascript">

		$(document).ready(function() {

			$('.input-daterange').datepicker({
				startView: 1,
				format: "mm/yyyy",
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

	<div class='cabecalho-report'>
		<h3 style="padding-left: 0px;"><?php echo $titulo_pagina; ?></h3>
		
		<form class="navbar">
			<div class="navbar-inner">

				<div class="control-group in-line">
					<label class="control-label">Tipo de Relatório</label>
					<div class="controls">
						<select class="span3" name="EntidadePapelID" id="EntidadePapelID">
							<option value="0">Por Ativo</option>
							<option value="1">Por Emissor</option>
							<option value="3">Por Cedente</option>
						</select>
					</div>
				</div>	

				<input type="hidden" id="ModalidadeID" name="ModalidadeID" 
					value='1'>
				</input>

	<!-- 			<div class="control-group in-line">
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
					<div class="input-daterange" id="datepicker">
						<input type="text" class="input-small" name="DataInicial" />
						<span class="add-on"> a </span>
						<input type="text" class="input-small" name="DataFinal" />
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
