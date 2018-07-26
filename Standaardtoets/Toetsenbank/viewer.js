const   //table constants from word
        TITLE = 'T',
        INFO = 'I',
        QUESTION = 'Q',
        FIGURE = 'F',
        ATTACHMENT = 'B',
        ANSWER = 'A',
        CALCULATION = 'C',
        POINTS = 'P',
        EMPTY = 'E',

        //html classes
        CLASS_TITLE = ' title',
        CLASS_INFO = ' info',
        CLASS_QUESTION = ' question',
        CLASS_FIGURE = ' figure',
        CLASS_ATTACHMENT = ' attachment',
        CLASS_ANSWER = ' answer',
        CLASS_CALCULATION = ' calculation',
        CLASS_POINTS = ' points',
        CLASS_EMPTY = ' empty',
        CLASS_NUMPOINTS = ' numpoints',
        CLASS_TYPE = ' type',
        CLASS_ASSIGNMENT = ' assignment',
        CLASS_ANSWERSHEET = ' answersheet',
        CLASS_ATTACHMENTTABLE = ' attachmenttable',
        CLASS_HIDDEN = ' hidden',
        CLASS_BULLET = ' bullet',
        
        //attributes
        SRC = 'src',
        COLSPAN = 'colspan',
        ROWSPAN = 'rowspan',

        //Elements
        FONT = 'FONT',
        TABLE = 'TABLE',
        THEAD = 'THEAD',
        TBODY = 'TBODY',
        TR = 'TR',
        TD = 'TD',
        FIGURETAG = 'FIGURE',
        FIGCAPTION = 'FIGCAPTION',
        IMG = 'IMG',
        P = 'P',
        SPAN = 'SPAn',
        
        //rest
        EMPTYSTRING = '',
        ALLELEMENTS = '*',
        
        //HTML
        BULLET = '&bull;';
        
var assignmentList = [];

function loadAssignmentList(){
    var file = new XMLHttpRequest();
    
    file.onreadystatechange = function() {
        
        if (this.readyState === 4 && this.status === 200) {
            var text = (file.responseText),
                assignments = text.split(',');
        
            //create table
            var table = document.createElement(TABLE);
            
            for(let i = 0; i < assignments.length; i++){
                let row = document.createElement(TR),
                    cell = document.createElement(TD);
            
                cell.innerHTML = assignments[i];
                
                table.appendChild(row);
                row.appendChild(cell);
            }
            
            document.body.appendChild(table);
                

        }// end if (this.readyState === 4 && this.status === 200) {
    };// end file.onreadystatechange = function()
    
    
    file.open("GET", "assignList.txt", true);
    file.send();
}

/**
 * Haalt alle tags uit het MS word html bestand behalve:
 * src, colspan, roswpan
 * 
 * Verwijderd alle 'font' tags
 * 
 * Geef een clean html table
  */
function cleanupTables(){
    var elements = document.body.querySelectorAll(ALLELEMENTS);
    
    
    for(var i = elements.length -1 ; i > -1; i--){

        for(var j = elements[i].attributes.length -1 ; j > -1 ; j--){
            var name = elements[i].attributes[j].name;

            if(name === SRC || name === COLSPAN || name === ROWSPAN){
                continue;
            } else {
                elements[i].removeAttribute(name);
            }// end ifelse

        }// end for

        //verwijder alle font tags
        if(elements[i].tagName === FONT){//vind de font tag
            var innerElement = elements[i].firstChild;//pak de child
            elements[i].parentNode.replaceChild(innerElement, elements[i]);//vervang 'font' met 'child'
        }// end if
        
        if(elements[i].tagName === TD && elements[i].innerHTML === EMPTYSTRING){
            elements[i].parentNode.removeChild(elements[i]);
        }
        
        if(elements[i].tagName === TR && elements[i].innerHTML.trim() === EMPTYSTRING){
            elements[i].parentNode.removeChild(elements[i]);
        }
        
    }// end forloop
}// end function cleanupTables()

