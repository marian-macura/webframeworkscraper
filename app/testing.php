<?php 
$servername = 'localhost';$username = 'root';$password = '';$dbname = 'framework';//Údaje pro připojení do databáze
$conn = new mysqli($servername, $username, $password, $dbname);//Připojení do databáze
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}//Kontrola připojení
include('simple_html_dom.php');
$phrase = $_POST['name'];//Převzetí fráze z index.php
$number = $_POST['nmb'];//Převzetí počtu výsledků pro Google
$phrase = strtr($phrase,' ','+');//Nahradí mezery "+", které se používají v google vyhledávání
$stack = array('');//Pole pro odkazy
$donestack = array('');//Pracovní pole
$bo = 'bootstrap';    
$fo = 'foundation';//Název souboru
$fo2 = 'Foundation for Sites';//Hlavička souboru
$mat = 'materialize'; 
$bu = 'bulma';   
$ui = 'uikit';
$pu = 'pure';
$pu2 = 'pure-css';
$mi = 'milligram';
$mi2 = 'https://milligram.io';
$tw = 'tailwind';
$tw2 = 'tailwindcss';
$sm = 'semantic';//Název souboru
$sm2 = 'Semantic UI';//Hlavička souboru
$mt = 'material design lite';
$mt2 = 'material-design-lite';//Hlavička souboru
$framework = '';
$http = 'https://';

    function get_domain($host){//Odstranění subdomén
    $myhost = strtolower(trim($host));
    $count = substr_count($myhost, '.');
    if($count === 2){
    if(strlen(explode('.', $myhost)[1]) > 3) $myhost = explode('.', $myhost, 2)[1];
    } else if($count > 2){$myhost = get_domain(explode('.', $myhost, 2)[1]);}
    return $myhost;}


//Google
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/search?q='.$phrase.'&num='.$number);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);//Povolit přesměrování
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
//Seznam
curl_setopt($curl, CURLOPT_URL, 'https://search.seznam.cz/?q='.$phrase);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);//Povolit přesměrování
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result2 = curl_exec($curl);
//Yahoo
curl_setopt($curl, CURLOPT_URL, 'https://search.yahoo.com/search?p='.$phrase);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);//Povolit přesměrování
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result3 = curl_exec($curl);
curl_close($curl);
//echo $result;

$domResult = new simple_html_dom();
@$domResult->load($result);

$domResulte = new simple_html_dom();
@$domResulte->load($result2);

$domResulta = new simple_html_dom();
@$domResulta->load($result3);

//Google
$google = $domResult->find('a[href^=/url?] div');
foreach($google as $link){
    $donestack[]=get_domain(strstr($link->plaintext, ' ', true));
    foreach($donestack as $key => $value){
        if($key%2 != 0) {continue;} 
        if(stripos($value,'.') && !empty($value) && !in_array($value,$stack)){$stack[]=$value;}}}
unset($stack[0]); //Odstraní nulté prázdné pole

//yahoo
$yahoo = $domResulta->find('div span');
foreach($yahoo as $link){
    $donestack[]=get_domain(strstr($link->plaintext, ' ', true));
    foreach($donestack as $key => $value){
        if(stripos($value,'.') && !empty($value) && !in_array($value,$stack)){array_push($stack,$value);}}}

//seznam
$seznam = $domResulte->find('.Result-url');
foreach($seznam as $link){
    $link=parse_url(get_domain($link->plaintext), PHP_URL_HOST);
    if(stripos($link,".") && !in_array($link,$stack)){array_push($stack,$link);}}

print_r($stack);


