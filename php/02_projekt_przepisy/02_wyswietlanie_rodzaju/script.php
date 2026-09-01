<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — rodzaj potrawy (JOIN + jedno fetch_assoc)
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 2 zmodyfikowane o warunek ID ---
// [ZOBACZ W README: SEC-1 oraz SEC-2]
$query = "SELECT potrawy.nazwa, rodzaje.rodzaj
          FROM potrawy
          JOIN rodzaje ON potrawy.idRodzaje = rodzaje.idRodzaje
          WHERE potrawy.idPotrawy = $id;";

// --- KROK 2: Wykonanie zapytania ---
// [ZOBACZ W README: SEC-3]
$result = $conn->query($query);

// --- KROK 3: Jeden wiersz — bez pętli while ---
// [ZOBACZ W README: SEC-3]
$row = $result->fetch_assoc();

// --- KROK 4: Wyświetlenie pola rodzaj ---
// [ZOBACZ W README: SEC-4]
echo "<h1>" . $row["rodzaj"] . "</h1>";
