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

class Application_Form_Company_Filter extends Zend_Form
{
  public function init()
  {
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('DbTable');
    $this
      ->clearDecorators()
      ->addDecorator('FormElements')
      ->addDecorator('Form')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'clear'))
      ;

    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setMethod('GET');

    $keyword = new Zend_Form_Element_Text('keyword');
    $keyword
      ->setLabel('Keyword:')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));

//    $ipaddresses = $helper->getTable("companies")
//            ->getIPAddressAssoc(array('group' => 'ipaddress'));
//    $ipaddresses[''] = '';
//    asort($ipaddresses);
//    $ipaddress = new Zend_Form_Element_Select('ipaddress');
//    $ipaddress
//      ->setLabel('IP Address:')
//      ->clearDecorators()
//      ->addDecorator('ViewHelper')
//      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
//      ->addDecorator('HtmlTag', array('tag' => 'div'))
//      ->setMultiOptions($ipaddresses);

    $operators = array('' => '', '2' => "Karla's Entries", '1' => "Nilesh's Entries", '3' => "Shuvo's Entries", '4' => "Jhasmine's Entries", '5' => "Clerk-1's Entries");
    $operator = new Zend_Form_Element_Select('operator');
    $operator
      ->setLabel('Entry Operator:')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'))
      ->setMultiOptions($operators);
    
    $countries = $helper->getTable("countries")->getCountryAssoc();    
    $countries[''] = '';
    asort($countries);
    $country = new Zend_Form_Element_Select('country');
    $country
      ->setLabel('Country:')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'))
      ->setMultiOptions($countries);
    
    $county = new Zend_Form_Element_Select('county');
    $county
      ->setLabel('County:')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'))
      ->setMultiOptions(array())
      ->setRegisterInArrayValidator(false);

    $city = new Zend_Form_Element_Select('city');
    $city
      ->setLabel('City / Town:')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'))
      ->setMultiOptions(array())
      ->setRegisterInArrayValidator(false);      

    $submit = new Zend_Form_Element_Button('search', array('type' => 'submit'));
    $submit
      ->setLabel('Search')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));

    $this->addElement('Hidden', 'order', array(
      'order' => 10001,
    ));

    $this->addElement('Hidden', 'direction', array(
      'order' => 10002,
    ));

    $this->addElement('Hidden', 'company_id', array(
      'order' => 10003,
    ));
    
    $this->addElements(array(
      $keyword,
      //$ipaddress,  
      $operator,
      $country,
      $county,
      $city,
      $submit
    ));

    // Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }
}