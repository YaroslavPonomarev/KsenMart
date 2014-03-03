<?php defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');
class JFormFieldKSCategories extends JFormFieldList {

    protected $type     = 'KSCategories';
    private $extension  = null;

    protected function getOptions() {
        // Initialise variables.
        $options            = array();
        $this->extension   = !empty($this->element['extension'])?$this->element['extension']:null;

        $options = $this->getCategories(0, 0, array());
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    private function getCategories($parent = 0, $level, $items) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from('#__' . $this->extension . '_categories')
            ->where('published=1')
            ->where('parent_id=' . $db->getEscaped($parent))
            ->order('ordering')
        ;
        
        $db->setQuery($query);
        $cats = $db->loadObjectList();
        foreach($cats as $cat) {
            $cat->title = str_repeat('- ', $level) . $cat->title;
            $items[]    = JHtml::_('select.option', $cat->id, $cat->title);
            $items      = $this->getCategories($cat->id, $level + 1, $items);
        }
        return $items;
    }
}