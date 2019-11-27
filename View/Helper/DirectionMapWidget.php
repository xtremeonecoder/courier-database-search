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

class Aninda_View_Helper_DirectionMapWidget extends Zend_View_Helper_Abstract 
{
    public function directionMapWidget($params = array()) {
        // get google api key
        $apiKey = $dbTableHelper->getTable("settings")->getSetting('google.api.key');
        
        return $this->view->partial(
            'helper-scripts/_directionMapWidget.phtml',
            array('direction' => $params, 'apiKey' => $apiKey->value)
        );
    }
}