<?php defined('_JEXEC') or die;

class ModKMSettingsGroupsHelper {
	
	public static function getForms() {
		$forms = array();
		if (!class_exists('KsenMartModelSettings')) require_once JPATH_ADMINISTRATOR . '/components/com_ksenmart/models/settings.php';
		$model = new KsenMartModelSettings();
		$forms = $model->getForm();
		
		return $forms;
	}
}