<?php
class cliente{
	public static function getAllCliente(){
		$sql= "SELECT p.*,pr.present_descripcion,SUM(s.cantidad) AS cantidad,u.uni_nombre,u.uni_abreviatura FROM articulos p  INNER JOIN stock s ON p.articulos_cod=s.articulos_cod INNER JOIN presentacion pr ON p.present_cod=pr.present_cod  INNER JOIN unidad u ON p.uni_codigo=u.uni_codigo group by p.articulos_cod ORDER BY p.ARTICULOS_cod ASC limit 25";
		return consulta::ejecutarSQL($sql);
	}
	public static function buscarCliente($txt){
		$sql= "SELECT c.clientes_cod,c.cliente_ci,c.cliente_nombre FROM clientes c WHERE c.cliente_nombre like '".$txt."%'  ORDER BY c.cliente_nombre ASC limit 10";
		return consulta::ejecutarSQL($sql);
	}

}

?>
