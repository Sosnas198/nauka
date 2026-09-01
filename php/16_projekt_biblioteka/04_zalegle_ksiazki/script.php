<?php
// UNIWERSALNY WZORZEC: Skrypt 4 — JOIN zaległych, LIMIT 15, <li> ze spacjami
// -----------------------------------------------------------------------------

// --- KROK 1: Zapytanie 2 ---
// [ZOBACZ W README: SEC-1]
$result = $mysqli->query(
    "SELECT tytul, id_cz, data_odd FROM ksiazka JOIN wypozyczenia ON id = id_ks ORDER BY data_odd LIMIT 15"
);

// --- KROK 2: tytuł, id czytelnika, data — spacje ---
// [ZOBACZ W README: SEC-2]
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["tytul"] . " " . $row["id_cz"] . " " . $row["data_odd"] . "</li>";
}
