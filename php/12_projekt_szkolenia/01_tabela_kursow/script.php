<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — wiersze tabeli kursów (obraz kod.jpg, nazwa, cena)
// -----------------------------------------------------------------------------

// --- KROK 1: Kursy posortowane po cenie ---
// [ZOBACZ W README: SEC-2]
$query = "SELECT kod, nazwa, cena FROM kursy ORDER BY cena;";
$result = $conn->query($query);

// --- KROK 2: Obraz z kodu, nazwa, cena ---
// [ZOBACZ W README: SEC-3]
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td><img src='" . $row["kod"] . ".jpg' alt='kurs'></td>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $row["cena"] . "</td>";
    echo "</tr>";
}
