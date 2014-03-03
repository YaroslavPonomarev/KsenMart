<?php
defined('JPATH_PLATFORM') or die;

class JKMForm extends JForm
{

	public static function getInstance($name, $data = null, $options = array(), $replace = true, $xpath = false)
	{
		$formname=explode('.',$name);
		$formname=$formname[count($formname)-1];
		
		$dispatcher = JDispatcher::getInstance();	
		$dispatcher->trigger('onBeforeGetForm'.$formname, array(&$this,&$name,&$data,&$options,&$replace,&$xpath));
		// Reference to array with form instances
		$forms = &self::$forms;

		// Only instantiate the form if it does not already exist.
		if (!isset($forms[$name]))
		{

			$data = trim($data);

			if (empty($data))
			{
				throw new Exception(JText::_('JLIB_FORM_ERROR_NO_DATA'));
			}

			// Instantiate the form.
			$forms[$name] = new JKMForm($name, $options);

			// Load the data.
			if (substr(trim($data), 0, 1) == '<')
			{
				if ($forms[$name]->load($data, $replace, $xpath) == false)
				{
					throw new Exception(JText::_('JLIB_FORM_ERROR_XML_FILE_DID_NOT_LOAD'));

					return false;
				}
			}
			else
			{
				if ($forms[$name]->loadFile($data, $replace, $xpath) == false)
				{
					throw new Exception(JText::_('JLIB_FORM_ERROR_XML_FILE_DID_NOT_LOAD'));

					return false;
				}
			}
		}
		$dispatcher->trigger('onAfterGetForm'.$formname, array(&$this,&$forms[$name]));

		return $forms[$name];
	}

	public function getLabel($name, $group = null)
	{
		$formname=$this->getName();
		$html='';
		
		$dispatcher = JDispatcher::getInstance();	
		$dispatcher->trigger('onBeforeGetFormLabel'.$formname.$name, array(&$this,&$name,&$html));
		if ($name!='empty' && $field = $this->getField($name, $group))
		{
			$html.=$field->label;
		}
		$dispatcher->trigger('onAfterGetFormLabel'.$formname.$name, array(&$this,&$name,&$html));

		return $html;
	}
	
	public function getInput($name, $group = null, $value = null)
	{
		$formname=$this->getName();
		$formname=explode('.',$formname);
		$formname=$formname[count($formname)-1];
		$html='';
		
		$dispatcher = JDispatcher::getInstance();	
		$dispatcher->trigger('onBeforeGetFormInput'.$formname.$name, array(&$this,&$name,&$html));
		if ($name!='empty' && $field = $this->getField($name, $group, $value))
		{
			$element=$this->findField($name, $group);
			$field_html=$field->input;
			if (isset($element['wrap']) && !empty($element['wrap']))
				$field_html=KMSystem::wrapFormField($element['wrap'],$element,$field_html);
			$html.=$field_html;
		}
		$dispatcher->trigger('onAfterGetFormInput'.$formname.$name, array(&$this,&$name,&$html));

		return $html;
	}

	public function findField($name, $group = null)	
	{
		return parent::findField($name, $group = null);
	}
	
}