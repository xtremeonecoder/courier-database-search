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

class Application_Form_Admin_Courier_Edit extends Zend_Form
{
    public function init()
    {
        $tabindex = 1;
        $this->setAttrib('id', 'courier_edit_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

        // to show the errors above the form
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend'))
        ));        
        
        // Company Name
        $this->addElement('Text', 'company_name', array(
          'label' => 'Company Name',
          'placeholder' => 'Company Name',    
          'allowEmpty' => false,
          'required' => true,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->company_name->removeDecorator('Errors');
        
        // Complany Address Line-1
        $this->addElement('Text', 'address1', array(
          'label' => 'Address 1',
          'placeholder' => 'Address 1',
          'allowEmpty' => false,
          'required' => true,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->address1->removeDecorator('Errors');
        
        // Complany Address Line-2
        $this->addElement('Text', 'address2', array(
          'label' => 'Address 2 (Optional)',
          'placeholder' => 'Address 2 (Optional)',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->address2->removeDecorator('Errors');
        
        // Complany Address Line-3
        $this->addElement('Text', 'address3', array(
          'label' => 'Address 3 (Optional)',
          'placeholder' => 'Address 3 (Optional)',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->address3->removeDecorator('Errors');
        
        // Complany Address Line-4
        $this->addElement('Text', 'address4', array(
          'label' => 'Address 4 (Optional)',
          'placeholder' => 'Address 4 (Optional)',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->address4->removeDecorator('Errors');
        
        // Town / City Name
        $this->addElement('Text', 'city_name', array(
          'label' => 'Town / City',
          'placeholder' => 'Town / City',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->city_name->removeDecorator('Errors');
        
        // City ID Hiddne
        $this->addElement('Hidden', 'city', array(
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->city->removeDecorator('Errors');
        
        // County Name
        $this->addElement('Text', 'county_name', array(
          'label' => 'County',
          'placeholder' => 'County',
          'readonly' => 'readonly',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->county_name->removeDecorator('Errors');
        
        // County ID Hiddne
        $this->addElement('Hidden', 'county', array(
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->county->removeDecorator('Errors');
        
        // Country Name
        $this->addElement('Text', 'country_name', array(
          'label' => 'Country',
          'placeholder' => 'Country',
          'readonly' => 'readonly',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->country_name->removeDecorator('Errors');
        
        // Country ID Hiddne
        $this->addElement('Hidden', 'country', array(
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->country->removeDecorator('Errors');
        
        // Post Code
        $this->addElement('Text', 'postcode', array(
          'label' => 'Post Code',
          'placeholder' => 'Post Code',
          'allowEmpty' => false,
          'required' => true,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512))
          ),
        ));
        $this->postcode->removeDecorator('Errors');
        $specialValidator = new Aninda_Validate_Callback(array($this, 'checkValidPostcode'), $this->postcode);
        $specialValidator->setMessage('Invalid post code entered!', 'invalid');
        $this->postcode->addValidator($specialValidator);
        
        // Website Number
        $this->addElement('Text', 'website', array(
          'label' => 'Company Website',
          'placeholder' => 'Company Website',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'class' => 'span5',
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 128)),
            //array('Regex', true, array('/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/i')),
            array('Regex', true, array('/(http|https):\/\/([a-z]([a-z0-9\-]*\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel|tel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}[0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(:[0-9]{1,5})?(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&amp;]*)?)?(#[a-z][a-z0-9_]*)?$/i')),
          ),
        ));
        $this->website->removeDecorator('Errors');        
        $this->website->getValidator('Regex')->setMessage('Invalid website address entered!', 'regexNotMatch');
        
        // Company Email
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
        $tableName = $helper->getTable("companies")->info('name');        
        $this->addElement('Text', 'email', array(
          'label' => 'Email Address',
          'placeholder' => 'Email Address',  
          'required' => true,
          'tabindex' => $tabindex++,
          'allowEmpty' => false,
          'class' => 'span5',
          'validators' => array(
            array('NotEmpty', true),
            array('EmailAddress', true),
            //array('Db_NoRecordExists', true, array($tableName, 'email'))
          ),
        ));
        $this->email->removeDecorator('Errors');        
        $this->email->getValidator('NotEmpty')->setMessage('Please enter a valid email address.', 'isEmpty');
        //$this->email->getValidator('Db_NoRecordExists')->setMessage('Someone has already registered company with this email address!', 'recordFound');
        
        // Contact Name
        $this->addElement('Text', 'contact_name', array(
          'label' => 'Contact Name',
          'placeholder' => 'Contact Name',    
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'class' => 'span5',
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->contact_name->removeDecorator('Errors');
        
        // Telephone Number
        $this->addElement('Text', 'phone_no', array(
          'label' => 'Phone Number',
          'placeholder' => 'Phone Number',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'class' => 'span5',
          'validators' => array(
            array('NotEmpty', true),
            //array('Regex', true, array('/^((\+44|0)2[0456789]\d{2}\s?\d{6})$/i')),
            array('Regex', true, array('/^((\+44)?[ ]?(\([0-9 ]{0,5}\))?[ ]?[0-9 ]{6,20})$/i')),
            array('StringLength', false, array(1, 50)),
          ),
        ));
        $this->phone_no->removeDecorator('Errors');        
        $this->phone_no->getValidator('Regex')->setMessage('Invalid telephone number entered!', 'regexNotMatch');
        
        // Mobile Number
        $this->addElement('Text', 'mobile_no', array(
          'label' => 'Mobile Number',
          'placeholder' => 'Mobile Number',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'class' => 'span5',
          'validators' => array(
            array('NotEmpty', true),
            //array('Regex', true, array('/^((\+44\s?|0)7([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/i')),
            //array('Regex', true, array('/^(07([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/i')),
            array('Regex', true, array('/^((07)[ ]?(\([0-9 ]{0,5}\))?[ ]?[0-9 ]{6,20})$/i')),
            array('StringLength', false, array(1, 50)),
          ),
        ));
        $this->mobile_no->removeDecorator('Errors');
        $this->mobile_no->getValidator('Regex')->setMessage('Invalid mobile number entered!', 'regexNotMatch');
                        
        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'tabindex' => $tabindex++,
          'ignore' => true,
        ));                
    }
    
    public function checkValidPostcode($value, $postcodeElement){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('PdnValidators');
        if(!empty($value) AND $helper->isValidPostCode($value)){
            return true;
        }
        
        return false;
    }  
}