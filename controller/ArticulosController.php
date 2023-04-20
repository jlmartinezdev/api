<?php
include("../model/consulta.php");
include("../model/articulos.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
	$body = json_decode(file_get_contents("php://input"), true);
	if (isset($body['articulo'])) {
		articulo::updateArticulo($body['articulo']);
		articulo::updatestock($body['stock'],$body['articulo']);
		print "Datos Guardado Correctamente";
	}
	if (isset($body['updatestock'])) {
		articulo::updatestock($body['updatestock'],$body['codart']);
		print "Datos Guardado Correctamente";
	}
	if(isset($body['reservar'])){
		articulo::addArticulo($body['reservar']);
		print "Articulo registrado";
	}
}
if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['all'])){
		print json_encode(articulo::getAllArticulo());	
	}
	if(isset($_GET['ultimo'])){
		$ultimo= articulo::getUltimo();
		$ultimo = $ultimo['ultimo'] ? $ultimo['ultimo'] + 1: 1; 
		print $ultimo;	
	}
	if(isset($_GET['buscar'])){
		$res= articulo::buscarArticulo($_GET['buscar']);
		if($res){
			print json_encode($res);
		}else{
			print "NO";
		}

		
	}
	if(isset($_GET['stock'])){
		print json_encode(articulo::getStock($_GET['stock']));
	}
}
if($_SERVER['REQUEST_METHOD']=='PATCH'){

}
if($_SERVER['REQUEST_METHOD']=='DELETE'){
	$body = json_decode(file_get_contents("php://input"), true);
	if(isset($body['articulocod'])){
		articulo::delArticulo($body['articulocod']);
		print "OK";
	}
	if(isset($body['delstockbyid'])){
		articulo::delStockbyID($body['delstockbyid']);
		print "OK";
	}
}

?>