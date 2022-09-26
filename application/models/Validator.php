<?php
class Validator extends CI_Model
{
 static function make($rules)
    {
		
		$ci =& get_instance();
		$ci->form_validation->set_error_delimiters('<label class="invalid-feedback">', '</label>');
		if($ci->input->method()=="put"){
			$ci->form_validation->set_data($ci->put());
		}
		foreach($rules as $key => $value){		
			$ci->form_validation->set_rules($key, $value[0] ,$value[1]);
		}
    }
	
	static function fails(){
		$ci =& get_instance();
		return $ci->form_validation->run();
		
	}

	static function error($posts=array()){
		$ci =& get_instance();
		if($ci->input->method()=="put"){
			$post = $ci->put();
		}else{
			$post = $ci->input->post();
		}
		$errors = $ci->functions->ciError($post);
		//print_r($posts);

		$req_errors = $ci->form_validation->error_string();
		if(!empty($req_errors)){
			$errors=$req_errors;
		}
		$value = array(
			'result'=>$errors,
			'message' =>'Some errors found.',
			'status' => 'error'
		);
		$ci->response($value, REST_Controller::HTTP_BAD_REQUEST);
		exit;
	}   

	static function setMessage($message){
		foreach($message as $key => $value){
			$ci =& get_instance();	
			$ci->form_validation->set_message($key,$value);
		}	
	}

}