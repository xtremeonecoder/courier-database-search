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

class Application_Model_DbTable_Mails extends Aninda_Db_Table_Abstract
{
    protected $_name = 'mails';
    protected $_rowClass = 'Application_Model_Mail';
    
    public function getMailPaginator($params = array()){
        return Zend_Paginator::factory($this->getMails($params));
    }
    
    public function getMails($params = array()){
        $select = $this->select();

        // enabled
        if(isset($params['enabled'])){
            $select->where('enabled = ?', (int) $params['enabled']);
        }
                        
        // order
        if(isset($params['order']) AND isset($params['direction'])){
            $select->order("{$params['order']} {$params['direction']}");
        }elseif(isset($params['order'])){
            $select->order("{$params['order']} ASC");
        }else{
            $select->order('mail_id ASC');
        }
        
        // limit
        if(isset($params['limit'])){
            $select->limit($params['limit']);
        }
        
        return $this->fetchAll($select);
    }
}