<?php

App::uses('AppHelper', 'View/Helper');
App::uses('HtmlPurifyUtil', 'Utility');

class HtmlPurifyHelper extends AppHelper
{
	public function purify($dirtyHtml)
	{
		return HtmlPurifyUtil::purify($dirtyHtml);
	}
}
