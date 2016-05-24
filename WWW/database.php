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
		$req .= ' FROM '.$table.' WHERE ';

		foreach ($where as $key => $value) {
			++$i;
			$req .= $key.' LIKE '.$value;
			if($i < $last)
			{
				$req .= ' AND ';
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
		return self::query($req);
	}

	public static function delete($id,$table){
		return self::query('DELETE FROM '.$table.' WHERE id LIKE '.$id.' ;');
	}
}
?>
