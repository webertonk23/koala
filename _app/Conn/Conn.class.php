<?php

	class Conn{
		private static $Host = HOST;
		private static $User = USER;
		private static $Pass = PASS;
		private static $Db = DB;
		
		private static $Connect = null;
		
		private static function Conectar(){
			try{
				if(self::$Connect == null):
					//$dsn = 'mysql:host='.self::$Host.';dbname='.self::$Db;
					$dsn = 'sqlsrv:Server='.self::$Host.';Database='.self::$Db;
					$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
					
					self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
					//self::$Connect = new PDO($dsn, self::$User, self::$Pass);
				endif;
			}catch (PDOExcepition $ex) {
				PHPErro($ex->getCode(), $ex->getMenssage(), $ex->getFile());
				die;				
			}
			
			self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return self::$Connect;
		}
		
		public static function GetConn(){
			return self::Conectar();
		}
	}