/**
 * 
 * @returns {undefined}
 */
function assignNecessaryTags(){
    var tables = document.getElementsByTagName(TABLE);
       
    for(let i = 0; i < tables.length; i++){
        var tableClass = tables[i].rows[0].cells[1].childNodes[1].childNodes[0].innerHTML;// classnaam voor tabel. Rij0 Kolom 1.
        var elements = tables[i].querySelectorAll(ALLELEMENTS);// select all tags per table
        var table = tables[i];// elke vraag is een table
        
        
        //set all elements of table in same class
        table.className += tableClass;// table gets mainclass
        for (let j = 0; j < elements.length; j++){// every element in the table gets mainclass
            elements[j].className += tableClass;
        }// end for loop
        var questionNumber = '';// for referenc in own table only
        
        //for every row
        for(let j = 1; j < tables[i].rows.length; j++){
            var row = tables[i].rows[j];// assing row variable
            var className = '';// classname for all tags, wordt meegenomen naar de volgende tag, tenzij anders gespeficieerd in de tabel.
            
            
            //for every cell in row
            for(let k = 0; k < row.cells.length; k++){
                let cell = row.cells[k],//assing cell variable
                    inner = getInnerHTML(cell),// get text from cell
                    cellElements = cell.querySelectorAll(ALLELEMENTS);// get all elements in cell
            
            
                if(inner === ''){// check for empty cells
                    cell.className += CLASS_EMPTY;
                } else if (inner === TITLE){// check for title
                    className = CLASS_TITLE;
                }  else if (inner.match(/I\[(\d|\d,){1,}\]$/) !== null){// check for info
                    let text = inner.match(/I\[(\d|\d,){1,}\]/)[0];
                    let numbers = text.match(/(\d,){1,}\d|\d/)[0].replace(',', ' ');
                    className = CLASS_INFO + ' ' + numbers;
                }  else if (inner.match(/Q[1-9]{1,2}$/) !== null){//check for question
                    questionNumber = ' ' + inner.match(/[1-9]{1,2}/);
                    className = CLASS_QUESTION + questionNumber;
                } else if (inner.match(/F\d\[(\d|\d,){1,}\]$/) !== null){//check for figure
                    let text = inner.match(/F\d\[(\d|\d,){1,}\]$/)[0];
                    let array = text.match(/\[(\d,|\d){1,}\]/)[0];
                    let numbers = ' ' + array.match(/(\d,|\d){1,}/)[0].replace(',', ' ');
                    className = CLASS_INFO + CLASS_FIGURE + numbers;
                } else if (inner.match(/B[1-9]{1,2}$/) !== null){// check for attachment
                    className = CLASS_ATTACHMENT + questionNumber;
                } else if (inner === ANSWER){// check for answer
                    className = CLASS_ANSWER + questionNumber;
                } else if (inner === CALCULATION){
                    className = CLASS_CALCULATION + questionNumber;// check for calculation
                } else if (inner === POINTS){
                    className = CLASS_POINTS + questionNumber;// check for points
                }
                
                cell.className += className;
                for(let l = 0; l < cellElements.length; l++){
                    cellElements[l].className += className;
                }// end for l
                
            }// end for k
            

            row.className += className;
        } // end for j
        
    }// end for i
    
    //filter figures for text references
    var figures = Array.from(document.getElementsByTagName('img'));
    for(let i = figures.length -1 ; i > -1 ; i--){
        let img = figures[i],
            imgClass = img.className;
        
        if(imgClass.match(CLASS_FIGURE) === null){
            figures.splice(i,1);
        }// end if
    }// end for i
    
    //Add labels to figures and put them in figure-tag with a figcaption
    for(let i = figures.length -1 ; i > -1 ; i--){
        let figureTag = document.createElement(FIGURETAG),
            figcaptionTag = document.createElement(FIGCAPTION),
            pTag = createTag(P),
            spanTag = createTag(SPAN),
            img = figures[i],
            parent = img.parentNode;
        
        figureTag.className = img.className;
        pTag.className = img.className;
        spanTag.className = img.className;
        figcaptionTag.className = img.className;
        
        parent.replaceChild(figureTag, img);
        spanTag.innerHTML = 'Figuur ' + (i+1);
        pTag.appendChild(spanTag);
        figcaptionTag.appendChild(pTag);
        figureTag.appendChild(figcaptionTag);
        figureTag.appendChild(img);
        
    }// end for i
    
    
    
    //start attachments
    for(var i = 0; i < tables.length; i++){
        
    }

}//end function assignNecessaryTags()

