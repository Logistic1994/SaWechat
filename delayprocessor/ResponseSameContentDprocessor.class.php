<?php
	namespace SaWechat\delayprocessor;
	
	class ReborrowAllDprocessor extends AbstractDprocessor{
		public function process($openid, $extra, &$response){
			$response['sendtype'] = 'text';
			$response['content'] = $extra['content'];
		}
	}