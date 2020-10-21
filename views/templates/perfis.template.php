<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();
	
	$custom_head .= $siopm->getJS("views", "perfis.js");

	//has_permission_or_stop("ACESSO_SISTEMA");
	//has_permission_or_stop("EDITAR_USUARIOS_UNIDADE");

	ob_start(); // começamos a armazenar tudo no buffer

?>

	<div class='conteudo-perfil'>

		<h3>Manutenção de Perfil</h3>

		<?php if (user_has_access("CADASTRO_PERFIL_EDITAR")) { ?>
			<p><button class="btn_novo btn btn-primary" type="button">Novo Perfil</button></p>
		<?php } ?>

		<table id="lista_perfis" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Nome do Perfil</th>
				<th>Descrição do Perfil</th>
				<th class="center">Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($db_perfis_arr as $perfil) { ?>

			<?php 

				$PerfilID			= htmlspecialchars($perfil['PerfilID'], ENT_QUOTES);
				$PerfilNome			= htmlspecialchars($perfil['PerfilNome'], ENT_QUOTES);
				$PerfilDescricao	= htmlspecialchars($perfil['PerfilDescricao'], ENT_QUOTES);
			?>

			<!-- O class na TR, serve para atualizar seu valor após uma EDICAO --> 
			<!-- Já o valor dos data-?, é para mostrar na mensagem de exclusão -->
			<tr class="perfil_<?php echo $PerfilID; ?>"	
				data-perfilid 	= "<?php echo $PerfilID; ?>"
				data-nome 		= "<?php echo $PerfilNome; ?>" 
				data-descricao 	= "<?php echo $PerfilDescricao; ?>" >

			<!-- O class no TD, serve para atualizar seu valor após uma EDICAO --> 
			<td><div class='perfil-nome'	 >	<?php echo $PerfilNome; ?>		</div></td>
			<td><div class='perfil-descricao'>	<?php echo $PerfilDescricao; ?>	</div></td>
			<td class='center'>
					<?php 
					if (user_has_access("CADASTRO_PERFIL_VISUALIZAR")) echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
					if (user_has_access("CADASTRO_PERFIL_EDITAR")) echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
					if (user_has_access("CADASTRO_PERFIL_EXCLUIR")) echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR; 
					?>
				</td>
			</tr>

		<?php } ?>

		</tbody>
		</table>

	</div>

<?php

	/* 
	* Foram removidos o getTemplate('layout') de todos os templates, para que em caso de necessidade de 
	* Usar o resultado de um cotroller através de ajax, não trazer todo o layout novamente. Desenhando-o duas vezes
	*/
	$contents = ob_get_clean(); // transferimos o buffer para a variável


?>