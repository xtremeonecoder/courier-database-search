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

class Application_Form_Quote_Check extends Zend_Form
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
        'id' => 'quotation_form',
        'class' => 'global_form_box',
      ));

    $cpostcode1 = new Zend_Form_Element_Text('cpostcode1');
    $cpostcode1
      ->setLabel('Collection Postcode:')
      ->setAttrib('placeholder', '1st Part')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'odddiv'));

    $cpostcode2 = new Zend_Form_Element_Text('cpostcode2');
    $cpostcode2
      ->setLabel('&nbsp;')
      ->setAttrib('placeholder', '2nd Part')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'evendiv'));

    $dpostcode1 = new Zend_Form_Element_Text('dpostcode1');
    $dpostcode1
      ->setLabel('Delivery Postcode:')
      ->setAttrib('placeholder', '1st Part')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'odddiv'));

    $dpostcode2 = new Zend_Form_Element_Text('dpostcode2');
    $dpostcode2
      ->setLabel('&nbsp;')
      ->setAttrib('placeholder', '2nd Part')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'evendiv'));
    
    $submit = new Zend_Form_Element_Button('getquote', array('type' => 'button'));
    $submit
      ->setLabel('Get My Quote')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'style' => 'padding-top: 24px;'));
    
    $this->addElements(array(
      $cpostcode1,
      $cpostcode2,
      $dpostcode1,
      $dpostcode2,
      $submit
    ));
    
//    // Element Collection Postcode
//    $this->addDisplayGroup(array(
//        'cpostcode1',
//        'cpostcode2'
//    ), 'collection_postcode');
//
//    // Element Delivery Postcode
//    $this->addDisplayGroup(array(
//        'dpostcode1',
//        'dpostcode2'
//    ), 'delivery_postcode');
    
  }
}