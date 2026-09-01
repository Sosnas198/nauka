<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — JOIN USING, RAND(), ilosc * cena
// -----------------------------------------------------------------------------

// --- KROK 1: Jedno losowe zamówienie z modelem i ceną opony ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT id_zam, ilosc, model, cena
          FROM zamowienie
          JOIN opony USING (nr_kat)
          ORDER BY RAND()
          LIMIT 1;";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// --- KROK 2: Wartość = ilość × cena ---
// [ZOBACZ W README: SEC-2]
$wartosc_zamowienia = $row["ilosc"] * $row["cena"];

// --- KROK 3: Dwa nagłówki h2 ---
// [ZOBACZ W README: SEC-3]
echo "<h2>Zamówienie nr " . $row["id_zam"] . ": " . $row["ilosc"] . " sztuki modelu " . $row["model"] . "</h2>";
echo "<h2>Wartość zamówienia: " . $wartosc_zamowienia . " zł</h2>";
