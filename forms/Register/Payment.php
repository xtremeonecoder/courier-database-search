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

class Application_Form_Register_Payment extends Zend_Form
{
  public function init()
  {
    // Init form
    $tabindex = 1;
    $this->setAttrib('id', 'payment_form')
      ->setAttrib('class', 'global_form')     
      ->setMethod("POST")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'member_signup', true));

    // to show the errors above the form
    $this->setDecorators(array(
        'FormElements',
        'Form',
        array('FormErrors', array('placement' => 'prepend'))
    ));        
        
    // Init duration
    $this->addElement('Select', 'duration', array(
      'label' => 'Select Duration',
      'placeholder' => 'Select Duration',
      'required' => false,
      'allowEmpty' => true,
      'tabindex' => $tabindex++,
      'class' => 'span5',        
      'multiOptions' => array(
        '' => 'Select Duration',
        '7' => '7 days',
        '14' => '14 days',
        '30' => '30 days',
        '60' => '60 days',
        '90' => '90 days'
      ),
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        //array('NotEmpty', true)
      )
    ));
    $this->duration->removeDecorator('Errors');

    // Init duration start
    $this->addElement('Select', 'duration_start', array(
      'label' => 'Select Start',
      'placeholder' => 'Select Start',
      'required' => false,
      'allowEmpty' => true,
      'tabindex' => $tabindex++,
      'class' => 'span5',        
      'multiOptions' => array(
        '' => 'Select Duration Starts',
        'invoice_date' => 'From invoice date',
        'end_of_month' => 'From end of month'
      ),
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        //array('NotEmpty', true)
      )
    ));
    $this->duration_start->removeDecorator('Errors');

    // Init comments
    $this->addElement('Textarea', 'comment', array(
      'label' => 'Additional Comments',
      'placeholder' => 'Additional Comments',
      'required' => false,
      'allowEmpty' => true,
      'tabindex' => $tabindex++,
      'class' => 'span8',        
      'style' => 'height: 150px;',
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        //array('NotEmpty', true)
      )
    ));
    $this->comment->removeDecorator('Errors');
    
    // add dummy element
    $this->addElement(
        'hidden',
        'dummy',
        array(
            'required' => false,
            'ignore' => true,
            'autoInsertNotEmptyValidator' => false,
            'decorators' => array(
                array(
                    'HtmlTag', array(
                        'tag'  => 'p',
                        'id' => 'dummy',
                        'style' => ''
                    )
                )
            )
        )
    );
    $this->dummy->clearValidators();          
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Next',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => $tabindex++,
    ));
  }
}