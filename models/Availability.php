<?php
/**
 * ParcelDeliveryNetwork
 *
 * @category   Application_Core
 * @package    PDN
 * @author     ParcelDeliveryNetwork
 * @developer  Aninda Barua <aninda.cse@gmail.com>
 */

/**
 * @category   Application_Core
 * @package    PDN
 */

class Application_Model_Availability extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->availability_id;
    }
    
    public function getAvailabilityDate(){
        return $this->availability_date;
    }    

    public function getFromTime(){
        return $this->from_time;
    }    

    public function getToTime(){
        return $this->to_time;
    }    

    public function getFromPostcode(){
        return $this->from_postcode;
    }    

    public function getToPostcode(){
        return $this->to_postcode;
    }    

    public function getCompanyId(){
        return (int) $this->company_id;
    }    

    public function getOwnerId(){
        return (int) $this->owner_id;
    }    

    public function getFromTownId(){
        return (int) $this->from_town_id;
    }    

    public function getToTownId(){
        return (int) $this->to_town_id;
    }    

    public function getVehicleId(){
        return (int) $this->vehicle_type;
    }    

    public function getToLat(){
        return $this->to_lat;
    }    

    public function getToLng(){
        return $this->to_lng;
    }    

    public function getFromLat(){
        return $this->from_lat;
    }    

    public function getFromLng(){
        return $this->from_lng;
    }    

    public function getCreationDate(){
        return $this->creation_date;
    }    

    public function getModifiedDate(){
        return $this->modified_date;
    }    

    public function isEnabled(){
        return $this->enabled ? true : false;
    }    

    public function getCompany(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("companies");
        return $table->fetchRow(array('company_id = ?' => $this->getCompanyId()));
    }
    
    public function getFromTown(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("towns");
        return $table->fetchRow(array('town_id = ?' => $this->getFromTownId()));
    }
    
    public function getToTown(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("towns");
        return $table->fetchRow(array('town_id = ?' => $this->getToTownId()));
    }
    
    public function getVehicle(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("vehicles");
        return $table->fetchRow(array('vehicle_id = ?' => $this->getVehicleId()));
    }
    
    public function getOwner(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("users");
        return $table->fetchRow(array('user_id = ?' => $this->getOwnerId()));
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
        // call parent
        parent::_postDelete();
    }
}