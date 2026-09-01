<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — DISTINCT pochodzenie do <select name="baza">
// -----------------------------------------------------------------------------

// --- KROK 1: Unikalne kraje alfabetycznie ---
// [ZOBACZ W README: SEC-2]
$sql = "SELECT DISTINCT pochodzenie FROM smok ORDER BY pochodzenie;";
$result = $conn->query($sql);

// --- KROK 2: Opcje listy ---
// [ZOBACZ W README: SEC-3]
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["pochodzenie"] . "'>" . $row["pochodzenie"] . "</option>";
}
