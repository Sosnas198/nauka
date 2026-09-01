<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie obiektowe z bazą medica
$host = "localhost";
$user = "root";
$pass = "";
$db   = "medica";

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
        <title>Medica</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <article>
            <?php
            // Moduł 01: [SEC-2] SELECT nazwa, cena, opis FROM abonamenty
            $query = "SELECT nazwa, cena, opis FROM abonamenty;";
            $result = $conn->query($query);

            // Moduł 01: [SEC-3] <h3> nazwa i cena; <p> opis
            while ($row = $result->fetch_assoc()) {
                echo "<h3>" . $row["nazwa"] . " - " . $row["cena"] . " zł</h3>";
                echo "<p>" . $row["opis"] . "</p>";
            }
            ?>
            <a href="opis.html">Dowiedz się więcej</a>
        </article>

        <main>
            <section id="pierwszy">
                <h2>Standardowy</h2>
                <ul>
                    <?php
                    // Moduł 02: [SEC-1, SEC-2] JOIN cech, abonamenty.id = 1
                    $query = "SELECT nazwa, cecha
                              FROM abonamenty
                              JOIN szczegolyabonamentu ON abonamenty.id = Abonamenty_id
                              JOIN cechy ON cechy.id = Cechy_id
                              WHERE abonamenty.id = 1;";
                    $result = $conn->query($query);

                    // Moduł 02: [SEC-4] Każda cecha jako <li>
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>" . $row["cecha"] . "</li>";
                    }
                    ?>
                </ul>
            </section>

            <section id="drugi">
                <h2>Premium</h2>
                <ul>
                    <?php
                    // Moduł 02: [SEC-3] To samo zapytanie, id = 2
                    $query = "SELECT nazwa, cecha
                              FROM abonamenty
                              JOIN szczegolyabonamentu ON abonamenty.id = Abonamenty_id
                              JOIN cechy ON cechy.id = Cechy_id
                              WHERE abonamenty.id = 2;";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<li>" . $row["cecha"] . "</li>";
                    }
                    ?>
                </ul>
            </section>

            <section id="trzeci">
                <h2>Dziecko</h2>
                <ul>
                    <?php
                    // Moduł 02: [SEC-3] To samo zapytanie, id = 3
                    $query = "SELECT nazwa, cecha
                              FROM abonamenty
                              JOIN szczegolyabonamentu ON abonamenty.id = Abonamenty_id
                              JOIN cechy ON cechy.id = Cechy_id
                              WHERE abonamenty.id = 3;";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<li>" . $row["cecha"] . "</li>";
                    }
                    ?>
                </ul>
            </section>
        </main>

        <footer>
            <p><img src="obraz2.png" alt="przychodnia">Stronę przygotował: 00000000000</p>
        </footer>
    </body>
</html>
<?php
$conn->close();
?>
