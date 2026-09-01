<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — POST, cena miejsca, koszt dorosłych i dzieci
// -----------------------------------------------------------------------------

// --- KROK 1: Wszystkie pola formularza w POST ---
// [ZOBACZ W README: SEC-1]
if ($_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["miejsce"], $_POST["dorosli"], $_POST["dzieci"], $_POST["termin"])) {

    $miejsce = $_POST["miejsce"];
    $dorosli = $_POST["dorosli"];
    $dzieci = $_POST["dzieci"];
    $termin = $_POST["termin"];

    // --- KROK 2: Cena po nazwie miejsca ---
    // [ZOBACZ W README: SEC-2]
    $stmt = $conn->prepare("SELECT cena FROM miejsca WHERE nazwa = ?");
    $stmt->bind_param("s", $miejsce);
    $stmt->execute();
    $stmt->bind_result($cena);

    if ($stmt->fetch()) {
        // --- KROK 3: Dzieci płacą połowę ---
        // [ZOBACZ W README: SEC-3]
        $koszt = ($cena * $dorosli) + ($cena * 0.5 * $dzieci);

        // --- KROK 4: Termin i kwota ---
        // [ZOBACZ W README: SEC-4]
        echo "<p>W dniu: " . $termin . "</p>";
        echo "<p>" . $koszt . " złotych</p>";
    }

    $stmt->close();
}
