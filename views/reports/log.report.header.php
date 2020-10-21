<?php
	$custom_head .= $siopm->getJS("views", "report.log.js");
	ob_start(); // Começamos a armazenar tudo no buffer.
?>

<script type="text/javascript">
	$(document).ready(function() {

		$('.input-daterange').datepicker({
			startView: 0,
			format: "dd/mm/yyyy",
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
		<h3 style="padding-left: 0px;"><?php echo $tituloPagina; ?></h3>
		<form class="navbar">
			<div class="navbar-inner">
				<div class="control-group in-line">
					<label class="control-label" for="Matricula">Matrícula</label>
					<div class="controls">
						<select class="span4" name="Matricula" id="Matricula">
							<option value="0"> &#60;Todas&#62;</option>
							<?php if (isset($usuarios)) foreach($usuarios as $usuario): ?>
								<option value='<?php echo $usuario["Matricula"] ?>' ><?php echo $usuario["Matricula"] . " - " . $usuario["Nome"]; ?> </option>
							<?php endforeach; ?>
						</select>						
					</div>
				</div>
				<div class="control-group in-line">
					<label class="control-label" for="Modulo">Modulos do Sistema</label>
					<div class="controls">
						<select class="span4" name="Modulo" id="Modulo">
							<option value="0">&#60;Todos&#62;</option>
							<?php if (isset($modulos)) foreach($modulos as $modulo): ?>
								<option value='<?php echo $modulo["Modulo"] ?>' ><?php echo $modulo["Modulo"] . " - " . $modulo["Descricao"]; ?> </option>
							<?php endforeach; ?>
						</select>						
					</div>
				</div>
				<div class="control-group in-line">
					<label class="control-label" for="Tipo">Tipo de LOG</label>
					<div class="controls">
						<select class="span4" name="Tipo" id="Tipo">
							<option value="0">&#60;Todos&#62;</option>
							<?php if (isset($tipos)) foreach($tipos as $tipo): ?>
								<option value='<?php echo $tipo["Tipo"] ?>' ><?php echo $tipo["Descricao"]; ?> </option>
							<?php endforeach; ?>
						</select>						
					</div>
				</div>
				<div class="control-group in-line">
					<label class="control-label"><b>Período</b> </label>
					<div class="input-daterange" id="datepicker">
						<input type="text" class="input-small" name="DataInicial" />
						<span class="add-on"> a </span>
						<input type="text" class="input-small" name="DataFinal" />
					</div>
				</div>
				<a class="btn btn-primary gerar-relatorio"> Gerar Relatório </a>
			</div>
		</form>
	</div>
	<div class='corpo-report'>
		<span id='spanBody'></span>
	</div>
	<div class='rodape-report'>
		<span id='spanFooter'></span>
	</div>

<?php $contents = ob_get_clean(); ?>
