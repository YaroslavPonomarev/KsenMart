<?php defined('_JEXEC') or die;

class ModKSMainMenuHelper {
    
    public static function getCurrentWidget() {
        global $ext_name;
        $jinput = JFactory::getApplication()->input;
        $view = $jinput->get('view', 'panel', 'string');
        if ($view == 'panel') 
        return false;
        if ($view == 'account') {
            $view = $jinput->get('layout', null, 'string');
        }
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__' . $ext_name . '_widgets')->where('name=' . $db->quote($view));
        $db->setQuery($query);
        $current_widget = $db->loadObject();
        
        return $current_widget;
    }
    
    public static function getParentWidget($current_widget) {
        global $ext_name;
        if (!$current_widget) 
        return false;
        if ($current_widget->parent_id == 0) 
        return $current_widget;
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__' . $ext_name . '_widgets')->where('id=' . $current_widget->parent_id);
        $db->setQuery($query);
        $parent_widget = $db->loadObject();
        
        return $parent_widget;
    }
    
    public static function getChildWidgets($parent_widget) {
        global $ext_name;
        if (!$parent_widget) 
        return false;
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__' . $ext_name . '_widgets')->where('parent_id=' . $parent_widget->id);
        $db->setQuery($query);
        $child_widgets = $db->loadObjectList();
        
        return $child_widgets;
    }
    
    public static function getCurrentWidgetType($parent_widget) {
        global $ext_name_com;
        $app = JFactory::getApplication();
        $current_widget_type = $app->getUserStateFromRequest($ext_name_com . '.panel.default.widget_type', 'widget_type', 'all');
        
        return $current_widget_type;
    }
    
    public static function getWidgetTypes() {
        global $ext_name;
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__' . $ext_name . '_widgets_types')->where('published=1');
        $db->setQuery($query);
        $widget_types = $db->loadObjectList();
        
        return $widget_types;
    }
}
