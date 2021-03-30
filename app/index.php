<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"><link rel="manifest" href="/site.webmanifest">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/092029466e.js" crossorigin="anonymous"></script>
    <title>Analýza webových stránek | Framework</title>
</head>
<body>

<div class="loader">
  <div class="loading">
  </div>
</div>

    <div class="urlform">
        <h2 class="text-form">Zadejte klíčovou frázi</h2>
        <form class="adresa" action="testing.php" method="post">
            <input class="texte" type="text" name="name" placeholder="Cestovní kancelář" required><br>
            <button type="submit" onclick="spinner()"><i class="fas fa-angle-double-right"></i></button>
        </form>

        <a href="rozcestnik.php"><button class="analyse">Proběhlé analýzy</button></a>
        <a href="info.php"><button class="analyse">Informace o projektu</button></a>
    </div>

    
    <footer class="footer">© 2021 | Marián Macura</footer>

    <script type="text/javascript">
    function spinner() {
        document.getElementsByClassName("loader")[0].style.display = "block";
    }
</script>    
</body>
</html>
