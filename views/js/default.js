
$(document).ready(function() {
    
	// Define os padrões para todos os requests
	$.ajaxSetup({
		type: "POST",
    global: true,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache: "false",
		async: false
	});

	//Live Tooltip
	$('body').tooltip({
		selector: '[rel=tooltip]'
	});


 
  $(document).on({
    ajaxSend: function(event, jqXHR, ajaxOptions){
      if (ajaxOptions.url != app_path + "/lib/DataTables/dataTables.portugues.txt"){
         $("body").addClass("loading"); 
      }
    },
    ajaxComplete: function(event, jqXHR, ajaxOptions){ 
      if (ajaxOptions.url != app_path + "/lib/DataTables/dataTables.portugues.txt"){
        $("body").removeClass("loading"); 
      }
    }
  });

  $("#modal_loader").bind( "click", function() {
    $("body").removeClass("loading"); 
    $.ajaxStop();
  });

  // $('#divConteudo').hide();
  // $('#divConteudo').fadeIn();

});

  jQuery.fn.dataTableExt.oSort['date-br-asc']  = function(a,b) {
      if (b == "") return 1;
      var usDatea = a.split('/');
      var usDateb = b.split('/');
      var x = (usDatea[2] + usDatea[1] + usDatea[0]) * 1;
      var y = (usDateb[2] + usDateb[1] + usDateb[0]) * 1;
      //return a - b;
      return ((x < y) ? -1 : ((x > y) ?  1 : 0));
      //return ((x > y) ?  1 : 0)
  };

  jQuery.fn.dataTableExt.oSort['date-br-desc'] = function(a,b) {
      if (a == "") return 1;
      var usDatea = a.split('/');
      var usDateb = b.split('/');
      var x = (usDatea[2] + usDatea[1] + usDatea[0]) * 1;
      var y = (usDateb[2] + usDateb[1] + usDateb[0]) * 1;
      //return b - a;
      return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
      //return ((x < y) ?  1 : 0);
  };

    jQuery.fn.dataTableExt.oSort['money-br-asc']  = function(a,b) {
      if (b == "") return 1;

      var valora = a.replaceAll('R$','');
      valora = valora.replaceAll('.','');
      valora = valora.replaceAll(',','.');
      
      var valorb = b.replaceAll('R$','');
      valorb = valorb.replaceAll('.','');
      valorb = valorb.replaceAll(',','.');

      var x = parseFloat(valora);
      var y = parseFloat(valorb);
      
      if (isNaN(x) || isNaN(y)) {
        return 1;
      } 

      return ((x < y) ? -1 : ((x > y) ?  1 : 0));
  };

  jQuery.fn.dataTableExt.oSort['money-br-desc'] = function(a,b) {
      if (b == "") return 1;

      var valora = a.replaceAll('R$','');
      valora = valora.replaceAll('.','');
      valora = valora.replaceAll(',','');

      var valorb = b.replaceAll('R$','');
      valorb = valorb.replaceAll('.','');
      valorb = valorb.replaceAll(',','');
    
      // var x = valora * 1;
      // var y = valorb * 1;
      var x = parseFloat(valora);
      var y = parseFloat(valorb);

      if (isNaN(x) || isNaN(y)) return 1;

      return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
  };

String.prototype.replaceAll = function(str1, str2, ignore) 
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
} 

  /*
 *
 * NOVO METODO PARA O JQUERY VALIDATE
 * VALIDA CNPJ COM 14 OU 15 DIGITOS
 * A VALIDAÇÃO É FEITA COM OU SEM OS CARACTERES SEPARADORES, PONTO, HIFEN, BARRA
 *
 * ESTE MÉTODO FOI ADAPTADO POR:
 * 
 * Shiguenori Suguiura Junior <junior@dothcom.net>
 * 
 * http://blog.shiguenori.com
 * http://www.dothcom.net
 * 
 */

