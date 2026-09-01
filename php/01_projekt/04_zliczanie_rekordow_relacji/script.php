<?php
// UNIWERSALNY WZORZEC: Zliczanie i wypisywanie powiązanych rekordów (JOIN + num_rows + fetch_assoc)
// -----------------------------------------------------------------------------

// --- KROK 1: Sprawdzenie obecności parametru w URL ---
if (isset($_GET['id'])) {

    // --- KROK 2: Przypisanie ID z adresu do zmiennej ---
    $id = $_GET['id'];

    // --- KROK 3: Przygotowanie zapytania SQL ze złączeniem JOIN (bez skrótów) ---
    // [ZOBACZ W README: SEC-1 oraz SEC-2]
    $query = "SELECT filmy.id_filmu 
              FROM filmy 
              JOIN filmy_aktorzy ON filmy.id_filmu = filmy_aktorzy.id_filmu 
              WHERE filmy_aktorzy.id_aktora = $id;";

    // --- KROK 4: Wysyłanie zapytania do bazy (powstaje obiekt $result) ---
    // [ZOBACZ W README: SEC-3]
    $result = $conn->query($query);

    // --- KROK 5: Sprawdzenie liczby odnalezionych wierszy za pomocą ->num_rows ---
    // [ZOBACZ W README: SEC-4 oraz SEC-5]
    if ($result->num_rows > 0) {

        // ETAP 1: Wyświetlenie informacji podsumowującej (ile pozycji odnaleziono)
        echo "<p>Znaleziono " . $result->num_rows . " powiązanych pozycji:</p>";

        // --- KROK 6: Pętla pobierająca i wyświetlająca konkretne rekordy ---
        // ETAP 2: Wyciąganie konkretów za pomocą fetch_assoc()
        // [ZOBACZ W README: SEC-5 oraz SEC-6]
        while ($row = $result->fetch_assoc()) {
            $id_filmu = $row['id_filmu'];
            echo "<p>ID filmu: " . $id_filmu . " - <a href='film.php?id=" . $id_filmu . "'>Zobacz szczegóły</a></p>";
        }
    } else {
        // Obsługa przypadku, gdy baza zwróciła 0 wyników
        echo "<p>Brak powiązanych pozycji w bazie.</p>";
    }
} else {
    echo "<p>Błąd: Brak podanego parametru ID w adresie strony.</p>";
}
