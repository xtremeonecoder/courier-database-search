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

class Application_Model_Service extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->service_id;
    }

    public function getCompanyId(){
        return $this->company_id;
    }

    public function getServices(){
        $services = array();
        if($this->same_day){$services[] = 'Same Day';}
        if($this->next_day){$services[] = 'Next Day';}
        if($this->overnight){$services[] = 'Overnight';}
        if($this->international){$services[] = 'International';}
        if($this->temperature_controlled){$services[] = 'Temperature Controlled';}
        if($this->european_deliveries){$services[] = 'European Deliveries';}
        if($this->ireland_deliveries){$services[] = 'Ireland Deliveries';}
        if($this->adr){$services[] = 'ADR';}
        if($this->day_24hours){$services[] = '24 hours a day';}
        if($this->week_7days){$services[] = '7 days a week';}
        
        return $services;
    }
    
    public function getCompany(){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("companies");
        return $table->fetchRow(array('company_id = ?' => $this->getCompanyId()));
    }    
}