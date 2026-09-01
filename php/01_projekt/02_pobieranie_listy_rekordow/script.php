<?php
// UNIWERSALNY WZORZEC: Wyświetlanie listy wszystkich rekordów w pętli
// -----------------------------------------------------------------------------

// --- KROK 1: Przygotowanie i wykonanie zapytania SQL ---
// [ZOBACZ W README: SEC-1 oraz SEC-2]
$query = "SELECT * FROM aktorzy ORDER BY nazwisko ASC, imie ASC;";

// $result to obiekt-skrzynia. Nie robimy na nim echo!
$result = $conn->query($query);

// --- KROK 2: Uruchomienie pętli przechodzącej po wszystkich rekordach ---
// [ZOBACZ W README: SEC-3]
// fetch_assoc() wyciąga po kolei wiersze i tworzy tablice asocjacyjne po atrybutach z bazy
while ($row = $result->fetch_assoc()) {

    // --- KROK 3: Wyciągnięcie danych z tablicy $row po kluczach-kolumnach ---
    // [ZOBACZ W README: SEC-4]
    $id       = $row['id_aktora'];     // nazwa kolumny w bazie: id_aktora
    $imie     = $row['imie'];          // nazwa kolumny w bazie: imie
    $nazwisko = $row['nazwisko'];      // nazwa kolumny w bazie: nazwisko
    $avatar   = $row['plik_awatara'];  // nazwa kolumny w bazie: plik_awatara

    // --- KROK 4: Wyświetlenie karty z linkiem do UNIWERSALNEGO pliku aktor.php ---
    // [ZOBACZ W README: SEC-5]
    echo "<div class='karta-aktora'>";
    // Tworzymy dynamiczny link, który kieruje do jednego pliku aktor.php z różnym ID
    echo "<a href='aktor.php?id=" . $id . "'>";
    echo "<img src='" . $avatar . "' alt='" . $imie . " " . $nazwisko . "'>";
    echo "<p>" . $imie . " " . $nazwisko . "</p>";
    echo "</a>";
    echo "</div>";
} // Koniec pętli while - gdy wiersze się skończą, fetch_assoc() zwróci false