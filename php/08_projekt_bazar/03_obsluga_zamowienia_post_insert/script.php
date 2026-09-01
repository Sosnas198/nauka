<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — POST, cena * waga, INSERT zamowienie
// -----------------------------------------------------------------------------

// --- KROK 1: Tylko po wysłaniu formularza ---
// [ZOBACZ W README: SEC-1]
if (isset($_POST["waga"], $_POST["id"])) {
    $id = $_POST["id"];
    $waga = $_POST["waga"];

    // --- KROK 2: Cena, nazwa i rodzaj wybranego towaru ---
    // [ZOBACZ W README: SEC-2]
    $query = "SELECT nazwa, rodzaj, cena FROM towar WHERE id = $id;";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    // --- KROK 3: Wartość = cena * waga oraz komunikat ---
    // [ZOBACZ W README: SEC-3]
    $wartosc = $row["cena"] * $waga;
    echo "<p>" . $row["rodzaj"] . " " . $row["nazwa"] . " " . $wartosc . " zł</p>";

    // --- KROK 4: Zapis zamówienia ---
    // [ZOBACZ W README: SEC-4]
    $insertQuery = "INSERT INTO zamowienie VALUES (NULL, $id, 2, $waga);";
    mysqli_query($conn, $insertQuery);
}
