<?php
// POŁĄCZONY WZORZEC (Moduł 03 na początku, potem Moduł 01 + Moduł 02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Połączenie proceduralne z bazą zgloszenia
$conn = mysqli_connect("localhost", "root", "", "zgloszenia");

// Moduł 03: [SEC-1] INSERT przed zapytaniami SELECT
// Moduł 03: [SEC-2] isset przycisku dodaj_zgloszenie oraz pola osoba_id
if (isset($_POST["dodaj_zgloszenie"]) && isset($_POST["osoba_id"])) {
    // Moduł 03: [SEC-3] Id z input type="number"
    $idPersonelu = $_POST["osoba_id"];

    // Moduł 03: [SEC-4] INSERT: NULL, CURDATE(), id personelu, 14
    $zapytanieDodaj = "INSERT INTO rejestr VALUES (NULL, CURDATE(), $idPersonelu, 14)";
    mysqli_query($conn, $zapytanieDodaj);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ZGŁOSZENIA</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <header>
            <h1>Zgłoszenia wydarzeń</h1>
        </header>

        <main>
            <div id="lewy">
                <h2>Personel</h2>
                <form action="index.php" method="post">
                    <label>
                        <input type="radio" name="personel" value="Policjant" checked>
                        Policjant
                    </label>
                    <label>
                        <input type="radio" name="personel" value="Ratownik">
                        Ratownik
                    </label>
                    <button type="submit" name="pokaz">Pokaż</button>
                </form>
                <?php
                // Moduł 01: [SEC-3] Domyślnie Policjant, potem wartość z radio POST
                $wybranaOpcja = "Policjant";
                if (isset($_POST["personel"])) {
                    $wybranaOpcja = $_POST["personel"];
                }

                // Moduł 01: [SEC-4] Status w bazie małymi literami
                $statusPersonelu = strtolower($wybranaOpcja);

                // Moduł 01: [SEC-3] Nagłówek h3 przed tabelą
                echo "<h3>Wybrano opcję: " . $wybranaOpcja . "</h3>";

                $zapytaniePersonel = "SELECT id, imie, nazwisko FROM personel WHERE status = '$statusPersonelu'";
                $wynikPersonel = mysqli_query($conn, $zapytaniePersonel);
                ?>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                    </tr>
                    <?php
                    // Moduł 01: [SEC-5] Wiersze tabeli z mysqli_fetch_assoc
                    while ($wiersz = mysqli_fetch_assoc($wynikPersonel)) {
                        echo "<tr>";
                        echo "<td>" . $wiersz["id"] . "</td>";
                        echo "<td>" . $wiersz["imie"] . "</td>";
                        echo "<td>" . $wiersz["nazwisko"] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>

            <div id="prawy">
                <h2>Nowe zgłoszenie</h2>
                <?php
                // Moduł 02: [SEC-2] LEFT JOIN — osoby bez wiersza w rejestr
                $zapytanieBrakZgloszenia = "SELECT personel.id, personel.nazwisko
                                            FROM personel
                                            LEFT JOIN rejestr ON personel.id = rejestr.id_personel
                                            WHERE id_personel IS NULL";
                $wynikBrakZgloszenia = mysqli_query($conn, $zapytanieBrakZgloszenia);

                // Moduł 02: [SEC-3] Lista numerowana id + nazwisko
                echo "<ol>";
                while ($wiersz = mysqli_fetch_assoc($wynikBrakZgloszenia)) {
                    echo "<li>" . $wiersz["id"] . " " . $wiersz["nazwisko"] . "</li>";
                }
                echo "</ol>";
                ?>
                <form action="index.php" method="post">
                    <label for="osoba_id">Wybierz id osoby z listy: </label>
                    <input type="number" id="osoba_id" name="osoba_id" min="1" required>
                    <button type="submit" name="dodaj_zgloszenie">Dodaj zgłoszenie</button>
                </form>
            </div>
        </main>

        <footer>
            <p>Stronę wykonał: 00000000000</p>
        </footer>
        <?php
        // Moduł 01: [SEC-1] Zamknięcie połączenia funkcją mysqli_close
        mysqli_close($conn);
        ?>
    </body>
</html>
