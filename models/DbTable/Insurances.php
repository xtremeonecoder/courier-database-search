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

class Application_Model_DbTable_Insurances extends Aninda_Db_Table_Abstract
{
    protected $_name = 'insurances';
    protected $_rowClass = 'Application_Model_Insurance';
}

