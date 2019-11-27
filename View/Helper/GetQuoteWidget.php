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

class Aninda_View_Helper_GetQuoteWidget extends Zend_View_Helper_Abstract 
{
    public function getQuoteWidget($params = array()) {
        // index code
        $form = new Application_Form_Quote_Check();
        $form->setAction($this->view->url(array(), 'landing_home', true));
        
        // call partial
        return $this->view->partial(
            'helper-scripts/_getQuoteWidget.phtml',
            array('quoteForm' => $form)
        );
    }
}