<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — lista szczytów w <span> z linkiem GET
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 1 (id, nazwa, sortowanie po wysokości malejąco) ---
// [ZOBACZ W README: SEC-3]
$query = "SELECT id, nazwa FROM szczyty ORDER BY wysokosc DESC;";
$result = $conn->query($query);

// --- KROK 2: Pętla po wszystkich wierszach ---
// [ZOBACZ W README: SEC-4]
while ($row = $result->fetch_assoc()) {

    // --- KROK 3: span + odnośnik szczyty.php?id= (metoda GET) ---
    // [ZOBACZ W README: SEC-5]
    echo "<span><a href='szczyty.php?id=" . $row['id'] . "'>" . $row['nazwa'] . "</a></span> ";
}
