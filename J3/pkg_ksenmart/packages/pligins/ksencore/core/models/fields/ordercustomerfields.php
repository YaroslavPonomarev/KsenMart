<?php defined('_JEXEC') or die;

class JFormFieldOrderCustomerFields extends JFormField {
	
	protected $type = 'OrderCustomerFields';
	
	public function getInput() {
		$db = JFactory::getDBO();
		$session = JFactory::getSession();
		$shipping_id = $this->form->get('shipping_id');
		$html = '';
		
		$query = $db->getQuery(true);
		$query->select('*')->from('#__ksenmart_shipping_fields')->where('shipping_id=' . (int)$shipping_id)->where('position=' . $db->quote('customer'))->where('published=1')->order('ordering');
		$db->setQuery($query);
		$customer_fields = $db->loadObjectList();
		$html.= '<div class="positions">';
		if (count($customer_fields)) {
			
			foreach ($customer_fields as $customer_field) {
				$html.= '<div class="position">';
				if ($customer_field->system && isset($this->value[$customer_field->title])) $value = $this->value[$customer_field->title];
				elseif (!$customer_field->system && isset($this->value[$customer_field->id])) $value = $this->value[$customer_field->id];
				else $value = '';
				$name = $customer_field->system ? $customer_field->title : $customer_field->id;
				$customer_field->title = $customer_field->system ? JText::_('ksm_orders_order_field_' . $customer_field->title) : $customer_field->title;
				
				$html.= '	<label class="inputname">' . $customer_field->title . '</label>';
				if ($customer_field->type == 'select') {
					$query = $db->getQuery(true);
					$query->select('*')->from('#__ksenmart_shipping_fields_values')->where('field_id=' . $customer_field->id);
					$db->setQuery($query);
					$customer_field->values = $db->loadObjectList();
					$html.= '<select name="' . $this->name . '[' . $name . ']" class="sel">';
					
					foreach ($customer_field->values as $value) $html.= '<option value="' . $value->id . '" ' . ($value->id == $value ? 'selected' : '') . '>' . $value->title . '</option>';
					$html.= '</select>';
				} else {
					$html.= '<input type="text" class="inputbox" ' . ($customer_field->system == 1 ? 'id="customer_' . $name . '"' : '') . ' name="' . $this->name . '[' . $name . ']" value="' . $value . '">';
				}
				$html.= '</div>';
			}
		} else {
			$html.= '	<div class="position empty-position">';
			$html.= '		<h3>' . JText::_('KSM_ORDERS_ORDER_NO_CUSTOMERFIELDS') . '</h3>';
			$html.= '	</div>';
		}
		$html.= '</div>';
		
		return $html;
	}
}