function createTestLayout(){
    var tables = document.getElementsByTagName(TABLE);
    //references to figures in text
    for(let i = 0; i < tables.length; i++){// per table
        var table = tables[i];
        var figcaptions = table.getElementsByTagName(FIGCAPTION);// get all figcaptures in the table
        
        
        for(let j = 0; j < figcaptions.length; j++){// loop trough the figcaptions
            let brack = '{F' + (j+1) + '}',//textref coded
                textRef = getInnerHTML(figcaptions[j]);//correct reffenrence
            
            while(table.innerHTML.match(brack) !== null){
                table.innerHTML = table.innerHTML.replace(brack, textRef);
            }// end while
            
        }// end for j
        
    }// end for i
    
    var tables = document.getElementsByTagName(TABLE),// 
        startNumTables = Number(tables.length),
            
        attachmentTable = document.createElement(TABLE),
        attachmentHead = document.createElement(THEAD),
        attachmentBody = document.createElement(TBODY);

    attachmentTable.className = CLASS_ATTACHMENTTABLE;
    attachmentTable.appendChild(attachmentHead);
    attachmentTable.appendChild(attachmentBody);
    
    var attachmentHeadRow = document.createElement(TR),
        attachmentHeadCell = document.createElement(TD),
        attachmentHeadCellP = document.createElement(P),
        attachmentHeadCellSpan = document.createElement(SPAN);
        
    attachmentHeadCell.colSpan = 2;
    attachmentHeadCellSpan.innerHTML = 'Bijlagen';
    
    attachmentHeadCell.appendChild(attachmentHeadCellP);
    attachmentHeadCell.appendChild(attachmentHeadCellSpan);
    attachmentHeadRow.appendChild(attachmentHeadCell);
    attachmentHead.appendChild(attachmentHeadRow);
    
    
    
    
    var tableIterations = 0;
    var questionNumber = 0;
    for(var i = 0; i < startNumTables; i++){
        var table = tables[i + tableIterations];
        
        //set title to correctionmodel as wel
        table.rows[0].cells[3].innerHTML = table.rows[1].cells[1].innerHTML;
        
        // create assignment table
            var assignmentTable = document.createElement(TABLE),
                assignmentHead = document.createElement(THEAD),
                assignmentBody = document.createElement(TBODY);

            assignmentTable.appendChild(assignmentHead);
            assignmentTable.appendChild(assignmentBody);
            // add class-names
            assignmentTable.className = table.className;
            assignmentTable.className += CLASS_ASSIGNMENT;
            assignmentHead.className = table.className;
            assignmentBody.className = table.className;
        
        
        for(var j = 2; j < table.rows.length; j++){
            //hide analyses
            
            var numPoints = 0;
            
            if(table.rows[j].cells[0].hasAttribute(ROWSPAN)){//skip a few rows if there is a rowspan (because of the points)
                numPoints = table.rows[j].cells[0].rowSpan - 2;
            }// end if
            
            
            
            //assignmentpart
            var assignmentRow = document.createElement(TR);//create row als holder for cells
            assignmentRow.insertCell(0);//create new empty cell for points reference
            assignmentRow.appendChild(table.rows[j].cells[0]);//insert type-cell in assignment
            assignmentRow.appendChild(table.rows[j].cells[0]);//insert question-, info- or figure-cell in assignment
            assignmentBody.appendChild(assignmentRow);//add row to assingment-body
            
            assignmentRow.cells[1].innerHTML = EMPTYSTRING;
            
            if(assignmentRow.cells[1].className.match(CLASS_QUESTION)){
                let qnP = document.createElement(P),
                    qnSpan = document.createElement(SPAN);
                
                questionNumber++;
                
                qnSpan.innerHTML = questionNumber;
                
                qnP.appendChild(qnSpan);
                assignmentRow.cells[1].appendChild(qnP);
            }
                        
            var attachmentRow = document.createElement(TR);
            attachmentBody.appendChild(attachmentRow);
            attachmentRow.appendChild(table.rows[j].cells[0]);
            attachmentRow.appendChild(table.rows[j].cells[0]);
            
            
                    
            if(numPoints > 0){//skip a few rows if there is a rowspan (because of the points)
                j += numPoints + 1;

            }// end if
            
            

            if(assignmentRow.cells[1].hasAttribute(ROWSPAN)){//remove the rospan attribute from the type-cell
                assignmentRow.cells[1].removeAttribute(ROWSPAN);
            }// end if

            if(assignmentRow.cells[2].hasAttribute(ROWSPAN)){//remove the rospan attribute from the question-, info- or figure-cell
                assignmentRow.cells[2].removeAttribute(ROWSPAN);
            }// end if
            
            if(attachmentRow.cells[0].hasAttribute(ROWSPAN)){//remove the rospan attribute from the type-cell
                attachmentRow.cells[0].removeAttribute(ROWSPAN);
            }// end if

            if(attachmentRow.cells[1].hasAttribute(ROWSPAN)){//remove the rospan attribute from the question-, info- or figure-cell
                attachmentRow.cells[1].removeAttribute(ROWSPAN);
            }// end if

            assignmentRow.className = assignmentRow.cells[1].className;
            assignmentRow.cells[0].className = assignmentRow.cells[1].className;
            assignmentRow.cells[0].className += CLASS_NUMPOINTS;
            assignmentRow.cells[1].className += CLASS_TYPE;

            if(numPoints > 0){
                let points = numPoints + 'p',

                    par = document.createElement(P),
                    span = document.createElement(SPAN);

                par.className = assignmentRow.cells[0].className;
                span.className = assignmentRow.cells[0].className;

                span.innerHTML = points;
                par.appendChild(span);
                assignmentRow.cells[0].appendChild(par);
            }// end if
            
        
        
        }// end for j
        
        var thRow = document.createElement(TR);
        thRow.appendChild(table.rows[1].cells[0]);
        thRow.appendChild(table.rows[1].cells[0]);
        thRow.cells[0].innerHTML = '';
        thRow.cells[1].colSpan = 2;
        assignmentHead.appendChild(thRow);
        
        document.body.insertBefore(assignmentTable, document.body.children[i]);
        
        table.rows[0].deleteCell(0);
        table.rows[0].deleteCell(0);
        table.rows[0].deleteCell(0);
        table.rows[1].deleteCell(0);
        table.rows[1].deleteCell(0);
        
        table.rows[0].deleteCell(1);
        table.rows[0].deleteCell(1);
        table.rows[0].deleteCell(1);
        
        table.className += CLASS_ANSWERSHEET;
        tableIterations++;
    }// end for i
    
    document.body.insertBefore(attachmentTable, document.body.children[tables.length/2]);
    
    //remove empty rows
    var attachmentTable = document.getElementsByClassName(CLASS_ATTACHMENTTABLE),
        ansersheetTables = document.getElementsByClassName(CLASS_ANSWERSHEET),
        deleteRowTables = [attachmentTable, ansersheetTables];//tablearray

        

    for(var i = deleteRowTables.length - 1; i > -1; i--){//go trough table array
        var cuTables = deleteRowTables[i];
        
        for(var j = cuTables.length - 1; j > -1; j--){//trough table
            var cuTable = cuTables[j];
            
            for(var k = cuTable.rows.length - 1; k > 0; k--){// rows
                let row = cuTable.rows[k],
                    cell0 = row.cells[0];
            
            if(cell0.className.match(CLASS_EMPTY) !== null){
               row.remove();
            }
            
            
                
            }//end for k  reverse
        }// end for j reverse
    }// end for i reverse
    
    
    
    var questionAnswerNumber = attachmentTable[0].rows.length -1;
    
    for(var i = attachmentTable[0].rows.length -1; i > 0; i--){
        let row = attachmentTable[0].rows[i],
            cell = row.cells[1],
            
            numP = document.createElement(P),
            numSpan = document.createElement(SPAN);
    
        numSpan.innerHTML = (i);
        
        numP.appendChild(numSpan);
        row.cells[0].innerHTML = '';
        row.cells[0].appendChild(numP);
        
        if(cell.className.match(CLASS_EMPTY) !== null){
            row.remove();
        }
    }
    
    for(var i = ansersheetTables.length - 1; i > -1 ; i--){
        let asTable = ansersheetTables[i],
            newRowSpan = 2,
            bodyGroup = 0;
        
        for(var j = asTable.rows.length -1; j > 0; j--){
            let row = asTable.rows[j];
            
            row.cells[0].className += CLASS_TYPE;
            
            if(row.cells[0].className.match(CLASS_POINTS) !== null){
                if(j > bodyGroup){
                    bodyGroup = j;
                }
                
                newRowSpan++;
                row.cells[0].innerHTML = BULLET;
                row.cells[0].className += CLASS_BULLET;
                row.cells[3].className += CLASS_HIDDEN;
                row.cells[4].className += CLASS_HIDDEN;
                row.cells[5].className += CLASS_HIDDEN;
            }
            
            if(row.cells[0].className.match(CLASS_CALCULATION) !== null){
                row.cells[0].innerHTML = EMPTYSTRING;
                row.cells[2].className += CLASS_HIDDEN;
                row.cells[3].className += CLASS_HIDDEN;
                row.cells[4].className += CLASS_HIDDEN;
            }
            
            if(row.cells[0].className.match(CLASS_ANSWER) !== null){
                let newCell = document.createElement(TD),
                    newCellP = document.createElement(P),
                    newCellSpan = document.createElement(SPAN),
                    
                    tableBody = document.createElement(TBODY);
                
                row.cells[2].className += CLASS_HIDDEN;
                row.cells[3].className += CLASS_HIDDEN;
                row.cells[4].className += CLASS_HIDDEN;
                
                row.cells[0].innerHTML = 'Antwoord:';
                newCell.rowSpan = newRowSpan;
                newRowSpan = 2;
                
                newCellSpan.innerHTML = questionAnswerNumber;
                newCellP.appendChild(newCellSpan);
                newCell.appendChild(newCellP);
                newCell.className += CLASS_TYPE;
                newCell.className += CLASS_ANSWER;
                row.insertBefore(newCell, row.firstChild);
                questionAnswerNumber--;
                
                asTable.insertBefore(tableBody, asTable.children[1]);
                
                while(bodyGroup > j-1){
                    tableBody.appendChild(asTable.rows[j]);
                    bodyGroup--;
                }
                
                bodyGroup = 0;
            }// end if
        
        
        }// end for j reverse
        
        ansersheetTables[i].rows[0].cells[0].colSpan = 3;
        
        var answersheetHead = document.createElement(THEAD);
        var puntenCell = document.createElement(TD);
        puntenCell.innerHTML = 'punten';
        ansersheetTables[i].insertBefore(answersheetHead, ansersheetTables[i].firstChild);
        answersheetHead.appendChild(ansersheetTables[i].rows[0]);
        answersheetHead.rows[0].appendChild(puntenCell);
    }// end for i reverse
    
    


}// end function createTestLayout()


function getInnerHTML(node){
    return node.querySelectorAll(SPAN)[0].innerHTML.trim();
}

function createTag(tagName){
    return document.createElement(tagName);
}


