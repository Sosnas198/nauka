<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie obiektowe z bazą szkolenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "szkolenia";

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
        <title>Szkolenia</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <main>
            <section id="lewo">
                <table>
                    <tr>
                        <th>Kurs</th>
                        <th>Nazwa</th>
                        <th>Cena</th>
                    </tr>
                    <?php
                    // Moduł 01: [SEC-2] SELECT kod, nazwa, cena ORDER BY cena
                    $query = "SELECT kod, nazwa, cena FROM kursy ORDER BY cena;";
                    $result = $conn->query($query);

                    // Moduł 01: [SEC-3] Obraz kod.jpg, nazwa, cena
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><img src='" . $row["kod"] . ".jpg' alt='kurs'></td>";
                        echo "<td>" . $row["nazwa"] . "</td>";
                        echo "<td>" . $row["cena"] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </section>

            <section id="prawo">
                <h2>Zapisy na kursy</h2>
                <form action="index.php" method="post">
                    <label for="imie">Imię</label><br>
                    <input type="text" name="imie" id="imie"><br>
                    <label for="nazwisko">Nazwisko</label><br>
                    <input type="text" name="nazwisko" id="nazwisko"><br>
                    <label for="wiek">Wiek</label><br>
                    <input type="number" name="wiek" id="wiek"><br>
                    <label for="kurs">Rodzaj kursu</label><br>
                    <select name="kurs" id="kurs">
                        <?php
                        // Moduł 02: [SEC-1] SELECT nazwa FROM kursy
                        $query = "SELECT nazwa FROM kursy;";
                        $result = $conn->query($query);

                        // Moduł 02: [SEC-3] <option value="nazwa">nazwa</option>
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["nazwa"] . "'>" . $row["nazwa"] . "</option>";
                        }
                        ?>
                    </select><br>
                    <button type="submit">Dodaj dane</button>
                </form>
                <?php
                // Moduł 03: [SEC-1] Obsługa tylko przy metodzie POST
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Moduł 03: [SEC-2] Walidacja empty() — komunikat o braku danych
                    if (empty($_POST["imie"]) || empty($_POST["nazwisko"]) || empty($_POST["wiek"]) || empty($_POST["kurs"])) {
                        echo "<p>Wprowadź wszystkie dane</p>";
                    } else {
                        $imie = $_POST["imie"];
                        $nazwisko = $_POST["nazwisko"];
                        $wiek = $_POST["wiek"];

                        // Moduł 03: [SEC-3] INSERT INTO uczestnicy
                        $query = "INSERT INTO uczestnicy (imie, nazwisko, wiek) VALUES ('$imie', '$nazwisko', $wiek);";
                        $conn->query($query);

                        // Moduł 03: [SEC-4] Komunikat o dodaniu
                        echo "<p>Dane uczestnika " . $imie . " " . $nazwisko . " zostały dodane</p>";
                    }
                }
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
