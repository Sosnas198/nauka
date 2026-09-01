<?php
// UNIWERSALNY WZORZEC: Skrypt 1 — radio / domyślny Policjant / h3 / tabela
// -----------------------------------------------------------------------------

// --- KROK 1: Domyślna opcja, potem nadpisanie z POST ---
// [ZOBACZ W README: SEC-2 oraz SEC-3]
$wybranaOpcja = "Policjant";
if (isset($_POST["personel"])) {
    $wybranaOpcja = $_POST["personel"];
}

$statusPersonelu = strtolower($wybranaOpcja);

// --- KROK 2: Nagłówek trzeciego stopnia przed tabelą ---
// [ZOBACZ W README: SEC-3]
echo "<h3>Wybrano opcję: " . $wybranaOpcja . "</h3>";

// --- KROK 3: Zapytanie ze zmienną statusu ---
// [ZOBACZ W README: SEC-4]
$zapytaniePersonel = "SELECT id, imie, nazwisko FROM personel WHERE status = '$statusPersonelu'";
$wynikPersonel = mysqli_query($conn, $zapytaniePersonel);

// --- KROK 4: Wiersze tabeli ---
// [ZOBACZ W README: SEC-5]
while ($wiersz = mysqli_fetch_assoc($wynikPersonel)) {
    echo "<tr>";
    echo "<td>" . $wiersz["id"] . "</td>";
    echo "<td>" . $wiersz["imie"] . "</td>";
    echo "<td>" . $wiersz["nazwisko"] . "</td>";
    echo "</tr>";
}
