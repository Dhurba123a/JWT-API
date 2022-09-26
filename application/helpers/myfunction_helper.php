<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


function in_array_any($needles, $haystack) {
   return (bool)array_intersect($needles, $haystack);
}




function print_array($array){
		echo '<pre>';
	print_r($array);
	echo '<pre>';
	}
   function test_print($item, $key)
{
    echo "$key holds $item\n";
	echo '<br/>';
}	
	function get_domain_from_url($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

function array_flatten($array) { 
  if (!is_array($array)) { 
    return FALSE; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, array_flatten($value)); 
    } 
    else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
} 


if(!function_exists('FontAwesomeIcon')){

 function FontAwesomeIcon($mime_type)
    {
        // List of official MIME Types: http://www.iana.org/assignments/media-types/media-types.xhtml
        static $font_awesome_file_icon_classes = [
            // Images
            'image'                                                                     => 'fa-file-image',
            // Audio
            'audio'                                                                     => 'fa-file-audio',
            // Video
            'video'                                                                     => 'fa-file-video',
            // Documents
            'application/pdf'                                                           => 'fa-file-pdf',
            'application/msword'                                                        => 'fa-file-word',
            'application/vnd.ms-word'                                                   => 'fa-file-word',
            'application/vnd.oasis.opendocument.text'                                   => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml'            => 'fa-file-word',
            'application/vnd.ms-excel'                                                  => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml'               => 'fa-file-excel',
            'application/vnd.oasis.opendocument.spreadsheet'                            => 'fa-file-excel',
            'application/vnd.ms-powerpoint'                                             => 'fa-file-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml'              => 'ffa-file-powerpoint',
            'application/vnd.oasis.opendocument.presentation'                           => 'fa-file-powerpoint',
            'text/plain'                                                                => 'fa-file-alt',
            'text/html'                                                                 => 'fa-file-code',
            'application/json'                                                          => 'fa-file-code',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
            // Archives
            'application/gzip'                                                          => 'fa-file-archive',
            'application/zip'                                                           => 'fa-file-archive',
            'application/x-zip-compressed'                                              => 'fa-file-archive',
            // Misc
            'application/octet-stream'                                                  => 'fa-file-archive',
        ];

        if (isset($font_awesome_file_icon_classes[$mime_type]))
            return $font_awesome_file_icon_classes[$mime_type];

        $mime_group = explode('/', $mime_type, 2)[0];
        return (isset($font_awesome_file_icon_classes[$mime_group])) ? $font_awesome_file_icon_classes[$mime_group] : 'fa-file';
    }
	
}


function my_icon($file_mime){
	
	return '<i class="fa '.FontAwesomeIcon($file_mime).'"></i>';
}

 function get_domain()
    {
        $pos = strpos($_SERVER['SERVER_NAME'], 'www');
        if ($pos === 0) {
            $domain = str_replace("www.", "", $_SERVER['SERVER_NAME']);
        } else {
            $domain = $_SERVER['SERVER_NAME'];
        }
        return $domain;
    }
	 function wordlimit($string, $length = 40, $ellipsis = "...")
	{
		$string = strip_tags($string, '<div>');
		$string = strip_tags($string, '<p>');
		$words = explode(' ', $string);
		if (count($words) > $length)
			return implode(' ', array_slice($words, 0, $length)) . $ellipsis;
		else
			return $string;
	}


	
	function create_slug($string){
		$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
		return strtolower($slug);
	}  
  
    function underscore_slug($str, $delimiter = '_') {
        $slug = trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter);
        return $slug;
    }


  function createSlug($str, $delimiter = '-') {

        $slug = trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter);
        return $slug;
    }
  
   if(!function_exists('makeDirectory')){
	   function makeDirectory($new_path, $mode) {
    if (!file_exists($new_path)) {
        mkdir($new_path, $mode, true);
    }
	return true;
	}
	   
   }
   if(!function_exists('delete_file')){
	   function delete_file($new_path) {
    if (file_exists($new_path)) {
      unlink($new_path);
    }
	return true;
	}
	   
   }
   if(!function_exists('cur_date')){
	  function cur_date(){
			return date('Y-m-d');
	  } 
   }
    if(!function_exists('cur_date_time')){
	  function cur_date_time(){
			return date('Y-m-d H:i:s');
	  } 
   }
  
  if(!function_exists('custom_date')){
	  function custom_date($format,$originalDate){
		$newDate = date($format, strtotime($originalDate));
		return $newDate;
	  }
	  
  }
  
  
  function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
  
  if(!function_exists('get_extension_by_type')){
  function get_extension_by_type($type){
		if($type=="image"){
					$extension = unserialize(image_extension); 
				}else if($type=="video"){
					$extension = unserialize(video_extension); 
				}else{
					$extension = array();
				}
		
		return $extension;
	}
  }
   if (!function_exists('withErrors')) {
	function withErrors($msg,$result=""){
		 $value=array(
				'status'=>"fail",
				'result' =>$result,
				'message'=>$msg,
				);
		return $value;
	}
   }
    if (!function_exists('withSuccess')) {
	function withSuccess($msg,$result=""){
		 $value=array(
				'status'=>"success",
				'result' => $result,
				'message'=>$msg,
				);
		return $value;
	}

	}

   
   if (!function_exists('getRealIpAddr')) {
   function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
   }  
  

 if (!function_exists('form_validation_error')) {
    
    function form_validation_error(){
 $ci =& get_instance();
   $post = $ci->input->post();
            $errors = $ci->functions->ciError($post);
            $value = array(
                'result' => $errors,
                'status' => 'error'
            );

            echo json_encode($value);
            exit;
	}
 }
 


 if (!function_exists('main_url')) {
	 function main_url(){
	$main_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
    $main_url .= '://'. $_SERVER['HTTP_HOST']."/";
	return $main_url;
 }

 }

