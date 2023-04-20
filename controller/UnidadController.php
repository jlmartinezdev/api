<?php
include("../model/consulta.php");
include("../model/unidad.php");
if($_SERVER['REQUEST_METHOD']=='GET'){
	print json_encode(unidad::getUnidad());
}
?>