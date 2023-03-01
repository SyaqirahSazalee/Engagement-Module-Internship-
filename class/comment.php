<?php
class Comment
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

	//create add comment function
	public function addComment($fields = array())
	{
		if(!$this->_db->insert('comment', $fields)) 
		{
			throw new Exception('There was a problem adding comment.');
		}
	}

	public function searchAllComment()
	{
		$data = $this->_db->getall('comment');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchCommentWithRecogID($recogID = null){
		if($recogID){
			$field = (is_numeric($recogID)) ? 'recogID' : 'recogID';
			$data = $this->_db->getDesc('comment', array($field, '=', $recogID), 'create_at');
			
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
			$data = $this->_db->getDesc('comment', array($field, '=', $from_user), 'create_at');
			
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
			$data = $this->_db->get('comment', array($field, '=', $from_user));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}
}
?>