<?php defined( '_JEXEC' ) or die;

KSSystem::import('views.viewksadmin');
class  KsenMartViewUpdater extends JViewKSAdmin
{

    function display($tpl = null)
    {
		$this->document->addScript(JURI::base().'components/com_ksenmart/js/updater.js');		
		$this->path->addItem(JText::_('updater'));
		$updates=KMUpdaterFunctions::getUpdates();
		$this->assignRef('updates', $updates);
		parent::display($tpl);
    }        
        
}