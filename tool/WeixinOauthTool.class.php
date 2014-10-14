<?php
	namespace SaWechat\tool;
	class WeixinOauthTool{
		public static function getCode($redirect_uri, $state=1, $scope='snsapi_base'){
			//公众号的唯一标识
			$appid = WECHAT_APPID;
			//授权后重定向的回调链接地址，请使用urlencode对链接进行处理
			$redirect_uri = 'http://'.WECHAT_HOST.$redirect_uri;
			$redirect_uri = urlencode($redirect_uri);
			//返回类型，请填写code
			$response_type = 'code';
			$state = WECHAT_OAUTH_STATE;
			//构造请求微信接口的URL
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=$state#wechat_redirect";
			header('Location: '.$url, true, 301);
		}
		
		public static function getOpenId($code){
			//公众号的唯一标识
			$appid = WECHAT_APPID;
			//公众号的appsecret
			$secret = WECHAT_SECRET;
			//填写为authorization_code
			$grant_type = 'authorization_code';
			//构造请求微信接口的URL
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$data = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($data, TRUE);
			return $data['openid'];
		}
	}
