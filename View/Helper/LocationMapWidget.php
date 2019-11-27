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

class Aninda_View_Helper_LocationMapWidget extends Zend_View_Helper_Abstract 
{
    public function locationMapWidget($location = false) {
        if(!$location){
            return false;
        }
        
        // get google api key
        $apiKey = $dbTableHelper->getTable("settings")->getSetting('google.api.key');
        
        // get location details from address
        $location = urlencode($location);
        $apiUrl = "http://maps.googleapis.com/maps/api/geocode/json?address={$location}&key={$apiKey->value}";
        $locationData = json_decode(file_get_contents($apiUrl));

        // check status?
        if($locationData->status != 'OK'){
            return false;
        }
        
        $location = $locationData->results[0]->geometry->location;
        $formatedAddress = (string) $locationData->results[0]->formatted_address;
                
        return $this->view->partial(
            'helper-scripts/_locationMapWidget.phtml',
            array(
                'location' => $location, 
                'apiKey' => $apiKey->value, 
                'address' => $formatedAddress
            )
        );
    }
}