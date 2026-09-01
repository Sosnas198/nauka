<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — pakiety: h3 (nazwa + cena) i p (opis)
// -----------------------------------------------------------------------------

// --- KROK 1: Wszystkie abonamenty ---
// [ZOBACZ W README: SEC-2]
$query = "SELECT nazwa, cena, opis FROM abonamenty;";
$result = $conn->query($query);

// --- KROK 2: Nagłówek 3. stopnia i paragraf opisu ---
// [ZOBACZ W README: SEC-3]
while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row["nazwa"] . " - " . $row["cena"] . " zł</h3>";
    echo "<p>" . $row["opis"] . "</p>";
}
