<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
        
    }
}
