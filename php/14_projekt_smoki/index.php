<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02) — strona smoków
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie obiektowe z bazą smoki
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smoki";

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
        <title>Smoki</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <nav>
            <!-- Moduł 03: [SEC-1] onclick — funkcje z main.js -->
            <section id="nav-baza" onclick="funkcjabaza()">Baza</section>
            <section id="nav-opisy" onclick="funkcjaopisy()">Opisy</section>
            <section id="nav-galeria" onclick="funkcjagaleria()">Galeria</section>
        </nav>

        <main>
            <section id="baza">
                <h3>Baza Smoków</h3>
                <form action="index.php" method="post">
                    <select name="baza" id="baza-select">
                        <?php
                        // Moduł 01: [SEC-2] DISTINCT pochodzenie ORDER BY pochodzenie
                        $sql = "SELECT DISTINCT pochodzenie FROM smok ORDER BY pochodzenie;";
                        $result = $conn->query($sql);

                        // Moduł 01: [SEC-3] <option> — name="baza" idzie do POST
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["pochodzenie"] . "'>" . $row["pochodzenie"] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Szukaj</button>
                </form>
                <table>
                    <tr>
                        <th>Nazwa</th>
                        <th>Długość</th>
                        <th>Szerokość</th>
                    </tr>
                    <?php
                    // Moduł 02: [SEC-1] Filtr tylko po POST name="baza"
                    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["baza"])) {
                        $pochodzenie = $_POST["baza"];

                        // Moduł 02: [SEC-2, SEC-3] prepare WHERE pochodzenie = ?
                        $stmt = $conn->prepare("SELECT nazwa, dlugosc, szerokosc FROM smok WHERE pochodzenie = ?");
                        $stmt->bind_param("s", $pochodzenie);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Moduł 02: [SEC-4] Wiersze: nazwa, dlugosc, szerokosc
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["nazwa"] . "</td>";
                            echo "<td>" . $row["dlugosc"] . "</td>";
                            echo "<td>" . $row["szerokosc"] . "</td>";
                            echo "</tr>";
                        }

                        $stmt->close();
                    }
                    ?>
                </table>
            </section>

            <section id="opisy">
                <h3>Opisy smoków</h3>
                <dl>
                    <dt>Smok czerwony</dt>
                    <dd>Pochodzi z Chin. Ma 1000 lat. Żywi się mniejszymi zwierzętami. Posiada łuski cenne na rynkach wschodnich do wyrabiania lekarstw. Jest dziki i groźny.</dd>

                    <dt>Smok zielony</dt>
                    <dd>Pochodzi z Bułgarii. Ma 10000 lat. Żywi się mniejszymi zwierzętami, ale tylko w kolorze zielonym. Jest kosmaty. Z sierści zgubionej przez niego, tka się najdroższe materiały.</dd>

                    <dt>Smok niebieski</dt>
                    <dd>Pochodzi z Francji. Ma 100 lat. Żywi się owocami morza. Jest natchnieniem dla najlepszych malarzy. Często im pozuje. Smok ten jest przyjacielem ludzi i czasami im pomaga. Jest jednak próżny i nie lubi się przepracowywać.</dd>
                </dl>
            </section>

            <section id="galeria">
                <h3>Galeria</h3>
                <img src="smok1.JPG" alt="Smok czerwony">
                <img src="smok2.JPG" alt="Smok wielki">
                <img src="smok3.JPG" alt="Skrzydlaty łaciaty">
            </section>
        </main>

        <footer>
            <p>Stronę opracował: 00000000000</p>
        </footer>
        <script src="main.js"></script>
    </body>
</html>
<?php
$conn->close();
?>
