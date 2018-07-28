<?php

declare(strict_types=1);

/**
 * Holds a taxonomy of a point. Determines the 'difficulty' of a question.
 *
 * @author AKS01
 */
class Info {
    //put your code here
    public  $scale = '',
            $value = -1;
    
    /**
     * 
     * @param String $scale
     * @param Int $value
     */
    function __construct($scale, $value) {
        try {
            $this->init($scale, $value);
        } catch (TypeError $ex) {
            throw new Exception($ex->getMessage());
        }

        
    }// end function __construct($scale, $value) 
    
    private function init(string $scale, int $value){
        $this->scale = $scale;
        $this->value = $value;
    }
}// end class Info
