<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — pełna lista zwierząt z nazwą gromady
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 2 — wszystkie zwierzęta z nazwą gromady ---
// [ZOBACZ W README: SEC-1]
$sql = "SELECT zwierzeta.id, zwierzeta.gatunek, gromady.nazwa FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id;";
$result = $conn->query(query: $sql);

// --- KROK 2: Wypisanie rekordów w formacie "id. gatunek nazwa_gromady" ---
// [ZOBACZ W README: SEC-2]
while($row = $result -> fetch_array()) {
    echo $row[0].". ".$row[1]." ".$row[2]."<br>";
}
