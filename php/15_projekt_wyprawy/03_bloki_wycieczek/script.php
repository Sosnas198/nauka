<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — bloki .wycieczka (obraz, h2, cena)
// -----------------------------------------------------------------------------

// --- KROK 1: Wszystkie miejsca ---
// [ZOBACZ W README: SEC-1]
$query = $conn->query("SELECT nazwa, cena, link_obraz FROM miejsca");

// --- KROK 2: div.wycieczka ---
// [ZOBACZ W README: SEC-2]
while ($row = $query->fetch_assoc()) {
    echo "<div class='wycieczka'>";
    echo "<img src='" . $row["link_obraz"] . "' alt='zdjęcie z wycieczki'>";
    echo "<h2>" . $row["nazwa"] . "</h2>";
    echo "<p>" . $row["cena"] . " zł</p>";
    echo "</div>";
}
