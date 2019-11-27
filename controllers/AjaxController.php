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

class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();        
    }

    public function indexAction()
    {
        // action body
    }

    public function getTownListAction()
    {
        // get data
        set_time_limit(0);
        $input = $this->_getParam('input', false);
        $county = $this->_getParam('county', false);
        $limit = $this->_getParam('limit', false);
        $limit = $limit ? (int) $limit : 0;
        
        // get town table
        $table = $this->_helper->getHelper('DbTable')->getTable("towns");
        if($input){
            $input = strtolower($input);
            $townData = $table->getTownDetailsAssoc(array('town_name' => $input));
        }else{
            if($county){
                $townData['status'] = 'success';
                $townData['result'] = $table->getTownAssoc(array('county_id' => $county));
            }else{
                $townData['status'] = 'failed';
            }
        }
        
        // output json data
        echo Zend_Json::encode($townData);
        exit();
    }

    public function getTownDetailsAction()
    {
        // get data
        $data = array();
        $townId = $this->_getParam('id', false);
        
        // check town id
        if(!$townId){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }            
        
        // get town table
        $table = $this->_helper->getHelper('DbTable')->getTable("towns");
        $town = $table->fetchRow(array('town_id = ?' => $townId));

        // check town
        if(!$town){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }            

        // get county and country of town
        $county = $town->getCounty();
        $country = $town->getCountry();
        
        // check county and country
        if(!$county OR !$country){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);
            exit();
        }            

        // prepare town details data
        $data['status'] = 'success';
        $data['countyid'] = $county->getIdentity();
        $data['countryid'] = $country->getIdentity();
        $data['countyname'] = htmlspecialchars($county->getCountyName());
        $data['countryname'] = htmlspecialchars($country->getCountryName());
        echo Zend_Json::encode($data);
        exit();
    }

    public function validatePostCodeAction()
    {
        $data = array();
        $postCode = $this->_getParam('postcode', false);

        // check validation
        if(!$postCode OR !$this->_helper->getHelper('PdnValidators')->isValidPostCode($postCode)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateEmailAction()
    {
        $data = array();
        $edit = $this->_getParam('edit', false);
        $email = $this->_getParam('email', false);
        if(!$email){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        // form
        if($edit){
            $form = new Application_Form_Admin_Courier_Edit();
        }else{
            $form = new Application_Form_Register_Contact();
        }
        
        // check validation
        if($form->getElement('email')->isValid($email)){
            $data['status'] = 'success';
            echo Zend_Json::encode($data);   
            exit();
        }else{
            $errors = $form->getElement('email')->getErrors();
            if(in_array('recordFound', $errors)){
               $data['error'] = 'error'; 
            }
        }
        
        $data['status'] = 'failed';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateMobileNumberAction()
    {
        $data = array();
        $mobile = $this->_getParam('mobile', false);
        
        // form
        $form = new Application_Form_Register_Contact();
        $mobileElement = $form->getElement('mobile_no');
        
        // if mobile empty clear validations
        if(!$mobile){
            $mobileElement->clearValidators();
        }
        
        // check validation
        if(!$mobileElement->isValid($mobile)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validatePhoneNumberAction()
    {
        $data = array();
        $phone = $this->_getParam('phone', false);
        
        // form
        $form = new Application_Form_Register_Contact();
        $phoneElement = $form->getElement('phone_no');
        
        // if phone empty clear validations
        if(!$phone){
            $phoneElement->clearValidators();
        }
        
        // check validation
        if(!$phoneElement->isValid($phone)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateCompanyNameAction()
    {
        $data = array();
        $company = $this->_getParam('company', false);
        
        // form
        $form = new Application_Form_Register_Contact();
        $companyElement = $form->getElement('company_name');
        
        // if website empty clear validations
        if(!$company){
            //$companyElement->clearValidators();
        }
        
        // check validation
        if(!$companyElement->isValid($company)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateContactNameAction()
    {
        $data = array();
        $contact = $this->_getParam('contact', false);
        
        // form
        $form = new Application_Form_Register_Contact();
        $contactElement = $form->getElement('contact_name');
        
        // if website empty clear validations
        if(!$contact){
            $contactElement->clearValidators();
        }
        
        // check validation
        if(!$contactElement->isValid($contact)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateAddressAction()
    {
        $data = array();
        $address = $this->_getParam('address', false);
        
        // form
        $form = new Application_Form_Register_Contact();
        $addressElement = $form->getElement('address1');
        
        // if address empty clear validations
        if(!$address){
            //$addressElement->clearValidators();
        }
        
        // check validation
        if(!$addressElement->isValid($address)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateCityNameAction()
    {
        $data = array();
        $city = $this->_getParam('city', false);
        if(!$city OR strlen($city)<4){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        // check validation
        $table = $this->_helper->getHelper('DbTable')->getTable("towns");
        $townData = $table->getTownAssoc(array('town_name' => $city));
        if(count($townData)>0){
            $data['status'] = 'success';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'failed';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function validateWebsiteAction()
    {
        $data = array();
        $website = $this->_getParam('website', false);
        
        // form
        $form = new Application_Form_Register_Contact();
        $websiteElement = $form->getElement('website');
        
        // if website empty clear validations
        if(!$website){
            $websiteElement->clearValidators();
        }
        
        // check validation
        if(!$websiteElement->isValid($website)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }

    public function getCountyListAction()
    {
        // get data
        set_time_limit(0);
        $data = array();
        $country = $this->_getParam('country', false);
        
        // get county table
        $table = $this->_helper->getHelper('DbTable')->getTable("counties");
        if($country){
            $data['status'] = 'success';
            $data['result'] = $table->getCountyAssoc(array('country_id' => $country));
        }else{
            $data['status'] = 'failed';
        }
        
        // output json data
        echo Zend_Json::encode($data);
        exit();
    }

    public function validateExpiryDateAction()
    {
        $data = array();
        $fieldName = $this->_getParam('fieldname', false);
        $expirydate = $this->_getParam('expirydate', false);
        
        // form
        $form = new Application_Form_Register_Insurance();
        $expiryDateElement = $form->getElement($fieldName);
        
        // if expiry date empty clear validations
        if(!$expirydate){
            $expiryDateElement->clearValidators();
        }
        
        // check validation
        if(!$expiryDateElement->isValid($expirydate)){
            $data['status'] = 'failed';
            echo Zend_Json::encode($data);   
            exit();
        }
        
        $data['status'] = 'success';
        echo Zend_Json::encode($data);   
        exit();
    }    
}