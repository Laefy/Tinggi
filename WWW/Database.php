<?php
class Database {

	private static $host = '127.0.0.1';
	private static $dbname = 'Tinggy';
	private static $user = 'root';
	private static $password = '';
	private static $pdo = null;

	public static function getInstance(){
		if(is_null(self::$pdo)){
			try {
					self::$pdo = new PDO('mysql:host='.self::$host.';dbname='.self::$dbname, self::$user, self::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			}
			catch( PDOException $Exception ) {
    		echo $Exception->getMessage( ) , $Exception->getCode( );
			}
		}
		return self::$pdo;
	}

	public static function query($query){
		$db = self::getInstance();
		$stmt = $db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function queryVoid($query){
		$db = self::getInstance();
		$stmt = $db->prepare($query);
		$stmt->execute();
	}

	public static function select($elements,$table,$where){
		$req = 'SELECT';
		$count = count($elements);
		$last = $count - 1;
		$i = 0;

		for($i = 0; $i < $count; ++$i) {
			$req .= ' '.$elements[$i];
			if($i < $last)
			{
				$req .= ',';
			}
		}
		$req .= ' FROM '.$table;

		$i = 0;
		$last = count($where) - 1;
		if ($last >= 0) {
			$req .= ' WHERE ';

			foreach ($where as $key => $value) {
				++$i;
				$req .= $key.' LIKE \''.$value.'\'';
				if($i < $last)
				{
					$req .= ' AND ';
				}

			}
		}

		$req.= ' ;';
		return self::query($req);
	}

	public static function insert($elements,$table){
		$count = count($elements);
		$last = $count - 1;
		$req = 'INSERT INTO '.$table.'(';
		$values = ' VALUES (';
		$i=0;
		foreach ($elements as $key => $value) {
			$req.= $key;
			$values.= '\''.$value.'\'';

			if($i < $last)
			{
				$req .= ',';
				$values .= ',';
			}
			$i++;
		}
		$req.= ')'.$values.');';
		return self::queryVoid($req);
	}

	public static function update($elements, $table, $where){
		$req = 'UPDATE ' .$table;
		$count = count($elements);
		$last = $count - 1;
		$i = 0;
		$req .= ' SET';

		foreach($elements as $key => $value) {
			$req .= ' '.$key. ' = \'' .$value.'\'';
			if($i < $last)
			{
				$req .= ',';
			}
			++$i;
		}
		$req .= ' WHERE ';

		$i = 0;
		$last = count($where) - 1;
		foreach ($where as $key => $value) {
			++$i;
			$req .= $key.' LIKE \''.$value.'\'';
			if($i < $last)
			{
				$req .= ' AND ';
			}

		}
		$req.= ' ;';
		return self::queryVoid($req);
	}

	public static function call_function($name,$param = [])
	{
		$i=0;
		$list= '';
		$values = array();
		foreach($param as $p)
		{
			$values[':P'.$i] = $p;
			if($i != 0) $list.=',';
			$list.=':P'.$i;
			++$i;
		}
		$db = self::getInstance();
		$stmt = $db->prepare("SELECT `$name`(".$list.") AS `result`;");
		$stmt->execute($values);
		$tab = $stmt->fetch(PDO::FETCH_NUM);
		return $tab[0];
	}

	public static function call($procedure,$parameters){
		$req='CALL ' .$procedure. '(';
		$count = count($parameters);
		$last = $count - 1;
		$i = 0;

		for($i = 0; $i < $count; ++$i) {
			$req .= ' '.$parameters[$i];
			if($i < $last)
			{
				$req .= ',';
			}
		}
		$req.=');';
		return self::query($req);
	}

	public static function delete($id,$table){
		return self::queryVoid('DELETE FROM '.$table.' WHERE id LIKE \''.$id.'\' ;');
	}
}
?>
