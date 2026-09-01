<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — wykonawcy z liczbą pracowników >= POST
// -----------------------------------------------------------------------------

$query = "SELECT nazwa_firmy, liczba_pracownikow FROM wykonawcy WHERE liczba_pracownikow >= ?";

// --- KROK 1: Tylko POST z wypełnionym polem pracownikow ---
// [ZOBACZ W README: SEC-2]
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pracownikow"]) && $_POST["pracownikow"] !== "") {

    // --- KROK 2: Prepared statement, parametr całkowity ---
    // [ZOBACZ W README: SEC-3 oraz SEC-4]
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_POST["pracownikow"]);
    $stmt->execute();
    $result = $stmt->get_result();

    // --- KROK 3: Lista firm ---
    // [ZOBACZ W README: SEC-5]
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["nazwa_firmy"] . ", " . $row["liczba_pracownikow"] . " pracowników</li>";
    }
    echo "</ul>";

    $stmt->close();
}
