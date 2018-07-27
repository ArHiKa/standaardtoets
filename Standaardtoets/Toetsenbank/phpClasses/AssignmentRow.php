<?php

declare (strict_types = 1);

include 'AssignmentRow/PointCondition.php';
include 'AssignmentRow/Meta.php';

    
/**
 * Een regel uit een toets. Kan verschillende types zijn.<br>
 * Titel, Info, Question, Figure
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
            $attachmentBody,
            /**
             * @var String Displays short answer of question
             */
            $answer,
            /**
             * @var String Displays calculation or long answer
             */
            $calculation,
            /**
             * @var String Displays possible remarks
             */
            $remarks,
            /**
             * @var Number Number of points for this question
             */
            $points,
            /**
             * @var PointCondition Array Description
             */
            $pointConditions,
            
            $meta;
    
    
    
}

$p = new PointCondition('test', 1);

$a = new AssignmentRow();
$a->pointConditions = [$p, $p];

$a->meta = new Meta();
echo json_encode($a, JSON_PRETTY_PRINT);