<?php
class Recognition
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

	//create add recognition function
	public function addRecognition($fields = array())
	{
		if(!$this->_db->insert('recognition', $fields)) 
		{
			throw new Exception('There was a problem adding recognition.');
		}
	}

	public function searchOnly($recogID = null){
		if($recogID){
			$field = (is_numeric($recogID)) ? 'recogID' : 'recogID';
			$data = $this->_db->getDesc('recognition', array($field, '=', $recogID), 'create_at');
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->getDesc('recognition', array($field, '=', $corporateID), 'create_at');
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->getDesc('recognition', array($field, '=', $companyID), 'create_at');
			
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
			$data = $this->_db->getDesc('recognition', array($field, '=', $from_user), 'create_at');
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchFromUserAnalytics($from_user = null){
		if($from_user){
			$field = ($from_user) ? 'from_user' : 'from_user';
			$data = $this->_db->get('recognition', array($field, '=', $from_user));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchRecognitionforPie()
	{
		$data = $this->_db->getall2('recognition', 'from_user');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}
}
?>