jQuery.validator.addMethod("cnpj", function(cnpj, element) {
   cnpj = jQuery.trim(cnpj);// retira espaços em branco
   // DEIXA APENAS OS NÚMEROS
   cnpj = cnpj.replace('/','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('-','');
 
   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
   digitos_iguais = 1;
 
   if (cnpj.length < 14 && cnpj.length < 15){
      return false;
   }
   for (i = 0; i < cnpj.length - 1; i++){
      if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
         digitos_iguais = 0;
         break;
      }
   }
 
   if (!digitos_iguais){
      tamanho = cnpj.length - 2
      numeros = cnpj.substring(0,tamanho);
      digitos = cnpj.substring(tamanho);
      soma = 0;
      pos = tamanho - 7;
 
      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(0)){
         return false;
      }
      tamanho = tamanho + 1;
      numeros = cnpj.substring(0,tamanho);
      soma = 0;
      pos = tamanho - 7;
      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(1)){
         return false;
      }
      return true;
   }else{
      return false;
   }
}, "Informe um CNPJ válido.");
 
jQuery.validator.addMethod("maiorZero", function(maiorZero, element) {
  maiorZero = jQuery.trim(maiorZero);
  maiorZero = maiorZero.replace('0','');
  maiorZero = maiorZero.replace('/','');
  maiorZero = maiorZero.replace('R$','');
  maiorZero = maiorZero.replace('$','');
  maiorZero = maiorZero.replace('.','');
  maiorZero = maiorZero.replace(',','');
  maiorZero = maiorZero.replace('-','');
  if (maiorZero.length > 0) return true; else return false;
}, "O valor deve ser maior que zero.");
 
// implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function(obj) {
  var t = typeof(obj);
  if (t != "object" || obj === null) {
    // simple data type
    if (t == "string")
      obj = '"' + obj + '"';
    return String(obj);
  } else {
    // recurse array or object
    var n, v, json = [],
      arr = (obj && obj.constructor == Array);
    for (n in obj) {
      v = obj[n];
      t = typeof(v);
      if (t == "string")
        v = '"' + v + '"';
      else if (t == "object" && v !== null)
        v = JSON.stringify(v);
      json.push((arr ? "" : '"' + n + '":') + String(v));
    }
    return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
  }
};

function unmask(){
    $(".campo-formatado").each(function( index ) {
        $(this).unmask();
    });
}

function maskFormBr(centMoeda, centFloat){

    if (centMoeda == "" || centMoeda == null) centMoeda = 2;
    if (centFloat == "" || centFloat == null) centFloat = 2;

    $('.moeda').priceFormat({
        prefix: 'R$ ',
        clearPrefix: false,
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit : centMoeda
    });

    $('.numero').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit : centFloat
    });

    $('.porcentagem').priceFormat({
        prefix: '% ',
        clearPrefix: false,
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit: centFloat
    });

    $('.inteiro').priceFormat({
        prefix: '',
        clearPrefix: true,
        centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
    });

}

function maskMoedaBR(precisao){

  if (precisao == "" || precisao == null) precisao = 2;

  $('.moeda').priceFormat({
        prefix: 'R$ ',
        clearPrefix: false,
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit : precisao
    });

}

function maskInteiro(){

$('.inteiro').priceFormat({
        prefix: '',
        clearPrefix: true,
        centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
    });
}

function maskNumeroBR(precisao){

  if (precisao == "" || precisao == null) precisao = 0;

  $('.numero').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit : precisao
    });
}

function maskPorcentagemBR(precisao){

  if (precisao == "" || precisao == null) precisao = 2;

  $('.porcentagem').priceFormat({
        prefix: '% ',
        clearPrefix: false,
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit : precisao
    });
}

function maskPorcentagemUn(precisao){

 $('.porcentagem').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: '.',
        thousandsSeparator: '',
        centsLimit: precisao
    });
}

function maskNumeroUm(precisao){

  if (precisao == "" || precisao == null) precisao = 0;

 $('.numero').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: '.',
        thousandsSeparator: '',
        centsLimit: precisao
    });
}

function maskMoedaUn(precisao){

    if (precisao == "" || precisao == null) precisao = 2;

    $('.moeda').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: '.',
        thousandsSeparator: '',
        centsLimit: precisao
    });

}

function maskFormUn(centMoeda, centFloat){

    if (centMoeda == "" || centMoeda == null) centMoeda = 2;
    if (centFloat == "" || centFloat == null) centFloat = 2;

    $('.moeda').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: '.',
        thousandsSeparator: '',
        centsLimit: centMoeda
    });

    $('.numero').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: '.',
        thousandsSeparator: '',
        centsLimit: centFloat
    });

    $('.porcentagem').priceFormat({
        prefix: '',
        clearPrefix: false,
        centsSeparator: '.',
        thousandsSeparator: '',
        centsLimit: centFloat
    });

    $('.inteiro').priceFormat({
        prefix: '',
        clearPrefix: true,
        centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
    });

}


