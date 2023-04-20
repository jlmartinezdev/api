<?php
include("../model/consulta.php");
include("../model/sucursal.php");
if($_SERVER['REQUEST_METHOD']=='GET'){
	print json_encode(sucursal::getSucursal());
}
?>