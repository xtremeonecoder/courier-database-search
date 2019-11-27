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

class Helper_DbTable extends Zend_Controller_Action_Helper_Abstract
{
    public function getTable($tableName = false) {
        if(!$tableName){
            return null;
        }
        
        $tableName = str_replace(' ', '', ucwords(str_replace('_', ' ', $tableName)));
        $className = "Application_Model_DbTable_{$tableName}";
        return new $className();
    }
}