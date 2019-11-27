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

class Helper_PdnValidators extends Zend_Controller_Action_Helper_Abstract 
{
    public function isValidPostCode($postCode = false) 
    {
        if (!$postCode) {
            return false;
        }

        // get valid format
        $postCode = $this->postCodeFormat($postCode);
        
        // validate postcode
        $postCode = strtoupper(str_replace(' ', '', $postCode));
        if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/", $postCode) 
                || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/", $postCode) 
                || preg_match("/^GIR0[A-Z]{2}$/", $postCode)) {
            return true;
        }
        
        return false;
    }

    //format postcode
    public function postCodeFormat($postCode = false)
    {
        // check
        if(!$postCode){
            return false;
        }
        
        //trim and remove spaces
        $cleanPostcode = str_replace(" ", "", trim($postCode));

        //make uppercase
        $cleanPostcode = strtoupper($cleanPostcode);

        //if 5 charcters, insert space after the 2nd character
        if (strlen($cleanPostcode) == 5) {
            $postCode = substr($cleanPostcode, 0, 2) . " " . substr($cleanPostcode, 2, 3);
        }

        //if 6 charcters, insert space after the 3rd character
        elseif (strlen($cleanPostcode) == 6) {
            $postCode = substr($cleanPostcode, 0, 3) . " " . substr($cleanPostcode, 3, 3);
        }

        //if 7 charcters, insert space after the 4th character
        elseif (strlen($cleanPostcode) == 7) {
            $postCode = substr($cleanPostcode, 0, 4) . " " . substr($cleanPostcode, 4, 3);
        }

        return $postCode;
    }

}