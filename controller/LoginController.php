<?php
session_start();
include("../model/consulta.php");
include("../model/usuario.php");
class login{
		public  static function log($user,$pass){
			$sql= "select * from usuarios where user_usuarios='".$user."' and clave_usuarios=md5('".$pass."');";
			
			$resultado= consulta::retornarUnaFila($sql);
			if($resultado){
				return $resultado;
			 }else{
				return false;
			}
		}
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	$body = json_decode(file_get_contents("php://input"), true);
	if (isset($body['usuario'])) {
		$metas = login::log($body['usuario'],$body['password']);
    if ($metas) {
    	$_SESSION['usuario']= $metas['nom_usuarios'];
        print json_encode(array(
            "estado" => 1,
            "data" => $metas
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "data" => "Usuario/Contraseña incorrecta!"
        ));
    }
	}
}
if($_SERVER['REQUEST_METHOD']=='GET'){
	print json_encode(usuario::getUsers());
}
?>