<?php defined('_JEXEC') or die;

KSSystem::import('views.viewksadmin');
class KsenViewSeo extends JViewKSAdmin {
	
	function display($tpl = null) {
		$this->path->addItem(JText::_('ks_trade') , 'index.php?option=com_ksen&widget_type=trade&extension='.$this->state->get('extension'));
		$this->path->addItem(JText::_('ks_seo'));
		$this->seo_type = $this->state->get('seo_type');
		
		switch ($this->getLayout()) {
			case 'seourlvalue':
				$this->document->addScript(JURI::base() . 'components/com_ksen/assets/js/seourlvalue.js');
				$this->seourlvalue = $this->get('SeoURLValue');
				$this->title = JText::_('ks_seo_seourlvalue_editor');
			break;
			case 'seotitlevalue':
				$this->document->addScript(JURI::base() . 'components/com_ksen/assets/js/seotitlevalue.js');
				$this->seotitlevalue = $this->get('SeoTitleValue');
				$this->title = JText::_('ks_seo_seotitlevalue_editor');
			break;
			case 'seotext':
				$this->document->addScript(JURI::base() . 'components/com_ksen/assets/js/seotext.js');
				$model = $this->getModel();
				$model->form = 'seotext';
				$seotext = $model->getSeoText();
				$model->form = 'seotext'.$this->state->get('extension');
				$form = $model->getForm();
				if ($form) $form->bind($seotext);
				$this->title = JText::_('ks_seo_seotext_editor');
				$this->form = $form;
				$this->setLayout('seotext'.$this->state->get('extension'));
				break;
			default:
				$this->document->addScript(JURI::base() . 'components/com_ksen/assets/js/seo.js');
				
				switch ($this->seo_type) {
					case 'seo-texts-config':
						$this->items = $this->get('ListItems');
						$this->total = $this->get('Total');
					break;
					case 'seo-titles-config':
						$this->configs = $this->get('TitlesConfigs');
					break;
					case 'seo-meta-config':
						$this->configs = $this->get('MetaConfigs');
					break;
					case 'seo-urls-config':
						$this->configs = $this->get('UrlsConfigs');
					break;
				}
			}
			parent::display($tpl);
	}
}