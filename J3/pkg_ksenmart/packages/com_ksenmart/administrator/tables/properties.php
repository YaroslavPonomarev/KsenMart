<?php 
defined( '_JEXEC' ) or die;

if (!class_exists('KsenmartTable')){
	require JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'tables' .DIRECTORY_SEPARATOR.'ksenmart.php' ;
}

class KsenmartTableProperties extends KsenmartTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__ksenmart_properties', 'id', $_db);
		//$date = JFactory::getDate();
		
	}


	function bind($src, $ignore=array()){
		return parent::bind($src, $ignore);
	}
	
	
	
}
