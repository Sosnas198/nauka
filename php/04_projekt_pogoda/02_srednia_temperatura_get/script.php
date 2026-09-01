<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — GET month + AVG/ROUND + „X stopni”
// -----------------------------------------------------------------------------

// --- KROK 1: Skrypt tylko gdy kliknięto odnośnik (parametr month) ---
// [ZOBACZ W README: SEC-1]
if (isset($_GET["month"])) {
    $month = $_GET["month"];

    // --- KROK 2: Średnia w SQL, zaokrąglenie do 2 miejsc, filtr miesiąca ---
    // [ZOBACZ W README: SEC-2]
    $query = "SELECT ROUND(AVG(temperatura), 2) AS srednia
              FROM pomiary
              WHERE id_miesiac = $month;";
    $result = $conn->query($query);

    // --- KROK 3: Jeden wiersz agregacji ---
    // [ZOBACZ W README: SEC-3]
    $row = $result->fetch_assoc();

    // --- KROK 4: Forma z arkusza: „<wartość> stopni” ---
    // [ZOBACZ W README: SEC-4]
    echo "<p>" . $row["srednia"] . " stopni</p>";
}
