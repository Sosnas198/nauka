<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — galeria 10 miniatur (obie strony)
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 2 (nazwa, plik, maksymalnie 10 rekordów) ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT nazwa, plik FROM szczyty LIMIT 10;";
$result = $conn->query($query);

// --- KROK 2: Pętla — jeden obraz na rekord ---
// [ZOBACZ W README: SEC-2 oraz SEC-3]
while ($row = $result->fetch_assoc()) {
    echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='miniatury'>";
}
