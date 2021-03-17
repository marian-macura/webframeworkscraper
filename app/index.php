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
    <div class="urlform">
        <h2 class="text-form">Zadejte klíčova slova a počet výsledků (Google)</h2>
        <h4 class="text-form">Následující pole slouží k procházení výsledků tří search enginů (Seznam, Yahooo a Google),
        berte prosím na vědomí, že čím více výsledků je požadována, tím déle analýza trvá.</h4>
        <form class="adresa" action="testing.php" method="post">
            <input class="texte" type="text" name="name" placeholder="Cestovní kancelář" required><br>
            <input class="number" type="text" name="nmb" placeholder="10-100" required>
            <button type="submit"><i class="fas fa-angle-double-right"></i></button>
        </form>

        <a href="frameworks.php"><button class="analyse">Proběhlé analýzy</button></a>
    </div>

    
    <footer class="footer">© 2021 | Marián Macura</footer>
</body>
</html>
