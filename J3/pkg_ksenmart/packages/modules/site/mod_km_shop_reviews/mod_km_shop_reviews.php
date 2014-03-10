<?php defined('_JEXEC') or die;

$dispatcher = JDispatcher::getInstance();
JPluginHelper::importPlugin('system');
$result = $dispatcher->trigger('onLoadKsen', array('ksenmart', array('common'), array(), array('angularJS' => 0)));
require_once(dirname(__file__) . '/helper.php');

$user            = KSUsers::getUser();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$km_params       = JComponentHelper::getParams('com_ksenmart');
$reviews         = ModuleKm_Shop_ReviewsHelper::getData($params);

if($km_params->get('modules_styles', true)){
    $document = JFactory::getDocument();
    $document->addStyleSheet(JURI::base().'modules/mod_km_shop_reviews/css/mod_km_shop_reviews.css');
}

require(JModuleHelper::getLayoutPath('mod_km_shop_reviews', $params->get('layout', 'default')));