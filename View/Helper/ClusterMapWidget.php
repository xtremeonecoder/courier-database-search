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

class Aninda_View_Helper_ClusterMapWidget extends Zend_View_Helper_Abstract 
{
    public function clusterMapWidget() {
        set_time_limit(0);
        $formValues = array();
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $order = trim($request->getParam('order', false));
        $keyword = trim($request->getParam('keyword', false));
        
        $dbTableHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $townTable = $dbTableHelper->getTable("towns");
        $countyTable = $dbTableHelper->getTable("counties");
        $companyTable = $dbTableHelper->getTable("companies");
        
        // prepare query
        $select = $companyTable->select()
                ->from($companyTable->info('name'))
                ->group("{$companyTable->info('name')}.company_id")
                ->order("{$companyTable->info('name')}.company_name ASC")
                ;
        
        if($keyword && $order){
            if($order == 1){
                $select->where("{$companyTable->info('name')}.company_name LIKE ?", "%{$keyword}%");
            }elseif($order == 2){
                $select
                    ->join($townTable->info('name'), "{$companyTable->info('name')}.city = {$townTable->info('name')}.town_id", null)
                    ->where("{$townTable->info('name')}.town_name LIKE ?", "%{$keyword}%");
            }elseif($order == 3){
                $select
                    ->join($countyTable->info('name'), "{$companyTable->info('name')}.county = {$countyTable->info('name')}.county_id", null)
                    ->where("{$countyTable->info('name')}.county_name LIKE ?", "%{$keyword}%");
            }elseif($order == 4){
                $select->where("{$companyTable->info('name')}.postcode LIKE ?", "%{$keyword}%");
            }elseif($order == 5){
                $select->where("{$companyTable->info('name')}.contact_name LIKE ?", "%{$keyword}%");
            }elseif($order == 6){
                $select->where("{$companyTable->info('name')}.email LIKE ?", "%{$keyword}%");
            }
            
            // collect form value
            $formValues['order'] = $order;
            $formValues['keyword'] = $keyword;
        }elseif($keyword && !$order){
            $select
                ->join($townTable->info('name'), "{$companyTable->info('name')}.city = {$townTable->info('name')}.town_id", null)
                ->join($countyTable->info('name'), "{$companyTable->info('name')}.county = {$countyTable->info('name')}.county_id", null)
                ->where("
                    {$companyTable->info('name')}.company_name LIKE ? OR
                    {$companyTable->info('name')}.contact_name LIKE ? OR
                    {$companyTable->info('name')}.email LIKE ? OR
                    {$companyTable->info('name')}.postcode LIKE ? OR
                    {$companyTable->info('name')}.address LIKE ? OR
                    {$townTable->info('name')}.town_name LIKE ? OR
                    {$countyTable->info('name')}.county_name LIKE ?
                ", "%{$keyword}%");
                
            // collect form value
            $formValues['keyword'] = $keyword;
        }

        // get couriers
        $couriers =  $companyTable->fetchAll($select);
        
        // get xml object
        $xml = new DOMDocument('1.0', 'utf-8');
        
        // <markers>
        $markersRoot = $xml->createElement('markers');
        $xml->appendChild($markersRoot);
        
        if(count($couriers)>0){
            foreach($couriers as $courier){
                // <marker>
                $marker = $xml->createElement('marker');
                
                // lat
                $latAttr = $xml->createAttribute('lat');
                $latAttr->value = $courier->getLatitude();
                $marker->appendChild($latAttr);

                // lng
                $lngAttr = $xml->createAttribute('lng');
                $lngAttr->value = $courier->getLongitude();
                $marker->appendChild($lngAttr);

                // county
                $countyAttr = $xml->createAttribute('county');
                $countyAttr->value = $courier->getCounty()->getTitle();
                $marker->appendChild($countyAttr);

                // href
                $hrefAttr = $xml->createAttribute('href');
                $hrefAttr->value = $courier->getHref();
                $marker->appendChild($hrefAttr);

                // title
                $titleAttr = $xml->createAttribute('title');
                $titleAttr->value = htmlentities($courier->getTitle(), ENT_QUOTES);
                $marker->appendChild($titleAttr);

                // email
                $emailAttr = $xml->createAttribute('email');
                $emailAttr->value = $courier->getEmail();
                $marker->appendChild($emailAttr);

                // email href
                $emailHrefAttr = $xml->createAttribute('emailhref');
                $emailHrefAttr->value = $courier->getEmailHref();
                $marker->appendChild($emailHrefAttr);

                // website
                $websiteAttr = $xml->createAttribute('website');
                $websiteAttr->value = $courier->getWebsite();
                $marker->appendChild($websiteAttr);

                // mobile number
                $mobileAttr = $xml->createAttribute('mobile');
                $mobileAttr->value = $courier->getMobileNo();
                $marker->appendChild($mobileAttr);

                // address
                $addressAttr = $xml->createAttribute('address');
                $addressAttr->value = htmlentities($courier->getFullAddressLine(), ENT_QUOTES);
                $marker->appendChild($addressAttr);

                // add marker to root
                $markersRoot->appendChild($marker);
            }
        }    
            
        $output = $xml->saveXML();
        $fileName = 'couriers.xml';
        $fileDir = realpath(APPLICATION_PATH.'/../public/gmap-icons');
        $fileFullPath = "{$fileDir}/{$fileName}";
        $xml->save($fileFullPath);

        // Setting up headers and body
        $front = Zend_Controller_Front::getInstance();
        $front->getResponse()
             ->setHeader('Content-Disposition', "inline; filename={$fileName}")
             ->setHeader('Content-Type', 'text/xml; charset=utf-8')
             ->setBody($output);

        // remove header after xml file creation
        $front->getResponse()->clearAllHeaders()->clearRawHeaders();
             
        // get google api key
        $apiKey = $dbTableHelper->getTable("settings")->getSetting('google.api.key');
        
        // call partials
        return $this->view->partial(
            'helper-scripts/_clusterMapWidget.phtml',
            array('fullPath' => $fileFullPath, 'apiKey' => $apiKey->value)
        );
    }
}