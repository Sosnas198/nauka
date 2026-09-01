<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — opona dnia (nr_kat = 9), trzy h2
// -----------------------------------------------------------------------------

// --- KROK 1: Jeden rekord po numerze katalogowym ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT producent, model, sezon, cena FROM opony WHERE nr_kat = 9;";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// --- KROK 2: Nagłówki drugiego stopnia ---
// [ZOBACZ W README: SEC-2]
echo "<h2>" . $row["producent"] . " model " . $row["model"] . "</h2>";
echo "<h2>Sezon: " . $row["sezon"] . "</h2>";
echo "<h2>Cena: " . $row["cena"] . " PLN</h2>";
