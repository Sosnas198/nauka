<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — GET + JOIN opis + karta szczytu
// -----------------------------------------------------------------------------

// --- KROK 1: Czy w adresie jest id z index.php? ---
// [ZOBACZ W README: SEC-1]
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // --- KROK 2: Zapytanie 3 z JOIN i filtrem ID ---
    // [ZOBACZ W README: SEC-2]
    $query = "SELECT szczyty.plik, szczyty.nazwa, szczyty.wysokosc, szczyty.pasmo, opis.opis
              FROM szczyty
              JOIN opis ON szczyty.id = opis.szczyty_id
              WHERE szczyty.id = $id;";
    $result = $conn->query($query);

    // --- KROK 3: Jeden wiersz — bez pętli while ---
    // [ZOBACZ W README: SEC-3]
    $row = $result->fetch_assoc();

    // --- KROK 4: Obraz.duze, h2, wysokość, pasmo, opis ---
    // [ZOBACZ W README: SEC-4]
    echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='duze'>";
    echo "<h2>" . $row['nazwa'] . "</h2>";
    echo "<p>Wysokość: " . $row['wysokosc'] . " m n.p.m.</p>";
    echo "<p>Pasmo górskie: " . $row['pasmo'] . "</p>";
    echo "<p>" . $row['opis'] . "</p>";
}
