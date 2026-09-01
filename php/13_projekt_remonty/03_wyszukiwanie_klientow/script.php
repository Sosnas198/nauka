<?php
// UNIWERSALNY WZORZEC: Skrypt 3 — miasto + usługa, JOIN, imie - cena
// -----------------------------------------------------------------------------

$queryZlecenia = "SELECT imie, cena
                  FROM klienci
                  JOIN zlecenia USING (id_klienta)
                  WHERE miasto = ? AND rodzaj = ?";

// --- KROK 1: Tylko drugi formularz (miasto i usluga w POST) ---
// [ZOBACZ W README: SEC-1]
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["miasto"], $_POST["usluga"])) {

    // --- KROK 2: Dwa placeholdery tekstowe ---
    // [ZOBACZ W README: SEC-2 oraz SEC-3]
    $stmt = $conn->prepare($queryZlecenia);
    $stmt->bind_param("ss", $_POST["miasto"], $_POST["usluga"]);
    $stmt->execute();
    $resultZlecenia = $stmt->get_result();

    // --- KROK 3: Lista z myślnikiem ---
    // [ZOBACZ W README: SEC-4]
    echo "<ul>";
    while ($row = $resultZlecenia->fetch_assoc()) {
        echo "<li>" . $row["imie"] . " - " . $row["cena"] . "</li>";
    }
    echo "</ul>";

    $stmt->close();
}
