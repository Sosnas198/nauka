<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — alergeny (JOIN N:M + pętla while)
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 3 zmodyfikowane o warunek ID ---
// [ZOBACZ W README: SEC-1 oraz SEC-2]
$query = "SELECT potrawy.nazwa, alergeny.alergen
          FROM potrawy
          JOIN lista_alergenow ON potrawy.idPotrawy = lista_alergenow.idPotrawy
          JOIN alergeny ON lista_alergenow.idAlergeny = alergeny.idAlergeny
          WHERE potrawy.idPotrawy = $id;";

$result = $conn->query($query);

// --- KROK 2: Wypisanie nazw alergenów oddzielonych spacją ---
// [ZOBACZ W README: SEC-3 oraz SEC-4]
echo "<p>Alergeny: ";
while ($row = $result->fetch_assoc()) {
    echo $row["alergen"] . " ";
}
echo "</p>";
