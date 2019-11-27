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

class Application_Model_DbTable_Countries extends Aninda_Db_Table_Abstract
{
    protected $_name = 'countries';
    protected $_rowClass = 'Application_Model_Country';
    
    public function getCountries($params = array()){
        $select = $this->select();
        
        // for country_name
        if(isset($params['country_name']) AND isset($params['left'])){
            $select->where('country_name LIKE ?', "{$params['country_name']}%");
        }elseif(isset($params['country_name']) AND isset($params['right'])){
            $select->where('country_name LIKE ?', "%{$params['country_name']}");
        }elseif(isset($params['country_name'])){
            $select->where('country_name LIKE ?', "%{$params['country_name']}%");
        }
        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$params['order']} ASC");
        }else{
            $select->order('country_name ASC');
        }
        
        // limit
        if(isset($params['limit'])){
            $select->limit($params['limit']);
        }
                
        return $this->fetchAll($select);
    }
    
    public function getCountryAssoc($params = array()){
        $countryArray = array();
        $countries = $this->getCountries($params);
        
        if(count($countries)>0){
            foreach($countries as $country){
                $countryArray[$country->getIdentity()] = htmlspecialchars($country->getTitle());
            }
        }
        
        return $countryArray;
    }
}

