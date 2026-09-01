<?php
// POŁĄCZONY WZORZEC (Moduł 03 + Moduł 01) — karta wyników maturzysty
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie proceduralne z bazą matura
$conn = mysqli_connect("localhost", "root", "", "matura");

// Moduł 03: [SEC-1] Parametry GET z linku na index.php
$id = isset($_GET["id"]) ? $_GET["id"] : 0;
$imie = isset($_GET["imie"]) ? $_GET["imie"] : "";
$nazwisko = isset($_GET["nazwisko"]) ? $_GET["nazwisko"] : "";
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matura</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <header>
            <h1>System informacji dla maturzystów</h1>
        </header>

        <aside>
            <img src="ma.jpg" alt="Matura"><br>
            <img src="tu.jpg" alt="Matura"><br>
            <img src="ra.jpg" alt="Matura"><br>
        </aside>

        <div id="pierwszy">
            <?php
            // Moduł 03: [SEC-2] <h2> z imienia i nazwiska przesłanych GET
            echo "<h2>" . $imie . " " . $nazwisko . "</h2>";

            // Moduł 03: [SEC-3] JOIN arkusz + wynik ON symbol, filtr maturzysta_id
            $qWyniki = "SELECT arkusz.rok, arkusz.sesja, arkusz.przedmiot, wynik.punkty
                        FROM arkusz
                        JOIN wynik ON arkusz.symbol = wynik.symbol
                        WHERE wynik.maturzysta_id = $id";
            $resWyniki = mysqli_query($conn, $qWyniki);

            // Moduł 03: [SEC-4] <h3> rok i sesja; <p> przedmiot: punkty
            while ($row = mysqli_fetch_assoc($resWyniki)) {
                echo "<h3>" . $row["rok"] . " " . $row["sesja"] . "</h3>";
                echo "<p>" . $row["przedmiot"] . ": " . $row["punkty"] . "</p>";
            }
            ?>
        </div>

        <div id="drugi">
            <?php
            // Moduł 01: [SEC-6] Ten sam Skrypt 1 co na index.php
            echo "<div class='blok'>";
            echo "<h4>Przedmioty</h4>";
            // Moduł 01: [SEC-2]
            $qPrzedmioty = "SELECT DISTINCT przedmiot FROM arkusz";
            $resPrzedmioty = mysqli_query($conn, $qPrzedmioty);
            while ($row = mysqli_fetch_assoc($resPrzedmioty)) {
                echo $row["przedmiot"] . " ";
            }
            echo "</div>";

            echo "<div class='blok'>";
            echo "<h4>Lata</h4>";
            // Moduł 01: [SEC-3]
            $qLata = "SELECT MIN(rok) AS min_rok, MAX(rok) AS max_rok FROM arkusz";
            $resLata = mysqli_query($conn, $qLata);
            $rowLata = mysqli_fetch_assoc($resLata);
            echo $rowLata["min_rok"] . " - " . $rowLata["max_rok"];
            echo "</div>";

            echo "<div class='blok'>";
            echo "<h4>Najlepszy wynik</h4>";
            // Moduł 01: [SEC-4]
            $qMax = "SELECT maturzysta_id, AVG(punkty) AS Wynik FROM wynik GROUP BY maturzysta_id ORDER BY Wynik DESC LIMIT 1";
            $resMax = mysqli_query($conn, $qMax);
            $rowMax = mysqli_fetch_assoc($resMax);
            echo round($rowMax["Wynik"], 2) . "%";
            echo "</div>";

            echo "<div class='blok'>";
            echo "<h4>Najgorszy wynik</h4>";
            // Moduł 01: [SEC-5]
            $qMin = "SELECT maturzysta_id, AVG(punkty) AS Wynik FROM wynik GROUP BY maturzysta_id ORDER BY Wynik ASC LIMIT 1";
            $resMin = mysqli_query($conn, $qMin);
            $rowMin = mysqli_fetch_assoc($resMin);
            echo round($rowMin["Wynik"], 2) . "%";
            echo "</div>";
            ?>
        </div>

        <footer>
            <p>Stronę wykonał: 00000000000</p>
        </footer>
    </body>
</html>
<?php
mysqli_close($conn);
?>
