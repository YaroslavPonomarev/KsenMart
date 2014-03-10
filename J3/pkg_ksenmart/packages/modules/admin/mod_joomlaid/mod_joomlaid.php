<script>
    var root = '<?php echo JURI::base(); ?>';
</script>
<?php defined('_JEXEC') or die;

    $document = JFactory::getDocument();
    $document->addStyleSheet(JURI::base().'modules/mod_joomlaid/css/default.css');
    $document->addStyleSheet(JURI::base().'modules/mod_joomlaid/css/jquery.Jcrop.min.css');
    
    $document->addScript(JURI::base() . 'modules/mod_joomlaid/js/jquery.Jcrop.min.js', 'text/javascript', true);
    $document->addScript(JURI::base() . 'modules/mod_joomlaid/js/default.js', 'text/javascript', true);
    
    global $ext_name_com, $ext_name;

    $current_ext_name       = $ext_name;
    $current_ext_name_com   = $ext_name_com;
    $ext_name               = 'ksenmart';
    $ext_name_com           = 'com_ksenmart';

    $account     = KSSystem::getController('account');
    if(!$account->checkAuthorize()){
        require_once dirname(__FILE__).'/tmpl/login.php';
    }else{
        $account_info = $account->getAccountInfo();
        require_once dirname(__FILE__).'/tmpl/default.php';
    }

    $ext_name     = $current_ext_name;
    $ext_name_com = $current_ext_name_com;
?>