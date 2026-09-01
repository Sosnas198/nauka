<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — cztery bloki statystyk (DISTINCT, MIN/MAX, AVG)
// -----------------------------------------------------------------------------

echo "<div class='blok'>";
echo "<h4>Przedmioty</h4>";
// --- KROK 1: Unikalne przedmioty, nazwy ze spacją ---
// [ZOBACZ W README: SEC-2]
$qPrzedmioty = "SELECT DISTINCT przedmiot FROM arkusz";
$resPrzedmioty = mysqli_query($conn, $qPrzedmioty);
while ($row = mysqli_fetch_assoc($resPrzedmioty)) {
    echo $row["przedmiot"] . " ";
}
echo "</div>";

echo "<div class='blok'>";
echo "<h4>Lata</h4>";
// --- KROK 2: MIN i MAX roku, myślnik ---
// [ZOBACZ W README: SEC-3]
$qLata = "SELECT MIN(rok) AS min_rok, MAX(rok) AS max_rok FROM arkusz";
$resLata = mysqli_query($conn, $qLata);
$rowLata = mysqli_fetch_assoc($resLata);
echo $rowLata["min_rok"] . " - " . $rowLata["max_rok"];
echo "</div>";

echo "<div class='blok'>";
echo "<h4>Najlepszy wynik</h4>";
// --- KROK 3: Najwyższa średnia (GROUP BY, DESC, LIMIT 1) ---
// [ZOBACZ W README: SEC-4]
$qMax = "SELECT maturzysta_id, AVG(punkty) AS Wynik
         FROM wynik
         GROUP BY maturzysta_id
         ORDER BY Wynik DESC
         LIMIT 1";
$resMax = mysqli_query($conn, $qMax);
$rowMax = mysqli_fetch_assoc($resMax);
echo round($rowMax["Wynik"], 2) . "%";
echo "</div>";

echo "<div class='blok'>";
echo "<h4>Najgorszy wynik</h4>";
// --- KROK 4: Najniższa średnia (ASC LIMIT 1) ---
// [ZOBACZ W README: SEC-5]
$qMin = "SELECT maturzysta_id, AVG(punkty) AS Wynik
         FROM wynik
         GROUP BY maturzysta_id
         ORDER BY Wynik ASC
         LIMIT 1";
$resMin = mysqli_query($conn, $qMin);
$rowMin = mysqli_fetch_assoc($resMin);
echo round($rowMin["Wynik"], 2) . "%";
echo "</div>";
