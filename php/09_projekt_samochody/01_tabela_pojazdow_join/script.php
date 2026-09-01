<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — INNER JOIN alfa, cena całkowita w 4. kolumnie
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie JOIN, tylko model alfa ---
// [ZOBACZ W README: SEC-2]
$query = "SELECT marka, model, cena, nazwa, doplata
          FROM pojazdy
          INNER JOIN kolory ON kolor = kolory.id
          WHERE model = 'alfa';";
$result = $conn->query($query);

// --- KROK 2: Każdy rekord jako wiersz tabeli ---
// [ZOBACZ W README: SEC-3 oraz SEC-4]
while ($row = $result->fetch_assoc()) {
    $cena_calkowita = $row["cena"] + $row["doplata"];
    echo "<tr>";
    echo "<td>" . $row["marka"] . "</td>";
    echo "<td>" . $row["model"] . "</td>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $cena_calkowita . "</td>";
    echo "</tr>";
}
