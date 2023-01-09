<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <?php
    $authors = array();
    $results = array();
    $subresults = array();
    
        populateArray($authors, $results, $subresults);
        
        function main($authors, $results, $subresults){
                for($i = 0; $i < count($authors); $i++){
                    $doc = new DomDocument();
                    $doc -> load("$authors[$i].xml");
                    $xpath = new DOMXPath($doc);
                    $tbody = $doc->getElementsByTagName('tbody')->item(0);
                    for($l = 0; $l < count($authors); $l++){
                        
                        $pidToCompare = getPid($authors[$l]);
                        
                        $nodeXPath = 'name(/r/*)';
                        $nodeName = $xpath->evaluate($nodeXPath, $tbody);
                        
                        if(isVenue()){
                            $venue = $_POST['venue'];
                           
                            $nodeAuthorArticleJournalCountXPath = 'count(r/article[author[@pid ='.'"'.$pidToCompare.'"'.']and journal ='.'"'.$venue.'"'.'])';
                            $nodeAuthorArticleJournalCount = $xpath->evaluate($nodeAuthorArticleJournalCountXPath, $tbody);
                            
                            $nodeAuthorIncollectionBooktitleCountXPath = 'count(r/incollection[author[@pid ='.'"'.$pidToCompare.'"'.']and booktitle ='.'"'.$venue.'"'.'])';
                            $nodeAuthorIncollectionBooktitleCount = $xpath->evaluate($nodeAuthorIncollectionBooktitleCountXPath, $tbody);
                            
                            $nodeAuthorInproceedingsBooktitleCountXPath = 'count(r/inproceedings[author[@pid ='.'"'.$pidToCompare.'"'.']and booktitle ='.'"'.$venue.'"'.'])';
                            $nodeAuthorInproceedingsBooktitleCount = $xpath->evaluate($nodeAuthorInproceedingsBooktitleCountXPath, $tbody);
                            
                            $nodeEditorProceedingsBooktitleCountXPath = 'count(r/proceedings[editor[@pid ='.'"'.$pidToCompare.'" '.']and booktitle = '.'"'.$venue.'"'.'])';
                            $nodeEditorProceedingsBooktitleCount = $xpath->evaluate($nodeEditorProceedingsBooktitleCountXPath, $tbody);
                            
                            $result =  $nodeAuthorArticleJournalCount + $nodeAuthorIncollectionBooktitleCount + $nodeAuthorInproceedingsBooktitleCount + $nodeEditorProceedingsBooktitleCount;
                            array_push($subresults, $result);
                        }
                        else{
                            $nodeAuthorArticleCountXPath = 'count(r/article/author[@pid ='.'"'.$pidToCompare.'"'.'])';
                            $nodeAuthorArticleCount = $xpath->evaluate($nodeAuthorArticleCountXPath, $tbody);
                            
                            $nodeAuthorBookCountXPath = 'count(r/book/author[@pid ='.'"'.$pidToCompare.'"'.'])';
                            $nodeAuthorBookCount = $xpath->evaluate($nodeAuthorBookCountXPath, $tbody);
                            
                            $nodeAuthorIncollectionCountXPath = 'count(r/incollection/author[@pid ='.'"'.$pidToCompare.'"'.'])';
                            $nodeAuthorIncollectionCount = $xpath->evaluate($nodeAuthorIncollectionCountXPath, $tbody);
                            
                            $nodeAuthorInproceedingsCountXPath = 'count(r/inproceedings/author[@pid ='.'"'.$pidToCompare.'"'.'])';
                            $nodeAuthorInproceedingsCount = $xpath->evaluate($nodeAuthorInproceedingsCountXPath, $tbody);
                            
                            $nodeEditorBookCountXPath = 'count(r/book/editor[@pid ='.'"'.$pidToCompare.'"'.'])';
                            $nodeEditorBookCount = $xpath->evaluate($nodeEditorBookCountXPath, $tbody);
                            
                            $nodeEditorProceedingsCountXPath = 'count(r/proceedings/editor[@pid ='.'"'.$pidToCompare.'"'.'])';
                            $nodeEditorProceedingsCount = $xpath->evaluate($nodeEditorProceedingsCountXPath, $tbody);
                            
                            $result =  $nodeAuthorArticleCount + $nodeAuthorBookCount + $nodeAuthorIncollectionCount + $nodeAuthorInproceedingsCount + $nodeEditorBookCount + $nodeEditorProceedingsCount;
                            
                            array_push($subresults, $result);
                        }
                    }
                    array_push($results, $subresults);
                    $subresults = array();
                }
                getTable($authors, $results);
        }
       
        function populateArray($authors, $results, $subresults){
            if (isset($_POST['alex'])){
                array_push($authors, $_POST['alex']);    
            }
            if (isset($_POST['andrea'])){
                array_push($authors, $_POST['andrea']);    
            }
            if (isset($_POST['jan'])){
                array_push($authors, $_POST['jan']);    
            }
            if (isset($_POST['mark'])){
                array_push($authors, $_POST['mark']);    
            }
            if (isset($_POST['nigel'])){
                array_push($authors, $_POST['nigel']);    
            }
            if (isset($_POST['peter'])){
                array_push($authors, $_POST['peter']);    
            }
           main($authors, $results, $subresults);
        }
        
        function getTable($authors, $results){
            if(count($authors) == 0){
                die("Please select at least one author/editor");
            }
            else if(!isVenue()){
                    echo "<h1><b>NO VENUE SELECTED !!!</b></h1>";
            }
            else{
                echo "<h1><b>VENUE: ".$_POST['venue']. " !!!</b></h1>";
            }
            echo "<table cellspacing='10'>"; 
            echo "<tr>";
            echo "<th>";
            echo "</th>";
            for($i = 0; $i < count($authors); $i++){
                $name = getName($authors[$i]);
                echo "<th>";
                    echo "<b>$name</b>";
                echo "</th>";
            }
            echo "</tr>";
                for($i = 0; $i < count($authors); $i++){
                    $name = getName($authors[$i]);
                    echo "<tr>";
                        echo "<td>";
                             echo "<b>$name</b>";
                        echo "</td>";
                        for($j = 0; $j < count($results[$i]); $j++){
                            echo "<td>";
                                echo $results[$i][$j];
                            echo "</td>";
                        }
                    echo "</tr>";
                }
            echo "</table>";
        }
        
        function getPid($value){
            if($value === "Poulovassilis-Alexandra"){
                return "p/APoulovassilis";
            }
            if($value === "Cali-Andrea"){
                return "c/AndreaCali";
            }
            if($value === "Hidders-Jan"){
                return "h/JanHidders";
            }
            if($value === "Levene-Mark"){
                return "l/MarkLevene";
            }
            if($value === "Martin-Nigel"){
                return "m/NigelJMartin";
            }
            if($value === "Wood-Peter"){
                return "w/PeterTWood";
            }
        }
        
        function getName($name){
            if($name === "Poulovassilis-Alexandra"){
                return "Alex";
            }
            if($name === "Cali-Andrea"){
                return "Andrea";
            }
            if($name === "Hidders-Jan"){
                return "Jan";
            }
            if($name === "Levene-Mark"){
                return "Mark";
            }
            if($name === "Martin-Nigel"){
                return "Nigel";
            }
            if($name === "Wood-Peter"){
                return "Peter";
            }
        }
        
        function isVenue(){
            if($_POST['venue'] == null){
                return false;
            }
            else{
                return true;
            }
        }
    ?>
</body>
</html>