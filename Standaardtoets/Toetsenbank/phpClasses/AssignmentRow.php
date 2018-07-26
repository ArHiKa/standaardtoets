<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include './AssignmentRow/PointCondition.php';
include './AssignmentRow/Taxonomy.php';

    
/**
 * Description of question
 *
 * @author AKS01
 */
class AssignmentRow {
    //put your code here
    static  $TITLE = 'TITLE',
            $INFO = 'INFO',
            $QUESTION = 'QUESTION',
            $FIGURE = 'FIGURE';

    
    public 
            /**
            * @var Number Number Unique id for row
            */
            $id = -1,
            /**
             * @var String Type of row
             * @uses TITLE, INFO, QUESTION or FIGURE
             */
            $type = '',
            /**
             * @var String Display of: TITLE, INFO or FIGURE
             */
            $body = '',
            /**
             * @var String Display of ATTACHMENT
             */
            $attachmentBody = '',
            /**
             * @var String Displays short answer of question
             */
            $answer = '',
            /**
             * @var String Displays calculation or long answer
             */
            $calculation = '',
            /**
             * @var String Displays possible remarks
             */
            $remarks = '',
            /**
             * @var Number Number of points for this question
             */
            $points = -1,
            /**
             * @var PointCondition Array Description
             */
            $pointConditions = [],
            
            $taxonomy;
    
    
    
}

$p = new PointCoindition();
$p->body = 'test';
$p->value = 1;

$a = new AssignmentRow();
$a->pointConditions = [$p, $p];
//$a->taxonomy = new Taxonomy(Taxonomy::$RTTI, 4);
echo json_encode($a);