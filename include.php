<?php
/**
 *  一次导入
 */
	namespace SaWechat;
	
	require_once 'core/WechatListener.class.php';
	require_once 'core/WechatDispatcher.class.php';
	require_once 'core/WechatResponse.class.php';
	require_once 'core/WechatDelayProcessor.class.php';
	require_once 'library/ReaderManager.class.php';
	
	require_once 'core/AbstractProcessor.class.php';
	
	require_once 'util/Encrypt.class.php';
	require_once 'util/Mysqli.class.php';
	
	//懒惰加载
	function class_search($classname){
		$names = explode('\\', $classname);
		$classname = end($names);
		if(substr($classname, -9) == 'Processor'){
			require_once 'processor/'.$classname.'.class.php';
		}else if(substr($classname, -4) == 'Tool'){
			require_once 'tool/'.$classname.'.class.php';
		}
	}
	spl_autoload_register('SaWechat\class_search');