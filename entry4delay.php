<?php
/**
 *  当3秒钟内处理事件不足时可以使用fsockopen不接受结果地调用此php
 */
	namespace SaWechat;
	ini_set('display_errors', false); 
	require_once 'constant.php';
	require_once 'include4delay.php';
	use SaWechat\delayprocessor as DProc;
	use SaWechat\tool\WeixinTool;
	if(isset($_GET['action']) && isset($_GET['openid'])){
		$action = $_GET['action'];
		$openid = $_GET['openid'];
	}else{
		exit();
	}
	$extra = array();
	switch ($action){
		case 'responsesamecontent':
			$proc = new DProc\ResponseSameContentDprocessor();
			$extra['content'] = $_GET['content'];
			break;
		default :
			exit();
	}
	$response = array("openid" => $openid);
	$proc->process($openid, $extra, $response);
	$weixitool = new WeixinTool();
	$weixitool->response($response);