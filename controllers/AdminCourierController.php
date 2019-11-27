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

class AdminCourierController extends Zend_Controller_Action
{
    public function init()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get viewer
        $viewer = $this->_helper->getHelper('User')->getViewer();
        if(!$viewer->isModerator() 
                && !$viewer->isAdmin() 
                && !$viewer->isSuperAdmin()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'user_dashboard', true);
        }
    }

    public function indexAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // redirect to browse
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'admin_courier_general', true);
    }
    
    public function browseAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier List');
        
        // filter form
        $page = $this->_getParam('page', 1);
        $this->view->formFilter = $formFilter 
                = new Application_Form_Admin_Courier_Filter();

        // Process form
        $values = array();
        $allData = $this->_getAllParams();
        $helper = $this->_helper->getHelper('DbTable');
        
        // get counties
        if(!empty($allData['country'])){
            $counties = $helper->getTable("counties")
                    ->getCountyAssoc(array('country_id' => $allData['country']));
            $counties[''] = '';
            asort($counties);
            $formFilter->getElement('county')->setMultiOptions($counties);
        }

        // get towns / cities
        if(!empty($allData['county'])){
            $towns = $helper->getTable("towns")
                    ->getTownAssoc(array('county_id' => $allData['county']));
            $towns[''] = '';
            asort($towns);
            $formFilter->getElement('city')->setMultiOptions($towns);
        }
        
        // validate
        if($formFilter->isValid($allData)){
            $values = $formFilter->getValues();
        }
        
        // unset empty value
        foreach($values as $key => $value){
          if($value == ''){
            unset($values[$key]);
          }
        }
        
        // merge values
        $values = array_merge(array(
          'order' => 'company_id',
          'direction' => 'DESC',
        ), $values);

        $this->view->assign($values);
        
        // Filter out junk
        $valuesCopy = array_filter($values);
       
        // get companies
        $itemPerPage = 20;
        $table = $helper->getTable("companies");
        $paginator = $table->getCompanyPaginator($values);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);
        $this->view->paginator =$paginator;
        $this->view->formValues = $valuesCopy;
        $this->view->itemPerPage = $itemPerPage;
    }
    
    public function editAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $companyId = $this->_getParam('id', false);
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Edit');
        
        // forward to error
        if(!$companyId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $this->view->form = $form 
                = new Application_Form_Admin_Courier_Edit();
        
        // get company data
        $table = $this->_helper->getHelper('DbTable')->getTable("companies");
        $company = $table->fetchRow(array('company_id = ?' => $companyId));
        $companyArray = $company->toArray();
        $companyArray['address1'] = $company->getAddress();
        $companyArray['city_name'] = $company->getCity()->getTitle();
        $companyArray['county_name'] = $company->getCounty()->getTitle();
        $companyArray['country_name'] = $company->getCountry()->getTitle();
        $form->populate($companyArray);
        $this->view->company = $company;
        
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
        
        // prepare address and other data
        $address = array();
        if(!empty($values['address1'])){
            $address[] = $values['address1'];
        }if(!empty($values['address2'])){
            $address[] = $values['address2'];
        }if(!empty($values['address3'])){
            $address[] = $values['address3'];
        }if(!empty($values['address4'])){
            $address[] = $values['address4'];
        }
        $values['address'] = implode(' ', $address);
        $values['modified_date'] = @date('Y-m-d H:i:s', time());
        $remoteAddress = $this->getRequest()->getServer('REMOTE_ADDR');
        $values['ipaddress'] = !empty($remoteAddress) 
                    ? $remoteAddress : $_SERVER['REMOTE_ADDR'];
        
        // get lat-lng from address
        $values['postcode'] = $this->_helper->getHelper('PdnValidators')->postCodeFormat($values['postcode']);
        $latLngAddr = !empty($values['address']) ? "{$values['address']}, " : "";
        $latLngAddr .= "{$values['city_name']}, {$values['county_name']}, {$values['postcode']}, {$values['country_name']}";
        $latLng = $this->_helper->getHelper('LatLng')->getLatLng($latLngAddr);
        $values['latitude'] = $latLng['lat'];
        $values['longitude'] = $latLng['lng'];

        // start transaction
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            $company->setFromArray($values);
            $company->save();
            
            // Commit
            $db->commit();        
            
            // redirect to company list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse'), 'admin_courier_general', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function deleteAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get ids and page id
        $page = $this->_getParam('pg', false);
        $companyIds = $this->_getParam('id', false);
        $companyIds = explode(',', $companyIds);
        
        // check company ids
        if(count($companyIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("companies");
            $companies = $table->fetchAll(array('company_id IN (?)' => $companyIds));
            if(count($companies)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($companies as $company){
                        $company->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to company list
        if($page > 1){
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse', 'page' => $page), 'admin_courier_general', true);
        }
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'admin_courier_general', true);
    }
    
    public function exportAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // disable layout
        set_time_limit(0);
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        // get companies
        $table = $this->_helper->getHelper('DbTable')->getTable("companies");
        $companies = $table->fetchAll();

        // get company table columns
        $tableColumns = array();
        foreach($table->info('cols') as $column){
            if(in_array($column, array('search', 'enabled'))){continue;}
            $tableColumns[] = trim(ucwords(str_replace('_', ' ', $column)));
        }
        
        // print excel header columns
        echo implode("\t", $tableColumns)."\n";
                
        // print row data
        if(count($companies)>0){
            foreach($companies as $company){
                $companyArray = $company->toArray();
                unset($companyArray['enabled'], $companyArray['search']);
                $companyArray['city'] = $company->getCity()->getTitle();
                $companyArray['county'] = $company->getCounty()->getTitle();
                $companyArray['country'] = $company->getCountry()->getTitle();
                echo implode("\t", $companyArray)."\n";
            }
        }
        
        // set header for excel
        header("Expires: 0");
        header("Content-Type: application/vnd.ms-excel");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Disposition: attachment;filename=courier-companies-" . time() . ".xls");
    }
    
    public function vehiclesAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $companyId = $this->_getParam('id', false);
        $helper = $this->_helper->getHelper('DbTable');
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Vehicles List');
                
        // get company
        $table = $helper->getTable("companies");
        $company = $table->fetchRow(array('company_id = ?' => $companyId));
        $vehicles = $company->getVehicles();
        $this->view->company =$company;
        $this->view->vehicles =$vehicles;
    }
    
    public function insuranceAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $companyId = $this->_getParam('id', false);
        $helper = $this->_helper->getHelper('DbTable');
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Insurance List');
                
        // get company
        $table = $helper->getTable("companies");
        $company = $table->fetchRow(array('company_id = ?' => $companyId));
        $insurances = $company->getInsurance();
        $this->view->company =$company;
        $this->view->insurances =$insurances;
    }
    
    public function paymentTermsAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $companyId = $this->_getParam('id', false);
        $helper = $this->_helper->getHelper('DbTable');
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Payment Terms List');
                
        // get company
        $table = $helper->getTable("companies");
        $company = $table->fetchRow(array('company_id = ?' => $companyId));
        $payments = $company->getPaymentTerms();
        $this->view->company =$company;
        $this->view->payments =$payments;
    }
    
    public function servicesAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $companyId = $this->_getParam('id', false);
        $helper = $this->_helper->getHelper('DbTable');
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Service List');
                
        // get company
        $table = $helper->getTable("companies");
        $company = $table->fetchRow(array('company_id = ?' => $companyId));
        $services = $company->getServices();
        $this->view->company =$company;
        $this->view->services =$services;
    }
    
}