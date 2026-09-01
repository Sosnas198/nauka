<?php
// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02 + Moduł 03 + Moduł 04 + Moduł 05)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Parametry dostępowe i [SEC-2] Tworzenie obiektu połączenia
$host = "localhost";
$user = "root";
$pass = "";
$db   = "przepisy";

$conn = new mysqli($host, $user, $pass, $db);

// Moduł 01: [SEC-3] Sprawdzenie błędów i zatrzymanie skryptu die()
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Moduł 01: [SEC-4] ID z GET albo wartość domyślna 7
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = 7;
}

$plik = "";
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blog kulinarny</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <aside>
            <a href="przepisy.php?id=1">Sernik</a><br>
            <a href="przepisy.php?id=2">Sałatka</a><br>
            <a href="przepisy.php?id=3">Pankejki</a><br>
            <a href="przepisy.php?id=4">Nugetsy</a><br>
            <a href="przepisy.php?id=5">Łosoś</a><br>
            <a href="przepisy.php?id=6">Kociołek</a><br>
            <a href="przepisy.php?id=7">Jagnięcina</a><br>
            <a href="przepisy.php?id=8">Hamburgery</a><br>
            <a href="przepisy.php?id=9">Eklerki</a><br>
            <a href="przepisy.php?id=10">Churros</a><br>
            <p>Autor: 00000000000</p>
        </aside>

        <main>
            <?php
            // Moduł 02: [SEC-2] Zapytanie 2 z JOIN rodzaje i [SEC-3] pojedyncze fetch_assoc()
            $query = "SELECT potrawy.nazwa, rodzaje.rodzaj
                      FROM potrawy
                      JOIN rodzaje ON potrawy.idRodzaje = rodzaje.idRodzaje
                      WHERE potrawy.idPotrawy = $id;";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();

            // Moduł 02: [SEC-4] Wyświetlenie pola rodzaj
            echo "<h1>" . $row["rodzaj"] . "</h1>";

            // Moduł 03: [SEC-1] Zapytanie 1 przefiltrowane po ID
            $query = "SELECT nazwa, trudnosc, kalorie FROM potrawy WHERE idPotrawy = $id;";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();

            // Moduł 03: [SEC-2] Nagłówek drugiego stopnia z nazwą potrawy
            echo "<h2>" . $row["nazwa"] . "</h2>";

            // Moduł 03: [SEC-3] Mapowanie trudnosc: 1=łatwe, 2=średnie, 3=trudne
            if ($row["trudnosc"] == 1) {
                $trudnosc = "łatwe";
            } else if ($row["trudnosc"] == 2) {
                $trudnosc = "średnie";
            } else if ($row["trudnosc"] == 3) {
                $trudnosc = "trudne";
            }

            // Moduł 03: [SEC-4] Paragraf: Trudność: ..., Kalorie: ...
            echo "<p>Trudność: " . $trudnosc . ", Kalorie: " . $row["kalorie"] . "</p>";
            ?>
            <img src="separator.png" alt="przepis">
            <?php
            // Moduł 04: [SEC-2] Zapytanie 3 z podwójnym JOIN (lista_alergenow)
            $query = "SELECT potrawy.nazwa, alergeny.alergen
                      FROM potrawy
                      JOIN lista_alergenow ON potrawy.idPotrawy = lista_alergenow.idPotrawy
                      JOIN alergeny ON lista_alergenow.idAlergeny = alergeny.idAlergeny
                      WHERE potrawy.idPotrawy = $id;";
            $result = $conn->query($query);

            // Moduł 04: [SEC-3, SEC-4] Pętla while — nazwy alergenów oddzielone spacją
            echo "<p>Alergeny: ";
            while ($row = $result->fetch_assoc()) {
                echo $row["alergen"] . " ";
            }
            echo "</p>";
            ?>
            <h2>Składniki</h2>
            <ul>
                <li>Lorem 1 kg</li>
                <li>Ipsum 2 szt.</li>
                <li>Dolor 200 g</li>
                <li>Sit amet (szczypta)</li>
            </ul>
            <?php
            // Moduł 05: [SEC-1] Zapytanie 4 — pola przepis i plik
            $query = "SELECT przepis, plik FROM potrawy WHERE idPotrawy = $id;";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();

            // Moduł 05: [SEC-3] Pole plik do tła sekcji (CSS inline)
            $plik = $row["plik"];

            // Moduł 05: [SEC-2] Wyświetlenie pola przepis
            echo "<p>" . $row["przepis"] . "</p>";
            ?>
        </main>

        <!-- Moduł 05: [SEC-4] Tło sekcji ze stylem inline (background-image) -->
        <section style="background-image: url('<?php echo $plik; ?>');">
            <h1>Blog Kulinarny</h1>
        </section>
    </body>
</html>
<?php
// Moduł 01: [SEC-5] Zamknięcie połączenia z bazą
$conn->close();
?>
