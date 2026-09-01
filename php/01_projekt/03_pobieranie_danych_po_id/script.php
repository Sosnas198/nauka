<?php
// UNIWERSALNY WZORZEC: Pobieranie jednego elementu na podstawie ID z adresu URL
// -----------------------------------------------------------------------------

// --- KROK 1: Sprawdzenie obecności parametru w URL ---
// [ZOBACZ W README: SEC-1, SEC-2 oraz SEC-3]
if (isset($_GET['id'])) {

    // --- KROK 2: Przypisanie wartości z tablicy $_GET ---
    // [ZOBACZ W README: SEC-3]
    $id = $_GET['id'];

    // --- KROK 3: Przygotowanie i wysłanie zapytania SQL ---
    // [ZOBACZ W README: SEC-4]
    $query = "SELECT imie, nazwisko, plik_awatara FROM aktorzy WHERE id_aktora = $id;";
    $result = $conn->query($query);

    // --- KROK 4: Sprawdzenie czy baza cokolwiek znalazła ---
    // [ZOBACZ W README: SEC-7]
    if ($result->num_rows > 0) {

        // --- KROK 5: Wyciągnięcie pojedynczego wiersza danych ---
        // [ZOBACZ W README: SEC-5 oraz SEC-6]
        $row = $result->fetch_assoc();

        // --- KROK 6: Odczytanie wartości z tablicy asocjacyjnej ---
        // [ZOBACZ W README: SEC-5]
        $imie     = $row['imie'];
        $nazwisko = $row['nazwisko'];
        $avatar   = $row['plik_awatara'];

        // --- KROK 7: Wyświetlenie danych w kodzie HTML ---
        echo "<div class='profil-aktora'>";
        echo "<img src='" . $avatar . "' alt='" . $imie . " " . $nazwisko . "'>";
        echo "<h1>" . $imie . " " . $nazwisko . "</h1>";
        echo "</div>";
    } else {
        // [ZOBACZ W README: SEC-7]
        echo "<p>Błąd: Nie odnaleziono w bazie aktora o podanym ID.</p>";
    }
} else {
    // [ZOBACZ W README: SEC-3]
    echo "<p>Błąd: Brak podanego parametru ID w adresie strony.</p>";
}
