<?php defined('_JEXEC') or die;

$view = JRequest::getVar('view', 'panel');
if (in_array('*', $params->get('views', array('*'))) || in_array($view, $params->get('views', array('*')))) {
	KSSystem::loadModuleFiles('mod_km_path');
	$path = KSPath::getInstance();
	require JModuleHelper::getLayoutPath('mod_km_path', $params->get('layout', 'default'));
}