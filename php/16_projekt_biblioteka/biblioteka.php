<?php
// POŁĄCZONY WZORZEC (Moduły 01–04)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie — baza biblioteka (mysqli_connect → $mysqli)
$mysqli = mysqli_connect("localhost", "root", "", "biblioteka");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Biblioteka miejska</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <header>
            <?php
            // Moduł 01: [SEC-2] Pętla — 20 razy obraz.png
            for ($i = 0; $i < 20; $i++) {
                echo '<img src="obraz.png" alt="grafika">';
            }
            ?>
        </header>

        <section id="pierwszy">
            <h2>Liryka</h2>
            <form action="biblioteka.php" method="post">
                <select name="liryka" id="liryka">
                    <?php
                    // Moduł 02: [SEC-1] WHERE gatunek = "liryka"
                    $result = $mysqli->query('SELECT id, tytul FROM ksiazka WHERE gatunek = "liryka"');
                    // Moduł 02: [SEC-2] value = id, treść = tytul
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["tytul"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Rezerwuj" name="buttonliryka" id="buttonliryka">
            </form>
            <?php
            // Moduł 03: [SEC-1] Tylko ten formularz (buttonliryka)
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buttonliryka"], $_POST["liryka"])) {
                $bookId = $_POST["liryka"];

                // Moduł 03: [SEC-2] SELECT tytul WHERE id = ?
                $stmt = $mysqli->prepare("SELECT tytul FROM ksiazka WHERE id = ?");
                $stmt->bind_param("i", $bookId);
                $stmt->execute();
                $stmt->bind_result($title);
                $stmt->fetch();
                $stmt->close();

                // Moduł 03: [SEC-3] Paragraf tylko w sekcji Liryka
                echo "<p>Książka " . $title . " została zarezerwowana</p>";

                // Moduł 03: [SEC-4] UPDATE rezerwacja = 1
                $update = $mysqli->prepare("UPDATE ksiazka SET rezerwacja = 1 WHERE id = ?");
                $update->bind_param("i", $bookId);
                $update->execute();
                $update->close();
            }
            ?>
        </section>

        <section id="drugi">
            <h2>Epika</h2>
            <form action="biblioteka.php" method="post">
                <select name="epika" id="epika">
                    <?php
                    // Moduł 02: [SEC-3] Gatunek epika
                    $result = $mysqli->query('SELECT id, tytul FROM ksiazka WHERE gatunek = "epika"');
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["tytul"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Rezerwuj" name="buttonepika" id="buttonepika">
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buttonepika"], $_POST["epika"])) {
                $bookId = $_POST["epika"];

                $stmt = $mysqli->prepare("SELECT tytul FROM ksiazka WHERE id = ?");
                $stmt->bind_param("i", $bookId);
                $stmt->execute();
                $stmt->bind_result($title);
                $stmt->fetch();
                $stmt->close();

                echo "<p>Książka " . $title . " została zarezerwowana</p>";

                $update = $mysqli->prepare("UPDATE ksiazka SET rezerwacja = 1 WHERE id = ?");
                $update->bind_param("i", $bookId);
                $update->execute();
                $update->close();
            }
            ?>
        </section>

        <section id="trzeci">
            <h2>Dramat</h2>
            <form action="biblioteka.php" method="post">
                <select name="dramat" id="dramat">
                    <?php
                    $result = $mysqli->query('SELECT id, tytul FROM ksiazka WHERE gatunek = "dramat"');
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["tytul"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Rezerwuj" name="buttondramat" id="buttondramat">
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buttondramat"], $_POST["dramat"])) {
                $bookId = $_POST["dramat"];

                $stmt = $mysqli->prepare("SELECT tytul FROM ksiazka WHERE id = ?");
                $stmt->bind_param("i", $bookId);
                $stmt->execute();
                $stmt->bind_result($title);
                $stmt->fetch();
                $stmt->close();

                echo "<p>Książka " . $title . " została zarezerwowana</p>";

                $update = $mysqli->prepare("UPDATE ksiazka SET rezerwacja = 1 WHERE id = ?");
                $update->bind_param("i", $bookId);
                $update->execute();
                $update->close();
            }
            ?>
        </section>

        <section id="czwarty">
            <h2>Zaległe książki</h2>
            <ul>
                <?php
                // Moduł 04: [SEC-1] JOIN ksiazka + wypozyczenia, ORDER BY data_odd LIMIT 15
                $result = $mysqli->query(
                    "SELECT tytul, id_cz, data_odd FROM ksiazka JOIN wypozyczenia ON id = id_ks ORDER BY data_odd LIMIT 15"
                );
                // Moduł 04: [SEC-2] <li>tytuł id_cz data_odd</li>
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . $row["tytul"] . " " . $row["id_cz"] . " " . $row["data_odd"] . "</li>";
                }
                ?>
            </ul>
        </section>

        <footer>
            <p><strong>Autor: 00000000000</strong></p>
        </footer>
    </body>
</html>
<?php
$mysqli->close();
?>
