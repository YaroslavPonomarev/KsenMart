<?php defined('_JEXEC') or die;
/**
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Ksencore
 * @since       2.5+
 * @author      TakT
 */
class plgSystemKsenCore extends JPlugin {
    /**
     * Class Constructor
     * @param object $subject
     * @param array $config
     */
    public function __construct(&$subject, $config) {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }
    
    public function onLoadKsen($ext_name_local, array $hFolders = array() , array $ignoreHelpers = array() , array $config = array()) {
        global $ext_name, $ext_name_com, $ext_prefix;
        
        $ext_name = $ext_name_local;
        if (strripos($ext_name_local, '.') !== false) {
            list($ext_name, $ext_prefix) = explode('.', $ext_name_local);
        }
        
        $ext_name_com = 'com_' . $ext_name;
        $document = JFactory::getDocument();
        
        include_once dirname(__FILE__) . '/core/defines.php';
        include_once KSC_ADMIN_PATH_CORE_HELPERS . 'helper.php';
        
        KSLoader::loadCoreHelpers($hFolders, $ignoreHelpers);
        
        if (!isset($config['admin'])) {
            $config['admin'] = false;
        }
        
        JHtml::_('jquery.framework');
        JHtml::_('jquery.ui');
        
        if ($config['admin']) {
            KSSystem::addCSS(array(
                'style',
                'prog-style',
                'nprogress',
                'ui-lightness/jquery-ui-1.8.20.custom'
            ));
            JHtml::_('jquery.ui', array('sortable'));
            //$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js');
            KSSystem::addJS(array('common', 'style', 'nprogress',  'list', 'listmodule'));
            
        }
        
        if ($this->params->get('angularJS', 1) && $config['angularJS']) {
            
            KSSystem::addJS(array(
                'hammer.min'
            ));
            $document->addScript('//ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.js');
            
            KSSystem::addCSS(array('ng-table'));
            KSSystem::addJS(array(
                'angular-ui-router.min',
                'angular-animate',
                'angular-sanitize',
                'angular-file-upload',
                'directive/a',
                'angular-hammer',
                'ngRepeatReorder'
            ));
        }
        
        $script = '
            var KS = {
                extension: \'' . $ext_name_com . '\'
            };
        ';
        $document->addScriptDeclaration($script);
        
        KSSystem::loadPlugins();
    }
}