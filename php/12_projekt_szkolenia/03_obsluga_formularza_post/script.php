<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — POST, empty(), INSERT uczestnicy, komunikaty
// -----------------------------------------------------------------------------

// --- KROK 1: Tylko metoda POST ---
// [ZOBACZ W README: SEC-1]
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- KROK 2: Czy wszystkie pola są uzupełnione? ---
    // [ZOBACZ W README: SEC-2]
    if (empty($_POST["imie"]) || empty($_POST["nazwisko"]) || empty($_POST["wiek"]) || empty($_POST["kurs"])) {
        echo "<p>Wprowadź wszystkie dane</p>";
    } else {
        $imie = $_POST["imie"];
        $nazwisko = $_POST["nazwisko"];
        $wiek = $_POST["wiek"];

        // --- KROK 3: Wstawienie uczestnika ---
        // [ZOBACZ W README: SEC-3]
        $query = "INSERT INTO uczestnicy (imie, nazwisko, wiek) VALUES ('$imie', '$nazwisko', $wiek);";
        $conn->query($query);

        // --- KROK 4: Komunikat sukcesu ---
        // [ZOBACZ W README: SEC-4]
        echo "<p>Dane uczestnika " . $imie . " " . $nazwisko . " zostały dodane</p>";
    }
}
