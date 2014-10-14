<?php
/**
 *  cache文件保存方式自行修改
 */
	namespace SaWechat\tool;
	final class WeixinTool{
		private $app_access_token;
		private $domain_name = 'librarycache';
		private $stor;
		public function __construct(){
			$this->stor = new \SaeStorage();
			if($this->stor->fileExists($this->domain_name, $this->cache_file)){
				$token_info = $this->getTokenFromCache();
				if($token_info['get_time'] + $token_info['expires_in'] <= time()){
					var_dump($token_info);
					echo '现在时间为:'.time();
					echo '需要更新';
					$token_info_new = $this->getTokenFromNet();
					$this->app_access_token = $token_info_new['access_token'];
					$this->saveTokenToCache($token_info_new);
				}else{
					echo '不需要更新';
					var_dump($token_info);
					echo '现在时间为:'.time();
					$this->app_access_token = $token_info['access_token'];
				}
			}else{
				echo '没有文件';
				$token_info_new = $this->getTokenFromNet();
				$this->app_access_token = $token_info_new['access_token'];
				$this->saveTokenToCache($token_info_new);
			}
		}
		
		private function getTokenFromCache(){
			$token_from_cache = unserialize($this->stor->read($this->domain_name, $this->cache_file));
			return $token_from_cache;
		}
		
		private function getTokenFromNet(){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->app_id}&secret={$this->app_secret}";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_HEADER,false);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			$res = curl_exec($ch);
			curl_close($ch);
			$j = json_decode($res,true);
			return $j;
		}
		
		private function saveTokenToCache($token){
			$token['get_time'] = time();
			$output = serialize($token);
			$this->stor->write($this->domain_name, $this->cache_file, $output);
		} 
		
		public function response(&$response){
			$openid = $response['openid'];
			$sendtype = $response['sendtype'];
			switch ($sendtype){
				case 'text':
					$this->sendText($openid, $response['content']);
					break;
			}
		}
		private function sendText($openid,$content){
			$content = urlencode($content);
			$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->app_access_token}";
			$message = array("touser" => $openid,
							"msgtype" => "text",
							"text" => array("content" => $content));
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_HEADER,false);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,urldecode(json_encode($message)));
			$res = curl_exec($ch);
			curl_close($ch);
		}
	}