<?php 
defined( '_JEXEC' ) or die;

if (!class_exists('KsenmartTable')){
	require JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'tables' .DIRECTORY_SEPARATOR.'ksenmart.php' ;
}

class KsenmartTableDiscounts extends KsenmartTable
{

	function __construct(&$_db)
	{
		parent::__construct('#__ksenmart_discounts', 'id', $_db);
	}


	function bind($src, $ignore=array()){
		return parent::bind($src, $ignore);
	}
	
}