<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Parametry dostępowe (baza choroby) i obiekt połączenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "choroby";

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
        <link rel="stylesheet" href="styl.css">
        <title>Wykaz chorób</title>
    </head>
    <body>
        <header>
            <h1>Informacja o chorobach w Polsce</h1>
        </header>

        <nav>
            <a href="https://szpitale.pl/" target="_blank">Szpitale</a>
            <a href="https://www.przychodnie.pl/" target="_blank">Przychodnie</a>
            <a href="https://www.nfz.gov.pl/" target="_blank">NFZ</a>
        </nav>

        <main>
            <div id="lewy">
                <h2>Choroby zakaźne</h2>
                <ol>
                    <?php
                    // Moduł 01: [SEC-2] Zapytanie — zakazna = 'T', ORDER BY nazwa ASC
                    $query = "SELECT nazwa FROM choroby WHERE zakazna = 'T' ORDER BY nazwa ASC;";
                    $result = $conn->query($query);

                    // Moduł 01: [SEC-3, SEC-4] Każda nazwa jako <li> wewnątrz <ol>
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>" . $row["nazwa"] . "</li>";
                    }
                    ?>
                </ol>
            </div>

            <div id="prawy">
                <h2>Objawy chorób</h2>
                <form action="zdrowie.php" method="post">
                    <select name="choroba" id="choroba">
                        <?php
                        // Moduł 02: [SEC-1] SELECT id, nazwa — wszystkie choroby
                        $query = "SELECT id, nazwa FROM choroby;";
                        $result = $conn->query($query);

                        // Moduł 02: [SEC-3, SEC-4] <option value="id">nazwa</option>
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" name="sprawdz" id="sprawdz">Sprawdź</button>
                </form>
                <div id="wynik">
                    <?php
                    // Moduł 03: [SEC-1] Skrypt 3 tylko gdy isset($_POST["sprawdz"])
                    if (isset($_POST["sprawdz"])) {
                        $choroba_id = $_POST["choroba"];

                        // Moduł 03: [SEC-2, SEC-3] JOIN objawy + choroby_objawy, ID z POST
                        $query = "SELECT o.nazwa
                                  FROM objawy o
                                  JOIN choroby_objawy co ON o.id = co.id_objawy
                                  WHERE co.id_choroby = '$choroba_id';";
                        $result = $conn->query($query);

                        // Moduł 03: [SEC-4] <span>nazwa</span> ze spacją po znaczniku
                        while ($row = $result->fetch_assoc()) {
                            echo "<span>" . $row["nazwa"] . "</span> ";
                        }
                    }
                    ?>
                </div>
            </div>
        </main>

        <footer>
            <p>Stronę opracował: 00000000000</p>
        </footer>

        <img src="zdrowia.png" alt="Życzymy zdrowia!">
    </body>
</html>
<?php
// Moduł 01: [SEC-1] Zamknięcie połączenia na końcu skryptu
$conn->close();
?>
