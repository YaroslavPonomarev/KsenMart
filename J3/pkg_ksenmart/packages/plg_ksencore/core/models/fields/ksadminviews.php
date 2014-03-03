<?php defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list');
class JFormFieldKSAdminViews extends JFormFieldList {
	
	public $type 		= 'KSAdminViews';
	private $extension 	= null;
	
	function getOptions() {
		$this->extension  	= !empty($this->element['extension'])?$this->element['extension']:null;
		$lang 				= JFactory::getLanguage();
		$lang->load('com_' . $this->extension . '.sys', JPATH_ADMINISTRATOR . '/components/com_' . $this->extension, null, false, false);
		$items 				= self::getViews();
		
		return $items;
	}
	
	function getViews() {
		$items 	 = array();
		$items[] = JHtml::_('select.option', '*', JText::_('JALL'));
		$views 	 = scandir(JPATH_ROOT . '/administrator/components/com_' . $this->extension . '/views/');
		
		foreach ($views as $view){
			if ($view != '.' && $view != '..' && is_dir(JPATH_ROOT . '/administrator/components/com_' . $this->extension . '/views/' . $view)){
				$items[] = JHtml::_('select.option', $view, JText::_($view));
			}
		}
		
		return $items;
	}
}