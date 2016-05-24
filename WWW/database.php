<?php
class Database {

	private static $host = 'localhost';
	private static $dbname = "Tinggi";
	private static $user = "root";
	private static $password = "root";
	private static $pdo = null;

	public static getInstance()
	{
		if(is_null($this->pdo))
		{
			$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname.';charset=UTF-8', $this->user, $this->password);
		}
		return $this->pdo;
	}

	public static query($query)
	{
		$db = Database::getInstance();
		$stmt = $db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static select($elements,$table,$where)
	{
		$req = 'SELECT';
		$count = count($elements);
		$last = $count - 1;
		$i = 0;

		for($i = 0, $i < $count, ++$i) {
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
		return Database::query($req);
	}

	public static insert($elements,$table)
	{
		$count = count($elements);
		$last = $count - 1;
		$req = 'INSERT INTO '.$table.'(';
		$values = ' VALUES ('
		foreach ($elements as $key => $value) {
			$req.= $key;
			$values.= $value;

			if($i < $last)
			{
				$req .= ',';
				$values .= ',';
			}
		}
		$req.= ')'.$values.');'
		return Database::query($req);
	}

	public static delete($id,$table)
	{
		return Database::query('DELETE FROM '.$table.' WHERE id LIKE '.$id.' ;');
	}

}
?>
