
var _pc = 0, _pv = 0, _ut = 0;
var _servicio = '../php/servicios/proc-productos.php';
var _servicio_clases = '../php/servicios/get_clases.php';

(function($){

	$(document).ready(function(){
		/* --------------------------------------------------------- */
		_Proveedor = $('#cboProveedor').selectize({
			options: _json_clientes,
			labelField: 'texto',
    		valueField: 'id',
		});
		if( _idProveedor > 0 ){
			_Proveedor[0].selectize.setValue(_idProveedor);
		}
		/* --------------------------------------------------------- */
		$('.cboSelectize').selectize();
		/* --------------------------------------------------------- */
		var $select = $('#deaClases').selectize({
			maxItems: null,
		    valueField: 'id',
		    labelField: 'title',
		    searchField: 'title',
    		options:_json_all_clases
		});
		var control = $select[0].selectize;
		if( _clases_producto != '' ){
			control.setValue( _clases_producto );
		}
		/* --------------------------------------------------------- */
		var $select = $('#deaAlamcen').selectize({
			maxItems: null,
		    valueField: 'id',
		    labelField: 'title',
		    searchField: 'title',
    		options:_json_all_almacenes
		});
		var control = $select[0].selectize;
		if( _almacen_producto != '' ){
			control.setValue( _almacen_producto );
		}
		/* --------------------------------------------------------- */
		$('#txtVence').datepicker({
			format: 'dd/mm/yyyy',
			startDate: '-3d',
			language : 'es',
			startView : 'year'
		});
		/* --------------------------------------------------------- */
		$('#myButton').click(function(event) {
			/* Guardar el producto. */
			var $btn = $(this).button('loading');
			var _data = $('#frmData').serializeArray();
			_data.push({name: 'nombreProveedor', value: $('#cboProveedor').text() });
			_data.push({name: 'lasClases', value: $('#deaClases').val() });
			_data.push({name: 'losAlmacen', value: $('#deaAlamcen').val() });
			//
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				$btn.button('reset');

				if( data.error == 'si' ){
					$('#msgBox').html( '<div class="alert alert-danger" role="alert"><p class="text-left" ><strong>Error:</strong><br/>'+data.texto_error+'</p></div>' );
					alertify.error('Revise los datos');
					return true;
				}

				if( data.existe == 'si' ){
					alertify.error('Producto ya existe');
					return true;
				}
				
				if( data.idprod > 0 ){
					$('#idProducto').val( data.idprod );
					alertify.success('Producto Guardado Correctamente.');
					alertify.confirm('¿Desea agregar otro Producto?',function(e){
						if(e){
							document.location.href = 'editar-producto.php';
						}
					});
				}
				
			},'json');
		});
		/* --------------------------------------------------------- */
		$('#btnSetEquiv').click(function(event) {
			//
			var _tabActivo = $('#tabActive').val(), _Precio = 0;
			var _tag = $('#tag').val(), _um = $('#cboum').val(), _cant = $('#cantNeg').val();
			var _idproducto = $('#idProducto').val();

			_Precio = $('#txtPreCompra'+_tabActivo).val();
			var _data = { f : 'inserteq', tag: _tag , cboum : _um , cantNeg : _cant , idp : _idproducto, precio : _Precio };
			//
			var $btn = $(this).button('loading');
			if( _um != '' && _cant != '' ){
				$.post( _servicio , _data , function(data, textStatus, xhr) {
					loadTablita( data );
					$btn.button('reset');
				},'json');
			}else{
				alertify.alert('Ingrese cantidad o seleccione unidad de medida.');
				$btn.button('reset');
			}
			event.preventDefault();
		});
		/* --------------------------------------------------------- */
		$('.losTabs').click(function(event) {
			/* Act on the event */
			var _id = $(this).attr('rel');
			$('.deaTabs').each(function(index){
				$(this).removeClass('active');
			});
			$('#tab'+_id).addClass('active');
			$('.tabPre').each(function(index){
				$(this).hide();
			});
			$('#Pre'+_id).show();
			$('#tabActive').val( _id );
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#txtPreCompra1').keyup(function(event) {
			_pc = $('#txtPreCompra1').val();
			_ut = $('#txtUtilidad1').val();
			_ut = ( _ut / 100 );
			calcularPV( 1 , _pc , _ut );
		});
		/* -------------------------------------- */
		$('#txtUtilidad1').keyup(function(event) {
			_pc = $('#txtPreCompra1').val();
			_ut = $('#txtUtilidad1').val();
			_ut = ( _ut / 100 );
			calcularPV( 1 , _pc , _ut );
		});
		/* -------------------------------------- */
		$('#txtPreCompra2').keyup(function(event) {
			_pc = $('#txtPreCompra2').val();
			_pv = $('#txtPv2').val();
			calcularUT( 1 , _pc , _pv );
		});
		/* -------------------------------------- */
		$('#txtPv2').keyup(function(event) {
			_pc = $('#txtPreCompra2').val();
			_pv = $('#txtPv2').val();
			calcularUT( 2 , _pc , _pv );
		});
		/* -------------------------------------- */
		$(document).delegate('.quitarEqui', 'click', function(event){
			var _tag = $('#tag').val(), _ideq = $(this).attr('rel');
			$.post( _servicio ,{ f : 'deleq', tag: _tag , ideq : _ideq }, function(data, textStatus, xhr) {
				loadTablita( data );
			},'json');
			event.preventDefault();
		});
	});

})(jQuery);

