<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02) — strona główna
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Parametry dostępowe (baza korona) i [SEC-2] Obiekt połączenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "korona";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Korona gór polskich</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <div id="header1">
            <img src="logo.png" alt="Logo">
        </div>

        <div id="header2">
            <h1>Korona Gór Polskich</h1>
        </div>

        <main>
            <?php
            // Moduł 01: [SEC-3] Zapytanie 1 — id, nazwa, ORDER BY wysokosc DESC
            $query = "SELECT id, nazwa FROM szczyty ORDER BY wysokosc DESC;";
            $result = $conn->query($query);

            // Moduł 01: [SEC-4] Pętla while + fetch_assoc()
            while ($row = $result->fetch_assoc()) {
                // Moduł 01: [SEC-5] <span> oraz odnośnik szczyty.php?id= (GET)
                echo "<span><a href='szczyty.php?id=" . $row['id'] . "'>" . $row['nazwa'] . "</a></span> ";
            }
            ?>
        </main>

        <section>
            <?php
            // Moduł 02: [SEC-1] Zapytanie 2 — nazwa, plik, LIMIT 10
            $query = "SELECT nazwa, plik FROM szczyty LIMIT 10;";
            $result = $conn->query($query);

            // Moduł 02: [SEC-2, SEC-3] Miniatury: src = plik, alt = nazwa, class = miniatury
            // Moduł 02: [SEC-4] Ten sam skrypt jest też na szczyty.php
            while ($row = $result->fetch_assoc()) {
                echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='miniatury'>";
            }
            ?>
        </section>

        <div id="footer1">
            <h3>Kontakt</h3>
            <ul>
                <li>Zadzwoń do nas: 111 222 333</li>
                <li><a href="mailto:korona@gory.pl">Napisz do nas</a></li>
            </ul>
        </div>

        <div id="footer2">
            <h3>© Wykonane przez: 00000000000</h3>
        </div>
    </body>
</html>
<?php
// Moduł 01: [SEC-2] Zamknięcie połączenia na końcu skryptu
$conn->close();
?>
