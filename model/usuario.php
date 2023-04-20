<?php

class usuario{
	public static function getUsers(){
		$sql= "select cod_usuarios,TRIM(nom_usuarios) as nom_usuarios,TRIM(user_usuarios) as user_usuarios from usuarios";
		return consulta::ejecutarSQL($sql);
	}
}
?>