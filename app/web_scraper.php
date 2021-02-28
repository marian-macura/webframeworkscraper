<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "framework";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}?>
<!DOCTYPE HTML>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/092029466e.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <title>Statistiky frameworků</title>
</head>

<body>
    <button class="back" onclick="window.location.href='test.php'"><i class="fas fa-caret-square-left"></i></button>
    <div class="zprava-db">
        <h2 class="text-black center">Údaje</h2>
        <div class="udaje">

            <?php 
/*Počítadla*/
$countBootstrap = 0;
$countFoundation = 0;
$countMaterialize = 0;
$countBulma = 0;
    
    
$bo = 'bootstrap';    
$fo = 'foundation';
$mat = 'materialize'; 
$bu = 'bulma';               
    
$http = 'http://';

$uname = $_POST["name"];
            
/* Kontrola jestli url obsahuje http */if (str_starts_with($uname, 'http')) {} else {$uname= $http.$uname;}
            
include('simple_html_dom.php');
$html = file_get_html($uname);

$css ="";
$jss ="";       
    
/*Inicializace proměné, pro ukládání do databáze*/$framework = "";
    
    
    foreach($html->find('link') as $element){
       if (str_contains($element, $bo)) {$countBootstrap++;} 
    elseif 
        (str_contains($element, $fo)){$countFoundation++;}
    elseif 
        (str_contains($element, $mat)){$countMaterialize++;}
    elseif 
        (str_contains($element, $bu)){$countBulma++;};}


foreach($html->find('script') as $element){
       if (str_contains($element, $bo)) {$countBootstrap++;} 
    elseif 
        (str_contains($element, $fo)){$countFoundation++;}
    elseif 
        (str_contains($element, $mat)){$countMaterialize++;}
    elseif 
        (str_contains($element, $bu)){$countBulma++;};}
    
            
    if($countBootstrap == 0 && $countFoundation == 0 && $countMaterialize == 0 && $countBulma ==0){
    
    
$searchfor = '.css';
$file = file_get_contents($uname);
$dtml = new DOMDocument();
@$dtml->loadHTML($file);
foreach($dtml->getElementsByTagName('link') as $a) {
    $property=$a->getAttribute('href');
    if (strpos($property , $searchfor)){
      @$css = file_get_html($uname."/".$property);
        @$dss = file_get_html($property);
   /*     echo $property; */
  /*  echo $_POST["name"]."/".$property; */
        
        if (str_contains($css, $bo)) {$countBootstrap++;} elseif (str_contains($dss, $bo)) {$countBootstrap++;} 
        elseif 
            (str_contains($css, $fo)){$countFoundation++;} elseif (str_contains($dss, $fo)) {$countFoundation++;}
        elseif 
            (str_contains($css, $mat)){$countMaterialize++;} elseif (str_contains($dss, $mat)) {$countMaterialize++;}
        elseif 
            (str_contains($css, $bu)){$countBulma++;} elseif (str_contains($dss, $bu)) {$countBulma++;};   
        
}}       
        }
        

if($countBootstrap == 0 && $countFoundation == 0 && $countMaterialize == 0 && $countBulma ==0){
    
$JSsearchfor = '.js';
$JSfile = file_get_contents($uname);
$JSdtml = new DOMDocument();
@$JSdtml->loadHTML($JSfile);
foreach($JSdtml->getElementsByTagName('script') as $a) {
    $JSproperty=$a->getAttribute('src');
    if (strpos($JSproperty , $JSsearchfor)){
      @$js = file_get_html($uname."/".$JSproperty);
        @$jjs = file_get_html($JSproperty);
  /*      echo $JSproperty; */
  /*  echo $_POST["name"]."/".$JSproperty; */
        
    if (str_contains($js, $bo)) {$countBootstrap++;} elseif (str_contains($jjs, $bo)) {$countBootstrap++;} 
    elseif 
        (str_contains($js, $fo)){$countFoundation++;} elseif (str_contains($jjs, $fo)) {$countFoundation++;} 
    elseif 
        (str_contains($js, $mat)){$countMaterialize++;} elseif (str_contains($jjs, $mat)) {$countMaterialize++;}
    elseif 
        (str_contains($js, $bu)){$countBulma++;} elseif (str_contains($jjs, $bu)) {$countBulma++;};   
        
}}
 }    

    
@$title = $html->find('title', 0)->plaintext;
if(is_null($title)){$title = "Nepodařilo se zjistit název stránky";}
print " <center><span class='udaj-title'>" . $title . "</span></center>";
   
if ($countBootstrap>0) {$framework = $bo;}elseif ($countFoundation>0)  {$framework = $fo;} elseif ($countMaterialize>0)  {$framework = $mat;} elseif ($countBulma>0)  {$framework = $bu;} else {$framework ="N/A";}
    
$sql = "INSERT INTO frm (title, url, framework)
VALUES ('$title', '$uname', '$framework')";
$dsql ="SELECT * FROM frm ORDER BY score DESC";

    if (mysqli_query($conn, $sql)) {print "<center class='vys'><span class='udaj-title'>".'Údaje byly úspěšně zaznamenány'."</span></center>";} else {
  print "Chyba: " . $sql . "<br>" . mysqli_error($conn);
}?>

            <p class="center">Framework: <?php  print  $framework ; ?></p>
            <button class="prehled" onclick="window.location.href='framework.php'">Přehled</button>
        </div>
    </div>
    <footer class="footer">© 2021 | Marián Macura</footer>
</body>
</html>
