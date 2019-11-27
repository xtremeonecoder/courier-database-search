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

class Application_Model_Mail extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->mail_id;
    }

    public function getSubject(){
        return $this->subject;
    }    
    
    public function getBody(){
        return $this->body;
    }    

    public function getSent(){
        return (int) $this->sent;
    }    

    public function getStatus(){
        return $this->status;
    }    

    public function isEnabled(){
        return $this->enabled;
    }    
    
    public function getCreationDate(){
        return $this->creation_date;
    }        
    
    public function getModifiedDate(){
        return $this->modified_date;
    }
    
    public function sendTo(Application_Model_User $user){
        // get reciepient
        if(!$user->company_id){
            $reciepient = 'Test User';
        }else{
            $reciepient = $user->getCompany()->getTitle();
        }
        
        // prepare mail params
        $mailParams = array(
            'to' => $user->getEmail(),
            'from' => 'info@xtremeonecoder.com',
            'reciepient' => $reciepient,
            'sender' => 'Admin - Courier Database',
            'subject' => $this->getSubject(),
            'messagebody' => html_entity_decode(
                    $this->getBody(), 
                    ENT_QUOTES
            ),
            'mailtype' => 'html'
        );

        // sent mail
        $mail = Zend_Controller_Action_HelperBroker::getStaticHelper('Mail');
        $mail->send($mailParams, false);
        
        // return true
        return true;        
    }
}