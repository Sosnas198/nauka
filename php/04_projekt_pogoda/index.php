<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Parametry dostępowe (baza pogoda) i obiekt połączenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pogoda";

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
        <title>Pogoda</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <div id="header1">
            <img src="slonce.png" alt="Słonecznie">
        </div>

        <div id="header2">
            <h1>Pogoda w Europie</h1>
        </div>

        <main>
            <div id="lewy">
                <h2>Temperatury w lipcu</h2>
                <table>
                    <tr>
                        <th>Miasto</th>
                        <th>Kraj</th>
                        <th>Temperatura</th>
                        <th>Pogoda</th>
                    </tr>
                    <?php
                    // Moduł 01: [SEC-2] JOIN miejscowosc + pomiary, lipiec (id_miesiac = 7)
                    $query = "SELECT miejscowosc.nazwa, miejscowosc.kraj, pomiary.temperatura
                              FROM miejscowosc
                              JOIN pomiary ON miejscowosc.id = pomiary.id_miejscowosc
                              WHERE pomiary.id_miesiac = 7;";
                    $result = $conn->query($query);

                    // Moduł 01: [SEC-3] Wiersze tabeli: nazwa, kraj, temperatura
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nazwa"] . "</td>";
                        echo "<td>" . $row["kraj"] . "</td>";
                        echo "<td>" . $row["temperatura"] . "</td>";

                        // Moduł 01: [SEC-4] Ikony: > 30 słońce, < 26 deszcz, inaczej chmury
                        if ($row["temperatura"] > 30) {
                            echo "<td><img src='slonce.png' alt='Słońce'></td>";
                        } else if ($row["temperatura"] < 26) {
                            echo "<td><img src='deszcz.png' alt='Deszcz'></td>";
                        } else {
                            echo "<td><img src='chmury.png' alt='Chmury'></td>";
                        }

                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>

            <div id="prawy">
                <h2>Średnie temperatury w roku</h2>
                <a href="index.php?month=1">Styczeń</a>
                <a href="index.php?month=2">Luty</a>
                <a href="index.php?month=3">Marzec</a>
                <a href="index.php?month=4">Kwiecień</a>
                <a href="index.php?month=5">Maj</a>
                <a href="index.php?month=6">Czerwiec</a>
                <a href="index.php?month=7">Lipiec</a>
                <a href="index.php?month=8">Sierpień</a>
                <a href="index.php?month=9">Wrzesień</a>
                <a href="index.php?month=10">Październik</a>
                <a href="index.php?month=11">Listopad</a>
                <a href="index.php?month=12">Grudzień</a>
                <p>Średnia temperatura dla wybranego miesiąca wynosi</p>
                <?php
                // Moduł 02: [SEC-1] Skrypt 2 tylko gdy isset($_GET["month"])
                if (isset($_GET["month"])) {
                    $month = $_GET["month"];

                    // Moduł 02: [SEC-2] ROUND(AVG(temperatura), 2) AS srednia, filtr GET
                    $query = "SELECT ROUND(AVG(temperatura), 2) AS srednia
                              FROM pomiary
                              WHERE id_miesiac = $month;";
                    $result = $conn->query($query);

                    // Moduł 02: [SEC-3] Jedno fetch_assoc() — wynik agregacji
                    $row = $result->fetch_assoc();

                    // Moduł 02: [SEC-4] Wyświetlenie: „<wartość> stopni”
                    echo "<p>" . $row["srednia"] . " stopni</p>";
                }
                ?>
            </div>
        </main>

        <footer>
            <p>Numer zdającego: 00000000000</p>
        </footer>
    </body>
</html>
<?php
// Moduł 01: [SEC-1] Zamknięcie połączenia na końcu skryptu
$conn->close();
?>
