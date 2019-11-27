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

class Application_Form_Register_Email extends Zend_Form
{
  public function init()
  {
    // Init form
    $tabindex = 1;
    $this->setAttrib('id', 'email_form')
      ->setAttrib('class', 'global_form')      
      ->setMethod("POST")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'member_signup', true));

    // to show the errors above the form
    $this->setDecorators(array(
        'FormElements',
        'Form',
        array('FormErrors', array('placement' => 'prepend'))
    ));        
        
    // Init email
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
    $tableName = $helper->getTable("companies")->info('name');
    $this->addElement('Text', 'email', array(
      'label' => 'Email Address',
      'placeholder' => 'Email Address',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('NotEmpty', true),
        array('EmailAddress', true),
        //array('Db_NoRecordExists', true, array($tableName, 'email'))
      ),
      
      // Fancy stuff
      'tabindex' => $tabindex++,
      'autofocus' => 'autofocus',
      'inputType' => 'email',
      'class' => 'text span5',
    ));
    $this->email->removeDecorator('Errors');
    $this->email->getValidator('NotEmpty')->setMessage('Please enter a valid email address.', 'isEmpty');
    //$this->email->getValidator('Db_NoRecordExists')->setMessage('This email already exists!', 'recordFound');

    // Init password
    //$password = Zend_Registry::get('Zend_Translate')->_('Password');
    $this->addElement('Password', 'password', array(
      'label' => 'Password',
      'placeholder' => 'Password',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'span5',
      'tabindex' => $tabindex++,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(6, 32))
      )
    ));
    $this->password->removeDecorator('Errors');
    $this->password->getValidator('NotEmpty')->setMessage('Please enter a valid password.', 'isEmpty');
    $this->password->getValidator('StringLength')->setMessage('Password must be more than 5 characters!', null);

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
    
    // Init passcon
    $this->addElement('Password', 'passcon', array(
      'label' => 'Confirm Password',
      'placeholder' => 'Confirm Password',
      //'description' => 'Enter your password again for confirmation.',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'span5',
      'validators' => array(
        array('NotEmpty', true),
      ),
      'tabindex' => $tabindex++,
    ));
    $this->passcon->removeDecorator('Errors');
    //$this->passcon->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
    $this->passcon->getValidator('NotEmpty')->setMessage('Please make sure the "password" and "confirm password" fields match.', 'isEmpty');

    // custom validation
    $specialValidator = new Aninda_Validate_Callback(array($this, 'checkPasswordConfirm'), $this->password);
    $specialValidator->setMessage('Password did not match!', 'invalid');
    $this->passcon->addValidator($specialValidator);
   
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
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Next',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => $tabindex++,
    ));
  }
  
  public function checkPasswordConfirm($value, $passwordElement){
    return ( $value == $passwordElement->getValue() );
  }  
}
