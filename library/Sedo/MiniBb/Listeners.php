<?php

class Sedo_MiniBb_Listeners
{
	/***
	 * Template helper - minibb
	 **/
	public static function init_helpers(XenForo_Dependencies_Abstract $dependencies, array $data)
	{
		if(!isset(XenForo_Template_Helper_Core::$helperCallbacks['minibb']))
		{
			XenForo_Template_Helper_Core::$helperCallbacks += array(
				'minibb' => array('Sedo_MiniBb_Template_Helper_Base', 'create')
			);
		}
	}
}