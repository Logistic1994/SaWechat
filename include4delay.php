<?php
	namespace SaWechat;
	require_once 'library/ReaderManager.class.php';
	require_once 'core/AbstractDprocessor.class.php';
	require_once 'util/Encrypt.class.php';
	require_once 'util/Mysqli.class.php';
	function class_search_delay($classname){
		$names = explode('\\', $classname);
		$classname = end($names);
		if(substr($classname, -10) == 'Dprocessor'){
			require_once 'delayprocessor/'.$classname.'.class.php';
		}else if(substr($classname, -4) == 'Tool'){
			require_once 'tool/'.$classname.'.class.php';
		}
	}
	spl_autoload_register('SaWechat\class_search_delay');
