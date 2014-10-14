<?php
/**
 *  调用入口
 */
	namespace SaWechat;
	
	ini_set('display_errors', false); 
	
	require_once 'constant.php';
	require_once 'include.php';
	
	use SaWechat\core\WechatListener;
	
	$listener = new WechatListener(WECHAT_TOKEN, true);
	$listener->run();