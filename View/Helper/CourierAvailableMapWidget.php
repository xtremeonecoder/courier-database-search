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

class Aninda_View_Helper_CourierAvailableMapWidget extends Zend_View_Helper_Abstract 
{
    public function courierAvailableMapWidget() {
        $formValues = array();
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $order = trim($request->getParam('order', false));
        $keyword = trim($request->getParam('keyword', false));
        
        // get tables
        $dbTableHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $townTable = $dbTableHelper->getTable("towns");
        $countyTable = $dbTableHelper->getTable("counties");
        $companyTable = $dbTableHelper->getTable("companies");
        $availabilityTable = $dbTableHelper->getTable("availabilities");
        
        // prepare query
        $select = $availabilityTable->select()
                ->from($availabilityTable->info('name'))
                ->join($companyTable->info('name'), "{$availabilityTable->info('name')}.company_id = {$companyTable->info('name')}.company_id", null)        
                ->group("{$availabilityTable->info('name')}.availability_id")
                ->order("{$availabilityTable->info('name')}.modified_date DESC")
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
                $select->where("(
                        {$companyTable->info('name')}.postcode LIKE ? OR 
                        {$availabilityTable->info('name')}.from_postcode LIKE ? OR 
                        {$availabilityTable->info('name')}.to_postcode LIKE ?)", 
                        "%{$keyword}%"
                );
            }elseif($order == 5){
                $select->where("{$companyTable->info('name')}.contact_name LIKE ?", "%{$keyword}%");
            }elseif($order == 6){
                $select->where("{$companyTable->info('name')}.email LIKE ?", "%{$keyword}%");
            }
            
            // collect form value
            $formValues['order'] = $order;
            $formValues['keyword'] = $keyword;
        }elseif($keyword AND !$order){
            $select
                ->join($townTable->info('name'), "{$companyTable->info('name')}.city = {$townTable->info('name')}.town_id", null)
                ->join($countyTable->info('name'), "{$companyTable->info('name')}.county = {$countyTable->info('name')}.county_id", null)
                ->where("
                    {$companyTable->info('name')}.company_name LIKE ? OR
                    {$companyTable->info('name')}.contact_name LIKE ? OR
                    {$companyTable->info('name')}.email LIKE ? OR
                    {$companyTable->info('name')}.postcode LIKE ? OR
                    {$availabilityTable->info('name')}.from_postcode LIKE ? OR
                    {$availabilityTable->info('name')}.to_postcode LIKE ? OR
                    {$companyTable->info('name')}.address LIKE ? OR
                    {$townTable->info('name')}.town_name LIKE ? OR
                    {$countyTable->info('name')}.county_name LIKE ?
                ", "%{$keyword}%");
                
            // collect form value
            $formValues['keyword'] = $keyword;
        }

        // get availabilities
        $itemPerPage = 50;
        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($request->getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);

        // get google api key
        $apiKey = $dbTableHelper->getTable("settings")->getSetting('google.api.key');
        
        return $this->view->partial(
            'helper-scripts/_courierAvailableMapWidget.phtml',
            array(
                'paginator' => $paginator, 
                'itemPerPage' => $itemPerPage, 
                'formValues' => $formValues,
                'apiKey' => $apiKey->value
            )
        );
    }
}