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

class Application_Form_Company_Edit extends Zend_Form
{
    protected $_field;

    public function init()
    {
        $this->setAttrib('id', 'company_create_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

        // Company Email
        $this->addElement('Text', 'email', array(
          'label' => '',
          'placeholder' => 'Email Address',  
          'required' => true,
          'tabindex' => 1,
          'allowEmpty' => false,
          'validators' => array(
            array('NotEmpty', true),
            array('EmailAddress', true),
            //array('Db_NoRecordExists', true, array('companies', 'email'))
          ),
        ));
        $this->email->getValidator('NotEmpty')->setMessage('Please enter a valid email address.', 'isEmpty');
        //$this->email->getValidator('Db_NoRecordExists')->setMessage('Someone has already registered company with this email address!', 'recordFound');
        
        // Mobile Number
        $this->addElement('Text', 'mobile_no', array(
          'label' => '',
          'placeholder' => 'Mobile Number',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 3,
          'validators' => array(
            array('NotEmpty', true),
            //array('Regex', true, array('/^((\+44\s?|0)7([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/i')),
            //array('Regex', true, array('/^(07([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/i')),
            array('Regex', true, array('/^((07)[ ]?(\([0-9 ]{0,5}\))?[ ]?[0-9 ]{6,20})$/i')),
            array('StringLength', false, array(1, 50)),
          ),
        ));
        $this->mobile_no->getValidator('Regex')->setMessage('Invalid mobile number entered!', 'regexNotMatch');
        
        // Company Name
        $this->addElement('Text', 'company_name', array(
          'label' => '',
          'placeholder' => 'Company Name',    
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 5,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
                
        // Complany Address Line-1
        $this->addElement('Text', 'address1', array(
          'label' => '',
          'placeholder' => 'Address 1',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 7,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
            
        // Complany Address Line-2
        $this->addElement('Text', 'address2', array(
          'label' => '',
          'placeholder' => 'Address 2 (Optional)',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 8,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));

        // Complany Address Line-3
        $this->addElement('Text', 'address3', array(
          'label' => '',
          'placeholder' => 'Address 3 (Optional)',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 9,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));

        // Complany Address Line-4
        $this->addElement('Text', 'address4', array(
          'label' => '',
          'placeholder' => 'Address 4 (Optional)',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 10,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));
        
        // Element Group 1
        $this->addDisplayGroup(array(
            'email',
            'mobile_no',  
            'company_name',  
            'address1',  
            'address2',  
            'address3',  
            'address4'
        ), 'group1');                    

        // Website Number
        $this->addElement('Text', 'website', array(
          'label' => '',
          'placeholder' => 'Company Website',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 2,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 128)),
            //array('Regex', true, array('/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/i')),
            array('Regex', true, array('/(http|https):\/\/([a-z]([a-z0-9\-]*\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel|tel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}[0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(:[0-9]{1,5})?(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&amp;]*)?)?(#[a-z][a-z0-9_]*)?$/i')),
          ),
        ));
        $this->website->getValidator('Regex')->setMessage('Invalid website address entered!', 'regexNotMatch');
        
        // Telephone Number
        $this->addElement('Text', 'phone_no', array(
          'label' => '',
          'placeholder' => 'Phone Number',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 4,
          'validators' => array(
            array('NotEmpty', true),
            //array('Regex', true, array('/^((\+44|0)2[0456789]\d{2}\s?\d{6})$/i')),
            array('Regex', true, array('/^((\+44)?[ ]?(\([0-9 ]{0,5}\))?[ ]?[0-9 ]{6,20})$/i')),
            array('StringLength', false, array(1, 50)),
          ),
        ));
        $this->phone_no->getValidator('Regex')->setMessage('Invalid telephone number entered!', 'regexNotMatch');
        
        // Contact Name
        $this->addElement('Text', 'contact_name', array(
          'label' => '',
          'placeholder' => 'Contact Name',    
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 6,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));

        // Town / City Name
        $this->addElement('Text', 'city_name', array(
          'label' => '',
          'placeholder' => 'Town / City',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 11,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));

        // City ID Hiddne
        $this->addElement('Hidden', 'city', array(
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));

        // County Name
        $this->addElement('Text', 'county_name', array(
          'label' => '',
          'placeholder' => 'County',
          'readonly' => 'readonly',
          'allowEmpty' => true,
          'required' => false,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));

        // County ID Hiddne
        $this->addElement('Hidden', 'county', array(
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));

        // Country Name
        $this->addElement('Text', 'country_name', array(
          'label' => '',
          'placeholder' => 'Country',
          'readonly' => 'readonly',
          'allowEmpty' => true,
          'required' => false,
          'validators' => array(
            //array('NotEmpty', true),
            //array('StringLength', false, array(1, 512)),
          ),
        ));

        // Country ID Hiddne
        $this->addElement('Hidden', 'country', array(
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));

        // Post Code
        $this->addElement('Text', 'postcode', array(
          'label' => '',
          'placeholder' => 'Post Code',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => 12,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512))
          ),
        ));
        
        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Edit Company',
          'type' => 'submit',
          'tabindex' => 12,
          'ignore' => true,
        ));        
        
        // Element Group 2
        $this->addDisplayGroup(array(
            'website',
            'phone_no',
            'contact_name',  
            'city_name',  
            'city',  
            'county_name',  
            'county',  
            'country_name',  
            'country',
            'postcode',
            'submit',
        ), 'group2');                    
        
        $this->addElement(
            'hidden',
            'dummy_content',    
            array(
                'required' => false,
                'ignore' => true,
                'autoInsertNotEmptyValidator' => false,
                'decorators' => array(
                    array(
                        'HtmlTag', array(
                            'tag'  => 'div',
                            'style' => 'clear: both'
                        )
                    )
                )
            )
        );
        $this->dummy_content->clearValidators();          
    }
}

