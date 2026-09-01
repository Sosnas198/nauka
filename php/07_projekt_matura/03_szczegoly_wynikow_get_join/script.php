<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — GET (h2) + JOIN arkusz/wynik po symbol
// -----------------------------------------------------------------------------

// --- KROK 1: Parametry z adresu ---
// [ZOBACZ W README: SEC-1]
$id = $_GET["id"];
$imie = $_GET["imie"];
$nazwisko = $_GET["nazwisko"];

// --- KROK 2: Nagłówek z imienia i nazwiska (GET, nie SQL) ---
// [ZOBACZ W README: SEC-2]
echo "<h2>" . $imie . " " . $nazwisko . "</h2>";

// --- KROK 3: JOIN po symbol, filtr maturzysta_id ---
// [ZOBACZ W README: SEC-3]
$q = "SELECT arkusz.rok, arkusz.sesja, arkusz.przedmiot, wynik.punkty
      FROM arkusz
      JOIN wynik ON arkusz.symbol = wynik.symbol
      WHERE wynik.maturzysta_id = $id";
$res = mysqli_query($conn, $q);

// --- KROK 4: h3 = rok i sesja, p = przedmiot: punkty ---
// [ZOBACZ W README: SEC-4]
while ($row = mysqli_fetch_assoc($res)) {
    echo "<h3>" . $row["rok"] . " " . $row["sesja"] . "</h3>";
    echo "<p>" . $row["przedmiot"] . ": " . $row["punkty"] . "</p>";
}
