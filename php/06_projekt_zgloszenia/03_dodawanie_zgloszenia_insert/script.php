<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — INSERT na początku pliku (CURDATE + id z number)
// -----------------------------------------------------------------------------

// --- KROK 1: Tylko po wysłaniu formularza „Dodaj zgłoszenie” ---
// [ZOBACZ W README: SEC-1 oraz SEC-2]
if (isset($_POST["dodaj_zgloszenie"]) && isset($_POST["osoba_id"])) {

    // --- KROK 2: Id personelu z input type="number" ---
    // [ZOBACZ W README: SEC-3]
    $idPersonelu = $_POST["osoba_id"];

    // --- KROK 3: INSERT — NULL (AI), CURDATE(), id, stała 14 ---
    // [ZOBACZ W README: SEC-4]
    $zapytanieDodaj = "INSERT INTO rejestr VALUES (NULL, CURDATE(), $idPersonelu, 14)";
    mysqli_query($conn, $zapytanieDodaj);
}
