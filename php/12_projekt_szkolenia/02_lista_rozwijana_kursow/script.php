<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — <option> z nazw kursów
// -----------------------------------------------------------------------------

// --- KROK 1: Same nazwy ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT nazwa FROM kursy;";
$result = $conn->query($query);

// --- KROK 2: value i treść = nazwa ---
// [ZOBACZ W README: SEC-3]
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["nazwa"] . "'>" . $row["nazwa"] . "</option>";
}
