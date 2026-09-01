<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — losowe propozycje książek (ORDER BY RAND(), LIMIT)
// -----------------------------------------------------------------------------

// --- KROK 1: Połączenie z bazą danych ---
// [ZOBACZ W README: SEC-1]
$polaczenie = new mysqli("localhost", "root", "", "biblioteka");

// --- KROK 2: Zapytanie 4 — losowanie 5 książek ---
// [ZOBACZ W README: SEC-2]
$sql = "SELECT autor, tytul, kod FROM ksiazki ORDER BY RAND() LIMIT 5";

// --- KROK 3: Wykonanie zapytania i sprawdzenie wyniku ---
// [ZOBACZ W README: SEC-3]
if ($wynik = $polaczenie->query($sql)) {

    // --- KROK 4: Pętla po wynikach i wypisanie wierszy tabeli ---
    // [ZOBACZ W README: SEC-4]
    while ($rekord = $wynik->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($rekord["autor"]) . "</td>";
        echo "<td>" . htmlspecialchars($rekord["tytul"]) . "</td>";
        echo "<td>" . htmlspecialchars($rekord["kod"]) . "</td>";
        echo "</tr>";
    }
    $wynik->free();
}

// --- KROK 5: Zamknięcie połączenia z bazą ---
// [ZOBACZ W README: SEC-5]
$polaczenie->close();
