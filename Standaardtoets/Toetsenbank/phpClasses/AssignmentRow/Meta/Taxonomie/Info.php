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
        if(is_string($scale)){
            $this->scale = $scale;
        } else {
            throw new Exception('param1 is not string');
        }
        
        if(is_int($value) && $value > 0){
            $this->value = $value;
        } else {
            throw new Exception('param2 is not int bigger than 0');
        }

        
    }// end function __construct($scale, $value) 
}// end class Info
