<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Parametry dostępowe i [SEC-2] Tworzenie obiektu połączenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kino";

$conn = new mysqli($host, $user, $pass, $db);

// Moduł 01: [SEC-3] Sprawdzenie błędów i zatrzymanie skryptu die()
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Lista Aktorów - Baza Kinowa</title>
</head>

<body>

    <h1>Baza Danych Kinowych</h1>
    <h2>Wszyscy aktorzy w bazie</h2>
    <hr>

    <div class="lista-aktorow">
        <?php
        // Moduł 02: [SEC-1] Zapytanie SELECT z ORDER BY i [SEC-2] Wykonanie query()
        $query = "SELECT * FROM aktorzy ORDER BY nazwisko ASC, imie ASC;";
        $result = $conn->query($query);

        // Moduł 02: [SEC-3] Pętla while z fetch_assoc()
        while ($row = $result->fetch_assoc()) {

            // Moduł 02: [SEC-4] Odczytanie wartości po nazwach kolumn
            $id       = $row['id_aktora'];
            $imie     = $row['imie'];
            $nazwisko = $row['nazwisko'];
            $avatar   = $row['plik_awatara'];

            // Moduł 02: [SEC-5] Generowanie uniwersalnego linku aktor.php?id=X
            echo "<div class='karta-aktora' style='margin-bottom: 15px;'>";
            echo "<a href='aktor.php?id=" . $id . "'>";
            echo "<img src='" . $avatar . "' alt='" . $imie . " " . $nazwisko . "' width='60' style='vertical-align: middle; margin-right: 10px;'>";
            echo "<strong>" . $imie . " " . $nazwisko . "</strong>";
            echo "</a>";
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>
<?php
// Moduł 01: [SEC-5] Zamknięcie połączenia z bazą
$conn->close();
?>