/* =============================================================================== */

function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '';
		for (var i = 0; i < json.data.length; i++) {
			_fila = json.data[i];
			_html += '<tr>';
			_html += '<td>'+_fila.var_Nombre+'</td>';
			_html += '<td>'+_fila.int_Cantidad+'</td>';
			_html += '<td>';
				_html += '<a href="#" title="Quitar Item" class="quitarEqui" rel="'+_fila.int_IdAuto+'" >';
					_html += '<span class="glyphicon glyphicon-remove" ></span>';
				_html += '</a>';
			_html += '</td>';
			_html += '</tr>';
		};
		$('#tablita tbody').html( _html );
	}
}
/* ---------------------------------------------------------- */
function calcularPV( _tag , _elpc , _laut ){
	if( !isNaN( _laut ) && !isNaN( _elpc ) ){
		var _xpv = _elpc / ( 1 - _laut ), _out = 0;
		_out = Math.round( _xpv * 100 ) /100;
		$('#txtPv'+_tag).val( _out );
	}
}
/* ---------------------------------------------------------- */
function calcularUT( _tag , _elpc , _elpv ){
	if( !isNaN( _elpv ) && !isNaN( _elpc ) ){
		var _lauti = (( _elpc / _elpv ) - 1 ) * 100;
		_lauti = _lauti * -1;
		if( !isNaN(_lauti) ){
			_lauti = parseInt(_lauti), _out = 0;
		}
		$('#txtUtilidad2').val( _lauti+'%' );
	}
}
/* ---------------------------------------------------------- */
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

function load_pic( _filtro){

    var archivos = document.getElementById("file");//Damos el valor del input tipo file
    var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo

    //El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
    var data = new FormData();

    //Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
    //objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
    //que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
    for( i=0; i < archivo.length ; i++ ){
        data.append('archivo'+i,archivo[i]);
    }

    data.append(_filtro);

    $.ajax({
        url:'php_class/servicios/up_foto_proy.php',    //Url a donde la enviaremos
        type:'POST',        //Metodo que usaremos
        contentType:false,  //Debe estar en false para que pase el objeto sin procesar
        data:data,          //Le pasamos el objeto que creamos con los archivos
        processData:false,  //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false,         //Para que el formulario no guarde cache
        dataType:'json'
        }).done(function(msg){
            $('.imagen_p').attr('src','images/proyectos/' + msg.img );
            $('#img').attr( 'value' , msg.img );
            $('#thumb').attr( 'value' , msg.thumb );
    });
}
