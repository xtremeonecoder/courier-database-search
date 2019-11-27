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

class Application_Model_DbTable_Companies extends Aninda_Db_Table_Abstract
{
    protected $_name = 'companies';
    protected $_rowClass = 'Application_Model_Company';

    public function getCompanyPaginator($params = array()){
        return Zend_Paginator::factory($this->getCompanySelect($params));
    }
    
    public function getCompanies($params = array()){
        $select = $this->getCompanySelect($params);
        return $this->fetchAll($select);
    }
    
    public function getCompanyAssoc($params = array()){
        $companyArray = array();
        $select = $this->getCompanySelect($params);
        $companies =  $this->fetchAll($select);
        
        if(count($companies)>0){
            foreach($companies as $company){
                $companyArray[$company->getIdentity()] = htmlspecialchars($company->getTitle());
            }
        }
        
        return $companyArray;
    }

    public function getIPAddressAssoc($params = array()){
        $ipAddressArray = array();
        $select = $this->getCompanySelect($params);
        $companies =  $this->fetchAll($select);
        
        if(count($companies)>0){
            foreach($companies as $company){
                $ipAddressArray[$company->getIpAddress()] = $company->getIpAddress();
            }
        }
        
        return $ipAddressArray;
    }

    public function getCompanyCount($params = array()){
        $select = $this->getCompanySelect($params);
        $companies =  $this->fetchAll($select);
        return (int) count($companies);
    }
    
    public function getCompanySelect($params = array()){
        $select = $this->select();
        
        // like search
        if(isset($params['keyword'])){
            $select->where(
                    "
                        company_name LIKE ? OR
                        contact_name LIKE ? OR
                        email LIKE ? OR
                        phone_no LIKE ? OR
                        mobile_no LIKE ? OR
                        address LIKE ? OR
                        website LIKE ? OR
                        postcode LIKE ?
                    ", 
                    "%{$params['keyword']}%");
        }
        
        // for city / town
        if(isset($params['city'])){
            $select->where('city = ?', (int) $params['city']);
        }
        
        // for county
        if(isset($params['county'])){
            $select->where('county = ?', (int) $params['county']);
        }
        
        // for country
        if(isset($params['country'])){
            $select->where('country = ?', (int) $params['country']);
        }

        // for ip address
        if(isset($params['ipaddress'])){
            if(isset($params['ipoperator'])){
                $select->where('ipaddress != ?', $params['ipaddress']);
            }else{
                $select->where('ipaddress = ?', $params['ipaddress']);
            }
        }

        // for operator code
        if(isset($params['operatorcode'])){
            $select->where('operatorcode = ?', $params['operatorcode']);
        }
        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$params['order']} ASC");
        }else{
            $select->order('company_name ASC');
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
}