
<!DOCTYPE HTML>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">   <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"><link rel="manifest" href="/site.webmanifest">
   
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/092029466e.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <title>Analýza frameworků</title>
</head>

<body>
    <button class="back" onclick="window.location.href='index.php'"><i class="fas fa-caret-square-left"></i></button>
    
    <div class="cont-vyber">
    <div class="zprava-choose">
        <h2 class="text-black center">Výpis analýzy</h2>
        <div class="udaje">
        <p class="center">Přehled všech proběhlých analýz</p>
            <button class="prehled" onclick="window.location.href='summary.php'">Zobrazit</button>
        </div>
    </div>

    <div class="zprava-choose">
        <h2 class="text-black center">Top 500 webů</h2>
        <div class="udaje">
        <p class="center">Analýza 500 nejpopulárnějších webů podle: moz.com </p>
            <button class="prehled" onclick="window.location.href='framework.php'">Zobrazit</button>
        </div>
    </div>
    </div>
    <footer class="footer">© 2021 | Marián Macura</footer>
</body>
</html>
