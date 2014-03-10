<?php defined('_JEXEC') or die;

KSSystem::import('views.viewksadmin');
class KsenMartViewSettings extends JViewKSAdmin {
    
    function display($tpl = null) {
        $this->path->addItem(JText::_('KS_SETTINGS'));
        $form = $this->get('Form');
        $component = $this->get('Component');
        
        foreach ($form as $name => $f) {
            if ($f && $component->params) {
                $form[$name]->bind($component->params);
            }
        }
        $this->form = $form;
        $this->component = $component;
        parent::display($tpl);
    }
}