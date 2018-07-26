<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="Viewer.css">
        <script src="viewer.js"></script>
    </head>
    <body>
        
        <?php
        
        //createListWithAvailableAssigns();
        
        //loadHTM(readHTMFromServerside());
        //checkForUpdates();
        writeJson();
        
        
        function console_log($data){
            
            $data = 'function: ' . debug_backtrace()[1]['function'] . '; ' . $data;
              if(is_array($data) || is_object($data)) {
                echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
              } else {
                echo("<script>console.log('PHP: $data');</script>");
              }
        }
        
        function loadHTM($list){
            $tableCleanArray = array(
                array('/(src=")/', 'src="opgaven/'),
                array('/(<!--)(.*)(-->)/sU', ''),
                array('/(<!\[if !msEquation\]>)/', '',),
                array('/(<!\[endif\]>)/', ''),
                array('/(<o:p>)(.*)(<\/o:p>)/', ''),
                //array('/(&nbsp;)/', ' '),
                array('/(<!\[if !vml\]>)/', ''),
                array('/(<!--[if !supportLists]-->)/', ''),
                array('/(<!--[if !supportMisalignedColumns]-->)/', '')
            );
            
            foreach ($list as $vraag) {
                $doc = file_get_contents($vraag);// read server MS word htm file
                $tables = array();// init array for table matches
                preg_match('/(<table)(.*)(<\/table>)/s', $doc, $tables);// get table from MS word htm file
                $table = $tables[0];// only one table available 
                //cleanup MS htm table to clean straight html table
                foreach($tableCleanArray as $cleaner) {
                    $regex = $cleaner[0];
                    $replacement = $cleaner[1];
                    $table = preg_replace($regex, $replacement, $table);
                }
                
                print_r($table);
            }
        }
        
        /**
         * Leest de .html bestanden die beschikbaar zijn om als vraag in te laden
         * @return Array directorylist for .html files
         */
        function readHTMFromServerside(){
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
           
           return $list;
        }// end loadHTMFromServerside()
        
        function createListWithAvailableAssigns(){
            $list = readHTMFromServerside();
            $myfile = fopen('assignList.txt', 'w') or die('Unable to open file!');
            $txt = '';
            
            for ($i = 0; $i < count($list); $i++) {
                $txt .= $list[$i];
                
                if($i < count($list) -1){
                    $txt .= ',';
                }
            }
            
            fwrite($myfile, $txt);
            fclose($myfile);
        }
        
        /**
         * Checks if there are new .html files are added.
         * @return boolean true if update is performed <br> false if otherwise
         */
        function checkForUpdates(){
            $dir = 'opgaven/';// map op zelfde niveau als deze php
            $list = scandir($dir);// lijst met alle bestanden en mappen van $dir 
            
            for($i = count($list); $i > 0; $i--){
                $assignmentModificationTIme = filemtime('assignList.txt');
                $fileLastModTime = filemtime($dir . $list[$i]);
                
                if($fileLastModTime > $assignmentModificationTIme){
                    createListWithAvailableAssigns();
                    console_log('Assignlist updated: true');
                    return true;
                }// end if ($fileLastModTime > $assignmentModificationTIme)

           }// end for $i
           console_log('Assignlist updated: false');
           return false;
        }// end function checkForUpdates()
        
        
        function writeJson(){
                $json;
                $json->p = 83;
                $json->title="tjsrnb0";
                
                $te = json_encode($json);
                
                $file = fopen('test.json', 'w');
                
                fwrite($file, $te);
                fclose($file);
                
        }
        ?>
        
        <script type="text/javascript">
            //loadAssignmentList();
            cleanupTables();
            assignNecessaryTags();
            createTestLayout();
        </script>
        
    </body>
</html>
