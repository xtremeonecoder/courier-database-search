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

class Application_Model_DbTable_Towns extends Aninda_Db_Table_Abstract
{
    protected $_name = 'towns';
    protected $_rowClass = 'Application_Model_Town';
    
    public function getTowns($params = array()){
        $select = $this->select();
        
        // for county
        if(isset($params['county_id'])){
            $select->where('county_id = ?', (int) $params['county_id']);
        }
        
        // for country
        if(isset($params['country_id'])){
            $select->where('country_id = ?', (int) $params['country_id']);
        }
        
        // for town_name
        if(isset($params['town_name']) AND isset($params['left'])){
            $select->where('town_name LIKE ?', "{$params['town_name']}%");
        }elseif(isset($params['town_name']) AND isset($params['right'])){
            $select->where('town_name LIKE ?', "%{$params['town_name']}");
        }elseif(isset($params['town_name'])){
            $select->where('town_name LIKE ?', "%{$params['town_name']}%");
        }
        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$params['order']} ASC");
        }else{
            $select->order('town_name ASC');
        }
        
        // limit
        if(isset($params['limit'])){
            $select->limit($params['limit']);
        }
                
        return $this->fetchAll($select);
    }
    
    public function getTownAssoc($params = array()){
        $townArray = array();
        $towns = $this->getTowns($params);
        
        if(count($towns)>0){
            foreach($towns as $town){
                $townArray[$town->getIdentity()] = htmlspecialchars($town->getTownName());
            }
        }
        
        return $townArray;
    }
    
    public function getTownDetailsAssoc($params = array()){
        $townArray = array('results' => array());
        $towns = $this->getTowns($params);

        if(count($towns)>0){
            foreach($towns as $town){
                $county = $town->getCounty();
                $country = $town->getCountry();
                $countyName = htmlspecialchars($county->getCountyName());
                $countryName = htmlspecialchars($country->getCountryName());
                $townArray['results'][] = array(
                    'id' => $town->getIdentity(),
                    'info' => "{$countyName}, {$countryName}",
                    'value' => htmlspecialchars($town->getTownName())
                    //'countyid' => $county->getIdentity(),
                    //'countyname' => $countyName,
                    //'countryid' => $country->getIdentity(),
                    //'countryname' => $countryName
                );
            }
        }
        
        return $townArray;
    }
}

