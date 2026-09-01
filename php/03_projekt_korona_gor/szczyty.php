<?php
// POŁĄCZONY WZORZEC (Moduł 03 + Moduł 02) — karta szczytu
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1, SEC-2] Połączenie z bazą korona (osobne na każdej stronie)
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
            // Moduł 03: [SEC-1] ID przesłane z index.php metodą GET
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Moduł 03: [SEC-2] Zapytanie 3 — JOIN opis, WHERE id z GET
                $query = "SELECT szczyty.plik, szczyty.nazwa, szczyty.wysokosc, szczyty.pasmo, opis.opis
                          FROM szczyty
                          JOIN opis ON szczyty.id = opis.szczyty_id
                          WHERE szczyty.id = $id;";
                $result = $conn->query($query);

                // Moduł 03: [SEC-3] Jeden rekord — pojedyncze fetch_assoc()
                $row = $result->fetch_assoc();

                // Moduł 03: [SEC-4] Obraz.duze, h2 z nazwą, wysokość i pasmo, opis
                echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='duze'>";
                echo "<h2>" . $row['nazwa'] . "</h2>";
                echo "<p>Wysokość: " . $row['wysokosc'] . " m n.p.m.</p>";
                echo "<p>Pasmo górskie: " . $row['pasmo'] . "</p>";
                echo "<p>" . $row['opis'] . "</p>";
            }
            ?>
        </main>

        <section>
            <?php
            // Moduł 02: [SEC-1, SEC-4] Ten sam Skrypt 2 co na index.php
            $query = "SELECT nazwa, plik FROM szczyty LIMIT 10;";
            $result = $conn->query($query);

            // Moduł 02: [SEC-2, SEC-3] class="miniatury" (nie mylić z class="duze")
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
