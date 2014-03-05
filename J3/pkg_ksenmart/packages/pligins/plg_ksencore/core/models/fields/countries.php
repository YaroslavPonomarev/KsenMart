<?php 
defined( '_JEXEC' ) or die;
JFormHelper::loadFieldClass('checkboxes');

class JFormFieldCountries extends JFormFieldCheckboxes{
	
	protected $type = 'Countries';
	
	public function getInput(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*')->from('#__ksenmart_countries')->order('ordering');
		$db->setQuery($query);
		$countries = $db->loadObjectList('id');
		
		$html = '<ul>';
		if (count($countries)>0)
		{
			foreach($countries as $country){
				$checked = '';
				$active ='';				
				if (in_array($country->id,$this->value)) { 
					$checked = ' checked="checked" ';
					$active = ' active ';
				}
				$html.='<li class="'.$active.'">';
				$html.='<label>'.JText::_($country->title).'<input type="checkbox" '.$checked.' value="'.$country->id.'" name="'.$this->name.'" onclick="'.$this->element['onclick'].'" /></label>';
				$html.='</li>';
			}
		}
		else
		{
			$html.='<li>';
			$html.='<label>'.JText::_('ksm_countries_no_countries').'</label>';
			$html.='</li>';		
		}
		$html.='</ul>';
		$html=KSSystem::wrapFormField($this->element,$html);
		return $html;
	}
	
}