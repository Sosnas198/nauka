<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — DISTINCT miasto do <select>
// -----------------------------------------------------------------------------

// --- KROK 1: Unikalne miasta, alfabetycznie ---
// [ZOBACZ W README: SEC-1]
$queryMiasta = "SELECT DISTINCT miasto FROM klienci ORDER BY miasto;";
$resultMiasta = $conn->query($queryMiasta);

// --- KROK 2: Opcje selecta ---
// [ZOBACZ W README: SEC-2]
while ($row = $resultMiasta->fetch_assoc()) {
    echo "<option value='" . $row["miasto"] . "'>" . $row["miasto"] . "</option>";
}
