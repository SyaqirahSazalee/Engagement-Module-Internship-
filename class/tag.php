<?php
/**
 * class for hashtag table/entity
 */
class Tag
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

	//create hashtag function
	public function addTag($fields = array())
	{
		if(!$this->_db->insert('tag', $fields))
		{
		  throw new Exception('There was a problem adding a hashtag.');
		}
	}

	//read all hashtags function
	public function searchAllTag()
	{
		$data = $this->_db->getall('tag');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchOnly($tagID = null){
		if($tagID){
			$field = (is_numeric($tagID)) ? 'tagID' : 'tagID';
			$data = $this->_db->get('tag', array($field, '=', $tagID));
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchForSuggestion($tagID = null){
		if($tagID){
			$field = (is_numeric($tagID)) ? 'tagID' : 'tagID';
			$data = $this->_db->get('tag', array($field, '=', $tagID), array("tagname", '=', $tagname));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporateID';
			$data = $this->_db->get('tag', array($field, '=', $corporateID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'corporateID';
			$data = $this->_db->get('tag', array($field, '=', $companyID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	//update hashtag function
	public function updateTag($fields = array(), $id = null, $tagID = null)
	{
		if (!$this->_db->update('tag', $id, $fields, $tagID)) 
		{
		  throw new Exception('There was a problem updating hashtag.');
		}
	}

	//delete hashtag function
	public function deleteTag($tagID = null)
	{
		if($tagID)
		{
			$field = (is_numeric($tagID)) ? 'tagID' : 'tagID';
			$data = $this->_db->delete('tag', array($field, '=', $tagID));
			return $data;
		}
		return false;
	}


}
?>