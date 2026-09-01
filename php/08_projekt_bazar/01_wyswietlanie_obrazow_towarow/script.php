<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — 10 obrazów towarów (src = plik, alt = nazwa)
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie LIMIT 10 ---
// [ZOBACZ W README: SEC-2]
$query = "SELECT nazwa, plik FROM towar LIMIT 10;";
$result = mysqli_query($conn, $query);

// --- KROK 2: Każdy wiersz jako <img> ---
// [ZOBACZ W README: SEC-3]
while ($row = mysqli_fetch_array($result)) {
    echo "<img src='" . $row["plik"] . "' alt='" . $row["nazwa"] . "'>";
}
