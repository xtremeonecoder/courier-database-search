<?php
/**
 * Search Engine for Finding Courier Services
 *
 * @category   Application_Core
 * @package    courier-search-engine
 * @author     Suman Barua
 * @developer  Suman Barua <sumanbarua576@gmail.com>
 */

/**
 * @category   Application_Core
 * @package    courier-search-engine
 */

class Helper_User extends Zend_Controller_Action_Helper_Abstract
{
    public function getViewer(){
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return null;
        }
        
        $user = Zend_Auth::getInstance()->getIdentity();
        if(empty($user->user_id)){
            return null;
        }
        
        // get loggedin user
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("users");
        return $table->fetchRow(array('user_id = ?' => (int) $user->user_id));        
    }
}