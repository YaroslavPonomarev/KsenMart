<?php defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

$dispatcher = JDispatcher::getInstance();
$dispatcher->trigger('onLoadKsen', array('ksenmart', array('common'), array(), array('angularJS' => 0)));
$dispatcher->trigger('onBeforeStartComponent',array());

if (!class_exists('KsenmartHtmlHelper')) {
	require JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_ksenmart'.DIRECTORY_SEPARATOR. 'helpers'.DIRECTORY_SEPARATOR.'head.php';
}
KsenmartHtmlHelper::AddHeadTags();

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_ksenmart/css/style.css');
$document->addScript(JURI::base().'components/com_ksenmart/js/style.js');

$controller = JControllerLegacy::getInstance('KsenMart');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();