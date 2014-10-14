<?php
	namespace SaWechat\delayprocessor;
	abstract class AbstractDprocessor{
		abstract public function process($openid, $extra, &$response);
	}
