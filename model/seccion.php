<?php
class seccion{
	public static function getSeccion(){
		$sql= "SELECT * FROM  presentacion";
		return consulta::ejecutarSQL($sql);
	}
}
?>