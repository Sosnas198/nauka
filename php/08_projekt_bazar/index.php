<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie proceduralne z bazą bazar
$conn = mysqli_connect("localhost", "root", "", "bazar");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bazar</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <nav>
            <?php
            // Moduł 01: [SEC-2] SELECT nazwa, plik FROM towar LIMIT 10
            $query = "SELECT nazwa, plik FROM towar LIMIT 10;";
            $result = mysqli_query($conn, $query);

            // Moduł 01: [SEC-3] <img src=plik alt=nazwa> — mysqli_fetch_array
            while ($row = mysqli_fetch_array($result)) {
                echo "<img src='" . $row["plik"] . "' alt='" . $row["nazwa"] . "' height='150px'>";
            }
            ?>
        </nav>

        <main>
            <section id="boczny">
                <img src="market.png" alt="bazarek">
            </section>

            <section id="sekcji">
                <p>Wybierz owoc lub warzywo i podaj jego wagę:</p>
                <form action="index.php" method="post">
                    <select name="id" id="id" required>
                        <?php
                        // Moduł 02: [SEC-1] SELECT id, nazwa FROM towar
                        $query = "SELECT id, nazwa FROM towar;";
                        $result = mysqli_query($conn, $query);

                        // Moduł 02: [SEC-3] <option value="id">nazwa</option>
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="number" step="1" min="1" name="waga" id="waga" required>
                    <button type="submit">Zamów</button>
                </form>

                <?php
                // Moduł 03: [SEC-1] Skrypt 3 tylko gdy w POST są id oraz waga
                if (isset($_POST["waga"], $_POST["id"])) {
                    $id = $_POST["id"];
                    $waga = $_POST["waga"];

                    // Moduł 03: [SEC-2] Pobranie nazwy, rodzaju i ceny
                    $query = "SELECT nazwa, rodzaj, cena FROM towar WHERE id = $id;";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_array($result);

                    // Moduł 03: [SEC-3] wartość = cena * waga; komunikat z „zł”
                    $wartosc = $row["cena"] * $waga;
                    echo "<p>" . $row["rodzaj"] . " " . $row["nazwa"] . " " . $wartosc . " zł</p>";

                    // Moduł 03: [SEC-4] INSERT INTO zamowienie (NULL, id towaru, 2, waga)
                    $insertQuery = "INSERT INTO zamowienie VALUES (NULL, $id, 2, $waga);";
                    mysqli_query($conn, $insertQuery);
                }
                ?>
            </section>
        </main>

        <footer>
            <p>Stronę opracował: 00000000000</p>
        </footer>
    </body>
</html>
<?php
mysqli_close($conn);
?>
