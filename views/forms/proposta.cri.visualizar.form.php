
<style type="text/css">

	#dialog-visualizar-propostas {
		width: 1050px; /* SET THE WIDTH OF THE MODAL */
    	margin-left: -520px;
    	/*margin-top: -30px;*/
	}

	#dialog-visualizar-propostas .modal-body{
		overflow: hidden;
		max-height: 1900px;
	}

	#dialog-visualizar-propostas .tabbable ul#navViewPropostas li a {
		min-width: 14px;
	}

	#dialog-visualizar-propostas .tabbable ul#navViewPropostas li.active > a{
		background: #C0D8F0;
		border-color: #C0D8F0;
	}

</style>

<script type="text/javascript">

	$('#navViewPropostas a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		if ($(this).attr('href') == "#tabNavArquivos") applyDataTableByID("lista_arquivos");
		if ($(this).attr('href') == "#tabNavContatos") applyDataTableByID("lista_proposta_contatos");
	});

</script>

<div id="dialog-visualizar-propostas" class = 'modal hide fade in'>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!--ou "×"--></button>
		<h3><?php echo $titulo_form; ?></h3>
	</div>
	<div class="modal-body">

		<form id="formVisualizarPropostas" name="formVisualizarPropostas" >
			
			<div class="tabbable tabs-left">

				<ul class="nav nav-tabs" id="navViewPropostas">
					<li class="active"	><a href="#tabNavDadosBasiscos"			data-toggle="tab"><i class='icon-list' title='Dados Básicos'></i></a></li>
					<li					><a href="#tabNavEnaquadramento" 		data-toggle="tab"><i class='icon-filter' title='Enquadramento e Análises'></i></a></li>
					<li					><a href="#tabNavManifSecuritizadora" 	data-toggle="tab"><i class='icon-check' title='Manifestações da Securitizadora'></i></a></li>
					<li					><a href="#tabNavManifAgenteOperador" 	data-toggle="tab"><i class='icon-ok-circle' title='Manifestação do Agente Operador'></i></a></li>
					<li					><a href="#tabNavArquivos" 				data-toggle="tab"><i class='icon-folder-open' title='Arquivos'></i></a></li>
					<li					><a href="#tabNavContatos" 				data-toggle="tab"><i class='icon-user' title='Contatos'></i></a></li>
				</ul>

				<div id="tabViewPropostas" class="tab-content">

					<div class="tab-pane fade active in" id='tabNavDadosBasiscos'>
						<?php require $siopm->getForm('proposta.cri.dados.basicos.visualizar'); ?>
					</div> <!-- Fim DADOS BASICOS -->

					<div class="tab-pane fade in" id='tabNavEnaquadramento'>
						<?php require $siopm->getForm('proposta.cri.enquad.analises.visualizar'); ?>
					</div> <!-- Fim ENQUADRAMENTO ANALISE -->

					<div class="tab-pane fade in" id='tabNavManifSecuritizadora'>
						<?php require $siopm->getForm('proposta.cri.manif.securitizadora.visualizar'); ?>
					</div> <!-- Fim MANIFESTACAO SECURITIZADORA -->

					<div class="tab-pane fade in" id='tabNavManifAgenteOperador'>
						<?php require $siopm->getForm('proposta.cri.manif.agentes.visualizar'); ?>
					</div> <!-- Fim MANFESTACAO AGENTE OPERADOR -->

					<div class="tab-pane fade in" id='tabNavArquivos'>
						<?php require $siopm->getForm('proposta.cri.arquivos.visualizar'); ?>
					</div> <!-- Fim ARQUIVOS -->

					<div class="tab-pane fade in" id='tabNavContatos'>
						<?php require $siopm->getForm('proposta.cri.contatos.visualizar'); ?>
					</div> <!-- Fim CONTATOS -->

				</div> <!-- Fim TAB CONTENT MAIN NAV -->

			</div>
		</form>

	</div>
	<div class="modal-footer">
		<button  class="btn" data-dismiss="modal" aria-hidden="true" >Sair</button>
	</div>
</div>
