<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — POST baza, tabela smoków z danego kraju
// -----------------------------------------------------------------------------

// --- KROK 1: Tylko po wysłaniu formularza ---
// [ZOBACZ W README: SEC-1]
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["baza"])) {
    $pochodzenie = $_POST["baza"];

    // --- KROK 2: Filtr prepared statement ---
    // [ZOBACZ W README: SEC-2 oraz SEC-3]
    $stmt = $conn->prepare("SELECT nazwa, dlugosc, szerokosc FROM smok WHERE pochodzenie = ?");
    $stmt->bind_param("s", $pochodzenie);
    $stmt->execute();
    $result = $stmt->get_result();

    // --- KROK 3: Wiersze tabeli ---
    // [ZOBACZ W README: SEC-4]
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nazwa"] . "</td>";
        echo "<td>" . $row["dlugosc"] . "</td>";
        echo "<td>" . $row["szerokosc"] . "</td>";
        echo "</tr>";
    }

    $stmt->close();
}
