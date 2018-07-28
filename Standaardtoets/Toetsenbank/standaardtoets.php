<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
                
        include 'phpClasses/Assignment.php';
        include 'phpClasses/globalConstants.php';
        
        // put your code here
        $doc = new DOMDocument();
        @$doc->loadHTMLFile('opgaven/havo_natuurkunde_2009_2_5.html');
        
        $table = $doc->getElementsByTagName('table')[0];
        $assignment = new Assignment($table);
        print_r(json_encode($assignment));
        
        ?>
    </body>
</html>
