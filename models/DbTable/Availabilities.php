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

class Application_Model_DbTable_Availabilities extends Aninda_Db_Table_Abstract
{
    protected $_name = 'availabilities';
    protected $_rowClass = 'Application_Model_Availability';

    public function getAvailabilityPaginator($params = array()){
        return Zend_Paginator::factory($this->getAvailabilitySelect($params));
    }
    
    public function getAvailabilities($params = array()){
        $select = $this->getAvailabilitySelect($params);
        return $this->fetchAll($select);
    }
    
    public function getAvailabilityAssoc($params = array()){
        $availabilityArray = array();
        $select = $this->getAvailabilitySelect($params);
        $availabilities =  $this->fetchAll($select);
        
        if(count($availabilities)>0){
            foreach($availabilities as $availability){
                $availabilityArray[$availability->getIdentity()] = htmlspecialchars($availability->getTitle());
            }
        }
        
        return $availabilityArray;
    }

    public function getAvailabilityCount($params = array()){
        $select = $this->getAvailabilitySelect($params);
        $availabilities =  $this->fetchAll($select);
        return (int) count($availabilities);
    }
    
    public function getAvailabilitySelect($params = array()){
        $select = $this->select();
        
        // if company_id?
        if(isset($params['company_id']) AND !empty($params['company_id'])){
            $select->where('company_id = ?', (int) $params['company_id']);
        }
        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$params['order']} ASC");
        }else{
            $select->order('availability_id ASC');
        }
        
        // limit
        if(isset($params['limit'])){
            $select->limit($params['limit']);
        }

        // group
        if(isset($params['group'])){
            $select->group($params['group']);
        }

        return $select;
    }    
    
    public function getAvailableCompanyPaginator($params = array()){
        return Zend_Paginator::factory($this->getAvailableCompanySelect($params));
    }
    
    public function getAvailableCompanySelect($params = array()){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $table = $helper->getTable("companies");
        
        // get select
        $select = $table->select();
        
        // like search
        if(isset($params['keyword'])){
            $select->where(
                    "
                        {$table->info('name')}.company_name LIKE ? OR
                        {$table->info('name')}.contact_name LIKE ? OR
                        {$table->info('name')}.email LIKE ? OR
                        {$table->info('name')}.phone_no LIKE ? OR
                        {$table->info('name')}.mobile_no LIKE ? OR
                        {$table->info('name')}.address LIKE ? OR
                        {$table->info('name')}.website LIKE ? OR
                        {$table->info('name')}.postcode LIKE ? OR
                        {$this->info('name')}.from_postcode LIKE ? OR
                        {$this->info('name')}.to_postcode LIKE ?
                    ", 
                    "%{$params['keyword']}%"
            );
        }
        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$table->info('name')}.{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$table->info('name')}.{$params['order']} ASC");
        }else{
            $select->order("{$this->info('name')}.modified_date DESC");
        }
        
        // limit
        if(isset($params['limit'])){
            $select->limit($params['limit']);
        }

        // group
        if(isset($params['group'])){
            $select->group("{$table->info('name')}.{$params['group']}");
        }

        return $select;
    }    
}