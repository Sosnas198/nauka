<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 03 + Moduł 04)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1, SEC-2] Tworzenie połączenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kino";

$conn = new mysqli($host, $user, $pass, $db);

// Moduł 01: [SEC-3] Obsługa błędu połączenia
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Profil Aktora - Baza Kinowa</title>
</head>

<body>

    <p><a href="index.php">← Powrót do listy wszystkich aktorów</a></p>
    <hr>

    <?php
    // Moduł 03: [SEC-1, SEC-3] Walidacja parametru GET za pomocą isset()
    if (isset($_GET['id'])) {

        // Moduł 03: [SEC-3] Przypisanie parametru z tablicy $_GET
        $id = $_GET['id'];

        // Moduł 03: [SEC-4] Zapytanie przefiltrowane po ID
        $queryAktor = "SELECT imie, nazwisko, plik_awatara FROM aktorzy WHERE id_aktora = $id;";
        $resultAktor = $conn->query($queryAktor);

        // Moduł 03: [SEC-7] Sprawdzenie czy rekord istnieje (num_rows > 0)
        if ($resultAktor->num_rows > 0) {

            // Moduł 03: [SEC-5, SEC-6] Pojedyncze fetch_assoc() bez pętli while
            $rowAktor = $resultAktor->fetch_assoc();
            $imie     = $rowAktor['imie'];
            $nazwisko = $rowAktor['nazwisko'];
            $avatar   = $rowAktor['plik_awatara'];

            echo "<div class='profil'>";
            echo "<img src='" . $avatar . "' alt='" . $imie . " " . $nazwisko . "' width='150'>";
            echo "<h1>" . $imie . " " . $nazwisko . "</h1>";
            echo "</div>";

            echo "<hr>";

            // Moduł 04: [SEC-1, SEC-2] Zapytanie JOIN z tabelą łączącą (bez skrótów)
            $queryFilmy = "SELECT filmy.id_filmu 
                           FROM filmy 
                           JOIN filmy_aktorzy ON filmy.id_filmu = filmy_aktorzy.id_filmu 
                           WHERE filmy_aktorzy.id_aktora = $id;";

            $resultFilmy = $conn->query($queryFilmy);

            // Moduł 04: [SEC-4, SEC-5] Etap 1: Podliczenie liczby wyników za pomocą num_rows
            if ($resultFilmy->num_rows > 0) {
                echo "<h3>Wystąpił w " . $resultFilmy->num_rows . " produkcjach:</h3>";
                echo "<ul>";

                // Moduł 04: [SEC-5] Etap 2: Pętla while do wyciągnięcia konkretnych wierszy
                while ($rowFilm = $resultFilmy->fetch_assoc()) {
                    $id_filmu = $rowFilm['id_filmu'];
                    echo "<li>ID filmu w bazie: " . $id_filmu . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Ten aktor nie ma przypisanych filmów w bazie.</p>";
            }
        } else {
            echo "<p>Błąd: Nie odnaleziono w bazie aktora o podanym ID.</p>";
        }
    } else {
        echo "<p>Błąd: Brak parametru ID w adresie strony.</p>";
    }
    ?>

</body>

</html>
<?php
// Moduł 01: [SEC-5] Zamknięcie połączenia
$conn->close();
?>