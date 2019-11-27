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

class CronController extends Zend_Controller_Action
{
    public function init()
    {
        // init
    }

    public function indexAction()
    {
        return $this->_forward('error', 'error', 'default', array());
    }
    
    public function executeAction()
    {
        // set time limit
        set_time_limit(0);
        
        // get total user count
        $userTable = $this->_helper->getHelper('DbTable')->getTable("users");
        $select = $userTable->select()
                ->from($userTable->info('name'), array('totalusers' => 'COUNT(*)'))
                ->where('user_id != ?', 1)
                ->where('email != ?', '');
        
        // get row
        $row = $userTable->fetchRow($select);
        
        // get all the mails
        $mailTable = $this->_helper->getHelper('DbTable')->getTable("mails");
        $mails = $mailTable->fetchAll(array(
            'status != ?' => 'Completed', 
            //'sent != ?' => $row->totalusers,
            'enabled = ?' => 1
        ));

        // check mails?
        if(!count($mails) || !$row->totalusers){
            exit();
        }
        
        // iterate the mail
        foreach($mails as $mail){
            // get user select
            $select = $userTable->select()
                    ->where('user_id != ?', 1)
                    ->where('user_id > ?', (int) $mail->lastid)
                    ->order('user_id ASC')
                    ->limit(1000);
            
            // get users
            $users = $userTable->fetchAll($select);
            if(count($users)>0){
                $counter = 0;
                $lastItem = $users->getRow(count($users)-1);
                
                // send mail to all members
                foreach($users as $user){
                    // call mail function
//                    try{
//                        $mail->sendTo($user);
//                    }catch(Exception $e){
//                        continue;
//                    }        
                    
                    // increase counter
                    $counter++;
                }
                
                // update mail
                $mail->sent += $counter;
                $mail->status = 'Processing';
                $mail->lastid = $lastItem->user_id;
                $mail->save();
            }else{
                //$mail->sent = 0;
                $mail->lastid = 0;
                $mail->enabled = 0;
                $mail->status = 'Completed';
                $mail->save();
            }
        }
        
        exit();
    }
}