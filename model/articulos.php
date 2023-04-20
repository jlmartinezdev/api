<?php
class articulo{
	public static function getAllArticulo(){
		$sql= "SELECT p.*,pr.present_descripcion,SUM(s.cantidad) AS cantidad,u.uni_nombre,u.uni_abreviatura FROM articulos p  INNER JOIN stock s ON p.articulos_cod=s.articulos_cod INNER JOIN presentacion pr ON p.present_cod=pr.present_cod  INNER JOIN unidad u ON p.uni_codigo=u.uni_codigo group by p.articulos_cod ORDER BY p.ARTICULOS_cod ASC limit 25";
		return consulta::ejecutarSQL($sql);
	}
	public static function buscarArticulo($txt){
		$sql= "SELECT p.*,pr.present_descripcion,SUM(s.cantidad) AS cantidad,u.uni_nombre,u.uni_abreviatura FROM articulos p  INNER JOIN stock s ON p.articulos_cod=s.articulos_cod INNER JOIN presentacion pr ON p.present_cod=pr.present_cod  INNER JOIN unidad u ON p.uni_codigo=u.uni_codigo WHERE p.producto_nombre like '%".$txt."%' GROUP BY p.articulos_cod ORDER BY p.ARTICULOS_cod ASC limit 25";
		return consulta::ejecutarSQL($sql);
	}
	public static function addArticulo($a){
		$sql="INSERT INTO articulos (ARTICULOS_cod, uni_codigo, producto_c_barra, present_cod, producto_nombre, producto_costo_compra, producto_costo_venta, foto, producto_fecHab, producto_vencimiento, pre_venta1, pre_venta2, pre_venta3, pre_venta4, pre_venta5, producto_ubicacion, producto_peso, producto_factor, pre_margen1, pre_margen2, pre_margen3, pre_margen4, pre_margen5,producto_indicaciones,producto_dosis,producto_formula, producto_dimagen) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$valores= array($a['codigo'],$a['unidad'],$a['c_barra'],$a['seccion'],$a['descripcion'],$a['costo'],$a['p1'],'','0','2030-01-01',$a['p1'],$a['p2'],$a['p3'],$a['p4'],0,$a['ubicacion'],'',$a['factor'],$a['m1'],$a['m2'],$a['m3'],$a['m4'],0,$a['indicaciones'],$a['modouso'],'','');
		if(consulta::add($sql,$valores)){
			//self::setActualizacion("articulos","articulos_cod",$a['codigo'],"I");
			return true;
		}else{
			return false;
		}
	}
	public static function delArticulo($id){
		self::delStock($id);
		self::setActualizacion("stock","articulos_cod",$id,"D");
		$sql= "DELETE FROM articulos WHERE ARTICULOS_cod=?;";
		self::setActualizacion("articulos","articulos_cod",$id,"D");
		return consulta::add($sql,array($id));
	}
	private static function delStock($id){
		$sql= "DELETE FROM stock WHERE ARTICULOS_cod=?;";
		consulta::add($sql,array($id));	
	}
	private static function setActualizacion($tabla,$columna,$id,$tipo){
		$a= self::getUltActualizacion();
		$sql= "INSERT INTO synctable (registro, tabla, columna, fhora, stado, LOCAL, nroactualizacion) VALUES(?,?,?,?,?,?,?)";
		consulta::add($sql,array($id,$tabla,$columna,date("Y-m-d H:i:s"),$tipo,'cen',$a['nroactualizacion']+1));	
	}
	private static function getUltActualizacion(){
		$sql="SELECT * FROM synctable ORDER BY nroactualizacion DESC LIMIT 1";
		return consulta::retornarUnaFila($sql);
	}
	public static function updateArticulo($a){
		$sql="CALL articulo_insert(?); ";
		$valores=array($a['codigo']);
		consulta::add($sql,$valores);
		$sql="UPDATE articulos SET uni_codigo=?,producto_c_barra=? ,present_cod=?,producto_nombre=?,producto_costo_compra=? ,producto_costo_venta=?,foto=?,producto_fecHab=? , producto_vencimiento=?, pre_venta1=?,pre_venta2=? ,pre_venta3=? ,pre_venta4=?,producto_ubicacion=?,producto_factor=?,pre_margen1=?,pre_margen2=?,pre_margen3=?,pre_margen4=?,producto_indicaciones=?,producto_dosis=?,producto_formula=?,producto_dimagen=? WHERE articulos_cod=?;";
		$valores=array($a['unidad'],self::setCodigo($a['codigo'],$a['c_barra']),$a['seccion'],$a['descripcion'],$a['costo'],$a['p1'],'',$a['svenc'],'2030-01-01',$a['p1'],$a['p2'],$a['p3'],$a['p4'],$a['ubicacion'],$a['factor'],$a['m1'],$a['m2'],$a['m3'],$a['m4'],$a['indicaciones'],$a['modouso'],'','',$a['codigo']);
		$res= consulta::add($sql,$valores);
		return $res;
		//self::setActualizacion("articulos","articulos_cod",$a['codigo'],"U");
	}
	public static function updateStock($stock,$articulo){
		
		for ($i=0; $i <count($stock) ; $i++) { 

			$sql="CALL insert_stock(?,?,?,?,?,?); ";
			$valores=array($articulo['codigo'],$stock[$i]['sucursal'],$stock[$i]['cantidad'],self::setVencimiento($stock[$i]['vencimiento']),$stock[$i]['loteold'],$stock[$i]['lotenew']);
			consulta::add($sql,$valores);
			
			// $sql="SELECT @tipo AS tipo ,@id AS id";
			// $act= consulta::ejecutarSQL($sql);
			// print(json_encode($act));
			// IF($act[0]['tipo']=='I'){
			// 	self::setActualizacion("stock","id_stock",$act[0]['id'],"I");
			// }ELSE{
			// 	self::setActualizacion("stock","id_stock",$act[0]['id'],"U");
			// }
		}
		return true;
	}
	public static function getUltimo(){
		$sql="select MAX(articulos_cod) as ultimo from articulos";
		return consulta::retornarUnaFila($sql);
	}
	private static function setCodigo($codigo,$c_barra){
		if(empty($c_barra)){
			return str_pad($codigo,7,'0',STR_PAD_LEFT);
		}
		return $c_barra;
	}
	private static function setVencimiento($fecha){
		if(empty($fecha) || $fecha=="Sin vencimiento"){
			return "2030-01-01";
		}
		return $fecha;
	}
	public static function getStock($id){
		$sql="SELECT id_stock as id,cantidad,lote_nro as loteold,lote_nro as lotenew,stock_fech_venc as vencimiento, suc_cod as sucursal FROM stock WHERE articulos_cod=".$id;
		return consulta::ejecutarSQL($sql);
	}
	public static function delStockbyID($id){
		$sql= "DELETE FROM stock WHERE id_stock=?;";
		consulta::add($sql,array($id));	
		self::setActualizacion("stock","id_stock",$id,"D");
	}
}

?>