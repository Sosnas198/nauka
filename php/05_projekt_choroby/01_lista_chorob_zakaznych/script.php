<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — lista <li> chorób zakaźnych (WHERE zakazna = 'T')
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie — tylko zakaźne, sortowanie po nazwie ---
// [ZOBACZ W README: SEC-2]
$query = "SELECT nazwa FROM choroby WHERE zakazna = 'T' ORDER BY nazwa ASC;";
$result = $conn->query($query);

// --- KROK 2: Pętla — każda nazwa jako element listy numerowanej ---
// [ZOBACZ W README: SEC-3 oraz SEC-4]
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["nazwa"] . "</li>";
}
