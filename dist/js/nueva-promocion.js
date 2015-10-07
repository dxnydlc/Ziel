
var _servicio = '../php/servicios/proc-promociones.php';
var _idPedidoX = 0, _docGenerate = '', _serieUsar = '';

var template = Handlebars.compile($("#result-template").html());
var empty = Handlebars.compile($("#empty-template").html());

(function($){

	//

	$(document).ready(function(){
		switch(_Estado){
			case 'ACT':
				$('#SavePromo').hide('slow');
				$('#delPromo').show('slow');
			break;
			case 'DEL':
				$('#SavePromo').hide('slow');
				$('#delPromo').hide('slow');
			break;
			default:
				$('#SavePromo').show('slow');
			break;
		}
		/* -------------------------------------- */
		var bestPictures = new Bloodhound({
			identify: function(o) { return o.id_str; },
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('label'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			dupDetector: function(a, b) { return a.id_str === b.id_str; },
			prefetch: '../php/servicios/prefetch_prods.php',
			remote: {
				url: '../php/servicios/get_prods.php?q=%QUERY',
				wildcard: '%QUERY'
			}
		});
		// ensure default users are read on initialization
		bestPictures.get('crest')
		function engineWithDefaults(q, sync, async) {
			if (q === '') {
				sync(bestPictures.get('crest'));
				async([]);
			}else{
			  	bestPictures.search(q, sync, async);
			}
		}
		//Buscador
		$('#Objeto').typeahead({
			hint: $('.Typeahead-hint'),
    		menu: $('.Typeahead-menu'),
			minLength: 2,
			classNames: {
				open: 'menu-lista-th',
				//empty: 'is-empty',
				//cursor: 'is-active',
				//suggestion: 'Typeahead-suggestion',
				//selectable: 'Typeahead-selectable'
			}
		},{
			displayKey: 'label',
  			display: 'label',
			source: engineWithDefaults,
			templates: {
			    empty: empty,
			    suggestion: template
			},
		});
		$('#Objeto').bind('typeahead:select', function(ev, suggestion) {
		  $('#idObjeto').val(suggestion.id);
		});
		/* -------------------------------------- */
		$('#cboClase').change(function(event) {
			$('#idObjeto').val( $(this).val() );
		});
		/* -------------------------------------- */
		$('#cboPara').change(function(event) {
			cambioPara( $(this).val() );
		});
		/* -------------------------------------- */
		$('#cboAplicar').change(function(event) {
			cambioAplicar( $(this).val() );
		});
		/* -------------------------------------- */
		$('#Desde').datetimepicker({
			locale: 'es'
		});
		/* -------------------------------------- */
		$('#Hasta').datetimepicker({
			locale: 'es'
		});
		/* -------------------------------------- */
		$('#tiempo').change(function(event) {
			cambioTiempo( $(this).val() );
		});
		/* -------------------------------------- */
		$('#SavePromo').click(function(event) {
			/* Dibujamos la masara */
			var _Mascara = '';
			if( $('#tiempo').val() == 'RangoFechas' ){
				_Mascara = 'Desde el '+$('#Desde').val()+' hasta el '+$('#Hasta').val();
			}else{
				var _arDias = [];
				$("input:checkbox:checked").each(function(){
					//cada elemento seleccionado
					_arDias.push( $(this).attr('rel') );
				});
				var _texto = _arDias.join(',');
				_Mascara = 'Los días '+_texto;
			}
			if( $('#cboPara').val() == 'Producto' ){
				_Mascara += ' en producto: '+$('#Objeto').val();
			}
			$('#Mascara').val( _Mascara );
			//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
			var _data = $('#frmPromo').serialize();
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				if( data.idPromo > 0 ){
					$('#labelPromo').html( data.idPromo );
					alertify.success('Promocion Generada');
					$('#SavePromo').hide('slow');
					$('#delPromo').show('slow');
					loadTablita(data.data);
				}
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#delPromo').click(function(event) {
			var _idPromo = $(this).attr('rel');
			alertify.confirm('Confirme anular Promoción',function(e){
				if(e){
					$.post( _servicio , {f:'del',idPromo: _idPromo} , function(data, textStatus, xhr) {
						alertify.error('Promoción Anulada');
						$('#SavePromo').hide('slow');
						$('#delPromo').hide('slow');
					});
				}
			});
		});
		/* -------------------------------------- */
	});
})(jQuery);

function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++) {
			_fila = json.data[i];

			_html += '<tr>';
				_html += '<td>'+_fila.prod+'</td>';
				_html += '<td>'+_fila.prec+'</td>';
				_html += '<td>'+_fila.prom+'</td>';
				_total = _total + parseFloat(_fila.flt_Total);
				_html += '<td></td>';
		};
		$('#TotalPedido').val( _total );
		$('#LabelTotal').html('Total de Pedido: '+_total);
		$('#Tablita tbody').html( _html );
	}
}

function cambioTiempo(q){
	switch(q){
		case 'RangoFechas':
			$('#wrapperRango').show();
			$('#wrapperPermanente').hide();
		break;
		case 'Permanente':
			$('#wrapperRango').hide();
			$('#wrapperPermanente').show();
		break;
	}
}

function cambioPara(o){
	switch(o){
		case 'Clase':
			$('#wrapperProd').hide();
			$('#wrapperClase').show();
		break;
		case 'Producto':
			$('#wrapperClase').hide();
			$('#wrapperProd').show();
		break;
	}
}

function cambioAplicar(e){
	switch(e){
		case 'PrecioFijo':
			$('#addON').html('S/.');
		break;
		case 'Porcentaje':
			$('#addON').html('%');
		break;
	}
}

/*Solo Numeros*/
/*
onkeypress="return validar(event);"
*/
function validar(e) {
    tecla = (document.all)?e.keyCode:e.which;//ascii
    //alert(tecla);
    switch(tecla){
        case 8:
            return true;
            break;
        case 46://punto
            return  true;
            break;
        case 58:// dos puntos
            return  true;
            break;
        case 43://Mas
            return true;
            break;
        case 45://Menos
            return true;
            break;
        case 44://Coma
            return true;
            break;
        case 0://Suprimir
            return true;
            break;
            

        default:
            
            break;
    }
    patron = /\d/;
    te = String.fromCharCode(tecla);
    
    return patron.test(te);
    
}

/*
Solo letras
onkeypress="return soloLetras(event)"
*/
function soloLetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = [8,37,39,46,9];

    tecla_especial = false
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla)==-1 && !tecla_especial){
        return false;
    }
}
