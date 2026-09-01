<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie obiektowe z bazą wyprawy
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wyprawy";

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
        <title>Wyprawy</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <main>
            <aside>
                <h3>Twój cel wyprawy</h3>
                <form action="index.php" method="post">
                    <label for="miejsce">Miejsce wycieczki</label><br>
                    <select name="miejsce" id="miejsce">
                        <?php
                        // Moduł 01: [SEC-2] SELECT nazwa FROM miejsca ORDER BY nazwa
                        $query = $conn->query("SELECT nazwa FROM miejsca ORDER BY nazwa");

                        // Moduł 01: [SEC-3] <option value="nazwa">
                        while ($row = $query->fetch_assoc()) {
                            echo "<option value='" . $row["nazwa"] . "'>" . $row["nazwa"] . "</option>";
                        }
                        ?>
                    </select><br>
                    <label for="dorosli">Ile dorosłych?</label><br>
                    <input type="number" name="dorosli" id="dorosli" min="1"><br>

                    <label for="dzieci">Ile dzieci?</label><br>
                    <input type="number" name="dzieci" id="dzieci" min="0"><br>

                    <label for="termin">Termin</label><br>
                    <input type="date" name="termin" id="termin"><br>
                    <button type="submit" name="symulacja" id="symulacja">Symulacja ceny</button>
                </form>
                <h4>Koszt wycieczki</h4>
                <?php
                // Moduł 02: [SEC-1] POST: miejsce, dorosli, dzieci, termin
                if ($_SERVER["REQUEST_METHOD"] === "POST"
                    && isset($_POST["miejsce"], $_POST["dorosli"], $_POST["dzieci"], $_POST["termin"])) {

                    $miejsce = $_POST["miejsce"];
                    $dorosli = $_POST["dorosli"];
                    $dzieci = $_POST["dzieci"];
                    $termin = $_POST["termin"];

                    // Moduł 02: [SEC-2] Cena wybranego miejsca (prepare)
                    $stmt = $conn->prepare("SELECT cena FROM miejsca WHERE nazwa = ?");
                    $stmt->bind_param("s", $miejsce);
                    $stmt->execute();
                    $stmt->bind_result($cena);

                    if ($stmt->fetch()) {
                        // Moduł 02: [SEC-3] Dzieci: połowa ceny
                        $koszt = ($cena * $dorosli) + ($cena * 0.5 * $dzieci);

                        // Moduł 02: [SEC-4] Termin i kwota w złotych
                        echo "<p>W dniu: " . $termin . "</p>";
                        echo "<p>" . $koszt . " złotych</p>";
                    }

                    $stmt->close();
                }
                ?>
            </aside>

            <section>
                <h3>Wycieczki</h3>
                <?php
                // Moduł 03: [SEC-1] SELECT nazwa, cena, link_obraz
                $query = $conn->query("SELECT nazwa, cena, link_obraz FROM miejsca");

                // Moduł 03: [SEC-2] div.wycieczka: img, h2, cena
                while ($row = $query->fetch_assoc()) {
                    echo "<div class='wycieczka'>";
                    echo "<img src='" . $row["link_obraz"] . "' alt='zdjęcie z wycieczki'>";
                    echo "<h2>" . $row["nazwa"] . "</h2>";
                    echo "<p>" . $row["cena"] . " zł</p>";
                    echo "</div>";
                }
                ?>
            </section>
        </main>

        <footer>
            <p>Autor: 00000000000</p>
        </footer>
    </body>
</html>
<?php
$conn->close();
?>
