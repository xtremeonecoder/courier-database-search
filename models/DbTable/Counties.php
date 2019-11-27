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

class Application_Model_DbTable_Counties extends Aninda_Db_Table_Abstract
{
    protected $_name = 'counties';
    protected $_rowClass = 'Application_Model_County';
    
    public function getCounties($params = array()){
        $select = $this->select();
        
        // for country
        if(isset($params['country_id'])){
            $select->where('country_id = ?', (int) $params['country_id']);
        }
        
        // for county_name
        if(isset($params['county_name']) AND isset($params['left'])){
            $select->where('county_name LIKE ?', "{$params['county_name']}%");
        }elseif(isset($params['county_name']) AND isset($params['right'])){
            $select->where('county_name LIKE ?', "%{$params['county_name']}");
        }elseif(isset($params['county_name'])){
            $select->where('county_name LIKE ?', "%{$params['county_name']}%");
        }
        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$params['order']} ASC");
        }else{
            $select->order('county_name ASC');
        }
        
        // limit
        if(isset($params['limit'])){
            $select->limit($params['limit']);
        }
                
        return $this->fetchAll($select);
    }
    
    public function getCountyAssoc($params = array()){
        $countyArray = array();
        $counties = $this->getCounties($params);
        
        if(count($counties)>0){
            foreach($counties as $county){
                $countyArray[$county->getIdentity()] = htmlspecialchars($county->getTitle());
            }
        }
        
        return $countyArray;
    }    
}

