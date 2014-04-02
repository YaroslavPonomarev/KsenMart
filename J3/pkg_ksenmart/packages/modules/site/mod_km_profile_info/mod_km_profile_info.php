<?php defined('_JEXEC') or die;

if(!JFactory::getUser()->get('guest')) {
    
    $dispatcher = JDispatcher::getInstance();
    JPluginHelper::importPlugin('system');
    $result = $dispatcher->trigger('onLoadKsen', array('ksenmart', array('common'), array(), array('angularJS' => 0)));
    
    if (!class_exists('KsenmartHtmlHelper')) {
        require JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_ksenmart'.DIRECTORY_SEPARATOR. 'helpers'.DIRECTORY_SEPARATOR.'head.php';
        KsenmartHtmlHelper::AddHeadTags();
    }
    
    $km_params = JComponentHelper::getParams('com_ksenmart');
    if($km_params->get('modules_styles', true)){
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::base().'modules/mod_km_profile_info/css/default.css');
    }
    
    require JModuleHelper::getLayoutPath('mod_km_profile_info', $params->get('layout', 'default'));
}