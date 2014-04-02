<?php defined('_JEXEC') or die;

if (!class_exists('KMPlugin')) {
	require (JPATH_ROOT . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_ksenmart' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'kmplugin.php');
}

abstract class KSMShippingPlugin extends KMPlugin {
	
	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
	}
	
	function checkRegion($regions, $region_id) {
		$regions = json_decode($regions, true);
		
		foreach ($regions as $country) if (in_array($region_id, $country)) 
		return true;
		
		return false;
	}
}
