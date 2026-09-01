<?php
// POŁĄCZONY WZORZEC (Moduł 02 + Moduł 01) — lista maturzystów T3
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie proceduralne z bazą matura
$conn = mysqli_connect("localhost", "root", "", "matura");
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
            // Moduł 02: [SEC-1] SELECT id, imie, nazwisko — szkola T3, ORDER BY nazwisko
            $qLista = "SELECT id, imie, nazwisko FROM maturzysta WHERE szkola = 'T3' ORDER BY nazwisko ASC";
            $resLista = mysqli_query($conn, $qLista);

            // Moduł 02: [SEC-2, SEC-3] Link wynik.php z id, imie, nazwisko; treść „id. imie nazwisko”
            while ($row = mysqli_fetch_assoc($resLista)) {
                $id = $row["id"];
                $imie = $row["imie"];
                $nazwisko = $row["nazwisko"];

                echo "<a href='wynik.php?id=" . $id . "&imie=" . $imie . "&nazwisko=" . $nazwisko . "'>";
                echo $id . ". " . $imie . " " . $nazwisko;
                echo "</a><br>";
            }
            ?>
        </div>

        <div id="drugi">
            <?php
            echo "<div class='blok'>";
            echo "<h4>Przedmioty</h4>";
            // Moduł 01: [SEC-2] DISTINCT przedmiot, nazwy ze spacją
            $qPrzedmioty = "SELECT DISTINCT przedmiot FROM arkusz";
            $resPrzedmioty = mysqli_query($conn, $qPrzedmioty);
            while ($row = mysqli_fetch_assoc($resPrzedmioty)) {
                echo $row["przedmiot"] . " ";
            }
            echo "</div>";

            echo "<div class='blok'>";
            echo "<h4>Lata</h4>";
            // Moduł 01: [SEC-3] MIN/MAX rok, myślnik
            $qLata = "SELECT MIN(rok) AS min_rok, MAX(rok) AS max_rok FROM arkusz";
            $resLata = mysqli_query($conn, $qLata);
            $rowLata = mysqli_fetch_assoc($resLata);
            echo $rowLata["min_rok"] . " - " . $rowLata["max_rok"];
            echo "</div>";

            echo "<div class='blok'>";
            echo "<h4>Najlepszy wynik</h4>";
            // Moduł 01: [SEC-4] AVG GROUP BY, ORDER BY Wynik DESC LIMIT 1, round + %
            $qMax = "SELECT maturzysta_id, AVG(punkty) AS Wynik FROM wynik GROUP BY maturzysta_id ORDER BY Wynik DESC LIMIT 1";
            $resMax = mysqli_query($conn, $qMax);
            $rowMax = mysqli_fetch_assoc($resMax);
            echo round($rowMax["Wynik"], 2) . "%";
            echo "</div>";

            echo "<div class='blok'>";
            echo "<h4>Najgorszy wynik</h4>";
            // Moduł 01: [SEC-5] To samo zapytanie, ASC LIMIT 1
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
// Moduł 01: [SEC-1] Zamknięcie połączenia
mysqli_close($conn);
?>
