<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — nazwa, trudność słownie, kalorie
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 1 zmodyfikowane o warunek ID ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT nazwa, trudnosc, kalorie FROM potrawy WHERE idPotrawy = $id;";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// --- KROK 2: Nagłówek drugiego stopnia z nazwą ---
// [ZOBACZ W README: SEC-2]
echo "<h2>" . $row["nazwa"] . "</h2>";

// --- KROK 3: Zamiana liczby trudnosc na tekst ---
// [ZOBACZ W README: SEC-3]
if ($row["trudnosc"] == 1) {
    $trudnosc = "łatwe";
} else if ($row["trudnosc"] == 2) {
    $trudnosc = "średnie";
} else if ($row["trudnosc"] == 3) {
    $trudnosc = "trudne";
}

// --- KROK 4: Paragraf według wzoru z arkusza ---
// [ZOBACZ W README: SEC-4]
echo "<p>Trudność: " . $trudnosc . ", Kalorie: " . $row["kalorie"] . "</p>";
