<?php defined('_JEXEC') or die;

$view = JRequest::getVar('view', 'panel');
if (in_array('*', $params->get('views', array('comments'))) || in_array($view, $params->get('views', array('comments')))) {
	KSSystem::loadModuleFiles('mod_km_commentrates');
	require_once dirname(__FILE__) . DS . 'helper.php';
	$rates = ModKMCommentRatesHelper::getRates();
	$layout = KSSystem::getModuleLayout('mod_km_commentrates');
	require JModuleHelper::getLayoutPath('mod_km_commentrates', $layout);
}
