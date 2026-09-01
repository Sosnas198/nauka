<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — nagłówek gromady i lista zwierząt tej gromady
// -----------------------------------------------------------------------------

// --- KROK 1: Sprawdzenie, czy formularz został wysłany ---
// [ZOBACZ W README: SEC-1]
if(isset($_POST["gromada"])) {
    $gromada = $_POST["gromada"];

    // --- KROK 2: Wypisanie nazwy gromady w nagłówku h2 ---
    // [ZOBACZ W README: SEC-2]
    if($gromada == 1) {
        echo "<h2>RYBY</h2>";
    }
    else if ($gromada == 2) {
        echo "<h2>PŁAZY</h2>";
    }
    else if ($gromada == 3) {
        echo "<h2>GADY</h2>";
    }
    else if ($gromada == 4) {
        echo "<h2>PTAKI</h2>";
    }
    else if ($gromada == 5) {
        echo "<h2>SSAKI</h2>";
    }

    // --- KROK 3: Zapytanie 1 zmodyfikowane — zwierzęta z wybranej gromady ---
    // [ZOBACZ W README: SEC-3]
    $sql = "SELECT gatunek, wystepowanie FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id AND gromady.id = $gromada;";
    $result = $conn->query(query: $sql);

    // --- KROK 4: Wypisanie wyników w formacie "gatunek, występowanie" ---
    // [ZOBACZ W README: SEC-4]
    while($row = $result -> fetch_array()) {
        echo $row["gatunek"].", ".$row["wystepowanie"]."<br>";
    }
}
