<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — opcje <select> (value = id, treść = nazwa)
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie — wszystkie choroby (id + nazwa) ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT id, nazwa FROM choroby;";
$result = $conn->query($query);

// --- KROK 2: Każdy rekord jako option ---
// [ZOBACZ W README: SEC-3 oraz SEC-4]
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
}
