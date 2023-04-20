<?php
class sucursal{
	public static function getSucursal(){
		$sql= "SELECT * FROM  sucursales";
		return consulta::ejecutarSQL($sql);
	}
}
?>