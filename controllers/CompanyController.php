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

class CompanyController extends Zend_Controller_Action
{
    public function init()
    {
        // codes
    }

    public function indexAction()
    {
        // redirect to browse        
        return $this->_helper->redirector
                ->gotoRoute(array(), 'courier_search', true);
    }

    public function profileAction()
    {
        $companyId = $this->_getParam('id', false);
        if(!$companyId){
            return $this->_forward('error', 'error', 'default', array());
        }
        
        // get company by id
        $dbTableHelper = $this->_helper->getHelper('DbTable');
        $companyTable = $dbTableHelper->getTable("companies");
        $company = $companyTable->fetchRow(array('company_id = ?' => $companyId));
        
        // check user exists?
        if(!isset($company->company_id) || empty($company->company_id)){
            return $this->_forward('error', 'error', 'default', array());
        }
        
        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Courier Company Profile');
        
        // implement meta
        $metaKeys = array(); $metaDesc = array();
        if(!empty($company->company_name)){
            $metaKeys['company_name'] = $company->company_name;
            $metaDesc['company_name'] = $this->view->translate('%s is a popular courier and parcel delivery company in UK.', $company->company_name);
        }if($company->getFullAddressLine() != ''){
            //$metaKeys['address'] = $company->getFullAddressLine();
            $metaDesc['address'] = $this->view->translate('Company address is - %s.', $company->getFullAddressLine());
        }if(!empty($company->postcode)){
            $metaKeys['postcode'] = $this->view->translate('Couriers in %1$s, %1$s Couriers', $company->postcode);
            $metaDesc['postcode'] = $this->view->translate('A popular courier and parcel delivery company in %s.', $company->postcode);
        }if(($town = $company->getCity()) != null){
            $metaKeys['town'] = $this->view->translate('Couriers in %1$s, %1$s Couriers', $town->getTitle());
            $metaDesc['town'] = $this->view->translate('A popular courier and parcel delivery company in town - %s.', $town->getTitle());
        }if(($county = $company->getCounty()) != null){
            $metaKeys['county'] = $this->view->translate('Couriers in %1$s, %1$s Couriers', $county->getTitle());
            $metaDesc['county'] = $this->view->translate('A popular courier and parcel delivery company in %s.', $county->getTitle());
        }if(($country = $company->getCountry()) != null){
            $metaKeys['country'] = $this->view->translate('Couriers in %1$s, %1$s Couriers', $country->getTitle());
            $metaDesc['country'] = $this->view->translate('A popular courier and parcel delivery company in %s.', $country->getTitle());
        }if(($services = $company->getServices()) != null){
            if(count($services)>0){
                $serviceArr = $services[0]->getServices();
                if(count($serviceArr)>0){
                    $metaKeys['services'] = implode(', ', $serviceArr);
                    $metaDesc['services'] = $this->view->translate('Our provided services are - %s.', implode(', ', $serviceArr));
                }
            }
        }
        
        if(count($metaKeys)>0 AND count($metaDesc)>0){
            $this->view->headMeta()->setName('keywords', implode(', ', $metaKeys));
            $this->view->headMeta()->setName('description', implode(' ', $metaDesc));
        }
        
        // send to view
        $this->view->company = $company;
    }
    
    public function browseAction()
    {
        set_time_limit(0);
        
        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Courier Map Search');
        
        // implement meta
        $identity = "{$this->_getParam('module')}_{$this->_getParam('controller')}_{$this->_getParam('action')}";
        $pageInfo = $this->_helper->getHelper('Page')->getPage($identity);
        if($pageInfo AND $pageInfo->page_id){
            $this->view->headMeta()->setName('keywords', $pageInfo->getMetaKeys());
            $this->view->headMeta()->setName('description', $pageInfo->getMetaDesc());
        }

        // populate form
        $form = new Application_Form_Company_Filter();
    }

