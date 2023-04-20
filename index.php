<?php
header('Access-Control-Allow-Headers: Origin,x-csrf-token,x-requested-with');
header('Access-Control-Allow-Origin: *');
include("consulta.php");
include("articulos.php");
include("clientes.php");
include("fix.php");

if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['cbarra'])){
		$res= articulo::getByCbarra($_GET['cbarra'],$_GET['bus_suc']);
		if($res){
			print json_encode($res);
		}else{
			print "no";
		}
	}
	if(isset($_GET['lote'])){
		$res= articulo::getlotes($_GET['lote'],$_GET['bus_suc']);
		if($res){
			print json_encode($res);
		}else{
			print "no";
		}
	}
	if(isset($_GET['lotecompra'])){
		$res= articulo::getlotes_compra($_GET['lotecompra'],$_GET['bus_suc']);
		if($res){
			print json_encode($res);
		}else{
			print "no";
		}
	}
	if(isset($_GET['buscar'])){
		$res= articulo::buscarArticulo($_GET['buscar'],$_GET['bus_suc']);
		if($res){
			print json_encode($res);
		}else{
			print "";
		}
	}
	if(isset($_GET['cliente'])){
		$res= cliente::buscarCliente($_GET['cliente']);
		if($res){
			print json_encode($res);
		}else{
			print "[]";
		}
	}
	if(isset($_GET['update'])){
		$cuotas= articulo::cuotas();
		$nro_venta=0;
		$is_actualizar= false;
		for ($i=0; $i < count($cuotas); $i++) {
			if($cuotas[$i]['nro_fact_ventas'] != $nro_venta){
				$nro_venta= $cuotas[$i]['nro_fact_ventas'];

				if($cuotas[$i]['nro_cuotas']=="2"){
					$is_actualizar= true;
				}
				if($cuotas[$i]['nro_cuotas']=="1"){
					$is_actualizar = false;
				}


			}
			if($is_actualizar){
				articulo::updateCuotas($cuotas[$i]['nro_cuotas'],$cuotas[$i]['nro_fact_ventas']);
				print $cuotas[$i]['nro_cuotas'];
			}
		}
	}
	if(isset($_GET['update2'])){
		print "Actualizando BD... \n";
		$cuotas= articulo::cuotas();
		$nro_venta=0;
		$is_actualizar= false;
		for ($i=0; $i < count($cuotas); $i++) {
			if($cuotas[$i]['nro_fact_ventas'] != $nro_venta){
				$nro_venta= $cuotas[$i]['nro_fact_ventas'];

				if($cuotas[$i]['nro_cuotas']=="1" && $cuotas[$i]['monto_cuota'] < 1 && $cuotas[$i]['monto_saldo'] < 1){
					$is_actualizar= true;
				}
				if($cuotas[$i]['nro_cuotas']=="1" &&  $cuotas[$i]['monto_cuota'] > 0 || $cuotas[$i]['monto_saldo'] > 0){
					$is_actualizar = false;
				}


			}
			if($is_actualizar){
				articulo::updateCuotas($cuotas[$i]['nro_cuotas'],$cuotas[$i]['nro_fact_ventas']);
				print $cuotas[$i]['nro_cuotas'];
			}
		}
		articulo::deleteCtas();
	}
	if(isset($_GET['fix'])){
		$compra= fix::getCompra();
		for ($i=0; $i < count($compra); $i++) {
			fix::compra($compra[$i]['producto_costo_compra'],$compra[$i]['ARTICULOS_cod'],$compra[$i]['compra_cod']);
		}
	}
}



?>
