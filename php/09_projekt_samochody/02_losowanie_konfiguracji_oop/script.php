<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — RAND() LIMIT 2, wiersze 3–4 i 6–7
// -----------------------------------------------------------------------------

// --- KROK 1: Dwa losowe pojazdy ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT marka, model, cena FROM pojazdy ORDER BY RAND() LIMIT 2;";
$result = $conn->query($query);

// --- KROK 2: Licznik plików a1.jpg, a2.jpg ---
// [ZOBACZ W README: SEC-3]
$nr = 1;

while ($row = $result->fetch_assoc()) {
    $marka = $row["marka"];
    $model = $row["model"];
    $cena = $row["cena"];

    echo "<tr>";
    echo "<td colspan='3'><img src='a" . $nr . ".jpg' alt='Konfiguracja " . $nr . "'></td>";
    echo "</tr>";

    // --- KROK 3: Marka (wiersz 3 albo 6) i Model (wiersz 4 albo 7) ---
    // [ZOBACZ W README: SEC-2 oraz SEC-4]
    echo "<tr>";
    echo "<td>Marka</td>";
    echo "<td>" . $marka . "</td>";
    echo "<td rowspan='2'>" . $cena . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Model</td>";
    echo "<td>" . $model . "</td>";
    echo "</tr>";

    $nr++;
}
