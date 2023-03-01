<?php
class Merit_assign
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

	//create add merit log function
	public function addMerit_assign($fields = array())
	{
		if(!$this->_db->insert('merit_assign', $fields)) 
		{
			throw new Exception('There was a problem adding merit assign.');
		}
	}

	public function searchWithLog($logID = null){
		if($logID){
			$field = (is_numeric($logID)) ? 'logID' : 'logID';
			$data = $this->_db->get('merit_assign', array($field, '=', $logID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchToUser($to_user = null){
		if($to_user){
			$field = ($to_user) ? 'to_user' : 'to_user';
			$data = $this->_db->get('merit_assign', array($field, '=', $to_user));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}
}
?>