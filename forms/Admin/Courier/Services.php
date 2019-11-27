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

class Application_Form_Admin_Courier_Services extends Zend_Form
{
    public function init()
    {
        $tabindex = 1;
        $this->setAttrib('id', 'services_form')
          ->setAttrib('class', 'global_form')      
          ->setMethod("POST")
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

        // to show the errors above the form
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend'))
        ));        
//        $this->expiry_date1->setDecorators(array(
//            'ViewHelper',
//            'Description',
//            'Errors',
//            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'span', 'class' => 'add-on', 'id' => 'datepicker1', 'placement' => 'append')),
//            array('HtmlTag', array('tag' => 'dd', 'id' => 'expirydate1', 'class' => 'input-append')),
//            array('Label', array('tag' => 'dt')),
//        ));
        
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
        
        // same_day
        $this->addElement('Checkbox', 'same_day', array(
          'label' => 'Same Day',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->same_day->removeDecorator('Errors');
        $this->getElement('same_day')->addDecorator('Label', array('placement' => 'APPEND'));
                
        // next_day
        $this->addElement('Checkbox', 'next_day', array(
          'label' => 'Next Day',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->next_day->removeDecorator('Errors');
        $this->getElement('next_day')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // overnight
        $this->addElement('Checkbox', 'overnight', array(
          'label' => 'Overnight',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->overnight->removeDecorator('Errors');
        $this->getElement('overnight')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // international
        $this->addElement('Checkbox', 'international', array(
          'label' => 'International',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->international->removeDecorator('Errors');
        $this->getElement('international')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // temperature controlled
        $this->addElement('Checkbox', 'temperature_controlled', array(
          'label' => 'Temperature Controlled',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->temperature_controlled->removeDecorator('Errors');
        $this->getElement('temperature_controlled')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // european deliveries
        $this->addElement('Checkbox', 'european_deliveries', array(
          'label' => 'European Deliveries',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->european_deliveries->removeDecorator('Errors');
        $this->getElement('european_deliveries')->addDecorator('Label', array('placement' => 'APPEND'));
                
        // ireland deliveries
        $this->addElement('Checkbox', 'ireland_deliveries', array(
          'label' => 'Ireland Deliveries',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->ireland_deliveries->removeDecorator('Errors');
        $this->getElement('ireland_deliveries')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // adr
        $this->addElement('Checkbox', 'adr', array(
          'label' => 'ADR',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->adr->removeDecorator('Errors');
        $this->getElement('adr')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // 24 hours a day
        $this->addElement('Checkbox', 'day_24hours', array(
          'label' => '24 hours a day',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->day_24hours->removeDecorator('Errors');
        $this->getElement('day_24hours')->addDecorator('Label', array('placement' => 'APPEND'));
        
        // 7 days a week
        $this->addElement('Checkbox', 'week_7days', array(
          'label' => '7 days a week',
          'allowEmpty' => true,
          'required' => false,
          'tabindex' => $tabindex++,
          'validators' => array(
            //array('NotEmpty', true),
          ),
        ));
        $this->week_7days->removeDecorator('Errors');
        $this->getElement('week_7days')->addDecorator('Label', array('placement' => 'APPEND'));
        
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
        
        // Submit Button
        $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'tabindex' => $tabindex++,
          'ignore' => true,
        ));                
    }
}