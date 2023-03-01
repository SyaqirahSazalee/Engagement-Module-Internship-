<?php
class Comment_alias
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
	public function addComment_alias($fields = array())
	{
		if(!$this->_db->insert('comment_alias', $fields)) 
		{
			throw new Exception('There was a problem adding comment_alias.');
		}
	}

	//read all alias_to function
	public function searchComment_alias()
	{
		$data = $this->_db->getall('comment_alias');
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
			$data = $this->_db->get('comment_alias', array($field, '=', $recogID));
			
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
			$data = $this->_db->get('comment_alias', array($field, '=', $commentID));
			
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
			$data = $this->_db->getnull('comment_alias', array($field, '=', $recogID),  'commentID');
			
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
			$data = $this->_db->get('comment_alias', array($field, '=', $to_user));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	//update alias_to function
	public function updateComment_alias($fields = array(), $id = null, $alias_toID)
	{
		if (!$this->_db->update('comment_alias', $id, $fields, $alias_toID)) 
		{
		  throw new Exception('There was a problem updating comment_alias.');
		}
	}

	//delete alias_to function
	public function deleteComment_alias($alias_toID = null)
	{
		if($alias_toID)
		{
			$field = (is_numeric($alias_toID)) ? 'alias_toID' : 'name';
			$data = $this->_db->delete('comment_alias', array($field, '=', $alias_toID));
			return $data;
		}
		return false;
	}

	public function searchTagApplyforPie()
	{
		$data = $this->_db->getall2('comment_alias', 'to_user');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}
}
?>