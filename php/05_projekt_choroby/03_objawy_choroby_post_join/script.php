<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — POST + JOIN choroby_objawy + span ze spacją
// -----------------------------------------------------------------------------

// --- KROK 1: Tylko gdy formularz wysłał dane (przycisk name="sprawdz") ---
// [ZOBACZ W README: SEC-1]
if (isset($_POST["sprawdz"])) {
    $choroba_id = $_POST["choroba"];

    // --- KROK 2: Zapytanie 3 — JOIN przez tabelę łączącą, filtr ID z POST ---
    // [ZOBACZ W README: SEC-2 oraz SEC-3]
    $query = "SELECT o.nazwa
              FROM objawy o
              JOIN choroby_objawy co ON o.id = co.id_objawy
              WHERE co.id_choroby = '$choroba_id';";
    $result = $conn->query($query);

    // --- KROK 3: Każdy objaw w <span> ze spacją po znaczniku ---
    // [ZOBACZ W README: SEC-4]
    while ($row = $result->fetch_assoc()) {
        echo "<span>" . $row["nazwa"] . "</span> ";
    }
}
