<?php
include_once 'Car.php';
/**
 * Description of ShopController
 *
 * @author yoink
 */
class Shop
{
	public $model;
	public function __construct($model)
	{
		if(is_readable('lib/classes/'.$model.'.php'))
		{
			$this->model = new $model;
		}
//		var_dump($this);
	}
	public function getCar($args=null)
	{
		$q = 'select id, model, color from cars';
		$res = $this->model->select($q);
		return $res;
//		$res = $this->model->db->select()->setTable('cars')->setColumns('id, brand, model')->exec();
//		echo $res;
	}
	public function putCar($args=null)
	{
		return print_r($args);
	}
	public function postCar($args=null)
	{
		return print_r($args);
	}
	public function deleteCar($args=null)
	{
		return print_r($args);
	}
}