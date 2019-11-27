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

class Application_Model_Town extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->town_id;
    }
    
    public function getTitle(){
        return $this->town_name;
    }
    
    public function getTownName(){
        return $this->town_name;
    }
    
    public function getCountyId(){
        return (int) $this->county_id;
    }

    public function getCountryId(){
        return (int) $this->country_id;
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
    
}