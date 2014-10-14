<?php
	namespace SaWechat\core;
	class WechatResponse{
		public static function response(&$response){
			switch($response['sendtype']){
				case 'text':
					self::rspText($response);
					break;
				case 'image':
					self::rspImage($response);
					break;
				case 'news':
					self::rspNews($response);
					break;
			}
		}
		
		private static function rspText(&$response){
			$template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>
XML;
			echo sprintf($template,
					$response['tousername'], $response['fromusername'],
					time(), $response['content']);
		}
		
		private static function rspImage(&$response){
			$template = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    <Image>
    <MediaId><![CDATA[%s]]></MediaId>
    </Image>
</xml>
XML;
        echo sprintf($template,
				$response['tousername'], $response['tousername'], 
				time(), $response['mediaid']);
		}
		
		private static function rspNews(&$response){
			$template = <<<XML
<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[news]]></MsgType>
	<ArticleCount>%d</ArticleCount>
	<Articles>%s</Articles>
</xml>
XML;
			$count = count($response['newscontent']);
			$articles = '';
			for($i = 0;$i < $count;$i++){
				$onenews = $response['newscontent'][$i];
				$articles .= self::buildNewsItem($onenews['title'], $onenews['description'],
						$onenews['picurl'], $onenews['url']);
			}
			
			echo sprintf($template, 
					$response['tousername'], $response['fromusername'],
					time(), $count, $articles);
		}
		
		private static function buildNewsItem($title, $description,
												$picurl, $url){
			$templateItem = <<<XML
<item>
	<Title><![CDATA[%s]]></Title>
	<Description><![CDATA[%s]]></Description>
	<PicUrl><![CDATA[%s]]></PicUrl>
	<Url><![CDATA[%s]]></Url>
</item>
XML;
			return sprintf($templateItem, $title, $description, $picurl, $url);
		}
	}

