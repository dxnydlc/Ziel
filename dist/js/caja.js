var _servicio = '../php/servicios/proc-caja.php';

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
		$( "#fecha" ).datepicker();
		/*--------------------------------------------------*/
		$('.nav-tabs a').click(function(event){
			var _action = $(this).attr('href');
			console.log(_action);
			$.post(_servicio, {f:'get',estado:_action} , function(data, textStatus, xhr) {
				llenarTablita( data , _action );
			},'json');
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
				_html += '<td><span class=" fa fa-file-o " ></span> '+_fila.var_Mascara+'</td>';
				_html += '<td>000'+_fila.int_IdPedido+'</td>';
				_html += '<td>'+_fila.fecha+'</td>';
				_html += '<td>'+_fila.flt_Total+'</td>';
				_html += '<td>'+_fila.estado_venta+'</td>';
				_html += '<td>'+_fila.usuario+'</td>';
			_html += '</tr>';
		};
		var _tabla = '';
		switch(_obj){
			case '#Activos':
				_tabla = 'tblActivos';
			break;
			case '#Anulados':
				_tabla = 'tblAnulados';
			break;
			case '#Busqueda':
				_tabla = 'tblBusqueda';
				//$('#Busqueda').tab('show');
				$('#myTab a[href="#Busqueda"]').tab('show');
			break;
		}
		$('#'+_tabla+' tbody').html( _html );
	}
}
