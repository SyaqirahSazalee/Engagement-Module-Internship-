<?php
class Validate{
	private $_passed = false,
			$_errors = array(),
			$_db = null;
			
	public function __construct(){
		$this->_db = Database::getInstance();
	}
	
	public function check($source, $items = array()){
		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){
				
				$value = $source[$item];
				$item = escape($item);
				
				if($rule === 'required' && empty($value)){
					$this->addError(["$item" => "Required"]);
				}else if(!empty($value)){
					switch($rule){
						case 'min':
							if(strlen($value)< $rule_value){
								$this->addError("{$item} must be at least {$rule_value} character");
							}
						break;
						case 'max':
							if(strlen($value)> $rule_value){
								$this->addError("{$item} must be at most {$rule_value} character");
							}
						break;
						case 'match':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item,'=',$value));
							if($check->count()){
								$this->addError("{$item} already exixts.");
							}
						break;
						case 'invalid':
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
								$this->addError("{$item} Invalid.");
							}
						break;
					}
				}
			}
		}
		
		if(empty($this->_errors)){
			$this->addError("Valid");
			$this->_passed = true;
		}
		return $this;
	}
	
	private function addError($error){
		$this->_errors[] = $error;
	}
	
	public function errors(){
		return $this->_errors;
	}
	
	public function passed(){
		return $this->_passed;
	}
}
?>