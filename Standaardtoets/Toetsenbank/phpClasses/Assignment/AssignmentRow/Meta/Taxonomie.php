<?php

declare (strict_types = 1);

include 'Taxonomie/Info.php';

/**
 * Element with array of possible taxonomy's
 *
 * @author AKS01
 * 
 */
class Taxonomie {
    //SCALES
    static  $NO_SCALE = 'NOSCALE',
            $RTTI = 'RTTI';
    
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
        
        try {
            $this->init($scale, $value);
        } catch (TypeError $ex) {
            throw new Exception($ex->getMessage());
        }
        
        
    }// end function addTaxonomy($scale, $value) 
    
    function init(string $scale, int $value){
        array_push($this->scales, new Info($scale, $value));
    }
}// end class Taxonomie
