<?php
class articulo{
	public static function getAllArticulo(){
		$sql= "SELECT p.*,pr.present_descripcion,SUM(s.cantidad) AS cantidad,u.uni_nombre,u.uni_abreviatura FROM articulos p  INNER JOIN stock s ON p.articulos_cod=s.articulos_cod INNER JOIN presentacion pr ON p.present_cod=pr.present_cod  INNER JOIN unidad u ON p.uni_codigo=u.uni_codigo group by p.articulos_cod ORDER BY p.ARTICULOS_cod ASC limit 25";
		return consulta::ejecutarSQL($sql);
	}
	public static function buscarArticulo($txt,$suc){
		$sql= "SELECT p.*,pr.present_descripcion,SUM(s.cantidad) AS cantidad,u.uni_nombre,u.uni_abreviatura,s.id_stock FROM articulos p  INNER JOIN stock s ON p.articulos_cod=s.articulos_cod INNER JOIN presentacion pr ON p.present_cod=pr.present_cod  INNER JOIN unidad u ON p.uni_codigo=u.uni_codigo WHERE p.producto_nombre like '%".$txt."%' AND s.suc_cod=".$suc." GROUP BY p.articulos_cod ORDER BY p.ARTICULOS_cod ASC limit 25";
		return consulta::ejecutarSQL($sql);
	}
	public static function getByCbarra($codigo,$suc){

		$sql= "SELECT p.*,pr.present_descripcion,s.id_stock,s.cantidad,s.lote_nro,u.uni_nombre,u.uni_abreviatura FROM articulos p  INNER JOIN stock s ON p.articulos_cod=s.articulos_cod INNER JOIN presentacion pr ON p.present_cod=pr.present_cod  INNER JOIN unidad u ON p.uni_codigo=u.uni_codigo WHERE p.producto_c_barra=\"".$codigo."\" AND s.suc_cod=$suc.";
		return consulta::ejecutarSQL($sql);
	}
	public static function getlotes($articulo,$suc){
		$sql="SELECT * FROM stock WHERE articulos_cod= $articulo and suc_cod= $suc and cantidad > 0";
		return consulta::ejecutarSQL($sql);
	}
	public static function getlotes_compra($articulo,$suc){
		$sql="SELECT * FROM stock WHERE articulos_cod= $articulo and suc_cod= $suc";
		return consulta::ejecutarSQL($sql);
	}
	public static function cuotas(){
		$sql="SELECT * FROM ctas_cobrar ORDER BY nro_fact_ventas, nro_cuotas";
		return consulta::ejecutarSQL($sql);
	}
	public static function updateCuotas($nro_cuotas, $nro_venta){
		$sql="UPDATE ctas_cobrar SET nro_cuotas = ($nro_cuotas - 1) WHERE nro_cuotas = $nro_cuotas AND nro_fact_ventas= $nro_venta";
		consulta::eliminar($sql);
		$sql= "UPDATE cobranza_detalle SET nro_cuotas= $nro_cuotas- 1 WHERE nro_cuotas = $nro_cuotas AND nro_fact_ventas= $nro_venta";
		consulta::eliminar($sql);

	}
	public static function deleteCtas(){

		$sql= "DELETE FROM ctas_cobrar WHERE nro_cuotas=0";
		consulta::eliminar($sql);

	}
}

?>
