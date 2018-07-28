<?php

declare (strict_types = 1);


/**
 * Description of PointCoindition
 *
 * @author AKS01
 * @param String $body 
 * @param Int $value
 */
class PointCondition {
    //put your code here
    public  $body = '',
            $value = -1;
    
    /**
     * 
     * @param String $body
     * @param Int $value
     */
    function __construct($body, $value) {
        /*
        if(is_string($body) === false){
            throw new Exception('param1 should be a string');
        }// end if
        
        if(is_int($value) === false) {
            throw new Exception('param2 should be a int');
        }// end if
         * 
         */
        
        try {
            $this->init($body, $value);
        } catch (TypeError $ex) {
            throw new Exception($ex->getMessage());
        }
        
    }
    
    private function init(string $body, int $value){
        $this->body = $body;
        $this->value = $value;
    }
}

