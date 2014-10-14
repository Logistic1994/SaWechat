<?php
	namespace SaWechat\core;
	class WechatDelayProcessor{
		public static function process(&$response){
			$host = '';// 需要转接的主机名
			$path = '';//需要转接的页面路径
			$fp = fsockopen($host, 80, $errno, $errstr, 30);
			$parameters = '?';
			$parameters .= urlencode('action').'='.urldecode($response['action']).
							'&'.urldecode('openid').'='.urldecode($response['tousername']);
			if(isset($response['extra'])){
				$extra = $response['extra'];
				foreach($extra as $key => $value){
					$parameters .= '&'.urlencode($key).'='.urldecode($value);
				}
			}
			$out = "GET /".$path.$parameters." / HTTP/1.1\r\n";
			$out .= "Host: ".$host."\r\n";
			$out .= "Connection: Close\r\n\r\n";
			fwrite($fp, $out);
			fclose($fp);
		}
	}

