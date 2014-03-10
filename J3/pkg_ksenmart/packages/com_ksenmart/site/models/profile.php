<?php defined('_JEXEC') or die;

KSSystem::import('models.modelkslist');
jimport('joomla.html.pagination');

/**
 * KsenMartModelProfile
 * 
 * @package
 * @copyright KsenMart
 * @version 2013
 * @access public
 */
class KsenMartModelProfile extends JModelKSList {

    var $_db        = null;
    var $_total     = null;
    var $_params    = null;
    var $_context   = 'com_ksenmart';

    /**
     * KsenMartModelProfile::__construct()
     * 
     * @return
     */
    public function __construct() {
        $this->_params = JComponentHelper::getParams('com_ksenmart');
        parent::__construct();
        
        $this->_limit = $this->_params->get('site_product_limit', 30);
    }
    
    protected function populateState($ordering = null, $direction = null){
        $this->onExecuteBefore('populateState', array(&$this));
        $this->onExecuteAfter('populateState', array(&$this));
    }
    
    /**
     * KsenMartModelProfile::getRegions()
     * 
     * @return
     */
    public function getRegions() {
        $this->onExecuteBefore('getRegions');
        
        $query = $this->_db->getQuery(true);
        $query
            ->select('
                r.id,
                r.title,
                r.country_id
            ')
            ->from('#__ksenmart_regions AS r')
            ->where('r.published=1')
            ->order('r.title')
        ;

        $this->_db->setQuery($query);
        $regions = $this->_db->loadObjectList();
        
        $this->onExecuteAfter('getRegions', array(&$regions));
        return $regions;
    }

    /**
     * KsenMartModelProfile::saveUser()
     * 
     * @return
     */
    public function saveUser() {
        $this->onExecuteBefore('saveUser');
        
        $jinput = JFactory::getApplication()->input;
        $data   = $jinput->get('form', array(), 'array');

        if(!empty($data['id'])){
            $pk = $data['id'];
        }else{
            $pk = (int)$this->getState('user.id');
        }
        $km_user   = KSUsers::getUser();
        $user   = JUser::getInstance($pk);
        if (!$user->bind($data)) {
            return $user->getError();
        }

        if (!$user->save()) {
            return $user->getError();
        }
        
        $user_o             = new stdClass;
        $user_o->id         = $user->id;
        $user_o->region_id  = $data['region'];
        $user_o->phone      = $data['phone'];
        
        try {
            $this->_db->updateObject('#__ksenmart_users', $user_o, 'id');
        }catch(Exception $e) {}
        
        $f_set      = null;
        $f_values   = $jinput->get('field', array(), 'array');

        if(!empty($f_values)){

            $query = $this->_db->getQuery(true);
            $columns = array('id', 'field_id', 'user_id', 'value');
            
            foreach($f_values as $key => $value){
                $values = array($km_user->{'field_'.$key}->id, $key, $user->id, $this->_db->quote($value));
                $tmp = '('.implode(',', $values).')';
                $query->values(implode(',', $values));
            }

            $query
                ->insert($this->_db->quoteName('#__ksenmart_user_fields_values'))
                ->columns($this->_db->quoteName($columns))
            ;
            $query .= ' ON DUPLICATE KEY UPDATE '.$this->_db->quotename('value').' = VALUES('.$this->_db->quotename('value').')';
            $this->_db->setQuery($query);

            try {
                $result = $this->_db->query(); // Use $this->_db->execute() for Joomla 3.0.
            }catch (Exception $e) {}
        }

        $sendEmail = $jinput->get('sendEmail', null, 'string');

        if($sendEmail == 'on') {
            KSUsers::setUserSubscribeGroup($user->id);
        } else {
            KSUsers::removeUserSubscribeGroup($user->id);
        }
        
        $this->onExecuteAfter('saveUser', array(&$this));
    }

    /**
     * KsenMartModelProfile::getOrders()
     * 
     * @return
     */
    public function getOrders() {
        $this->onExecuteBefore('getOrders');

        $user  = JFactory::getUser();

        $query = $this->_db->getQuery(true);
        $query
            ->select('
                o.id, 
                o.cost
            ')
            ->from('#__ksenmart_orders AS o')
            ->where('o.user_id='.$user->id)
            ->order('o.date_add DESC')
        ;

        $this->_db->setQuery($query);
        $orders = $this->_db->loadObjectList();
        for ($k = 0; $k < count($orders); $k++) {
            $orders[$k]           = $this->getOrder($orders[$k]->id);
            $orders[$k]->cost_val = KSMPrice::showPriceWithTransform($orders[$k]->cost);
        }
        
        $this->onExecuteAfter('getOrders', array(&$orders));
        return $orders;
    }

    /**
     * KsenMartModelProfile::getOrder()
     * 
     * @param integer $order_id
     * @return
     */
    public function getOrder($order_id = 0) {
        $this->onExecuteBefore('getOrder', array(&$order_id));

        if ($order_id == 0){
            $order_id = JRequest::getVar('id', 0);
        }

        $user  = KSUsers::getUser();
        $order = KSMOrders::getOrder($order_id);
        $order->shipping_title = $this->getShippingTitle($order->shipping_id);               

        if(empty($order->email)){
            $order->email = $user->email;
        }
        if(empty($order->name)){
            $order->name = $user->name;
        }

        if (empty($order->phone)){
            $order->phone = $user->phone;
        }
        if (!empty($order)) {
            $order->items = KSMOrders::getOrderItems($order_id);
        }
        
        $this->onExecuteAfter('getOrder', array(&$order));
        return $order;
    }

    /**
     * KsenMartModelProfile::getFavorities()
     * 
     * @return
     */
    public function getFavorities() {
        $this->onExecuteBefore('getFavorities');

        $user           = KSUsers::getUser();
        $limitstart     = JRequest::getVar('limitstart', 0);
        $rows           = KSSystem::getTableByIds($user->favorites, 'products', array('t.id'));

        if(!empty($rows)){
            foreach($rows as &$row){
                $row = KSMProducts::getProduct($row->id);
            }
            
            $this->_pagination = new JPagination($this->_total, $limitstart, $this->_limit);
        }
        
        $this->onExecuteAfter('getFavorities', array(&$rows));
        return $rows;
    }
    
    public function removeFavorite($id) {
        $this->onExecuteBefore('removeFavorite', array(&$id));

        if(!empty($id) && $id > 0){
            $user = KSUsers::getUser();
            foreach($user->favorites as $key => $favorite){
                if($favorite == $id){
                    unset($user->favorites[$key]);
                    break;
                }
            }
            sort($user->favorites);
            $user->favorites = json_encode($user->favorites);
            if(KSUsers::updateUser($user->id, 'favorites', $user->favorites)){
                $this->onExecuteAfter('removeFavorite');
                return true;
            }
        }
        return false;
    }
    
    public function removeWatched($id) {
        $this->onExecuteBefore('removeWatched', array(&$id));
        if(!empty($id) && $id > 0){
            $user = KSUsers::getUser();
            foreach($user->watched as $key => $watched){
                if($watched == $id){
                    unset($user->watched[$key]);
                    break;
                }
            }
            sort($user->watched);
            $user->watched = json_encode($user->watched);
            if(KSUsers::updateUser($user->id, 'watched', $user->watched)){
                $this->onExecuteAfter('removeWatched');
                return true;
            }
        }
        return false;
    }

    /**
     * KsenMartModelProfile::getWatched()
     * 
     * @return
     */
    public function getWatched() {
        $this->onExecuteBefore('getWatched');

        $user       = KSUsers::getUser();
        $limitstart = JFactory::getApplication()->input->get('limitstart', 0, 'int');
        $rows       = KSSystem::getTableByIds($user->watched, 'products', array('t.id'));
        
        if(!empty($rows)){
            foreach($rows as &$row){
                $row = KSMProducts::getProduct($row->id);
            }
            $this->_pagination = new JPagination($this->_total, $limitstart, $this->_limit);
        }
        
        $this->onExecuteAfter('getWatched', array(&$rows));
        return $rows;
    }

    /**
     * KsenMartModelProfile::addAddress()
     * 
     * @return
     */
    public function addAddress() {
        $this->onExecuteBefore('addAddress');

        $jinput  = JFactory::getApplication()->input;
        $user    = KSUsers::getUser();
        $city    = $jinput->get('city', null, 'string');
        $street  = $jinput->get('street', null, 'string');
        $house   = $jinput->get('house', null, 'string');
        $floor   = $jinput->get('floor', 0, 'int');
        $flat    = $jinput->get('flat', 0, 'int');
        $default = $jinput->get('default', 0, 'int');

        $address = new stdClass();
        $address->user_id   = $user->id;
        $address->city      = $city;
        $address->street    = $street;
        $address->house     = $house;
        $address->floor     = $floor;
        $address->flat      = $flat;
        $address->default   = $default;
        
        try{
            $result = $this->_db->insertObject('#__ksenmart_user_addresses', $address);
            
            $this->onExecuteAfter('addAddress', array(&$result));
            return true;
        }catch(Exception $e){}
        return false;
    }

    /**
     * KsenMartModelProfile::deleteAddress()
     * 
     * @return
     */
    public function deleteAddress() {
        $this->onExecuteBefore('deleteAddress');

        $id     = JFactory::getApplication()->input->get('id', 0, 'int');
        $user   = KSUsers::getUser();
        
        $query = $this->_db->getQuery(true);

        $conditions = array(
            'id='.$this->_db->escape($id),
            'user_id='.$user->id
        );
        
        $query->delete($this->_db->quoteName('#__ksenmart_user_addresses'));
        $query->where($conditions);
        
        $this->_db->setQuery($query);
        
        try {
            $result = $this->_db->query(); // $this->_db->execute(); for Joomla 3.0.
            
            $this->onExecuteAfter('onExecuteBefore', array(&$result));
            return true;
        }catch (Exception $e) {}
        return false;
    }

    /**
     * KsenMartModelProfile::setDefaultAddress()
     * 
     * @return
     */
    public function setDefaultAddress() {
        $this->onExecuteBefore('setDefaultAddress');

        $id     = JFactory::getApplication()->input->get('id', 0, 'int');
        $user   = KSUsers::getUser();
        
        try{
            $this->_db->transactionStart();
            
            $address          = new stdClass();
            $address->user_id = $user->id;
            $address->default = 0;
            
            $this->_db->updateObject('#__ksenmart_user_addresses', $address, 'user_id');
            
            $query  = $this->_db->getQuery(true);
            $fields = array(
                $this->_db->quoteName('default') . '=1'
            );
            $conditions = array(
                $this->_db->quoteName('user_id') . '='.$this->_db->escape($user->id), 
                $this->_db->quoteName('id') . '='.$this->_db->escape($id)
            );
            
            $query
                ->update($this->_db->quoteName('#__ksenmart_user_addresses'))
                ->set($fields)
                ->where($conditions)
            ;
            $this->_db->setQuery($query);
            $this->_db->queryBatch($query);
            $this->_db->transactionCommit();
            
            $this->onExecuteAfter('setDefaultAddress');
        }catch (Exception $e){
            $this->_db->transactionRollback();
            JErrorPage::render($e);
        }
    }

    /**
     * KsenMartModelProfile::getAddresses()
     * 
     * @return
     */
    public function getAddresses() {
        $this->onExecuteBefore('getAddresses');

        $adresses = KSUsers::getAddresses();
        
        $this->onExecuteAfter('getAddresses', array(&$adresses));
        return $adresses;
    }
    
    public function setSelectAddressId($id, $city, $street, $house, $flat, $floor) {
        $this->onExecuteBefore('setSelectAddressId', array(&$id, &$city, &$street, &$house, &$flat, &$floor));

        if(!empty($id) && $id > 0){
            $session = JFactory::getSession();
            
            $session->set('selected_address', $id);
            $session->set($this->_context.'.address_fields[city]', $city);
            $session->set($this->_context.'.address_fields[street]', $street);
            $session->set($this->_context.'.address_fields[house]', $house);
            $session->set($this->_context.'.address_fields[flat]', $flat);
            $session->set($this->_context.'.address_fields[floor]', $floor);
            
            $this->onExecuteAfter('setSelectAddressId', array(&$this));
            return true;
        }
        return false;
    }

    /**
     * KsenMartModelProfile::getTotal()
     * 
     * @return
     */
    function getTotal() {
        $this->onExecuteBefore('getTotal', array(&$this));
        $this->onExecuteAfter('getTotal', array(&$this));
        
        return $this->_total;
    }

    /**
     * KsenMartModelProfile::getPagination()
     * 
     * @return
     */
    function getPagination() {
        $this->onExecuteBefore('getPagination', array(&$this));
        $this->onExecuteAfter('getPagination', array(&$this));
        return $this->_pagination;
    }

    /**
     * KsenMartModelProfile::getComments()
     * 
     * @return
     */
    public function getComments() {
        $this->onExecuteBefore('getComments');

        $query = $this->_db->getQuery(true);
        $this->_limit = 10;
        $limitstart = JRequest::getVar('limitstart', 0);
        $user = JFactory::getUser();

        $query->select('
            c.id, 
            c.user_id AS user, 
            c.product_id AS product, 
            c.name, 
            c.comment, 
            c.good, 
            c.bad, 
            c.rate, 
            c.date_add, 
            p.id AS p_id, 
            p.title, 
            p.alias, 
            i.filename, 
            i.folder
        ');
        $query->from('#__ksenmart_comments AS c');
        $query->leftjoin('#__ksenmart_products AS p ON c.product_id = p.id');
        $query->leftjoin('#__ksenmart_files AS i ON p.id=i.owner_id');
        $query->where('c.published = 1');
        $query->where('c.user_id = ' . $user->id);
        $query->where("c.type = 'review'");
        $query->group('c.id');

        $this->_db->setQuery($query, $limitstart, $this->_limit);
        $comments = $this->_db->loadObjectList();
        $this->_pagination = new JPagination(count($comments), $limitstart, $this->_limit);

        $this->setProductLinksOfReviews($comments);
        $this->setProductImagesOfReviews($comments);

        $this->onExecuteAfter('getComments', array(&$comments));
        return $comments;
    }

    /**
     * KsenMartModelProfile::setProductLinksOfReviews()
     * 
     * @param mixed $comments
     * @return
     */
    function setProductLinksOfReviews($comments) {
        $this->onExecuteBefore('setProductLinksOfReviews', array(&$comments));

        foreach ($comments as $comment) {
            $comment->link = JRoute::_('index.php?option=com_ksenmart&view=product&id=' . $comment->p_id . ':' . $comment->alias);
        }
        
        $this->onExecuteAfter('setProductLinksOfReviews', array(&$comments));
        return $comments;
    }

    /**
     * KsenMartModelProfile::setProductImagesOfReviews()
     * 
     * @param mixed $comments
     * @return
     */
    function setProductImagesOfReviews($comments) {
        $this->onExecuteBefore('setProductImagesOfReviews', array(&$comments));

        $params = JComponentHelper::getParams('com_ksenmart');
        foreach ($comments as $comment) {
            $comment->small_img = KSMedia::resizeImage($comment->filename, $comment->folder, $params->get('thumb_width'), $params->get('thumb_height'));
        }
        
        $this->onExecuteAfter('setProductImagesOfReviews', array(&$comments));
        return $comments;
    }

    /**
     * KsenMartModelProfile::getShippingTitle()
     * 
     * @param mixed $type_id
     * @return
     */
    public function getShippingTitle($type_id) {
        $this->onExecuteBefore('getShippingTitle', array(&$type_id));

        if(!empty($type_id)){
            $query = $this->_db->getQuery(true);
            $query
                ->select('id, title')
                ->from('#__ksenmart_shippings')
                ->where('id = ' . $this->_db->Quote($type_id))
                ->order('id')
            ;

            $this->_db->setQuery($query);
            $this->_shipping = $this->_db->loadObject();
            
            if ($this->_shipping) {
                return $this->_shipping->title;
            }
        }
        
        $this->_shipping        = new stdClass();
        $this->_shipping->title = 'Доставка еще не выбрана';
        
        $this->onExecuteAfter('getShippingTitle', array(&$this->_shipping->title));
        return $this->_shipping->title;
    }
    
    public function loadAvatar() {
        $this->onExecuteBefore('loadAvatar');

        $resize = (bool)JRequest::getVar('resize', false);
        $flag   = (bool)JRequest::getVar('flag', false);

        if($flag){
            $this->moveTmpImg();
        }else{
            $this->moveTmpImg(true);
        }
        
        $this->onExecuteAfter('loadAvatar');
        return true;
    }
    
    
    private function setUserAvatar($uid, $avatar_name){
        $this->onExecuteBefore('setUserAvatar', array(&$uid, $avatar_name));

        if(!empty($uid)){
            $object = new stdClass();
            
            $object->owner_id   = $uid;
            $object->filename   = $avatar_name;
            $object->media_type = 'image';
            $object->folder     = 'users';
            $object->owner_type = 'avatar';

            try {
                $asd = $this->issetUserAvatatFile($uid);
                if($asd){
                    $result = $this->_db->updateObject('#__ksenmart_files', $object, 'owner_id');
                }else{
                    $result = $this->_db->insertObject('#__ksenmart_files', $object);
                }
                
                $this->onExecuteAfter('setUserAvatar', array(&$result));
                return true;
            }catch(Exception $e) {}
        }
        return false;
    }
    
    private function issetUserAvatatFile($uid){
        $this->onExecuteBefore('issetUserAvatatFile', array(&$uid));

        $query = $this->_db->getQuery(true);
        $query
            ->select('f.id')
            ->from('#__ksenmart_files AS f')
            ->where('owner_id = ' . (int)$uid)
        ;

        $this->_db->setQuery($query, 0, 1);
        $this->_shipping = $this->_db->loadObject();
        $result = $this->_db->query();
        
        $this->onExecuteAfter('issetUserAvatatFile', array(&$result));
        return $result->num_rows;
    }
    
    public function moveTmpImg($resize = false) {
        $this->onExecuteBefore('moveTmpImg', array(&$resize));
        
        $uid    = KSUsers::getUser()->id;
        $jinput = JFactory::getApplication()->input;
        
        $x1     = $jinput->get('x1', 0, 'int');
        $y1     = $jinput->get('y1', 0, 'int');
        $w      = $jinput->get('w', 0, 'int');
        $h      = $jinput->get('h', 0, 'int');

        $boundx = $jinput->get('boundx', 0, 'int');
        $boundy = $jinput->get('boundy', 0, 'int');
        
        $uploaddir = JPATH_ROOT . DS . 'media' . DS . 'ksenmart' . DS . 'images' . DS . 'users';

        if($resize){
            foreach ($_FILES as $key => $value) {
                $size = getimagesize($value['tmp_name']);

                if($value["size"] > 1024*8*1024){
                    return false;
                }

                if(empty($uid)){
                    $value['name'] = $this->generateRandomString(15);
                }else{
                    $value['name'] = $uid.'_'.$value['name'];
                }
                
                $uploadfile_original = $uploaddir . DS . 'original' . DS. basename($value['name']);
                $uploadfile_thumb    = $uploaddir . DS . 'thumb' . DS. basename($value['name']);

                if(!file_exists($uploaddir . DS . 'original' . DS)){
                    mkdir($uploaddir . DS . 'original' . DS);
                }

                if(!file_exists($uploaddir . DS . 'thumb' . DS)){
                    mkdir($uploaddir . DS . 'thumb' . DS);
                }                

                if(!is_uploaded_file($value['tmp_name'])){
                    return false;
                }

                $this->resizeImage($value['tmp_name'], 0, 0, $w, $h, $boundx, $boundy, true);
                copy($value['tmp_name'], $uploadfile_original);

                $this->resizeImage($value['tmp_name'], $x1, $y1, $w, $h, $boundx, $boundy);
                move_uploaded_file($value['tmp_name'], $uploadfile_thumb);

                $this->setUserAvatar($uid, $value['name']);
                
                $this->onExecuteAfter('moveTmpImg');
                return true;
            }
        }else{
            $avatar_full   = JPATH_ROOT . DS . JRequest::getVar('avatar_full', null);
            if(!empty($avatar_full)){
                if(file_exists($avatar_full)){
                    $pathinfo       = pathinfo($avatar_full);
                    $thumb_patch    = $uploaddir . DS . 'thumb' . DS;
                    
                    if(copy($pathinfo['dirname'].'/'.$pathinfo['basename'], $thumb_patch.$pathinfo['basename'])){
                        if($this->resizeImage($thumb_patch.$pathinfo['basename'], $x1, $y1, $w, $h, $boundx, $boundy)){
                            $this->onExecuteAfter('moveTmpImg');
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    
    /**
     * KsenMartModelAccount::resizeImage()
     * 
     * @param mixed $tmp_name
     * @param mixed $x1
     * @param mixed $y1
     * @param mixed $w
     * @param mixed $h
     * @param mixed $boundx
     * @param mixed $boundy
     * @param bool $resize
     * @return
     */
    private function resizeImage($tmp_name, $x1, $y1, $w, $h, $boundx, $boundy, $resize = false){
        $this->onExecuteBefore('resizeImage', array(&$tmp_name, &$x1, &$y1, &$w, &$h, &$boundx, &$boundy, &$resize));

        $iWidth = $iHeight = 150; // desired image result dimensions
        $iJpgQuality = 100;

                    
        if(file_exists($tmp_name) && filesize($tmp_name) > 0) {
            $aSize = getimagesize($tmp_name); // try to obtain image info

            if (!$aSize) {
                return;
            }

            // check for image type
            switch($aSize[2]) {
                case IMAGETYPE_JPEG:
                    $sExt = '.jpg';
                    $vImg = imagecreatefromjpeg($tmp_name);
                    break;
                case IMAGETYPE_PNG:
                    $sExt = '.png';
                    $vImg = imagecreatefrompng($tmp_name);
                    break;
                default:
                return;
            }

            if(!$resize){
                
                $vDstImg = imagecreatetruecolor($iWidth, $iHeight);

                $proX = $aSize[0]/$boundx;
                $proY = $aSize[1]/$boundy;

                if($x1+$w >= $aSize[0]){
                    imagecopyresampled($vDstImg, $vImg, 0, 0, $x1, $y1, $iWidth, $iHeight, $w, $h);
                }else{
                    imagecopyresampled($vDstImg, $vImg, 0, 0, $x1*$proX, $y1*$proY, $iWidth, $iHeight, $w*$proX, $h*$proY);
                }
            //}elseif($aSize[0] > 1000){
            }else{
                $koe    = $aSize[0]/1000;
                $new_h  = ceil ($aSize[1]/$koe);

                $vDstImg = imagecreatetruecolor(1000, $new_h);

                imagecopyresampled($vDstImg, $vImg, 0, 0, 0, 0, 1000, $new_h, $aSize[0], $aSize[1]);
            }

            // define a result image filename
            $sResultFileName = $tmp_name;

            // output image to file
            imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);

            $this->onExecuteAfter('resizeImage');
            return true;
        }
    }
    
    public function getShopReview($uid){
        $this->onExecuteBefore('getShopReview', array(&$uid));

        $query = $this->_db->getQuery(true);
        $query->select('
            c.id,
            c.user_id AS user, 
            c.name, 
            c.comment, 
            c.date_add, 
            c.rate
        ');
        $query->from('#__ksenmart_comments AS c');
        $query->where("c.type='shop_review'");
        $query->where("c.published=1");
        $query->where('c.user_id='.$uid);

        $this->_db->setQuery($query);
        $reviews = KSUsers::setAvatarLogoInObject($this->_db->loadObject());
        
        $this->onExecuteAfter('getShopReview', array(&$reviews));
        return $reviews;
    }
    
    public function updateProductReview($review_id, $comment, $good, $bad){
        $this->onExecuteBefore('updateProductReview', array(&$review_id, &$comment, &$good, &$bad));

        if(!empty($review_id)){
            $comment_o = new stdClass();
            
            $comment_o->id        = $review_id;
            $comment_o->comment   = $this->_db->escape($comment);
            $comment_o->good      = $this->_db->escape($good);
            $comment_o->bad       = $this->_db->escape($bad);

            try {
                $res = $this->_db->updateObject('#__ksenmart_comments', $comment_o, 'id');
                
                $this->onExecuteAfter('updateProductReview', array(&$res));
                return true;
            }catch(Exception $e) {
                
            }
        }
        return false;
    }
    
    public function editAddress($id) {
        $this->onExecuteBefore('editAddress', array(&$id));

        if(!empty($id) && $id > 0){
            $address = new stdClass();
            $jinput  = JFactory::getApplication()->input;
            
            $address->id        = $id;
            $address->city      = $jinput->get('city', null, 'string');
            $address->street    = $jinput->get('street', null, 'string');
            $address->house     = $jinput->get('house', null, 'int');
            $address->floor     = $jinput->get('floor', null, 'int');
            $address->flat      = $jinput->get('flat', null, 'int');
            $address->default   = $jinput->get('default', null, 'int');
            
            try {
                $result = $this->_db->updateObject('#__ksenmart_user_addresses', $address, 'id');
                
                $this->onExecuteAfter('editAddress', array(&$result));
                return true;
            }catch(Exception $e) {
                
            }
        }
        return false;
    }
    
    public function getShippingsByRegionId($region_id) {
        $this->onExecuteBefore('getShippingsByRegionId', array(&$region_id));

        $shippings = array();
        if(!empty($region_id) && $region_id > 0){
            $query = $this->_db->getQuery(true);
            $query
                ->select('
                    s.id,
                    s.title,
                    s.type,
                    s.regions,
                    s.days,
                    s.params,
                    s.ordering
                ')
                ->from('#__ksenmart_shippings AS s')
                ->where('s.regions LIKE \'%'.$this->_db->escape($region_id).'%\'')
                ->where('s.published=1')
                ->order('s.id')
            ;

            $this->_db->setQuery($query);
            $shippings = $this->_db->loadObjectList();
        }
        
        $this->onExecuteAfter('getShippingsByRegionId', array(&$shippings));
        return $shippings;
    }
    
    public function getPaymentsByRegionId($region_id) {
        $this->onExecuteBefore('getPaymentsByRegionId', array(&$region_id));

        $payments = array();
        if(!empty($region_id) && $region_id > 0){
            $query = $this->_db->getQuery(true);
            $query
                ->select('
                    p.id,
                    p.title,
                    p.type,
                    p.regions,
                    p.description,
                    p.params,
                    p.ordering
                ')
                ->from('#__ksenmart_payments AS p')
                ->where('p.regions LIKE \'%'.$this->_db->escape($region_id).'%\'')
                ->where('p.published=1')
                ->order('p.id')
            ;

            $this->_db->setQuery($query);
            $payments = $this->_db->loadObjectList();
        }
        
        $this->onExecuteAfter('getPaymentsByRegionId', array(&$payments));
        return $payments;
    }
}