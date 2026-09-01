<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — opcje selecta dla jednego gatunku (tu: liryka)
// -----------------------------------------------------------------------------

// --- KROK 1: Książki z gatunku liryka ---
// [ZOBACZ W README: SEC-1]
$result = $mysqli->query('SELECT id, tytul FROM ksiazka WHERE gatunek = "liryka"');

// --- KROK 2: value = id, treść = tytul ---
// [ZOBACZ W README: SEC-2]
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["id"] . "'>" . $row["tytul"] . "</option>";
}

// W bibliotece.php to samo dla "epika" i "dramat" (inne name selecta).
