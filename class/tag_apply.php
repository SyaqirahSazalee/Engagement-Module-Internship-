<?php
class Tag_apply
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
	public function addTag_apply($fields = array())
	{
		if(!$this->_db->insert('tag_apply', $fields)) 
		{
			throw new Exception('There was a problem adding tag apply.');
		}
	}

	//read all tag apply function
	public function searchAllTagApply()
	{
		$data = $this->_db->getall('tag_apply');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchWithRecognition($recogID = null){
		if($recogID){
			$field = (is_numeric($recogID)) ? 'recogID' : 'recogID';
			$data = $this->_db->get('tag_apply', array($field, '=', $recogID));
			
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
			$data = $this->_db->get('tag_apply', array($field, '=', $commentID));
			
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
			$data = $this->_db->getnull('tag_apply', array($field, '=', $recogID),  'commentID');
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchTagApplyforPie()
	{
		$data = $this->_db->getall2('tag_apply', 'comment_tag', 'tagname');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}
}
?>