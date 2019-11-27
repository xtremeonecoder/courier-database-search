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

class Application_Form_Order_Delivery extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'order_delivery_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend'))
        ));        
        
        // Firstname
        $this->addElement('Text', 'dfirstname', array(
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
        $this->dfirstname->removeDecorator('Errors');

        // Lastname
        $this->addElement('Text', 'dlastname', array(
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
        $this->dlastname->removeDecorator('Errors');
        
        // Company name
        $this->addElement('Text', 'dcompany_name', array(
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
        $this->dcompany_name->removeDecorator('Errors');

        // Phone Number
        $this->addElement('Text', 'dphone_no', array(
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
        $this->dphone_no->removeDecorator('Errors');
        
        // Mobile Number
        $this->addElement('Text', 'dmobile_no', array(
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
        $this->dmobile_no->removeDecorator('Errors');
        
        // Building no
        $this->addElement('Text', 'dbuilding_no', array(
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
        $this->dbuilding_no->removeDecorator('Errors');

        // Street name
        $this->addElement('Text', 'dstreet', array(
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
        $this->dstreet->removeDecorator('Errors');

        // Town name
        $this->addElement('Text', 'dtown', array(
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
        $this->dtown->removeDecorator('Errors');
        
        // Post Code
        $this->addElement('Text', 'dpostcode', array(
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
        $this->dpostcode->removeDecorator('Errors');

        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Proceed to Pick/Drop Times',
          'type' => 'submit',
          'tabindex' => 10,
          'ignore' => true,
        ));        
        
        // Element Group 1
        $this->addDisplayGroup(array(
            'dfirstname',
            'dlastname',
            'dcompany_name',
            'dphone_no',  
            'dmobile_no'
        ), 'group1');

        // Element Group 2
        $this->addDisplayGroup(array(
            'dbuilding_no',
            'dstreet',
            'dtown',
            'dpostcode'
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