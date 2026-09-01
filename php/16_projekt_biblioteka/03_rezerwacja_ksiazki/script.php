<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — rezerwacja (przykład: sekcja liryka)
// -----------------------------------------------------------------------------

// --- KROK 1: Tylko ten formularz (buttonliryka + select liryka) ---
// [ZOBACZ W README: SEC-1]
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buttonliryka"], $_POST["liryka"])) {
    $bookId = $_POST["liryka"];

    // --- KROK 2: Zapytanie 5 — tytuł po id ---
    // [ZOBACZ W README: SEC-2]
    $stmt = $mysqli->prepare("SELECT tytul FROM ksiazka WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $stmt->bind_result($title);
    $stmt->fetch();
    $stmt->close();

    // --- KROK 3: Komunikat ---
    // [ZOBACZ W README: SEC-3]
    echo "<p>Książka " . $title . " została zarezerwowana</p>";

    // --- KROK 4: Zapytanie 4 — UPDATE rezerwacja ---
    // [ZOBACZ W README: SEC-4]
    $update = $mysqli->prepare("UPDATE ksiazka SET rezerwacja = 1 WHERE id = ?");
    $update->bind_param("i", $bookId);
    $update->execute();
    $update->close();
}
