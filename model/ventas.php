<?php
class ventas{
public static function getVentas($desde,$hasta){
	$filtro="";
	$limit="";
	if(!empty($desde) && !empty($hasta)){
		$filtro= " WHERE DATE(v.venta_fecha) BETWEEN '".$desde."' AND '".$hasta."'";
	}else{
		$limit="limit 100";
	}
	
	$sql= "SELECT v.*,DATE_FORMAT(v.venta_fecha,'%d/%m/%Y %H:%i') AS fecha,c.cliente_nombre, c.cliente_direccion, c.cliente_ruc,s.suc_desc FROM ventas v INNER JOIN clientes c ON v.CLIENTES_cod=c.CLIENTES_cod INNER JOIN sucursales s ON v.suc_cod=s.suc_cod ".$filtro." ORDER BY v.nro_fact_ventas DESC ".$limit;
		return consulta::ejecutarSQL($sql);
}
public static function getVentasRes($chart){
	$filtro="";
	if($chart['byYear']){
	}else{
		$filtro= " WHERE YEAR(v.venta_fecha)=".$chart["anho"]." AND MONTH(v.venta_fecha)=".$chart['mes'];
	}
	$sql= "SELECT SUM(v.venta_total) AS total,DATE_FORMAT(v.venta_fecha,'%Y-%m-%d') AS fecha FROM ventas v ".$filtro."  GROUP BY DATE(v.venta_fecha)";
		return consulta::ejecutarSQL($sql);
}	
}
?>