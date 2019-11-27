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

class Aninda_View_Helper_CourierDetailsWidget extends Zend_View_Helper_Abstract 
{
    public function courierDetailsWidget($company = null){
        // check company?
        if(!$company){
            return null;
        }
        
        // call partial
        return $this->view->partial(
            'helper-scripts/_courierDetailsWidget.phtml',
            array('company' => $company)
        );        
    }
}