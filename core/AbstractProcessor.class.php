<?php
	namespace SaWechat\processor;
	abstract class AbstractProcessor{
		abstract public function process(&$request, &$response);
	}