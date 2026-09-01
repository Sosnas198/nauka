<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — JOIN cech dla id = 1, 2 i 3
// -----------------------------------------------------------------------------

// --- KROK 1: Pakiet id = 1 (Standardowy) ---
// [ZOBACZ W README: SEC-2 oraz SEC-3]
$query = "SELECT nazwa, cecha
          FROM abonamenty
          JOIN szczegolyabonamentu ON abonamenty.id = Abonamenty_id
          JOIN cechy ON cechy.id = Cechy_id
          WHERE abonamenty.id = 1;";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["cecha"] . "</li>";
}

// --- KROK 2: To samo zapytanie dla id = 2 (Premium) i id = 3 (Dziecko) ---
// [ZOBACZ W README: SEC-3 oraz SEC-4]
// W index.php każdy blok stoi w osobnym <ul> (sekcje #pierwszy, #drugi, #trzeci).
