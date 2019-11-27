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

class AvailabilityController extends Zend_Controller_Action
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
        if(!$viewer->isUser()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'admin_dashboard', true);
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
                ->gotoRoute(array('action' => 'browse'), 'company_availability', true);
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
                ->getView()->headTitle('Couriers Availability Schedule');
        
        // Get DbTable
        $helper = $this->_helper->getHelper('DbTable');
        
        // get viewer
        $viewer = $this->_helper->getHelper('User')->getViewer();
        
        // merge values
        $values = array(
            'company_id' => $viewer->getCompanyId(),
            'order' => 'availability_id',
            'direction' => 'DESC'
        );

        // get availabilities
        $itemPerPage = 20;
        $table = $helper->getTable("availabilities");
        $paginator = $table->getAvailabilityPaginator($values);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage($itemPerPage);
        $this->view->paginator =$paginator;
        $this->view->itemPerPage = $itemPerPage;
    }
    
    public function addAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }

        // page title
        $this->_helper->layout()
                ->getView()->headTitle('Add New Availability Schedule');

        // get viewer
        $viewer = $this->_helper->getHelper('User')->getViewer();
        
        // render form
        $this->view->form = $form 
                = new Application_Form_Company_Availability_Add();
                
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
        $values['enabled'] = 1;
        $values['owner_id'] = $viewer->getIdentity();
        $values['company_id'] = $viewer->getCompanyId();
        $values['creation_date'] = @date('Y-m-d H:i:s', time());
        $values['modified_date'] = @date('Y-m-d H:i:s', time());
        
        // get source & destination lat-lng
        $toLatLngAddr = "{$values['to_town_name']}, {$values['to_postcode']}, United Kingdom";
        $fromLatLngAddr = "{$values['from_town_name']}, {$values['from_postcode']}, United Kingdom";
        $toLatLng = $this->_helper->getHelper('LatLng')->getLatLng($toLatLngAddr);
        $fromLatLng = $this->_helper->getHelper('LatLng')->getLatLng($fromLatLngAddr);
        $values['to_lat'] = (string) $toLatLng['lat'];
        $values['to_lng'] = (string) $toLatLng['lng'];
        $values['from_lat'] = (string) $fromLatLng['lat'];
        $values['from_lng'] = (string) $fromLatLng['lng'];
        
        // start transaction
        $table = $this->_helper->getHelper('DbTable')->getTable("availabilities");
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            $availability = $table->createRow();
            $availability->setFromArray($values);
            $availability->save();
            
            // Commit
            $db->commit();        
            
            // redirect to page list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse'), 'company_availability', true);
        }catch(Exception $e){
            $db->rollBack();
            $form->addError($e->getMessage());
            throw $e;
        }
    }

    public function editAction()
    {
        // check user loggedin?
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector
                    ->gotoRoute(array(), 'member_login', true);
        }
        
        // data for layout
        $availabilityId = $this->_getParam('id', false);
        $this->_helper->layout()
                ->getView()->headTitle('Edit Availability Schedule');
        
        // forward to error
        if(!$availabilityId){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // render form
        $this->view->form = $form 
                = new Application_Form_Company_Availability_Edit();
        
        // get availability
        $table = $this->_helper->getHelper('DbTable')->getTable("availabilities");
        $availability = $table->fetchRow(array('availability_id = ?' => $availabilityId));
        
        // forward to error
        if(!$availability OR !$availability->availability_id){
           return $this->_forward('error', 'error', 'default', array());
        }
        
        // populate form
        $form->populate($availability->toArray());
        $this->view->availability = $availability;
        
        // assign city names
        $form->getElement('from_town_name')->setValue($availability->getFromTown()->getTitle());
        $form->getElement('to_town_name')->setValue($availability->getToTown()->getTitle());
        
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
        $values['modified_date'] = @date('Y-m-d H:i:s', time());
        
        // get source & destination lat-lng
        $toLatLngAddr = "{$values['to_town_name']}, {$values['to_postcode']}, United Kingdom";
        $fromLatLngAddr = "{$values['from_town_name']}, {$values['from_postcode']}, United Kingdom";
        $toLatLng = $this->_helper->getHelper('LatLng')->getLatLng($toLatLngAddr);
        $fromLatLng = $this->_helper->getHelper('LatLng')->getLatLng($fromLatLngAddr);
        $values['to_lat'] = (string) $toLatLng['lat'];
        $values['to_lng'] = (string) $toLatLng['lng'];
        $values['from_lat'] = (string) $fromLatLng['lat'];
        $values['from_lng'] = (string) $fromLatLng['lng'];
        
        // start transaction
        $db = $table->getAdapter();
        $db->beginTransaction();

        try{
            $availability->setFromArray($values);
            $availability->save();
            
            // Commit
            $db->commit();        
            
            // redirect to page list
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse'), 'company_availability', true);
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
        $pg = $this->_getParam('pg', false);
        $availabilityIds = $this->_getParam('id', false);
        $availabilityIds = explode(',', $availabilityIds);
        
        // check availability ids
        if(count($availabilityIds)>0){
            $table = $this->_helper->getHelper('DbTable')->getTable("availabilities");
            $availabilities = $table->fetchAll(array('availability_id IN (?)' => $availabilityIds));
            if(count($availabilities)>0){
                // start transaction
                $db = $table->getAdapter();
                $db->beginTransaction();

                try{
                    foreach($availabilities as $availability){
                        $availability->delete();
                    }
                    
                    // Commit
                    $db->commit();        
                }catch(Exception $e){
                    $db->rollBack();
                    throw $e;
                }                
            }
        }
        
        // redirect to page list
        if($pg > 1){
            return $this->_helper->redirector
                    ->gotoRoute(array('action' => 'browse', 'page' => $pg), 'company_availability', true);
        }
        return $this->_helper->redirector
                ->gotoRoute(array('action' => 'browse'), 'company_availability', true);
    }
}