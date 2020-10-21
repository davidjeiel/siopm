<style type="text/css">
	#formManifAgentes{
		margin: 0px;
	}
	.tab-content{
		overflow:hidden;
	}

</style>

<script type="text/javascript">

$(document).ready(function() {

	$("#GifugArquivoNome").off("click").on("click", function(){
		window.open(app_path + "/controllers/propostas.arquivos.controller.php" 	+ "?ac=download&ArquivoID=" + $('#GifugArquivoID').val() );
	});
	$("#GefomArquivoNome").off("click").on("click", function(){
		window.open(app_path + "/controllers/propostas.arquivos.controller.php" 	+ "?ac=download&ArquivoID=" + $('#GefomArquivoID').val() );
	});
	$("#PropResolucaoArquivoNome").off("click").on("click", function(){
		window.open(app_path + "/controllers/propostas.arquivos.controller.php" 	+ "?ac=download&ArquivoID=" + $('#PropResolucaoArquivoID').val() );
	});
});

</script>
<form id="formManifAgentes" name="formManifAgentes" >
	<h3>Manifestações do Agente Operador</h3>
	<?php
		$show_resolucao = "";
		if ($fase == 1){
			$show_resolucao = "hide";
		}
	?>

	<ul class="nav nav-tabs" id="navPropostas">
		<li class="active"	><a href="#tabManifGifug" data-toggle="tab">Manifestação GIFUG</a></li>
		<li					><a href="#tabManifGefom" data-toggle="tab">Manifestação SUFUG</a></li>
		<li	class= "<?php echo $show_resolucao; ?>" ><a href="#tabResolucao" data-toggle="tab">Resolução do Conselho</a></li>
	</ul>

	<div id="tabPropostas" class="tab-content">

		<!-- =========================================================== INICIO tabManifGifug 			=========================================================== -->
		<div class="tab-pane active fade in" id='tabManifGifug'>

			<div class="control-group in-line">
				<label class="control-label" for="ManifGifugData">Data</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="ManifGifugData" name="ManifGifugData" 
						value = '<?php echo (isset($manifGifug["ManifGifugData"])) ? 
												PPOEntity::toDateBr($manifGifug["ManifGifugData"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="GifugConclusaoID">Conclusão</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="GifugConclusaoID" name="GifugConclusaoID" 
					value = '<?php echo (isset($manifGifug["ConclusaoDescricao"])) ? $manifGifug["ConclusaoDescricao"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ManifGifugObs">Texto Conclusivo</label>
				<div class="controls">
					<textarea class="span12" readonly maxlength="1000" type="text" id="ManifGifugObs" name="ManifGifugObs" ><?php echo (isset($manifGifug["ManifGifugObs"])) ? $manifGifug["ManifGifugObs"] : ""; ?></textarea>
				</div>
			</div>

			<input type="hidden" id="GifugArquivoID" name="GifugArquivoID" 
						value = '<?php echo (isset($manifGifug["GifugArquivoID"])) ? $manifGifug["GifugArquivoID"] : ""; ?>' ></input>

			<div class="control-group in-line">
				<label class="control-label">
				<?php 
					if (isset($manifGifug["GifugArquivoNome"])) 
						echo '<a id="GifugArquivoNome" href="#" class="up-file-name">'.$manifGifug["GifugArquivoNome"]."</a>";
					else 
						echo "<span class='alert-danger'>Arquivo não encontrado!</span>"; 
				?>
				</label>
			</div><!-- Fim do CONTAINER do upload de arquivo -->

		</div> <!-- Fim tabManifGifug -->
		
		<!-- =========================================================== INICIO tabManifGefom 			=========================================================== -->
		<div class="tab-pane fade in" id='tabManifGefom'>

			<div class="control-group in-line">
				<label class="control-label" for="ManifGefomData">Data</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="ManifGefomData" name="ManifGefomData" 
						value = '<?php echo (isset($manifGefom["ManifGefomData"])) ? 
												PPOEntity::toDateBr($manifGefom["ManifGefomData"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

			<?php if ($fase == 2) { ?>

				<div class="control-group in-line ">
					<label class="control-label" for="GefomOficioVoto">Voto VIFUG</label>
					<div class="controls">
						<input class="span3" maxlength="10"  readonly type="text" id="GefomOficioVoto" name="GefomOficioVoto" 
							value = '<?php echo (isset($manifGefom["GefomOficioVoto"])) ? $manifGefom["GefomOficioVoto"] : ""; ?>' ></input>
					</div>
				</div>

			<?php } ?>

			<div class="control-group in-line">
				<label class="control-label" for="GefomConclusaoID">Conclusão</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="GefomConclusaoID" name="GefomConclusaoID" 
					value = '<?php echo (isset($manifGefom["ConclusaoDescricao"])) ? $manifGefom["ConclusaoDescricao"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ValorAprovadoGEFOM">Valor Aprovado GEFOM</label>
				<div class="controls">
					<input class="span3 campo-formatado moeda"  maxlength="20" readonly type="text" id="ValorAprovadoGEFOM" name="ValorAprovadoGEFOM" 
					value = '<?php echo (isset($proposta["ValorAprovadoGEFOM"])) ?  PPOEntity::toMoneyBr($proposta["ValorAprovadoGEFOM"]) : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="ManifGefomObs">Texto Conclusivo</label>
				<div class="controls">
					<textarea class="span12" readonly maxlength="1000" type="text" id="ManifGefomObs" name="ManifGefomObs" ><?php echo (isset($manifGefom["ManifGefomObs"])) ? $manifGefom["ManifGefomObs"] : ""; ?></textarea>
				</div>
			</div>

			<input type="hidden" id="GefomArquivoID" name="GefomArquivoID" 
				value = '<?php echo (isset($manifGefom["GefomArquivoID"])) ? $manifGefom["GefomArquivoID"] : ""; ?>' ></input>

			<div class="control-group in-line">
				<label class="control-label">
				<?php 
					if (isset($manifGefom["GefomArquivoNome"])) 
						echo '<a id="GefomArquivoNome" href="#" class="up-file-name">'.$manifGefom["GefomArquivoNome"]."</a>";
					else 
						echo "<span class='alert-danger'>Arquivo não encontrado!</span>"; 
				?>
				</label>
			</div>
			
		</div> <!-- Fim tabManifGefom -->

		<!-- =========================================================== INICIO tabResolucao 			=========================================================== -->
		<div class="tab-pane fade in" id='tabResolucao'>

			<div class="control-group in-line">
				<label class="control-label" for="PropResolucaoData">Data</label>
				<div class="controls">
					<input class="span3" readonly type="text" id="PropResolucaoData" name="PropResolucaoData" 
						value = '<?php echo (isset($resolucao["PropResolucaoData"])) ? 
												PPOEntity::toDateBr($resolucao["PropResolucaoData"], "d/m/Y") : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line ">
				<label class="control-label" for="PropResolucaoNumero">Número da Resolução</label>
				<div class="controls">
					<input class="span3" readonly maxlength="10" type="text" id="PropResolucaoNumero" name="PropResolucaoNumero" 
						value = '<?php echo (isset($resolucao["PropResolucaoNumero"])) ? $resolucao["PropResolucaoNumero"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropResolucaoConclusaoID">Conclusão</label>
				<div class="controls">
					<input class="span3" type="text" readonly maxlength="10" id="PropResolucaoConclusaoID" name="PropResolucaoConclusaoID" 
					value = '<?php echo (isset($resolucao["ConclusaoDescricao"])) ? $resolucao["ConclusaoDescricao"] : ""; ?>' ></input>
				</div>
			</div>

			<div class="control-group in-line">
				<label class="control-label" for="PropResolucaoObs">Texto Conclusivo</label>
				<div class="controls">
					<textarea class="span12" readonly maxlength="1000" type="text" id="PropResolucaoObs" name="PropResolucaoObs" ><?php echo (isset($resolucao["PropResolucaoObs"])) ? $resolucao["PropResolucaoObs"] : ""; ?></textarea>
				</div>
			</div>

			<input type="hidden" id="PropResolucaoArquivoID" name="PropResolucaoArquivoID" 
				value = '<?php echo (isset($resolucao["PropResolucaoArquivoID"])) ? $resolucao["PropResolucaoArquivoID"] : ""; ?>' ></input>

			<div class="control-group in-line">
				<label class="control-label">
				<?php 
					if (isset($resolucao["PropResolucaoArquivoNome"])) 
						echo '<a id="PropResolucaoArquivoNome" href="#" class="up-file-name">' . $resolucao["PropResolucaoArquivoNome"] . "</a>";
					else 
						echo "<span class='alert-danger'>Arquivo não encontrado!</span>"; 
				?>
				</label>
			</div>
				
		</div> <!-- Fim tabResolucao -->

	</div> <!-- FIM tab-content -->

</form>		