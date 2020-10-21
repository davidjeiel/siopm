<?php
	
	// Configurações do document_top
	$title = $siopm->getTitle();

	//$sistema_selecionado = "FLE";
	$titulo_da_pagina = "Cadastro de Usuários";

	$opcao_selecionada = "Manutenção";
	$subopcao_selecionada = "Usuários";
	
	$custom_head  .= $siopm->getJS("views", "usuarios.js");


	ob_start(); // começamos a armazenar tudo no buffer
?>

	<div class='conteudo-usuario'>

		<h3>Manutenção de Usuários</h3>

		<?php if (user_has_access("CADASTRO_USUARIOS_EDITAR")) { ?>
		<p><button class="btn_novo_usuario btn btn-primary" type="button">Novo usuário</button></p>
		<?php } ?>

		<table id="lista_usuarios" class="table table-striped table-temp-hover table-condensed">
		<thead>
			<tr>
				<th>Matrícula</th>
				<th>Nome</th>
				<th>Unidade</th>
				<th>Perfil</th>
				<th class="center">Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($db_usuarios_arr as $usuario) { ?>

			<?php 

				$display_matricula 		= htmlspecialchars($usuario['UsuarioMatricula'], ENT_QUOTES);
				$display_nome 			= htmlspecialchars($usuario['UsuarioNome'], ENT_QUOTES);
				$display_unidade_id 	= htmlspecialchars($usuario['UnidadeID'], ENT_QUOTES);
				$display_perfil_nome 	= htmlspecialchars($usuario['PerfilNome'], ENT_QUOTES);
				
			?>

			<tr class="usuario_<?php echo $display_matricula; ?>" data-matricula = "<?php echo $display_matricula; ?>" data-nome = "<?php echo $display_nome; ?>" >
				<td><div class="usuario_matricula"><?php echo $display_matricula; ?></div></td>
				<td><div class="usuario_nome"><?php echo $display_nome; ?></div></td>
				<td><div class="unidade_id"><?php echo $display_unidade_id; ?></div></td>
				<td><div class="perfil_nome"><?php echo $display_perfil_nome; ?></div></td>
				<td class='center'>
					<?php 
					if (user_has_access("CADASTRO_USUARIOS_VISUALIZAR")) echo TAG_A_VISUALIZAR; else echo TAG_I_VISUALIZAR;
					if (user_has_access("CADASTRO_USUARIOS_EDITAR")) echo TAG_A_EDITAR; else echo TAG_I_EDITAR;
					if (user_has_access("CADASTRO_USUARIOS_EXCLUIR")) echo TAG_A_EXCLUIR; else echo TAG_I_EXCLUIR;
					?>
				</td>
			</tr>

		<?php } ?>

		</tbody>
		</table>

	</div>

	<span id='spanUsuariosForm'></span>

<?php

	$contents = ob_get_clean(); // transferimos o buffer para a variável
	
?>

