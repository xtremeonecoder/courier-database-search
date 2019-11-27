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

class Application_Form_Order_Collection extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'order_collection_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
        
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend'))
        ));        
        
        // Firstname
        $this->addElement('Text', 'sfirstname', array(
          'label' => 'First Name',
          'placeholder' => 'First Name',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 1,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->sfirstname->removeDecorator('Errors');
        
        // Lastname
        $this->addElement('Text', 'slastname', array(
          'label' => 'Last Name',
          'placeholder' => 'Last Name',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 2,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->slastname->removeDecorator('Errors');
        
        // Company name
        $this->addElement('Text', 'scompany_name', array(
          'label' => 'Company Name',
          'placeholder' => 'Company Name',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 3,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->scompany_name->removeDecorator('Errors');

        // Phone Number
        $this->addElement('Text', 'sphone_no', array(
          'label' => 'Landline Number',
          'placeholder' => 'Landline Number',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 4,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 50)),
          ),
        ));
        $this->sphone_no->removeDecorator('Errors');
        
        // Mobile Number
        $this->addElement('Text', 'smobile_no', array(
          'label' => 'Mobile Number',
          'placeholder' => 'Mobile Number',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 5,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 50)),
          ),
        ));
        $this->smobile_no->removeDecorator('Errors');
        
        // Building no
        $this->addElement('Text', 'sbuilding_no', array(
          'label' => 'Building Name/Number',
          'placeholder' => 'Building Name/Number',    
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 6,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->sbuilding_no->removeDecorator('Errors');

        // Street name
        $this->addElement('Text', 'sstreet', array(
          'label' => 'Street Name',
          'placeholder' => 'Street Name',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 7,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->sstreet->removeDecorator('Errors');

        // Town name
        $this->addElement('Text', 'stown', array(
          'label' => 'Town Name',
          'placeholder' => 'Town Name',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 8,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->stown->removeDecorator('Errors');
        
        // Post Code
        $this->addElement('Text', 'spostcode', array(
          'label' => 'Post Code',
          'placeholder' => 'Post Code',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => 9,
          'readonly' => 'readonly',
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512))
          ),
        ));
        $this->spostcode->removeDecorator('Errors');

        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Proceed to Delivery Details',
          'type' => 'submit',
          'tabindex' => 10,
          'ignore' => true,
        ));        
        
        // Element Group 1
        $this->addDisplayGroup(array(
            'sfirstname',
            'slastname',
            'scompany_name',
            'sphone_no',  
            'smobile_no'
        ), 'group1');

        // Element Group 2
        $this->addDisplayGroup(array(
            'sbuilding_no',
            'sstreet',
            'stown',
            'spostcode'
        ), 'group2');

        // Element Group 3
        $this->addDisplayGroup(array(
            'submit'
        ), 'group3');
        
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