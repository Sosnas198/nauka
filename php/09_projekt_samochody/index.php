<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie obiektowe z bazą samochody
$host = "localhost";
$user = "root";
$pass = "";
$db   = "samochody";

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
        <title>Samochody</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <nav>
            <h2>Samochody</h2>
            <h2>Konfigurator</h2>
            <h2>Kontakt</h2>
        </nav>

        <main>
            <section id="lewa">
                <table>
                    <?php
                    // Moduł 01: [SEC-2] INNER JOIN pojazdy + kolory, model alfa
                    $query = "SELECT marka, model, cena, nazwa, doplata
                              FROM pojazdy
                              INNER JOIN kolory ON kolor = kolory.id
                              WHERE model = 'alfa';";
                    $result = $conn->query($query);

                    // Moduł 01: [SEC-3, SEC-4] Cena całkowita = cena + doplata, kolejne <tr>
                    while ($row = $result->fetch_assoc()) {
                        $cena_calkowita = $row["cena"] + $row["doplata"];
                        echo "<tr>";
                        echo "<td>" . $row["marka"] . "</td>";
                        echo "<td>" . $row["model"] . "</td>";
                        echo "<td>" . $row["nazwa"] . "</td>";
                        echo "<td>" . $cena_calkowita . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </section>

            <section id="srodkowa">
                <table>
                    <tr>
                        <th colspan="2">Konfiguracja</th>
                        <th>Cena</th>
                    </tr>
                    <?php
                    // Moduł 02: [SEC-1] ORDER BY RAND() LIMIT 2
                    $query = "SELECT marka, model, cena FROM pojazdy ORDER BY RAND() LIMIT 2;";
                    $result = $conn->query($query);
                    $nr = 1;

                    while ($row = $result->fetch_assoc()) {
                        $marka = $row["marka"];
                        $model = $row["model"];
                        $cena = $row["cena"];

                        // Moduł 02: [SEC-3] Obraz a1.jpg / a2.jpg (wiersze 2 i 5)
                        echo "<tr>";
                        echo "<td colspan='3'><img src='a" . $nr . ".jpg' alt='Konfiguracja " . $nr . "'></td>";
                        echo "</tr>";

                        // Moduł 02: [SEC-2, SEC-4] 1. rekord: wiersze 3–4; 2. rekord: wiersze 6–7
                        echo "<tr>";
                        echo "<td>Marka</td>";
                        echo "<td>" . $marka . "</td>";
                        echo "<td rowspan='2'>" . $cena . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td>Model</td>";
                        echo "<td>" . $model . "</td>";
                        echo "</tr>";

                        $nr++;
                    }
                    ?>
                </table>
            </section>

            <section id="prawa">
                <h3>111 222 444</h3>
                <img src="a3.png" alt="Samochód">
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
