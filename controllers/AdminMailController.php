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

class AdminMailController extends Zend_Controller_Action
{
    public function init()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get viewer
        $viewer = $this->_helper->getHelper('User')->getViewer();
        if(!$viewer->isModerator() 
                && !$viewer->isAdmin() 
                && !$viewer->isSuperAdmin()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'user_dashboard', true);
        }
    }

    public function indexAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // redirect to browse
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'admin_mail_general', true);
    }
    
    public function browseAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Admin Mails List');
        
        // Get DbTable
        $helper = $this->_helper->getHelper('DbTable');
        
        // merge values
        $values = array(
            'order' => 'mail_id',
            'direction' => 'DESC'
        );

        // get companies
        $itemPerPage = 10;
        $table = $helper->getTable("mails");
        $paginator = $table->getMailPaginator($values);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);
        $this->view->paginator =$paginator;
        $this->view->itemPerPage = $itemPerPage;
    }
    
    public function addAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Admin Compose New Mail');
        
        // render form
        $this->view->form = $form 
                = new Application_Form_Admin_Mail_Compose();
                
        // Check form posted
        if(!$this->getRequest()->isPost()){
            return;
        }
        
        // Check form valid
        if(!$form->isValid($this->getRequest()->getPost())){
            return;
        }
        
        //get form values
        $values = $form->getValues();
        $values['enabled'] = 0;
        $values['creation_date'] = @date('Y-m-d H:i:s', time());
        $values['modified_date'] = @date('Y-m-d H:i:s', time());
        $values['body'] = htmlentities($values['body'], ENT_QUOTES);
        
        // start transaction
        $table = $this->_helper->getHelper('DbTable')->getTable("mails");
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            $mail = $table->createRow();
            $mail->setFromArray($values);
            $mail->save();
            
            // Commit
            $db->commit();
            
            // redirect to mail list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse'), 'admin_mail_general', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function editAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $mailId = $this->_getParam('id', false);
        $this->_helper->layout()
                ->getView()->headTitle('Admin Mail Edit');
        
        // forward to error
        if(!$mailId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $this->view->form = $form 
                = new Application_Form_Admin_Mail_Edit();
        
        // get mail
        $table = $this->_helper->getHelper('DbTable')->getTable("mails");
        $mail = $table->fetchRow(array('mail_id = ?' => $mailId));
        
        // forward to error
        if(!$mail OR !$mail->mail_id){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // populate form
        $mailArray = $mail->toArray();
        $mailArray['body'] = html_entity_decode($mailArray['body'], ENT_QUOTES);
        $form->populate($mailArray);
        $this->view->mail = $mail;
                
        // Check form posted
        if(!$this->getRequest()->isPost()){
            return;
        }
        
        // Check form valid
        if(!$form->isValid($this->getRequest()->getPost())){
            return;
        }
        
        //get form values
        $values = $form->getValues();
        $values['modified_date'] = @date('Y-m-d H:i:s', time());
        $values['body'] = htmlentities($values['body'], ENT_QUOTES);
        
        // start transaction
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            $mail->setFromArray($values);
            $mail->save();
            
            // Commit
            $db->commit();        
            
            // redirect to mail list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse'), 'admin_mail_general', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }
    
    public function deleteAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get ids and page id
        $pg = $this->_getParam('pg', false);
        $mailIds = $this->_getParam('id', false);
        $mailIds = explode(',', $mailIds);
        
        // check mail ids
        if(count($mailIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("mails");
            $mails = $table->fetchAll(array('mail_id IN (?)' => $mailIds));
            if(count($mails)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($mails as $mail){
                        $mail->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to mail list
        if($pg > 1){
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse', 'page' => $pg), 'admin_mail_general', true);
        }
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'admin_mail_general', true);
    }
    
    public function statusAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get id and page id
        $pg = $this->_getParam('pg', false);
        $mailId = $this->_getParam('id', false);
        
        // check mail id
        if(!$mailId){
            return $this->_forward('error', 'error', 'default', array());
        }
        
        // get table
        $table = $this->_helper->getHelper('DbTable')->getTable("mails");
        $mail = $table->fetchRow(array('mail_id = ?' => $mailId));
        
        // forward to error
        if(!$mail OR !$mail->mail_id){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // start transaction
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            // change status
            $mail->enabled = $mail->isEnabled() ? 0 : 1;
            $mail->save();

            // Commit
            $db->commit();        
        }catch(Exception $e){
            $db->rollBack();
            throw $e;
        }                
        
        // redirect to mail list
        if($pg > 1){
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse', 'page' => $pg), 'admin_mail_general', true);
        }
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'admin_mail_general', true);
    }
    
    public function resetAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get id and page id
        $pg = $this->_getParam('pg', false);
        $mailId = $this->_getParam('id', false);
        
        // check mail id
        if(!$mailId){
            return $this->_forward('error', 'error', 'default', array());
        }
        
        // get table
        $table = $this->_helper->getHelper('DbTable')->getTable("mails");
        $mail = $table->fetchRow(array('mail_id = ?' => $mailId));
        
        // forward to error
        if(!$mail OR !$mail->mail_id){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // start transaction
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            // change status
            $mail->sent = 0;
            $mail->lastid = 0;
            $mail->status = 'Stopped';
            $mail->save();

            // Commit
            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            throw $e;
        }                
        
        // redirect to mail list
        if($pg > 1){
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse', 'page' => $pg), 'admin_mail_general', true);
        }
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'admin_mail_general', true);
    }

    public function testMailAction()
    {
        // check user loggedin?
        $data = array();
        $mailId = $this->_getParam('id', false);
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }
        
        // check mail id
        if(!$mailId){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }
        
        // get mail
        $mail = $this->_helper
                ->getHelper('DbTable')
                ->getTable("mails")
                ->fetchRow(array('mail_id = ?' => $mailId));

        // get user
        $user = $this->_helper
                ->getHelper('DbTable')
                ->getTable("users")
                ->fetchRow(array('user_id = ?' => 1));
        
        // forward to error
        if(!isset($mail->mail_id) || empty($mail->mail_id) 
                OR !isset($user->user_id) || empty($user->user_id)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }
        
        try{
            $mail->sendTo($user);
        }catch(Exception $e){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }        
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);
        exit();        
    }
}