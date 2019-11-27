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

class Application_Form_Company_Availability_Add extends Zend_Form
{
  public function init()
  {
    // Init form
    $tabindex = 1;
    $this->setAttrib('id', 'add_schedule')
      ->setAttrib('class', 'global_form')      
      ->setMethod("POST")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    // to show the errors above the form
    $this->setDecorators(array(
        'FormElements',
        'Form',
        array('FormErrors', array('placement' => 'prepend'))
    ));        

    // availability_date
    $this->addElement('Text', 'availability_date', array(
      'label' => 'Availability Date',
      'placeholder' => 'Availability Date',
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
      'class' => 'span4',
    ));
    $this->availability_date->removeDecorator('Errors');
    $this->availability_date->getValidator('NotEmpty')->setMessage('Please enter an availability date.', 'isEmpty');
        
    // from_time
    $this->addElement('Text', 'from_time', array(
      'label' => 'From',
      'placeholder' => 'From',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('NotEmpty', true)
      ),    
      'tabindex' => $tabindex++,
      'class' => 'span9',
    ));
    $this->from_time->removeDecorator('Errors');
    $this->from_time->getValidator('NotEmpty')->setMessage('Please enter a from time.', 'isEmpty');

    // to_time
    $this->addElement('Text', 'to_time', array(
      'label' => 'To',
      'placeholder' => 'To',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('NotEmpty', true)
      ),    
      'tabindex' => $tabindex++,
      'class' => 'span8',
    ));
    $this->to_time->removeDecorator('Errors');
    $this->to_time->getValidator('NotEmpty')->setMessage('Please enter a to time.', 'isEmpty');

    // From Town / City Name
    $this->addElement('Text', 'from_town_name', array(
      'label' => 'From Town / City',
      'placeholder' => 'From Town / City',
      'allowEmpty' => true,
      'required' => false,
      'class' => 'span5',
      'tabindex' => $tabindex++,
      'validators' => array(
        //array('NotEmpty', true),
        //array('StringLength', false, array(1, 512)),
      ),
    ));
    $this->from_town_name->removeDecorator('Errors');

    // From Town / City ID Hidden
    $this->addElement('Hidden', 'from_town_id', array(
      'allowEmpty' => false,
      'required' => true,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 512)),
      ),
    ));
    $this->from_town_id->removeDecorator('Errors');
    
    // From PostCode
    $this->addElement('Text', 'from_postcode', array(
      'label' => 'From Post Code',
      'placeholder' => 'From Post Code',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'span5',
      'tabindex' => $tabindex++,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 512))
      ),
    ));
    $this->from_postcode->removeDecorator('Errors');
    $specialValidator = new Aninda_Validate_Callback(array($this, 'checkValidPostcode'), $this->from_postcode);
    $specialValidator->setMessage('Invalid from postcode entered!', 'invalid');
    $this->from_postcode->addValidator($specialValidator);
        
    // To Town / City Name
    $this->addElement('Text', 'to_town_name', array(
      'label' => 'To Town / City',
      'placeholder' => 'To Town / City',
      'allowEmpty' => true,
      'required' => false,
      'class' => 'span5',
      'tabindex' => $tabindex++,
      'validators' => array(
        //array('NotEmpty', true),
        //array('StringLength', false, array(1, 512)),
      ),
    ));
    $this->to_town_name->removeDecorator('Errors');

    // To Town / City ID Hidden
    $this->addElement('Hidden', 'to_town_id', array(
      'allowEmpty' => false,
      'required' => true,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 512)),
      ),
    ));
    $this->to_town_id->removeDecorator('Errors');
    
    // To PostCode
    $this->addElement('Text', 'to_postcode', array(
      'label' => 'To Post Code',
      'placeholder' => 'To Post Code',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'span5',
      'tabindex' => $tabindex++,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 512))
      ),
    ));
    $this->to_postcode->removeDecorator('Errors');
    $specialValidator = new Aninda_Validate_Callback(array($this, 'checkValidPostcode'), $this->to_postcode);
    $specialValidator->setMessage('Invalid to postcode entered!', 'invalid');
    $this->to_postcode->addValidator($specialValidator);
       
    // vehicle_type
    $vehicleArr = array();
    $viewer = Zend_Controller_Action_HelperBroker::getStaticHelper('User')->getViewer();
    $vehicles = $viewer->getCompany()->getVehicles();
    $vehicleTypes = array('' => 'Select Vehicle Type');
    if(count($vehicles)>0){
        foreach($vehicles as $vehicle){
            $vehicleArr["{$vehicle->getIdentity()}"] = "{$vehicle->getMake()} {$vehicle->getModel()}";
        }
        asort($vehicleArr);
    }
    $vehicleTypes = $vehicleTypes+$vehicleArr;
    $this->addElement('Select', 'vehicle_type', array(
      'label' => 'Vehicle Type',
      'placeholder' => 'Vehicle Type',
      'required' => true,
      'allowEmpty' => false,
      'multiOptions' => $vehicleTypes,
      'validators' => array(
        array('NotEmpty', true)
      ),    
      'tabindex' => $tabindex++,
      'class' => 'span5',
    ));
    $this->vehicle_type->removeDecorator('Errors');
    $this->vehicle_type->getValidator('NotEmpty')->setMessage('Please select vehicle type.', 'isEmpty');
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Availability',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => $tabindex++,
    ));
  }
  
  public function checkValidPostcode($value, $postcodeElement){
     $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('PdnValidators');
     if(!empty($value) AND $helper->isValidPostCode($value)){
         return true;
     }

     return false;
  }  
}