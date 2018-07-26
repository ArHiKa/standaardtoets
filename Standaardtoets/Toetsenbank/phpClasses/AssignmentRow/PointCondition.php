<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
    function __construct($body = '', $value = -1) {
        if(is_string($body) === false){
            throw new Exception('param1 should be a string');
        }// end if
        
        if(is_int($value) === false) {
            throw new Exception('param2 should be a int');
        }// end if
        $this->body = $body;
        $this->value = $value;
    }
}

