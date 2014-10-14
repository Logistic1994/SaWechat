<?php
namespace SaWechat\core;
use SaWechat\core\WechatDispatcher;
use SaWechat\core\WechatDelayProcessor;
final class WechatListener{
    private $request;
    private $debug;
    public function __construct($token, $debug = false){
		if($this->isValid() && $this->validateSignature($token)){
			exit($_GET['echostr']);
		}
		$xml = (array) simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
		$this->request = array_change_key_case($xml,CASE_LOWER);
		$this->debug = $debug;
    }
    private function isValid(){
		return isset($_GET['echostr']);
    }
    private function validateSignature($token){
		$signature = $_GET['signature'];
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];
		$signatureArray = array($token,$timestamp,$nonce);
		sort($signatureArray);	
		return sha1(implode($signatureArray)) == $signature;
    }
		
    public function run(){
		set_error_handler(array($this, 'error_handle'));
		
		$processor = WechatDispatcher::dispatch($this->request);
		
		$response = array();
		$response['fromusername'] = $this->request['tousername'];
		$response['tousername'] = $this->request['fromusername'];
		
		$processor->process($this->request, $response);
		WechatResponse::response($response);
		// 此任务需要延迟操作
		if(isset($response['needDelay']) && $response['needDelay'] === true){
			WechatDelayProcessor::process($response);
		}
    }
    
	public function error_handle($errno, $errstr, $errfile, $errline){
		if($this->debug){
			$message = "ERROR:[$errno]:$errstr\n"
				. "	Fatal error in line $errline in file $errfile";
		}else{
			$message = "Internal Error!";
		}
		$response = array();
		$response['fromusername'] = $this->request['tousername'];
		$response['tousername'] = $this->request['fromusername'];
		$response['sendtype'] = 'text';
		$response['content'] = $message;
		WechatResponse::response($response);
		exit();
	}
}