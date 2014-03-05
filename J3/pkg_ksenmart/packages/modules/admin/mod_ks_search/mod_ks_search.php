<?php defined('_JEXEC') or die;

$view = JRequest::getVar('view', 'panel');
if (in_array('*', $params->get('views', array('images'))) || in_array($view, $params->get('views', array('images')))) {
    KSSystem::loadModuleFiles('mod_ks_search');
    require_once dirname(__file__) . DS . 'helper.php';
    $searchword = ModKSSearchHelper::getSearchWord();
    require JModuleHelper::getLayoutPath('mod_ks_search', $params->get('layout', 'default'));
}