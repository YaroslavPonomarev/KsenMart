<?php defined( '_JEXEC' ) or die;

KSSystem::import('views.viewksadmin');
class  KsenMartViewCountries extends JViewKSAdmin
{

    function display($tpl = null)
    {
		$this->path->addItem(JText::_('ksm_trade'),'index.php?option=com_ksenmart&view=panel&component_type=trade');
		$this->path->addItem(JText::_('ksm_countries'));
		switch ($this->getLayout())
		{
            case 'region':
                $this->document->addScript(JURI::base() . 'components/com_ksenmart/js/region.js');
                $model = $this->getModel();
                $region = $model->getRegion();
				$model->form='region';
                $form = $model->getForm();
                if ($form) $form->bind($region);
                $this->title = JText::_('ksm_countries_region_editor');
                $this->form=$form;
                break;		
            case 'country':
                $this->document->addScript(JURI::base() . 'components/com_ksenmart/js/country.js');
                $model = $this->getModel();
                $country = $model->getCountry();
				$model->form='country';
                $form = $model->getForm();
                if ($form) $form->bind($country);
                $this->title = JText::_('ksm_countries_country_editor');
                $this->form=$form;
                break;		
			default:
				$this->document->addScript(JURI::base().'components/com_ksenmart/js/jquery.custom.min.js');
				$this->document->addScript(JURI::base().'components/com_ksenmart/js/list.js');
				$this->document->addScript(JURI::base().'components/com_ksenmart/js/listmodule.js');
				$this->items=$this->get('ListItems');
				$this->total=$this->get('Total');
		}	
        parent::display($tpl);
    }

}