<?php

declare (strict_types = 1);

include 'Assignment/AssignmentRow.php';

/**
 * Description of Assignment
 *
 * @author AKS01
 */
class Assignment {
    //put your code here
    public  $timestamp,
            $id,
            $title,
            $niveau,
            $course,      
            $rows = [];
    
    private $table;
    
    


    function __construct($table) {
        try {
            $this->init($table);
            $this->parseRows();
        } catch (TypeError $ex) {
            throw new Exception($ex->getMessage());
        }
       
    }
    
    private function init(DOMElement $table){
        if($table->tagName !== TABLE){
            throw new Exception('Elementtag should be <table>, input is <' . $table->tagName / '>');
        }// end if
        
        $this->table = $table;
    }// end private function init(DOMElement $table)
    
    private function parseRows(){
        $rows = $this->table->getElementsByTagName(TABLE_ROW);
        
        //get specific info from first and second row
        $this->id = $rows[0]->getElementsByTagName(TABLE_CELL)[1]->getElementsByTagName(SPAN)[0]->textContent;//set id
        $this->title = $rows[1]->getElementsByTagName(TABLE_CELL)[1]->getElementsByTagName(SPAN)[0]->textContent;// set title from question
        
        //loop trough rest of tablerows from lineindex 2
        $pushRows = [];
        $rowspan = 1;
        for($i = 2; $i < count($rows); $i += $rowspan){
            $firstCell = $rows[$i]->getElementsByTagName(TABLE_CELL)[0];// get first cell only for rowspan
            if($firstCell->hasAttribute(ROWSPAN)){// if rowspan is bigger than one
                $rowspan = (int) $firstCell->getAttribute(ROWSPAN);// set rospan
            } else {
                $rowspan = 1;
            }// end if else
            
            //loop trouhg rest of rows with rowspan
            for($j = 0; $j < $rowspan; $j++){
                array_push($pushRows, $rows[$i+$j]);
            }// end for $j
            
            array_push($this->rows, new AssignmentRow($pushRows));
            $pushRows = [];
        }// end for $i
        
        
        $this->timestamp = time();
    }// end private function parseRows()
}// end class
