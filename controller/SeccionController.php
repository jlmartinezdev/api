<?php
include("../model/consulta.php");
include("../model/seccion.php");
if($_SERVER['REQUEST_METHOD']=='GET'){
	print json_encode(seccion::getSeccion());
}
?>