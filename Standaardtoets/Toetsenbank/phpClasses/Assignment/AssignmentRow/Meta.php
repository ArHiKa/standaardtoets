<?php

declare (strict_types = 1);

include 'Meta/Domein.php';
include 'Meta/Taxonomie.php';

/**
 * Description of Domain
 *
 * @author AKS01
 */
class Meta {
    //put your code here
    public  $domeinen = [],
            $taxonomie = [],
            $pValue;
    
    function __construct() {
        
    }
    
    function addDomein($domein, $taxonomie){
        try {
            $this->tryAddDomein($domein, $taxonomie);
        } catch (TyeError $ex) {
            throw new Exception($ex->getMessage());
        } 
    }
    
    function tryAddDomein(Domein $domein, Taxonomie $taxonomie){
        array_push($this->domeinen, $domein);
        array_push($this->taxonomie, $taxonomie);
    }
}
