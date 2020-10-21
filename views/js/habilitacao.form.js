// VERSAO 5!!!

$(document).ready(function() {
	
	$("#formHabilitacao").validate({

		rules: {
			EntidadeID: {required: true},
			HabilitacaoDataRecebimento: {required: true},
			UnidadeID: {required: true}
		},

		messages: { 
			EntidadeID: { required: 'Campo obrigatório'},
			HabilitacaoDataRecebimento: { required: 'Campo obrigatório' },
			UnidadeID: { required: 'Campo obrigatório' }
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

	$('#EntidadeID').on('change', function() {
		var selected = $(this).find('option:selected');
      	$("#EntidadeUF").val(selected.data('entidadeuf'));
      	$("#EntidadeTipoDescricao").val(selected.data('entidadetipodescricao'));
      	var entidadetipoid = selected.data('entidadetipoid');
      	if (entidadetipoid == 2){
      		$(".analise-esconder").hide('slow');
      	}else{
      		$(".analise-esconder").show('slow');
      	}

      	//alert(selected.data('entidadetipoid'));

	});
	
});