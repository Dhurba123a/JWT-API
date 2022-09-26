<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class functions{
  protected $ci;

  /**
   * function constructor
   */
  function __construct()
  {
    $this->ci =& get_instance();

  }
	function getCustomDate($dateFormat,$date){
		if($date!=""){
		  if(!is_numeric(trim($date))){
			return mdate($dateFormat,strtotime(trim($date)));
		  }else{
			return mdate($dateFormat,trim($date));
		  }
		}else{
		  return "";
		}
	}
	public function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}

	function settingValue($colName){
	  $sett = $this->ci->adminmodel->getsettingValue($colName);
	  return $sett;
	}
	
	function ciError($post){
	  	 $errors = array();
        // Loop through $_POST and get the keys
        foreach ($post as $key => $value)
        {		
			//print_r($value);
			if(is_array($value)){
				$check = $this->check_array_error($value);
				if($check){
					$errors[$key."[]"] = form_error($key."[]");
				}
			}else{
				$errors[$key] = form_error($key);
			}
        }
		return array_filter($errors);	
	}
	
	function check_array_error($array){
		foreach ($array as $key => $value) {
			$value = trim($value);
			if (empty($value))
			return true;
		}	  
	}
	
 	function getStatusResult($post,$ret){
		if ($post['stat'] == "instatus") {
			if ($ret == 1) {
				$result = "activatesuccess";
				$stat   = "astatus";
			} else {
				$result = "activatefail";
				$stat   = "astatus";
			}
		} else if ($post['stat'] == "astatus") {
			if ($ret == 1) {
				$result = "deactivatesuccess";
				$stat   = "instatus";
			} else {
				$result = "deactivatefail";
				$stat   = "instatus";
			}
		}
		$res= array(
			'result' => $result,
			'stat' => $stat
		);
		return $res;
	}
	




}


?>