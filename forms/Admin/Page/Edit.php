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

class Application_Form_Admin_Page_Edit extends Zend_Form
{
  public function init()
  {
    // Init form
    $tabindex = 1;
    $this->setAttrib('id', 'edit_page')
      ->setAttrib('class', 'global_form')      
      ->setMethod("POST")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    // to show the errors above the form
    $this->setDecorators(array(
        'FormElements',
        'Form',
        array('FormErrors', array('placement' => 'prepend'))
    ));        

    // page title
    $this->addElement('Text', 'title', array(
      'label' => 'Page Title',
      'placeholder' => 'Page Title',
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
    ));
    $this->title->removeDecorator('Errors');
    $this->title->getValidator('NotEmpty')->setMessage('Please enter a title of the page.', 'isEmpty');
        
    // Init keywords
    $this->addElement('Textarea', 'keywords', array(
      'label' => 'Meta Keywords',
      'placeholder' => 'Meta Keywords (keywords must related to page contents, and comma separated, like - apple, banana, mango)',
      'required' => false,
      'allowEmpty' => true,
      'class' => 'span5',
      'style' => 'height: 150px;',
      'tabindex' => $tabindex++,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        //array('NotEmpty', true),
        //array('StringLength', false, array(6, 32))
      )
    ));
    $this->keywords->removeDecorator('Errors');
    //$this->keywords->getValidator('NotEmpty')->setMessage('Please enter some page related keywords.', 'isEmpty');
    //$this->keywords->getValidator('StringLength')->setMessage('Password must be more than 5 characters!', null);
    
    // Init description
    $this->addElement('Textarea', 'description', array(
      'label' => 'Meta Description',
      'placeholder' => 'Meta Description (description must related to page contents)',
      'required' => false,
      'allowEmpty' => true,
      'class' => 'span5',
      'style' => 'height: 150px;',
      'tabindex' => $tabindex++,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        //array('NotEmpty', true),
        //array('StringLength', false, array(6, 32))
      )
    ));
    $this->description->removeDecorator('Errors');
    //$this->description->getValidator('NotEmpty')->setMessage('Please enter page related description.', 'isEmpty');
    //$this->description->getValidator('StringLength')->setMessage('Password must be more than 5 characters!', null);
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Edit Page',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => $tabindex++,
    ));
  }  
}