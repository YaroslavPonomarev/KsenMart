<?php defined('_JEXEC') or die;

$view = JRequest::getVar('view', 'panel');
if (in_array('*', $params->get('views', array('settings'))) || in_array($view, $params->get('views', array('settings')))) {
	KSSystem::loadModuleFiles('mod_ks_settings_groups');
	require_once (dirname(__FILE__) . DS . 'helper.php');
	$forms = ModKSSettingsGroupsHelper::getForms();
	global $ext_prefix;
	
	require JModuleHelper::getLayoutPath('mod_ks_settings_groups', $params->get('layout', 'default'));
}