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

class AdminCourierEditController extends Zend_Controller_Action
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
        if(!$viewer->isModerator() AND !$viewer->isAdmin() AND !$viewer->isSuperAdmin()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'user_dashboard', true);
        }
    }

    public function editVehicleAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $vehicleId = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Vehicle Edit');
        
        // forward to error
        if(!$companyId OR !$vehicleId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $helper = $this->_helper->getHelper('DbTable');
        $this->view->form = $form 
                = new Application_Form_Admin_Courier_Vehicles();
        
        // get company data
        $ctable = $helper->getTable("companies");
        $company = $ctable->fetchRow(array('company_id = ?' => $companyId));
        $vtable = $helper->getTable("vehicles");
        $vehicle = $vtable->fetchRow(array('vehicle_id = ?' => $vehicleId));
        $vehicleArray = $vehicle->toArray();
        $form->populate($vehicleArray);
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

        // start transaction
        $db = $vtable->getAdapter();
        $db->beginTransaction();

        try{
            $values['modified_date'] = @date('Y-m-d H:i:s', time());
            $vehicle->setFromArray($values);
            $vehicle->save();
            
            // Commit
            $db->commit();        
            
            // redirect to vehicles list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'vehicles', 'id' => $company->getIdentity()), 'admin_courier_action', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function deleteVehicleAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get ids and page id
        $vehicleIds = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $vehicleIds = explode(',', $vehicleIds);
        
        // check vehicle ids
        if(count($vehicleIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("vehicles");
            $vehicles = $table->fetchAll(array('vehicle_id IN (?)' => $vehicleIds));
            if(count($vehicles)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($vehicles as $vehicle){
                        $vehicle->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to vehicles list
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'vehicles', 'id' => $companyId), 'admin_courier_action', true);
    }
    
    public function editInsuranceAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $insuranceId = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Insurance Edit');
        
        // forward to error
        if(!$companyId OR !$insuranceId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $helper = $this->_helper->getHelper('DbTable');
        $this->view->form = $form 
                = new Application_Form_Admin_Courier_Insurance();
        
        // get company data
        $ctable = $helper->getTable("companies");
        $company = $ctable->fetchRow(array('company_id = ?' => $companyId));
        $itable = $helper->getTable("insurances");
        $insurance = $itable->fetchRow(array('insurance_id = ?' => $insuranceId));
        $insuranceArray = $insurance->toArray();
        $form->populate($insuranceArray);
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

        // start transaction
        $db = $itable->getAdapter();
        $db->beginTransaction();

        try{
            $values['modified_date'] = @date('Y-m-d H:i:s', time());
            $insurance->setFromArray($values);
            $insurance->save();
            
            // Commit
            $db->commit();        
            
            // redirect to vehicles list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'insurance', 'id' => $company->getIdentity()), 'admin_courier_action', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function deleteInsuranceAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get ids and page id
        $insuranceIds = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $insuranceIds = explode(',', $insuranceIds);
        
        // check insurance ids
        if(count($insuranceIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("insurances");
            $insurances = $table->fetchAll(array('insurance_id IN (?)' => $insuranceIds));
            if(count($insurances)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($insurances as $insurance){
                        $insurance->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to insurance list
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'insurance', 'id' => $companyId), 'admin_courier_action', true);
    }
    
    public function editPaymentTermAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $paymentId = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Payment Terms Edit');
        
        // forward to error
        if(!$companyId OR !$paymentId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $helper = $this->_helper->getHelper('DbTable');
        $this->view->form = $form 
                = new Application_Form_Admin_Courier_Payment();
        
        // get company data
        $ctable = $helper->getTable("companies");
        $company = $ctable->fetchRow(array('company_id = ?' => $companyId));
        $ptable = $helper->getTable("paymentsettings");
        $payment = $ptable->fetchRow(array('paymentsetting_id = ?' => $paymentId));
        $paymentArray = $payment->toArray();
        $form->populate($paymentArray);
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

        // start transaction
        $db = $ptable->getAdapter();
        $db->beginTransaction();

        try{
            $values['modified_date'] = @date('Y-m-d H:i:s', time());
            $payment->setFromArray($values);
            $payment->save();
            
            // Commit
            $db->commit();        
            
            // redirect to vehicles list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'payment-terms', 'id' => $company->getIdentity()), 'admin_courier_action', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function deletePaymentTermAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get ids and page id
        $paymentIds = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $paymentIds = explode(',', $paymentIds);
        
        // check payment ids
        if(count($paymentIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("paymentsettings");
            $payments = $table->fetchAll(array('paymentsetting_id IN (?)' => $paymentIds));
            if(count($payments)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($payments as $payment){
                        $payment->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to payment terms list
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'payment-terms', 'id' => $companyId), 'admin_courier_action', true);
    }
    
    public function editServiceAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $serviceId = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $this->_helper->layout()
                ->getView()->headTitle('Admin Courier Service Edit');
        
        // forward to error
        if(!$companyId OR !$serviceId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $helper = $this->_helper->getHelper('DbTable');
        $this->view->form = $form 
                = new Application_Form_Admin_Courier_Services();
        
        // get company data
        $ctable = $helper->getTable("companies");
        $company = $ctable->fetchRow(array('company_id = ?' => $companyId));
        $stable = $helper->getTable("services");
        $service = $stable->fetchRow(array('service_id = ?' => $serviceId));
        $serviceArray = $service->toArray();
        $form->populate($serviceArray);
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

        // start transaction
        $db = $stable->getAdapter();
        $db->beginTransaction();

        try{
            $values['modified_date'] = @date('Y-m-d H:i:s', time());
            $service->setFromArray($values);
            $service->save();
            
            // Commit
            $db->commit();        
            
            // redirect to vehicles list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'services', 'id' => $company->getIdentity()), 'admin_courier_action', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function deleteServiceAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // get ids and page id
        $serviceIds = $this->_getParam('id', false);
        $companyId = $this->_getParam('cid', false);
        $serviceIds = explode(',', $serviceIds);
        
        // check service ids
        if(count($serviceIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("services");
            $services = $table->fetchAll(array('service_id IN (?)' => $serviceIds));
            if(count($services)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($services as $service){
                        $service->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to vehicles list
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'services', 'id' => $companyId), 'admin_courier_action', true);
    }
    
}