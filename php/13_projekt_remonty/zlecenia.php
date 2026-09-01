<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie obiektowe z bazą remonty
$host = "localhost";
$user = "root";
$pass = "";
$db   = "remonty";

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
        <title>Remonty</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <main>
            <nav>
                <a href="kontakt.html">Kontakt</a>
                <a href="https://remonty.pl" target="_blank">Partnerzy</a>
            </nav>

            <aside>
                <img src="tapeta_lewa.png" alt="usługi">
                <img src="tapeta_prawa.png" alt="usługi">
                <img src="tapeta_lewa.png" alt="usługi">
            </aside>

            <section id="lewo">
                <h2>Dla klientów</h2>
                <form action="zlecenia.php" method="post">
                    <label for="pracownikow">Ilu co najmniej pracowników potrzebujesz?</label><br>
                    <input type="number" name="pracownikow" id="pracownikow">
                    <button type="submit">Szukaj firm</button>
                </form>
                <?php
                // Moduł 01: [SEC-3] WHERE liczba_pracownikow >= ?
                $query = "SELECT nazwa_firmy, liczba_pracownikow FROM wykonawcy WHERE liczba_pracownikow >= ?";

                // Moduł 01: [SEC-2] Tylko POST z wypełnionym polem pracownikow
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pracownikow"]) && $_POST["pracownikow"] !== "") {
                    // Moduł 01: [SEC-4] prepare, bind_param("i"), execute, get_result
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $_POST["pracownikow"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Moduł 01: [SEC-5] <li>firma, N pracowników</li>
                    echo "<ul>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>" . $row["nazwa_firmy"] . ", " . $row["liczba_pracownikow"] . " pracowników</li>";
                    }
                    echo "</ul>";
                    $stmt->close();
                }
                ?>
            </section>

            <section id="srodek">
                <h2>Dla wykonawców</h2>
                <form action="zlecenia.php" method="post">
                    <select name="miasto" id="miasto">
                        <?php
                        // Moduł 02: [SEC-1] DISTINCT miasto ORDER BY miasto
                        $queryMiasta = "SELECT DISTINCT miasto FROM klienci ORDER BY miasto;";
                        $resultMiasta = $conn->query($queryMiasta);

                        // Moduł 02: [SEC-2] <option value="miasto">
                        while ($row = $resultMiasta->fetch_assoc()) {
                            echo "<option value='" . $row["miasto"] . "'>" . $row["miasto"] . "</option>";
                        }
                        ?>
                    </select><br>
                    <input type="radio" name="usluga" id="usluga-malowanie" value="malowanie" checked>
                    <label for="usluga-malowanie">malowanie</label><br>
                    <input type="radio" name="usluga" id="usluga-gipsowanie" value="gipsowanie">
                    <label for="usluga-gipsowanie">gipsowanie</label><br>
                    <button type="submit">Szukaj klientów</button>
                </form>
                <?php
                // Moduł 03: [SEC-2] JOIN klienci + zlecenia, miasto = ? AND rodzaj = ?
                $queryZlecenia = "SELECT imie, cena
                                  FROM klienci
                                  JOIN zlecenia USING (id_klienta)
                                  WHERE miasto = ? AND rodzaj = ?";

                // Moduł 03: [SEC-1] Tylko drugi formularz (miasto i usluga)
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["miasto"], $_POST["usluga"])) {
                    // Moduł 03: [SEC-3] bind_param("ss")
                    $stmt = $conn->prepare($queryZlecenia);
                    $stmt->bind_param("ss", $_POST["miasto"], $_POST["usluga"]);
                    $stmt->execute();
                    $resultZlecenia = $stmt->get_result();

                    // Moduł 03: [SEC-4] <li>imie - cena</li>
                    echo "<ul>";
                    while ($row = $resultZlecenia->fetch_assoc()) {
                        echo "<li>" . $row["imie"] . " - " . $row["cena"] . "</li>";
                    }
                    echo "</ul>";
                    $stmt->close();
                }
                ?>
            </section>
        </main>

        <footer>
            <p><strong>Stronę wykonał: 00000000000</strong></p>
        </footer>
    </body>
</html>
<?php
$conn->close();
?>
