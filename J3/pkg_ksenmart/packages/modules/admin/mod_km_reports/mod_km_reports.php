<?php defined('_JEXEC') or die;

$view = JRequest::getVar('view', 'panel');
if (in_array('*', $params->get('views', array('reports'))) || in_array($view, $params->get('views', array('reports')))) {
	KSSystem::loadModuleFiles('mod_km_reports');
	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper.php';
	$reports = ModKMReportsHelper::getReports();
	require JModuleHelper::getLayoutPath('mod_km_reports', $params->get('layout', 'default'));
}