foreach($stack as $vvv){
    if (!str_starts_with($vvv, 'http')) {$vvv= $http.$vvv;}//Přidání https, pokud ho adresa neobsahuje
    if (!empty($vvv)) {//Kontrola, jestli nemáme prázdné adresy
    $html = file_get_html($vvv);
    $workpole = array('');
    if (!empty($html)){// Pokud dokáže získat source kód stránky, pokračuje
    foreach($html->find('link') as $element){$workpole[]=$element;}
    foreach($html->find('script') as $element){array_push($workpole,$element);}
    foreach($workpole as $element){//Zjišťování frameworku z názvu souborů
         if(stripos($element, $bo)) {$framework=$bo;}//Bootstrap 
     elseif(empty($framework)){if(stripos($element,$fo)){$framework=$fo;}}//Foundation
     elseif(empty($framework)){if(stripos($element,$mat)){$framework=$mat;}}//Materialize
     elseif(empty($framework)){if(stripos($element,$bu)){$framework=$bu;}}//Bulma
     elseif(empty($framework)){if(stripos($element,$ui)){$framework=$ui;}}//UIkit          
     elseif(empty($framework)){if(stripos($element,$pu)){$framework=$pu;}}//Pure    
     elseif(empty($framework)){if(stripos($element,$mi)){$framework=$mi;}}//Milligram  
     elseif(empty($framework)){if(stripos($element,$tw)){$framework=$tw;}}//Tailwind 
     elseif(empty($framework)){if(stripos($element,$sm)){$framework=$sm;}}//Semantic  
         }
 


            if(empty($framework)){
                $moreworkpole = array('');
                $file = file_get_contents($vvv);
                $dtml = new DOMDocument();
                @$dtml->loadHTML($file);
                $searchfor = '.css';
                $JSsearchfor = '.js';
                foreach($dtml->getElementsByTagName('link') as $a){ $property=$a->getAttribute('href');$moreworkpole[]=$property;}
                foreach($dtml->getElementsByTagName('script') as $a){$property=$a->getAttribute('src');array_push($moreworkpole,$property);}
                foreach($moreworkpole as $element){
                    if(strpos($element , $searchfor) OR (strpos($element , $JSsearchfor))){
                        @$css = file_get_html($vvv."/".$element);
                          @$dss = file_get_html($element);
                          if (stripos($css, $bo) OR stripos($dss, $bo)) {$framework=$bo;} 
                          elseif(empty($framework)) {if(stripos($css, $fo2) OR stripos($dss, $fo2)){$framework=$fo;}}
                          elseif(empty($framework)) {if(stripos($css, $mat) OR stripos($dss, $mat)){$framework=$mat;}}
                          elseif(empty($framework)) {if(stripos($css, $bu) OR stripos($dss, $bu)){$framework=$bu;}}
                          elseif(empty($framework)) {if(stripos($css, $ui) OR stripos($dss, $ui)){$framework=$ui;} }
                          elseif(empty($framework)) {if(stripos($css, $pu2) OR stripos($dss, $pu2)){$framework=$pu;}}   
                          elseif(empty($framework)) {if(stripos($css, $mi2) OR stripos($dss, $mi2)){$framework=$mi;} }     
                          elseif(empty($framework)) {if(stripos($css, $tw2) OR stripos($dss, $tw2)){$framework=$tw;}  } 
                          elseif(empty($framework)) {if(stripos($css, $sm2) OR stripos($dss, $sm2)){$framework=$sm;}   }
                          elseif(empty($framework)) {if(stripos($css, $mt2) OR stripos($dss, $mt2)){$framework=$mt;}    }
                }
}}

    if(empty($framework)){$framework='žádný';}//Pokud nebyl framework nalezen, je "žádný"

    
$sql = "INSERT INTO frames (url, framework, name, number)
VALUES ('$vvv', '$framework', '$phrase', '$number')";

unset($framework);
    if (mysqli_query($conn, $sql)) {print "<center class='vys'><span class='udaj-title'>".'Údaje byly úspěšně zaznamenány'."</span></center>";} else {
  print "Chyba: " . $sql . "<br>" . mysqli_error($conn);
    echo "<br>";
}}}}

unset($stack);//Vyprázdní se pole*/
mysqli_close($conn);//Ukončí se spojení s databází
?>



