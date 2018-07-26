<?php

include 'Taxonomie/Info.php';

/**
 * Element with array of possible taxonomy's
 *
 * @author AKS01
 * 
 */
class Taxonomie {
    //SCALES
    static  $RTTI = 'RTTI';
    
    public  $scales = [];
    
    /**
     * 
     * @param String $scale
     * @param Int $value
     */
    function __construct($scale, $value) {
        $this->addTaxonomy($scale, $value);
    }// end function __construct($scale, $value)
    
    function addTaxonomy($scale, $value) {
        if(is_string($scale) === false){
            throw new Exception('param1 should be a string');
        }// end if
        
        if(is_int($value) === false) {
            throw new Exception('param2 should be a int');
        }// end if
        
        $info = new Info($scale, $value);
        // push new value
        array_push($this->scales, $info);
    }// end function addTaxonomy($scale, $value) 
    
}
