<?php
	namespace SaWechat\processor;
	class ResponseSameContentProcessor extends AbstractProcessor{
		public function process(&$request, &$response) {
			$response['sendtype'] = 'text';
			$response['content'] = $request['content'];
		}
	}
