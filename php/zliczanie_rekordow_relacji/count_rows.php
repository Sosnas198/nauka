<?php
// UNIWERSALNY WZORZEC: Zliczanie powiązanych rekordów (JOIN + num_rows)

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT f.id_filmu FROM filmy f 
              JOIN filmy_aktorzy fa ON f.id_filmu = fa.id_filmu 
              WHERE fa.id_aktora = $id;";

    $result = $conn->query($query);

    // Sprawdzanie czy znaleziono jakiekolwiek powiązane wpisy
    if ($result->num_rows > 0) {
        echo "Znaleziono " . $result->num_rows . " powiązanych pozycji.";
    } else {
        echo "<p>Brak powiązanych pozycji w bazie.</p>";
    }
}
