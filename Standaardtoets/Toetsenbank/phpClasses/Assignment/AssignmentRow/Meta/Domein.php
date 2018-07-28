<?php

declare (strict_types = 1);


/**
 * Description of Domein
 *
 * @author AKS01
 */
class Domein {
    static  $A = 0,
            $B = 1,
            $C = 2,
            $D = 3,
            $E = 4,
            $F = 5,
            $G = 6,
            $H = 7,
            $I = 8,
            $J = 9;


    //put your code here
    public  $domein,
            $subdomein,
            $specificatie,
            $formules = [];
    
    function __construct($domein, $subdomein, $specificatie, $formules = []) {
        try {
            $this->init($domein, $subdomein, $specificatie, $formules);
        } catch (TypeError $ex) {
            throw new Exception($ex->getMessage());
        }
        
        
        
    }
    
    function init(int $domein, int $subdomein, int $specificatie, array $formules) {
            $this->domein = $domein;
            $this->subdomein = $subdomein;
            $this->specificatie = $specificatie;
            $this->formules = $formules;
        }
}
