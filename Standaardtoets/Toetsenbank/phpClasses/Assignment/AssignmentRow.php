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
            $questionrelevance = [],
            
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
    
    function __construct($htmlTableRows) {
        try {
            $this->htmlRowParser($htmlTableRows);
        } catch (TypeError $ex) {
            throw new Exception($ex->getMessage());
        }
        
        
    }

    function htmlRowParser(array $htmlTableRows){
        if(count($htmlTableRows) === 1){
            $cells = $htmlTableRows[0]->getElementsByTagName(TABLE_CELL);// get cells from single row
            $typeText = $cells[0]->nodeValue;//get typetext from cell
            
            $match = [];//init for regex match
            preg_match('/[FI]/', $typeText, $match);//check if cell contains type for INFO or FIGURE
            if($match[0] === 'F'){
                $this->type = self::$FIGURE;
            } else if ($match[0] === 'I'){
                $this->type = self::$INFO;
            } else {
                throw new Exception('Wrong input type in type.  Input is:'. $typeText.'. Format should be: "F#[#(,#,#,...)]" or "I[#(#,#,...)]"');
            }
            
            if(preg_match('/\[(\d|,\d){1,}]/', $typeText, $match) === 1){
                $relevanceArray = [];
                preg_match_all('/\d{1,}/', $match[0], $relevanceArray);
                $intarray = [];
                foreach ($relevanceArray[0] as $number) {
                    array_push($intarray, (int) $number);
                }
                
                $this->questionrelevance = $intarray;
            } else {
                throw new Exception('Wrong input type. Input is:'. $typeText.'. Format should be: "F#[#(,#,#,...)]" or "I[#(#,#,...)]"');
            }
            
            //unset public variables not used
            unset($this->attachmentBody, $this->answer, $this->calculation, $this->remarks, $this->pointConditions, $this->points, $this->meta);
        } else if (count($htmlTableRows) > 1){
            $typeText = $htmlTableRows[0]->getElementsByTagName(TABLE_CELL)[0]->nodeValue;
            
            if(preg_match('/(Q)(\d{1,})/', $typeText, $match) === 1){
                $this->type = self::$QUESTION;
                array_push($this->questionrelevance, (int) $match[2]);
            }
        } else {
            throw new Exception('Table needed');
        }
    }
    
    
}

