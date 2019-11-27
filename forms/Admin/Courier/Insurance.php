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

class Application_Form_Admin_Courier_Insurance extends Zend_Form
{
    public function init()
    {
        $tabindex = 1;
        $this->setAttrib('id', 'insurance_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

        // to show the errors above the form
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend'))
        ));        
        
        // add dummy element
        $this->addElement(
            'hidden',
            'dummy1',
            array(
                'required' => false,
                'ignore' => true,
                'autoInsertNotEmptyValidator' => false,
                'decorators' => array(
                    array(
                        'HtmlTag', array(
                            'tag'  => 'p',
                            'id' => 'dummy1',
                            'style' => ''
                        )
                    )
                )
            )
        );
        $this->dummy1->clearValidators();          
        
        // insurance company
        $this->addElement('Text', 'insurance_company1', array(
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
        $this->insurance_company1->removeDecorator('Errors');

        // expiry date
        $this->addElement('Text', 'expiry_date1', array(
          'label' => 'Expiry Date',
          'placeholder' => 'Expiry Date',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->expiry_date1->removeDecorator('Errors');
        $this->expiry_date1->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'span', 'class' => 'add-on', 'id' => 'datepicker1', 'placement' => 'append')),
            array('HtmlTag', array('tag' => 'dd', 'id' => 'expirydate1', 'class' => 'input-append')),
            array('Label', array('tag' => 'dt')),
        ));
        
        // custom validation
        $specialValidator1 = new Aninda_Validate_Callback(array($this, 'isValidExpiryDate'), $this->expiry_date1);
        $specialValidator1->setMessage('The date entered is not valid as it has expired!', 'invalid');
        $this->expiry_date1->addValidator($specialValidator1);
        
        // add dummy element
        $this->addElement(
            'hidden',
            'dummy2',
            array(
                'required' => false,
                'ignore' => true,
                'autoInsertNotEmptyValidator' => false,
                'decorators' => array(
                    array(
                        'HtmlTag', array(
                            'tag'  => 'p',
                            'id' => 'dummy2',
                            'style' => ''
                        )
                    )
                )
            )
        );
        $this->dummy2->clearValidators();          

        // insurance company
        $this->addElement('Text', 'insurance_company2', array(
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
        $this->insurance_company2->removeDecorator('Errors');

        // amount covered
        $this->addElement('Text', 'amount_covered1', array(
          'label' => 'Amount Covered',
          'placeholder' => 'Amount Covered',
          'allowEmpty' => false,
          'required' => true,
          //'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->amount_covered1->removeDecorator('Errors');
        $this->amount_covered1->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'span', 'class' => 'add-on', 'id' => 'amountpan1', 'placement' => 'prepend')),
            array('HtmlTag', array('tag' => 'dd', 'id' => 'amountwrap1', 'class' => 'input-prepend', 'style' => 'display: block;')),
            array('Label', array('tag' => 'dt')),
        ));
        
        // expiry date
        $this->addElement('Text', 'expiry_date2', array(
          'label' => 'Expiry Date',
          'placeholder' => 'Expiry Date',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->expiry_date2->removeDecorator('Errors');
        $this->expiry_date2->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'span', 'class' => 'add-on', 'id' => 'datepicker2', 'placement' => 'append')),
            array('HtmlTag', array('tag' => 'dd', 'id' => 'expirydate2', 'class' => 'input-append')),
            array('Label', array('tag' => 'dt')),
        ));
        
        // custom validation
        $specialValidator2 = new Aninda_Validate_Callback(array($this, 'isValidExpiryDate'), $this->expiry_date2);
        $specialValidator2->setMessage('The date entered is not valid as it has expired!', 'invalid');
        $this->expiry_date2->addValidator($specialValidator2);
        
        // add dummy element
        $this->addElement(
            'hidden',
            'dummy3',
            array(
                'required' => false,
                'ignore' => true,
                'autoInsertNotEmptyValidator' => false,
                'decorators' => array(
                    array(
                        'HtmlTag', array(
                            'tag'  => 'p',
                            'id' => 'dummy3',
                            'style' => ''
                        )
                    )
                )
            )
        );
        $this->dummy3->clearValidators();          
        
        // insurance company
        $this->addElement('Text', 'insurance_company3', array(
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
        $this->insurance_company3->removeDecorator('Errors');

        // amount covered
        $this->addElement('Text', 'amount_covered2', array(
          'label' => 'Amount Covered',
          'placeholder' => 'Amount Covered',
          'allowEmpty' => false,
          'required' => true,
          //'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->amount_covered2->removeDecorator('Errors');
        $this->amount_covered2->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'span', 'class' => 'add-on', 'id' => 'amountpan2', 'placement' => 'prepend')),
            array('HtmlTag', array('tag' => 'dd', 'id' => 'amountwrap2', 'class' => 'input-prepend', 'style' => 'display: block;')),
            array('Label', array('tag' => 'dt')),
        ));
        
        // expiry date
        $this->addElement('Text', 'expiry_date3', array(
          'label' => 'Expiry Date',
          'placeholder' => 'Expiry Date',
          'allowEmpty' => false,
          'required' => true,
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->expiry_date3->removeDecorator('Errors');
        $this->expiry_date3->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'span', 'class' => 'add-on', 'id' => 'datepicker3', 'placement' => 'append')),
            array('HtmlTag', array('tag' => 'dd', 'id' => 'expirydate3', 'class' => 'input-append')),
            array('Label', array('tag' => 'dt')),
        ));

        // custom validation
        $specialValidator3 = new Aninda_Validate_Callback(array($this, 'isValidExpiryDate'), $this->expiry_date3);
        $specialValidator3->setMessage('The date entered is not valid as it has expired!', 'invalid');
        $this->expiry_date3->addValidator($specialValidator3);
        
        // add dummy element
        $this->addElement(
            'hidden',
            'dummy4',
            array(
                'required' => false,
                'ignore' => true,
                'autoInsertNotEmptyValidator' => false,
                'decorators' => array(
                    array(
                        'HtmlTag', array(
                            'tag'  => 'p',
                            'id' => 'dummy4',
                            'style' => ''
                        )
                    )
                )
            )
        );
        $this->dummy4->clearValidators();          
        
        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'tabindex' => $tabindex++,
          'ignore' => true,
        ));                
    }
    
    public function isValidExpiryDate($expiryDate, $dateElement){
        $today = @date('Y-m-d', time());
        return ($expiryDate>$today) ? true : false;
    }  
}