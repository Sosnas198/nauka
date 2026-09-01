<?php
// UNIWERSALNY WZORZEC: Skrypt 4 — pole przepis + zmienna $plik do tła sekcji
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 4 zmodyfikowane o warunek ID ---
// [ZOBACZ W README: SEC-1]
$query = "SELECT przepis, plik FROM potrawy WHERE idPotrawy = $id;";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// --- KROK 2: Zapisanie nazwy pliku tła (użycie w <section style="...">) ---
// [ZOBACZ W README: SEC-3 oraz SEC-4]
$plik = $row["plik"];

// --- KROK 3: Wyświetlenie pola przepis ---
// [ZOBACZ W README: SEC-2]
echo "<p>" . $row["przepis"] . "</p>";
