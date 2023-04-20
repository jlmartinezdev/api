<?php
include("../model/consulta.php");
include("../model/ventas.php");
if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['alld'])){
		print json_encode(ventas::getVentas($_GET['alld'],$_GET['allh']));	
	}
	if(isset($_GET['chart'])){
		//
	}
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	$body = json_decode(file_get_contents("php://input"), true);
	if(isset($body['chart'])){
		print json_encode(ventas::getVentasRes($body['chart']));	
	}
}
?>