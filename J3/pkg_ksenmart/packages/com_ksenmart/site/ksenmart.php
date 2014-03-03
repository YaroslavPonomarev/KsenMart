<?php defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

$dispatcher = JDispatcher::getInstance();
JPluginHelper::importPlugin('system');
$result  = $dispatcher->trigger('onLoadKsen', array('ksenmart.KSM', array('common'), array(), array('angularJS' => 0)));
KSLoader::loadLocalHelpers(array('common'));
$results = $dispatcher->trigger('onBeforeStartComponent',array());

if (!class_exists('KsenmartHtmlHelper')) {
	require JPATH_ROOT.DS.'components'.DS.'com_ksenmart'.DS. 'helpers'.DS.'head.php';
	KsenmartHtmlHelper::AddHeadTags();
}

$controller = JController::getInstance('KsenMart');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();