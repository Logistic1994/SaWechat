<?php
	namespace SaWechat\core;
	use SaWechat\processor as Proc;
	final class WechatDispatcher{
		public static function dispatch(&$request){
			$msgtype = $request['msgtype'];
			$proc = NULL;
			switch ($msgtype){
				case 'event':
					$event = $request['event'];
					switch ($event){
						case 'subscribe':
							$proc = new Proc\ResponseUnknownProcessor();
						break;
						case 'unsubscribe':
							$proc = new Proc\ResponseUnknownProcessor();
						break;
						case 'CLICK':
							$proc = self::handleMenu($request);
						break;
						case 'VIEW':
						case 'LOCATION':
							$proc = new Proc\ResponseUnknownProcessor();
						break;
						default:
							$proc = new Proc\ResponseUnknownProcessor();
						break;
					} 
				break;
				case 'location':
					$proc = new Proc\ResponseUnknownProcessor();
				break;
				case 'text':
					$proc = self::handleText($request);
				break;
				case 'image':
					$proc = new Proc\ResponseUnknownProcessor();
				break;
				default:
					$proc = new Proc\ResponseUnknownProcessor();
				break;
			}
			return $proc;
		}
		
		private static function handleMenu(&$request){
			$eventKey = $request['eventkey'];
			$proc = NULL;
			switch($eventKey){
				default:
					$proc = new Proc\ResponseUnknownProcessor();
				break;
			}
			return $proc;
		}
		
		private static function handleText(&$request){
			$proc = new Proc\ResponseUnknownProcessor();
			return $proc;
		}
	}