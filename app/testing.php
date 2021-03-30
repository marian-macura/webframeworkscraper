<?php $sn='freedb.tech';$un='freedbtech_Corvere';$ps='comegu06';$db='freedbtech_bakaprace';$conn=new mysqli($sn, $un, $ps, $db);if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}
include('simple_html_dom.php');
$phrase=$_POST['name'];
$phrase=strtr($phrase,' ','+');
$stack=array('');$donestack=array('');
$bo='bootstrap';$fo='foundation';$fo2='Foundation for Sites';$mat='materialize';$bu='bulma';$ui='uikit';$pu='pure';$pu2='pure-css';$mi='milligram';$mi2='https://milligram.io';$tw='tailwind';$tw2='tailwindcss';$sm='semantic';$sm2='Semantic UI';$mt='material design lite';$mt2='material-design-lite';
$framework='';
$meta='';
$http='https://';
function get_domain($h){$mh=strtolower(trim($h));$count=substr_count($mh,'.');if($count===2){if(strlen(explode('.',$mh)[1])>3)$mh=explode('.',$mh,2)[1];}else if($count>2){$mh=get_domain(explode('.',$mh,2)[1]);}return $mh;}
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,'https://www.google.com/search?q='.$phrase);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($curl);
curl_setopt($curl,CURLOPT_URL,'https://search.seznam.cz/?q='.$phrase);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$result2=curl_exec($curl);
curl_setopt($curl,CURLOPT_URL,'https://search.yahoo.com/search?p='.$phrase);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$result3=curl_exec($curl);curl_close($curl);

$domResult=new simple_html_dom();@$domResult->load($result);
$domResulte=new simple_html_dom();@$domResulte->load($result2);
$domResulta=new simple_html_dom();@$domResulta->load($result3);
$google=$domResult->find('a[href^=/url?] div');
foreach($google as $link){$donestack[]=get_domain(strstr($link->plaintext, ' ', true));
foreach($donestack as $key => $value)
{if($key%2 != 0) {continue;}if(stripos($value,'.') && !empty($value) && !in_array($value,$stack))
{$stack[]=$value;}}}unset($stack[0]);
$yahoo=$domResulta->find('div span');
foreach($yahoo as $link){$donestack[]=get_domain(strstr($link->plaintext, ' ', true));
foreach($donestack as $key => $value){if(stripos($value,'.') && !empty($value) && !in_array($value,$stack))
{array_push($stack,$value);}}}
$seznam=$domResulte->find('.Result-url');
foreach($seznam as $link){$link=parse_url(get_domain($link->plaintext), PHP_URL_HOST);
if(stripos($link,".") && !in_array($link,$stack)){array_push($stack,$link);}}

foreach($stack as $vvv)
{if(!substr($vvv,0,7)==="http://"){$vvv=$http.$vvv;}
if(!empty($vvv))
{$curl=curl_init();curl_setopt($curl,CURLOPT_URL,$vvv);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$hotml=curl_exec($curl);
curl_close($curl);
$html=new simple_html_dom();
@$html->load($hotml);
$workpole=array('');


if(!empty($html))
{$responsive=$html->find('meta[name=viewport]');if(!empty($responsive)){$meta='ano';}else{$meta='ne';}
foreach($html->find('link') as $element){$workpole[]=$element;}
foreach($html->find('script') as $element){array_push($workpole,$element);}
foreach($workpole as $element){if(stripos($element, $bo)){$framework=$bo;}
if(empty($framework)){if(stripos($element,$fo)){$framework=$fo;}}
if(empty($framework)){if(stripos($element,$mat)){$framework=$mat;}}
if(empty($framework)){if(stripos($element,$bu)){$framework=$bu;}}
if(empty($framework)){if(stripos($element,$ui)){$framework=$ui;}}
if(empty($framework)){if(stripos($element,$pu)){$framework=$pu;}}
if(empty($framework)){if(stripos($element,$mi)){$framework=$mi;}}
if(empty($framework)){if(stripos($element,$tw)){$framework=$tw;}}
if(empty($framework)){if(stripos($element,$sm)){$framework=$sm;}}}

if(empty($framework)){$moreworkpole=array('');
@$file=file_get_contents($http.$vvv);
$dtml=new DOMDocument();
if(!empty($file)){@$dtml->loadHTML($file);
$searchfor='.css';$JSsearchfor='.js';
foreach($dtml->getElementsByTagName('link') as $a)
{$property=$a->getAttribute('href');$moreworkpole[]=$property;}
foreach($dtml->getElementsByTagName('script') as $a)
{$property=$a->getAttribute('src');array_push($moreworkpole,$property);}
foreach($moreworkpole as $element){if(strpos($element, $searchfor) OR strpos($element, $JSsearchfor))
{@$css=file_get_html($http.$vvv."/".$element);@$dss=file_get_html($element);
if(stripos($css, $bo) OR stripos($dss, $bo)){$framework=$bo;}
if(stripos($css, $fo2) OR stripos($dss, $fo2)){$framework=$fo;}
if(stripos($css, $mat) OR stripos($dss, $mat)){$framework=$mat;}
if(stripos($css, $bu) OR stripos($dss, $bu)){$framework=$bu;}
if(stripos($css, $ui) OR stripos($dss, $ui)){$framework=$ui;}
if(stripos($css, $pu2) OR stripos($dss, $pu2)){$framework=$pu;}
if(stripos($css, $mi2) OR stripos($dss, $mi2)){$framework=$mi;}
if(stripos($css, $tw2) OR stripos($dss, $tw2)){$framework=$tw;}
if(stripos($css, $sm2) OR stripos($dss, $sm2)){$framework=$sm;}
if(stripos($css, $mt2) OR stripos($dss, $mt2)){$framework=$mt;}}}}}
if(empty($framework)){$framework='zadny';}

$sql="INSERT INTO frames (url,framework,name,responsive)VALUES('$vvv','$framework','$phrase','$meta')";
unset($framework);unset($meta);mysqli_query($conn,$sql);}}}unset($stack);mysqli_close($conn);?>
<!DOCTYPE HTML><html><head><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="styles.css"><link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png"><link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"><link rel="manifest" href="/site.webmanifest"><link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"><script src="https://kit.fontawesome.com/092029466e.js" crossorigin="anonymous"></script><meta charset="UTF-8"><title>Analýza frameworků</title></head><body><button class="back" onclick="window.location.href='index.php'"><i class="fas fa-caret-square-left"></i></button><div class="zprava-db"><h2 class="text-black center">Údaje</h2><div class="udaje"><p class="center">Údaje byly zpasány do databáze</p><button class="prehled" onclick="window.location.href='summary.php'">Přehled</button></div></div><footer class="footer">© 2021 | Marián Macura</footer></body></html>