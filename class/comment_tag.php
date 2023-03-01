<?php
class Comment_tag
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
	public function addComment_tag($fields = array())
	{
		if(!$this->_db->insert('comment_tag', $fields)) 
		{
			throw new Exception('There was a problem adding comment_tag.');
		}
	}

	//read all tag apply function
	public function searchComment_tag()
	{
		$data = $this->_db->getall('comment_tag');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchWithRecognition($recogID = null){
		if($recogID){
			$field = (is_numeric($recogID)) ? 'recogID' : 'recogID';
			$data = $this->_db->get('comment_tag', array($field, '=', $recogID));
			
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
			$data = $this->_db->get('comment_tag', array($field, '=', $commentID));
			
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
			$data = $this->_db->getnull('comment_tag', array($field, '=', $recogID),  'commentID');
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchTagApplyforPie()
	{
		$data = $this->_db->getall3('comment_tag', 'tagname');
		if($data->count())
		{
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}
}
?>