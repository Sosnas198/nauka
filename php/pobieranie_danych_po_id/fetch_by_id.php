<?php
// UNIWERSALNY WZORZEC: Pobieranie jednego elementu na podstawie ID z URL

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT imie, nazwisko, plik_awatara FROM aktorzy WHERE id_aktora = $id;";
    $result = $conn->query($query);

    // Pobieramy tylko jeden wiersz
    $row = $result->fetch_assoc();

    $imie = $row['imie'];
    $nazwisko = $row['nazwisko'];
    $avatar = $row['plik_awatara'];

    echo "<div>";
    echo "<img src='" . $avatar . "' alt='" . $imie . " " . $nazwisko . "'>";
    echo "<h1>" . $imie . " " . $nazwisko . "</h1>";
    echo "</div>";
}
