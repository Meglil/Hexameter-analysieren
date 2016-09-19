<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="application/x-www-form-urlencoded; charset=UTF-8">
</head>
<body>

<?php

/*
function umlaute($text){ 
    $returnvalue=""; 
    for($i=0;$i<strlen($text);$i++){ 
        $teil=hexdec(rawurlencode(substr($text, $i, 1))); 
        
        if($teil<32||$teil>1114111){ 
            $returnvalue.=substr($text, $i, 1); 
        }else{ //echo "&#224";
               $returnvalue.="&#".$teil.";"; 
               //$returnvalue.="&#224"; 
        } 
    } 
    return $returnvalue; 
}

habe mich mal daran versucht das ganze in eine hexa datenbank umzucoden
*/ 


require("connection.php"); // Verbindung mit Webserver aufbauen

$query = $_GET["Hexameter"]; // Eingabe 


$einzeln = preg_split("/[\s,-]+/", $query); //um jedes Wort einzeln zu suchen
$einzeln = $einzeln[0]; 


$results=mysqli_query($con,"SET NAMES utf8"); //Umcodierung


$results= mysqli_query($con,'SELECT * FROM forms WHERE  sounds LIKE "%'.$einzeln.'%"') or die(mysqli_error());

// Sounds like Funktion, da ja unterschiedliche Betonungen des gleichen Wortes gesucht werden. 


if(mysqli_num_rows($results) == 0)  { // falls nichts oder irrelevantes eingegeben wurde
echo "Deine Eingabe wurde nicht gefunden"; 
                                    }
	




if(mysqli_num_rows($results) > 0) {


		while($row=mysqli_fetch_array($results)) {
				    
		   
//---- Ellisionen ---

$einzeln = $row["sounds"];

$vowels = array("a","e","i","o","u","h");
$ending1 = array("am","im","em","om","um");
$ending2 = array("am","im","em","om","a","e","i","o","u","h");
$words = explode(" ",$einzeln);


for($i=0;$i<count($words);$i++)
{

   $first=substr($words[$i],-1);
   $string=$words[$i+1];
   $second= $string[0];


   $first_2=substr($words[$i],-2);
   $first_3=substr($words[$i],-2);

		if( isset($first) && isset($second) ){
		    if (   in_array($first,$vowels) && in_array($second,$vowels) ){
			$words[$i]=substr($words[$i],0,-1);
			}

		}


		if( isset($first_2) && isset($second) ){
				    if (   in_array($first_2,$ending1) && in_array($second,$vowels) ){
					$words[$i]=substr($words[$i],0,-2);
					}

		}


		if( isset($first_3) ){
				    if (   in_array($first_3,$ending2) && in_array($second,array('es','est')) ){
					$words[$i]=substr($words[$i],0,-2);
					}

		}



}


//---- Silbentrennung --- 
$psdoc = ps_new();
ps_set_parameter($psdoc, "hyphendict", "hyph_de.dic");
$hyphens = ps_hyphenate($psdoc, $word);
	for($i=0; $i<strlen($word); $i++) {
  		echo $word[$i];
  			if(in_array($i, $hyphens))
    		echo "-";
}

ps_delete($psdoc);
      
}









		
		}






} 

if (mysqli_num_rows($results) > 1) {

	

		while($row=mysqli_fetch_array($results)) {
			
			//Code für mehrdeutige Formen ist noch fehlerhaft	    
		   
          }		    

} 


?>



