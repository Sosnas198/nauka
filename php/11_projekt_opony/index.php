<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Odświeżanie co 10 s — WYŁĄCZNIE przed HTML
header("Refresh: 10;");

// Moduł 01: [SEC-2] Połączenie obiektowe z bazą opony
$host = "localhost";
$user = "root";
$pass = "";
$db   = "opony";

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
        <title>Opony</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <aside>
            <?php
            // Moduł 01: [SEC-3] 10 najtańszych opon
            $query = "SELECT nr_kat, producent, model, sezon, cena FROM opony ORDER BY cena LIMIT 10;";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                // Moduł 01: [SEC-4] lato.png / zima.png / uniwer.png
                if ($row["sezon"] == "lato") {
                    $plikSezonu = "lato.png";
                } else if ($row["sezon"] == "zima") {
                    $plikSezonu = "zima.png";
                } else {
                    $plikSezonu = "uniwer.png";
                }

                // Moduł 01: [SEC-5] div.opona, h4 i h3
                echo "<div class='opona'>";
                echo "<img src='" . $plikSezonu . "' alt='" . $row["sezon"] . "'>";
                echo "<h4>" . $row["producent"] . " " . $row["model"] . "</h4>";
                echo "<h3>" . $row["cena"] . " zł</h3>";
                echo "</div>";
            }
            ?>
        </aside>

        <main>
            <section id="gora">
                <img src="opona.png" alt="Opona">
                <h2>Opona dnia</h2>
                <?php
                // Moduł 02: [SEC-1] Prezentacja opony dnia (nr_kat = 9)
                $query = "SELECT producent, model, sezon, cena FROM opony WHERE nr_kat = 9;";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();

                // Moduł 02: [SEC-2] Trzy nagłówki h2
                echo "<h2>" . $row["producent"] . " model " . $row["model"] . "</h2>";
                echo "<h2>Sezon: " . $row["sezon"] . "</h2>";
                echo "<h2>Cena: " . $row["cena"] . " PLN</h2>";
                ?>
            </section>

            <section id="dol">
                <h2>Najnowsze zamówienie</h2>
                <?php
                // Moduł 03: [SEC-1] JOIN USING (nr_kat), losowe jedno zamówienie
                $query = "SELECT id_zam, ilosc, model, cena
                          FROM zamowienie
                          JOIN opony USING (nr_kat)
                          ORDER BY RAND()
                          LIMIT 1;";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();

                // Moduł 03: [SEC-2] Wartość = ilosc * cena
                $wartosc_zamowienia = $row["ilosc"] * $row["cena"];

                // Moduł 03: [SEC-3] Podsumowanie w h2
                echo "<h2>Zamówienie nr " . $row["id_zam"] . ": " . $row["ilosc"] . " sztuki modelu " . $row["model"] . "</h2>";
                echo "<h2>Wartość zamówienia: " . $wartosc_zamowienia . " zł</h2>";
                ?>
            </section>
        </main>

        <footer>
            <p>Stronę wykonał: 00000000000</p>
        </footer>
    </body>
</html>
<?php
$conn->close();
?>