    public function listAction()
    {
        $formValues = array();
        $order = $this->_getParam('order', false);
        $keyword = $this->_getParam('keyword', false);
        $form = new Application_Form_Company_Filter();
        
        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Courier Listing Search');
        
        // implement meta
        $identity = "{$this->_getParam('module')}_{$this->_getParam('controller')}_{$this->_getParam('action')}";
        $pageInfo = $this->_helper->getHelper('Page')->getPage($identity);
        if($pageInfo AND $pageInfo->page_id){
            $this->view->headMeta()->setName('keywords', $pageInfo->getMetaKeys());
            $this->view->headMeta()->setName('description', $pageInfo->getMetaDesc());
        }

        // get tables
        $dbTableHelper = $this->_helper->getHelper('DbTable');
        $townTable = $dbTableHelper->getTable("towns");
        $countyTable = $dbTableHelper->getTable("counties");
        $companyTable = $dbTableHelper->getTable("companies");
        
        // prepare query
        $select = $companyTable->select()
                ->from($companyTable->info('name'))
                ->group("{$companyTable->info('name')}.company_id")
                ->order("{$companyTable->info('name')}.company_name ASC");
        
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

        // get companies
        $this->view->formValues = $formValues;
        $this->view->itemPerPage = $itemPerPage = 10;
        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);
        $this->view->paginator =$paginator;
    }
    
    public function availabilityAction()
    {
        $formValues = array();
        $order = $this->_getParam('order', false);
        $keyword = $this->_getParam('keyword', false);
        $form = new Application_Form_Company_Filter();
        
        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Available Couriers for Deliveries');
        
        // implement meta
        $identity = "{$this->_getParam('module')}_{$this->_getParam('controller')}_{$this->_getParam('action')}";
        $pageInfo = $this->_helper->getHelper('Page')->getPage($identity);
        if($pageInfo AND $pageInfo->page_id){
            $this->view->headMeta()->setName('keywords', $pageInfo->getMetaKeys());
            $this->view->headMeta()->setName('description', $pageInfo->getMetaDesc());
        }

        // get tables
        $dbTableHelper = $this->_helper->getHelper('DbTable');
        $townTable = $dbTableHelper->getTable("towns");
        $countyTable = $dbTableHelper->getTable("counties");
        $companyTable = $dbTableHelper->getTable("companies");
        $availabilityTable = $dbTableHelper->getTable("availabilities");
        
        // prepare query
        $select = $availabilityTable->select()
                ->from($availabilityTable->info('name'))
                ->join($companyTable->info('name'), "{$availabilityTable->info('name')}.company_id = {$companyTable->info('name')}.company_id", null)        
                ->group("{$availabilityTable->info('name')}.availability_id")
                ->order("{$availabilityTable->info('name')}.modified_date DESC");
        
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
        }elseif($keyword && !$order){
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

        // get companies
        $this->view->formValues = $formValues;
        $this->view->itemPerPage = $itemPerPage = 10;
        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);
        $this->view->paginator =$paginator;
    }
        
    public function mapAvailabilityAction()
    {
        $formValues = array();
        $order = $this->_getParam('order', false);
        $keyword = $this->_getParam('keyword', false);
        $form = new Application_Form_Company_Filter();
        
        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Available Couriers on Map for Deliveries');
        
        // implement meta
        $identity = "{$this->_getParam('module')}_{$this->_getParam('controller')}_{$this->_getParam('action')}";
        $pageInfo = $this->_helper->getHelper('Page')->getPage($identity);
        if($pageInfo && $pageInfo->page_id){
            $this->view->headMeta()->setName('keywords', $pageInfo->getMetaKeys());
            $this->view->headMeta()->setName('description', $pageInfo->getMetaDesc());
        }

        // get tables
        $dbTableHelper = $this->_helper->getHelper('DbTable');
        $townTable = $dbTableHelper->getTable("towns");
        $countyTable = $dbTableHelper->getTable("counties");
        $companyTable = $dbTableHelper->getTable("companies");
        $availabilityTable = $dbTableHelper->getTable("availabilities");
        
        // prepare query
        $select = $availabilityTable->select()
                ->from($availabilityTable->info('name'))
                ->join($companyTable->info('name'), "{$availabilityTable->info('name')}.company_id = {$companyTable->info('name')}.company_id", null)        
                ->group("{$availabilityTable->info('name')}.availability_id")
                ->order("{$availabilityTable->info('name')}.modified_date DESC");
        
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
        }elseif($keyword && !$order){
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

        // get companies
        $this->view->formValues = $formValues;
        $this->view->itemPerPage = $itemPerPage = 10;
        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);
        $this->view->paginator =$paginator;
    }
        
    public function sendEmailAction()
    {
        $this->view->message = false;
        $companyId = $this->_getParam('id', false);
        if(!$companyId){
            return $this->_forward('error', 'error', 'default', array());
        }
        
        // get company by id
        $dbTableHelper = $this->_helper->getHelper('DbTable');
        $table = $dbTableHelper->getTable("companies");
        $company = $table->fetchRow(array('company_id = ?' => $companyId));
        
        // check user exists?
        if(!isset($company->company_id) || empty($company->company_id)){
            return $this->_forward('error', 'error', 'default', array());
        }
        
        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Send Email to Courier Company');
        
        // implement meta
        $identity = "{$this->_getParam('module')}_{$this->_getParam('controller')}_{$this->_getParam('action')}";
        $pageInfo = $this->_helper->getHelper('Page')->getPage($identity);
        if($pageInfo && $pageInfo->page_id){
            $this->view->headMeta()->setName('keywords', $pageInfo->getMetaKeys());
            $this->view->headMeta()->setName('description', $pageInfo->getMetaDesc());
        }
        
        // send to view
        $this->view->company = $company;
        $this->view->form = $form 
                = new Application_Form_Company_Email();

        // Check form posted
        if(!$this->getRequest()->isPost()){
            return;
        }

        // Check form valid
        if(!$form->isValid($this->getRequest()->getPost())){
            return;
        }
        
        //get form values
        $values = $form->getValues();

        // send mail
        $company->sendMail($values);
    }
}