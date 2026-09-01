<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — LEFT JOIN, osoby bez wiersza w rejestr
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie — personel bez zgłoszenia ---
// [ZOBACZ W README: SEC-1 oraz SEC-2]
$zapytanieBrakZgloszenia = "SELECT personel.id, personel.nazwisko
                            FROM personel
                            LEFT JOIN rejestr ON personel.id = rejestr.id_personel
                            WHERE id_personel IS NULL";
$wynikBrakZgloszenia = mysqli_query($conn, $zapytanieBrakZgloszenia);

// --- KROK 2: Lista numerowana ---
// [ZOBACZ W README: SEC-3]
echo "<ol>";
while ($wiersz = mysqli_fetch_assoc($wynikBrakZgloszenia)) {
    echo "<li>" . $wiersz["id"] . " " . $wiersz["nazwisko"] . "</li>";
}
echo "</ol>";
