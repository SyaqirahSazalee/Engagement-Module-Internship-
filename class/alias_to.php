<?php
class Alias_to
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

	public static function exists($name)
	{
		return (!empty($this->_data)) ? true : false;
	}

	//create add alias_to function
	public function addAlias_to($fields = array())
	{
		if(!$this->_db->insert('alias_to', $fields)) 
		{
			throw new Exception('There was a problem adding alias_to.');
		}
	}

	//read all alias_to function
	public function searchAllAlias_to()
	{
		$data = $this->_db->getall('alias_to');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchWithRecognition($recogID = null){
		if($recogID){
			$field = (is_numeric($recogID)) ? 'recogID' : 'recogID';
			$data = $this->_db->get('alias_to', array($field, '=', $recogID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithComment($commentID = null){
		if($commentID){
			$field = (is_numeric($commentID)) ? 'commentID' : 'commentID';
			$data = $this->_db->get('alias_to', array($field, '=', $commentID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithRecogAndComment($recogID = null){
		if($recogID){
			$field = (is_numeric($recogID)) ? 'recogID' : 'recogID';
			$data = $this->_db->getnull('alias_to', array($field, '=', $recogID),  'commentID');
			
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
			$data = $this->_db->get('alias_to', array($field, '=', $to_user));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	//update alias_to function
	public function updateAlias_to($fields = array(), $id = null, $alias_toID)
	{
		if (!$this->_db->update('alias_to', $id, $fields, $alias_toID)) 
		{
		  throw new Exception('There was a problem updating alias_to.');
		}
	}

	//delete alias_to function
	public function deleteAlias_to($alias_toID = null)
	{
		if($alias_toID)
		{
			$field = (is_numeric($alias_toID)) ? 'alias_toID' : 'name';
			$data = $this->_db->delete('alias_to', array($field, '=', $alias_toID));
			return $data;
		}
		return false;
	}

	public function searchAliasToforPie()
	{
		$data = $this->_db->getall2('alias_to', 'comment_alias', 'to_user');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}
}
?>