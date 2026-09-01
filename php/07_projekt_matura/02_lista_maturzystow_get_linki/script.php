<?php
// UNIWERSALNY WZORZEC: Skrypt 2 — lista linków wynik.php?id&imie&nazwisko
// -----------------------------------------------------------------------------

// --- KROK 1: Maturzyści ze szkoły T3 ---
// [ZOBACZ W README: SEC-1]
$q = "SELECT id, imie, nazwisko FROM maturzysta WHERE szkola = 'T3' ORDER BY nazwisko ASC";
$res = mysqli_query($conn, $q);

// --- KROK 2: Odnośnik z trzema parametrami GET ---
// [ZOBACZ W README: SEC-2, SEC-3 oraz SEC-4]
while ($row = mysqli_fetch_assoc($res)) {
    $id = $row["id"];
    $imie = $row["imie"];
    $nazwisko = $row["nazwisko"];

    echo "<a href='wynik.php?id=" . $id . "&imie=" . $imie . "&nazwisko=" . $nazwisko . "'>";
    echo $id . ". " . $imie . " " . $nazwisko;
    echo "</a><br>";
}
