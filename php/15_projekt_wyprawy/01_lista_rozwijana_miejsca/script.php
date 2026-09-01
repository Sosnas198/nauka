<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — SELECT nazwa FROM miejsca do <select>
// -----------------------------------------------------------------------------

// --- KROK 1: Nazwy alfabetycznie ---
// [ZOBACZ W README: SEC-2]
$query = $conn->query("SELECT nazwa FROM miejsca ORDER BY nazwa");

// --- KROK 2: Opcje (value = nazwa) ---
// [ZOBACZ W README: SEC-3]
while ($row = $query->fetch_assoc()) {
    echo "<option value='" . $row["nazwa"] . "'>" . $row["nazwa"] . "</option>";
}
