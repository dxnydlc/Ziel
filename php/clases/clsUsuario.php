<?php
#session_start();
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Clase para registrar a un usuario nuevo
 * @author Dxny DLC
 */
class Usuario extends MySQL{
    //put your code here
    private $campos = array();
    private $dataQ  = array();
    private $unionQ = array();
    private $union  = array();
    private $entero     = array();
    public $idUsuario   = 0;

    public function __construct() {
        parent::__construct();
    }
	
	/* -------------------------------------------------------------------- */
    public function set_UnionQ( $valor , $campo ){
        $this->unionQ[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_NUMBER );
    }
    /* -------------------------------------------------------------------- */
    public function set_UnionT( $valor , $campo ){
        $this->unionQ[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_TEXT );
    }
    /* -------------------------------------------------------------------- */
    public function set_Dato( $valor , $campo ){
        $this->dataQ[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_TEXT);
    }
    /* -------------------------------------------------------------------- */
    public function insertUnion(){
        return $this->InsertRow( 'utb_campana' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function set_Valor( $valor , $campo ){
        $this->campos[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_TEXT);
    }
    /* -------------------------------------------------------------------- */
    public function set_Union( $valor , $campo ){
        $this->union[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_NUMBER );
    }
    /* -------------------------------------------------------------------- */
    public function set_Union_tag( $valor , $campo ){
        $this->union[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_TEXT );
    }
    /* -------------------------------------------------------------------- */
    public function insert_Producto(){
        return $this->InsertRow( 'utb_productos' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_Producto(){
        $this->UpdateRows( 'utb_productos' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function update_precio_Producto(){
        $this->UpdateRows( 'utb_precio_producto' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function insert_Precio_Producto(){
        $this->InsertRow( 'utb_precio_producto' , $this->campos );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_Clase_Producto(){
        return $this->InsertRow( 'utb_clase_producto' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_detalle_pedido(){
        $this->InsertRow( 'utb_pedido_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function create_new_inventario(){
        return $this->InsertRow( 'utb_inventarios' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_new_inventario(){
        $this->UpdateRows( 'utb_inventarios' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function join_inventario_detalle(){
        $this->UpdateRows( 'utb_inventario_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function add_item_inventario(){
        $this->InsertRow( 'utb_inventario_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_detalle_pedido(){
        $this->UpdateRows( 'utb_pedido_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function delete_detalle_pedido(){
        $this->DeleteRows( 'utb_pedido_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function delete_detalle_inventario(){
        $this->DeleteRows( 'utb_inventario_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function delete_clases_in_producto(){
        $this->DeleteRows( 'utb_clases_in_producto' , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_pedido(){
        return $this->InsertRow( 'utb_pedido' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_pedido(){
        return $this->UpdateRows( 'utb_pedido' , $this->campos , $this->union );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function join_pedido_detalle(){
        $this->UpdateRows( 'utb_pedido_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_unidad_medida(){
        return $this->InsertRow( 'utb_unidad_medida' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_Cliente(){
        return $this->InsertRow( 'utb_clientes' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_Equivalencia_Producto(){
        return $this->UpdateRows( 'utb_equivalencia_producto' , $this->campos , $this->union );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_equivalencia_Producto(){
        $this->InsertRow( 'utb_equivalencia_producto' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_clases_in_producto(){
        $this->InsertRow( 'utb_clases_in_producto' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_Generico_Producto(){
        return $this->InsertRow( 'utb_producto_generico' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_Clase_Producto(){
        $this->UpdateRows( 'utb_clase_producto' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function update_Cliente(){
        $this->UpdateRows( 'utb_clientes' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function update_Generico_Producto(){
        return $this->UpdateRows( 'utb_producto_generico' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function existeCampana( $idu , $campana ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT `int_IdAuto` as 'idu' FROM `utb_campana` WHERE `int_IdUsuario` = '".$idu."' AND var_Campana = '".$campana."' ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        if( is_array($data) ){
            foreach ($data as $key => $u) {
                return $u->idu;
            }
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function existe_clase( $nombre ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT `int_IdAuto` as 'id' FROM `utb_clase_producto` WHERE `var_Nombre` = '".$nombre."' ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        if( is_array($data) ){

            foreach ($data as $key => $u) {
                return $u->id;
            }

        }else{

            return 0;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function updateUser(){
        $this->UpdateRows( 'utb_usuarios' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function get_all_clases( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT * FROM `utb_clase_producto` ".$filtro." ORDER BY var_Nombre ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_all_genericos( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT * FROM `utb_producto_generico` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_generico( $id ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_producto_generico` WHERE int_IdGenerico = ".$id;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_clases( $id ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_clase_producto` WHERE int_IdAuto = ".$id;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_unidades_medida(){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_unidad_medida` ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_um( $id ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_unidad_medida` WHERE int_IdUM = ".$id;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_equivalencias_prod( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_equivalencia_producto` e INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = e.`int_IdUM` ".$filtro." and e.chr_Estado = 'ACT' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            $response['sql']   = $sql;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_productos_lista( $filtro = '', $limit = '' ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        $sql = " SELECT *, g.var_Nombre as 'generico', p.var_Nombre as 'producto', 
        p.chr_Estado as 'estado', p.ts_Registro as 'registro',DATE_FORMAT(dt_Vencimiento,'%d/%m/%Y') as 'vencimiento' 
        FROM utb_productos p INNER JOIN utb_producto_generico g ON g.int_IdGenerico = p.int_IdGenerico ".$filtro." ".$limit;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();

            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdProducto"]    = $rs->int_IdProducto;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["int_IdUM"]          = $rs->int_IdUM;
                $o["int_Cantidad"]      = $rs->int_Cantidad;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["generico"]          = $rs->generico;
                $o["producto"]          = $rs->producto;
                $o["estado"]            = $rs->estado;
                $o["registro"]          = $rs->registro;
                $o["vencimiento"]       = $rs->vencimiento;
                $o["chr_Destacado"]     = $rs->chr_Destacado;
                $o["clases"]            = $this->get_clases_in_producto2( $rs->int_IdProducto );
                $o["var_Laboratorio"]   = $rs->var_Laboratorio;
                $o["int_IdProveedor"]   = $rs->int_IdProveedor;
                $o["var_Proveedor"]     = $rs->var_Proveedor;
                $o["arPrecio"]          = $this->get_precio_producto( $rs->int_IdProducto , $rs->int_IdUM );
                #
                array_push( $p , $o );
            }

            $response['data'] = $p;
            return $response;
            
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_precios_producto( $idp ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM utb_precio_producto WHERE int_IdProducto =  ".$idp." AND chr_Estado = 'ACT' ORDER BY ftl_Precio_Venta ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function existe_cliente( $ruc ){
        #En base al RUC
        $sql = '';
        $data = array();
        $response = array();
        $sql = " SELECT `int_IdCliente` as 'id' FROM `utb_clientes` WHERE `var_Ruc` = '".$ruc."' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $u) {
                return $u->id;
            }
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_all_clientes( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT * FROM `utb_clientes` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_clientes_json( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT * FROM `utb_clientes` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $data;
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_data_cliente( $id ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_clientes` WHERE int_IdCliente = ".$id;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data']   = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function existe_um( $nombre ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT `int_IdUM` as 'id' FROM `utb_unidad_medida` WHERE `var_Nombre` = '".$nombre."' ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $u) {
                return $u->id;
            }
        }else{

            return 0;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_detalle_pedido( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, p.int_Cantidad as 'cant' FROM `utb_pedido_detalle` p INNER JOIN `utb_productos` pr ON p.int_IdProducto = pr.int_IdProducto ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetallePedido"]= $rs->int_IdDetallePedido;
                $o["int_IdPedido"]       = $rs->int_IdPedido;
                $o["int_IdProducto"]     = $rs->int_IdProducto;
                $o["int_IdUnidadMedida"] = $rs->int_IdUnidadMedida;
                $o["int_Cantidad"]      = $rs->cant;
                $o["flt_Precio"]        = number_format($rs->flt_Precio,2);
                $o["flt_Total"]         = number_format($rs->flt_Total,2);
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUnidadMedida );
                $o["int_IdPromo"]       = $rs->int_IdPromo;
                $o["var_Promo"]         = $rs->var_Promo;
                $o["flt_Promo"]         = $rs->flt_Promo;
                //$o[""] = $rs[""];
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return '';

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_detalle_inventario( $filtro , $limite ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT * FROM `utb_inventario_detalle` i INNER JOIN `utb_productos` pr 
        ON i.int_IdProducto = pr.int_IdProducto ".$filtro.' '.$limite;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetalleInv"]  = $rs->int_IdDetalleInv;
                $o["int_IdInventario"]  = $rs->int_IdInventario;
                $o["int_IdProducto"]    = $rs->int_IdProducto;
                $o["int_IdUm"]          = $rs->int_IdUm;
                $o["int_Cant"]          = $rs->int_Cant;
                #
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUm );
                //$o[""] = $rs[""];
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function buscar_in_detalle_inventario( $query = '' , $idInv = '' ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT * FROM `utb_inventario_detalle` i INNER JOIN `utb_productos` pr ON i.int_IdProducto = pr.int_IdProducto AND pr.var_Nombre like  '%".$query."%' AND i.int_IdInventario = ".$idInv;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetalleInv"]  = $rs->int_IdDetalleInv;
                $o["int_IdInventario"]  = $rs->int_IdInventario;
                $o["int_IdProducto"]    = $rs->int_IdProducto;
                $o["int_IdUm"]          = $rs->int_IdUm;
                $o["int_Cant"]          = $rs->int_Cant;
                #
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUm );
                //$o[""] = $rs[""];
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_count_detalle_inventario( $id ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT count(int_IdDetalleInv) as 'n' FROM `utb_inventario_detalle` WHERE int_IdInventario = ".$id;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->n;
            }
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_detalle_venta( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, v.int_Cantidad as 'cant' FROM `utb_venta_detalle` v INNER JOIN `utb_productos` pr ON v.`int_IdProducto` = pr.`int_IdProducto` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetalleVenta"]= $rs->int_IdDetalleVenta;
                $o["int_IdVenta"]       = $rs->int_IdVenta;
                $o["int_IdProducto"]    = $rs->int_IdProducto;
                $o["int_IdUnidadMedida"]= $rs->int_IdUnidadMedida;
                $o["int_Cantidad"]      = $rs->cant;
                $o["flt_Precio"]        = number_format( $rs->flt_Precio , 2 );
                $o["flt_Total"]         = number_format( $rs->flt_Total , 2 );
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUnidadMedida );
                $o["int_IdPromo"]       = $rs->int_IdPromo;
                $o["var_Promo"]         = $rs->var_Promo;
                $o["flt_Promo"]         = $rs->flt_Promo;
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return 0;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_unidad_medida( $idum ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_unidad_medida` WHERE int_IdUM = ".$idum;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->var_Nombre;
            }
        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_equivalencia_un_producto( $idprod , $idum ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_equivalencia_producto` WHERE `int_IdProducto` = ".$idprod." AND `int_IdUM` = ".$idum;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->int_Cantidad;
            }
        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_saldo_producto( $idprod ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_kardex_actual` WHERE `int_IdProducto` = ".$idprod." ORDER BY `int_IdAuto` DESC LIMIT 1 ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->int_Saldo;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_stock_lote( $idlote ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT `int_Stock` FROM `utb_producto_lote` WHERE `int_IdLote` = ".$idlote;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->int_Stock;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_un_producto( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        $sql = " SELECT CONCAT( p.var_Nombre ,' x ',u.var_Nombre,' ',p.int_stock) as 'label', p.int_IdProducto as 'id', um.`int_IdUM` as 'um', u.var_Nombre as 'textum', p.chr_Destacado as 'destacado', p.var_Nombre as 'prod'
        FROM utb_productos p INNER JOIN utb_producto_generico g ON g.`int_IdGenerico` = p.`int_IdGenerico` 
        INNER JOIN `utb_equivalencia_producto` um 
        ON um.`int_IdProducto` = p.`int_IdProducto` INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = um.`int_IdUM` 
        AND um.`int_IdProducto` = p.`int_IdProducto` AND um.`chr_Estado` <> 'DES' ".$filtro." ORDER BY  p.var_Nombre ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            $response['n']      = $this->RowCount();

            foreach ($data as $key => $rsp ) {
                $o =  array();
                $pr = array();
                # id | precio venta | precio compra | unidad medida | utilidad
                $o["id"]        = $rspint_IdProducto;
                $o["label"]     = $rspprod;
                $pr = explode(',', $this->get_precio_producto( $rsp->id , $rsp->um ) );
                $o["prec"]      = $pr[0];
                $o["compra"]    = $pr[1];
                $o["utilidad"]  = $pr[2];
                $o["data"]      = $rsp->id.'|'.$pr[0].'|'.$pr[1].'|'.$rsp->um.'|'.$pr[2];
                /**/
                #id | precio venta | precio compra | id unidad medida
                array_push( $p , $o );
            }

            $response['data'] = $p;
            return $p;

        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_prefetch_prod( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        $sql = "SELECT p.var_Nombre as 'label', p.int_IdProducto as 'id' FROM `utb_productos` p INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` INNER JOIN `utb_precio_producto` pr ON pr.`int_IdProducto` = p.`int_IdProducto` AND pr.`chr_Estado` = 'ACT' ".$filtro." ORDER BY  p.var_Nombre ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            $response['n']      = $this->RowCount();

            foreach ($data as $key => $rsp ) {
                $o =  array();
                $pr = array();
                # id | precio venta | precio compra | unidad medida | utilidad
                
                $o["id"]        = $rsp->id;
                $o["label"]     = $rsp->label;
            }

            $response['data'] = $p;
            return $p;

        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_productos_venta( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        $sql = "SELECT *, u.var_Nombre as 'textum', p.var_Nombre as 'prod', p.int_IdProducto as 'idp', p.`int_IdUM` as 'idum'
        FROM `utb_productos` p INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` 
        INNER JOIN `utb_precio_producto` pr ON pr.`int_IdProducto` = p.`int_IdProducto` AND pr.`chr_Estado` = 'ACT' ".$filtro." ORDER BY  p.var_Nombre ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            $response['n']      = $this->RowCount();

            foreach ($data as $key => $rsp ) {
                $o =  array();
                $pr = array();
                # id | precio venta | precio compra | unidad medida | utilidad
                
                $o["id"]    = $rsp->idp;
                $o["idum"]  = $rsp->idum;
                $o["label"] = $rsp->prod;
                if( $rsp->chr_Destacado == 0 ){
                    $o['ico'] = 'nodestacado';
                }else{
                    $o['ico'] = 'destcado';
                }
                $o["prec"]      = $rsp->ftl_Precio_Venta;
                $o["comp"]      = $rsp->flt_Precio_Compra;
                $o["textum"]    = $rsp->textum;
                $o["stock"]     = $rsp->int_stock;
                /*
                $o["um"]        = $rsp["um"];
                
                
                $o["compra"]    = $pr[1];
                $o["utilidad"]  = $pr[2];
                $o["data"]      = $rsp["id"].'|'.$pr[0].'|'.$pr[1].'|'.$rsp["um"].'|'.$pr[2];
                
                /**/
                #id | precio venta | precio compra | id unidad medida
                array_push( $p , $o );
            }

            $response['data'] = $p;
            return $p;

        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_precio_producto( $idprod , $idum ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_precio_producto` WHERE int_IdProducto = ".$idprod." AND int_IdUM = ".$idum." AND chr_Estado = 'ACT' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            foreach ($data as $key => $value) {
                return $value->ftl_Precio_Venta.','.$value->flt_Precio_Compra.','.$value->flt_Utilidad;
            }

        }else{
            return '*';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_precio_producto1( $idprod ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_precio_producto` WHERE int_IdProducto = ".$idprod." AND chr_Estado = 'ACT' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            foreach ($data as $key => $value) {
                return $value->ftl_Precio_Venta.','.$value->flt_Precio_Compra.','.$value->flt_Utilidad;
            }

        }else{
            return '*';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_old_precio_producto( $idDoc ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        #$sql = " SELECT * FROM `utb_precio_producto` WHERE int_IdProducto = ".$idprod." AND int_IdUM = ".$idum." AND chr_Estado = 'ACT' ";
        $sql = " SELECT * FROM `utb_precio_producto` WHERE `var_Doc` = '".$idDoc."' AND `chr_Estado` = 'ACT' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            foreach ($data as $key => $value) {
                return $value->ftl_old_Precio_Venta.','.$value->flt_old_Precio_Compra.','.$value->flt_old_Utilidad;
            }

        }else{
            return '0';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_equivalencias_producto( $idprod ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, e.`int_IdUM` as 'um', e.`int_Cantidad`  as 'cant' FROM `utb_equivalencia_producto` e INNER JOIN `utb_unidad_medida` u ON 
        u.`int_IdUM` = e.`int_IdUM` and e.`chr_Estado` = 'ACT' AND e.`int_IdProducto` = ".$idprod;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_equivalencias_producto_for_precio( $idprod ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, e.`int_IdUM` as 'um', e.`int_Cantidad`  as 'cant' FROM `utb_equivalencia_producto` e INNER JOIN `utb_unidad_medida` u ON 
        u.`int_IdUM` = e.`int_IdUM` and e.`chr_Estado` <> 'DES' AND e.`int_IdProducto` = ".$idprod;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function anular_precios_producto( $idprod ){
        return $this->Query( " UPDATE utb_precio_producto SET chr_Estado = 'DEL' WHERE int_IdProducto = ".$idprod );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_pedido_listado( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(p.ts_Registro,'%d/%m/%Y') as 'fecha', p.`chr_Estado` as 'estado', u.`Var_Nombre` as 'usuario' FROM `utb_pedido` p INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = p.`int_IdCliente` INNER JOIN `utb_usuarios` u ON u.`int_IdUsuario` = p.`int_IdUsuario` ".$filtro." ORDER BY p.int_IdPedido DESC";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function copiar_pedido( $IdaCopiar , $idu ){
        $sql = '';
        $response = '';
        $data = array();
        $NuevoPedido = 0;
        $o = array();

        $sql = "SELECT  int_IdCliente,CURRENT_DATE() as 'fecha',flt_Total FROM utb_pedido WHERE int_IdPedido = ".$IdaCopiar;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        if( is_array($data) ){
            foreach ($data as $key => $p) {
                
                $o["int_IdCliente"] = MySQL::SQLValue( $p->int_IdCliente , MySQL::SQLVALUE_TEXT );
                $o["dt_Fecha"]      = MySQL::SQLValue( $p->fecha , MySQL::SQLVALUE_DATETIME );
                $o["flt_Total"]     = MySQL::SQLValue( $p->flt_Total , MySQL::SQLVALUE_TEXT );
                $o["int_IdUsuario"] = MySQL::SQLValue( $idu , MySQL::SQLVALUE_TEXT );
                
                $this->InsertRow( 'utb_pedido' , $o );
                $NuevoPedido = $this->GetLastInsertID();
            }
        }

        $sql = " INSERT INTO utb_pedido_detalle(int_IdPedido,int_IdProducto,int_IdUnidadMedida,int_Cantidad,flt_Precio,flt_Total,int_IdUsuario,int_IdLote) SELECT ".$NuevoPedido.",int_IdProducto,int_IdUnidadMedida,int_Cantidad,flt_Precio,flt_Total,".$idu.",int_IdLote FROM utb_pedido_detalle WHERE int_IdPedido = ".$IdaCopiar;
        $this->Query( $sql );
        return $NuevoPedido;
    }
    /* -------------------------------------------------------------------- */
    public function get_data_pedido( $idPedido ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(p.ts_Registro,'%d/%m/%Y') as 'fecha', p.chr_Estado as 'estado' FROM `utb_pedido` p INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = p.`int_IdCliente` AND p.int_IdPedido = ".$idPedido;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_venta( $idVenta , $filtro = '' ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(v.ts_Registro,'%d/%m/%Y') as 'fecha', v.`var_Dir` as 'dir', v.`chr_Estado` as 'estado', u.`var_Usuario` as 'user', v.`ts_Registro` as 'registro' FROM `utb_venta` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdCliente` INNER JOIN `utb_usuarios` u ON u.`int_IdUsuario` = v.`int_IdUsuario` AND v.`int_idVenta` = ".$idVenta;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            $response['data_del']      = $this->get_data_anulado_venta( $idVenta );
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_listado_ventas( $filtro , $limit = '' ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(v.ts_Registro,'%d/%m/%Y') as 'fecha', v.`var_Dir` as 'dir', v.`int_IdVenta` as 'id', v.`chr_Estado` as 'estado', u.`var_Usuario` as 'user' 
        FROM `utb_venta` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdCliente` INNER JOIN `utb_usuarios` u ON u.`int_IdUsuario` = v.`int_IdUsuario` ".$filtro." ORDER BY v.int_IdVenta DESC ".$limit;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function count_listado_ventas(){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT COUNT( v.`int_IdVenta`) as 'n' FROM `utb_venta` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdCliente` INNER JOIN `utb_usuarios` u ON u.`int_IdUsuario` = v.`int_IdUsuario`  ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rsp) {
                return $rsp->n;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function facturar_pedido( $tipo = 'B' , $idPedido = 0 , $cor = 0 , $idu ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_pedido` WHERE `int_IdPedido` = ".$idPedido;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array( $data ) ){
            #Si hay datos los inserto en el encabezado de la tabla de ventas.
            $mascara = '';
            $c = array();
            $corr = 0;
            $serie = "001";
            if( $cor == 0 ){
                $corr = $this->get_max_correlativo( $tipo ) + 1;
            }else{
                $corr = $cor;
            }
            switch ($tipo) {
                case 'B':
                    $mascara = 'Boleta '.sprintf("%05s", $corr );
                    break;
                case 'F':
                    $mascara = 'Boleta '.sprintf("%05s", $corr );
                    break;
                case 'R':
                    $mascara = 'Boleta '.sprintf("%05s", $corr );
                    break;
            }
            

            $corr = sprintf("%06s", $corr );
            
            foreach ($data as $key => $p ) {
                $c["cht_TipoDoc"]       = MySQL::SQLValue( $tipo , MySQL::SQLVALUE_TEXT );
                $c['int_IdPedido']      = MySQL::SQLValue( $p->int_IdPedido , MySQL::SQLVALUE_NUMBER );
                $c["flt_Total"]         = MySQL::SQLValue( $p->flt_Total , MySQL::SQLVALUE_TEXT );
                $c["int_Serie"]         = MySQL::SQLValue( $serie , MySQL::SQLVALUE_TEXT );
                $c["dt_Fecha"]          = MySQL::SQLValue( $p->dt_Fecha , MySQL::SQLVALUE_TEXT );
                $c["int_Correlativo"]   = MySQL::SQLValue( $corr , MySQL::SQLVALUE_TEXT );
                $c["int_IdCliente"]     = MySQL::SQLValue( $p->int_IdCliente , MySQL::SQLVALUE_TEXT );
                $c["var_Mascara"]       = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
                $c["int_IdUsuario"]     = MySQL::SQLValue( $idu , MySQL::SQLVALUE_TEXT );
                
                #Copiando Encabezado.
                $this->InsertRow( 'utb_venta' , $c );
                $idVenta = $this->GetLastInsertID();
            }
            #Copiando Detalle
            $sql =  " INSERT INTO `utb_venta_detalle`(`int_IdVenta`, `int_IdProducto`, `int_IdUnidadMedida`, `int_Cantidad`, `flt_Precio`, `flt_Total`,int_IdUsuario,int_IdPromo,var_Promo,flt_Promo,int_IdLote) SELECT ".$idVenta.", `int_IdProducto`, `int_IdUnidadMedida`, `int_Cantidad`, `flt_Precio`, `flt_Total`,".$idu.",int_IdPromo,var_Promo,flt_Promo,int_IdLote FROM `utb_pedido_detalle` WHERE `int_IdPedido` = ".$idPedido;
            $this->Query( $sql );

            #Marcando Pedido.
            $p = array();
            $idp = array();
            $lafecha = date("y-m-d H:i:s");

            $p["chr_TipoDoc"]       = MySQL::SQLValue( $tipo , MySQL::SQLVALUE_TEXT );
            $p["chr_Estado"]        = MySQL::SQLValue( 'ADJ' , MySQL::SQLVALUE_TEXT );
            $p["var_NumDoc"]        = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
            $p["ts_FechaDoc"]       = MySQL::SQLValue( $lafecha , MySQL::SQLVALUE_DATETIME );
            $idp['int_IdPedido']    = MySQL::SQLValue( $idPedido , MySQL::SQLVALUE_NUMBER );
            #
            $this->UpdateRows( 'utb_pedido' , $p , $idp );


            return $idVenta;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_max_correlativo( $tipo ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT MAX(`int_Correlativo`) as 'corr' FROM `utb_venta` WHERE `cht_TipoDoc` = '".$tipo."' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $s) {
                return $s->corr;
            }
        }else{
            return 1;
        }
    }
    /* -------------------------------------------------------------------- */
    public function inventario_kardex( $idInventario ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $fechai = '';
        $concepto = 'I';
        $num_doc = $idInventario;
        $cliente = '';
        $tipoInv = '';
        # Encabezado detalle.

        $sql = " SELECT *, dt_Fecha as 'fecha' FROM `utb_inventarios` WHERE `int_IdAuto` = ".$idInventario;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $e) {
                $fechai  = $e->fecha;
                $cliente = $e->var_Nombre;
                $tipoInv = $e->var_Tipo;
            }
        }else{
            return 0;
        }
        /*
        - Antes de realizar el inventario se enviará el kardex actual al kardex historico.
        */
        if( $tipoInv == 'Todos' ){
            $sql = " INSERT INTO `utb_kardex_historial` SELECT * FROM `utb_kardex_actual` ";
            $this->Query( $sql );
            #Ahora trunco la tabla del kardex actual
            $this->TruncateTable('utb_kardex_actual');
        }

        #Detalle del movimiento.
        $sql = " SELECT *,pr.var_Nombre as 'prod', um.var_Nombre as 'um', i.int_IdUm as 'idum' FROM `utb_inventario_detalle` i INNER JOIN `utb_productos` pr ON i.int_IdProducto = pr.int_IdProducto INNER JOIN `utb_unidad_medida` um on um.int_IdUM = i.int_IdUm and i.int_IdInventario = ".$idInventario;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            
            foreach ($data as $key => $d) {

                $k = array();
                $unidadMedida = '';

                $tipoMov = '';
                $concepto = '';
                $equiv          = (int)$this->get_equivalencia_un_producto( $d->int_IdProducto , $d->idum );
                $cant_proc      = 0;
                $saldo_act      = 0;
                $det_entra     = (int)$d->int_Cant;
                $det_saldo      = 0;//(int)$this->get_saldo_producto( $d["int_IdProducto"] );

                #Voy a descargar la cantidad del doc de ventas x el equivalente (frasco = 10, caja = 30 etc.)
                $cant_proc      = ( $det_entra );// * $equiv
                /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                $tipoMov        = 'A';
                $saldo_act      = $det_saldo + $cant_proc;
                $concepto       = 'Inventario';
                /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

                $det_idProd     = $d->int_IdProducto;
                $det_NombProd   = $d->prod;
                $det_unidadMedi = $d->um;
                #Ahora inserto el kardex.

                $k["dt_Fecha"]      = MySQL::SQLValue( $fechai , MySQL::SQLVALUE_DATETIME );
                $k["chr_Concepto"]  = MySQL::SQLValue( $concepto , MySQL::SQLVALUE_TEXT );
                $k["var_Descri"]    = MySQL::SQLValue( 'Inventario Inicial' , MySQL::SQLVALUE_TEXT );
                
                $k["var_NumeroDoc"] = MySQL::SQLValue( $idInventario , MySQL::SQLVALUE_NUMBER );
                $k["var_Cliente"]   = MySQL::SQLValue( $cliente , MySQL::SQLVALUE_TEXT );
                
                #Entrada
                $k["int_Entrada"]   = MySQL::SQLValue( $det_entra , MySQL::SQLVALUE_NUMBER );
                $k["int_Salida"]    = MySQL::SQLValue( 0 , MySQL::SQLVALUE_NUMBER );
                $k["int_Saldo"]     = MySQL::SQLValue( $saldo_act , MySQL::SQLVALUE_NUMBER );

                $k["int_IdProducto"]        = MySQL::SQLValue( $det_idProd , MySQL::SQLVALUE_NUMBER );
                $k["var_NombreProducto"]    = MySQL::SQLValue( $det_NombProd , MySQL::SQLVALUE_TEXT );
                $k["var_UnidadMedida"]      = MySQL::SQLValue( $det_unidadMedi , MySQL::SQLVALUE_TEXT );
                $k["var_Mascara"]           = MySQL::SQLValue( 'Inventario '.sprintf("%05s", $idInventario ) , MySQL::SQLVALUE_TEXT );

                $this->InsertRow( 'utb_kardex_actual' , $k );
                $idKardex = $this->GetLastInsertID();
                #$idKardex = $this->getLastSQL();

                #Actualizar Stock en tabla productos.
                $k = array();
                $p = array();
                $k["int_stock"]         = MySQL::SQLValue( $saldo_act , MySQL::SQLVALUE_NUMBER );
                $p["int_IdProducto"]    = MySQL::SQLValue( $det_idProd , MySQL::SQLVALUE_NUMBER );
                $this->UpdateRows( 'utb_productos' , $k , $p );
                
            }
            return $idKardex;
        }else{
            return 1;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_Inventarios( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *,DATE_FORMAT(dt_Fecha,'%d/%m/%Y') as 'fecha' FROM `utb_inventarios` ".$filtro." ORDER BY int_IdAuto DESC ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_Kardex( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *,DATE_FORMAT(ts_Registro,'%d/%m/%Y') as 'fecha' FROM `utb_kardex_actual` ".$filtro." ORDER BY int_IdAuto DESC ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_clases_json( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT `int_IdAuto` as 'id', `var_Nombre` as 'name' FROM `utb_clase_producto` WHERE `chr_Estado` = 'ACT' ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_clases_in_producto( $idProducto ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT c.int_IdAuto as 'id', c.var_Nombre as 'name' FROM `utb_clases_in_producto` cp INNER JOIN `utb_clase_producto` c ON 
        cp.`int_IdClase` = c.`int_IdAuto` AND cp.`int_IdProducto` = ".$idProducto;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            $response['json'] = json_encode( $data );
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_clases_in_producto2( $idProducto ){
        /*
        Esta funcion solo va a devolver un arreglo simple del query.
        */
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT c.int_IdAuto as 'id', c.var_Nombre as 'name' FROM `utb_clases_in_producto` cp INNER JOIN `utb_clase_producto` c ON 
        cp.`int_IdClase` = c.`int_IdAuto` AND cp.`int_IdProducto` = ".$idProducto;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function disminuir_kardex( $idDoc ){
        /*
        Esta funcion va a agregar el detalle de un documento de ventas al kardex y reducir el respectivo stock
        */
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $enc_fecha      = '';
        $enc_tipodoc    = '';
        $enc_numdoc     = '';
        $enc_cliente    = '';
        #
        $sql = " SELECT * FROM `utb_venta` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdCliente` AND v.`int_idVenta` = ".$idDoc;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            
            #Obtener los encabezados del Documento
            foreach ( $data as $key => $rs ) {
                $enc_fecha      = $rs->dt_Fecha;
                $enc_tipodoc    = $rs->cht_TipoDoc;
                $enc_numdoc     = $rs->int_idVenta;
                $enc_cliente    = $rs->var_Nombre;
                $la_serie       = $rs->int_Serie;
                $el_corr        = $rs->int_Correlativo;
            }
            $mascara = '';
            switch ($enc_tipodoc) {
                case 'B':
                    $mascara = 'Boleta '.sprintf("%06s", $el_corr );
                    break;
                case 'F':
                    $mascara = 'Factura '.sprintf("%03s", $la_serie ).'-'.sprintf("%06s", $el_corr );
                    break;
                case 'R':
                    $mascara = 'Recibo '.sprintf("%06s", $el_corr );
                    break;
            }
            #Obtener los detalles del Documento
            /*$sql = " SELECT *, d.int_Cantidad as 'cant', p.var_Nombre as 'prod', um.var_Nombre as 'um', d.int_IdUnidadMedida as 'idum' FROM `utb_venta_detalle` d INNER JOIN `utb_productos` p ON d.`int_IdProducto` = p.`int_IdProducto` 
            INNER JOIN `utb_unidad_medida` um on um.int_IdUM = d.int_IdUnidadMedida AND d.`int_IdVenta` = ".$idDoc;*/
            $sql = " SELECT *, d.`int_Cantidad` as 'cant', p.`var_Nombre` as 'prod', um.`var_Nombre` as 'um', d.`int_IdUnidadMedida` as 'idum',
            l.`var_Lote` as 'lote', l.`int_IdLote` as 'idlote'
            FROM `utb_venta_detalle` d INNER JOIN `utb_productos` p ON d.`int_IdProducto` = p.`int_IdProducto` 
            INNER JOIN `utb_unidad_medida` um on um.`int_IdUM` = d.`int_IdUnidadMedida` 
            INNER JOIN`utb_producto_lote` l ON l.`int_IdLote` = d.`int_IdLote` AND d.`int_IdVenta` = ".$idDoc;
            $data = $this->QueryArray( $sql , MYSQL_ASSOC );

            if( is_array($data) ){
                foreach ($data as $key => $rd) {

                    $tipoMov = '';
                    #$equiv          = (int)$this->get_equivalencia_un_producto( $rd["int_IdProducto"] , $rd["idum"] );
                    $cant_proc      = 0;
                    $saldo_act      = 0;

                    $det_salida     = (int)$rd->cant;
                    #Saldo de todo el producto, cuantos quedan
                    $det_saldo      = (int)$this->get_saldo_producto( $rd->int_IdProducto );

                    #Voy a descargar la cantidad del doc de ventas x el equivalente (frasco = 10, caja = 30 etc.)
                    $cant_proc      = ( $det_salida );//* $equiv 
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    $tipoMov        = 'S';
                    $saldo_act      = $det_saldo - $cant_proc;
                    $concepto       = 'Salida por Venta';
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    #Lotes
                    $lote           = $rd->lote;
                    $idlote         = $rd->idlote;
                    $saldo_lote     = (int)$this->get_stock_lote( $idlote );
                    $new_saldo_lote = 0;
                    $new_saldo_lote = $saldo_lote - $det_salida;
                    #Disminuir/Aumentar stock en lote
                    $this->download_lote_producto( $idlote , $new_saldo_lote  );
                    #
                    $det_idProd     = $rd->int_IdProducto;
                    $det_NombProd   = $rd->prod;
                    $det_unidadMedi = $rd->um;
                    #Ahora inserto el kardex.
                    $k = array();
                    #
                    $k["dt_Fecha"]          = MySQL::SQLValue( $enc_fecha , MySQL::SQLVALUE_DATETIME );
                    $k["chr_Concepto"]      = MySQL::SQLValue( $tipoMov , MySQL::SQLVALUE_TEXT );
                    $k["var_Descri"]        = MySQL::SQLValue( $concepto , MySQL::SQLVALUE_TEXT );
                    $k["chr_TipoDoc"]       = MySQL::SQLValue( $enc_tipodoc , MySQL::SQLVALUE_TEXT );
                    $k["var_NumeroDoc"]     = MySQL::SQLValue( $enc_numdoc , MySQL::SQLVALUE_TEXT );
                    $k["var_Cliente"]       = MySQL::SQLValue( $enc_cliente , MySQL::SQLVALUE_TEXT );
                    $k["int_Salida"]        = MySQL::SQLValue( $cant_proc , MySQL::SQLVALUE_NUMBER );
                    $k["int_Saldo"]         = MySQL::SQLValue( $saldo_act , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdProducto"]    = MySQL::SQLValue( $det_idProd , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdLote"]        = MySQL::SQLValue( $idlote , MySQL::SQLVALUE_NUMBER );
                    $k["var_NombreProducto"]= MySQL::SQLValue( $det_NombProd.' Lote: '.$lote , MySQL::SQLVALUE_TEXT );
                    $k["var_UnidadMedida"]  = MySQL::SQLValue( $det_unidadMedi , MySQL::SQLVALUE_TEXT );
                    $k["var_Mascara"]       = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
                    #
                    $this->InsertRow( 'utb_kardex_actual' , $k );

                    #Actualizar Stock en tabla productos.
                    $this->update_stock_producto( $det_idProd , $saldo_act );
                }
            }
            return 'Andu falah';

        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function anular_kardex( $idDoc ){
        /*
        Esta funcion va a agregar el detalle de un documento de ventas al kardex y aumentar el respectivo stock
        ya que es una anulacion
        */
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $enc_fecha      = '';
        $enc_tipodoc    = '';
        $enc_numdoc     = '';
        $enc_cliente    = '';
        #
        $sql = " SELECT * FROM `utb_venta` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdCliente` AND v.`int_idVenta` = ".$idDoc;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            
            #Obtener los encabezados del Documento
            foreach ( $data as $key => $rs ) {
                $enc_fecha      = $rs->dt_Fecha;
                $enc_tipodoc    = $rs->cht_TipoDoc;
                $enc_numdoc     = $rs->int_idVenta;
                $enc_cliente    = $rs->var_Nombre;
                $corr           = sprintf("%05s", $rs->int_Correlativo );
                $serie          = sprintf("%03s", $rs->int_Serie );
                $tipo           = $rs->cht_TipoDoc;
            }
            $mascara = '';
            switch ($enc_tipodoc) {
                case 'B':
                    $mascara = 'Boleta '.sprintf("%06s", $corr );
                    break;
                case 'F':
                    $mascara = 'Factura '.sprintf("%03s", $serie ).'-'.sprintf("%06s", $corr );
                    break;
                case 'R':
                    $mascara = 'Recibo '.sprintf("%06s", $corr );
                    break;
            }
            #Obtener los detalles del Documento
            /*$sql = " SELECT *, d.int_Cantidad as 'cant', p.var_Nombre as 'prod', um.var_Nombre as 'um', d.int_IdUnidadMedida as 'idum' FROM `utb_venta_detalle` d INNER JOIN `utb_productos` p ON d.`int_IdProducto` = p.`int_IdProducto` 
            INNER JOIN `utb_unidad_medida` um on um.int_IdUM = d.int_IdUnidadMedida AND d.`int_IdVenta` = ".$idDoc;*/
            $sql = " SELECT *, d.`int_Cantidad` as 'cant', p.`var_Nombre` as 'prod', um.`var_Nombre` as 'um', d.`int_IdUnidadMedida` as 'idum',
            l.`var_Lote` as 'lote', l.`int_IdLote` as 'idlote'
            FROM `utb_venta_detalle` d INNER JOIN `utb_productos` p ON d.`int_IdProducto` = p.`int_IdProducto` 
            INNER JOIN `utb_unidad_medida` um on um.`int_IdUM` = d.`int_IdUnidadMedida` 
            INNER JOIN`utb_producto_lote` l ON l.`int_IdLote` = d.`int_IdLote` AND d.`int_IdVenta` = ".$idDoc;
            $data = $this->QueryArray( $sql , MYSQL_ASSOC );

            if( is_array($data) ){
                foreach ($data as $key => $rd) {

                    $tipoMov = '';
                    $concepto = '';
                    #$equiv          = (int)$this->get_equivalencia_un_producto( $rd["int_IdProducto"] , $rd["idum"] );
                    $cant_proc      = 0;
                    $saldo_act      = 0;

                    $det_salida     = (int)$rd->cant;
                    $det_saldo      = (int)$this->get_saldo_producto( $rd->int_IdProducto );

                    #Voy a descargar la cantidad del doc de ventas x el equivalente (frasco = 10, caja = 30 etc.)
                    $cant_proc      = ( $det_salida );//* $equiv 
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    $tipoMov        = 'A';
                    $saldo_act      = $det_saldo + $cant_proc;
                    $concepto       = 'Ingreso por Anular venta';
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    #Lotes
                    $lote           = $rd->lote;
                    $idlote         = $rd->idlote;
                    $saldo_lote     = (int)$this->get_stock_lote( $idlote );
                    $new_saldo_lote = 0;
                    $new_saldo_lote = $saldo_lote + $det_salida;
                    #Disminuir/Aumentar stock en lote
                    $this->download_lote_producto( $idlote , $new_saldo_lote  );
                    #
                    $det_idProd     = $rd->int_IdProducto;
                    $det_NombProd   = $rd->prod;
                    $det_unidadMedi = $rd->um;
                    #Ahora inserto el kardex.
                    $k = array();
                    #
                    $k["dt_Fecha"]          = MySQL::SQLValue( $enc_fecha , MySQL::SQLVALUE_DATETIME );
                    $k["chr_Concepto"]      = MySQL::SQLValue( $tipoMov , MySQL::SQLVALUE_TEXT );
                    $k["chr_TipoDoc"]       = MySQL::SQLValue( $enc_tipodoc , MySQL::SQLVALUE_TEXT );
                    $k["var_Descri"]        = MySQL::SQLValue( $concepto , MySQL::SQLVALUE_TEXT );
                    $k["var_NumeroDoc"]     = MySQL::SQLValue( $enc_numdoc , MySQL::SQLVALUE_TEXT );
                    $k["var_Cliente"]       = MySQL::SQLValue( $enc_cliente , MySQL::SQLVALUE_TEXT );
                    $k["int_Entrada"]       = MySQL::SQLValue( $cant_proc , MySQL::SQLVALUE_NUMBER );
                    $k["int_Saldo"]         = MySQL::SQLValue( $saldo_act , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdLote"]        = MySQL::SQLValue( $idlote , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdProducto"]    = MySQL::SQLValue( $det_idProd , MySQL::SQLVALUE_NUMBER );
                    $k["var_NombreProducto"]= MySQL::SQLValue( $det_NombProd.' Lote: '.$lote , MySQL::SQLVALUE_TEXT );
                    $k["var_UnidadMedida"]  = MySQL::SQLValue( $det_unidadMedi , MySQL::SQLVALUE_TEXT );
                    $k["var_Mascara"]       = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
                    #
                    $this->InsertRow( 'utb_kardex_actual' , $k );
                    
                    #Actualizar Stock en tabla productos.
                    $this->update_stock_producto( $det_idProd , $saldo_act );
                }
            }
            return 'Andu falah';

        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    /* ---------------------------------------------utb_orden_compra_detalle----------------------- */
    public function delete_detalle_oc(){
        $this->DeleteRows( 'utb_orden_compra_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    public function copiar_orden_compra( $IdaCopiar ){
        $sql = '';
        $response = '';
        $data = array();
        $NuevaOC = 0;
        $o = array();

        $sql = "SELECT  int_IdProveedor,CURRENT_DATE() as 'fecha',flt_Total FROM utb_orden_compra WHERE int_IdOrdenCompra = ".$IdaCopiar;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        if( is_array($data) ){
            foreach ($data as $key => $p) {
                
                $o["int_IdProveedor"] = MySQL::SQLValue( $p->int_IdProveedor , MySQL::SQLVALUE_TEXT );
                $o["dt_Fecha"]        = MySQL::SQLValue( $p->fecha , MySQL::SQLVALUE_DATETIME );
                $o["flt_Total"]       = MySQL::SQLValue( $p->flt_Total , MySQL::SQLVALUE_TEXT );
                $o["int_Copia"]       = MySQL::SQLValue( $IdaCopiar , MySQL::SQLVALUE_TEXT );
                
                $this->InsertRow( 'utb_orden_compra' , $o );
                $NuevaOC = $this->GetLastInsertID();
            }
        }

        $sql = " INSERT INTO utb_orden_compra_detalle(int_IdOrdenCompra,int_IdProducto,int_IdUnidadMedida,int_Cantidad,flt_Precio,flt_Total,flt_Precio_Compra,ftl_Precio_Venta,flt_Utilidad) SELECT ".$NuevaOC.",int_IdProducto,int_IdUnidadMedida,int_Cantidad,flt_Precio,flt_Total,flt_Precio_Compra,ftl_Precio_Venta,flt_Utilidad FROM utb_orden_compra_detalle WHERE int_IdOrdenCompra = ".$IdaCopiar;
        $this->Query( $sql );
        return $NuevaOC;
    }
    /* -------------------------------------------------------------------- */
    public function update_detalle_oc(){
        $this->UpdateRows( 'utb_orden_compra_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_detalle_oc(){
        $this->InsertRow( 'utb_orden_compra_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_detalle_oc( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, p.int_Cantidad as 'cant' FROM `utb_orden_compra_detalle` p INNER JOIN `utb_productos` pr ON p.int_IdProducto = pr.int_IdProducto ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetalleOC"]   = $rs->int_IdDetalleOC;
                $o["int_IdOrdenCompra"] = $rs->int_IdOrdenCompra;
                $o["int_IdProducto"]    = $rs->int_IdProducto;
                $o["int_IdUnidadMedida"]= $rs->int_IdUnidadMedida;
                $o["int_Cantidad"]      = $rs->cant;
                $o["flt_Precio"]        = number_format($rs->flt_Precio,2);
                $o["flt_Precio_Compra"] = number_format($rs->flt_Precio_Compra,2);
                $o["ftl_Precio_Venta"]  = number_format($rs->ftl_Precio_Venta,2);
                $o["flt_Utilidad"]      = number_format($rs->flt_Utilidad,2);
                $o["flt_Total"]         = number_format($rs->flt_Total,2);
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUnidadMedida );
                //$o[""] = $rs[""];
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return 0;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function insert_oc(){
        return $this->InsertRow( 'utb_orden_compra' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function join_pedido_oc(){
        $this->UpdateRows( 'utb_orden_compra_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_oc(){
        return $this->UpdateRows( 'utb_orden_compra' , $this->campos , $this->union );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_oc_listado( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(p.ts_Registro,'%d/%m/%Y') as 'fecha', p.`chr_Estado` as 'estado' FROM `utb_orden_compra` p INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = p.`int_IdProveedor` ".$filtro." ORDER BY p.int_IdOrdenCompra DESC";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_oc( $idOC ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(p.dt_Fecha,'%d/%m/%Y') as 'fecha', p.chr_Estado as 'estado' FROM `utb_orden_compra` p INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = p.`int_IdProveedor` AND p.int_IdOrdenCompra = ".$idOC;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    public function oc_to_pe( $idOC ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_orden_compra` WHERE `int_IdOrdenCompra` = ".$idOC;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array( $data ) ){
            #Si hay datos los inserto en el encabezado de la tabla de ventas.
            $c      = array();
            $idPE   = 0;
            
            foreach ($data as $key => $p ) {
                $c["int_IdProveedor"]   = MySQL::SQLValue( $p->int_IdProveedor , MySQL::SQLVALUE_NUMBER );
                $c['dt_Fecha']          = MySQL::SQLValue( $p->dt_Fecha , MySQL::SQLVALUE_TEXT );
                $c["flt_Total"]         = MySQL::SQLValue( $p->flt_Total , MySQL::SQLVALUE_TEXT );
                $c["var_NumOC"]         = MySQL::SQLValue( $idOC , MySQL::SQLVALUE_TEXT );
                #Copiando Encabezado.
                $this->InsertRow( 'utb_parte_entrada' , $c );
                $idPE = $this->GetLastInsertID();
            }
            #Copiando Detalle
            $sql =  " INSERT INTO `utb_parte_entrada_detalle`(`int_IdParteEntrada`, `int_IdProducto`, `int_IdUnidadMedida`, `int_Cantidad`, `flt_Precio`, `flt_Total`,`flt_Precio_Compra`,`ftl_Precio_Venta`,`flt_Utilidad`) SELECT ".$idPE.", `int_IdProducto`, `int_IdUnidadMedida`, `int_Cantidad`, `flt_Precio`, `flt_Total`,`flt_Precio_Compra`,`ftl_Precio_Venta`,`flt_Utilidad` FROM `utb_orden_compra_detalle` WHERE `int_IdOrdenCompra` = ".$idOC;
            $this->Query( $sql );

            #Marcando Orden de Compra.
            $p          = array();
            $idp        = array();
            $lafecha    = date("y-m-d H:i:s");

            $p["int_ParteEntrada"]      = MySQL::SQLValue( $idPE , MySQL::SQLVALUE_TEXT );
            $p["chr_Estado"]            = MySQL::SQLValue( 'ADJ' , MySQL::SQLVALUE_TEXT );
            $idp['int_IdOrdenCompra']   = MySQL::SQLValue( $idOC , MySQL::SQLVALUE_NUMBER );
            #
            $this->UpdateRows( 'utb_orden_compra' , $p , $idp );


            return $idPE;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_pe_listado( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(p.ts_Registro,'%d/%m/%Y') as 'fecha', p.`chr_Estado` as 'estado' FROM `utb_parte_entrada` p INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = p.`int_IdProveedor` ".$filtro." ORDER BY p.int_IdParteEntrada DESC";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_pe( $idPE ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(p.ts_Registro,'%d/%m/%Y') as 'fecha', p.chr_Estado as 'estado' FROM `utb_parte_entrada` p INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = p.`int_IdProveedor` AND p.int_IdParteEntrada = ".$idPE;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_detalle_pe( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, p.int_Cantidad as 'cant' FROM `utb_parte_entrada_detalle` p INNER JOIN `utb_productos` pr ON p.int_IdProducto = pr.int_IdProducto ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetallePE"]   = $rs->int_IdDetallePE;
                $o["int_IdOrdenCompra"] = $rs->int_IdOrdenCompra;
                $o["int_IdProducto"]    = $rs->int_IdProducto;
                $o["int_IdUnidadMedida"]= $rs->int_IdUnidadMedida;
                $o["cant"]              = $rs->cant;
                $o["flt_Precio"]        = number_format($rs->flt_Precio ,2 );
                $o["flt_Precio_Compra"] = number_format($rs->flt_Precio_Compra ,2 );
                $o["ftl_Precio_Venta"]  = number_format($rs->ftl_Precio_Venta ,2 );
                $o["flt_Utilidad"]      = number_format($rs->flt_Utilidad ,2 );
                $o["flt_Total"]         = number_format($rs->flt_Total ,2 );
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUnidadMedida );
                //$o[""] = $rs[""];
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return 0;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_detalle_pe01( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, p.`int_Cantidad` as 'cant', u.`var_Nombre` as 'unidadMedida', pr.`var_Nombre` as 'prod', p.`var_Lote` as 'lote', p.`var_Laboratorio` as 'lab', DATE_FORMAT(p.`dt_Vencimiento`,'%d/%m/%Y') as 'fecha' 
        FROM `utb_parte_entrada_detalle` p INNER JOIN `utb_productos` pr ON p.`int_IdProducto` = pr.`int_IdProducto` INNER JOIN  `utb_unidad_medida` u ON u.`int_IdUM` = pr.`int_IdUM` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function copiar_parte_entrada( $IdaCopiar ){
        $sql = '';
        $response = '';
        $data = array();
        $NuevoPE = 0;
        $o = array();

        $sql = "SELECT  int_IdProveedor,CURRENT_DATE() as 'fecha',flt_Total FROM utb_parte_entrada WHERE int_IdParteEntrada = ".$IdaCopiar;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        if( is_array($data) ){
            foreach ($data as $key => $p) {
                
                $o["int_IdProveedor"]   = MySQL::SQLValue( $p->int_IdProveedor , MySQL::SQLVALUE_TEXT );
                $o["dt_Fecha"]          = MySQL::SQLValue( $p->fecha , MySQL::SQLVALUE_DATETIME );
                $o["flt_Total"]         = MySQL::SQLValue( $p->flt_Total , MySQL::SQLVALUE_TEXT );
                
                $this->InsertRow( 'utb_parte_entrada' , $o );
                $NuevoPE = $this->GetLastInsertID();
            }
        }

        $sql = " INSERT INTO utb_parte_entrada_detalle(int_IdParteEntrada,int_IdProducto,int_IdUnidadMedida,int_Cantidad,flt_Precio,flt_Total) SELECT ".$NuevoPE.",int_IdProducto,int_IdUnidadMedida,int_Cantidad,flt_Precio,flt_Total FROM utb_parte_entrada_detalle WHERE int_IdParteEntrada = ".$IdaCopiar;
        $this->Query( $sql );
        return $NuevoPE;
    }
    /* -------------------------------------------------------------------- */
    public function update_detalle_pe(){
        $this->UpdateRows( 'utb_parte_entrada_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_detalle_pe(){
        $this->InsertRow( 'utb_parte_entrada_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_pe(){
        return $this->InsertRow( 'utb_parte_entrada' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_pe(){
        $this->UpdateRows( 'utb_parte_entrada' , $this->campos , $this->union );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function join_pe_detalle(){
        $this->UpdateRows( 'utb_parte_entrada_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function anular_kardex_from_pe( $idDoc ){
        /*
        Esta funcion va a agregar el detalle de un documento Parte de entrada al kardex y aumentar el respectivo stock
        */
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $enc_fecha      = '';
        $enc_tipodoc    = '';
        $enc_numdoc     = '';
        $enc_cliente    = '';
        $mascara        = '';
        #
        $sql = " SELECT * FROM `utb_parte_entrada` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdProveedor` AND v.`int_IdParteEntrada` = ".$idDoc;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            
            #Obtener los encabezados del Documento
            foreach ( $data as $key => $rs ) {
                $enc_fecha      = $rs->dt_Fecha;
                $enc_tipodoc    = 'PE';
                $enc_numdoc     = $rs->int_IdParteEntrada;
                $enc_cliente    = $rs->var_Nombre;
                $mascara        = 'Parte Entrada '.sprintf("%05s", $enc_numdoc );
            }

            #Obtener los detalles del Documento
            $sql = " SELECT *, d.int_Cantidad as 'cant', p.var_Nombre as 'prod', um.var_Nombre as 'um', d.int_IdUnidadMedida as 'idum', d.`var_Lote` as 'lote', d.`var_Laboratorio` as 'lab', d.`dt_Vencimiento` as 'fecha' FROM `utb_parte_entrada_detalle` d INNER JOIN `utb_productos` p ON d.`int_IdProducto` = p.`int_IdProducto` 
            INNER JOIN `utb_unidad_medida` um on um.int_IdUM = d.int_IdUnidadMedida AND d.`int_IdParteEntrada` = ".$idDoc;
            $data = $this->QueryArray( $sql , MYSQL_ASSOC );

            $lasIdKardex = 0;

            if( is_array($data) ){
                foreach ($data as $key => $rd) {

                    $tipoMov = '';
                    $equiv          = 0;#(int)$this->get_equivalencia_un_producto( $rd["int_IdProducto"] , $rd["idum"] );
                    $cant_proc      = 0;
                    $saldo_act      = 0;

                    $det_salida     = (int)$rd->cant;
                    $det_saldo      = (int)$this->get_saldo_producto( $rd->int_IdProducto );

                    #Voy a descargar la cantidad del doc de ventas x el equivalente (frasco = 10, caja = 30 etc.)
                    $cant_proc      = ( $det_salida );//* $equiv 
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    $tipoMov        = 'E';
                    $saldo_act      = $det_saldo - $cant_proc;
                    $concepto       = 'Egreso por anular Parte Entrada';
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    #return 'saldo actual: '.$equiv;
                    
                    $det_idProd     = $rd->int_IdProducto;
                    $det_NombProd   = $rd->prod;
                    $det_unidadMedi = $rd->um;
                    #Ahora inserto el kardex.
                    #
                    $precioVenta    = 0;
                    $precioCompra   = 0;
                    $utilidad       = 0;
                    $id_Unid        = '';
                    $k = array();
                    $precioVenta    = $rd->ftl_Precio_Venta;
                    $precioCompra   = $rd->flt_Precio_Compra;
                    $utilidad       = $rd->flt_Utilidad;
                    $id_Unid        = $rd->idum;
                    $idLote         = $rd->int_IdLote;
                    $lote           = $rd->lote;
                    #
                    $k["dt_Fecha"]          = MySQL::SQLValue( $enc_fecha , MySQL::SQLVALUE_DATETIME );
                    $k["chr_Concepto"]      = MySQL::SQLValue( $tipoMov , MySQL::SQLVALUE_TEXT );
                    $k["var_Descri"]        = MySQL::SQLValue( $concepto , MySQL::SQLVALUE_TEXT );
                    $k["chr_TipoDoc"]       = MySQL::SQLValue( $enc_tipodoc , MySQL::SQLVALUE_TEXT );
                    $k["var_NumeroDoc"]     = MySQL::SQLValue( $enc_numdoc , MySQL::SQLVALUE_TEXT );
                    $k["var_Cliente"]       = MySQL::SQLValue( $enc_cliente , MySQL::SQLVALUE_TEXT );
                    $k["int_Salida"]        = MySQL::SQLValue( $cant_proc , MySQL::SQLVALUE_NUMBER );
                    $k["int_Saldo"]         = MySQL::SQLValue( $saldo_act , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdProducto"]    = MySQL::SQLValue( $det_idProd , MySQL::SQLVALUE_NUMBER );
                    $k["var_NombreProducto"]= MySQL::SQLValue( $det_NombProd.' Lote: '.$lote , MySQL::SQLVALUE_TEXT );
                    $k["var_UnidadMedida"]  = MySQL::SQLValue( $det_unidadMedi , MySQL::SQLVALUE_TEXT ); 
                    $k["var_Mascara"]       = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
                    #
                    $lasIdKardex = $this->InsertRow( 'utb_kardex_actual' , $k );

                    #Actualizar Stock en tabla productos.
                    /*06 07 15, desactivo esto por que el stock se maneja por lotes.*/
                    $this->update_stock_producto( $det_idProd , $saldo_act  );
                    /*Actualizar ID Lote, para anular si es necesario*/
                    $k = array();
                    $p = array();
                    $k["chr_Estado"]   = MySQL::SQLValue( 'DEL' , MySQL::SQLVALUE_TEXT );
                    $p["int_IdLote"]   = MySQL::SQLValue( $idLote , MySQL::SQLVALUE_NUMBER );
                    $this->UpdateRows( 'utb_producto_lote' , $k , $p );

                    #Precios de productos, ya que el parte de entrada afecta al precio de los productos.
                    $OBJP = array();
                    $OBJP = new Usuario();
                    $arr_old_Data = array();
                    $tex_data = '';
                    $t = '';

                    $tex_data = $this->get_old_precio_producto( $enc_numdoc );
                    #compra, venta, utilidad

                    if( $tex_data != '' ){
                        $arr_old_Data = explode(',', $tex_data );
                        $OBJP->set_Valor( $arr_old_Data[0] , 'flt_old_Precio_Compra' );
                        $OBJP->set_Valor( $arr_old_Data[1] , 'ftl_old_Precio_Venta' );
                        $OBJP->set_Valor( $arr_old_Data[2] , 'flt_old_Utilidad' );
                        $OBJP->set_Valor( 'PE' , 'char_TipoDoc' );
                        $OBJP->set_Valor( $enc_numdoc , 'var_Doc' );
                    }

                    $OBJP->set_Valor( $det_idProd , 'int_IdProducto' );
                    $OBJP->set_Valor( $id_Unid , 'int_IdUM' );
                    $OBJP->set_Valor( '2' , 'int_TipoCalculo' );
                    #
                    $OBJP->set_Valor( $precioCompra , 'flt_Precio_Compra' );
                    $OBJP->set_Valor( $precioVenta , 'ftl_Precio_Venta' );
                    $OBJP->set_Valor( $utilidad , 'flt_Utilidad' );
                    $OBJP->set_Valor( $concepto , 'var_Descri' );

                    #Anulando productos anteriores.
                    $OBJP->anular_precios_producto( $det_idProd );

                    #Guardando Precio Producto
                    $OBJP->insert_Precio_Producto();

                    #Ahora actualizo las promociones amarradas a este producto.
                    #$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
                    #$OBJP->update_precio_promo_prod( $det_idProd );

                }
            }
            return $lasIdKardex;

        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function aumentar_kardex_from_pe( $idDoc ){
        /*
        Esta funcion va a aumentar el detalle de un documento Parte de entrada al kardex y aumentar el respectivo stock
        */
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $enc_fecha      = '';
        $enc_tipodoc    = '';
        $enc_numdoc     = '';
        $enc_cliente    = '';
        $mascara        = '';
        #
        $sql = " SELECT * FROM `utb_parte_entrada` v INNER JOIN `utb_clientes` c ON c.`int_IdCliente` = v.`int_IdProveedor` AND v.`int_IdParteEntrada` = ".$idDoc;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            
            #Obtener los encabezados del Documento
            foreach ( $data as $key => $rs ) {
                $enc_fecha      = $rs->dt_Fecha;
                $enc_tipodoc    = 'PE';
                $enc_numdoc     = $rs->int_IdParteEntrada;
                $enc_cliente    = $rs->var_Nombre;
                $mascara        = 'Parte Entrada '.sprintf("%05s", $enc_numdoc );
            }

            #Obtener los detalles del Documento
            $sql = " SELECT *, d.int_Cantidad as 'cant', p.var_Nombre as 'prod', um.var_Nombre as 'um', d.int_IdUnidadMedida as 'idum', d.`var_Lote` as 'lote', d.`var_Laboratorio` as 'lab', d.`dt_Vencimiento` as 'fecha' FROM `utb_parte_entrada_detalle` d INNER JOIN `utb_productos` p ON d.`int_IdProducto` = p.`int_IdProducto` 
            INNER JOIN `utb_unidad_medida` um on um.int_IdUM = d.int_IdUnidadMedida AND d.`int_IdParteEntrada` = ".$idDoc;
            $data = $this->QueryArray( $sql , MYSQL_ASSOC );

            $lasIdKardex = 0;

            if( is_array($data) ){
                foreach ($data as $key => $rd) {

                    $tipoMov = '';
                    $equiv          = 0;#(int)$this->get_equivalencia_un_producto( $rd["int_IdProducto"] , $rd["idum"] );
                    $cant_proc      = 0;
                    $saldo_act      = 0;

                    $det_entrada    = (int)$rd->cant;
                    $det_saldo      = (int)$this->get_saldo_producto( $rd->int_IdProducto );

                    #Voy a descargar la cantidad del doc de ventas x el equivalente (frasco = 10, caja = 30 etc.)
                    $cant_proc      = ( $det_entrada );//* $equiv 
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    $tipoMov        = 'I';
                    $saldo_act      = $det_saldo + $cant_proc;
                    $concepto       = 'Ingreso por Parte Entrada';
                    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
                    #return 'saldo actual: '.$equiv;
                    $det_idProd     = $rd->int_IdProducto;
                    $det_NombProd   = $rd->prod;
                    $det_unidadMedi = $rd->um;
                    #
                    $precioVenta    = 0;
                    $precioCompra   = 0;
                    $utilidad       = 0;
                    $id_Unid        = '';
                    #Ahora inserto el kardex.
                    
                    $precioVenta    = $rd->ftl_Precio_Venta;
                    $precioCompra   = $rd->flt_Precio_Compra;
                    $utilidad       = $rd->flt_Utilidad;
                    $id_Unid        = $rd->idum;
                    #Creando el Lote del producto
                    $stock_lote     = 0;
                    $new_stock_L    = 0;
                    $idLote         = 0;
                    $lote           = $rd->lote;
                    $stock_lote     = $this->stock_lote_producto( $det_idProd , $lote );
                    $new_stock_L    = $stock_lote + $det_entrada;
                    $lab            = $rd->lab;
                    $fecha          = $rd->fecha;
                    $idLote = $this->crear_lote_prod( $det_idProd , $lote , $fecha , $lab , $new_stock_L );
                    #
                    $k = array();
                    $k["dt_Fecha"]          = MySQL::SQLValue( $enc_fecha , MySQL::SQLVALUE_DATETIME );
                    $k["chr_Concepto"]      = MySQL::SQLValue( $tipoMov , MySQL::SQLVALUE_TEXT );
                    $k["var_Descri"]        = MySQL::SQLValue( $concepto , MySQL::SQLVALUE_TEXT );
                    $k["chr_TipoDoc"]       = MySQL::SQLValue( $enc_tipodoc , MySQL::SQLVALUE_TEXT );
                    $k["var_NumeroDoc"]     = MySQL::SQLValue( $enc_numdoc , MySQL::SQLVALUE_TEXT );
                    $k["var_Cliente"]       = MySQL::SQLValue( $enc_cliente , MySQL::SQLVALUE_TEXT );
                    $k["int_Entrada"]       = MySQL::SQLValue( $cant_proc , MySQL::SQLVALUE_NUMBER );
                    $k["int_Saldo"]         = MySQL::SQLValue( $saldo_act , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdProducto"]    = MySQL::SQLValue( $det_idProd , MySQL::SQLVALUE_NUMBER );
                    $k["int_IdLote"]        = MySQL::SQLValue( $idLote , MySQL::SQLVALUE_NUMBER );
                    $k["var_NombreProducto"]= MySQL::SQLValue( $det_NombProd.' Lote: '.$lote , MySQL::SQLVALUE_TEXT );
                    $k["var_UnidadMedida"]  = MySQL::SQLValue( $det_unidadMedi , MySQL::SQLVALUE_TEXT );
                    $k["var_Mascara"]       = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
                    #
                    $lasIdKardex = $this->InsertRow( 'utb_kardex_actual' , $k );
                    unset($k);
                    
                    #Actualizar Stock en tabla productos.
                    $k = array();
                    $p = array();
                    /*06 07 15, desactivo esto por que el stock se maneja por lotes.*/
                    $this->update_stock_producto( $det_idProd , $saldo_act  );
                    /*Actualizar ID Lote, para anular si es necesario*/
                    $k["int_IdLote"]         = MySQL::SQLValue( $idLote , MySQL::SQLVALUE_NUMBER );
                    $p["int_IdDetallePE"]    = MySQL::SQLValue( $rd->int_IdDetallePE , MySQL::SQLVALUE_NUMBER );
                    $this->UpdateRows( 'utb_parte_entrada_detalle' , $k , $p );

                    #Precios de productos, ya que el parte de entrada afecta al precio de los productos.
                    $OBJP = array();
                    $OBJP = new Usuario();
                    $arr_old_Data = array();
                    $tex_data = array();
                    $t = '';

                    $tex_data = $this->get_data_un_producto( " AND p.int_IdProducto = ".$det_idProd );
                    if( is_array($tex_data) ){
                        foreach ($tex_data as $key => $rsx) {
                            $t = $rsx->data;
                        }
                        
                        $arr_old_Data = explode("|", $t );
                        $OBJP->set_Valor( $arr_old_Data[2] , 'flt_old_Precio_Compra' );
                        $OBJP->set_Valor( $arr_old_Data[1] , 'ftl_old_Precio_Venta' );
                        $OBJP->set_Valor( $arr_old_Data[4] , 'flt_old_Utilidad' );
                        $OBJP->set_Valor( 'PE' , 'char_TipoDoc' );
                        $OBJP->set_Valor( $enc_numdoc , 'var_Doc' );
                    }

                    $OBJP->set_Valor( $det_idProd , 'int_IdProducto' );
                    $OBJP->set_Valor( $id_Unid , 'int_IdUM' );
                    $OBJP->set_Valor( '2' , 'int_TipoCalculo' );
                    #
                    $OBJP->set_Valor( $precioCompra , 'flt_Precio_Compra' );
                    $OBJP->set_Valor( $precioVenta , 'ftl_Precio_Venta' );
                    $OBJP->set_Valor( $utilidad , 'flt_Utilidad' );
                    $OBJP->set_Valor( $concepto , 'var_Descri' );

                    #Anulando productos anteriores.
                    $OBJP->anular_precios_producto( $det_idProd );

                    #Guardando Precio Producto
                    $OBJP->insert_Precio_Producto();
                    /*

                    #Ahora actualizo las promociones amarradas a este producto.
                    #$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
                    $OBJP->update_precio_promo_prod( $det_idProd );
                    /**/
                }/* END FOREACH */
            }
            return $lasIdKardex;

        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function update_detalle_pe_for_promos( $idpe ){
        #Vamos a actualizar el precio de las promociones en base a aun PE ya cerrado.
        #Lo estoy separando del proceso normal de parte de entrada ya que al parecer este lo sobrecarga.
        $sql = '';
        $data = array();
        #
        $sql =  " SELECT * FROM `utb_parte_entrada_detalle` WHERE int_IdParteEntrada = ".$idpe;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array( $data ) ){
            foreach ($data as $key => $rs) {
                #Ahora actualizo las promociones amarradas a este producto.
                #$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
                $this->update_precio_promo_prod( $rs->int_IdProducto );
            }
        }
    }
    /* -------------------------------------------------------------------- */
    public function delete_detalle_pe(){
        $this->DeleteRows( 'utb_parte_entrada_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_estado_doc( $idDOC , $tipoDoc ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        switch ($tipoDoc){
            case 'PE':
                $sql = " SELECT `chr_Estado` as 'estado' FROM `utb_parte_entrada` WHERE `int_IdParteEntrada` = ".$idDOC;
                break;
            case 'V':
                $sql = " SELECT `chr_Estado` as 'estado' FROM `utb_venta` WHERE `int_idVenta` = ".$idDOC;
                break;
        }
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array( $data ) ){
            foreach ($data as $key => $rs) {
                return $rs->estado;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function update_ventas(){
        return $this->UpdateRows( 'utb_venta' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function insert_ventas(){
        return $this->InsertRow( 'utb_venta' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_detalle_venta(){
        $this->UpdateRows( 'utb_venta_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_detalle_venta(){
        $this->InsertRow( 'utb_venta_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function delete_detalle_venta(){
        $this->DeleteRows( 'utb_venta_detalle' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function join_venta_detalle(){
        $this->UpdateRows( 'utb_venta_detalle' , $this->dataQ , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_caja(){
        return $this->UpdateRows( 'utb_caja_ventas' , $this->campos , $this->union );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_caja(){
        return $this->InsertRow( 'utb_caja_ventas' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_listado_caja( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(v.`dt_Fecha`,'%d/%m/%Y') as 'fecha', u.`var_Nombre` as 'usuario', v.`chr_Estado` as 'estado_venta', c.`chr_Estado` as 'estado_caja', c.`ts_Registro` as 'fecha_caja'
        FROM `utb_caja_ventas` c INNER JOIN `utb_venta` v ON v.`int_IdVenta` = c.`int_IdVenta`
        INNER JOIN `utb_usuarios` u ON u.`int_IdUsuario` = c.`int_IdUsuario` ".$filtro." ORDER BY v.int_IdVenta DESC ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return $sql;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_usuarios_lista( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_usuarios` WHERE int_IdUsuario > 0 ".$filtro." ORDER BY int_IdUsuario DESC ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_usuario( $idUsuario ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_usuarios` WHERE int_IdUsuario = ".$idUsuario;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function insert_usuario(){
        return $this->InsertRow( 'utb_usuarios' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_usuario(){
        return $this->UpdateRows( 'utb_usuarios' , $this->dataQ , $this->unionQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function login_usuario( $user , $clave ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $clave_sha = sha1($clave);
        #
        $sql = " SELECT * FROM `utb_usuarios` WHERE var_Usuario = '".$user."' AND txt_Clave ='".$clave_sha."' AND chr_Estado = 'ACT' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return $sql;
        }
    }
    /* -------------------------------------------------------------------- */
    public function count_pedidos( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_pedido` ".$filtro;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $this->RowCount();
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function count_facturas( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_venta` WHERE `cht_TipoDoc` = 'F' ".$filtro;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $this->RowCount();
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function count_boletas( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_venta` WHERE `cht_TipoDoc` = 'B' ".$filtro;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $this->RowCount();
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function insert_promocion(){
        return $this->InsertRow( 'utb_promociones' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_producto_promocion(){
        return $this->InsertRow( 'utb_promociones_productos' , $this->campos );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function update_precio_promo_prod( $idprod ){
        /*
        Vamos a actualizar el precio de un producto, y a actualizar las promociones amarradas a el
        */
        $sql        = '';
        $sql1       = '';
        $data       = array();
        $data1      = array();
        $response   = array();
        $diaActual  = date("N");
        $ar_Precio  = array();
        $ar_Precio  = explode( ',' , $this->get_precio_producto1( $idprod ) );
        #Primero busco las promociones activas, primero las permanentes con estado ACT
        $sql = " SELECT * FROM `utb_promociones` WHERE `var_Tiempo` = 'Permanente' AND `chr_Estado` = 'ACT' AND var_Dias like '%".$diaActual."%'; ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            #ahora vamos a busar el producto dentro de los precios promo.
            foreach ($data as $key => $rsp) {
                $idPromo = 0;
                $idPromo = $rsp->int_IdPromocion;
                $this->set_precio_promo( $idPromo , $idprod , $ar_Precio[0] );
            }
        }

        $hoy = date("Y-m-d H:i:s");
        #Todas las promos que aun estan activas.
        $sql = " SELECT * FROM `utb_promociones` WHERE `dt_Hasta` >= '".$hoy."' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        if( is_array($data) ){
            #ahora vamos a busar el producto dentro de los precios promo.
            foreach ($data as $key => $rsp) {
                $idPromo = 0;
                $idPromo = $rsp->int_IdPromocion;
                $this->set_precio_promo( $idPromo , $idprod , $ar_Precio[0] );
            }
        }
        return 'Bis Morgen';
    }
    /* -------------------------------------------------------------------- */
    public function set_precio_promo( $idPromo , $idProd , $precioProd ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_promociones_productos` WHERE `int_IdPromo` = ".$idPromo." AND `int_IdProducto` = ".$idProd." AND `chr_Estado` = 'ACT' ";
        $data1 = $this->QueryArray( $sql , MYSQL_ASSOC );
        foreach ($data1 as $key => $pp) {
            $idDetalle  = $pp->int_IdAuto;
            $precio     = $precioProd;
            $promo      = 0;
            $pre        = 0;
            if( $pp->var_Aplicar == 'Porcentaje' ){
                $pre = ( $precio * $pp->flt_Valor ) / 100;
                $promo = $precio - $pre;
            }else{
                $promo = $pp->flt_Valor;
            }
            $sql = " UPDATE `utb_promociones_productos` SET flt_Precio = ".$precioProd.", flt_Promo = ".$promo." WHERE int_IdAuto = ".$idDetalle;
            $this->Query( $sql );
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_clases_for_prods( $idClase ){
        /*
        Devolvera todos los productos que contienen esa clase.
        */
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT *, p.`int_IdProducto` as 'idp' FROM `utb_clases_in_producto` c INNER JOIN `utb_productos` p ON p.`int_IdProducto` = c.`int_IdProducto` AND c.`int_IdClase` = ".$idClase;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function prod_in_promo( $idProd ){
        #El producto está en promoción?
        $llave  = '';
        $rand   = '';
        $rand   = '?v='.rand(0,9999999);
        $llave  = date('d-m-y H-i-s').'-'.$rand;
        $llave  = sha1($llave);
        $sql    = '';
        $data   = array();
        $datap  = array();
        $response = array();
        $diaActual  = date("N");
        $ar_Precio  = array();
        $ar_Precio  = explode( ',' , $this->get_precio_producto1( $idProd ) );
        
        $ar_Prods   = array();
        #Primero busco las promociones activas, primero las PERMANENTES con estado ACT
        $sql = " SELECT * FROM `utb_promociones` WHERE `var_Tiempo` = 'Permanente' AND `chr_Estado` = 'ACT' AND var_Dias like '%".$diaActual."%'; ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        #
        if( is_array($data) ){
            #ahora vamos a busar el producto dentro de los precios promo.
            foreach ($data as $key => $rsp) {
                $idPromo = 0;
                $NombrePromo = '';
                $idPromo        = $rsp->int_IdPromocion;
                $NombrePromo    = $rsp->var_Nombre;
                #
                $sql = " SELECT * FROM `utb_promociones_productos` WHERE `int_IdPromo` = ".$idPromo." AND `int_IdProducto` = ".$idProd." AND `chr_Estado` = 'ACT' ";
                $datap = $this->QueryArray( $sql , MYSQL_ASSOC );
                if( is_array($datap) ){
                    foreach ($datap as $key => $rst) {
                        #guardo la promo en una tabla temporal para luego decidir que precio conviene al cliente.
                        $this->insert_prefetch_prod( $llave, $idPromo, $NombrePromo, $rst->flt_Precio, $rst->flt_Promo );
                    }
                    unset($rst);
                }
            }
        }
        #/ Fin busqueda de promos PERMANENTES

        #Busqueda en todas las promociones de RANGO de fecha.
        $hoy = date("Y-m-d H:i:s");
        $sql = " SELECT * FROM `utb_promociones` WHERE `dt_Hasta` >= '".$hoy."' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            #ahora vamos a busar el producto dentro de los precios promo.
            foreach ($data as $key => $rsp) {
                $idPromo = 0;
                $NombrePromo = '';
                $idPromo        = $rsp->int_IdPromocion;
                $NombrePromo    = $rsp->var_Nombre;
                #
                $sql = " SELECT * FROM `utb_promociones_productos` WHERE `int_IdPromo` = ".$idPromo." AND `int_IdProducto` = ".$idProd." AND `chr_Estado` = 'ACT' ";
                $datap = $this->QueryArray( $sql , MYSQL_ASSOC );
                if( is_array($datap) ){
                    foreach ($datap as $key => $rst) {
                        #guardo la promo en una tabla temporal para luego decidir que precio conviene al cliente.
                        $this->insert_prefetch_prod( $llave, $idPromo, $NombrePromo, $rst->flt_Precio, $rst->flt_Promo );
                    }
                    unset($rsp);
                }
            }
        }
        #fin busqueda por RANGO

        #Ahora busco la promo con el precio mas bajo.
        $sql = " SELECT * FROM `utb_promo_fetch` WHERE `txt_Key` = '".$llave."' ORDER BY `flt_Promo` LIMIT 1 ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            #Borro esa tmp.
            $sql = " DELETE FROM utb_promo_fetch WHERE txt_Key = '".$llave."' ";
            $this->Query($sql);
            return $data;
        }else{
            return 0;
        }
        #
    }
    /* -------------------------------------------------------------------- */
    public function insert_prefetch_prod( $llave, $idPromo, $NombrePromo, $precio, $promo ){
        $k = array();
        $k["txt_Key"]       = MySQL::SQLValue( $llave , MySQL::SQLVALUE_TEXT );
        $k["int_IdPromo"]   = MySQL::SQLValue( $idPromo , MySQL::SQLVALUE_TEXT );
        $k["var_Promo"]     = MySQL::SQLValue( $NombrePromo , MySQL::SQLVALUE_TEXT );
        $k["flt_Precio"]    = MySQL::SQLValue( $precio , MySQL::SQLVALUE_TEXT );
        $k["flt_Promo"]     = MySQL::SQLValue( $promo , MySQL::SQLVALUE_TEXT );
        $this->InsertRow( 'utb_promo_fetch' , $k );
        $this->getLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_productos_in_promo( $idPromo ){
        #devolvera los productos dentro de un Id de Promocion
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, p.`var_Nombre` as 'prod', u.`var_Nombre` as 'um', prom.`flt_Precio` as 'prec', prom.`flt_Promo` as 'prom' FROM `utb_promociones_productos` prom INNER JOIN 
        `utb_productos` p ON p.`int_IdProducto` = prom.`int_IdProducto` INNER JOIN 
        `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` AND `int_IdPromo` = ".$idPromo;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if(is_array($data)){
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_promo_listado( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(ts_Registro,'%d/%m/%Y') as 'fecha' FROM `utb_promociones` ".$filtro." ORDER BY int_IdPromocion DESC ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function update_promocion(){
        $this->UpdateRows( 'utb_promociones' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function update_detalle_promocion(){
        $this->UpdateRows( 'utb_promociones_productos' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function get_data_promo( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT *, DATE_FORMAT(ts_Registro,'%d/%m/%Y') as 'fecha', DATE_FORMAT(dt_Desde,'%d/%m/%Y %H:%i') as 'desde', DATE_FORMAT(dt_Hasta,'%d/%m/%Y %H:%i') as 'hasta' FROM `utb_promociones` WHERE int_IdPromocion = ".$filtro;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_promos_hoy(){
        #El producto está en promoción?
        $llave  = '';
        $rand   = '';
        $rand   = '?v='.rand(0,9999999);
        $llave  = date('d-m-y H-i-s').'-'.$rand;
        $llave  = sha1($llave);
        $sql    = '';
        $data   = array();
        $datap  = array();
        $response = array();
        $diaActual  = date("N");
        
        $ar_Prods   = array();
        #Primero busco las promociones activas, primero las PERMANENTES con estado ACT
        $sql = " SELECT * FROM `utb_promociones` WHERE `var_Tiempo` = 'Permanente' AND `chr_Estado` = 'ACT' AND var_Dias like '%".$diaActual."%'; ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        #
        if( is_array($data) ){
            #ahora vamos a busar el producto dentro de los precios promo.
            foreach ($data as $key => $rsp) {
                $idPromo = 0;
                $NombrePromo = '';
                $idPromo        = $rsp->int_IdPromocion;
                $NombrePromo    = $rsp->var_Nombre;
                $Mascara        = $rsp->var_Mascara;
                $o = array();
                $o['idPromo']   = $idPromo;
                $o["Nombre"]    = $NombrePromo;
                $o["Mascara"]   = $Mascara;
                array_push( $response , $o );
                #
            }
        }
        #/ Fin busqueda de promos PERMANENTES

        #Busqueda en todas las promociones de RANGO de fecha.
        $hoy = date("Y-m-d H:i:s");
        $sql = " SELECT * FROM `utb_promociones` WHERE `dt_Hasta` >= '".$hoy."' AND `chr_Estado` = 'ACT' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            #ahora vamos a busar el producto dentro de los precios promo.
            foreach ($data as $key => $rsp) {
                $idPromo = 0;
                $NombrePromo = '';
                $idPromo        = $rsp->int_IdPromocion;
                $NombrePromo    = $rsp->var_Nombre;
                $Mascara        = $rsp->var_Mascara;
                $o = array();
                $o['idPromo']   = $idPromo;
                $o["Nombre"]    = $NombrePromo;
                $o["Mascara"]   = $Mascara;
                array_push( $response , $o );
                #
            }
        }
        #fin busqueda por RANGO

        return $response;
    }
    /* -------------------------------------------------------------------- */
    public function get_ventas_usuario( $idUsuario ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT d.`int_Cantidad` as 'cant', d.`flt_Precio` as 'precio', d.`flt_Total` as 'tota', v.`cht_TipoDoc` as 'tipo',
        d.`int_IdPromo` as 'idpromo', d.`var_Promo` as 'promo', d.`flt_Promo` as 'precpromo', v.`int_idVenta` as 'idv', 
        v.`var_Mascara` as 'mascara', v.`dt_Fecha` as 'fecha', v.`ts_Registro` as 'registro', p.`var_Nombre` as 'producto' 
        FROM `utb_venta_detalle` d INNER JOIN `utb_venta` v ON v.`int_IdVenta` = d.`int_IdVenta` 
        INNER JOIN `utb_productos` p ON p.`int_IdProducto` = d.`int_IdProducto` AND v.`int_IdUsuario` = ".$idUsuario." AND 
        v.`chr_Estado` = 'CER' AND v.`cht_TipoDoc` <> 'R' ORDER BY d.`int_Cantidad`,v.`int_idVenta` ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function copiar_venta( $IdaCopiar , $idu ){
        $sql = '';
        $response = '';
        $data = array();
        $NuevoPedido = 0;
        $o = array();

        #Datos de la cabecera
        $sql = " SELECT `cht_TipoDoc`, `int_IdCliente`, `dt_Fecha`, `flt_Total`, `var_Dir`, `var_Mascara`, `int_IdUsuario`, `int_Serie`, `int_Correlativo` FROM `utb_venta` WHERE `int_idVenta` = ".$IdaCopiar;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );

        $data_corr = 0;
        $mascara = '';
        $tipoDoc = '';

        if( is_array($data) ){
            foreach ($data as $key => $p) {
                
                $data_corr  = $this->get_max_correlativo( $p->cht_TipoDoc ) + 1;
                switch ( $p->cht_TipoDoc ) {
                    case 'B':
                        $mascara    = 'Boleta '.sprintf("%05s", $data_corr );
                        break;
                    case 'F':
                        $mascara    = 'Factura 001-'.sprintf("%05s", $data_corr );
                        break;
                    case 'R':
                        $mascara    = 'Recibo '.sprintf("%05s", $data_corr );
                        break;
                }
                

                $o["cht_TipoDoc"]       = MySQL::SQLValue( $p->cht_TipoDoc , MySQL::SQLVALUE_TEXT );
                $o["int_IdCliente"]     = MySQL::SQLValue( $p->int_IdCliente , MySQL::SQLVALUE_NUMBER );
                $o["dt_Fecha"]          = MySQL::SQLValue( $p->dt_Fecha , MySQL::SQLVALUE_DATETIME );

                $o["flt_Total"]         = MySQL::SQLValue( $p->flt_Total , MySQL::SQLVALUE_TEXT );
                $o["var_Dir"]           = MySQL::SQLValue( $p->var_Dir , MySQL::SQLVALUE_TEXT );
                $o["var_Mascara"]       = MySQL::SQLValue( $mascara , MySQL::SQLVALUE_TEXT );
                $o["int_IdUsuario"]     = MySQL::SQLValue( $idu , MySQL::SQLVALUE_NUMBER );
                $o["int_Serie"]         = MySQL::SQLValue( '001' , MySQL::SQLVALUE_NUMBER );
                $o["int_Correlativo"]   = MySQL::SQLValue( $data_corr , MySQL::SQLVALUE_NUMBER );
                
                $this->InsertRow( 'utb_venta' , $o );
                $nuevaVenta = $this->GetLastInsertID();
            }
        }

        $sql = " INSERT INTO utb_venta_detalle( `int_IdVenta`, `int_IdProducto`, `int_IdUnidadMedida`, `int_Cantidad`, `flt_Precio`, `flt_Total`, `int_IdUsuario`, `int_IdPromo`, `var_Promo`, `flt_Promo`) SELECT ".$nuevaVenta.", `int_IdProducto`, `int_IdUnidadMedida`, `int_Cantidad`, `flt_Precio`, `flt_Total`, ".$idu.", `int_IdPromo`, `var_Promo`, `flt_Promo` FROM `utb_venta_detalle` WHERE `int_IdVenta` = ".$IdaCopiar;
        $this->Query( $sql );
        return $nuevaVenta;
    }
    /* -------------------------------------------------------------------- */
    public function insert_cierre_caja( $idu, $monto ){
        $k = array();
        $k["chr_Accion"]        = MySQL::SQLValue( 'C' , MySQL::SQLVALUE_TEXT );
        $k["flt_Cierre"]        = MySQL::SQLValue( $monto , MySQL::SQLVALUE_TEXT );
        $k["int_IdUsuario"]     = MySQL::SQLValue( $idu , MySQL::SQLVALUE_TEXT );
        return $this->InsertRow( 'utb_caja_ventas' , $k );
        $this->getLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_apertura_caja( $idu, $monto ){
        $k = array();
        $k["chr_Accion"]        = MySQL::SQLValue( 'A' , MySQL::SQLVALUE_TEXT );
        $k["flt_Caja"]          = MySQL::SQLValue( $monto , MySQL::SQLVALUE_TEXT );
        $k["int_IdUsuario"]     = MySQL::SQLValue( $idu , MySQL::SQLVALUE_TEXT );
        return $this->InsertRow( 'utb_caja_ventas' , $k );
        $this->getLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function get_estados_caja( $fecha = 'CURRENT_DATE()' ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_caja_ventas` WHERE `chr_Accion` <> 'M' AND DATE(`ts_Registro`) = ".$fecha;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_all_almacenes( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT * FROM `utb_almacenes` ".$filtro." ORDER BY var_Nombre ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function update_Almacen(){
        $this->UpdateRows( 'utb_almacenes' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function insert_Almacen(){
        return $this->InsertRow( 'utb_almacenes' , $this->dataQ );
        #return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function existe_Almacen( $nombre ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT `int_IdAlmacen` as 'id' FROM `utb_almacenes` WHERE `var_Nombre` = '".$nombre."' ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $u) {
                return $u->id;
            }
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_producto_almacenes( $idProducto ){
        $sql = '';
        $data = array();
        $response = array();
        #
        $sql = " SELECT a.int_IdAlmacen as 'id', a.var_Nombre as 'name' FROM `utb_almacen_producto` ap INNER JOIN `utb_almacenes` a ON 
        ap.`int_IdAlmacen` = a.`int_IdAlmacen` AND ap.`int_IdProducto` = ".$idProducto;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            $response['json'] = json_encode( $data );
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function delete_almacenes_in_producto(){
        $this->DeleteRows( 'utb_almacen_producto' , $this->unionQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function insert_almacen_in_producto(){
        $this->InsertRow( 'utb_almacen_producto' , $this->dataQ );
        return $this->GetLastSQL();
    }
    /* -------------------------------------------------------------------- */
    public function existe_producto( $nombre ){
        #En base al RUC
        $sql = '';
        $data = array();
        $response = array();
        $sql = " SELECT `int_IdProducto` as 'id' FROM `utb_productos` WHERE `var_Nombre` = '".trim($nombre)."' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $u) {
                return $u->id;
            }
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_count_productos(){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT count(int_IdProducto) as 'n' FROM `utb_productos` ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->n;
            }
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_productos_clase( $idclase ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT * FROM `utb_clases_in_producto` cp INNER JOIN `utb_productos` p ON p.`int_IdProducto` = cp.`int_IdProducto` AND cp.`int_IdClase` = ".$idClase;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $data;
            }
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_productos_almacen( $idAlmacen ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT * FROM `utb_almacen_producto` ap INNER JOIN `utb_productos` p ON p.`int_IdProducto` = ap.`int_IdProducto` AND ap.`int_IdAlmacen` = ".$idAlmacen;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $data;
            }
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function update_cant_detinv(){
        $this->UpdateRows( 'utb_inventario_detalle' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
    public function get_productos_01(){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT * FROM `utb_productos` ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $data;
            }
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_lotes_producto( $idProducto ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT l.`var_Lote` as 'lote', DATE_FORMAT(l.`dt_Vencimiento`,'%d/%m/%Y') as 'vence', l.`int_Stock` as 'stock' FROM `utb_productos` p INNER JOIN utb_producto_lote l ON l.`int_IdProducto` = p.`int_IdProducto` AND p.`int_IdProducto` = ".$idProducto;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']    = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* ------------------------------------------------------------------------ */
    public function crear_lote_prod( $idprod , $lote , $vence , $lab , $stock ){
        $o = array();
        #
        $o["int_IdProducto"]    = MySQL::SQLValue( $idprod , MySQL::SQLVALUE_NUMBER );
        $o["var_Lote"]          = MySQL::SQLValue( $lote , MySQL::SQLVALUE_TEXT );
        $o["dt_Vencimiento"]    = MySQL::SQLValue( $vence , MySQL::SQLVALUE_TEXT );
        $o["var_Laboratorio"]   = MySQL::SQLValue( $lab , MySQL::SQLVALUE_TEXT );
        $o["int_Stock"]         = MySQL::SQLValue( $stock , MySQL::SQLVALUE_NUMBER );
        #
        return $this->InsertRow( 'utb_producto_lote' , $o );
        #return $this->GetLastSQL();

    }
    /* -------------------------------------------------------------------- */
    public function stock_lote_producto( $idprod , $lote ){
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT `int_Stock` as 'n' FROM `utb_producto_lote` WHERE `int_IdProducto` = ".$idprod." AND `var_Lote` = '".$lote."' ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->n;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function anular_lote_producto( $idLote ){
        $this->UpdateRows( 'utb_precio_producto' , $this->campos , $this->union );
    }
    /* -------------------------------------------------------------------- */
     public function get_productos_venta_by_lotes( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        $sql = "SELECT *, u.var_Nombre as 'textum', p.var_Nombre as 'prod', p.int_IdProducto as 'idp', p.`int_IdUM` as 'idum', lt.`var_Lote` as 'lote', lt.`var_Laboratorio` as 'lab', DATE_FORMAT(lt.`dt_Vencimiento`,'%d/%m/%Y') as 'fecha', lt.int_Stock as 'stock', lt.int_IdLote as 'idlote'
        FROM `utb_productos` p INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` 
        INNER JOIN `utb_precio_producto` pr ON pr.`int_IdProducto` = p.`int_IdProducto` AND pr.`chr_Estado` = 'ACT' INNER JOIN `utb_producto_lote` lt ON lt.`int_IdProducto` = pr.`int_IdProducto` AND lt.`chr_Estado` = 'ACT'
         ".$filtro." ORDER BY  lt.`dt_Vencimiento` ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            $response['n']      = $this->RowCount();

            foreach ($data as $key => $rsp ) {
                $o =  array();
                $m = '';
                $pr = array();
                # id | precio venta | precio compra | unidad medida | utilidad
                
                $o["id"]        = $rsp->idp;
                $o["idum"]      = $rsp->idum;
                $o["label"]     = $rsp->prod;
                if( $rsp->chr_Destacado == 0 ){
                    $o['ico'] = 'nodestacado';
                }else{
                    $o['ico'] = 'destcado';
                }
                $o["prec"]      = $rsp->ftl_Precio_Venta;
                $o["comp"]      = $rsp->flt_Precio_Compra;
                $o["textum"]    = $rsp->textum;
                $o["stock"]     = $rsp->stock;
                $o["lote"]      = $rsp->lote;
                $o["fecha"]     = $rsp->fecha;
                
                /*
                Arreglo usando en la version 2.0
                */
                $fecha = '';
                if( $rsp->fecha != '' ){
                    $fecha = $rsp->fecha;
                }

                $pr[0] = $rsp->prod;
                $pr[1] = $rsp->lote;
                $pr[2] = $rsp->stock;
                $pr[3] = $fecha;
                $pr[4] = $rsp->ftl_Precio_Venta;
                $pr[5] = $rsp->idp;
                $pr[6] = $rsp->idum;
                $pr[7] = $rsp->idlote;

                $m = $rsp->prod;
                array_push( $p , $pr );
            }

            $texto_salida = '';
            $texto_salida = implode(',', $p );

            $response['data'] = $p;
            return $p;

        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_prefetch_prod_lotes( $filtro ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        $sql = "SELECT p.var_Nombre as 'label', p.int_IdProducto as 'id' 
        FROM `utb_productos` p INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` INNER JOIN `utb_precio_producto` pr 
        ON pr.`int_IdProducto` = p.`int_IdProducto` AND pr.`chr_Estado` = 'ACT' INNER JOIN `utb_producto_lote` lt ON lt.`int_IdProducto` = pr.`int_IdProducto` ".$filtro." ORDER BY  p.var_Nombre ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            
            $response['n']      = $this->RowCount();

            foreach ($data as $key => $rsp ) {
                $o =  array();
                $pr = array();
                # id | precio venta | precio compra | unidad medida | utilidad
                
                $o["id"]        = $rsp->id;
                $o["label"]     = $rsp->label;
            }

            $response['data'] = $p;
            return $p;

        }else{
            return '';
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_productos_lotes_lista( $filtro = '', $limit = '' ){
        $sql        = '';
        $data       = array();
        $response   = array();
        $p          = array();
        #
        /*$sql = " SELECT p.`var_Nombre` as 'prod', p.`int_IdProducto` as 'idp', l.`var_Lote` as 'lote', l.`var_Laboratorio` as 'lab', DATE_FORMAT(l.`dt_Vencimiento`,'%d/%m/%Y') as 'fecha', l.`int_Stock` as 'stock', p.`chr_Estado` as 'estado'
        FROM `utb_producto_lote` l INNER JOIN `utb_productos` p ON p.`int_IdProducto` = l.`int_IdLote` 
        INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` AND l.`chr_Estado` = 'ACT' ".$filtro." ORDER BY p.`var_Nombre` ".$limit;*/
        $sql = " SELECT p.`var_Nombre` as 'prod', p.`int_IdProducto` as 'idp', l.`var_Lote` as 'lote', l.`var_Laboratorio` as 'lab', DATE_FORMAT(l.`dt_Vencimiento`,'%d/%m/%Y') as 'fecha', l.`int_Stock` as 'stock', p.`chr_Estado` as 'estado' 
        FROM `utb_productos` p INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.`int_IdUM` INNER JOIN `utb_precio_producto` pr 
        ON pr.`int_IdProducto` = p.`int_IdProducto` AND pr.`chr_Estado` = 'ACT' INNER JOIN `utb_producto_lote` l ON l.`int_IdProducto` = pr.`int_IdProducto` 
        AND l.`chr_Estado` = 'ACT' ".$filtro." ORDER BY p.`var_Nombre` ".$limit;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n']      = $this->RowCount();
            $response['data'] = $data;
            return $response;
            
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_count_productos_lotes(){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT count(p.int_IdProducto) as 'n' FROM `utb_producto_lote` l INNER JOIN `utb_productos` p ON p.`int_IdProducto` = l.`int_IdLote`  ";
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                return $rs->n;
            }
        }else{

            return $sql;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function get_detalle_venta01( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, v.int_Cantidad as 'cant', l.`var_Lote` as 'lote' FROM `utb_venta_detalle` v INNER JOIN `utb_productos` pr ON v.`int_IdProducto` = pr.`int_IdProducto` INNER JOIN `utb_producto_lote` l ON l.`int_IdLote` = v.`int_IdLote` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            //$response['data'] = $data;
            foreach ($data as $key => $rs) {
                $o =  array();
                $o["int_IdDetalleVenta"] = $rs->int_IdDetalleVenta;
                $o["int_IdVenta"]        = $rs->int_IdVenta;
                $o["int_IdProducto"]     = $rs->int_IdProducto;
                $o["int_IdUnidadMedida"] = $rs->int_IdUnidadMedida;
                $o["int_Cantidad"]      = $rs->cant;
                $o["flt_Precio"]        = number_format( $rs->flt_Precio , 2 );
                $o["flt_Total"]         = number_format( $rs->flt_Total , 2 );
                $o["txt_Tag"]           = $rs->txt_Tag;
                $o["ts_Registro"]       = $rs->ts_Registro;
                $o["int_IdClase"]       = $rs->int_IdClase;
                $o["int_IdGenerico"]    = $rs->int_IdGenerico;
                $o["var_Nombre"]        = $rs->var_Nombre;
                $o["txt_Descri"]        = $rs->txt_Descri;
                $o["int_stock"]         = $rs->int_stock;
                $o["var_Lote"]          = $rs->var_Lote;
                $o["dt_Vencimiento"]    = $rs->dt_Vencimiento;
                $o["chr_Estado"]        = $rs->chr_Estado;
                $o["unidadMedida"]      = $this->get_unidad_medida( $rs->int_IdUnidadMedida );
                $o["int_IdPromo"]       = $rs->int_IdPromo;
                $o["var_Promo"]         = $rs->var_Promo;
                $o["flt_Promo"]         = $rs->flt_Promo;
                $o["lote"]              = $rs->lote;
                array_push( $p , $o );
            }
            $response['data'] = $p;
            return $response;
        }else{

            return 0;

        }
    }
    /* ------------------------------------------------------------------------ */
    public function download_lote_producto( $idLote , $saldo  ){
        # vamos a reducir el stock en el lote de un producto.
        $l = array();
        $li = array();
        $l["int_Stock"]     = MySQL::SQLValue( $saldo , MySQL::SQLVALUE_NUMBER );
        $li["int_IdLote"]   = MySQL::SQLValue( $idLote , MySQL::SQLVALUE_NUMBER );
        $this->UpdateRows( 'utb_producto_lote' , $l , $li );
        unset($l);
        unset($li);
    }
    /* ------------------------------------------------------------------------ */
    public function update_stock_producto( $idprod , $saldo  ){
        # vamos a reducir el stock en el lote de un producto.
        $k = array();
        $p = array();
        $k["int_stock"]         = MySQL::SQLValue( $saldo , MySQL::SQLVALUE_NUMBER );
        $p["int_IdProducto"]    = MySQL::SQLValue( $idprod , MySQL::SQLVALUE_NUMBER );
        $this->UpdateRows( 'utb_productos' , $k , $p );
        unset($k);
        unset($p);
    }
    /* ------------------------------------------------------------------------ */
    public function get_detalle_pedido01( $filtro ){
        $sql = '';
        $data = array();
        $response = array();
        
        $p = array();
        #
        $sql = " SELECT *, p.int_Cantidad as 'cant', l.`var_Lote` as 'lote', pr.var_Nombre as 'prod', u.var_Nombre as 'um'
        FROM `utb_pedido_detalle` p INNER JOIN `utb_productos` pr ON p.int_IdProducto = pr.int_IdProducto 
        INNER JOIN `utb_unidad_medida` u ON u.`int_IdUM` = p.int_IdUnidadMedida
        INNER JOIN `utb_producto_lote` l ON l.`int_IdLote` = p.`int_IdLote` ".$filtro;
        #
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{

            return '';

        }
    }
    /* ------------------------------------------------------------------------ */
    public function existe_correlativo( $corr , $TipoDoc ){
        #vamos a ver si existe el correlativo en la base de datos.
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT `int_idVenta` as 'id' FROM `utb_venta` WHERE `cht_TipoDoc` = '".$TipoDoc."' AND `int_Correlativo` = ".$corr;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $s) {
                return $s->id;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_serie_factura(){
        //Obtener la serie de las facturas desde la tabla confi
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT int_SerieFactura as 'serie' FROM `utb_confi` ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $s) {
                return $s->serie;
            }
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_pull_data_user( $idu ){
        //Obtener la serie de las facturas desde la tabla confi
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT * FROM `utb_usuarios` WHERE `int_IdUsuario` = ".$idu;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_data_anulado_venta( $idv ){
        //Obtener la serie de las facturas desde la tabla confi
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT v.`int_idUserAnula` as 'idu_del', DATE_FORMAT(v.`dt_Anulado`,'%d/%m/%Y %H:%i') as 'fec_anulado', v.`txt_MotivoAnulado`, u.`var_Usuario` FROM `utb_venta` v INNER JOIN `utb_usuarios` u ON u.int_IdUsuario = v.`int_idUserAnula` AND v.`int_idVenta` = ".$idv;
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            return $data;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function rep_prods_mas_vendidos( $idu , $limite = '' ){
        //Obtener la serie de las facturas desde la tabla confi
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " DELETE FROM `tmp_prod_mas_vendido` WHERE int_IdUsuario = ".$idu;
        $this->Query( $sql );
        #Volcando datos a la temporal
        $sql = " INSERT INTO `tmp_prod_mas_vendido` 
        SELECT d.`int_IdProducto` as 'idp', '".$idu."', SUM(d.`int_Cantidad`) as 'n' FROM `utb_venta_detalle` d INNER JOIN `utb_venta` v ON v.`int_idVenta` = d.`int_idVenta`AND v.`chr_Estado` = 'CER' GROUP BY d.`int_IdProducto` ";
        $this->Query( $sql );
        #Uniendo con tabla productos
        $sql = " SELECT t.`int_IdProd` as 'idp', t.`int_Cantidad` as 'n', p.`var_Nombre` as 'prod', p.int_Stock as 'stock'
        FROM `tmp_prod_mas_vendido` t
        INNER JOIN `utb_productos` p ON p.`int_IdProducto` = t.`int_IdProd`
        ORDER BY t.`int_Cantidad` DESC ".$limite;
        #Mostrando...
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            $response['n'] = $this->RowCount();
            $response['data'] = $data;
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function get_count_prod_mas_vendido(){
        //Obtener el numero de productos mas vendidos
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT COUNT(d.`int_IdProducto`) as 'n' FROM `utb_venta_detalle` d INNER JOIN `utb_venta` v ON v.`int_idVenta` = d.`int_idVenta`AND v.`chr_Estado` = 'CER' ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rst) {
                return $rst->n;
            }
            unset($rst);
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function grafico_ventas_usuario_dia( $idu ){
        //Obtener los registros ventas de un usuario, los 7 ultimos registros
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT SUM(`flt_Total`) as 'total', DATE_FORMAT(`ts_Registro`,'%d/%m/%Y') as 'fecha', DATE(`ts_Registro`) as 'day'  FROM `utb_venta` WHERE int_IdUsuario = ".$idu." GROUP BY DAY(`ts_Registro`) LIMIT 7 ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                $o = array();
                $o['day'] = $rs->day;
                $o['total'] = number_format($rs->total,2);
                array_push( $response , $o );
            }
            unset($rs);
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function grafico_ventas_dias(){
        //Obtener los registros ventas de todos, los 7 ultimos registros
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " SELECT SUM(`flt_Total`) as 'total', DATE_FORMAT(`ts_Registro`,'%d/%m/%Y') as 'fecha', DATE(`ts_Registro`) as 'day'  FROM `utb_venta` GROUP BY DAY(`ts_Registro`) LIMIT 7 ";
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                $o = array();
                $o['day'] = $rs->day;
                $o['total'] = number_format($rs->total,2);
                array_push( $response , $o );
            }
            unset($rs);
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
    public function grafico_prod_mas_vendido_user( $idu ){
        //Obtener la serie de las facturas desde la tabla confi
        $sql        = '';
        $data       = array();
        $response   = array();
        #
        $sql = " DELETE FROM `tmp_prod_mas_vendido` WHERE int_IdUsuario = ".$idu;
        $this->Query( $sql );
        #Volcando datos a la temporal
        $sql = " INSERT INTO `tmp_prod_mas_vendido` 
        SELECT d.`int_IdProducto` as 'idp', '".$idu."', SUM(d.`int_Cantidad`) as 'n' FROM `utb_venta_detalle` d INNER JOIN `utb_venta` v ON v.`int_idVenta` = d.`int_idVenta`AND v.`chr_Estado` = 'CER' GROUP BY d.`int_IdProducto` ";
        $this->Query( $sql );
        #Uniendo con tabla productos
        $sql = " SELECT t.`int_IdProd` as 'idp', t.`int_Cantidad` as 'n', p.`var_Nombre` as 'prod', p.int_Stock as 'stock'
        FROM `tmp_prod_mas_vendido` t
        INNER JOIN `utb_productos` p ON p.`int_IdProducto` = t.`int_IdProd`
        ORDER BY t.`int_Cantidad` DESC LIMIT 4 ";
        #Mostrando...
        $data = $this->QueryArray( $sql , MYSQL_ASSOC );
        #
        if( is_array($data) ){
            foreach ($data as $key => $rs) {
                $o = array();
                $o['value'] = intval($rs->n);
                $o['label'] = $rs->prod;
                array_push( $response , $o );
            }
            unset($rs);
            return $response;
        }else{
            return 0;
        }
    }
    /* -------------------------------------------------------------------- */
}

?>