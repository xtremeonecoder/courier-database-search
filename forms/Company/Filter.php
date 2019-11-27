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

    $orders = array(
        '' => 'Search courier by', 
        '1' => "Company Name", 
        '2' => "Town", 
        '3' => "County", 
        '4' => "Post Code",
        '5' => "Contact Name",
        '6' => "Email"
    );
    $order = new Zend_Form_Element_Select('order');
    $order
      ->setLabel('Search courier by:')
      ->setAttribs(array(
          'class' => 'span'
      ))
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'style' => 'margin-right: 10px; float: left;'))
      ->setMultiOptions($orders);
    
    $keyword = new Zend_Form_Element_Text('keyword');
    $keyword
      ->setLabel('Keyword:')
      ->setAttribs(array(
          'class' => 'span',
          'placeholder' => 'Search by keyword'
      ))
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div', 'style' => 'margin-right: 10px; float: left;'));

    $submit = new Zend_Form_Element_Button('search', array('type' => 'submit'));
    $submit
      ->setLabel('Search')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));

    $this->addElements(array(
      $order,
      $keyword,
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