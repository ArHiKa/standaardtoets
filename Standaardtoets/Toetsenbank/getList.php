<?php

$dir = 'opgaven/';// map op zelfde niveau als deze php
$list = scandir($dir);// lijst met alle bestanden en mappen van $dir 
for($i = count($list); $i > 0; $i--){

    if(filetype($list[$i]) === 'dir' 
            || preg_match('/(.html)$/', $list[$i]) === 0){// of als het geen .html bestand is...
        array_splice($list, $i, 1);// verwijder uit de lijst
        continue;
    }// endif 

    $list[$i] = $dir . $list[$i];// voeg directory toe
}// end forloop

// verwijder eerste punt uit de lijst. Is een '.'
array_splice($list, 0,1);



echo json_encode($list);
?>
