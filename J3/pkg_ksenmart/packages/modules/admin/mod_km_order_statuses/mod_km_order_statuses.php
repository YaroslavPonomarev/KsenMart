<?php
defined( '_JEXEC' ) or die;

$view=JRequest::getVar('view','panel');
if (in_array('*',$params->get('views',array('orders')))|| in_array($view,$params->get('views',array('orders'))))
{
	KSSystem::loadModuleFiles('mod_km_order_statuses');
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php';
	$statuses=ModKSMOrderstatusesHelper::getStatuses();
	$layout=KSSystem::getModuleLayout('mod_km_order_statuses');
	require JModuleHelper::getLayoutPath('mod_km_order_statuses',$layout);
}
?>