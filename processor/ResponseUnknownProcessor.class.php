<?php
	namespace SaWechat\processor;
	class ResponseUnknownProcessor extends AbstractProcessor{
		public function process(&$request, &$response) {
			$response['sendtype'] = 'text';
			$response['content'] = '该内容未知或者已经被删除！';
		}
	}
