<?php
class unidad{
	public static function getUnidad(){
		$sql= "SELECT * FROM  unidad";
		return consulta::ejecutarSQL($sql);
	}
}
?>