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

class Application_Model_Country extends Zend_Db_Table_Row_Abstract
{
    public function getIdentity(){
        return (int) $this->country_id;
    }

    public function getTitle(){
        return $this->country_name;
    }    
    
    public function getCountryName(){
        return $this->country_name;
    }    
}