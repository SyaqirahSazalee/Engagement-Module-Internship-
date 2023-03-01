<?php
class Merit_log
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
	public function addMerit_log($fields = array())
	{
		if(!$this->_db->insert('merit_log', $fields)) 
		{
			throw new Exception('There was a problem adding merit log.');
		}
	}

	//read all merit log function
	public function searchAllMeritLog()
	{
		$data = $this->_db->getall('merit_log');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchWithLog($logID = null){
		if($logID){
			$field = (is_numeric($logID)) ? 'logID' : 'logID';
			$data = $this->_db->get('merit_log', array($field, '=', $logID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchFromUser($from_user = null){
		if($from_user){
			$field = ($from_user) ? 'from_user' : 'from_user';
			$data = $this->_db->getDesc('merit_log', array($field, '=', $from_user), 'create_at');
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchAllOnlyMonth()
	{
		$data = $this->_db->getgiveallowance('merit_log', 'create_at');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

}
?>