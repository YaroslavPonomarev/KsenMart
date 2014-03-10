<?php defined('_JEXEC') or die;

KSSystem::import('views.viewksadmin');
class KsenMartViewPanel extends JViewKSAdmin {

    public function display($tpl = null) {
		$widget_type=$this->state->get('widget_type');
		if ($widget_type!='all')
			$this->path->addItem(JText::_('ksm_'.$widget_type));
        $this->document->addScript(JURI::base().'components/com_ksenmart/js/jquery.mousewheel.min.js');
        $this->document->addScript(JURI::base().'components/com_ksenmart/js/jquery-ui.js');
        $this->document->addScript(JURI::base().'components/com_ksenmart/js/panel.js');
        $this->widgets_groups = $this->get('Widgets');
        parent::display($tpl);
    }
}