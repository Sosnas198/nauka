<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — wiersze tabeli + ikony według progów temperatury
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie JOIN (lipiec = id_miesiac 7) ---
// [ZOBACZ W README: SEC-2]
$query = "SELECT miejscowosc.nazwa, miejscowosc.kraj, pomiary.temperatura
          FROM miejscowosc
          JOIN pomiary ON miejscowosc.id = pomiary.id_miejscowosc
          WHERE pomiary.id_miesiac = 7;";
$result = $conn->query($query);

// --- KROK 2: Pętla — trzy pierwsze kolumny z bazy ---
// [ZOBACZ W README: SEC-3]
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $row["kraj"] . "</td>";
    echo "<td>" . $row["temperatura"] . "</td>";

    // --- KROK 3: Czwarta kolumna — ikona według progów ---
    // [ZOBACZ W README: SEC-4]
    if ($row["temperatura"] > 30) {
        echo "<td><img src='slonce.png' alt='Słońce'></td>";
    } else if ($row["temperatura"] < 26) {
        echo "<td><img src='deszcz.png' alt='Deszcz'></td>";
    } else {
        echo "<td><img src='chmury.png' alt='Chmury'></td>";
    }

    echo "</tr>";
}
