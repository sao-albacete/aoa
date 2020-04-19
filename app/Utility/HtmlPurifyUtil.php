<?php

//App::uses('HTMLPurifier', 'HTMLPurifier/library');

require_once APPLIBS . 'HtmlPurifier/library/HTMLPurifier.auto.php';

class HtmlPurifyUtil
{
	public static function purify($dirtyHtml) {

		$config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($dirtyHtml);
	}
}
