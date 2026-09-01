<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — opcje <select> (value = id, treść = nazwa)
// -----------------------------------------------------------------------------

// --- KROK 1: Wszystkie towary ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT id, nazwa FROM towar;";
$result = mysqli_query($conn, $query);

// --- KROK 2: Każdy rekord jako option ---
// [ZOBACZ W README: SEC-3]
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
}
