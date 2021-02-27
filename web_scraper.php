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
      <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/092029466e.js" crossorigin="anonymous"></script>

</head>
<body>
/*Navigace*/<button class="back" onclick="window.location.href='test.php'"><i class="fas fa-caret-square-left"></i></button>
/*Navigace*/<button class="prehled" onclick="window.location.href='framework.php'">Přehled</button>
            <h2 class="text-form">Údaje</h2>
 

<div class="udaje">
        
<?php 
$ver = $_POST["name"];
include('simple_html_dom.php');
$html = file_get_html($_POST["name"]);
@$title = $html->find('title', 0)->plaintext;
if(is_null($title)){$title = "Nepodařilo se zjistit název stránky";}
print " <center><span class='udaj-title'>" . $title . "</span></center>";

/*Počítadla*/
$countBootstrap = 0;
$countFoundation = 0;
$countMaterialize = 0;
$countBulma = 0;

 $list = $html->find('link',0);


foreach($html->find('link') as $element)
       if (str_contains($element, 'bootstrap')) {
    $countBootstrap++;} elseif (str_contains($element, 'foundation')){
    $countFoundation++;}elseif (str_contains($element, 'materialize')){
    $countMaterialize++;}elseif (str_contains($element, 'bulma')){
    $countBulma++;};

$list2 = $html->find('script',0);


foreach($html->find('script') as $element)
       if (str_contains($element, 'bootstrap')) {
    $countBootstrap++;} elseif (str_contains($element, 'foundation')){
    $countFoundation++;}elseif (str_contains($element, 'materialize')){
    $countMaterialize++;}elseif (str_contains($element, 'bulma')){
    $countBulma++;};

/*Inicializace proměné, pro ukládání do databáze*/$framework = "";

if ($countBootstrap>0) {$framework = "Bootstrap";}elseif ($countFoundation>0)  {$framework = "Foundation";} elseif ($countMaterialize>0)  {$framework = "Materialize";} elseif ($countBulma>0)  {$framework = "Bulma";} else {$framework ="Žádný nebo neznámý framework";}


$sql = "INSERT INTO frm (title, url, framework)
VALUES ('$title', '$ver', '$framework')";
$dsql ="SELECT * FROM frm ORDER BY score DESC";

    if (mysqli_query($conn, $sql)) {print "<center class='vys'><span class='udaj-title'>".'Údaje byly úspěšně zaznamenány'."</span></center>";} else {
  print "Chyba: " . $sql . "<br>" . mysqli_error($conn);
}
?>
     </div>
<footer class="footer">© 2021 | Marián Macura</footer></body></html>


