<?php
class Addpoint
{
	private $_data,
			$_db;

	function __construct()
	{
		$this->_db = Database::getInstance();
	}

	public function data()
	{
		return $this->_data;
	}

	public function lastinsertid()
	{
		return $this->_db->lastInsertId();
	}

	public static function exists($name)
	{
		return (!empty($this->_data)) ? true : false;
	}

	//create add addpoint function
	public function addAddpoint($fields = array())
	{
		if(!$this->_db->insert('addpoint', $fields)) 
		{
			throw new Exception('There was a problem adding add point.');
		}
	}

	//read all addpoint function
	public function searchAllAddpoint()
	{
		$data = $this->_db->getall('recognition');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	//update addpoint function
	public function updateAddpoint($fields = array(), $id = null, $addpointID)
	{
		if (!$this->_db->update('addpoint', $id, $fields, $addpointID)) 
		{
		  throw new Exception('There was a problem updating add point.');
		}
	}

	//delete addpoint function
	public function deleteAddpoint($addpointID = null)
	{
		if($addpointID)
		{
			$field = (is_numeric($addpointID)) ? 'addpointID' : 'name';
			$data = $this->_db->delete('addpoint', array($field, '=', $addpointID));
			return $data;
		}
		return false;
	}
}
?>