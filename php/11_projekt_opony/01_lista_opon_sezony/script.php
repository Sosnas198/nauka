<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — 10 najtańszych opon + ikona sezonu
// -----------------------------------------------------------------------------

// --- KROK 1: Sortowanie po cenie, LIMIT 10 ---
// [ZOBACZ W README: SEC-3]
$query = "SELECT nr_kat, producent, model, sezon, cena FROM opony ORDER BY cena LIMIT 10;";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    // --- KROK 2: Dobór pliku graficznego ---
    // [ZOBACZ W README: SEC-4]
    if ($row["sezon"] == "lato") {
        $plikSezonu = "lato.png";
    } else if ($row["sezon"] == "zima") {
        $plikSezonu = "zima.png";
    } else {
        $plikSezonu = "uniwer.png";
    }

    // --- KROK 3: Blok opona, h4 (producent + model), h3 (cena) ---
    // [ZOBACZ W README: SEC-5]
    echo "<div class='opona'>";
    echo "<img src='" . $plikSezonu . "' alt='" . $row["sezon"] . "'>";
    echo "<h4>" . $row["producent"] . " " . $row["model"] . "</h4>";
    echo "<h3>" . $row["cena"] . " zł</h3>";
    echo "</div>";
}
