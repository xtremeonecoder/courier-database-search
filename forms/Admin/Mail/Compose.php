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

class Application_Form_Admin_Mail_Compose extends Zend_Form
{
  public function init()
  {
    // Init form
    $tabindex = 1;
    $this->setAttrib('id', 'compose_mail')
      ->setAttrib('class', 'global_form')      
      ->setMethod("POST")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    // to show the errors above the form
    $this->setDecorators(array(
        'FormElements',
        'Form',
        array('FormErrors', array('placement' => 'prepend'))
    ));        

    // mail subject
    $this->addElement('Text', 'subject', array(
      'label' => 'Mail Subject',
      'placeholder' => 'Mail Subject',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('NotEmpty', true)
      ),
      'tabindex' => $tabindex++,
      'autofocus' => 'autofocus',
      'class' => 'span5',
      'style' => 'margin-bottom: 25px;'
    ));
    $this->subject->removeDecorator('Errors');
    $this->subject->getValidator('NotEmpty')->setMessage('Please enter a subject of the mail.', 'isEmpty');
        
    // Init body
    $this->addElement('Textarea', 'body', array(
      'label' => 'Mail Body',
      'placeholder' => 'Mail Body (mail body can be both text / html)',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'span5',
      //'style' => 'height: 150px;',
      'tabindex' => $tabindex++,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('NotEmpty', true),
        //array('StringLength', false, array(6, 32))
      )
    ));
    $this->body->removeDecorator('Errors');
    $this->body->getValidator('NotEmpty')->setMessage('Please enter mail body.', 'isEmpty');
    //$this->body->getValidator('StringLength')->setMessage('Password must be more than 5 characters!', null);
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Compose Mail',
      'type' => 'submit',
      'style' => 'margin-top: 15px;',
      'ignore' => true,
      'tabindex' => $tabindex++,
    ));
  }  
}