var _servicio = '../php/servicios/proceso-ventas.php';

(function($){
	
	//

	$(document).ready(function(){
		/* -------------------------------------- */
		$('.Zebra_Pagination ul').addClass('pagination');
		//Seleccionar la pagina actual
		$('.Zebra_Pagination ul li').each(function(index, el) {
			var _obj = $(this).find('a');
			if( Number(_obj.html()) == Number(_pagina) ){
				$(this).addClass('active');
			}
		});
		/* -------------------------------------- */
		$('#btnBuscar').click(function(event) {
			var _desde = $('#txtDesde').val();
			var _hasta = $('#txtHasta').val();
			//
			$.post( _servicio , { f:'buscar' , desde:_desde , hasta:_hasta } , function(data, textStatus, xhr) {
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
		$('.input-daterange').each(function (){
			$(this).datepicker({
				format: 'dd/mm/yyyy',
				/*startDate: '-3d',*/
				language : 'es',
				startView : 'day',
				autoclose: true
			});
		});
		/*--------------------------------------------------*/
		$(document).delegate('.anularDocvta', 'click', function(event){
			var _tdoc = $(this).attr('rel');
			var _idv = $(this).attr('href');
			alertify.confirm("Confirme anular "+_tdoc,function(e){
				if(e){
					$.post( _servicio , {f:'delBoleta',id:_idv} , function(data, textStatus, xhr) {
						alertify.error(_tdoc+' Anulada correctamente.');
						$('#Fila_'+_idv).removeClass().addClass('danger');
						$('#estado_'+_idv).html('DEL');
					},'json');
				}
			});
			event.preventDefault();
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
		$(document).delegate('.copiarVenta', 'click', function(event) {
			var _idVenta = $(this).attr('href');
			alertify.confirm('Confirme copiar Pedido de venta #'+_idVenta,function(e){
				if(e){
					$.post( _servicio , {f:'copy',idp:_idVenta} , function(data, textStatus, xhr) {
						document.location.reload();
					},'json');
				}
			});
			event.preventDefault();
		});
	});

})(jQuery);

function llenarTablita( json , _obj ){
	
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.n; i++) {
			_fila = json.data[i];
			var _estado = _fila.estado, _cla = '';
			switch (_estado) {
                case 'CER':
                    _cla = 'success';
                    break;
                case 'DEL':
                    _cla = 'danger';
                    break;
            }
			_html += '<tr class="'+_cla+'">';
				_html += '<td>'+_fila.int_Correlativo+'</td>';
				_html += '<td>';
					_html += '<a href="nueva-venta.php?id='+_fila.id+'" ><strong>'+_fila.var_Nombre+'</strong></a>';
				_html += '</td>';
				if( _fila.int_IdPedido == null ){
					_html += '<td></td>';
				}else{
					_html += '<td>000'+_fila.int_IdPedido+'</td>';
				}
				_html += '<td>'+_fila.fecha+'</td>';
				_html += '<td>'+_fila.flt_Total+'</td>';
				_html += '<td>'+_fila.estado+'</td>';
				_html += '<td>';
					if( _estado != 'DEL' ){
						_html += '<a class="anularBoleta pull-left btn btn-primary btn-outline" href="'+_fila.id+'" alt="" data-toggle="tooltip" data-placement="top" title="Anular Boleta" ><i class="fa fa-times"></i> </a>';
					}
				_html += '</td>';
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
