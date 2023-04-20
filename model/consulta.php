<?php
require_once 'Database.php';
class consulta{
	public static function ejecutarSQL($query){
		try {
            $comando = Database::getInstance()->getDb()->prepare($query);
            $comando->execute();
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {

           // print($e);
            return -1;
        } 
	}
	public static function retornarSoloFILA($query){
		try {
            $comando = Database::getInstance()->getDb()->prepare($query);
            $comando->execute();
            $row = $comando->fetchAll(PDO::FETCH_NUM);
            return $row;

        } catch (PDOException $e) {

            //print($e);
            return -1;
        } 
	}
	
	public static function retornarUnaFila($query){
		try {
            $comando = Database::getInstance()->getDb()->prepare($query);
            $comando->execute();
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {

            //print($e);
            return -1;
		}
	}
	public static function add($sql,array $values){
			// Preparar la sentencia
			$sentencia = Database::getInstance()->getDb()->prepare($sql);
			return $sentencia->execute($values);

	}
	public static function eliminar($consulta){
		try{
			$comando = Database::getInstance()->getDb()->prepare($consulta);
            return $comando->execute();
		}catch(PDOException $e){
			//echo $e;
			return -1;
		}
	}
}

?>