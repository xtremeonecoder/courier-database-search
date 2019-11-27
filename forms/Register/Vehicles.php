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

class Application_Form_Register_Vehicles extends Zend_Form
{
    public function init()
    {
        $tabindex = 1;
        $this->setAttrib('id', 'vehicles_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'member_signup', true));

        // to show the errors above the form
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend'))
        ));        
        
        // make
        $this->addElement('Text', 'make', array(
          'label' => 'Make',
          'placeholder' => 'Make',    
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->make->removeDecorator('Errors');

        // model
        $this->addElement('Text', 'model', array(
          'label' => 'Model',
          'placeholder' => 'Model',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->model->removeDecorator('Errors');

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
        
        // weight
        $this->addElement('Text', 'weight', array(
          'label' => 'Weight',
          'placeholder' => 'Weight',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->weight->removeDecorator('Errors');
        
        // width
        $this->addElement('Text', 'width', array(
          'label' => 'Width',
          'placeholder' => 'Width',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->width->removeDecorator('Errors');
        
        // height
        $this->addElement('Text', 'height', array(
          'label' => 'Height',
          'placeholder' => 'Height',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->height->removeDecorator('Errors');
        
        // length
        $this->addElement('Text', 'length', array(
          'label' => 'Length',
          'placeholder' => 'Length',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->length->removeDecorator('Errors');
        
        // vehicle number
        $this->addElement('Text', 'vehicle_number', array(
          'label' => 'Number of Vehicles',
          'placeholder' => 'Number of these types of vehicles in your fleet',
          'allowEmpty' => true,
          'required' => false,
          'class' => 'span5',
          'tabindex' => $tabindex++,
          'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 512)),
          ),
        ));
        $this->vehicle_number->removeDecorator('Errors');
                
//        // add dummy element
//        $this->addElement(
//            'hidden',
//            'dummy2',
//            array(
//                'required' => false,
//                'ignore' => true,
//                'autoInsertNotEmptyValidator' => false,
//                'decorators' => array(
//                    array(
//                        'HtmlTag', array(
//                            'tag'  => 'p',
//                            'id' => 'dummy2',
//                            'style' => ''
//                        )
//                    )
//                )
//            )
//        );
//        $this->dummy2->clearValidators();          

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
        
        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Next',
          'type' => 'submit',
          'tabindex' => $tabindex++,
          'ignore' => true,
        ));                
    }
}