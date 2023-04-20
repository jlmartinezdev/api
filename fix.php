<?php

class fix{
  public static function getCompra(){
		$sql= "SELECT dc.*,a.producto_costo_compra FROM detalle_compra dc INNER JOIN articulos a ON dc.ARTICULOS_cod= a.ARTICULOS_cod WHERE dc.compra_cod > 127";
		return consulta::ejecutarSQL($sql);
	}
	public static function compra($precio, $art, $com){
		$sql= "update detalle_compra set compra_precio= $precio where ARTICULOS_cod= $art and compra_cod= $com";
		return consulta::eliminar($sql);
	}

}

 ?>
