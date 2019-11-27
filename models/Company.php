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

class Application_Model_Company extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->company_id;
    }
    
    public function getTitle(){
        return $this->company_name ?
                $this->company_name : 'Unknown Courier Company';
    }    

    public function getHref($params = array())
    {
        $slug = $this->getSlug();
        $params = array_merge(array(
            'route' => 'courier_profile',
            'reset' => true,
            'id' => $this->getIdentity(),
            'slug' => $slug,
        ), $params);
        $route = $params['route'];
        $reset = $params['reset'];
        unset($params['route']);
        unset($params['reset']);
        return Zend_Controller_Front::getInstance()->getRouter()
                ->assemble($params, $route, $reset);
    }

    public function getSlug() 
    {
        return Aninda_Helper_Text::slugify($this->getTitle());
    }
    
    public function getContactName(){
        return $this->contact_name;
    }    

    public function getEmail(){
        return $this->email;
    }    

    public function getEmailHref($params = array())
    {
        $params = array_merge(array(
            'route' => 'courier_send_mail',
            'reset' => true,
            'id' => $this->getIdentity()
        ), $params);
        $route = $params['route'];
        $reset = $params['reset'];
        unset($params['route']);
        unset($params['reset']);
        return Zend_Controller_Front::getInstance()->getRouter()
                ->assemble($params, $route, $reset);
    }

    public function getPhoneNo(){
        return $this->phone_no;
    }    

    public function getMobileNo(){
        return $this->mobile_no;
    }    

    public function getAddress(){
        return $this->address;
    }    

    public function getFullAddress(){
        return "{$this->address},
            {$this->getCity()->getTitle()},
            {$this->getCounty()->getTitle()},
            {$this->getPostCode()},
            {$this->getCountry()->getTitle()}
        ";
    }    

    public function getFullAddressLine(){
        return "{$this->address}, {$this->getCity()->getTitle()}, {$this->getCounty()->getTitle()}, {$this->getPostCode()}, {$this->getCountry()->getTitle()}";
    }    

    public function getWebsite(){
        return $this->website;
    }    

    public function getOwnerId(){
        return $this->user_id;
    }    

    public function getCreationDate(){
        return $this->creation_date;
    }    

    public function getModifiedDate(){
        return $this->modified_date;
    }    

    public function getPostCode(){
        return $this->postcode;
    }    

    public function isEnabled(){
        return $this->enabled ? true : false;
    }    

    public function isSearchAble(){
        return $this->search ? true : false;
    }    

    public function getIpAddress(){
        return $this->ipaddress;
    }    

    public function getLatitude(){
        return $this->latitude;
    }    

    public function getLongitude(){
        return $this->longitude;
    }    

    public function getCityId(){
        return (int) $this->city;
    }
    
    public function getCountyId(){
        return (int) $this->county;
    }

    public function getCountryId(){
        return (int) $this->country;
    }

    public function getCity(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("towns");
        return $table->fetchRow(array('town_id = ?' => $this->getCityId()));
    }
    
    public function getCounty(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("counties");
        return $table->fetchRow(array('county_id = ?' => $this->getCountyId()));
    }

    public function getCountry(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("countries");
        return $table->fetchRow(array('country_id = ?' => $this->getCountryId()));
    }

    public function getVehicles(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("vehicles");
        return $table->fetchAll(array('company_id = ?' => $this->getIdentity(), 'enabled = ?' => 1));
    }
    
    public function getInsurance(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("insurances");
        return $table->fetchAll(array('company_id = ?' => $this->getIdentity(), 'enabled = ?' => 1));
    }
    
    public function getPaymentTerms(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("paymentsettings");
        return $table->fetchAll(array('company_id = ?' => $this->getIdentity(), 'enabled = ?' => 1));
    }
    
    public function getServices(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("services");
        return $table->fetchAll(array('company_id = ?' => $this->getIdentity(), 'enabled = ?' => 1));
    }
    
    public function getOwner(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("users");
        return $table->fetchRow(array('user_id = ?' => $this->getOwnerId()));
    }

    public function getAvailabilities(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("availabilities");
        $select = $table->select()
                ->where('company_id = ?', $this->getIdentity())
                ->where('enabled = ?', 1)
                ->order('modified_date DESC')
                ;
        return $table->fetchAll($select);
    }
    
    public function sendMail($params = array())
    {
        // init mail class
        $mail = new Zend_Mail();

        // prepare mail params
        $mailParams = array(
            //'to' => 'aninda.cse@gmail.com',
            'to' => $this->getEmail(),
            'from' => trim($params['email']),
            'reciepient' => $this->getTitle(),
            'sender' => trim($params['fullname']),
            'subject' => trim($params['subject']),
            'messagebody' => nl2br($params['message']),
            //'messagebody' => nl2br(html_entity_decode(nl2br($this->getMessage()), ENT_QUOTES)),
            'mailtype' => 'html'
        );

        // send text mail
        $mail->setBodyHtml($mailParams['messagebody']);
        $mail->setFrom($mailParams['from'], $mailParams['sender']);
        $mail->addTo($mailParams['to'], ucwords($mailParams['reciepient']));
        $mail->setSubject($mailParams['subject']);
        $mail->send();
    }    
    
    /**
     *  pre delete hook
     */    
    protected function _delete(){
        // Call parent
        parent::_delete();
    }

    /**
     *  post delete hook
     */   
    protected function _postDelete(){
        // delete company vehicles
        $vehicles = $this->getVehicles();
        if(count($vehicles)>0){
            try{
                foreach($vehicles as $vehicle){
                    $vehicle->delete();
                }
            }catch(Exception $e){}
        }

        // delete company insurances
        $insurances = $this->getInsurance();
        if(count($insurances)>0){
            try{
                foreach($insurances as $insurance){
                    $insurance->delete();
                }
            }catch(Exception $e){}
        }
        
        // delete company payment terms
        $paymentTerms = $this->getPaymentTerms();
        if(count($paymentTerms)>0){
            try{
                foreach($paymentTerms as $paymentTerm){
                    $paymentTerm->delete();
                }
            }catch(Exception $e){}
        }
        
        // delete company services
        $services = $this->getServices();
        if(count($services)>0){
            try{
                foreach($services as $service){
                    $service->delete();
                }
            }catch(Exception $e){}
        }
        
        // delete company owner account
        $owner = $this->getOwner();
        if($owner){
            try{
                $owner->delete();
            }catch(Exception $e){}
        }
        
        // call parent
        parent::_postDelete();
    }
}