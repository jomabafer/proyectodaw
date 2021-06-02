<?php
 /**
 * Clase para buscar diversos datos en la base de datos
 * @version 1.0
 * @package database
 */
class database {
	
	public function __construct(){
		  $config = parse_ini_file('config.ini');
		  try{     
		       $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
		       $dsn = 'mysql:host='.$config['server'].';dbname='.$config['base'];
		       $this->conn = new PDO($dsn,$config['usu'],$config['pass'],$opc);
		       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
		  catch (Exception $ex){
	          throw $ex;
	         }
	}
	
	
}
?>