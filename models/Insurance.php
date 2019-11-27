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

class Application_Model_Insurance extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->insurance_id;
    }

    public function getCompanyId(){
        return $this->company_id;
    }
    
    public function getInsurance1(){
        return $this->insurance_company1;
    }
    
    public function getExpiryDate1(){
        return $this->expiry_date1;
    }
    
    public function getInsurance2(){
        return $this->insurance_company2;
    }
    
    public function getExpiryDate2(){
        return $this->expiry_date2;
    }
    
    public function getAmountCovered1(){
        return $this->amount_covered1;
    }
    
    public function getInsurance3(){
        return $this->insurance_company3;
    }
    
    public function getExpiryDate3(){
        return $this->expiry_date3;
    }
    
    public function getAmountCovered2(){
        return $this->amount_covered2;
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