/************************************************CCAvenue******************************************************************************/

function decrypt($encryptedText, $key)
{
    $key           = hextobin(md5($key));
    $initVector    = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText = hextobin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
}
/**
 * Function to encrypt
 * @param $plainText string
 * @param $key string
 * @return string
 */
function encrypt($plainText, $key)
{
    $key           = hextobin(md5($key));
    $initVector    = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode      = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    $encryptedText = bin2hex($openMode);
    return $encryptedText;
}

/*
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
$plainPad = pkcs5_pad($plainText, $blockSize);
if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) {
$encryptedText = mcrypt_generic($openMode, $plainPad);
mcrypt_generic_deinit($openMode);
}
return bin2hex($encryptedText);
}

function decrypt($encryptedText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
mcrypt_generic_init($openMode, $secretKey, $initVector);
$decryptedText = mdecrypt_generic($openMode, $encryptedText);
$decryptedText = rtrim($decryptedText, "\0");
mcrypt_generic_deinit($openMode);
return $decryptedText;
}*/

//*********** Padding Function *********************

function pkcs5_pad($plainText, $blockSize)
{
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********

function hextobin($hexString)
{
    $length    = strlen($hexString);
    $binString = "";
    $count     = 0;
    while ($count < $length) {
        $subString    = substr($hexString, $count, 2);
        $packedString = pack("H*", $subString);
        if ($count == 0) {
            $binString = $packedString;
        } else {
            $binString .= $packedString;
        }
        
        $count += 2;
    }
    return $binString;
}


	// sentence teaser
// this function will cut the string by how many words you want
function word_teaser($string, $count){
  $original_string = $string;
  $words = explode(' ', $original_string);
 
  if (count($words) > $count){
   $words = array_slice($words, 0, $count);
   $string = implode(' ', $words);
  }
 
  return $string;
}


function file_download($filepath){
	  if(file_exists($filepath)) {

            header('Content-Description: File Transfer');

            header('Content-Type: application/octet-stream');

            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');

            header('Expires: 0');

            header('Cache-Control: must-revalidate');

            header('Pragma: public');

            header('Content-Length: ' . filesize($filepath));

            flush(); // Flush system output buffer

            readfile($filepath);

            exit;

        }
	
}


function create_directory($dir_name){
    if(empty($dir_name)){
        $dir_name='uploads/'.date('m-Y').'/';
    }
    $dir = $dir_name;
    if(!file_exists($dir)){
        mkdir($dir , 0777, true);
    }else{
        $msg="Directory already exists!";
    }
    $newFileName = $dir."index.html";
    if(!file_exists($newFileName)){    
        $newFileContent = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
        if (file_put_contents($newFileName, $newFileContent) !== false) {
            $msg= "File created (" . basename($newFileName) . ")";
        } else {
            $msg= "Cannot create file (" . basename($newFileName) . ")";
        }
    }
    $data=array('msg'=>$msg,'dir'=>$dir);
    return $dir;
}

function download_file_url($url,$save_path,$file_name=''){
	$result=false;
	$file_url='';	
	create_directory($uploads_url);	
    $newfname = $save_path . $file_name;

    $file = fopen ($url, "rb");
    if ($file) {
      $newf = fopen ($newfname, "wb");

      if ($newf)
      while(!feof($file)) {
        fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
      }
    }

    if ($file) {
      fclose($file);
    }

    if ($newf) {
      fclose($newf);
	  $result=true;
	  $file_url=$newfname;
    }
	$value=array('result'=>$result,'file_url'=>$file_url);
	return $value;
}

function upload_report_file($url,$save_path,$file_name,$download_type){
	
	$status='fail';
	$file_url='';
	
	$ci =& get_instance();
    $uploads_data=$ci->db->get_where('web_settings',array('data_type'=>'interface_upload_url'))->row_array();
	$uploads_url=$uploads_data['data_value'];
	$post_fields=array('file_url' => $url,'file_folder'=>$save_path,'file_name'=>$file_name,'download_type'=>$download_type);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
	curl_setopt($ch, CURLOPT_URL, $uploads_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	$returnGroup['info'] = curl_getinfo($ch);
	$returnGroup['errno']= curl_errno($ch);
	$returnGroup['error']= curl_error($ch);
	$returnGroup['http_code']=$returnGroup['info']['http_code'];		
	curl_close($ch);
	$response=json_decode($response,true);
	//print_r($response);exit();
	//print_r($returnGroup);
	
	if(!empty($response['status']) && $response['status']=='success'){
		$status='success';
		$file_url=$response['file_url'];
	}
	$value=array('status'=>$status,'file_url'=>$file_url);
	return $value;
}

 function check_imageformat($str) {
        $allowed_mime_type_arr = array('application/octet-stream','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip');
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message('check_imageformat', 'Please select only /gif/jpg/png file.');
                return false;
            }
        } else {
            $this->form_validation->set_message('check_imageformat', 'Please choose a file to upload.');
            return false;
        }
    }



	
	
	
	if (!function_exists('randomPassword')) {
	
		function randomPassword($len = 8) {

    //enforce min length 8
    if($len < 8)
        $len = 8;

    //define character libraries - remove ambiguous characters like iIl|1 0oO
    $sets = array();
    $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    $sets[] = '23456789';
    $sets[]  = '~!@#$%^&*(){}[],./?';

    $password = '';
    
    //append a character from each set - gets first 4 characters
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
    }

    //use all characters to fill up to $len
    while(strlen($password) < $len) {
        //get a random set
        $randomSet = $sets[array_rand($sets)];
        
        //add a random char from the random set
        $password .= $randomSet[array_rand(str_split($randomSet))]; 
    }
    
    //shuffle the password string before returning!
    return str_shuffle($password);
	}
	
	
	}
	

	function humanTiming ($time)
        {

            $time = time() - $time; // to get the time since that moment
            $time = ($time<1)? 1 : $time;
            $tokens = array (
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second'
            );

            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
            }

        }
	function get_timing_tooltip($date)
    {
		$result = humanTiming(strtotime($date)).' ago <span data-toggle="tooltip" data-placement="top" title="'.date("M jS, Y h:i:s: A", strtotime($date)).'"><i class="fa fa-info-circle" aria-hidden="true"></i></span>';	   
		return $result;
    }


	function add_message_array($index_data,$message){
		$imp_data  = implode(',<br/>',$index_data);
		$result = preg_replace('/[ ,]+/', ' ', trim($imp_data));
		$msg = $message.'<br/>'.$result;
		return $msg;
	}
	

	function json_validate($string,$do_exit='')
	{
		// decode the JSON data
		$result = json_decode($string);

		// switch and check possible JSON errors
		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				$error = ''; // JSON is valid // No error has occurred
				break;
			case JSON_ERROR_DEPTH:
				$error = 'The maximum stack depth has been exceeded.';
				break;
			case JSON_ERROR_STATE_MISMATCH:
				$error = 'Invalid or malformed JSON.';
				break;
			case JSON_ERROR_CTRL_CHAR:
				$error = 'Control character error, possibly incorrectly encoded.';
				break;
			case JSON_ERROR_SYNTAX:
				$error = 'Syntax error, malformed JSON.';
				break;
			// PHP >= 5.3.3
			case JSON_ERROR_UTF8:
				$error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
				break;
			// PHP >= 5.5.0
			case JSON_ERROR_RECURSION:
				$error = 'One or more recursive references in the value to be encoded.';
				break;
			// PHP >= 5.5.0
			case JSON_ERROR_INF_OR_NAN:
				$error = 'One or more NAN or INF values in the value to be encoded.';
				break;
			case JSON_ERROR_UNSUPPORTED_TYPE:
				$error = 'A value of a type that cannot be encoded was given.';
				break;
			default:
				$error = 'Unknown JSON error occured.';
				break;
		}
		return $error;
	}


	function is_base64($s){
        // Check if there are valid base64 characters
       // if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;
        // Decode the string in strict mode and check the results
        $decoded = base64_decode($s, true);
        if(false === $decoded) return false;
        // Encode the string again
        if(base64_encode($decoded) != $s) return false;
        return true;
    }
    
    function du_uploads($path,$base64string){
        if(is_base64($base64string) == true){  
            $base64string = "data:image/jpeg;base64,".$base64string;
            $this->check_size($base64string);
            $this->check_dir($path);
            $this->check_file_type($base64string);
            
            /*=================uploads=================*/
            list($type, $base64string) = explode(';', $base64string);
            list(,$extension)          = explode('/',$type);
            list(,$base64string)       = explode(',', $base64string);
            $fileName                  = uniqid().date('Y_m_d').'.'.$extension;
            $base64string              = base64_decode($base64string);
            file_put_contents($path.$fileName, $base64string);
            return array('status' =>true,'message' =>'successfully upload !','file_name'=>$fileName,'with_path'=>$path.$fileName);
        }else{
            print_r(json_encode(array('status' =>false,'message' => 'This Base64 String not allowed !')));exit;
        }
    }
