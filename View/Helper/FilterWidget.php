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

class Aninda_View_Helper_FilterWidget extends Zend_View_Helper_Abstract 
{
    public function filterWidget($params = array()) {
        // index code
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $valules = $request->getParams();
        $form = new Application_Form_Company_Filter();
        //$form->setAction($this->view->url(array(), 'landing_home', true));
        $form->populate($valules);
        
        // call partial
        return $this->view->partial(
            'helper-scripts/_filterWidget.phtml',
            array('filterForm' => $form)
        );
    }
}