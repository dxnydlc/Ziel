var _servicio = '../php/servicios/proc-usuarios.php';

(function($){
	
	//

	$(document).ready(function(){
		/*--------------------------------------------------*/
		$('#btnBuscar').click(function(event) {
			var _fecha = $('#fecha').val();
			$.post( _servicio , {f:'buscar',fecha:_fecha} , function(data, textStatus, xhr) {
				llenarTablita( data , '#Busqueda' );
			},'json');
			event.preventDefault();
		});
		/*--------------------------------------------------*/
		$( "#fecha" ).datepicker({
			format: 'dd/mm/yyyy',
			startDate: '-3d',
			language : 'es',
			startView : 'day'
		});
		/*--------------------------------------------------*/
		$('.nav-tabs a').click(function(event){
			var _action = $(this).attr('href');
			console.log(_action);
			$.post(_servicio, {f:'get',estado:_action} , function(data, textStatus, xhr) {
				llenarTablita( data , _action );
			},'json');
		});
		/*--------------------------------------------------*/
		$('#SaveUser').click(function(event) {
			var _clave1 = $('#clave').val();
			var _clave2 = $('#clave2').val();
			//
			if( _clave1 != _clave2 ){
				alertify.error('Las contraseñas no coinciden.');
				return true;
			}
			if( _clave1 == '' ){
				alertify.error('Ingrese una contraseña.');
				return true;
			}
			var _data = $('#frmUser').serialize();
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				$('#idu').val( data.idu );
				alertify.success('Usuario guardado.');
				llenarTablita(data.data);
			},'json');
			event.preventDefault();
		});
		/*--------------------------------------------------*/
		$('.getUser').click(function(event) {
			/* Act on the event */
			var _idu = $(this).attr('rel');
			$.post( _servicio , {f:'get',idu:_idu} , function(data, textStatus, xhr) {
				if( data != undefined || data != null ){
					console.log(data);
					var _fila = [];
					_fila = data.data[0];
					$('#idu').val( _fila.int_IdUsuario );
					$('#Nombre').val( _fila.Var_Nombre );
					$('#Correo').val( _fila.var_Mail );
					$('#Usuario').val( _fila.var_Usuario );
					$('#Tipo').val( _fila.cht_Tipo );
					$('#clave').val('');
					$('#clave2').val('');
				}
			},'json');
			event.preventDefault();
		});
		/*--------------------------------------------------*/
	});

})(jQuery);

function llenarTablita( json , _obj ){
	
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.n; i++) {
			_fila = json.data[i];
			var _estado = _fila.estado_venta, _cla = '';
			switch (_estado) {
                case 'CER':
                    _cla = 'success';
                    break;
                case 'DEL':
                    _cla = 'danger';
                    break;
            }
			_html += '<tr class="'+_cla+'">';
				_html += '<td>'+_fila.int_IdUsuario+'</td>';
				_html += '<td>';
					_html += '<a class="getUser" href="#" rel="'+_fila.int_IdUsuario+'" data-toggle="modal" data-target="#myModal" >';
						_html += '<span class=" fa  fa-user " ></span> '+_fila.var_Usuario;
					_html += '</a>';
				_html += '</td>';
				_html += '<td>'+_fila.Var_Nombre+'</td>';
				_html += '<td>'+_fila.var_Mail+'</td>';
				_html += '<td>'+_fila.cht_Tipo+'</td>';
				_html += '<td>'+_fila.chr_estado+'</td>';
				_html += '<td></td>';
			_html += '</tr>';
		};

		$('#tblUser tbody').html( _html );
	}
}
