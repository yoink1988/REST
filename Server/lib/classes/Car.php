<?php
include_once 'Sql.php';
include_once 'Db.php';
/**
 * Description of Car
 *
 * @author yoink
 */
class Car
{
	public $db;

	public function __construct()
	{
		$pdoOpts = MYSQL_HOST;
		$user = MYSQL_USER;
		$pass = MYSQL_PASS;
		$this->db = new PDO($pdoOpts,$user,$pass);
	}

	public function select($query)
	{
		$stmt = $this->db->query($query);
		
		while($res = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result[]=$res;
		}
		return $result;
	}
	
}
