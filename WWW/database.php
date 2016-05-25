<?php
class Database {

	private static $host = 'localhost';
	private static $dbname = "Tinggi";
	private static $user = "root";
	private static $password = "root";
	private static $pdo = null;

	public static function getInstance(){
		if(is_null(self::$pdo))
		{
			self::$pdo = new PDO('mysql:host='.self::$host.';dbname='.self::$dbname.';charset=UTF-8', self::$user, self::$password);
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
			$req .= ' '.$elements[i];
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
				$req .= $key.' LIKE '.$value;
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
		foreach ($elements as $key => $value) {
			$req.= $key;
			$values.= $value;

			if($i < $last)
			{
				$req .= ',';
				$values .= ',';
			}
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
			$req .= ' '.$key. ' = ' .$value;
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
			$req .= $key.' LIKE '.$value;
			if($i < $last)
			{
				$req .= ' AND ';
			}

		}
		$req.= ' ;';
		return self::queryVoid($req);
	}

	public static function call($procedure,$parameters){
		$req='CALL ' .$procedure. '(';
		$count = count($parameters);
		$last = $count - 1;
		$i = 0;

		for($i = 0; $i < $count; ++$i) {
			$req .= ' '.$parameters[i];
			if($i < $last)
			{
				$req .= ',';
			}
		}
		$req.=');';
	}

	public static function delete($id,$table){
		return self::queryVoid('DELETE FROM '.$table.' WHERE id LIKE '.$id.' ;');
	}
}
?>
