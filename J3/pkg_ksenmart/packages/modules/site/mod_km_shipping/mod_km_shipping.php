<?php defined('_JEXEC') or die;

$dispatcher = JDispatcher::getInstance();
JPluginHelper::importPlugin('system');
$result = $dispatcher->trigger('onLoadKsen', array('ksenmart', array('common'), array(), array('angularJS' => 0)));

if(!class_exists('KsenMartModelProfile')){
    include (JPATH_ROOT . '/components/com_ksenmart/models/profile.php');
}

require_once(dirname(__file__) . '/helper.php');

$shippings   = ModKSMShippingHelper::getShippings();
$session     = JFactory::getSession();
$user_region = $session->get('user_region', KSUsers::getUser()->region_id);
$model       = new KsenMartModelProfile();
$km_params   = JComponentHelper::getParams('com_ksenmart');

if($km_params->get('modules_styles', true)) {
    $document = JFactory::getDocument();
    $document->addScript(JURI::base() . 'modules/mod_km_shipping/js/mod_km_shipping.js');
}

$regions   = $model->getRegions();
$shippings = $model->getShippingsByRegionId($user_region);
$payments  = $model->getPaymentsByRegionId($user_region);

require(JModuleHelper::getLayoutPath('mod_km_shipping', $params->get('layout', 'default')));