function applyDataTableByID(tableID, ScrollY){

  if (ScrollY == null) ScrollY = "400px";

  $('table#' + tableID).dataTable().fnDestroy();
  
  oTable = $('table#' + tableID).dataTable({
      "oLanguage": {
        "sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
        "sInfoThousands": "."
      },
      "sEmptyTable": "Nenhum registro encontrado.",
      "sDom": '<"top">rt<"bottom"iflp><"clear">',
      "bLengthChange": false,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": true,
      "bPaginate": false,
      "bRetrieve": true, 
      "bProcessing": true,
      "bDestroy": true, 
      "bScrollCollapse": true
      ,"sScrollY": ScrollY
  });

  return oTable; 

} 

function ShowHelp() {
	window.open('help.html', '', 'height=600,width=800,scrollbars=1,resizable=1');
}

// http://stackoverflow.com/questions/1219860/javascript-jquery-html-encoding

function htmlEscape(str) {
	return String(str)
		.replace(/&/g, '&amp;')
		.replace(/"/g, '&quot;')
		.replace(/'/g, '&#39;')
		.replace(/</g, '&lt;')
		.replace(/>/g, '&gt;');
}

function htmlUnescape(value) {
	return String(value)
		.replace(/&quot;/g, '"')
		.replace(/&#39;/g, "'")
		.replace(/&lt;/g, '<')
		.replace(/&gt;/g, '>')
		.replace(/&amp;/g, '&');
}

// function cancelaValidacao() {
// 	$(".label-error").remove();
// 	$('.error').removeClass('error');
// 	$('.error').popover('hide');
// 	$(".modal span[class!='add-on']").html("");
// }

// Enviado por Marcos Dimitro

// ******************************************************************
// This function accepts a string variable and verifies if it is a
// proper date or not. It validates format matching either
// mm-dd-yyyy or mm/dd/yyyy. Then it checks to make sure the month
// has the proper number of days, based on which month it is.

// The function returns true if a valid date, false if not.
// ******************************************************************

function isDate(dateStr) {

	if (dateStr == null) return false;

	var datePat = /^(\d{1,2})[\/-](\d{1,2})[\/-](\d{2}|\d{4})$/;
	var matchArray = dateStr.match(datePat); // is the format ok?

	if (matchArray == null) {
		//alert("Please enter date as either dd/mm/yyyy or dd-mm-yyyy.");
		return false;
	}

	day = matchArray[1]; // p@rse date into variables
	month = matchArray[2];
	year = matchArray[3];

	if (day < 1 || day > 31) {
		//alert("Day must be between 1 and 31.");
		return false;
	}

	if (month < 1 || month > 12) { // check month range
		//alert("Month must be between 1 and 12.");
		return false;
	}

	if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
		//alert("Month "+month+" doesn`t have 31 days!");
		return false;
	}

	if (month == 2) { // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day > 29 || (day == 29 && !isleap)) {
			//alert("February " + year + " doesn`t have " + day + " days!");
			return false;
		}
	}

	return true; // date is valid
}

function isLikeDate(data) {

	er = /([0-9]|[12][0-9]|3[01])[-\.\/]([0-9]|1[012])[-\.\/][0-9]{4}/;
	if (er.exec(data)) {
		return true;
	} else {
		return false;
	}

}


function escapeJson(str) {
	return str.replace(/([\\]|[\"]|[\/])/g, "\\$1")
		.replace(/[\b]/g, "\\b")
		.replace(/[\f]/g, "\\f")
		.replace(/[\n]/g, "\\n")
		.replace(/[\r]/g, "\\r")
		.replace(/[\t]/g, "\\t");
}





function Left(str, n) {
	if (n <= 0)
		return '';
	else if (n > String(str).length)
		return str;
	else
		return String(str).substring(0, n);
}

function Right(str, n) {
	if (n <= 0)
		return '';
	else if (n > String(str).length)
		return str;
	else {
		var iLen = String(str).length;
		return String(str).substring(iLen, iLen - n);
	}
}

//
// Sliding system messages v1.0
// Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
// Em 08/04/2013
// Para GIFUG/SP
//
var sys_message_timeout;
var sys_message_animation_is_running = false;

$(function() {
  // auto positionamento da mensagem.
  $(window).on({resize: sys_message_position, scroll: sys_message_position});
});

function success_message(txt) {
  sys_message(txt, "alert-success");
}

function error_message(txt) {
  sys_message(txt, "alert-error");
}

function alert_message(txt) {
  sys_message(txt, "alert");
}

function info_message(txt) {
  sys_message(txt, "info");
}

function sys_message(txt, alert_class) {
  var html, width_containner_do_alerta, containner_top, containner_left;

  // Se houver alguma mensagem exibida, ela é removida para exibição
  // da nova.
  sys_message_remove();

  // Parâmetros
  var width_alerta = 500;
  var padding_alert = 52;
  var espaco_a_direita = 30;

  var width_containner_do_alerta = width_alerta+padding_alert+espaco_a_direita;

  html  = "";
  html += '<div id="system-message" style="position:absolute;display: none; width: ' + width_containner_do_alerta + 'px;">';
  html += '<div id="alert" class="alert alert-block ' + alert_class + '" style="width: ' + width_alerta + 'px;">';
  html += '<button type="button" class="close" onclick="sys_message_remove();">&times;</button>';
  html += '<h4>' + txt + '</h4></div></div>';
  $("body").append(html);
  sys_message_position();

  // Exibimos a mensagem
  sys_message_animation_is_running = true;
  $('#system-message').show('slide',{direction:'right'},400, function(){
    sys_message_animation_is_running = false;
    // Ao final da animação, precisamos posicionar novamente,
    // caso o viewport tenha sido algum tipo de resize (maximizar, restaurar, 
    // scroll)
    sys_message_position();
  });
  // Definimos o tempo de exibição e então destruímos a janela.
  sys_message_timeout = setTimeout("sys_message_hide();",3500);
}

function sys_message_hide() {
  sys_message_animation_is_running = true;
  $('#system-message').hide('slide',{direction:'right'},400,function(){
    sys_message_animation_is_running = false;
    $('#system-message').remove();
    $('.ui-effects-wrapper').remove();
  });
}

function sys_message_position() {
  // Só alteramos a posição de uma mensagem se ela não estiver
  // durante a animação de entrada ou de saída, pois se estiver,
  // o efeito de animação é cancelado.
  if (!sys_message_animation_is_running) {
    var scrollArr = getPageScroll();
    var horiz_scroll = scrollArr[0];
    var vert_scroll = scrollArr[1];
    var page_height = getPageHeight();

    var width_alerta = $("#system-message #alert").width();
    var width_containner_do_alerta = $("#system-message").width();
    var height_containner_do_alerta = $("#system-message").height();

    var containner_top = vert_scroll + page_height - height_containner_do_alerta - 30;
    var containner_left = $(window).width() - width_containner_do_alerta;

    $("#system-message").css("left", containner_left).css("top", containner_top);
  }
}

function sys_message_remove() {
  // Se estiver programado para fazer a animação de saída, cancelamos.
  clearTimeout(sys_message_timeout);
  // Se estiver durante a animação de saída, paramos.
  $("#system-message").stop();
  // Por fim, removemos a exibição do elemento.
  $("#system-message").remove();
  sys_message_animation_is_running = false;
}

// Thanks to cballou for getPageScroll() and getPageHeight()
// http://stackoverflow.com/questions/1567327/using-jquery-to-get-elements-position-relative-to-viewport
// getPageScroll() by quirksmode.com
function getPageScroll() {
  var xScroll, yScroll;
  if (self.pageYOffset) {
    yScroll = self.pageYOffset;
    xScroll = self.pageXOffset;
  } else if (document.documentElement && document.documentElement.scrollTop) {
    yScroll = document.documentElement.scrollTop;
    xScroll = document.documentElement.scrollLeft;
  } else if (document.body) {// all other Explorers
    yScroll = document.body.scrollTop;
    xScroll = document.body.scrollLeft;
  }
  return new Array(xScroll,yScroll)
}
// Adapted from getPageSize() by quirksmode.com
function getPageHeight() {
  var windowHeight
  if (self.innerHeight) { // all except Explorer
    windowHeight = self.innerHeight;
  } else if (document.documentElement && document.documentElement.clientHeight) {
    windowHeight = document.documentElement.clientHeight;
  } else if (document.body) { // other Explorers
    windowHeight = document.body.clientHeight;
  }
  return windowHeight
}


