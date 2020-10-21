<style>

	#dialog-manut-perfil {
		width: 1024px; /* SET THE WIDTH OF THE MODAL */
	    margin-left: -512px;  /*CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
	   /* margin-top: -60px!important;*/
	}

	#dialog-manut-perfil .modal-body{
		max-height: 510px;
		height: 510px;
		overflow: hidden;
	}

	.listaFuncionalidades {
		overflow-y: scroll!important ;
		height: 420px;
	}


	#formPefis.tab-content{
		height: 350px!important;
	}

</style>


<div id="dialog-manut-perfil" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut-perfil">Manutenção de Perfis</h3>
	</div>
	<div class="modal-body">

		<form id="formPerfis" name="formPerfis" >
			<fieldset>
				<input type="hidden"  id="PerfilID" name="PerfilID"	value= '<?php echo (isset($arrPerfis["PerfilID"])) ? $arrPerfis["PerfilID"] : ""; ?>' ></input>
				<input type="hidden"  id="PerfilAtivo" name="PerfilAtivo"	value= '1' ></input>

				<div class="control-group span6">
					<label for="PerfilNome">Nome do Perfil</label>
					<input class="span6 gravar" type="text"  id="PerfilNome" name="PerfilNome" 
						value= '<?php echo (isset($arrPerfis["PerfilNome"])) ? $arrPerfis["PerfilNome"] : ""; ?>' ></input>
				</div>
				<div class="control-group span6">
					<label for="PerfilDescricao">Descrição do Perfil</label>
					<input class="span6 gravar" type="text" id="PerfilDescricao" name="PerfilDescricao" 
						value= '<?php echo (isset($arrPerfis["PerfilDescricao"])) ? $arrPerfis["PerfilDescricao"] : ""; ?>' ></input>
				</div>
				 
				<h4> Funcionalidades </h4>	

				<div class="listaFuncionalidades" >

			 		<?php foreach($arrFuncionalidades as $row): ?>

			 			<div class="controls span6 inline">
			 				
							<label class="checkbox"><i class="glyphicon-keys"></i>
							<input type="checkbox" <?php echo (in_array($row["FuncionalidadeNome"], $arrFuncionalidadesExistentes)) ? "checked":""; ?>
								 name='<?php echo (isset($row["FuncionalidadeNome"])) ? $row["FuncionalidadeNome"] : ""; ?>'> <strong> 
							<?php echo (isset($row["FuncionalidadeNome"])) ? $row["FuncionalidadeNome"] : ""; ?> </strong> 
							</label>

							<p > <em> <?php echo (isset($row["FuncionalidadeDescricao"])) ? $row["FuncionalidadeDescricao"] : ""; ?> </em> </p> 
						</div>
					<?php endforeach; ?>
				</div>

			</fieldset>
		</form>
	</div>
	<div class="modal-footer">
		<button id="btn_salvar_perfil" class="btn_salvar_perfil btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar_perfil" class="btn_cancelar_perfil btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>