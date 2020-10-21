
<style type="text/css">

	#dialog-manut-usuario .modal-body{	
		overflow: hidden;
	}

</style>

<div id="dialog-manut-usuario" class="modal fade in" >

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3 id="titulo-manut-usuario">Manutenção de Usuário</h3>
	</div>
	<div class="modal-body">

		<form id="formUsuarios" name="formUsuarios" >
			<fieldset>

				<input class="gravar" id="UsuarioAtivo" name="UsuarioAtivo" type="hidden" value="1"> </input>
				<input class="gravar" id="UnidadeAtiva" name="UnidadeAtiva" type="hidden" value="1"> </input>
				<input class="gravar" id="UnidadeSigla" name="UnidadeSigla" type="hidden" value='<?php echo (isset($arrUsuarios["UnidadeSigla"])) ? $arrUsuarios["UnidadeSigla"] : ""; ?>'> </input>
				<input class="gravar" id="UnidadeNome" 	name="UnidadeNome" 	type="hidden" value='<?php echo (isset($arrUsuarios["UnidadeNome"])) ? $arrUsuarios["UnidadeNome"] : ""; ?>'> </input>
				<input class="gravar" id="UnidadeEmail" name="UnidadeEmail" type="hidden" value='<?php echo (isset($arrUsuarios["UnidadeEmail"])) ? $arrUsuarios["UnidadeEmail"] : ""; ?>'> </input>
				
				<input class="span2 gravar" type="hidden" id="UsuarioMatriculaResponsavel" name="UsuarioMatriculaResponsavel" 
					value= <?php echo  $user->getUsuarioMatricula(); ?> ></input>
				<input class="span2 gravar" type="hidden" id="UsuarioDataCadastro" name="UsuarioDataCadastro"
					 value= <?php echo (isset($arrUsuarios["UsuarioDataCadastro"])) ? $arrUsuarios["UsuarioDataCadastro"] : ""; ?> ></input>
				
			    <div class="control-group span6" id="divPesquisaMatricula">
					<label class="control-label">Pesquisa Empregado</label>
					<div class="control-group">
					    <div class="input-append">
							<input id="pesquisaMatricula" name="pesquisaMatricula" style = "height: 20px"
									placeholder="C??????" class="input-medium" type="text" value="">
								<a href="#" class="btn_pesquisa_usuario btn add-on"><i class="icon-plus"></i></a>
							</input>
						</div>
				   	</div>
				</div>

				<div class="control-group span3">
					<label for="UsuarioMatricula">Matrícula</label>
					<input class="span3 gravar" type="text" readonly id="UsuarioMatricula" name="UsuarioMatricula" 
						value= '<?php echo (isset($arrUsuarios["UsuarioMatricula"])) ? $arrUsuarios["UsuarioMatricula"] : ""; ?>' ></input>
				</div>
				<div class="control-group span6">
					<label for="UnidadeID">Unidade</label>
					<input readonly class="span3 gravar" type="text" id="UnidadeID" name="UnidadeID" 
						value= '<?php echo (isset($arrUsuarios["UnidadeID"])) ? $arrUsuarios["UnidadeID"] : ""; ?>' ></input>
					<!--
					<input readonly class="span3 gravar" type="text" id="UnidadeNome" name="UnidadeNome" 
						value = '<?php echo (isset($arrUsuarios["UnidadeNome"])) ? $arrUsuarios["UnidadeNome"] : ""; ?>' ></input> -->
				</div>
				<div class="control-group span6">
					<label for="UsuarioNome">Nome</label>
					<input readonly class="span6 gravar" type="text" id="UsuarioNome" name="UsuarioNome" 
						value = '<?php echo (isset($arrUsuarios["UsuarioNome"])) ? $arrUsuarios["UsuarioNome"] : ""; ?>' ></input>
				</div>
				<div class="control-group span6">
					<label class="control-label">Perfil</label>
					<select class="gravar" name="PerfilID" id="PerfilID">
					    <!-- <option value="0">Nenhum</option> -->
					   		<?php $selected = ""; ?>
					   		<?php foreach($perfis_arr as $row): ?>

					   			<?php 
						   			if (isset($arrUsuarios["PerfilID"])){
						   				 if ($row["PerfilID"] == $arrUsuarios["PerfilID"]) $selected = "selected = 'selected'"; else $selected="";
						   			} 
					   			?>

					    		<option <?php echo $selected; ?> value = "<?php echo $row["PerfilID"] ?>" > <?php echo $row["PerfilNome"]; ?> </option>

					    	<?php endforeach; ?>
					</select>
				</div>				

			</fieldset>
		</form>
	</div>
	<div class="modal-footer">
		<button id="btn_salvar_usuario" class="btn_salvar_usuario btn btn-primary">Salvar Alterações</button>
		<button id="btn_cancelar_usuario" class="btn_cancelar_usuario btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
	</div>
</div>