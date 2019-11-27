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

class Application_Model_Vehicle extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->vehicle_id;
    }

    public function getCompanyId(){
        return $this->company_id;
    }
    
    public function getMake(){
        return $this->make;
    }
    
    public function getModel(){
        return $this->model;
    }
    
    public function getWeight(){
        return $this->weight;
    }
    
    public function getWidth(){
        return $this->width;
    }
    
    public function getHeight(){
        return $this->height;
    }
    
    public function getLength(){
        return $this->length;
    }
    
    public function getVehicleNumber(){
        return $this->vehicle_number;
    }
    
    public function isEnabled(){
        return $this->enabled;
    }
    
    public function getCompany(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("companies");
        return $table->fetchRow(array('company_id = ?' => $this->getCompanyId()));
    }    
}